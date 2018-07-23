<?php

require '../conection.php';
session_start();
if(isset($_POST['date'])){
    $stat = $conn->prepare('call cuotas_del_dia(:asesor, :date);');
    $stat->bindValue(':asesor', $_SESSION['first_name'].' '.$_SESSION['last_name'], PDO::PARAM_STR);
    $stat->bindValue(':date', $_POST['date'], PDO::PARAM_STR);
    if($stat->execute()){
        $result = $stat->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }else{
        echo 'false';
    }
}

?>