<?php 
	session_start();
	$usuario		= $_SESSION['first_name']." ".$_SESSION['last_name'];
	//$usuario		           = "Denis Pastor Garcia Canales";
	$municipio                 = $_POST['municipio'];
	$ciclo                     = $_POST['ciclo'];
	$cantidadCreditos          = $_POST['cantidadCreditos'];
	$montoCreditos             = $_POST['montoCreditos'];
	$fecha                     = $_POST['fecha'];


	if (isset($_POST['fecha'])) {
		try{
			 require "../php/conection.php";
        
        	$stat = $conn->prepare('insert into credito_solidario.log_desembolsos (fecha, nombre, municipio, desembolsos, monto, ciclo) values (:fecha, :usuario, :municipio, :cantidadCreditos, :montoCreditos, :ciclo)');
            
            $stat->bindValue(':usuario', $usuario, PDO::PARAM_STR);
            $stat->bindValue(':municipio', $_POST['municipio'], PDO::PARAM_STR);
            $stat->bindValue(':ciclo', $_POST['ciclo'], PDO::PARAM_STR);
            $stat->bindValue(':cantidadCreditos', $_POST['cantidadCreditos'], PDO::PARAM_STR);
            $stat->bindValue(':montoCreditos', $_POST['montoCreditos'], PDO::PARAM_STR);
            $stat->bindValue(':fecha', $_POST['fecha'], PDO::PARAM_STR);

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

