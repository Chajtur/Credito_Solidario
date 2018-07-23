<?php

require_once 'conection.php';

if($conn){
    
    $stat = $conn->prepare('select * from municipio');
    $stat->execute();

    $result = $stat->fetchAll();

    foreach($result as $fila){

        echo '<option value="'.$fila['idDepartamento'].'">'.$fila['nombre'].'</option>';

    }
    
}

?>