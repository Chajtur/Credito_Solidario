<?php

if(isset($_POST['consulta']) && isset($_POST['parametro'])){
    
    try{
        
        require "../php/conection.php";
        
        $parametro = $_POST['parametro'];
        $parametro = str_replace('-', '', $parametro);
        $es_numerico = is_numeric($parametro);

        if($_POST['consulta'] == 'general'){

            //Codigo para la consulta general
            
            $command_nombre = 'select a.identidad, a.Nombre, a.ciclo, Format(a.Monto_Autorizado,2) as monto_autorizado, a.Estatus_Prestamo, a.Gestor, a.Fecha_Desembolso, b.nombre as nombre_ifi, fecha_ultimo_pago, cuotas_vencidas, Format(capital_mora,2) as capital_mora, a.documento from cartera_consolidada a, ifi b where if(a.ifi is null,0,a.ifi) = b.id and a.Nombre like :nombre limit 200';
            $command_identidad = 'select a.identidad, a.Nombre, a.sexo, a.ciclo, Format(a.Monto_Autorizado,2) as monto_autorizado, a.Estatus_Prestamo, a.Gestor, a.Fecha_Desembolso, b.nombre as nombre_ifi, fecha_ultimo_pago, cuotas_vencidas, Format(capital_mora,2) as capital_mora, a.documento from cartera_consolidada a, ifi b where if(a.ifi is null,0,a.ifi) = b.id and a.identidad = :identidad limit 200';
            
            if($es_numerico){
                
                $stat = $conn->prepare($command_identidad);
                $stat->bindValue(':identidad', $parametro, PDO::PARAM_STR);

            }else{

                $stat = $conn->prepare($command_nombre);
                $stat->bindValue(':nombre', "%".$parametro."%", PDO::PARAM_STR);

            }

            $stat->execute();
            
            $data = array();
            
            $cantidad = 0;
            
            while($result = $stat->fetch(PDO::FETCH_ASSOC)){
                
                $data[] = $result;
                $cantidad++;
                
            }
        
            echo json_encode($data);

        }

        if($_POST['consulta'] == 'censo'){

            //Codigo para la consulta censo

            $command_nombre = 'select a.primerNombre, a.segundoNombre, a.primerApellido, a.segundoApellido, a.identidad, date(a.fechaNacimiento) as fechaNacimiento, if(a.codigoSexo=1,"M","F") as sexo from censo a where concat_ws(" ", primerNombre, segundoNombre, primerApellido, segundoApellido) like :nombre';
            $command_identidad = 'select a.primerNombre, a.segundoNombre, a.primerApellido, a.segundoApellido, a.identidad, date(a.fechaNacimiento) as fechaNacimiento, if(a.codigoSexo=1,"M","F") as sexo from censo a where a.identidad = :identidad';
            
            if($es_numerico){
                
                $stat = $conn3->prepare($command_identidad);
                $stat->bindValue(':identidad', $parametro, PDO::PARAM_STR);
                
            }else{
                
                $val = str_replace(" ", "%", $parametro);
                $stat = $conn3->prepare($command_nombre);
                $stat->bindValue(':nombre', "%".$val."%", PDO::PARAM_STR);
                
            }
            
            $stat->execute();
            
            $data = array();
            
            $cantidad = 0;
            
            while($result = $stat->fetch(PDO::FETCH_ASSOC)){
                
                $data[] = $result;
                $cantidad++;
                
            }
        
            echo json_encode($data);
            
        }
        
    }catch(PDOException $e){
        
        echo $e->getCode();
        
    }
    
}else{
    echo "nada";
}

?>