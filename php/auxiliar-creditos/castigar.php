<?php

if(isset($_POST['data'])){

    $obj = json_decode($_POST['data']);

    // {
	//  "id": "155653",
	// 	"nombre": "Cinthia rosibel silva giron",
	// 	"identidad": "0801198205825",
	// 	"conObservacion": true,
	// 	"observacion": "hola",
	// 	"estatus": "Ingresado"
	// }

    session_start();

    require '../conection.php';

    //Función para ingresar una entrada nueva a la bitacora
    function agregarEnBitacora($statement, $idcredito, $hash, $razon, $estado_credito, $user, $observ){

        $statement->bindValue(':id_credito', $idcredito, PDO::PARAM_INT);
        $statement->bindValue(':hash', $hash, PDO::PARAM_STR);
        $statement->bindValue(':estado_razon', $razon, PDO::PARAM_STR);
        $statement->bindValue(':estado_credito', $estado_credito, PDO::PARAM_STR);
        $statement->bindValue(':user_id', $user, PDO::PARAM_STR);
        $statement->bindValue(':observacion', $observ, PDO::PARAM_STR);
        return $statement->execute();

    }

    $stat_bitacora = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) 
                                        values (:id_credito, :hash, :estado_razon, :observacion, CURRENT_TIMESTAMP(), :estado_credito, :user_id)');

    foreach($obj->beneficiarios as $beneficiario){
        if($beneficiario->conObservacion == true){
            agregarEnBitacora($stat_bitacora, $beneficiario->id, $obj->hash, 'Observacion Auxiliar de Creditos', $beneficiario->estatus, $_SESSION['user'], $beneficiario->observacion);
        }else{
            agregarEnBitacora($stat_bitacora, $beneficiario->id, $obj->hash, 'Observacion Auxiliar de Creditos', $beneficiario->estatus, $_SESSION['user'], 'Crédito Retenido a causa de otro compañero');
        }
    }

    foreach($obj->beneficiarios as $beneficiario){
        agregarEnBitacora($stat_bitacora, $beneficiario->id, $obj->hash, 'Crédito Retenido', 'Credito Retenido', $_SESSION['user'], 'El crédito ha sido retenido');
    }

    $stat = $conn->prepare('update cartera_consolidada set Estatus_Prestamo = "Credito Retenido" where grupo_solidario_hash = :hash');
    $stat->bindValue(':hash', $obj->hash, PDO::PARAM_STR);
    if($stat->execute()){
        echo true;
    }else{
        echo 'error';
    }


}

?>