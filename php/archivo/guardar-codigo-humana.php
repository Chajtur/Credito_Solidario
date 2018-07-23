<?php

/**
 * Archivo para crear la caja de humana y agregar en caja los créditos recibidos
 * @param creditos vis post ($_POST['creditos'], arreglo de créditos)
 * @author Rychiv4
 */

require '../conection.php';
session_start();
if(isset($_POST['creditos'])){
    $obj = json_decode($_POST['creditos']);
    try{
        $conn->beginTransaction();
        $stat = $conn->prepare('call crear_caja_humana(:agencia);');
        $stat->bindValue(':agencia', $_SESSION['agencia_gsc'], PDO::PARAM_STR);
        $stat->execute();
        $result = $stat->fetch(PDO::FETCH_NUM);
        $stat->closeCursor();

        $stat = $conn->prepare('call agregar_en_caja(:hash, :codigo);');
        foreach($obj as $hash){
            $stat->bindValue(':hash', $hash, PDO::PARAM_STR);
            $stat->bindValue(':codigo', $result[0], PDO::PARAM_STR);
            $stat->execute();
            $stat->closeCursor();
        }
        $conn->commit();
        error_log('Agencia: '.$_SESSION['agencia_gsc']);
        echo $result[0];
    }catch(PDOException $e){
        $conn->rollBack();
        echo 'false';
    }
}

?>