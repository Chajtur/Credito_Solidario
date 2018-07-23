<?php

if(isset($_POST['desde'], $_POST['hasta'], $_POST['por'], $_POST['consolidar'])){

    require '../../../php/conection.php';
    require '../../../php/plugins/pro-excel/pro-excel.class.php';

    $archivo = new ProExcel('desembolsos_generado_'.date('d-m-Y'), 'docs', $conn);
    $sql = '"'.$_POST['por'].'", '.($_POST['desde'] == "" ? 'null' : '"'.$_POST['desde'].'"').', '.($_POST['hasta'] == "" ? 'null' : '"'.$_POST['hasta'].'"').', '.$_POST['consolidar'];
    $archivo->query = 'call obtener_desembolsos('.$sql.')';
    $archivo->generarExcel();
    echo $archivo->ruta;
    
}



?>