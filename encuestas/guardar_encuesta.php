<?php

if(isset($_POST['identidad'], $_POST['nombre'], $_POST['respuesta'])){

    session_start();
    require '../php/conection.php';

    $stat = $conn->prepare('call almacenar_encuesta(:user, :identidad, :beneficiario, :respuesta)');
    $stat->bindValue(':user', $_POST['identidad'], PDO::PARAM_STR);
    $stat->bindValue(':identidad', $_POST['nombre'], PDO::PARAM_STR);
    $stat->bindValue(':beneficiario', $_POST['respuesta'], PDO::PARAM_STR);
    $stat->bindValue(':respuesta', $_SESSION['user'], PDO::PARAM_STR);
    $stat->execute();

}



?>