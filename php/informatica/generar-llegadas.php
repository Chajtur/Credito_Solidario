<?php

if(isset($_GET['fechaDesde'], $_GET['fechaHasta'])){

    try{

        require '../conection.php';

        $stat = $conn->prepare('select `ID de usuario`, Nombre, date_format(`Fecha/Hora`, "%d-%m-%Y") as fecha, date_format(`Fecha/Hora`, "%r") as hora 
        from control_llegadas where Nombre is not null and `Fecha/Hora` between :fechaInicial and :fechaFinal order by Nombre;');
        $stat->bindValue(':fechaInicial', $_GET['fechaDesde'], PDO::PARAM_STR);
        $stat->bindValue(':fechaFinal', $_GET['fechaHasta'], PDO::PARAM_STR);
        $stat->execute();
        $llegadas = $stat->fetchAll(PDO::FETCH_ASSOC);

        // ========================
        // Creando archivo de excel
        // ========================

        require '../PHPExcel.php';
        
        $archivo = new PHPExcel();
        $archivo->getProperties()
            ->setCreator('Credito Solidario')
            ->setTitle('Reporte Llegadas');

        $i=3;
        foreach($llegadas as $llegada){

            $j=1;
            foreach($llegada as $indice => $valor){
                
                $archivo->getActiveSheet()
                    ->setCellValueByColumnAndRow($j++, $i, $valor);

            }
            $i++;  

        }

        // Autosize
        $arreglo_letras = range('A', 'Z');
        
        foreach($arreglo_letras as $letter){
            $archivo->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
        }

        // Arreglar headers
        $archivo->getActiveSheet()->mergeCells('B2:E2');
        $archivo->getActiveSheet()->setCellValue('B2','Llegadas del '.$_GET['fechaDesde'].' al '.$_GET['fechaHasta']);

        // Estilizar
        $centerStyle = array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        );

        $headerStyle = array(
            'font' => array(
                'color' => array('rgb' => 'ffffff')
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '000040')
            )
        );

        $bordeStyle = array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN                    
            )
        );

        $archivo->getActiveSheet()->getStyle('B2')->applyFromArray($headerStyle);
        $archivo->getActiveSheet()->getStyle('B2')->getAlignment()->applyFromArray($centerStyle);
        $archivo->getActiveSheet()->getStyle('B2:E'.strval((count($llegadas))+2))->getBorders()->applyFromArray($bordeStyle);

        // ==================
        // Generando el excel
        // ==================

        $nombre_archivo = 'LLEGADAS';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($archivo, 'Excel2007');
        $objWriter->save('php://output');

    }catch(PDOException $e){
        
        echo $e->getMessage();
        
    }

}

?>