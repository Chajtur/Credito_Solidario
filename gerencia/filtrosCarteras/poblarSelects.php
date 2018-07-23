<?php 
	session_start();
    $user = $_SESSION['user'];
    /*foreach($numeros_prestamos as $prestamo){
                echo $prestamo;
            }
    echo $gestor;*/

//OBTENER LISTA DE SUPERVISORES DEL COORDINADOR PARA CARGAR EL SELECT2 DE SUPERVISORES
    if(isset($_POST['id_coordinador_list'])){
        $coordinador_id = $_POST['id_coordinador_list'];
        
        try{
			 require "../../php/conection.php";
            
            $correcto = false;
            
            $getSupervisores = $conn->prepare('select nombre, id from gsc where tipoEmpleado = "Supervisor" and parent = :user');
            $getSupervisores->bindValue(':user', $coordinador_id, PDO::PARAM_STR);
            
            if ($getSupervisores->execute()) {
				    $correcto = true;
                    $supervisoresCreditos = $getSupervisores->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                } else {
                    $correcto = false;
                    return false;
                }
            
            echo json_encode($supervisoresCreditos);
            
            
            }catch(PDOException $e){
	        echo $e->getMessage();
    	}
    }

//OBTENER LISTA DE ASESORES DEL COORDINADOR PARA CARGAR EL SELECT2 DE ASESORES
    if(isset($_POST['id_coordinador_list_asesores'])){
        $coordinador_id_list_asesores = $_POST['id_coordinador_list_asesores'];
        
        try{
			 require "../../php/conection.php";
            
            $correcto = false;
            
            $getAsesores = $conn->prepare('
            select a.nombre from gsc a, gsc b
            where b.parent = :user
            and a.parent = b.id and a.tipoEmpleado = "Gestor"
            ');
            $getAsesores->bindValue(':user', $coordinador_id_list_asesores, PDO::PARAM_STR);
            
            if ($getAsesores->execute()) {
				    $correcto = true;
                    $AsesoresList = $getAsesores->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                } else {
                    $correcto = false;
                    return false;
                }
            
            echo json_encode($AsesoresList);
            
            
            }catch(PDOException $e){
	        echo $e->getMessage();
    	}
    }

//OBTENER CARTERA DE SUPERVISORES DEL COORDINADOR PARA MOSTRAS EN LA LISTA DE LA TABLA
    if(isset($_POST['id_coordinador_cartera'])){
        $coordinador_id_cartera = $_POST['id_coordinador_cartera'];
        
        try{
			 require "../../php/conection.php";
            
            $correcto = false;
            
            $getCarteraCoordinador = $conn->prepare('
            select b.id, a.Supervisor, count(*) as creditos, 
            (select count(*) from prestamo c, gsc d where c.Supervisor = d.nombre and d.id = b.id and c.ciclo = "1" and Estado_Credito = "desembolsado") as cantidad_ciclo1,
            (select count(*) from prestamo c, gsc d where c.Supervisor = d.nombre and d.id = b.id and c.ciclo = "2" and Estado_Credito = "desembolsado") as cantidad_ciclo2,
            (select count(*) from prestamo c, gsc d where c.Supervisor = d.nombre and d.id = b.id and c.ciclo = "3" and Estado_Credito = "desembolsado") as cantidad_ciclo3,
            sum(a.Monto_Desembolsado) as montoDesembolsado, 
            sum(a.saldo_capital) as saldoCapital, sum(if(a.capital_mora>0,capital_mora,0)) 
            as capitalMora, (sum(a.capital_mora)/sum(a.saldo_capital))*100 as porcentajeMora, b.agencia
            from prestamo a, gsc b 
            where a.Supervisor = b.nombre 
            and b.parent = :user
            and Estado_Credito = "desembolsado"
            and tipoEmpleado = "Supervisor"
            group by Supervisor 
            order by porcentajeMora desc
            ');
            $getCarteraCoordinador->bindValue(':user', $coordinador_id_cartera, PDO::PARAM_STR);
            
            if ($getCarteraCoordinador->execute()) {
				    $correcto = true;
                    $supervisoresCarteras = $getCarteraCoordinador->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                } else {
                    $correcto = false;
                    return false;
                }
            
            echo json_encode($supervisoresCarteras);
            
            
        }catch(PDOException $e){
	        echo $e->getMessage();
    	}
    }


//OBTENER CARTERA DE ASESORES DEL COORDINADOR (CUANDO EL COORDINAOR NO TENGA SUPERVISOR) PARA MOSTRAR EN LA LISTA DE LA TABLA
if(isset($_POST['id_coordinador_cartera_asesores'])){

        $coordinador_id_cartera_asesores = $_POST['id_coordinador_cartera_asesores'];
        
        try{
			 require "../../php/conection.php";
            
            $correcto = false;
            //echo $coordinador_id_cartera_asesores;
            
            $getCarteraAsesores = $conn->prepare('
            select a.gestor, count(a.Numero_Prestamo) as creditos, 
            sum(a.Monto_Desembolsado) as montoDesembolsado, sum(a.saldo_capital) as saldoCapital, 
            sum(if(a.capital_mora>0,capital_mora,0)) as capitalMora, 
            (sum(a.capital_mora)/sum(a.saldo_capital))*100 as porcentajeMora, b.agencia
            from gsc b, prestamo a
            where b.parent = :user
            and b.tipoEmpleado = "Gestor" and a.Estado_Credito = "desembolsado" and a.Gestor = b.nombre
            group by a.gestor
            order by (sum(a.capital_mora)/sum(a.saldo_capital)) desc
            ');
            $getCarteraAsesores->bindValue(':user', $coordinador_id_cartera_asesores, PDO::PARAM_STR);
            
            if ($getCarteraAsesores->execute()) {
				    $correcto = true;
                    $AsesoresCartera = $getCarteraAsesores->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $correcto = false;
                return false;
            }
            
            echo json_encode($AsesoresCartera);
            
        }catch(PDOException $e){
	        echo $e->getMessage();
    	}
    }

    //OBTENER LISTA DE ASESORES DEL SUPERVISOR SELECCIONADO PARA CARGAR EL SELECT2 DE ASESORES
    if(isset($_POST['id_supervisor_list'])){
        $supervisor_id = $_POST['id_supervisor_list'];
        
        try{
			 require "../../php/conection.php";
            
            $correcto = false;
            
            $getGestores = $conn->prepare('select nombre, id from gsc where tipoEmpleado = "Gestor" and parent = :user');
            $getGestores->bindValue(':user', $supervisor_id, PDO::PARAM_STR);
            
            if ($getGestores->execute()) {
				    $correcto = true;
                    $gestoresCreditos = $getGestores->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                } else {
                    $correcto = false;
                    return false;
                }
            
            echo json_encode($gestoresCreditos);
            
            
            }catch(PDOException $e){
	        echo $e->getMessage();
    	}
    }

//OBTENER CARTERA DEL SUPERVISOR SELECCIONADO PARA CARGAR EN LA LISTA DE LA TABLA
    if(isset($_POST['id_supervisor_cartera'])){
        $supervisor_id_cartera = $_POST['id_supervisor_cartera'];
        
        try{
			 require "../../php/conection.php";
            
            $correcto = false;
            
            $getCarteraSupervisor = $conn->prepare('
            select b.id, a.gestor, count(*) as creditos, 
            (select count(*) from prestamo c, gsc d where c.Gestor = d.nombre and d.id = b.id and c.ciclo = "1" and Estado_Credito = "desembolsado") as cantidad_ciclo1,
            (select count(*) from prestamo c, gsc d where c.Gestor = d.nombre and d.id = b.id and c.ciclo = "2" and Estado_Credito = "desembolsado") as cantidad_ciclo2,
            (select count(*) from prestamo c, gsc d where c.Gestor = d.nombre and d.id = b.id and c.ciclo = "3" and Estado_Credito = "desembolsado") as cantidad_ciclo3,
            sum(a.Monto_Desembolsado) as montoDesembolsado, sum(a.saldo_capital) as saldoCapital, sum(if(a.capital_mora>0,capital_mora,0)) as capitalMora, 
            (sum(a.capital_mora)/sum(a.saldo_capital))*100 as porcentajeMora , b.agencia
            from prestamo a, gsc b 
            where a.Gestor = b.nombre 
            and b.parent = :user
            and Estado_Credito = "desembolsado" 
            group by Gestor 
            order by (sum(a.capital_mora)/sum(a.saldo_capital)) desc
            ');
            $getCarteraSupervisor->bindValue(':user', $supervisor_id_cartera, PDO::PARAM_STR);
            
            if ($getCarteraSupervisor->execute()) {
				    $correcto = true;
                    $gestoresCarteras = $getCarteraSupervisor->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                } else {
                    $correcto = false;
                    return false;
                }
            
            echo json_encode($gestoresCarteras);
            
            
        }catch(PDOException $e){
	        echo $e->getMessage();
    	}
    }
    

//OBTENER CARTERA DEL ASESOR SELECCIONADO EN EL SELECT2 DE ASESORES PARA MOSTRAR EN LA LISTA DE LA TABLA
	if (isset($_POST['asesor_list'])) {
        
        //$coordinador_list = $_POST['coordinador_list'];
        //$supervisor_list = $_POST['supervisor_list'];
        $asesor_list = $_POST['asesor_list'];
        
        try{
			 require "../../php/conection.php";
            
            $correcto = false;
            
            /*if(){}*/
            
            $stat = $conn->prepare('SELECT Identidad, Nombre_Completo, saldo_capital, capital_mora, (capital_mora/saldo_capital)*100 as mora, Direccion, Negocio, Gestor, Numero_Prestamo
                                        FROM prestamo 
                                        WHERE Gestor = :nombreasesor
                                        and Estado_Credito = "desembolsado" order by (capital_mora/saldo_capital) desc');
            
                $stat->bindValue(':nombreasesor', $asesor_list, PDO::PARAM_STR);
                
                if ($stat->execute()) {
				    $correcto = true;
                    $gestoresCreditos = $stat->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                } else {
                    $correcto = false;
                    return false;
                }
            //var_dump($gestoresCreditos);
            echo json_encode($gestoresCreditos);

		}catch(PDOException $e){
	        echo $e->getMessage();
    	}
    }


?>