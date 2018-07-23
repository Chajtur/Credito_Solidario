<?php

if(isset($_POST['consulta']) && isset($_POST['parametro'])){
    
    try{
        
        require "../php/conection.php";
        session_start();

        if($_POST['consulta'] == 'general'){

            $stat = $conn->prepare('select tipoEmpleado from gsc where id = :user');
            $stat->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
            $stat->execute();
            $data = $stat->fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['tipoEmpleado'] = $data['tipoEmpleado'];

            if(in_array($_SESSION['designation'], array(18, 81, 87))){
                $sql = 'call buscar_beneficiario_ciudad_mujer(:parametro);';
            }else{
                $sql = (($data['tipoEmpleado'] == 'Gestor' || $data['tipoEmpleado'] == 'Supervisor') ? 'call buscar_beneficiario_asesores(:parametro);' : 'call buscar_beneficiario(:parametro);');
            }
            

            $stat = $conn->prepare($sql);
            $stat->bindValue(':parametro', $_POST['parametro'], PDO::PARAM_STR);
            $stat->execute();
            $data = $stat->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($data);
            
        }

        if($_POST['consulta'] == 'censo'){

            $parametro = $_POST['parametro'];
            $parametro = str_replace('-', '', $parametro);
            $es_numerico = is_numeric($parametro);
            
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