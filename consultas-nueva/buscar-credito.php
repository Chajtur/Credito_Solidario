<?php

if(isset($_POST['value'])){

    require "../php/conection.php";

    $stat = $conn->prepare('call buscar_beneficiario(:value);');
    $stat->bindValue(':value', $_POST['value'], PDO::PARAM_STR);
    if($stat->execute()){
        echo json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
    }else{
        echo 'No se pudo ejecutar';
    }

}

?>