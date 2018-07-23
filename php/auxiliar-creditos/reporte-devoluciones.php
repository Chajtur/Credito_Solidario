<?php

if(isset($_POST['data'])){
    
    $obj = json_decode($_POST['data']);
    require '../plugins/pro-excel/pro-excel.class.php';
    require '../conection.php';

    $departamento = ($obj->departamento == 'Call Center' ? '("C143", "A039", "A064")' : '("C025", "C099")');
    $proExcel = new ProExcel('Reporte '.$obj->departamento, '', $conn);
    $proExcel->query = 'select a.grupo_hash, a.id_credito, b.Identidad, a.razon, a.observacion, a.estado_credito, 
    concat(c.first_name, " ",c.last_name) as usuario, b.Gestor, b.Supervisor, b.Coordinador, a.fecha 
    from credito_solidario.bitacora_creditos a 
    left join credito_solidario.cartera_consolidada b on a.id_credito = b.id
    left join larahrm.users c on a.id_usuario = c.employee_id collate utf8_unicode_ci
    where a.id_usuario in '.$departamento.' and a.fecha between "'.$obj->desde.'" and "'.$obj->hasta.'" 
    order by a.fecha desc';
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