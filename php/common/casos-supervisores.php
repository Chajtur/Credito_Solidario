<?php

if(isset($_GET['obtener'])){

    try{

        require '../conection.php';
        session_start();

        $stat = $conn->prepare('call Obtener_Casos_Cda(:user);');
        $stat->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
        $stat->execute();
        echo json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
    
    }catch(PDOException $e){

        error_log($e->getMessage());
        echo 'false';
        
    }

}

?>