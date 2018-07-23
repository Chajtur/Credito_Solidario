<?php

require 'plugins/pro-excel/pro-excel.class.php';

require 'conection.php';

$proExcel = new ProExcel('REPORTE_SALINEROS', '', $conn);
$proExcel->outputEnable = true;
$proExcel->query = 'select *
from prestamo where identidad in (
"1709197600440",
"1709196600089",
"0808195900168",
"1709195100166",
"0601196701322",
"1701198001315",
"1701198001315",
"1709197600687",
"1701198402915",
"1709195800089",
"1709195100222",
"1701197301286",
"1701199401357"
) and Estado_Credito = "Desembolsado"';
if($proExcel->generarExcel()){
    echo "correcto";
}else{
    echo "error";
}

?>