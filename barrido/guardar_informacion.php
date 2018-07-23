<?php

if(isset(
    $_POST['identidad'], 
    $_POST['nombre'], 
    $_POST['telefono'], 
    $_POST['actividad_economica'], 
    $_POST['nombre_negocio'], 
    $_POST['direccion_negocio'], 
    $_POST['es_beneficiario'], 
    $_POST['optar_credito'],
    $_POST['porque_optar_credito'],
    $_POST['interesado_capacitacion'], 
    $_POST['tema_capacitacion'])){

        session_start();
        require '../php/conection.php';

        $stat = $conn->prepare('call almacenar_recoleccion_datos(
            :user,
            :identidad,
            :nombre,
            :telefono,
            :actividad_economica,
            :nombre_negocio,
            :direccion_negocio,
            :es_beneficiario,
            :optar_credito,
            :porque_optar_credito,
            :interesado_capacitacion,
            :tema_capacitacion
        );');

        $stat->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
        $stat->bindValue(':identidad', $_POST['identidad'], PDO::PARAM_STR);
        $stat->bindValue(':nombre', $_POST['nombre'], PDO::PARAM_STR);
        $stat->bindValue(':telefono', $_POST['telefono'], PDO::PARAM_STR);
        $stat->bindValue(':actividad_economica', $_POST['actividad_economica'], PDO::PARAM_STR);
        $stat->bindValue(':nombre_negocio', $_POST['nombre_negocio'], PDO::PARAM_STR);
        $stat->bindValue(':direccion_negocio', $_POST['direccion_negocio'], PDO::PARAM_STR);
        $stat->bindValue(':es_beneficiario', $_POST['es_beneficiario'], PDO::PARAM_STR);
        $stat->bindValue(':optar_credito', $_POST['optar_credito'], PDO::PARAM_STR);
        $stat->bindValue(':porque_optar_credito', $_POST['porque_optar_credito'], PDO::PARAM_STR);
        $stat->bindValue(':interesado_capacitacion', $_POST['interesado_capacitacion'], PDO::PARAM_STR);
        $stat->bindValue(':tema_capacitacion', $_POST['tema_capacitacion'], PDO::PARAM_STR);

        if($stat->execute()){
            echo 'correcto';
        }else{
            echo 'error';
        }

}

?>