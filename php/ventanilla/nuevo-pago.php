<?php

if(isset($_POST['data'])){


    require '../conection.php';
    $obj = json_decode($_POST['data']);

    $stat = $conn->prepare('call registrar_pago(:fecha, :prestamo, :monto);');
    $stat->bindValue(':fecha', $obj->fecha, PDO::PARAM_STR);
    $stat->bindValue(':prestamo', $obj->prestamo, PDO::PARAM_STR);
    $stat->bindValue(':monto', $obj->valor, PDO::PARAM_STR);
    if($stat->execute()){
        echo 'true';
    }else{
        echo 'false';
    }

}else{

    echo "No capturó nada";

}

?>