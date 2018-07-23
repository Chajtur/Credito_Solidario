<?php

require_once 'conection.php';
if($conn){
    $stat = $conn->prepare('select * from ifi');
    $stat->execute();

    $result = $stat->fetchAll();

    foreach($result as $fila){

        echo '<option value="'.$fila['id'].'">'.$fila['Nombre'].'</option>';

    }
}


?>