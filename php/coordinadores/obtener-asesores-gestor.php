<?php

require '../conection.php';

if(isset($_POST['idsupervisor'])){

    $stat = $conn->prepare('select * from gsc where parent = :id and tipoEmpleado = "Gestor"');
    $stat->bindValue(':id', $_POST['idsupervisor'], PDO::PARAM_STR);
    $stat->execute();
    $asesores = $stat->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($asesores);

}

?>