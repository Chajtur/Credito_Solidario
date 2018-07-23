<?php

require 'PHPExcel.php';

if(isset($_POST['select_ifi']) && isset($_POST['date_desde']) && isset($_POST['date_hasta']) && isset($_POST['select_formato'])){
    
    require_once 'conection.php';
    
    $ifi = $_POST['select_ifi'];
    $desde = $_POST['date_desde'];
    $hasta = $_POST['date_hasta'];
    $formato = $_POST['select_formato'];
    
    $nombre_ifi = '';
    
    try {
        
        $sql = 'CALL desembolso_resumido("'.$desde.'","'.$hasta.'","'.$ifi.'")';
        $statement = $conn->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $archivo = new PHPExcel();

        $archivo->getProperties()->setCreator("Ricardo Valladares")
                                     ->setLastModifiedBy("Ricardo Valladares")
                                     ->setTitle("Archivo de prueba")
                                     ->setSubject("Subject prueba")
                                     ->setDescription("Descripción de prueba")
                                     ->setKeywords("office PHPExcel php")
                                     ->setCategory("Test result file");

        $archivo->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow('0', '1', 'Fecha')
            ->setCellValueByColumnAndRow('1', '1', 'Monto')
            ->setCellValueByColumnAndRow('2', '1', 'Cantidad');
        
        $i = 2;
        foreach($rows as $fila){
            
            $archivo->getActiveSheet()
                ->setCellValueByColumnAndRow('0', $i, $fila['Fecha_Desembolso'])
                ->setCellValueByColumnAndRow('1', $i, $fila['Monto'])
                ->setCellValueByColumnAndRow('2', $i, $fila['Cantidad']);
            $i++;

        }
        
        $archivo->getActiveSheet()->setTitle('RESUMEN');
        
        switch($ifi){
                
            case 1:
                $nuevaHoja = new PHPExcel_Worksheet($archivo, 'COMPLETO');
                $archivo->addSheet($nuevaHoja, 1);
                
                $sql = 'CALL desembolsos_bantrab_completo("'.$desde.'", "'.$hasta.'")';
                $statement = $conn->prepare($sql);
                $statement->execute();
                $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                $archivo->setActiveSheetIndex(1)
                    ->setCellValueByColumnAndRow('0', '1', 'Departamento')
                    ->setCellValueByColumnAndRow('1', '1', 'Municipio')
                    ->setCellValueByColumnAndRow('2', '1', 'Nombre_Completo')
                    ->setCellValueByColumnAndRow('3', '1', 'Identidad')
                    ->setCellValueByColumnAndRow('4', '1', 'Grupo_Solidario')
                    ->setCellValueByColumnAndRow('5', '1', 'Actividad_Economica')
                    ->setCellValueByColumnAndRow('6', '1', 'Direccion')
                    ->setCellValueByColumnAndRow('7', '1', 'Monto_Desembolsado')
                    ->setCellValueByColumnAndRow('8', '1', 'Fecha_Desembolso')
                    ->setCellValueByColumnAndRow('9', '1', 'fecha_ultimo_pago')
                    ->setCellValueByColumnAndRow('10', '1', 'Gestor')
                    ->setCellValueByColumnAndRow('11', '1', 'Supervisor')
                    ->setCellValueByColumnAndRow('12', '1', 'Ciclo')
                    ->setCellValueByColumnAndRow('13', '1', 'saldo_anterior')
                    ->setCellValueByColumnAndRow('14', '1', 'cuotas_vencidas')
                    ->setCellValueByColumnAndRow('15', '1', 'interes_mora')
                    ->setCellValueByColumnAndRow('16', '1', 'interes_pagado')
                    ->setCellValueByColumnAndRow('17', '1', 'Numero_Prestamo')
                    ->setCellValueByColumnAndRow('18', '1', 'Ifi')
                    ->setCellValueByColumnAndRow('19', '1', 'fondo');
                
                $i = 2;
                foreach($rows as $fila){

                    $archivo->getActiveSheet()
                        ->setCellValueByColumnAndRow('0', $i, $fila['Departamento'])
                        ->setCellValueByColumnAndRow('1', $i, $fila['Municipio'])
                        ->setCellValueByColumnAndRow('2', $i, $fila['Nombre_Completo'])
                        ->setCellValueByColumnAndRow('3', $i, $fila['Identidad'])
                        ->setCellValueByColumnAndRow('4', $i, $fila['Grupo_Solidario'])
                        ->setCellValueByColumnAndRow('5', $i, $fila['Actividad_Economica'])
                        ->setCellValueByColumnAndRow('6', $i, $fila['Direccion'])
                        ->setCellValueByColumnAndRow('7', $i, $fila['Monto_Desembolsado'])
                        ->setCellValueByColumnAndRow('8', $i, $fila['Fecha_Desembolso'])
                        ->setCellValueByColumnAndRow('9', $i, $fila['fecha_ultimo_pago'])
                        ->setCellValueByColumnAndRow('10', $i, $fila['Gestor'])
                        ->setCellValueByColumnAndRow('11', $i, $fila['Supervisor'])
                        ->setCellValueByColumnAndRow('12', $i, $fila['Ciclo'])
                        ->setCellValueByColumnAndRow('13', $i, $fila['saldo_anterior'])
                        ->setCellValueByColumnAndRow('14', $i, $fila['cuotas_vencidas'])
                        ->setCellValueByColumnAndRow('15', $i, $fila['interes_mora'])
                        ->setCellValueByColumnAndRow('16', $i, $fila['interes_pagado'])
                        ->setCellValueByColumnAndRow('17', $i, $fila['Numero_Prestamo'])
                        ->setCellValueByColumnAndRow('18', $i, $fila['IFI'])
                        ->setCellValueByColumnAndRow('19', $i, $fila['fondo']);
                    $i++;

                }
                
                $nombre_ifi = 'BANTRAB';
                break;
                
            //end case
                
            case 2:
                $nuevaHoja = new PHPExcel_Worksheet($archivo, 'COMPLETO');
                $archivo->addSheet($nuevaHoja, 1);
                
                $sql = 'CALL desembolsos_banrural_completo("'.$desde.'", "'.$hasta.'")';
                $statement = $conn->prepare($sql);
                $statement->execute();
                $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                $archivo->setActiveSheetIndex(1)
                    ->setCellValueByColumnAndRow('0', '1', 'Departamento')
                    ->setCellValueByColumnAndRow('1', '1', 'Municipio')
                    ->setCellValueByColumnAndRow('2', '1', 'Nombre_Completo')
                    ->setCellValueByColumnAndRow('3', '1', 'Identidad')
                    ->setCellValueByColumnAndRow('4', '1', 'Telefono')
                    ->setCellValueByColumnAndRow('5', '1', 'Grupo_Solidario')
                    ->setCellValueByColumnAndRow('6', '1', 'Gestor')
                    ->setCellValueByColumnAndRow('7', '1', 'Monto_Desembolsado')
                    ->setCellValueByColumnAndRow('8', '1', 'Actividad_Economica')
                    ->setCellValueByColumnAndRow('9', '1', 'Estado_Credito')
                    ->setCellValueByColumnAndRow('10', '1', 'Direccion')
                    ->setCellValueByColumnAndRow('11', '1', 'Fecha_Desembolso')
                    ->setCellValueByColumnAndRow('12', '1', 'fecha_ultimo_pago')
                    ->setCellValueByColumnAndRow('13', '1', 'Supervisor')
                    ->setCellValueByColumnAndRow('14', '1', 'Ciclo')
                    ->setCellValueByColumnAndRow('15', '1', 'saldo_capital')
                    ->setCellValueByColumnAndRow('16', '1', 'cuotas_vencidas')
                    ->setCellValueByColumnAndRow('17', '1', 'interes_pagado')
                    ->setCellValueByColumnAndRow('18', '1', 'Numero_Prestamo')
                    ->setCellValueByColumnAndRow('19', '1', 'Ifi')
                    ->setCellValueByColumnAndRow('20', '1', 'fondo');
                
                $i = 2;
                foreach($rows as $fila){

                    $archivo->getActiveSheet()
                        ->setCellValueByColumnAndRow('0', $i, $fila['Departamento'])
                        ->setCellValueByColumnAndRow('1', $i, $fila['Municipio'])
                        ->setCellValueByColumnAndRow('2', $i, $fila['Nombre_Completo'])
                        ->setCellValueByColumnAndRow('3', $i, $fila['Identidad'])
                        ->setCellValueByColumnAndRow('4', $i, $fila['Telefono'])
                        ->setCellValueByColumnAndRow('5', $i, $fila['Grupo_Solidario'])
                        ->setCellValueByColumnAndRow('6', $i, $fila['Gestor'])
                        ->setCellValueByColumnAndRow('7', $i, $fila['Monto_Desembolsado'])
                        ->setCellValueByColumnAndRow('8', $i, $fila['Actividad_Economica'])
                        ->setCellValueByColumnAndRow('9', $i, $fila['Estado_Credito'])
                        ->setCellValueByColumnAndRow('10', $i, $fila['Direccion'])
                        ->setCellValueByColumnAndRow('11', $i, $fila['Fecha_Desembolso'])
                        ->setCellValueByColumnAndRow('12', $i, $fila['fecha_ultimo_pago'])
                        ->setCellValueByColumnAndRow('13', $i, $fila['Supervisor'])
                        ->setCellValueByColumnAndRow('14', $i, $fila['Ciclo'])
                        ->setCellValueByColumnAndRow('15', $i, $fila['saldo_capital'])
                        ->setCellValueByColumnAndRow('16', $i, $fila['cuotas_vencidas'])
                        ->setCellValueByColumnAndRow('17', $i, $fila['interes_pagado'])
                        ->setCellValueByColumnAndRow('18', $i, $fila['Numero_Prestamo'])
                        ->setCellValueByColumnAndRow('19', $i, $fila['Ifi'])
                        ->setCellValueByColumnAndRow('20', $i, $fila['fondo']);
                    $i++;

                }
                
                $nombre_ifi = 'BANRURAL';
                break;
                
            //end case
                
            case 3:
                $nuevaHoja = new PHPExcel_Worksheet($archivo, 'COMPLETO');
                $archivo->addSheet($nuevaHoja, 1);
                
                $sql = 'CALL desembolsos_chorotega_completo("'.$desde.'", "'.$hasta.'")';
                $statement = $conn->prepare($sql);
                $statement->execute();
                $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                $archivo->setActiveSheetIndex(1)
                    ->setCellValueByColumnAndRow('0', '1', 'Departamento')
                    ->setCellValueByColumnAndRow('1', '1', 'Nombre_Agencia')
                    ->setCellValueByColumnAndRow('2', '1', 'Nombre_Afiliado')
                    ->setCellValueByColumnAndRow('3', '1', 'Numero_Identificacion')
                    ->setCellValueByColumnAndRow('4', '1', 'Numero_Prestamo')
                    ->setCellValueByColumnAndRow('5', '1', 'Monto')
                    ->setCellValueByColumnAndRow('6', '1', 'Fecha')
                    ->setCellValueByColumnAndRow('7', '1', 'IFI')
                    ->setCellValueByColumnAndRow('8', '1', 'fondo');
                
                $i = 2;
                foreach($rows as $fila){

                    $archivo->getActiveSheet()
                        ->setCellValueByColumnAndRow('0', $i, $fila['Departamento'])
                        ->setCellValueByColumnAndRow('1', $i, $fila['Nombre_Agencia'])
                        ->setCellValueByColumnAndRow('2', $i, $fila['Nombre_Afiliado'])
                        ->setCellValueByColumnAndRow('3', $i, $fila['Numero_Identificacion'])
                        ->setCellValueByColumnAndRow('4', $i, $fila['Numero_Prestamo'])
                        ->setCellValueByColumnAndRow('5', $i, $fila['Monto'])
                        ->setCellValueByColumnAndRow('6', $i, $fila['Fecha'])
                        ->setCellValueByColumnAndRow('7', $i, $fila['IFI'])
                        ->setCellValueByColumnAndRow('8', $i, $fila['fondo']);
                    $i++;

                }
                
                $nombre_ifi = 'CHOROTEGA';
                break;
                
            //end case   
                
            default:
                
                $nuevaHoja = new PHPExcel_Worksheet($archivo, 'COMPLETO');
                $archivo->addSheet($nuevaHoja, 1);
                
                $sql = 'CALL desembolsos_completo("'.$desde.'", "'.$hasta.'", "'.$ifi.'")';
                $statement = $conn->prepare($sql);
                $statement->execute();
                $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                $archivo->setActiveSheetIndex(1)
                    ->setCellValueByColumnAndRow('0', '1', 'Departamento')
                    ->setCellValueByColumnAndRow('2', '1', 'Nombre_Afiliado')
                    ->setCellValueByColumnAndRow('3', '1', 'Numero_Identificacion')
                    ->setCellValueByColumnAndRow('4', '1', 'Numero_Prestamo')
                    ->setCellValueByColumnAndRow('5', '1', 'Monto')
                    ->setCellValueByColumnAndRow('6', '1', 'Fecha')
                    ->setCellValueByColumnAndRow('7', '1', 'IFI')
                    ->setCellValueByColumnAndRow('8', '1', 'fondo');
                
                $i = 2;
                foreach($rows as $fila){

                    $archivo->getActiveSheet()
                        ->setCellValueByColumnAndRow('0', $i, $fila['Departamento'])
                        ->setCellValueByColumnAndRow('2', $i, $fila['Nombre_Afiliado'])
                        ->setCellValueByColumnAndRow('3', $i, $fila['Numero_Identificacion'])
                        ->setCellValueByColumnAndRow('4', $i, $fila['Numero_Prestamo'])
                        ->setCellValueByColumnAndRow('5', $i, $fila['Monto'])
                        ->setCellValueByColumnAndRow('6', $i, $fila['Fecha'])
                        ->setCellValueByColumnAndRow('7', $i, $fila['IFI'])
                        ->setCellValueByColumnAndRow('8', $i, $fila['fondo']);
                    $i++;

                }
                
                switch($ifi){
                    case 4:
                        $nombre_ifi = 'CATACAMAS';
                        break;
                    case 8:
                        $nombre_ifi = 'BANADESA';
                        break;
                }
                
                break;
                
            //end case
            
        }
        
        //Definir estilo
        $archivo->setActiveSheetIndex(0)->getStyle('A1:C1')->getFont()->setBold(true);
        $archivo->getActiveSheet()->getStyle('A1:C1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('263238');
        $archivo->getActiveSheet()->getStyle('A1:C1')->getFont()->getColor()->setRGB('FFFFFF');
        $archivo->setActiveSheetIndex(1)->getStyle('A1:Z1')->getFont()->setBold(true);
        $archivo->getActiveSheet()->getStyle('A1:Z1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('263238');
        $archivo->getActiveSheet()->getStyle('A1:Z1')->getFont()->getColor()->setRGB('FFFFFF');
        $archivo->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('0000000000000');
        
        $nombre_archivo = 'DESEMBOLSOS_'.$nombre_ifi.'_'.$desde.'_'.$hasta;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($archivo, 'Excel2007');
        $objWriter->save('php://output');

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}else{
    session_start();
    $_SESSION['msg'] = "Por favor rellene todos los campos.";
    header('Location: ../index.php');
}
?>
