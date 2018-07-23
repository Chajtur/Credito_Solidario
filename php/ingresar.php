<?php

try{
    
    require 'conection.php';
    
    if($conn->beginTransaction()){
        
        $stat = $conn->prepare('select nombre, nacimiento, genero, correo, telefono, celular, identidad, direccion, ciudad, fechainicio, fechafinal, salario, usuario, passwordbcrypt from personal_cshrm_2');
        $stat->execute();
        $personas = $stat->fetchAll();
        
        foreach($personas as $persona){
            
            echo $persona['nombre']."<br>";
            
            $nombre_array = explode(" ", $persona['nombre']);
            switch(sizeof($nombre_array)){
                case 2:
                    $first_name = $nombre_array[0];
                    $last_name = $nombre_array[1];
                    break;
                case 3:
                    $first_name = $nombre_array[0] . " " . $nombre_array[1];
                    $last_name = $nombre_array[2];
                    break;
                case 4:
                    $first_name = $nombre_array[0] . " " . $nombre_array[1];
                    $last_name = $nombre_array[2] . " " . $nombre_array[3];
                    break;
                case 5:
                    $first_name = $nombre_array[0] . " " . $nombre_array[1] . " " . $nombre_array[2];
                    $last_name = $nombre_array[3] . " " . $nombre_array[4];
                    break;
                    
            }
            
            $query = 'insert into users(first_name, last_name, identidad, birthday, gender, email, telephone, cellphone, local_address, permanent_address, employee_id, username, password, department_id, designation_item_id, role_id) values("'.$first_name.'", "'.$last_name.'", "'.$persona['identidad'].'", "'.$persona['nacimiento'].'", "'.$persona['genero'].'", "'.$persona['correo'].'", "'.$persona['telefono'].'", "'.$persona['celular'].'", "'.$persona['direccion'].'", "'.$persona['ciudad'].'", "'.$persona['usuario'].'", "'.$persona['usuario'].'", "'.$persona['passwordbcrypt'].'", 8, 11, 2)';
            $stat_larahrm = $conn2->prepare($query);
            
            if(!$stat_larahrm->execute()){
                
                echo "No se ejecutó";
                
            }
            
        }
        echo $query;
        if($conn->commit()){
            
            echo "Completado";
            
        }
        
    }else{
        
        echo "No inició la transacción";
        
    }
    
}catch(PDOException $e){
    
    if($conn->rollback()){
        
        echo "Transacción cancelada, Error: ".$e->getMessage();
        
    }
    
}

?>