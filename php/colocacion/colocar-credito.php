<?php

/**
 * Archivo utilizado por el sistema para gestionar el proceso de colocación de un pbs
 * 
 * Recibe un objeto en formato JSON
 * Retorna el nombre del archivo generado en caso de éxito
 */


if(isset($_POST['data'])){
    
    try{
        
        session_start();
        
        require '../conection.php';
        require '../plugins/excel-reporter/excel-reporter.php';
        $obj = json_decode($_POST['data']); // decodificamos la variable enviada en objeto

        $conn->beginTransaction();

        // Obtenemos el máximo pbs que existe en la base
        // para asignar el siguiente corelativo
        $maxstatpbs = $conn->query('select get_max_pbs() as pbs_max');
        $maxpbs = $maxstatpbs->fetch(PDO::FETCH_ASSOC);
        
        // Verificamos si la IFI tiene el api activa
        $stat_activo = $conn->prepare('select activo from apiusers where ifi = :ifi');
        $stat_activo->bindValue(':ifi', $obj->ifi, PDO::PARAM_STR);
        $stat_activo->execute();
        $dat = $stat_activo->fetch(PDO::FETCH_ASSOC);

        if($dat['activo'] == 1){
            $estatus = 'Enviado'; // si esta activo, el estatus será Enviado
        }else{
            $estatus = 'Colocado'; // sino será Colocado
        }

        // Preparamos todos los statements para el ciclo principal
        $stat = $conn->prepare('update cartera_consolidada set estatus_prestamo = "'.$estatus.'", 
        ifi = :ifi, fondo = :fondo, documento = :documento, estatus_archivo = "1", programa = :programa
        where grupo_solidario_hash = :hash and estatus_prestamo <> "Anulado"');
        $stat_idcredito = $conn->prepare('select id, ciclo, Monto_Autorizado, departamento from cartera_consolidada where grupo_solidario_hash = :hash');
        $stat_bitacora = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) values (:id_credito, :hash, :estado_razon, :observacion, CURRENT_TIMESTAMP(), :estado_credito, :user_id)');
        
        // Iniciamos variables necesarias para el ciclo principal
        $grupos = array();
        $cantcreditos = 0;
        $ciclo = 0;
        $monto_total = 0;

        // CICLO PRINCIPAL
        foreach($obj->grupos_hash as $hash){
            
            $stat_idcredito->bindValue(':hash', $hash, PDO::PARAM_STR);
            $stat_idcredito->execute();
            
            $ids = $stat_idcredito->fetchAll();
            
            foreach($ids as $credito){
                
                agregarEnBitacora($stat_bitacora, $credito['id'], $hash, 'Credito Colocado', 'Colocado', $_SESSION['user'], 'Se ha colocado el crédito');
                $cantcreditos++;
                $monto_total += $credito['Monto_Autorizado'];
                $departamento = $credito['departamento'];

            }
            
            $stat->bindValue(':ifi', $obj->ifi, PDO::PARAM_STR);
            $stat->bindValue(':fondo', $obj->fondo, PDO::PARAM_STR);
            $stat->bindValue(':hash', $hash, PDO::PARAM_STR);
            $stat->bindValue(':programa', $obj->producto, PDO::PARAM_STR);
            $stat->bindValue(':documento', 'PBS_'.($maxpbs['pbs_max']+1), PDO::PARAM_STR);
            $stat->execute();
            
            $grupos[] = $hash;
            $ciclo = $ids[0]['ciclo'];
            
        }
        
        // Obtenemos la abreviación de IFI para el nombre del archivo
        $stat_ifi = $conn->prepare('select abreviacion from ifi where id = :id');
        $stat_ifi->bindValue(':id', $obj->ifi, PDO::PARAM_STR);
        $stat_ifi->execute();
        $ifi = $stat_ifi->fetch(PDO::FETCH_ASSOC);
        
        $fecha = new DateTime();
        
        // Generar el archivo de excel
        $nombre_archivo = quitar_tildes($departamento).'_PBS_'.($maxpbs['pbs_max']+1).' '.$cantcreditos.' CREDITOS CICLO '.$ciclo.' '.$ifi['abreviacion'].' '.$obj->fondo.' '.$fecha->format('d_m_Y').' MONTO TOTAL '.$monto_total;
        $excel = new ExcelReporter($nombre_archivo, $grupos, $_SESSION['user']);
        $excel->generarExcel('../../docs/excel/', $conn);
        $conn->commit();
        echo $nombre_archivo.'.xls';
        
    }catch(PDOException $e){
        $conn->rollBack();
        echo $e->getMessage();
        
    }
    
}

function quitar_tildes($cadena) {
    $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
    $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    $texto = str_replace($no_permitidas, $permitidas ,$cadena);
    return $texto;
}

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

?>