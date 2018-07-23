<?php

if (isset($_POST['tag'])) {
		try {
			$conn = require_once 'connect.php';
			//$sql = "SELECT * FROM datos";
			$result = $conn->prepare('call prueba_resumen_datatable()') or die ($sql);
			if (!$result->execute()) return false;
			if ($result->rowCount() > 0) {
				$json = array();
				while ($row = $result->fetch()) {
					$json[] = array(
						'Departamento' => $row['Departamento'],
						'Creditos' =>$row['Creditos'],
						'Morosos' => $row['Morosos'],
						'Desembolsado' => $row['Desembolsado'],
						'Saldo' => $row['Saldo'],
						'CapitalenMora' => $row['CapitalenMora'],
						'InteresenMOra' => $row['InteresenMOra'],
						'TotalMora' => $row['TotalMora'],
						'TotalMora' => $row['TotalMora'],
						'TotalMora' => $row['TotalMora']
					);
				}
				$json['success'] = true;
				echo json_encode($json);
			}
		} catch (PDOException $e) {
			echo 'Error: '. $e->getMessage();
		}
	}

?>