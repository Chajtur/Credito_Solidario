<?php

try{
    
    $conn = new PDO('mysql:host=192.168.1.98;dbname=credito_solidario', 'ricardo', 'icsric2016');
    $stat = $conn->prepare('select day(`Fecha/Hora`) as fecha from control_llegadas 
    where `ID de usuario` = :id and time(`Fecha/Hora`) between "06:00:00" and "14:59:00" and `Fecha/Hora` between "2017-12-01" and "2017-12-13"'); // aqui sumar un dia a la fecha
    
    $ids = range(1,79);
    
    $users = [];
    
    foreach($ids as $id){
        
        $stat->bindValue(':id',$id, PDO::PARAM_INT);
        $stat->execute();
        $data = $stat->fetchAll();
        
        $fechas = [];
        
        foreach($data as $fecha){
            array_push($fechas, $fecha['fecha']);
        }
        
        //$fechas['cantidad'] = sizeof($data);
        
        $users[$id] = $fechas;
        
    }
    
    $fechastodas = [
        "1","2","3","4","5","6","7","8","9","10","11","12"
        // "21","22","23","24","25","26","27","28","29","30"
    ];
    
    $diff = [];
    
    foreach($users as $user => $array){
        $diff[$user] = array_diff($fechastodas, $array);
    }
    
    $stat = $conn->prepare('select Nombre from control_llegadas where `ID de usuario` = :id');
    
    $datosconvertidos = [];
    
    //var_dump($diff);
    
    foreach($diff as $datosusuario => $array){
        
        $stat->bindValue(':id', $datosusuario, PDO::PARAM_INT);
        $stat->execute();
        $nombre = $stat->fetch(PDO::FETCH_ASSOC);
        
        $fechas_sin_marcar = [];
        
        foreach($array as $index => $value){
            
            array_push($fechas_sin_marcar, $value);
            
        }
        
        $datosconvertidos[$nombre['Nombre']] = $fechas_sin_marcar;
        
    }
    
    /*header('Content-type: text/plain');
    echo json_encode($datosconvertidos);*/
    
    require 'PHPExcel.php';
    
    $archivo = new PHPExcel();
    $archivo->getProperties()
        ->setCreator('Credito Solidario')
        ->setTitle('Reporte Gerencial');
    
    $i=1;
    foreach($datosconvertidos as $empleado => $array){
        
        $archivo->getActiveSheet()
            ->setCellValueByColumnAndRow(0, $i, $empleado);
        
        $j=1;
        foreach($array as $fecha){
            
            $archivo->getActiveSheet()
            ->setCellValueByColumnAndRow($j, $i, $fecha);
            $j++;
            
        }
        
        $i++;
        
    }
    
    $arreglo_letras = range('A', 'Z');

    foreach($arreglo_letras as $letter){
        $archivo->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
    }
    
    $nombre_archivo = 'ENTRADAS_NO_MARCADAS';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($archivo, 'Excel2007');
    $objWriter->save('php://output');
    
}catch(PDOException $e){
    
    echo $e->getMessage();
    
}

?>