<?php

if(isset(
    $_POST['nombre'], 
    $_POST['identidad'], 
    $_POST['telefono'], 
    $_POST['genero'], 
    $_POST['es_beneficiario'], 
    $_POST['merece_continuar'], 
    $_POST['calificacion_programa'], 
    $_POST['problema_poco_dinero'],
    $_POST['problema_zona_poca_clientela'],
    $_POST['problema_mantener_finanzas'], 
    $_POST['problema_llevar_contabilidad'], 
    $_POST['problema_inseguridad'], 
    $_POST['problema_necesita_entrenarse_clientela'], 
    $_POST['problema_desconoce_tecnicas_negocio'], 
    $_POST['problema_entrenamiento_basico_pc'], 
    $_POST['problema_necesita_capacitaciones'],
    $_POST['ayuda_adicional_brindar'],
    $_POST['se_compromete_ayudar_programa'])){

        session_start();
        require '../php/conection.php';

        $stat = $conn->prepare('call insertar_recoleccion_datos_2(
            :nombre,
            :identidad,
            :telefono,
            :genero,
            :es_beneficiario,
            :merece_continuar,
            :calificacion_programa,
            :problema_poco_dinero,
            :problema_zona_poca_clientela,
            :problema_mantener_finanzas,
            :problema_llevar_contabilidad,
            :problema_inseguridad,
            :problema_necesita_entrenarse_clientela,
            :problema_desconoce_tecnicas_negocio,
            :problema_entrenamiento_basico_pc,
            :problema_necesita_capacitaciones,
            :ayuda_adicional_brindar,
            :se_compromete_ayudar_programa
        );');

        $stat->bindValue(':nombre', $_POST['nombre'], PDO::PARAM_STR);
        $stat->bindValue(':identidad', $_POST['identidad'], PDO::PARAM_STR);
        $stat->bindValue(':telefono', $_POST['telefono'], PDO::PARAM_STR);
        $stat->bindValue(':genero', $_POST['genero'], PDO::PARAM_STR);
        $stat->bindValue(':es_beneficiario', $_POST['es_beneficiario'], PDO::PARAM_STR);
        $stat->bindValue(':merece_continuar', $_POST['merece_continuar'], PDO::PARAM_STR);
        $stat->bindValue(':calificacion_programa', $_POST['calificacion_programa'], PDO::PARAM_STR);
        $stat->bindValue(':problema_poco_dinero', $_POST['problema_poco_dinero'], PDO::PARAM_STR);
        $stat->bindValue(':problema_zona_poca_clientela', $_POST['problema_zona_poca_clientela'], PDO::PARAM_STR);
        $stat->bindValue(':problema_mantener_finanzas', $_POST['problema_mantener_finanzas'], PDO::PARAM_STR);
        $stat->bindValue(':problema_llevar_contabilidad', $_POST['problema_llevar_contabilidad'], PDO::PARAM_STR);
        $stat->bindValue(':problema_inseguridad', $_POST['problema_inseguridad'], PDO::PARAM_STR);
        $stat->bindValue(':problema_necesita_entrenarse_clientela', $_POST['problema_necesita_entrenarse_clientela'], PDO::PARAM_STR);
        $stat->bindValue(':problema_desconoce_tecnicas_negocio', $_POST['problema_desconoce_tecnicas_negocio'], PDO::PARAM_STR);
        $stat->bindValue(':problema_entrenamiento_basico_pc', $_POST['problema_entrenamiento_basico_pc'], PDO::PARAM_STR);
        $stat->bindValue(':problema_necesita_capacitaciones', $_POST['problema_necesita_capacitaciones'], PDO::PARAM_STR);
        $stat->bindValue(':ayuda_adicional_brindar', $_POST['ayuda_adicional_brindar'], PDO::PARAM_STR);
        $stat->bindValue(':se_compromete_ayudar_programa', $_POST['se_compromete_ayudar_programa'], PDO::PARAM_STR);

        if($stat->execute()){
            echo 'correcto';
        }else{
            echo 'error';
        }

}

?>