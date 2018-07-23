<?php

if(isset($_POST['id'], $_POST['hash'])){
    
    require '../php/conection.php';
    $stat = $conn->prepare('call buscar_aval( :hash, :identidad);');
    $stat->bindValue(':identidad', $_POST['id'], PDO::PARAM_STR);
    $stat->bindValue(':hash', $_POST['hash'], PDO::PARAM_STR);
    $stat->execute();
    $result = $stat->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($result);
    
}

?>