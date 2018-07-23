<?php

if(isset($_POST['palabra_clave'])){

    require '../conection.php';

    $stat = $conn->prepare('call buscar_beneficiario(:palabra);');
    $stat->bindValue(':palabra', $_POST['palabra_clave'], PDO::PARAM_STR);
    $stat->execute();

    $result = $stat->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

}

    

?>