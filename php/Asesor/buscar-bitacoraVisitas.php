<?php 
$id_visitado = $_POST['id_visitado'];
// echo "PHP: ".$id_visitado;
if (isset($id_visitado)) {
	try{
		require "../conection.php";

		$stat = $conn->prepare(
			'SELECT a.fecha, a.hora, a.tipo_visita, b.nombre
			FROM bitacora_visitas a INNER JOIN gestor b 
			ON a.idusuario = b.idgestor
			WHERE a.identidad = :id_visitado 
			AND a.fecha = (select max(fecha) from bitacora_visitas where identidad = :id_visitado)
			AND a.hora = (select max(hora) from bitacora_visitas where identidad = :id_visitado)');

		$stat->bindValue(':id_visitado', $id_visitado, PDO::PARAM_STR);


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