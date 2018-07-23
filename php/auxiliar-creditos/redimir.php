<?php

if(isset($_POST['hash'])){

    $grupo_hash = $_POST['hash'];

    require '../conection.php';

    session_start();

    // obtener el estatus que deberia
    $stat_estatus = $conn->prepare('select estado_credito from bitacora_creditos a left join cartera_consolidada b on a.id_credito = b.id 
    where a.grupo_hash = :hash and razon = "Observacion Auxiliar de Creditos" order by fecha desc limit 1');
    $stat_estatus->bindValue(':hash', $grupo_hash, PDO::PARAM_STR);
    $stat_estatus->execute();
    $status = $stat_estatus->fetch(PDO::FETCH_ASSOC);

    // registrar en bitacora

    function agregarEnBitacora($statement, $idcredito, $hash, $razon, $estado_credito, $user, $observ){

        $statement->bindValue(':id_credito', $idcredito, PDO::PARAM_INT);
        $statement->bindValue(':hash', $hash, PDO::PARAM_STR);
        $statement->bindValue(':estado_razon', $razon, PDO::PARAM_STR);
        $statement->bindValue(':estado_credito', $estado_credito, PDO::PARAM_STR);
        $statement->bindValue(':user_id', $user, PDO::PARAM_STR);
        $statement->bindValue(':observacion', $observ, PDO::PARAM_STR);
        return $statement->execute();

    }

    $stat_bitacora = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) 
                                        values (:id_credito, :hash, :estado_razon, :observacion, CURRENT_TIMESTAMP(), :estado_credito, :user_id)');

    $stat_creditos = $conn->prepare('select id from cartera_consolidada where grupo_solidario_hash = :hash');
    $stat_creditos->bindValue(':hash', $grupo_hash, PDO::PARAM_STR);
    $stat_creditos->execute();
    $creditos = $stat_creditos->fetchAll(PDO::FETCH_ASSOC);

    foreach ($creditos as $credito) {
        agregarEnBitacora($stat_bitacora, $credito['id'], $grupo_hash, 'Credito Redimido', $status['estado_credito'], $_SESSION['user'], 'El crédito ha sido redimido');
    }

    $stat = $conn->prepare('update cartera_consolidada set Estatus_Prestamo = :estatus where grupo_solidario_hash = :hash');
    $stat->bindValue(':estatus', $status['estado_credito'], PDO::PARAM_STR);
    $stat->bindValue(':hash', $grupo_hash, PDO::PARAM_STR);
    if($stat->execute()){
        echo true;
    }else{
        echo "error";
    }

}

?>