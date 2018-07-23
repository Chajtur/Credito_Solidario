<?php 
session_start();
$id          = $_POST['id'];/*
$usuario		= $_SESSION['first_name']." ".$_SESSION['last_name'];*/
// echo "PHP: ".$id_visitado;
if (isset($id)) {
	try{
		require "../php/conection.php";

		$stat = $conn->prepare('delete from credito_solidario.log_desembolsos where id = :id');

		$stat->bindValue(':id', $id, PDO::PARAM_STR);

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