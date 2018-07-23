<?php

require_once 'conection.php';
if($conn){
    $stat = $conn->prepare('select * from tipos_viviendas');
    $stat->execute();

    $result = $stat->fetchAll();

    foreach($result as $fila){

        echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';

    }
}


?>