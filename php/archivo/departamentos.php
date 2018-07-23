<?php

/**
 * Archivo que captura los departamentos de la tabla departamento
 * @param none
 * @author Rychiv4
 */

require '../conection.php';

try{
    $stat = $conn->prepare('select iddepartamento as value, UC_FIRST(nombre) as text from departamento');
    $stat->execute();
    echo json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
}catch(PDOException $e){
    echo false;
}


?>