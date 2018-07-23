<?php

if(isset($_POST['search'])){

    require "../conection.php";

    $stat = $conn->prepare('call buscar_beneficiario_digitacion(:value);');
    $stat->bindValue(':value', $_POST['search'], PDO::PARAM_STR);
    if($stat->execute()){
        echo json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
    }else{
        echo 'No se pudo ejecutar';
    }

}

?>