<?php 

if(isset($_POST['data'])){
	try {
		require_once '../conection.php';
		
		$data                          = json_decode($_POST['data']);
		
		if ($data->departamento        == NULL){$data->departamento = "0";}
		if ($data->municipio           == NULL){$data->municipio = "0";}
		if ($data->aldea               == NULL){$data->aldea = "0";}
		if ($data->caserio             == NULL){$data->caserio = "0";}
		if ($data->barrio              == NULL){$data->barrio = "0";}
		if ($data->departamentonegocio == NULL){$data->departamentonegocio = "0";}
		if ($data->municipionegocio    == NULL){$data->municipionegocio = "0";}
		if ($data->aldeanegocio        == NULL){$data->aldeanegocio = "0";}
		if ($data->caserionegocio      == NULL){$data->caserionegocio = "0";}
		if ($data->barrionegocio       == NULL){$data->barrionegocio = "0";}		
		
		$departamento                  = str_pad($data->departamento, 2, '0', STR_PAD_LEFT);
		$municipio                     = str_pad($data->municipio, 2, '0', STR_PAD_LEFT);
		$aldea                         = str_pad($data->aldea, 3, '0', STR_PAD_LEFT);
		$caserio                       = str_pad($data->caserio, 3, '0', STR_PAD_LEFT);
		$barrio                        = str_pad($data->barrio, 3, '0', STR_PAD_LEFT);
		
		$departamentonegocio           = str_pad($data->departamentonegocio, 2, '0', STR_PAD_LEFT);
		$municipionegocio              = str_pad($data->municipionegocio, 2, '0', STR_PAD_LEFT);
		$aldeanegocio                  = str_pad($data->aldeanegocio, 3, '0', STR_PAD_LEFT);
		$caserionegocio                = str_pad($data->caserionegocio, 3, '0', STR_PAD_LEFT);
		$barrionegocio                 = str_pad($data->barrionegocio, 3, '0', STR_PAD_LEFT);
		
		$idbarriocolonia               = $departamento.$municipio.$aldea.$caserio.$barrio;
		$idbarriocolonianegocio        = $departamentonegocio.$municipionegocio.$aldeanegocio.$caserionegocio.$barrionegocio;

		$stat = $conn->prepare('update cartera_consolidada set 
			Fecha_Solicitud        = :fechadesolicitud, 
			Lugar_Nacimiento       = :lugardenacimiento, 
			Estado_Civil           = :estadocivil, 
			Telefono               = :telefono, 
			Telefono2              = :celular, 
			idbarriocolonia        = :idbarriocolonia, 
			tipodevivienda         = :tipodevivienda, 
			Direccion_Domicilio    = :puntodereferencia, 
			alquilacasa            = :alquilacasa, 
			nombre_propietario     = :nombrepropietario, 
			telefono_propietario   = :telefonopropietario, 
			Sector_Económico       = :sectoreconomico, 
			Actividad_Económica    = :actividadeconomica, 
			Tipo_Cliente           = :tipodecliente, 
			idbarriocolonianegocio = :idbarriocolonianegocio, 
			Direccion_Negocio      = :puntodereferencianegocio, 
			`Nombre Ref1`          = :nombreref1, 
			`Nombre Ref2`          = :nombreref2, 
			`Nombre Ref3`          = :nombreref3, 
			`Nombre Ref4`          = :nombreref4, 
			`Parentesco Ref1`      = :parentescoref1, 
			`Parentesco Ref2`      = :parentescoref2, 
			`Parentesco Ref3`      = :parentescoref3, 
			`Parentesco Ref4`      = :parentescoref4, 
			`Direccion Ref1`       = :direccionref1, 
			`Direccion Ref2`       = :direccionref2, 
			`Direccion Ref3`       = :direccionref3, 
			`Direccion Ref4`       = :direccionref4, 
			`Telefono Ref1`        = :telefonoref1, 
			`Telefono Ref2`        = :telefonoref2, 
			`Telefono Ref3`        = :telefonoref3, 
			`Telefono Ref4`        = :telefonoref4,
			digitado			   = :digitado 
			where id = :idcredito');
		
		$stat->bindValue(':fechadesolicitud', $data->fechadesolicitud, PDO::PARAM_STR);
		$stat->bindValue(':lugardenacimiento', $data->lugardenacimiento, PDO::PARAM_STR);
		$stat->bindValue(':estadocivil', $data->estadocivil, PDO::PARAM_STR);
		$stat->bindValue(':telefono', $data->telefono, PDO::PARAM_STR);
		$stat->bindValue(':celular', $data->celular, PDO::PARAM_STR);
		$stat->bindValue(':idbarriocolonia', $idbarriocolonia, PDO::PARAM_STR);
		$stat->bindValue(':tipodevivienda', $data->tipodevivienda, PDO::PARAM_STR);
		$stat->bindValue(':puntodereferencia', $data->puntodereferencia, PDO::PARAM_STR);
		$stat->bindValue(':alquilacasa', $data->alquilacasa, PDO::PARAM_STR);
		$stat->bindValue(':nombrepropietario', $data->nombrepropietario, PDO::PARAM_STR);
		$stat->bindValue(':telefonopropietario', $data->telefonopropietario, PDO::PARAM_STR);
		$stat->bindValue(':sectoreconomico', $data->sectoreconomico, PDO::PARAM_STR);
		$stat->bindValue(':actividadeconomica', $data->actividadeconomica, PDO::PARAM_STR);
		$stat->bindValue(':tipodecliente', $data->tipodecliente, PDO::PARAM_STR);
		$stat->bindValue(':idbarriocolonianegocio', $idbarriocolonianegocio, PDO::PARAM_STR);
		$stat->bindValue(':puntodereferencianegocio', $data->puntodereferencianegocio, PDO::PARAM_STR);
		$stat->bindValue(':nombreref1', $data->nombreref1, PDO::PARAM_STR);
		$stat->bindValue(':nombreref2', $data->nombreref2, PDO::PARAM_STR);
		$stat->bindValue(':nombreref3', $data->nombreref3, PDO::PARAM_STR);
		$stat->bindValue(':nombreref4', $data->nombreref4, PDO::PARAM_STR);
		$stat->bindValue(':parentescoref1', $data->parentescoref1, PDO::PARAM_STR);
		$stat->bindValue(':parentescoref2', $data->parentescoref2, PDO::PARAM_STR);
		$stat->bindValue(':parentescoref3', $data->parentescoref3, PDO::PARAM_STR);
		$stat->bindValue(':parentescoref4', $data->parentescoref4, PDO::PARAM_STR);
		$stat->bindValue(':direccionref1', $data->direccionref1, PDO::PARAM_STR);
		$stat->bindValue(':direccionref2', $data->direccionref2, PDO::PARAM_STR);
		$stat->bindValue(':direccionref3', $data->direccionref3, PDO::PARAM_STR);
		$stat->bindValue(':direccionref4', $data->direccionref4, PDO::PARAM_STR);
		$stat->bindValue(':telefonoref1', $data->telefonoref1, PDO::PARAM_STR);
		$stat->bindValue(':telefonoref2', $data->telefonoref2, PDO::PARAM_STR);
		$stat->bindValue(':telefonoref3', $data->telefonoref3, PDO::PARAM_STR);
		$stat->bindValue(':telefonoref4', $data->telefonoref4, PDO::PARAM_STR);
		$stat->bindValue(':digitado', $data->digitado, PDO::PARAM_STR);
		$stat->bindValue(':idcredito', $data->idcredito, PDO::PARAM_STR);

		if ($stat->execute()) {
			echo "Query Succesfull";
		} else {
			echo "Query Error";
		}

	} catch (PDOException $e) {
		echo $e->getMessage();
	}
}

?>
