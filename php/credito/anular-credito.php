<?php

if(isset($_POST['data'])){

    require '../conection.php';

    session_start();

    $obj = json_decode($_POST['data']);

    $stat_bitacora = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) values (:id_credito, :hash, :estado_razon, :observacion, CURRENT_TIMESTAMP(), :estado_credito, :user_id)');
        
    function agregarEnBitacora($statement, $idcredito, $hash, $razon, $estado_credito, $user, $observ){
        
        $statement->bindValue(':id_credito', $idcredito, PDO::PARAM_INT);
        $statement->bindValue(':hash', $hash, PDO::PARAM_STR);
        $statement->bindValue(':estado_razon', $razon, PDO::PARAM_STR);
        $statement->bindValue(':estado_credito', $estado_credito, PDO::PARAM_STR);
        $statement->bindValue(':user_id', $user, PDO::PARAM_STR);
        $statement->bindValue(':observacion', $observ, PDO::PARAM_STR);
        $statement->execute();
        
    }

    $stat_creditos = $conn->prepare('select id, estatus_prestamo from cartera_consolidada where grupo_solidario_hash = :hash');
    $stat_creditos->bindValue(':hash', $obj->hash, PDO::PARAM_STR);
    $stat_creditos->execute();
    $result = $stat_creditos->fetchAll(PDO::FETCH_ASSOC);

    foreach($result as $row){
        agregarEnBitacora($stat_bitacora, $row['id'], $obj->hash, 'Credito Anulado', $row['estatus_prestamo'], $_SESSION['user'], 'El crédito ha sido anulado');
    }

    $stat = $conn->prepare('update cartera_consolidada set estatus_prestamo = "Anulado" where grupo_solidario_hash = :hash');
    $stat->bindValue(':hash', $obj->hash, PDO::PARAM_STR);
    if($stat->execute()){
        echo true;
    }else{
        echo false;
    }

}

?>