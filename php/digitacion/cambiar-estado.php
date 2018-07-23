<?php
	session_start();

	if(isset($_POST['data'])){
	    
	    // echo $_POST['data'];
		require '../conection.php';
	    
	    if (isset($conn)) {

	    	$conn->beginTransaction();
			
		    try {
				
				$data = json_decode($_POST['data']);				
				
				$stat = $conn->prepare('UPDATE cartera_consolidada SET monto_Autorizado = :monto, Forma_de_Pago = :frecuencia, Valor_del_Ahorro = :valor, Plazo = :plazo, Estatus_Prestamo = "Colocacion", Observaciones = :observacion, IFI = :ifi WHERE id = :idcredito');

				$stat_bitacora = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) values (:id_credito, :hash, :estado_razon, :observacion, CURRENT_TIMESTAMP(), :estado_credito, :user_id)');

		        //Función para ingresar una entrada nueva a la bitacora
		        function agregarEnBitacora($statement, $idcredito, $hash, $razon, $estado_credito, $user, $observ){
		            
		            $statement->bindValue(':id_credito', $idcredito, PDO::PARAM_INT);
		            $statement->bindValue(':hash', $hash, PDO::PARAM_STR);
		            $statement->bindValue(':estado_razon', $razon, PDO::PARAM_STR);
		            $statement->bindValue(':estado_credito', $estado_credito, PDO::PARAM_STR);
		            $statement->bindValue(':user_id', $user, PDO::PARAM_STR);
		            $statement->bindValue(':observacion', $observ, PDO::PARAM_STR);
		            $statement->execute();
		            
		        }			

				foreach ($data as $index => $value) {
					$stat->bindValue(':monto', str_replace(',', '', $value->monto), PDO::PARAM_STR);
					$stat->bindValue(':frecuencia', $value->frecuencia, PDO::PARAM_STR);
					$stat->bindValue(':valor', $value->valor, PDO::PARAM_STR);
					$stat->bindValue(':plazo', $value->plazo, PDO::PARAM_STR);
					$stat->bindValue(':idcredito', $value->idcredito, PDO::PARAM_STR);
					$stat->bindValue(':observacion', $value->observ, PDO::PARAM_STR);
					$stat->bindValue(':ifi', $value->ifi, PDO::PARAM_STR);
					$stat->execute();	
	                agregarEnBitacora($stat_bitacora, $value->idcredito, $value->hash, 'Credito Digitado', 'Colocacion', $_SESSION['user'], 'Se ha digitado el crédito');
				}

				if($conn->commit()){
					echo "Success";
				}else{
					$conn->rollBack();
					echo "Query Fail";
				}

		    } catch (PDOException $e) {
		    	$conn->rollBack();
		    	echo "Catch Fail";
		    }
		}
	}

?>