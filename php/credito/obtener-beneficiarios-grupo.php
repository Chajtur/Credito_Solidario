<?php

if(isset($_POST['hash'])){
    
    try{
        require_once '../conection.php';
    
        $stat = $conn->prepare('select * from cartera_consolidada where grupo_solidario_hash = :hash');
        $stat->bindValue(':hash', $_POST['hash'], PDO::PARAM_STR);
        $stat->execute();
        $result = $stat->fetchAll();

        echo json_encode($result);
    }catch(PDOException $e){
        echo "Error, actualice la pagina";
    }
    
    
}

?>