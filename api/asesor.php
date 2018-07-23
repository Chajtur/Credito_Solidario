<?php

/**
 * Archivo que devuelve el nombre del gestor en base un id recibido
 * @return JSON Devuelve un objeto con el nombre del gestor
 * @author Rychiv4
 */

if(isset($_POST['id'])){
    
    $id = $_POST['id'];
    
    try{
        
        require '../php/conection.php';
        
        $stat = $conn->prepare('select nombre from gestor where idgestor = :id');
        $stat->bindValue(':id', $id, PDO::PARAM_STR);
        $stat->execute();
        
        $result = $stat->fetchAll();
        
        echo json_encode($result[0]);
        
    }catch(PDOException $e){
        
        echo $e->getMessage();
        
    }
    
}

?>