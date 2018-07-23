<?php

if(isset($_POST['data'])){
    
    try{
        
        session_start(); 
    
        require '../conection.php';

        $obj = json_decode($_POST['data']); // Capturamos el objeto principal enviado por el ajax

        $stat_estatus = $conn->prepare('update cartera_consolidada set estatus_prestamo = :estado where grupo_solidario_hash = :hash');
        $stat_bitacora = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) values (:id_credito, :hash, :estado_razon, :observacion, CURRENT_TIMESTAMP(), :estado_credito, :user_id)');
        
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
        
        foreach($obj as $grupo){

            $correcto = true;

            if($grupo->verificado){ //Si el grupo ha sido verificado, se procesa

                foreach($grupo->beneficiarios as $beneficiario){

                    if(sizeof($beneficiario->checklist) > 0){ // Si es mayor a cero, entonces tiene observaciones (checkboxes)

                        $correcto = false;

                        foreach($beneficiario->checklist as $observacion){ // Agregamos una observación en la bitacora por cada elemento de la checklist
                            
                            agregarEnBitacora($stat_bitacora, $beneficiario->id_credito, $grupo->hash, 'Correccion Call Center', 'Call Center', $_SESSION['user'], $observacion->text);

                        }
                        
                        agregarEnBitacora($stat_bitacora, $beneficiario->id_credito, $grupo->hash, 'Devuelto con Correcciones', 'Devuelto', $_SESSION['user'], 'Devuelto con Correcciones');
                        
                    }else if($grupo->con_error){ // Si el checklist está vacío, entonces puede que el resto del grupo tenga error, registramos el caso en la bitacora
                        
                        agregarEnBitacora($stat_bitacora, $beneficiario->id_credito, $grupo->hash, 'Grupo con correccion', 'Call Center', $_SESSION['user'], 'Grupo con correccion');
                        
                        agregarEnBitacora($stat_bitacora, $beneficiario->id_credito, $grupo->hash, 'Devuelto con Correcciones', 'Devuelto', $_SESSION['user'], 'Devuelto con Correcciones');
                        
                    }else if($correcto){ // Si el checklist está vacío y el grupo no tiene error, entonces el crédito no tiene errores, registramos en la bitacora
                        
                        agregarEnBitacora($stat_bitacora, $beneficiario->id_credito, $grupo->hash, 'Sin Correcciones', 'Call Center', $_SESSION['user'], 'Sin Correcciones');
                        
                        agregarEnBitacora($stat_bitacora, $beneficiario->id_credito, $grupo->hash, 'Verificado Call Center', 'Call Center', $_SESSION['user'], 'Sin Correcciones');
                        
                    }
                    
                }
                
                /*
                Hasta aqui modificamos el estado de todo el grupo con sus créditos.
                Si tiene errores, entonces Para Correccion, sino Control de Calidad.
                */
                
                $stat_estatus->bindValue(':estado', ($correcto ? 'Control de Calidad' : 'Devuelto'), PDO::PARAM_STR);
                $stat_estatus->bindValue(':hash', $grupo->hash, PDO::PARAM_STR);
                $stat_estatus->execute();
                
                //Fin
                
            }

        }
        
        echo "true"; // Devolvemos true al ajax
        
    }catch(PDOException $e){
        
        error_log($e->getCode());
        echo $e->getCode();
        
    }
    
    
}

?>