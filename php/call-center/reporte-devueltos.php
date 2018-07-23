<?php

require '../conection.php';

$stat = $conn->prepare('select distinct id_credito from bitacora_creditos where razon = "Devuelto con correcciones" and id_usuario = "A039" order by id_credito');
$stat->execute();

$ids = $stat->fetchAll(PDO::FETCH_ASSOC);

foreach($ids as $id){

    

};

?>