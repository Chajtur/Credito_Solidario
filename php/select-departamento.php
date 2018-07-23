<?php

require_once 'conection.php';

if($conn){
    
    $stat = $conn->prepare('select * from departamento');
    $stat->execute();

    $result = $stat->fetchAll();

    foreach($result as $fila){

        echo '<option value="'.$fila['iddepartamento'].'">'.$fila['nombre'].'</option>';

    }
    
}


?>