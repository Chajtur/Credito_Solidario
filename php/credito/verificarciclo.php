<?php

if(isset($_POST['id'])){
    
    require_once '../conection.php';
    
    $stat = $conn->prepare('select count(*) as cantidad from prestamo where Estado_Credito in ("Desembolsado","Para Desembolso") and identidad = :id');
    $stat->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
    $stat->execute();
    
    $data = $stat->fetch(PDO::FETCH_ASSOC);
    
    if($data['cantidad'] == "0"){
        
        $stat2 = $conn->prepare('select count(*) as cantidad from cartera_consolidada where estatus_prestamo in ("Ingresado","Call Center","Para Control de Calidad","Control de Calidad","Para Coordinacion","Coordinacion","Para Digitacion","Digitacion","Colocacion","Colocado","Devuelto","Para Correccion","Credito Retenido") and identidad = :id');
        $stat2->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
        $stat2->execute();
        
        $reg = $stat2->fetch(PDO::FETCH_ASSOC);

        if($reg['cantidad'] > "0"){

            echo "YA EN SISTEMA";

        }else{

            $stat = $conn->prepare('
            select if((Ciclo is null or Ciclo = ""), if(Monto_Desembolsado <= 5000, 1, if(Monto_Desembolsado <= 10000, 2, 3)), Ciclo) as Ciclo
            from prestamo where identidad = :id and (Ciclo < 10 or ciclo is null or ciclo = "") order by Ciclo DESC limit 1
            ');
            $stat->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
            $stat->execute();

            $result = $stat->fetch(PDO::FETCH_ASSOC);

            echo $result['Ciclo'] + 1;

        }        
        
    }else{

        echo "NO APLICA";
        
    }
    
    
}

?>