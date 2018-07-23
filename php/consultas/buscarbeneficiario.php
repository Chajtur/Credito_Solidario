<?php

if(isset($_POST['data'])){
    
    try{
        
        $data = $_POST['data'];
        
        require "../conection.php";
        
        $command_nombre = 'select a.fecha_colocacion, a.identidad, a.Nombre, a.ciclo, Format(a.Monto_Autorizado,2), a.Estatus_Prestamo, a.Gestor, a.Fecha_Desembolso, b.nombre, fecha_ultimo_pago, cuotas_vencidas, Format(capital_mora,2), a.documento from cartera_consolidada a, ifi b where if(a.ifi is null,0,a.ifi) = b.id and a.Nombre like :nombre limit 200';
        $command_identidad = 'select a.fecha_colocacion, a.identidad, a.Nombre, a.ciclo, Format(a.Monto_Autorizado,2), a.Estatus_Prestamo, a.Gestor, a.Fecha_Desembolso, b.nombre, fecha_ultimo_pago, cuotas_vencidas, Format(capital_mora,2), a.documento from cartera_consolidada a, ifi b where if(a.ifi is null,0,a.ifi) = b.id and a.identidad = :identidad limit 200';
        
        if(is_numeric($data)){
            
            $stat = $conn->prepare($command_identidad);
            $stat->bindValue(':identidad', $data, PDO::PARAM_STR);
            
        }else{
            
            $stat = $conn->prepare($command_nombre);
            $stat->bindValue(':nombre', "%".$data."%", PDO::PARAM_STR);
            
        }
        
        $stat->execute();
        $result = $stat->fetchAll();
        
        $array['data'] = $result;
        
        echo json_encode($array);
        
    }catch(PDOException $e){
        
        echo $e->getMessage();
        
    }
    
}   
    
    

?>