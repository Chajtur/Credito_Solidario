<?php 
	session_start();
    $user = $_SESSION['user'];
    /*foreach($numeros_prestamos as $prestamo){
                echo $prestamo;
            }
    echo $gestor;*/

    

	if (isset($_POST['data'])) {
        
        $numeros_prestamos = json_decode($_POST['data']);
        $gestor = $_POST['gestor'];
        
		try{
			 require "../php/conection.php";
            
            $correcto = false;
            
            foreach($numeros_prestamos as $prestamo){
                
                /*$stat = $conn->prepare('update prestamo 
                set Gestor = :gestor where Numero_Prestamo = :prestamo');
            
                $stat->bindValue(':gestor', $gestor, PDO::PARAM_STR);
                $stat->bindValue(':prestamo', $prestamo, PDO::PARAM_STR);
                */
                /*if ($stat->execute()) {
				    $correcto = true;
                    
                     $sql = $conn->prepare('update cartera_consolidada 
                    set Gestor = :gestor where Prestamo_Numero = :prestamo');
            
                    $sql->bindValue(':gestor', $gestor, PDO::PARAM_STR);
                    $sql->bindValue(':prestamo', $prestamo, PDO::PARAM_STR);
                    $sql->execute();
                */    
                    //SLECCIONAR EL ANTIGUO ASESOR POR CADA PRESTAMO
                    $antiguoAsesor = $conn->prepare('select gestor
                                                    from prestamo
                                                    where Numero_Prestamo = :prestamo');
                    $antiguoAsesor->bindValue(':prestamo', $prestamo, PDO::PARAM_STR);
                    $antiguoAsesor->execute();
                    $asesorAntiguo = $antiguoAsesor->fetch();
                    
                    //echo $asesorAntiguo['antiguoGestor'];
                    
                    //INSERTAR CAMBIOS EN LA BITACORA DE SUPERVISORES
                    $bitacora = $conn->prepare('insert into bitacora_supervisores (iduser, numero_prestamo, asesor_nuevo, asesor_viejo)
                                                values (:user, :prestamo, :gestor, :antiguoGestor)');
                    $bitacora->bindValue(':user', $user, PDO::PARAM_STR);
                    $bitacora->bindValue(':prestamo', $prestamo, PDO::PARAM_STR);
                    $bitacora->bindValue(':gestor', $gestor, PDO::PARAM_STR);
                    $bitacora->bindValue(':antiguoGestor', $asesorAntiguo['gestor'], PDO::PARAM_STR);
                    $bitacora->execute();
                /*} else {
                    $correcto = false;
                    return false;
                }*/
                
            }
            
            echo $correcto;

		}catch(PDOException $e){

	        echo $e->getMessage();

    	}
	}

		


?>