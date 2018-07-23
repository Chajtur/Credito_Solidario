<?php

require 'plugins/excel-reporter/excel-reporter.php';

require 'conection.php';

$stat = $conn->prepare('select grupo_solidario_hash from cartera_consolidada where ifi = "15"');
$stat->execute();
$data = $stat->fetchAll(PDO::FETCH_ASSOC);

$groups = array();
foreach($data as $fila){
    $groups[] = $fila['grupo_solidario_hash'];
}

$excelreporter = new ExcelReporter('reporte-guadalupe', $groups, 'Rychiv4');
$excelreporter->generarExcel('/', $conn);

?>