<?php

if(isset($_GET['fechaDesde'], $_GET['fechaHasta'])){

    try{

        require '../conection.php';
        
        $dateDesde = new DateTime($_GET['fechaDesde']);
        $dateHasta = new DateTime($_GET['fechaHasta']);

        $maxDiaMeses = array("31","28","31","30","31","30","31","31","30","31","30","31");
        $mesEspanol = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        // Obtener los códigos y nombres de usuarios
        $stat = $conn->prepare('select distinct `ID de usuario` as id, nombre from control_llegadas 
        where nombre is not null and nombre <> "" order by nombre');
        $stat->execute();
        $usuarios = $stat->fetchAll(PDO::FETCH_ASSOC);
        // $usuarios contiene los id y nombres de cada usuario

        $meses = range($dateDesde->format('m'), $dateHasta->format('m'));
        $users = []; // Arreglo multidimensional que contedrá todos los días que marcaron
        $diff = []; // Arreglo multidimensional que contendrá los días que no marcaron

        // ========================
        // Creando archivo de excel
        // ========================

        require '../PHPExcel.php';
        
        $archivo = new PHPExcel();
        $archivo->getProperties()
            ->setCreator('Credito Solidario')
            ->setTitle('Reporte No Marcadas');

        foreach($meses as $mes){

            // Preparamos el query para obtener las fechas de cada usuario
            $stat = $conn->prepare('select date_format(`Fecha/Hora`, "%Y-%m-%d") as fecha from control_llegadas 
            where `ID de usuario` = :id and time(`Fecha/Hora`) between "06:00:00" and "18:59:00" 
            and `Fecha/Hora` between "'.date("Y-m-d", strtotime($_GET['fechaDesde'])).'" and "'.date("Y-m-d", strtotime($_GET['fechaHasta'])).'" 
            and month(`Fecha/Hora`) = :mes and weekday(`Fecha/Hora`) < 6'); // aqui sumar un dia a la fecha
            $stat->bindValue(':mes', $mes, PDO::PARAM_STR); // Enviar el mes actual

            // ====================================================================================================
            // Recorremos los ids de cada usuario para capturar las fechas y agregarlas a un array multidimensional
            // ====================================================================================================
            foreach($usuarios as $usuario){
                
                $stat->bindValue(':id', $usuario['id'], PDO::PARAM_INT);
                $stat->execute();
                $data = $stat->fetchAll();
                
                $fechas = [];
                
                foreach($data as $fecha){
                    array_push($fechas, $fecha['fecha']);
                }
                
                //$fechas['cantidad'] = sizeof($data);
                
                $users[$usuario['id']][$mes] = $fechas;
                
            }
            // Hasta acá tenemos todas las fechas marcadas de cada usuario en el array $users 

            // =======================================================
            // Para generar el arreglo de todas las fechas en el rango
            // =======================================================

            $fechastodas = [];

            if(count($meses) > 1){ // Si son más de un més jugamos con la fecha

                if($mes == $dateDesde->format('m')){
                    $inicial = new DateTime($_GET['fechaDesde']);
                    $final = new DateTime($dateDesde->format('Y').'-'.$dateDesde->format('m').'-'.$maxDiaMeses[$mes-1]);
                }
    
                if($mes == $dateHasta->format('m')){
                    $inicial = new DateTime($dateHasta->format('Y').'-'.$dateHasta->format('m').'-01');
                    $final = new DateTime($_GET['fechaHasta']);
                    
                }

                if(($dateDesde->format('m')) < $mes && $mes < ($dateHasta->format('m'))){
                    $inicial = $inicial = new DateTime($dateDesde->format('Y').'-'.$mes.'-01');
                    $final = new DateTime($dateHasta->format('Y').'-'.$mes.'-'.$maxDiaMeses[$mes-1]);
                }
                
            }else{ // Sino las dejamos como están
                
                $inicial = new DateTime($_GET['fechaDesde']);
                $final = new DateTime($_GET['fechaHasta']. ' + 1 days ');
                
            }
            
            $maxColumna = ($final->format('d') - $inicial->format('d'))+2;
            $final->add(new DateInterval('P1D'));
            
            $rangoFechas = new DatePeriod(
                $inicial,
                new DateInterval('P1D'),
                $final
            );

            $domingos = 0;

            foreach($rangoFechas as $fechactual){
                
                if($fechactual->format('w') != "7"){
                    $fechastodas[] = $fechactual->format('Y-m-d');
                }else{
                    $domingos++;
                }
                
            }

            $maxColumna -= $domingos;
            // hasta acá listo el arreglo de todas las fechas en el rango

            // =======================================
            // Ahora calcular los días que no se marcó
            // =======================================

            foreach($users as $user => $array){
                $diff[$user][$mes] = array_values(array_diff($fechastodas, $array[$mes])); // En $diff están todos los días no marcados de cada usuario
            }

            // =========================
            // Generando la hoja actual
            // =========================

            if($mes != $dateDesde->format('m')){
                $sheetId = $archivo->getSheetCount();
                $archivo->createSheet($sheetId);
                $archivo->setActiveSheetIndex($sheetId);
            }
            $hojaActiva = $archivo->getActiveSheet();
            $archivo->getActiveSheet()->setTitle($mesEspanol[$inicial->format('m')-1]); // Colocando nombre a la hoja activa

            $i=3;
            foreach($usuarios as $empleado){
                
                $hojaActiva
                ->setCellValueByColumnAndRow(1, $i, $empleado['nombre']);
                
                $j=2;
                foreach($diff[$empleado['id']][$mes] as $fecha){
                    
                    $fechaActual = new DateTime($fecha);
                    $hojaActiva
                    ->setCellValueByColumnAndRow($j, $i, $fechaActual->format('d'));
                    $j++;
                    
                }
                
                $i++;
                
            }

            // ===================
            // Estilizando la hoja
            // ===================

            $arregloLetras = createColumnsArray('BZ');
            
            foreach($arregloLetras as $letter){
                $archivo->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
            }

            $final->sub(new DateInterval('P1D'));
            $archivo->getActiveSheet()->mergeCells('C2:'.$arregloLetras[$maxColumna].'2');
            $archivo->getActiveSheet()->setCellValue('C2','No marcadas del '.$inicial->format('Y-m-d').' al '.$final->format('Y-m-d'));

            $style = array(
                'font' => array(
                    'color' => array('rgb' => 'ffffff')
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '000040')
                )
            );

            $centerStyle = array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            );

            $bordeGruesoStyle = array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM                    
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM                    
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM                    
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM                    
                )
            );

            $archivo->getActiveSheet()->getStyle('C2')->applyFromArray($style);
            $archivo->getActiveSheet()->getStyle('C2')->getAlignment()->applyFromArray($centerStyle);
            $archivo->getActiveSheet()->getStyle('B3:B'.(count($usuarios)+2))->applyFromArray($style);
            $archivo->getActiveSheet()->getStyle('C2:'.$arregloLetras[$maxColumna].(count($usuarios)+2))->getBorders()->applyFromArray($bordeGruesoStyle);
            $archivo->getActiveSheet()->getStyle('B3:B'.(count($usuarios)+2))->getBorders()->applyFromArray($bordeGruesoStyle);
            
        }
        
        // ==================
        // Generando el excel
        // ==================

        $nombre_archivo = 'ENTRADAS_NO_MARCADAS';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($archivo, 'Excel2007');
        $objWriter->save('php://output');
        
    }catch(PDOException $e){
        
        echo $e->getMessage();
        
    }

}

function createColumnsArray($end_column, $first_letters = ''){
    $columns = array();
    $length = strlen($end_column);
    $letters = range('A', 'Z');

    // Iterate over 26 letters.
    foreach ($letters as $letter) {
        // Paste the $first_letters before the next.
        $column = $first_letters . $letter;

        // Add the column to the final array.
        $columns[] = $column;

        // If it was the end column that was added, return the columns.
        if ($column == $end_column)
            return $columns;
    }

    // Add the column children.
    foreach ($columns as $column) {
        // Don't itterate if the $end_column was already set in a previous itteration.
        // Stop iterating if you've reached the maximum character length.
        if (!in_array($end_column, $columns) && strlen($column) < $length) {
            $new_columns = createColumnsArray($end_column, $column);
            // Merge the new columns which were created with the final columns array.
            $columns = array_merge($columns, $new_columns);
        }
    }

    return $columns;
}

?>