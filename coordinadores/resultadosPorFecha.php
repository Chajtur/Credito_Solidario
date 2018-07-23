<?php 
session_start();
$fecha          = $_POST['fecha'];
$usuario		= $_SESSION['first_name']." ".$_SESSION['last_name'];
// echo "PHP: ".$id_visitado;
if (isset($fecha)) {
	try{
		require "../php/conection.php";

		$stat = $conn->prepare('Select id, fecha, municipio, desembolsos, monto, ciclo from credito_solidario.log_desembolsos where fecha = :fecha and nombre = :usuario');

		$stat->bindValue(':fecha', $fecha, PDO::PARAM_STR);
		$stat->bindValue(':usuario', $usuario, PDO::PARAM_STR);


		if ($stat->execute()) {

			$result = $stat->fetchAll();
			echo json_encode($result);

		}else{
			echo "No se realizo el query";
		}

	}catch(PDOException $e){

		echo $e->getMessage();

	}
}
?>