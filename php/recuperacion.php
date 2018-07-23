<?php

require 'PHPExcel.php';

if(isset($_POST['select_ifi_rec']) && isset($_POST['date_desde_rec']) && isset($_POST['date_hasta_rec']) && isset($_POST['select_formato_rec'])){
    
    try{
       
        require_once 'conection.php';

        $desde = $_POST['date_desde_rec'];
        $hasta = $_POST['date_hasta_rec'];

        //echo var_dump($_POST);

        $archivo = new PHPExcel();


        $archivo->getProperties()->setCreator("Ricardo Valladares")
                            ->setLastModifiedBy("Ricardo Valladares")
                            ->setTitle("Archivo de prueba")
                            ->setSubject("Subject prueba")
                            ->setDescription("Descripción de prueba")
                            ->setKeywords("office PHPExcel php")
                            ->setCategory("Test result file");


        $i = 0;
        foreach($_POST['select_ifi_rec'] as $ifi){

            $nombre_ifi = $ifi;

            switch($ifi){

                case 1:
                    $nombre_ifi = 'BANTRAB';
                    break;
                case 2:
                    $nombre_ifi = 'BANRURAL';
                    break;
                case 3:
                    $nombre_ifi = 'CHOROTEGA';
                    break;
                case 4:
                    $nombre_ifi = 'CATACAMAS';
                    break;
                case 8:
                    $nombre_ifi = 'BANADESA';
                    break;

            }

            $nuevaHoja = new PHPExcel_Worksheet($archivo, $nombre_ifi);
            $archivo->addSheet($nuevaHoja, $i);

            $sql = 'call recuperacion_ifi_fecha('.$ifi.', "'.$desde.'", "'.$hasta.'")';
            $stat = $conn->prepare($sql);
            $stat->execute();
            $rows = $stat->fetchAll(PDO::FETCH_ASSOC);

            $archivo->setActiveSheetIndex($i)
                        ->setCellValueByColumnAndRow('0', '1', 'Identidad')
                        ->setCellValueByColumnAndRow('1', '1', 'NombreCliente')
                        ->setCellValueByColumnAndRow('2', '1', 'FechaPago')
                        ->setCellValueByColumnAndRow('3', '1', 'Capital')
                        ->setCellValueByColumnAndRow('4', '1', 'Intereses')
                        ->setCellValueByColumnAndRow('5', '1', 'InteresMoratorio')
                        ->setCellValueByColumnAndRow('6', '1', 'Otros')
                        ->setCellValueByColumnAndRow('7', '1', 'Recuperacion')
                        ->setCellValueByColumnAndRow('8', '1', 'Ifi')
                        ->setCellValueByColumnAndRow('9', '1', 'fondo');

            $j = 2;
            foreach($rows as $fila){

                $archivo->setActiveSheetIndex($i)
                            ->setCellValueByColumnAndRow('0', $j, $fila['Identidad'])
                            ->setCellValueByColumnAndRow('1', $j, $fila['NombreCliente'])
                            ->setCellValueByColumnAndRow('2', $j, $fila['FechaPago'])
                            ->setCellValueByColumnAndRow('3', $j, $fila['Capital'])
                            ->setCellValueByColumnAndRow('4', $j, $fila['Intereses'])
                            ->setCellValueByColumnAndRow('5', $j, $fila['InteresMoratorio'])
                            ->setCellValueByColumnAndRow('6', $j, $fila['Otros'])
                            ->setCellValueByColumnAndRow('7', $j, $fila['Recuperacion'])
                            ->setCellValueByColumnAndRow('8', $j, $fila['Ifi'])
                            ->setCellValueByColumnAndRow('9', $j, $fila['fondo']);
                        $j++;
                if((memory_get_usage() / 1024 / 1024) > 500){
                    
                    session_start();
                    $_SESSION['msg'] = 'Lo sentimos, no hay suficiente memoria para generar el reporte; intente generar cada reporte por separado.';
                    header('Location: ../index.php#recuperacion');
                    
                }
                
            }

            $i++;
            
        }

        $nombre_archivo = 'RECUPERACION_'.$desde.'_'.$hasta;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($archivo, 'Excel2007');
        $objWriter->save('php://output');

        /*$ifi = $_POST['select_ifi_rec'];
        $desde = $_POST['date_desde'];
        $hasta = $_POST['date_hasta'];
        $formato = $_POST['select_formato'];

        $nombre_ifi = '';

        $sql = 'call recuperacion_ifi_fecha('.ifi.', "'.$fecha_inicio.'", "'.$fecha_final.'")';*/
        
    }catch(PDOException $e){
        
        session_start();
        $_SESSION['msg'] = 'Error de conexión';
        error_log($e->getMessage());
        
    }
    
}else{
    
    session_start();
    $_SESSION['msg'] = "Por favor rellene todos los campos.";
    header('Location: ../index.php');
    
}

?>