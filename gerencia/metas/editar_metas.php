<?php 

require '../../php/conection.php';
session_start();

$user = $_SESSION['user'];

if (isset($_POST['idCoordinador']) && isset($_POST['nombreCoordinador']) && isset($_POST['idMeta']) && isset($_POST['montoMeta'])){
        
    echo json_encode($_POST);
    
    switch($_POST['idMeta']){
        
        case "modalmetadesembolsos":
            $nombreColumna = "metaCreditos";
            //CODE
            actualizar($_POST['idCoordinador'], $_POST['montoMeta'], $nombreColumna, $conn);
        break;
        case "modalmetacolocacion":
            $nombreColumna = "metaColocacion";
            //CODE
            actualizar($_POST['idCoordinador'], $_POST['montoMeta'], $nombreColumna, $conn);
        break;
        case "modalmetarecuperacion":
            $nombreColumna = "metaRecuperacion";
            //CODE
            actualizar($_POST['idCoordinador'], $_POST['montoMeta'], $nombreColumna, $conn);
        break;
        case "modalmetamora":
            $nombreColumna = "metaMora";
            //CODE
            actualizar($_POST['idCoordinador'], $_POST['montoMeta'], $nombreColumna, $conn);
        break;
    }
        
}

function actualizar($idCoordinador, $montoMeta, $columna, $conn){
        try{
            $correcto = false;
            
            $sql = $conn->prepare('
                    insert into metas (idUsuario, '.$columna.')
                                                values (:userCoordinador, :montometa)
                                                on duplicate key 
                                                update '.$columna.' = :montometa
                    ');
                    $sql->bindValue(':userCoordinador', $idCoordinador, PDO::PARAM_STR);
                    $sql->bindValue(':montometa', $montoMeta, PDO::PARAM_STR);
            
                    if ($sql->execute()) {
				    $correcto = true;
                    
                    } else {
                        $correcto = false;
                        return false;
                    }
            
                    echo $correcto;


        }catch(PDOException $e){
	        echo $e->getMessage();
    	}
    }










?>