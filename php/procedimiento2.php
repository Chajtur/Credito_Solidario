<?php

require 'conection.php';

$stat = $conn->prepare('select Numero_Prestamo, Fecha_Desembolso, Monto_Desembolsado, plazo, saldo_capital from tabla_temporal');
$stat->execute();
$result = $stat->fetchAll(PDO::FETCH_ASSOC);

$delete_stat = $conn->prepare('delete a from temp_mora_antiguedad a
where a.numero_prestamo = :numero_prestamo');

$stat_proc = $conn->prepare('select CalcularAntiguedad(:numero_prestamo, :fecha, :monto, :plazo, :saldo)');

$completados = 0;
$conerror = 0;
foreach($result as $fila){
    
    $delete_stat->bindValue(':numero_prestamo', $fila['Numero_Prestamo']);
    $delete_stat->execute();
    
    $stat_proc->bindValue(':numero_prestamo', $fila['Numero_Prestamo'], PDO::PARAM_STR);
    $stat_proc->bindValue(':fecha', $fila['Fecha_Desembolso'], PDO::PARAM_STR);
    $stat_proc->bindValue(':monto', $fila['Monto_Desembolsado'], PDO::PARAM_STR);
    $stat_proc->bindValue(':plazo', $fila['plazo'], PDO::PARAM_STR);
    $stat_proc->bindValue(':saldo', $fila['saldo_capital'], PDO::PARAM_STR);
    
    if($stat_proc->execute()){
        echo $fila['Numero_Prestamo']." completado correctamente.";
        $completados++;
    }else{
        echo $fila['Numero_Prestamo']." con error.";
        $conerror++;
    }

    echo "<br>";

}

echo "<br>";
echo "Se completaron sin errores ".$completados." numeros de prestamo"."<br>";
echo "Se completaron con errores ".$conerror." numeros de prestamo";

?>