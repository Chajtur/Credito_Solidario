<?php

/**
 * Archivo que obtiene todas las visitas de un usuario dado (id de usuario registrado en la bitácora)
 * @return identidad Devuelve la identidad
 * @author Ricardo Valladares (Rychiv4)
 */

if(isset($_GET['id'])){
    
    require '../php/conection.php';
    $stat = $conn->prepare('select * from bitacora_visitas where idusuario = :id');
    $stat->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
    $stat->execute();
    
    $all = $stat->fetchAll(PDO::FETCH_ASSOC);
    
    $stat = $conn3->prepare('select * from censo where identidad = :identidad');
    
    $i=0;
    
    foreach($all as $row){
        
        $stat->bindValue(':identidad', $row['identidad'], PDO::PARAM_STR);
        $stat->execute();
        $result = $stat->fetch(PDO::FETCH_ASSOC);
        
        $all[$i]['primerNombre'] = $result['primerNombre'];
        $all[$i]['segundoNombre'] = $result['segundoNombre'];
        $all[$i]['primerApellido'] = $result['primerApellido'];
        $all[$i]['segundoApellido'] = $result['segundoApellido'];
        $all[$i]['genero'] = $result['codigoSexo'];
        $all[$i]['fechaNacimiento'] = $result['fechaNacimiento'];
        $i++;
        
    }
    
    echo json_encode($all);
    
}

?>