<?php

if(isset($_POST['credito'])){
    
    try{
        
        $creditos = json_decode($_POST['credito']);
        
        session_start();
        
        require "../conection.php";
        require '../plugins/reception-report/reception-report.php';
        
        $stat = $conn->prepare('update cartera_consolidada set Estatus_Prestamo = "Call Center" where grupo_solidario_hash = :hash');
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
        
        $stat_creditos = $conn->prepare('select * from cartera_consolidada where grupo_solidario_hash = :hash');
        
        $grupos = array();
        
        foreach($creditos as $hash){
            
            $stat_creditos->bindValue(':hash', $hash, PDO::PARAM_STR);
            $stat_creditos->execute();
            
            while($result = $stat_creditos->fetch(PDO::FETCH_ASSOC)){
                agregarEnBitacora($stat_bitacora, $result['id'], $hash, 'Recibido Call Center', 'Call Center', $_SESSION['user'], 'Recibido Call Center');
            }
            
            $stat->bindValue(':hash', $hash, PDO::PARAM_STR);
            $stat->execute();
                
            $grupos[] = $hash;
            
        }
        
        // Conseguir datos para el archivo
        $stat_bitacora = $conn->prepare('select id_usuario from bitacora_creditos where grupo_hash = :hash and estado_credito = "Ingresado" order by fecha desc limit 1');
        $stat_bitacora->bindValue(':hash', $grupos[0], PDO::PARAM_STR);
        $stat_bitacora->execute();
        $identrego = $stat_bitacora->fetch(PDO::FETCH_ASSOC);
        
        $stat_larahrm = $conn2->prepare('select concat(first_name, " ", last_name) as name from users where employee_id = :id or username = :id');
        $stat_larahrm->bindValue(':id', $identrego['id_usuario'], PDO::PARAM_STR);
        $stat_larahrm->execute();
        $nombre = $stat_larahrm->fetch(PDO::FETCH_ASSOC);
        
        $entrega = $nombre['name'];
        
        $date = date('d-m-Y_Gis');
        
        $nombre = 'RECEPCION_CALL_CENTER_'.$_SESSION['user'].'_'.$date.'.pdf';
        
        // Desde aca se genera el archivo
        $archivo = new ReceptionReport($nombre, 'Call Center', $_SESSION['user']);
        $archivo->saveToDatabase($conn);
        $archivo->groups = $grupos;
        $str = $archivo->generateReportToDirectory('../../docs/', $conn, $conn2, $entrega);

        // echo $str;
        echo $nombre;
        
        // print_r($_POST['credito']);
        
    }catch(PDOException $e){
        
        echo false;
        
    }
    
    
}else{
    echo "No capturo";
}

?>