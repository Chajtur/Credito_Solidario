<?php

// var_dump($_SERVER);

require '../plugins/pro-excel/pro-excel.class.php';
require '../conection.php';

$proExcel = new ProExcel('VISITAS', '', $conn);
$proExcel->outputEnable = true;
$proExcel->query = 'call obtener_visitas_cda();';
if($proExcel->generarExcel()){
    echo "correcto";
}else{
    echo "error";
}

?>