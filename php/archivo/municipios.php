<?php

/**
 * Archivo que obtiene los municipios de un departamento
 * @param data debe contener el código de un departamento
 * @author Rychiv4
 */

if(isset($_POST['data'])){

    require '../conection.php';
    $obj = json_decode($_POST['data']);
    error_log('Data----------------> '.$obj[0]);
    $stat = $conn->prepare('select idmunicipio as value, UC_FIRST(nombre) as text 
        from municipio where iddepartamento = :cod_depto');
    $stat->bindValue(':cod_depto', $obj[0], PDO::PARAM_STR);
    $stat->execute();
    echo json_encode($stat->fetchAll(PDO::FETCH_ASSOC));

}



?>