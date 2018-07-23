<?php 
	session_start();
	$usuario		= $_SESSION['first_name']." ".$_SESSION['last_name'];
	//$usuario		           = "Denis Pastor Garcia Canales";
    $id                        = $_POST['id'];
	$fecha                     = $_POST['fecha'];
	$municipio                 = $_POST['municipio'];
	$ciclo                     = $_POST['ciclo'];
	$cantidadCreditos          = $_POST['cantidadCreditos'];
	$montoCreditos             = $_POST['montoCreditos'];


	if (isset($_POST['id'])) {
		try{
			 require "../php/conection.php";
        
        	$stat = $conn->prepare('update credito_solidario.log_desembolsos set ciclo = :ciclo, desembolsos = :cantidadCreditos, monto = :montoCreditos where id = :id');
            
            $stat->bindValue(':ciclo', $_POST['ciclo'], PDO::PARAM_STR);
            $stat->bindValue(':cantidadCreditos', $_POST['cantidadCreditos'], PDO::PARAM_STR);
            $stat->bindValue(':montoCreditos', $_POST['montoCreditos'], PDO::PARAM_STR);
            $stat->bindValue(':id', $_POST['id'], PDO::PARAM_STR);

            if ($stat->execute()) {
				echo true;
            } else {
                echo false;
            }

		}catch(PDOException $e){

	        echo $e->getMessage();

    	}
	}

		


?>