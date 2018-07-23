<?php

require 'excel-reporter.php';
require '../../conection.php';

$grupos = array('D112', 'D113', 'D111');

$data = new ExcelReporter('archivo', $grupos);
$data->generarExcel('', $conn);


?>