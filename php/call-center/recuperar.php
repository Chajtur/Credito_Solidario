<?php

if(isset($_POST['hash'])){

    try{

        session_start();

        require '../conection.php';

        $conn->beginTransaction();
        $stat_bitacora = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) 
            values (:id_credito, :hash, :estado_razon, :observacion, CURRENT_TIMESTAMP(), :estado_credito, :user_id)');
            
        function agregarEnBitacora($statement, $idcredito, $hash, $razon, $estado_credito, $user, $observ){
            
            $statement->bindValue(':id_credito', $idcredito, PDO::PARAM_INT);
            $statement->bindValue(':hash', $hash, PDO::PARAM_STR);
            $statement->bindValue(':estado_razon', $razon, PDO::PARAM_STR);
            $statement->bindValue(':estado_credito', $estado_credito, PDO::PARAM_STR);
            $statement->bindValue(':user_id', $user, PDO::PARAM_STR);
            $statement->bindValue(':observacion', $observ, PDO::PARAM_STR);
            $statement->execute();
            
        }

        $stat_select = $conn->prepare('select * from cartera_consolidada where grupo_solidario_hash = :hash');
        $stat_select->bindValue(':hash', $_POST['hash']);
        $stat_select->execute();
        $result = $stat_select->fetchAll();
        
        foreach($result as $fila){
            
            agregarEnBitacora($stat_bitacora, $fila['id'], $_POST['hash'], 'Credito Recuperado', $fila['Estatus_Prestamo'], $_SESSION['user'], 'Credito regresado al departamento anterior por el usuario');

        }

        $stat_estado = $conn->prepare('select * from bitacora_creditos 
        where estado_credito in ("Call Center","Control de Calidad")
        and grupo_hash = :hash
        order by fecha desc limit 1');
        $stat_estado->bindValue(':hash', $_POST['hash'], PDO::PARAM_STR);
        $stat_estado->execute();
        $fetch = $stat_estado->fetch(PDO::FETCH_ASSOC);

        $stat = $conn->prepare('update cartera_consolidada set estatus_prestamo = :estatus where grupo_solidario_hash = :hash');
        $stat->bindValue(':estatus', $fetch['estado_credito'], PDO::PARAM_STR);
        $stat->bindValue(':hash', $_POST['hash'], PDO::PARAM_STR);
        $stat->execute();
        $conn->commit();
        echo 'true';

    }catch(PDOException $e){

        $conn->rollBack();
        echo 'false';

    }

    

}

?>