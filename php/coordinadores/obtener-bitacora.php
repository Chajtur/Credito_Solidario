<?php

if(isset($_POST['id'])){

    require '../conection.php';
    
    $stat = $conn->prepare('select a.razon, a.observacion, a.fecha, a.estado_credito, a.id_usuario
    from credito_solidario.bitacora_creditos a
    where a.id_credito = :idcredito');
    $stat->bindValue(':idcredito', $_POST['id'], PDO::PARAM_STR);
    $stat->execute();
    $data = $stat->fetchAll(PDO::FETCH_ASSOC);

    $stat_lara = $conn2->prepare('select concat(first_name, " ", last_name) as nombre from users where username = :user');

    $obj = array();

    $i = 0;
    foreach($data as $fila){

        $stat_lara->bindValue(':user', $fila['id_usuario'], PDO::PARAM_STR);
        $stat_lara->execute();
        $result = $stat_lara->fetch(PDO::FETCH_ASSOC);
        $fila['nombre'] = $result['nombre'];
        $obj[] = $fila;
        $i++;
        
    }

    echo json_encode($obj);

}

?>