<?php 


session_start();
require '../../php/conection.php';
$user = $_SESSION['user'];


/*if (isset($_POST['metaTodasCreditos']) && 
        isset($_POST['metaTodasMora']) && 
        isset($_POST['metaTodasPMora']) && 
        isset($_POST['metaTodasColocacion']) && 
        isset($_POST['metaTodasRecuperacion'])) {
        
        $idAsesorS = $_POST['idAsesor'];
        $mcreditos = $_POST['metaTodasCreditos'];
        $mmora = $_POST['metaTodasMora'];
        $mpmora = $_POST['metaTodasPMora'];
        $mcolocacion = $_POST['metaTodasColocacion'];
        $mrecuperacion = $_POST['metaTodasRecuperacion'];
        
		try{
			 
            
            $correcto = false;
            
                
                $stat = $conn->prepare('
                insert into metas (idUsuario, metaCreditos, metaMora, metaPorcentajeMora, metaColocacion, metaRecuperacion)
                                                values (:user, :mcreditos, :mmora, :mpmora, :mcolocacion, :mrecuperacion)
                                                on duplicate key 
                                                update metaCreditos = :mcreditos, 
                                                metaMora = :mmora,
                                                metaPorcentajeMora = :mpmora,
                                                metaColocacion = :mcolocacion,
                                                metaRecuperacion = :mrecuperacion
                ');
                
                $stat->bindValue(':user', $idAsesorS, PDO::PARAM_STR);
                $stat->bindValue(':mcreditos', $mcreditos, PDO::PARAM_STR);
                $stat->bindValue(':mmora', $mmora, PDO::PARAM_STR);
                $stat->bindValue(':mpmora', $mpmora, PDO::PARAM_STR);
                $stat->bindValue(':mcolocacion', $mcolocacion, PDO::PARAM_STR);
                $stat->bindValue(':mrecuperacion', $mrecuperacion, PDO::PARAM_STR);
                
                if ($stat->execute()) {
				    $correcto = true;
                    
                } else {
                    $correcto = false;
                    return false;
                }
                
            
            echo $correcto;

		}catch(PDOException $e){

	        echo $e->getMessage();

    	}
	}*/






if (isset($_POST['idAsesor']) && isset($_POST['idMeta']) && isset($_POST['montoMeta'])){
        
    
    switch($_POST['idMeta']){
        
        case "modalmetadesembolsos":
            $nombreColumna = "metaCreditos";
            //CODE
            actualizar($_POST['idAsesor'], $_POST['montoMeta'], $nombreColumna, $conn);
        break;
        case "modalmetacolocacion":
            $nombreColumna = "metaColocacion";
            //CODE
            actualizar($_POST['idAsesor'], $_POST['montoMeta'], $nombreColumna, $conn);
        break;
        case "modalmetarecuperacion":
            $nombreColumna = "metaRecuperacion";
            //CODE
            actualizar($_POST['idAsesor'], $_POST['montoMeta'], $nombreColumna, $conn);
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