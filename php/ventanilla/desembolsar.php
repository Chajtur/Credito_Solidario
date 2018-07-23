<?php

require '../conection.php';

if(isset($_POST['id_credito'])){

    $stat = $conn->prepare('update cartera_consolidada set estatus_prestamo = "Desembolsado" where id = :id');
    $stat->bindValue(':id', $_POST['id_credito'], PDO::PARAM_STR);
    if($stat->execute()){
        echo true;
    }else{
        echo false;
    }

}


?>