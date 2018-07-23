<?php

require '../../conection.php';
session_start();

$stat = $conn->prepare('call obtener_indicador_direcciones(:iduser);');
$stat->bindValue(':iduser', $_SESSION['user'], PDO::PARAM_STR);
$stat->execute();

$indicadores = $stat->fetch(PDO::FETCH_ASSOC);

echo json_encode($indicadores);

?>