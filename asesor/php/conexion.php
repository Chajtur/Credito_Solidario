<?php

try{
    $conn = new PDO('mysql:dbname=credito_solidario;host=181.210.15.138', 'ricardo', 'icsric2016');
}catch(PDOException $e){
    $conn = null;
}

?>