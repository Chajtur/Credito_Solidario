<?php 
	session_start();
    $user = $_SESSION['user'];
    /*foreach($numeros_prestamos as $prestamo){
                echo $prestamo;
            }
    echo $gestor;*/
    //echo json_encode($_POST);
    if (isset($_POST['metaMonto']) && isset($_POST['idAsesor']) && isset($_POST['metaInputId'])){
        
        try{
            require "../php/conection.php";
            
            $correcto = false;
            
            $idAsesorS = $_POST['idAsesor'];
            $metaNueva = $_POST['metaMonto'];
        
            switch($_POST['metaInputId']){
                case "metaCreditosIndiv": 
                    $sql = $conn->prepare('
                    insert into metas (idUsuario, metaCreditos)
                                                values (:userGestor, :mcreditos)
                                                on duplicate key 
                                                update metaCreditos = :mcreditos
                    ');
                    $sql->bindValue(':userGestor', $idAsesorS, PDO::PARAM_STR);
                    $sql->bindValue(':mcreditos', $metaNueva, PDO::PARAM_STR);
                    if ($sql->execute()) {
				    $correcto = true;
                    
                    } else {
                        $correcto = false;
                        return false;
                    }
                    echo $correcto;
                    
                    break;
                case "metaColocacionIndiv": 
                    $sql = $conn->prepare('
                    insert into metas (idUsuario, metaColocacion)
                                                values (:userGestor, :mcolocacion)
                                                on duplicate key 
                                                update metaColocacion = :mcolocacion');
                    $sql->bindValue(':userGestor', $idAsesorS, PDO::PARAM_STR);
                    $sql->bindValue(':mcolocacion', $metaNueva, PDO::PARAM_STR);
                    if ($sql->execute()) {
				    $correcto = true;
                    
                    } else {
                        $correcto = false;
                        return false;
                    }
                    echo $correcto;
                    
                    break;
                case "metaRecuperacionIndiv": 
                    $sql = $conn->prepare('
                    insert into metas (idUsuario, metaRecuperacion)
                                                values (:userGestor, :metaRecuperacion)
                                                on duplicate key 
                                                update metaRecuperacion = :metaRecuperacion');
                    $sql->bindValue(':userGestor', $idAsesorS, PDO::PARAM_STR);
                    $sql->bindValue(':metaRecuperacion', $metaNueva, PDO::PARAM_STR);
                    if ($sql->execute()) {
				    $correcto = true;
                    
                    } else {
                        $correcto = false;
                        return false;
                    }
                    echo $correcto;
                    
                    break;
            }
            
        }catch(PDOException $e){
	        echo $e->getMessage();
    	}
            
        
    }

	if (isset($_POST['metaTodasCreditos']) && 
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
			 require "../php/conection.php";
            
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
	}

		


?>