<?php

if(isset($_POST['id'])){
    
    require_once '../conection.php';
    
    $stat = $conn->prepare('select count(*) as cantidad from prestamo where Estado_Credito = "Desembolsado" and identidad = :id');
    $stat->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
    $stat->execute();
    
    $data = $stat->fetch(PDO::FETCH_ASSOC);
    
    if($data['cantidad'] == "0"){
        
        $stat = $conn->prepare('select if((Ciclo is null or Ciclo = ""), if(Monto_Desembolsado <= 5000, 1, if(Monto_Desembolsado <= 10000, 2, 3)), Ciclo) as Ciclo, Monto_Desembolsado as ciclo from prestamo where identidad = :id order by Numero_Linea DESC limit 1');
        $stat->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
        $stat->execute();

        $result = $stat->fetch(PDO::FETCH_ASSOC);

        echo $result['Ciclo'] + 1;
        
    }else{
        
        //echo $data['cantidad'];
        echo "NO APLICA";
        
    }
    
    
}

?>