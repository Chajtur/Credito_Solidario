<?php

if(isset($_POST['hash'], $_POST['fechaInicial'], $_POST['fechaFinal'], $_POST['tipo'])){
    
    require '../plugins/pro-excel/pro-excel.class.php';
    require '../conection.php';

    $tipo = ($_POST['tipo'] == '0' ? 'de Grupo' : 'de Rango de Fechas');

    $proExcel = new ProExcel('Reporte '.$tipo, '', $conn);
    $q = 'call Reportar_Control_Calidad("'.($_POST['hash'] ? $_POST['hash'] : "").'", "'.($_POST['fechaInicial'] ? $_POST['fechaInicial'] : '').'", "'.($_POST['fechaFinal'] ? $_POST['fechaFinal'] : null).'", "'.$_POST['tipo'].'");';
    $proExcel->query = $q;
    // error_log($proExcel->query);

    if($proExcel->generarExcel()){
        echo $proExcel->ruta;
    }else{
        echo "error";
    }

}else{

    echo "no data";

}

?>