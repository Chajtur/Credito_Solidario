<?php

require 'php/conection.php';
require 'php/PHPExcel.php';

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

$sql = 'select nombre, fecha_inicio 
from gsc where tipoEmpleado = "Gestor" 
and fecha_inicio is not null';
$stat = $conn->prepare($sql);
$stat->execute();
$arreglo = $stat->fetchAll(PDO::FETCH_ASSOC);

// $arreglo = [
//     array(
//         "nombre" => "Lourdes Maria Andino Flores",
//         "fecha_inicio" => "01/01/2017"
//     ),
//     array(
//         "nombre" => "Doris Xiomara Martinez Martinez",
//         "fecha_inicio" => "01/04/2017"
//     )
// ];

foreach($arreglo as $fila){

    $archivo = "archivo.xlsx";
    $excelReader = PHPExcel_IOFactory::createReaderForFile($archivo);
	$excelObj = $excelReader->load($archivo);
    $excelObj->getActiveSheet();
    
    $excelObj->getActiveSheet()->setCellValue('C1', $fila['nombre']);
    $excelObj->getActiveSheet()->setCellValue('E1', $fila['fecha_inicio']);

    $excelwriter = PHPExcel_IOFactory::createWriter($excelObj, 'Excel2007');
    $excelwriter->save('generado_'.str_replace(' ', '_', $fila['nombre']).'.xlsx');

}

?>