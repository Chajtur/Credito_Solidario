<?php

/**
 * Archivo que obtiene los datos necesarios para asignar un hash a un grupo que no lo tiene
 * @param identidad via post ($_POST['identidad'], debe contener un string con la identidad)
 * @return JSON arreglo de información
 * @author Rychiv4
 */

require '../conection.php';

if(isset($_POST['identidad'])){

    try{

        $stat = $conn->prepare('call obtener_datos_asignacion_hash(:identidad);');
        $stat->bindValue(':identidad', $_POST['identidad'], PDO::PARAM_STR);
        $stat->execute();
        echo json_encode($stat->fetch(PDO::FETCH_ASSOC));

    }catch(PDOException $e){
        
        error_log($e->getMessage());
        echo false;
        
    }

}else{
    echo false;
}

?>