<?php

require '../conection.php';
session_start();

if(isset($_SESSION['first_name'], $_SESSION['last_name'])){

    $stat = $conn->prepare('call listar_asesores(:user);');
    $stat->bindValue(':user', $_SESSION['first_name'].' '.$_SESSION['last_name'], PDO::PARAM_STR);
    if($stat->execute()){
        echo json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
    }else{
        echo 'false';
    }

}

?>