<?php

if(isset($_POST['data'])){
    
    $obj = json_decode($_POST['data']);
    require '../conection.php';

    $stat = $conn->prepare('select NombreGS(:nombre, nombre) as nombre from gsc where id = :gestor;');
    $stat->bindValue(':nombre', $obj->nombre, PDO::PARAM_STR);
    $stat->bindValue(':gestor', $obj->gestor, PDO::PARAM_STR);
    $stat->execute();
    $data = $stat->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);

}

?>