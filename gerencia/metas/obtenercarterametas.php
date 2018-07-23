<?php

require '../../php/conection.php';
session_start();

$user = $_SESSION['user'];

if (isset($_POST['id_empleado']) && isset($_POST['tipo_usuario'])){
    
    try{
            $correcto = false;
            
            $sql = $conn->prepare('
                    select b.nombre, a.idUsuario, a.creditos, a.metaCreditos, a.metaColocacion, a.colocacion, 
                    a.metaRecuperacion, a.recuperacion, a.metaMora, a.mora
                    from metas a inner join gsc b on a.idUsuario = b.id
                    where b.tipoEmpleado = :tipoUsuario and a.parent = :idEmpleado
                    ');
                    $sql->bindValue(':idEmpleado', $_POST['id_empleado'], PDO::PARAM_STR);
                    $sql->bindValue(':tipoUsuario', $_POST['tipo_usuario'], PDO::PARAM_STR);
            
                    if ($sql->execute()) {
                        $carterametas = $sql->fetchAll(PDO::FETCH_ASSOC);
				        $correcto = true;
                    
                    } else {
                        $correcto = false;
                        return false;
                    }
            
                    echo json_encode($carterametas);


        }catch(PDOException $e){
	        echo $e->getMessage();
    	}
    
}else {
    echo "no viene el ID";
}






?>