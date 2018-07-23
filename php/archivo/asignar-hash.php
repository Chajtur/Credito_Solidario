<?php

/**
 * Este archivo sirve para completar la asignación de hash a un grupo que no lo contiene
 * @param datos generales del crédito via post
 * @param beneficiarios via post (arreglo de beneficiarios)
 * @author Rychiv4
 */

if(isset($_POST['grupo_solidario'], $_POST['asesor'], $_POST['ciclo'], $_POST['departamento'], $_POST['municipio'], $_POST['beneficiarios'])){

    require '../conection.php';

    try{

        $conn->beginTransaction();

        // TODO: Hay que hacer un foreach para que lo siguiente se ejecute para cada beneficiario recibido

        $stat = $conn->prepare('call asignar_hash(:grupo_solidario, :asesor, :fecha, :munincipio, :departamento, :identidad, :ciclo);');
        $stat_asesor = $conn->prepare('update cartera_consolidada set Gestor = :asesor where identidad = :identidad and ciclo = :ciclo');

        foreach($_POST['beneficiarios'] as $identidad){
            $stat->bindValue(':grupo_solidario', $_POST['grupo_solidario'], PDO::PARAM_STR);
            $stat->bindValue(':asesor', $_POST['asesor'], PDO::PARAM_STR);
            $stat->bindValue(':fecha', $_POST['fecha'], PDO::PARAM_STR);
            $stat->bindValue(':munincipio', $_POST['municipio'], PDO::PARAM_STR);
            $stat->bindValue(':departamento', $_POST['departamento'], PDO::PARAM_STR);
            $stat->bindValue(':identidad', $identidad, PDO::PARAM_STR);
            $stat->bindValue(':ciclo', $_POST['ciclo'], PDO::PARAM_STR);
            $stat->execute();
            
            $stat_asesor->bindValue(':asesor', $_POST['asesor'], PDO::PARAM_STR);
            $stat_asesor->bindValue(':identidad', $identidad, PDO::PARAM_STR);
            $stat_asesor->bindValue(':ciclo', $_POST['ciclo'], PDO::PARAM_STR);
            $stat_asesor->execute();
        }
        

        $conn->commit();
        echo true;

    }catch(PDOException $e){

        $conn->rollBack();
        echo false;

    }

}



?>