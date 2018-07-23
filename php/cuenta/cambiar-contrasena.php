<?php 
	if(isset($_POST['data'])){
		try {
			$data = json_decode($_POST['data']);

			$nueva = password_hash($data->contraseña_nueva, PASSWORD_BCRYPT);
			$actual = $data->contraseña_actual;

			require_once '../conection.php';

			$stat = $conn2->prepare('select password from users where employee_id = :id');
			$stat->bindValue(':id', $data->id_user, PDO::PARAM_STR);

			if ($stat->execute()) {
				$result = $stat->fetch();
				// echo $result['password']."\n";
				if (password_verify($actual, $result['password'])) {
					// echo "contraseña cambiada";
					$stat = $conn2->prepare('update users set password = :nueva where employee_id = :id');
					$stat->bindValue(':nueva', $nueva, PDO::PARAM_STR);	
					$stat->bindValue(':id', $data->id_user, PDO::PARAM_STR);	
					if ($stat->execute()) {
						echo "1";
					} else{
						echo "2";
					}			
				} else {
					echo "0";
				}			
			} else {
				echo "Query Error"."\n";
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
 ?>