<?php

if(isset($_POST['data'])){
    
    session_start();
    
    $obj = json_decode($_POST['data']);
    
    try{
        
        require '../php/conection.php';
    
        $stat_bitacora = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) 
                                        values (:id_credito, :hash, :estado_razon, :observacion, CURRENT_TIMESTAMP(), :estado_credito, :user_id)');

        //Función para ingresar una entrada nueva a la bitacora
        function agregarEnBitacora($statement, $idcredito, $hash, $razon, $estado_credito, $user, $observ){

            $statement->bindValue(':id_credito', $idcredito, PDO::PARAM_INT);
            $statement->bindValue(':hash', $hash, PDO::PARAM_STR);
            $statement->bindValue(':estado_razon', $razon, PDO::PARAM_STR);
            $statement->bindValue(':estado_credito', $estado_credito, PDO::PARAM_STR);
            $statement->bindValue(':user_id', $user, PDO::PARAM_STR);
            $statement->bindValue(':observacion', $observ, PDO::PARAM_STR);
            return $statement->execute();

        }
        
        if(agregarEnBitacora($stat_bitacora, $obj->idcredito, $obj->hash, $obj->razon, $obj->estado_credito, $_SESSION['user'], $obj->observacion)){
            echo true;
        }else{
            echo "error";
        }
        
    }catch(PDOException $e){
        
        error_log($e->getMessage());
        
    }
    
    
    
}

?>