<?php

if(isset($_POST['data'])){

    try{
        
        session_start();
    
        require '../conection.php';

        $obj = json_decode($_POST['data']);
        
        $stat_estado = $conn->prepare('update cartera_consolidada set Estatus_Prestamo = :estado where grupo_solidario_hash = :hash');
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
            $statement->execute();
            
        }
        
        $conn->beginTransaction();

        foreach($obj as $grupo){
            
            if($grupo->estado != null || $grupo->estado != ""){
                
                $stat_estado->bindValue(':estado',($grupo->estado == "1" ? 'Digitacion' : 'Devuelto'), PDO::PARAM_STR);
                $stat_estado->bindValue(':hash', $grupo->hash, PDO::PARAM_STR);
                $stat_estado->execute();
                
                foreach($grupo->beneficiarios as $beneficiario){
                    
                    agregarEnBitacora($stat_bitacora, $beneficiario->id_credito, $grupo->hash, 'Crédito '.($grupo->estado == "1" ? 'Aprobado' : 'Denegado'), $grupo->estatus_prestamo, $_SESSION['user'], 'Crédito Procesado');
                    agregarEnBitacora($stat_bitacora, $beneficiario->id_credito, $grupo->hash, ($grupo->estado == "1" ? 'Aprobación de crédito' : 'Denegación de Crédito'), ($grupo->estado == "1" ? 'Digitacion' : 'Denegado'), $_SESSION['user'], 'Crédito '.($grupo->estado == "1" ? 'Digitacion' : 'Denegado'));
                    
                }
                
            }
            
        }
        $conn->commit();
        echo true; // Devolvemos true al ajax
        
    }catch(PDOException $e){
        $conn->rollBack();
        echo $e->getCode();
        
    }
    
}

?>