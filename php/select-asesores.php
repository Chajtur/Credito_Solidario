<?php

require_once 'conection.php';

if($conn){
    
    $stat = $conn->prepare('select * from gestor');
    $stat->execute();

    $result = $stat->fetchAll();

    foreach($result as $fila){

        echo '<option value="'.$fila['idgestor'].'">'.$fila['nombre'].'</option>';

    }
}


?>