<?php

require 'conection.php';

$stat = $conn->prepare('select numero_prestamo from mora_antiguedad where15 is null and Mora30 is null and Mora60 is null and Mora90 is null and Mora120 is null and Mora120mas = 0');
$stat->execute();
$result = $stat->fetchAll(PDO::FETCH_ASSOC);

$stat_proc = $conn->prepare('call CalcularMoras(:numero_prestamo)');

$completados = 0;
$conerror = 0;
foreach($result as $fila){

    $stat_proc->bindValue(':numero_prestamo', $fila['numero_prestamo'], PDO::PARAM_STR);
    if($stat_proc->execute()){
        echo $fila['numero_prestamo']." completado correctamente.";
        $completados++;
    }else{
        echo $fila['numero_prestamo']." con error.";
        $conerror++;
    }

    echo "<br>";

}

echo "<br>";
echo "Se completaron sin errores ".$completados." numeros de prestamo";
echo "Se completaron con errores ".$conerror." numeros de prestamo";

?>