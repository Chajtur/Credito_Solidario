<?php

require '../conection.php';
session_start();

if(isset($_POST['id_caso'], $_POST['solucion'])){

    $stat = $conn->prepare('call guardar_solucion(:solucion, :id_caso);');
    $stat->bindValue('id_caso', $_POST['id_caso'], PDO::PARAM_STR);
    $stat->bindValue('solucion', $_POST['solucion'], PDO::PARAM_STR);
    if($stat->execute()){
        echo 'true';
    }else{
        echo 'false';
    }

}

?>