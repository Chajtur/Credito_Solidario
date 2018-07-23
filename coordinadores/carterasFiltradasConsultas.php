<?php 
	session_start();
    $user = $_SESSION['user'];
    /*foreach($numeros_prestamos as $prestamo){
                echo $prestamo;
            }
    echo $gestor;*/

    

	if (isset($_POST['supervisor'])) {
        $supervisor = $_POST['supervisor'];
        $idSupervisor = $_POST['id'];
        
        try{
			 require "../php/conection.php";
            
            $correcto = false;
            
            $stat = $conn->prepare('select nombre, id
            from gsc where tipoEmpleado = "Gestor" and parent = :id');
            
                $stat->bindValue(':id', $idSupervisor, PDO::PARAM_STR);
                
                if ($stat->execute()) {
				    $correcto = true;
                    $gestores = $stat->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                } else {
                    $correcto = false;
                    return false;
                }
            echo json_encode($gestores);

		}catch(PDOException $e){
	        echo $e->getMessage();
    	}
    }


    if (isset($_POST['id_supervisor_cartera'])) {
        //$supervisor_list = $_POST['supervisor_list'];
        $id_supervisor_list = $_POST['id_supervisor_cartera'];
        //$asesor_list = $_POST['asesor_list'];
        
        try{
			 require "../php/conection.php";
            
            $correcto = false;
            
            if($id_supervisor_list != ""){
                $stat = $conn->prepare('select b.id, a.gestor, count(*) as creditos, sum(a.Monto_Desembolsado) as montoDesembolsado, sum(a.saldo_capital) as saldoCapital, sum(if(a.capital_mora>0,capital_mora,0)) as capitalMora, (sum(a.capital_mora)/sum(a.saldo_capital))*100 as porcentajeMora 
                                        from prestamo a, gsc b 
                                        where a.Gestor = b.nombre 
                                        and b.parent = :supervisorid 
                                        and Estado_Credito = "desembolsado" 
                                        group by Gestor 
                                        order by (sum(a.capital_mora)/sum(a.saldo_capital)) desc');
            
                $stat->bindValue(':supervisorid', $id_supervisor_list, PDO::PARAM_STR);
                
                if ($stat->execute()) {
				    $correcto = true;
                    $gestores = $stat->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                } else {
                    $correcto = false;
                    return false;
                }
                echo json_encode($gestores);
            } /*else {
                
            }*/
            
            

		}catch(PDOException $e){
	        echo $e->getMessage();
    	}
    }

    if (isset($_POST['nombre_asesor_cartera'])) {
        $nombre_asesor_list = $_POST['nombre_asesor_cartera'];
        
        try{
			 require "../php/conection.php";
            
            $correcto = false;
            
            
            $stat = $conn->prepare('SELECT Identidad, Nombre_Completo, saldo_capital, capital_mora, (capital_mora/saldo_capital)*100 as mora, Direccion, Negocio, Gestor, Numero_Prestamo
                                        FROM prestamo 
                                        WHERE Gestor = :nombreasesor
                                        and Estado_Credito = "desembolsado" order by (capital_mora/saldo_capital) desc');
            
                $stat->bindValue(':nombreasesor', $nombre_asesor_list, PDO::PARAM_STR);
                
                if ($stat->execute()) {
				    $correcto = true;
                    $gestoresCreditos = $stat->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                } else {
                    $correcto = false;
                    return false;
                }
            echo json_encode($gestoresCreditos);
            
            
            
        }catch(PDOException $e){
	        echo $e->getMessage();
    	}
    }

?>