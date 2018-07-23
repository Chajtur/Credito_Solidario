<?php
	if(isset($_POST['data'])){
		session_start();
		try {
			require_once '../conection.php';
			
			$data = json_decode($_POST['data']);
			
			if ($data->cnombre) {
				$stat = $conn->prepare('update cartera_consolidada set Grupo_Solidario = :nombre where grupo_solidario_hash = :group'); 
				$stat->bindValue(':nombre', $data->nombre, PDO::PARAM_STR);
				$stat->bindValue(':group', $data->group, PDO::PARAM_STR);
				if ($stat->execute()) {
					echo "Query Succesfull\n";
				} else {
					echo "Query Error\n";
				}				
			} 

			if ($data->cgestor) {
				$statGestor = $conn->prepare('select a.departamento, a.agencia, a.nombre, Get_Supervisor(a.nombre) as supervisor, Get_Supervisor(Get_Supervisor(a.nombre)) as coordinador from gsc a where nombre = :gestor'); 
				$statGestor->bindValue(':gestor', $data->gestor, PDO::PARAM_STR);
        		if($statGestor->execute()){        
            		$datogestor = $statGestor->fetch(PDO::FETCH_ASSOC);				
					$stat = $conn->prepare('update cartera_consolidada set Gestor = :gestor, Agencia = :agencia, Departamento = :departamento, Supervisor = :supervisor, Coordinador = :coordinador where grupo_solidario_hash = :group'); 
					$stat->bindValue(':gestor', $data->gestor, PDO::PARAM_STR);
					$stat->bindValue(':group', $data->group, PDO::PARAM_STR);
                    $stat->bindValue(':agencia', $datogestor['agencia'], PDO::PARAM_STR);
                    $stat->bindValue(':departamento', $datogestor['departamento'], PDO::PARAM_STR);
                    $stat->bindValue(':supervisor', $datogestor['supervisor'], PDO::PARAM_STR);
                    $stat->bindValue(':coordinador', $datogestor['coordinador'], PDO::PARAM_STR);					
					if ($stat->execute()) {
						echo "Query Succesfull\n";
					} else {
						echo "Query Error\n";
					}				
				}	
			} 		

			if (isset($data->borrarBeneficiarios))	{
				foreach ($data->borrarBeneficiarios as $beneficiario) {
					// echo $beneficiario->identidad;
					$stat2 = $conn->prepare('select id from cartera_consolidada where grupo_solidario_hash = :hash AND Identidad = :identidad');
					$stat2->bindValue(':hash', $data->group, PDO::PARAM_STR);
					$stat2->bindValue(':identidad', $beneficiario->identidad, PDO::PARAM_STR);
					if ($stat2->execute()){
						echo "Query ID Succesfull\n";
					}else {
						echo "No se puedo obtener el ID Crédito\n";
					}

					$id_credito = $stat2->fetch(PDO::FETCH_ASSOC);

					$stat = $conn->prepare('delete from cartera_consolidada where grupo_solidario_hash = :hash AND Identidad = :identidad'); 
					$stat->bindValue(':identidad', $beneficiario->identidad, PDO::PARAM_STR);
					$stat->bindValue(':hash', $data->group, PDO::PARAM_STR);
					
					if ($stat->execute()) {
						echo "Beneficiario eliminado del grupo\n";
					} else {
						echo "No se pudo eliminar el beneficiario\n";
					}					

					echo $id_credito['id']."\n";
					echo $data->group."\n";
					echo $_SESSION['user']."\n";

					$statBitacora = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) 
                    	values (:id_credito, :hash, "Beneficiario eliminado del grupo", "Se elimino un beneficiario del grupo en la ventana de edición", CURRENT_TIMESTAMP(), "Ingresado", :user_id)');                    
                    $statBitacora->bindValue(':id_credito', $id_credito['id'], PDO::PARAM_INT);
                    $statBitacora->bindValue(':hash', $data->group, PDO::PARAM_STR);
                    $statBitacora->bindValue(':user_id', $_SESSION['user'], PDO::PARAM_STR);
                    if ($statBitacora->execute()){
                    	echo "Bitacora: Beneficiario eliminado del grupo\n";
                    }else{
                    	echo "No se pudo ingresar en la bitacora\n";
                    }
				}
			}

			if (isset($data->agregarBeneficiarios)) {
				$stat = $conn->prepare('select a.departamento, a.agencia, a.nombre, Get_Supervisor(a.nombre) as supervisor, Get_Supervisor(Get_Supervisor(a.nombre)) as coordinador from gsc a where nombre = :gestor'); 
				$stat->bindValue(':gestor', $data->gestor, PDO::PARAM_STR);
        		if($stat->execute()){
            
            		$datogestor = $stat->fetch(PDO::FETCH_ASSOC);
            		$hoy = new DateTime();
            		$beneficiarios = $data->agregarBeneficiarios;

					foreach($beneficiarios as $beneficiario){					
		                // echo $beneficiario->identidad;
		                $censostat = $conn3->prepare('select * from censo where identidad = :identidad');
		                $censostat->bindValue(':identidad', $beneficiario->identidad, PDO::PARAM_STR);   
		                
		                if($censostat->execute()){

		                    $persona = $censostat->fetch(PDO::FETCH_ASSOC);
		                    $stat = $conn->prepare('
		                    	insert into cartera_consolidada(
		                    	Identidad, 
		                    	Nombre, 
		                    	PrimerNombre, 
		                    	SegundoNombre, 
		                    	PrimerApellido, 
		                    	SegundoApellido, 
		                    	Agencia, 
		                    	Departamento, 
		                    	Estatus_Prestamo, 
		                    	ciclo, 
		                    	fecha_procesamiento, 
		                    	Gestor, 
		                    	Supervisor, 
		                    	grupo_solidario, 
		                    	Sexo, 
		                    	Fecha_Nacimiento, 
		                    	Coordinador) 

		                    	values(
		                    	:identidad, 
		                    	:nombre, 
		                    	:primernombre, 
		                    	:segundonombre, 
		                    	:primerapellido, 
		                    	:segundoapellido, 
		                    	:agencia, 
		                    	:departamento, 
		                    	"Ingresado", 
		                    	:ciclo, 
		                    	:fecha, 
		                    	:gestor, 
		                    	:supervisor, 
		                    	:gruposolidario, 
		                    	:sexo, 
		                    	:fechanacimiento, 
		                    	:coordinador)
		                    	');

		                    $stat->bindValue(':primernombre', $persona['primerNombre'], PDO::PARAM_STR);
		                    $stat->bindValue(':segundonombre', $persona['segundoNombre'], PDO::PARAM_STR);
		                    $stat->bindValue(':primerapellido', $persona['primerApellido'], PDO::PARAM_STR);
		                    $stat->bindValue(':segundoapellido', $persona['segundoApellido'], PDO::PARAM_STR);
		                    $stat->bindValue(':identidad', $beneficiario->identidad, PDO::PARAM_STR);
		                    $stat->bindValue(':nombre', $beneficiario->nombre, PDO::PARAM_STR);
		                    $stat->bindValue(':agencia', $datogestor['agencia'], PDO::PARAM_STR);
		                    $stat->bindValue(':departamento', $datogestor['departamento'], PDO::PARAM_STR);
		                    $stat->bindValue(':ciclo', $data->ciclo, PDO::PARAM_STR);
		                    $stat->bindValue(':fecha', $hoy->format('Y-m-d'), PDO::PARAM_STR);
		                    $stat->bindValue(':gestor', $datogestor['nombre'], PDO::PARAM_STR);
		                    $stat->bindValue(':supervisor', $datogestor['supervisor'], PDO::PARAM_STR);
		                    $stat->bindValue(':gruposolidario', $data->nombre, PDO::PARAM_STR);
		                    $stat->bindValue(':sexo', ($persona['codigoSexo'] == "1" ? "M" : "F"), PDO::PARAM_STR);
		                    $stat->bindValue(':fechanacimiento', $persona['fechaNacimiento'], PDO::PARAM_STR);
		                    $stat->bindValue(':coordinador', $datogestor['coordinador'], PDO::PARAM_STR);

		                    if ($stat->execute()){
		                    	echo "Beneficiario agregado al grupo\n";

								$statHash = $conn->prepare('update cartera_consolidada set grupo_solidario_hash = :hash where identidad = :identidad AND Grupo_Solidario = :nombreGrupo'); 
								$statHash->bindValue(':hash', $data->group, PDO::PARAM_STR);
								$statHash->bindValue(':identidad', $beneficiario->identidad, PDO::PARAM_STR);
								$statHash->bindValue(':nombreGrupo', $data->nombre, PDO::PARAM_STR);
								if ($statHash->execute()) {
									echo "Hash Actualizado\n";
								} else {
									echo "No se pudo cambiar el Hash\n";
								}

								$stat2 = $conn->prepare('select id from cartera_consolidada where grupo_solidario_hash = :hash AND Identidad = :identidad');
								$stat2->bindValue(':hash', $data->group, PDO::PARAM_STR);
								$stat2->bindValue(':identidad', $beneficiario->identidad, PDO::PARAM_STR);
								if ($stat2->execute()){
									$id_credito = $stat2->fetch(PDO::FETCH_ASSOC);	
									echo "Query ID Succesfull\n";
								}else {
									echo "No se puedo obtener el ID Crédito\n";
								}

								echo $id_credito['id']."\n";		                    	
								echo $data->group."\n";
								echo $_SESSION['user']."\n";		
									                    
			                    $statBitacora = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) 
			                    	values (:id_credito, :hash, "Beneficiario agregado al grupo", "Se agrego un beneficiario al grupo en la ventana de edición", CURRENT_TIMESTAMP(), "Ingresado", :user_id)');
	                    
			                    $statBitacora->bindValue(':id_credito', $id_credito['id'], PDO::PARAM_INT);
			                    $statBitacora->bindValue(':hash', $data->group, PDO::PARAM_STR);
			                    $statBitacora->bindValue(':user_id', $_SESSION['user'], PDO::PARAM_STR);
			                    if ($statBitacora->execute()){
			                    	echo "Bitacora: Beneficiario agregado al grupo\n";
			                    }else{
			                    	echo "No se pudo ingresar en la bitacora\n";
			                    }                    	
		                    } else {
		                    	echo "No se pudo ingresar el beneficiario\n";
		                    }

		                }
		            }         		
            	}
			}
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
?>