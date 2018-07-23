<?php

/**
 * Archivo que obtiene las metas mensuales para la ventana de gerencia
 * @author Victor Alvarado
 */

if(isset($_POST['mes'])){

    require '../conection.php';
    
    $stat = $conn->prepare('call obtener_meta_mensual(:mes);');
    $stat->bindValue(':mes', $_POST['mes'], PDO::PARAM_STR);
    $stat->execute();

    $result = $stat->fetch(PDO::FETCH_ASSOC);

    echo json_encode($result);

}

?>