<?php

require '../../php/conection.php';
session_start();

$user = $_SESSION['user'];

if (isset($_POST['id_usuario'])){
    
    try{
            $correcto = false;
            
            $sql = $conn->prepare('
                    select metaCreditos, creditos, metaColocacion, colocacion, metaRecuperacion, recuperacion, metaMora, mora
                    from metas 
                    where idUsuario = :userId  and tipoEmpleado = :tipo_usuario
                    ');
                    $sql->bindValue(':userId', $_POST['id_usuario'], PDO::PARAM_STR);
                    $sql->bindValue(':tipo_usuario', $_POST['tipo_usuario'], PDO::PARAM_STR);
            
                    if ($sql->execute()) {
                        $metas = $sql->fetchAll(PDO::FETCH_ASSOC);
				        $correcto = true;
                    
                    } else {
                        $correcto = false;
                        return false;
                    }
            
                    echo json_encode($metas);


        }catch(PDOException $e){
	        echo $e->getMessage();
    	}
    
}else {
    echo "no viene el ID";
}






?>