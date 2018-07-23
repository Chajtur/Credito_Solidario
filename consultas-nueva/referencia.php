<?php

if(isset($_POST['id_credito'])){
    
    require '../php/conection.php';
    $stat = $conn->prepare('call buscar_referencias(:id_credito);');
    $stat->bindValue(':id_credito', $_POST['id_credito'], PDO::PARAM_STR);
    $stat->execute();
    $result = $stat->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($result);
    
}

?>