<?php

if(isset($_POST['antiguo']) && isset($_POST['nuevo'])){

    require '../conection.php';

    $stat = $conn->prepare('update prestamo set gestor = :nuevo where gestor = :antiguo and estado_credito = "Desembolsado"');
    $stat->bindValue(':nuevo', $_POST['nuevo'], PDO::PARAM_STR);
    $stat->bindValue(':antiguo', $_POST['antiguo'], PDO::PARAM_STR);
    if($stat->execute()){
        echo 'true';
    }else{
        echo 'false';
    }

}

?>