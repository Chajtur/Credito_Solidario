<?php

/**
 * Archivo para completar la recepción de  un crédito en archivo
 * @param credito via post ($_POST['credito'], es un arreglo de créditos (hash) en formato json)
 * @author Rychiv4
 */

if(isset($_POST['credito'])){
    
    try{
        
        $creditos = json_decode($_POST['credito']);
        
        session_start();
        
        require "../conection.php"; // Conexión
        require '../plugins/reception-report/reception-report.php'; // requerido para generar la hoja de recepción de créditos
        
        $stat = $conn->prepare('update cartera_consolidada set estatus_archivo = "2" where grupo_solidario_hash = :hash'); // Cambiar el estado_archivo en la base
        $stat_bitacora = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) values (:id_credito, :hash, :estado_razon, :observacion, CURRENT_TIMESTAMP(), :estado_credito, :user_id)');
        
        // Función que agrega en bitácora un registro nuevo, requiere el statement $stat_bitacora o el statement preparado para almacenar los datos en la bd
        function agregarEnBitacora($statement, $idcredito, $hash, $razon, $estado_credito, $user, $observ){
            
            $statement->bindValue(':id_credito', $idcredito, PDO::PARAM_INT);
            $statement->bindValue(':hash', $hash, PDO::PARAM_STR);
            $statement->bindValue(':estado_razon', $razon, PDO::PARAM_STR);
            $statement->bindValue(':estado_credito', $estado_credito, PDO::PARAM_STR);
            $statement->bindValue(':user_id', $user, PDO::PARAM_STR);
            $statement->bindValue(':observacion', $observ, PDO::PARAM_STR);
            $statement->execute();
            
        }
        
        // Obtener los datos de cada beneficiario del grupo para registrar en bitácora con id de crédito y demás información
        $stat_creditos = $conn->prepare('select * from cartera_consolidada where grupo_solidario_hash = :hash');
        
        $grupos = array();
        
        // Para cada hash recibido
        foreach($creditos as $hash){
            
            $stat_creditos->bindValue(':hash', $hash, PDO::PARAM_STR);
            $stat_creditos->execute();
            
            // Para cada beneficiario del grupo registramos en bitácora que se recibió el grupo
            while($result = $stat_creditos->fetch(PDO::FETCH_ASSOC)){
                agregarEnBitacora($stat_bitacora, $result['id'], $hash, 'Recibido en Archivo', 'Colocado Prueba', $_SESSION['user'], 'Recibido en Archivo');
            }
            
            $stat->bindValue(':hash', $hash, PDO::PARAM_STR);
            $stat->execute();
                
            $grupos[] = $hash;
            
        }
        
        // Conseguir datos para el archivo
        $stat_bitacora = $conn->prepare('select id_usuario from bitacora_creditos where grupo_hash = :hash and razon = "Credito Colocado" order by fecha desc limit 1');
        $stat_bitacora->bindValue(':hash', $grupos[0], PDO::PARAM_STR);
        $stat_bitacora->execute();
        $identrego = $stat_bitacora->fetch(PDO::FETCH_ASSOC);
        
        $stat_larahrm = $conn2->prepare('select concat(first_name, " ", last_name) as name from users where employee_id = :id or username = :id');
        $stat_larahrm->bindValue(':id', $identrego['id_usuario'], PDO::PARAM_STR);
        $stat_larahrm->execute();
        $nombre = $stat_larahrm->fetch(PDO::FETCH_ASSOC);
        
        $entrega = $nombre['name'];
        
        $date = date('d-m-Y_Gis'); // Fecha actual
        
        $nombre = 'RECEPCION_ARCHIVO_'.$_SESSION['user'].'_'.$date.'.pdf'; // Nombre del pdf
        
        // Desde aca se genera el archivo
        $archivo = new ReceptionReport($nombre, 'Archivo', $_SESSION['user']); // Hacemos una instancia de la clase ReceptionReport ('../plugins/reception-report/reception-report.php')
        $archivo->saveToDatabase($conn);
        $archivo->groups = $grupos;
        $archivo->generateReportToDirectory('../../docs/', $conn, $conn2, $entrega);

        echo $nombre;
        
        // print_r($_POST['credito']);
        
    }catch(PDOException $e){
        
        echo false;
        
    }
    
    
}else{
    echo "No capturo";
}

?>