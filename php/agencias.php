<?php 

require 'conection.php';

$stat = $conn->prepare('select * from agencia');
$stat->execute();
$agencias = $stat->fetchAll(PDO::FETCH_ASSOC);

?>