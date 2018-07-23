<?php

if(isset($_POST['data'])){

    require '../conection.php';
    $obj = json_decode($_POST['data']);

    $stat = $conn->prepare('update prestamo set saldo_capital = (saldo_capital - (:value * 1)) where Numero_Prestamo = :prestamo');
    $stat->bindValue(':value', $obj->valor, PDO::PARAM_STR);
    $stat->bindValue(':prestamo', $obj->prestamo, PDO::PARAM_STR);
    if($stat->execute()){
        echo true;
    }else{
        echo "No se pudo procesar la solicitud";
    }

}

?>