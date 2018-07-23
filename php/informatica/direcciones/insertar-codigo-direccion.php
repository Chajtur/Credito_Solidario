<?php

require '../../conection.php';
session_start();

if(isset($_POST['idcredito'], $_POST['idbarriocolonia'], $_POST['observacion'], $_POST['tipo'])){

    $stat = $conn->prepare('call insertar_codigo_direccion(:iduser, :idcredito, :idbarriocolonia, :observacion, :tipo);');

    $stat->bindValue(':iduser', $_SESSION['user'], PDO::PARAM_STR);
    $stat->bindValue(':idcredito', $_POST['idcredito'], PDO::PARAM_STR);
    $stat->bindValue(':idbarriocolonia', $_POST['idbarriocolonia'], PDO::PARAM_STR);
    $stat->bindValue(':observacion', $_POST['observacion'], PDO::PARAM_STR);
    $stat->bindValue(':tipo', $_POST['tipo'], PDO::PARAM_STR);

    if($stat->execute()){
        echo 'true';
    }else{
        echo 'false';
    }

}else{
    echo 'false';
}



?>