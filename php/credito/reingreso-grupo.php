<?php

if(isset($_POST['data'])){
    
    // echo $_POST['data'];
    
    try{
        
        session_start();
        require '../conection.php';
        $obj = json_decode($_POST['data']);
        
        // Statements
        $stat_select_status = $conn->prepare('select estado_credito from bitacora_creditos 
        where grupo_hash = :hash and razon like "Correccion%"
        order by fecha asc limit 1');
        $stat_update = $conn->prepare('update cartera_consolidada set Estatus_Prestamo = :status where grupo_solidario_hash = :hash');
        $stat_update_new = $conn->prepare('update cartera_consolidada set grupo_solidario_hash = :hash, grupo_solidario = :gruposolidario where identidad = :identidad and ciclo = :ciclo and fecha_procesamiento = :fecha');
        $stat_creditos = $conn->prepare('select id from cartera_consolidada where grupo_solidario_hash = :hash');
        $stat_insert = $conn->prepare('insert into cartera_consolidada(grupo_solidario_hash, Identidad, Nombre, PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, Agencia, Departamento, ciclo, fecha_procesamiento, Gestor, Supervisor, grupo_solidario, Sexo) 
                                                                values(:hash, :identidad, :nombre, :primernombre, :segundonombre, :primerapellido, :segundoapellido, :agencia, :departamento, :ciclo, :fecha, :gestor, :supervisor, :gruposolidario, :sexo)');
        $stat_censo = $conn3->prepare('select * from censo where identidad = :identidad');
        $stat_gestor = $conn->prepare('select a.departamento, a.agencia, a.nombre, Get_Supervisor(a.nombre) as supervisor
        from gsc a where nombre = :nombre');
        $stat_eliminar = $conn->prepare('delete from cartera_consolidada where identidad = :identidad and grupo_solidario_hash = :hash');
        $stat_obtener_id_credito = $conn->prepare('select id from cartera_consolidada where identidad = :identidad and grupo_solidario_hash = :hash limit 1');
        $stat_bitacora = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) values (:id_credito, :hash, :estado_razon, :observacion, CURRENT_TIMESTAMP(), :estado_credito, :user_id)');
        
        error_log($_POST['data']);
        
        // Functions
        function agregarEnBitacora($statement, $idcredito, $hash, $razon, $estado_credito, $user, $observ){
            
            $statement->bindValue(':id_credito', $idcredito, PDO::PARAM_INT);
            $statement->bindValue(':hash', $hash, PDO::PARAM_STR);
            $statement->bindValue(':estado_razon', $razon, PDO::PARAM_STR);
            $statement->bindValue(':estado_credito', $estado_credito, PDO::PARAM_STR);
            $statement->bindValue(':user_id', $user, PDO::PARAM_STR);
            $statement->bindValue(':observacion', $observ, PDO::PARAM_STR);
            $statement->execute();
            
        }
        
        $hoy = new DateTime();
        
        // Process itself
        foreach($obj as $grupo){
            
            $stat_gestor->bindValue(':nombre', $grupo->gestor, PDO::PARAM_STR);
            $stat_gestor->execute();
            $gestor = $stat_gestor->fetch(PDO::FETCH_ASSOC);
            
            foreach($grupo->eliminar as $beneficiario){
                
                $stat_obtener_id_credito->bindValue(':identidad', $beneficiario->identidad, PDO::PARAM_STR);
                $stat_obtener_id_credito->bindValue(':hash', $grupo->hash, PDO::PARAM_STR);
                $stat_obtener_id_credito->execute();
                $id = $stat_obtener_id_credito->fetch(PDO::FETCH_ASSOC);
                
                $stat_eliminar->bindValue(':identidad', $beneficiario->identidad, PDO::PARAM_STR);
                $stat_eliminar->bindValue(':hash', $grupo->hash, PDO::PARAM_STR);
                $stat_eliminar->execute();
                
                error_log('Eliminado hash: '.$grupo->hash.', identidad: '.$beneficiario->identidad);
                agregarEnBitacora($stat_bitacora, $id['id'], $grupo->hash, 'Beneficiario eliminado del grupo', 'Devuelto', $_SESSION['user'], 'Grupo Modificado');
                
            }
            
            foreach($grupo->agregar as $benef){
                
                $stat_censo->bindValue(':identidad', $benef->identidad, PDO::PARAM_STR);
                $stat_censo->execute();
                $persona = $stat_censo->fetch(PDO::FETCH_ASSOC);
                
                $stat_insert->bindValue(':hash', $grupo->hash, PDO::PARAM_STR);
                $stat_insert->bindValue(':identidad', $benef->identidad, PDO::PARAM_STR);
                $stat_insert->bindValue(':nombre', $benef->nombre, PDO::PARAM_STR);
                $stat_insert->bindValue(':primernombre', $persona['primerNombre'], PDO::PARAM_STR);
                $stat_insert->bindValue(':segundonombre', $persona['segundoNombre'], PDO::PARAM_STR);
                $stat_insert->bindValue(':primerapellido', $persona['primerApellido'], PDO::PARAM_STR);
                $stat_insert->bindValue(':segundoapellido', $persona['segundoApellido'], PDO::PARAM_STR);
                $stat_insert->bindValue(':agencia', $gestor['agencia'], PDO::PARAM_STR);
                $stat_insert->bindValue(':departamento', $gestor['departamento'], PDO::PARAM_STR);
                $stat_insert->bindValue(':ciclo', $grupo->ciclo, PDO::PARAM_STR); 
                $stat_insert->bindValue(':fecha', $hoy->format('Y-m-d'), PDO::PARAM_STR);
                $stat_insert->bindValue(':gestor', $gestor['nombre'], PDO::PARAM_STR);
                $stat_insert->bindValue(':supervisor', $gestor['supervisor'], PDO::PARAM_STR);
                $stat_insert->bindValue(':gruposolidario', $grupo->nombre_grupo, PDO::PARAM_STR);
                $stat_insert->bindValue(':sexo', ($persona['codigoSexo'] == "1" ? "M" : "F"), PDO::PARAM_STR);
                $stat_insert->execute();
                
                $stat_update_new->bindValue(':hash', $grupo->hash, PDO::PARAM_STR);
                $stat_update_new->bindValue(':gruposolidario', $grupo->nombre_grupo, PDO::PARAM_STR);
                $stat_update_new->bindValue(':identidad', $benef->identidad, PDO::PARAM_STR);
                $stat_update_new->bindValue(':ciclo', $grupo->ciclo, PDO::PARAM_STR);
                $stat_update_new->bindValue(':fecha', $hoy->format('Y-m-d'), PDO::PARAM_STR);
                $stat_update_new->execute();
                
                $stat_obtener_id_credito->bindValue(':identidad', $benef->identidad, PDO::PARAM_STR);
                $stat_obtener_id_credito->bindValue(':hash', $grupo->hash, PDO::PARAM_STR);
                $stat_obtener_id_credito->execute();
                $id = $stat_obtener_id_credito->fetch(PDO::FETCH_ASSOC);
                    
                error_log('Agregado hash: '.$grupo->hash.', identidad: '.$benef->identidad);
                agregarEnBitacora($stat_bitacora, $id['id'], $grupo->hash, 'Beneficiario agregado al grupo', 'Devuelto', $_SESSION['user'], 'Grupo Modificado');
                
            }
            
            $stat_creditos->bindValue(':hash', $grupo->hash, PDO::PARAM_STR);
            $stat_creditos->execute();
            $creditos = $stat_creditos->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($creditos as $credito){
                
                agregarEnBitacora($stat_bitacora, $credito['id'], $grupo->hash, 'Reingreso de credito', 'Ingresado', $_SESSION['user'], 'Reingreso de credito');
                
            }
            
            $stat_select_status->bindValue(':hash', $grupo->hash, PDO::PARAM_STR);
            $stat_select_status->execute();
            $status = $stat_select_status->fetch(PDO::FETCH_ASSOC);

            $stat_update->bindValue(':hash', $grupo->hash, PDO::PARAM_STR);
            $stat_update->bindValue(':status', ($status['estado_credito'] == 'Call Center' || $status['estado_credito'] == 'Ingresado' ? "Ingresado" : 'Para '.$status['estado_credito']), PDO::PARAM_STR);
            $stat_update->execute();
            
        }
        
        echo true;
        
    }catch(PDOException $e){
        
        error_log($e->getMessage());
        echo "Error";
        
    }
    
}

?>