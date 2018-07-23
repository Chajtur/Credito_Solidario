<?php 
	session_start();
	/*$usuario		= $_SESSION['user'];*/
	$usuario		= $_POST['user'];
	/*$usuario		= "C041";*/
	$lat            = $_POST['latitude'];
	$long           = $_POST['longitude'];
	$id             = $_POST['identidad'];
	$obs            = $_POST['observacion'];
	$tipo_visita    = $_POST['tipo_visita'];
	$tipo_direccion = $_POST['tipo_direccion'];

	//Si es visita, tipo_visita = 1
	//Si es levantamiento, tipo_visita = 0
	if ($tipo_visita=="socializacion") {
		$tipo_visita = 0;
	}
	if ($tipo_visita=="levantamiento") {
		$tipo_visita = 1;
	}	
	if ($tipo_visita=="asesoria") {
		$tipo_visita = 2;
	}	
	if ($tipo_visita=="seguimiento") {
		$tipo_visita = 3;
	}	
	if ($tipo_visita=="recuperacion") {
		$tipo_visita = 4;
	}
	//Si es negocio, tipo_direccion = 1
	//Si es domicilio, tipo_direccion = 0
	if ($tipo_direccion == "negocio") {
		$tipo_direccion = 1;
	} else {
		$tipo_direccion = 0;
	}
	
    if ($obs == "+ Agregar Observación"){
        $obs = "";
    }

	if (isset($_POST['identidad'])) {
		try{
			 require "../conection.php";
        
        	$stat = $conn->prepare('insert into bitacora_visitas(idusuario, identidad, latitud, longitud, tipo_visita, tipo_direccion, observacion, fecha, hora)
									values(:usuario, :identidad, :latitude, :longitude, :tipo_visita, :tipo_direccion, :observacion, current_date(), concat(hour(current_timestamp()), ":", minute(current_timestamp()), ":", second(current_timestamp())))');
            
            $stat->bindValue(':usuario', $usuario, PDO::PARAM_STR);
            $stat->bindValue(':identidad', $_POST['identidad'], PDO::PARAM_STR);
            $stat->bindValue(':latitude', $_POST['latitude'], PDO::PARAM_STR);
            $stat->bindValue(':longitude', $_POST['longitude'], PDO::PARAM_STR);
            $stat->bindValue(':tipo_visita', $tipo_visita, PDO::PARAM_INT);
            $stat->bindValue(':tipo_direccion', $tipo_direccion, PDO::PARAM_INT);
            $stat->bindValue(':observacion', $obs, PDO::PARAM_STR);

            if ($stat->execute()) {
            	$data =  "Latitude: " . $lat . " Longitude: " . $long . 
		        "\nObservación: " . $obs . 
		        "\nIdentidad: " . $id .
		        "\nTipo visita: " . $tipo_visita .
		        "\nTipo de Direccion: " . $tipo_direccion .
		        "\nPHP";
			 
				echo $data;
            }

		}catch(PDOException $e){

	        echo $e->getMessage();

    	}
	}

		


?>

