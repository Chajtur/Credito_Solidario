<?php

/**
 * Este archivo sirve para completar la asignación de hash a un grupo que no lo contiene
 * @param datos generales del crédito via post
 * @param beneficiarios via post (arreglo de beneficiarios)
 * @author Rychiv4
 */

//if(isset($_POST['grupo_solidario'], $_POST['asesor'], $_POST['ciclo'], $_POST['departamento'], $_POST['municipio'], $_POST['beneficiarios'])){

    require '../conection.php';

    try{

        $conn->beginTransaction();
        $algo2 = 'kakdjf';
        $fecha = '2018-08-07';
        $hola = '51545454';
        
        // TODO: Hay que hacer un foreach para que lo siguiente se ejecute para cada beneficiario recibido

        $stat = $conn->prepare('call asignar_hash(?, ?, ?, ?, ?, ?, ?, @miHash);');
        $stat->bindParam(1, $_POST['grupo_solidario'], PDO::PARAM_STR);
            $stat->bindParam(2, $algo2, PDO::PARAM_STR);
            $stat->bindParam(3, $fecha, PDO::PARAM_STR);
            $stat->bindParam(4, $_POST['municipio'], PDO::PARAM_STR);
            $stat->bindParam(5, $_POST['departamento'], PDO::PARAM_STR);
            $stat->bindParam(6, $hola, PDO::PARAM_STR);
            $stat->bindParam(7, $_POST['ciclo'], PDO::PARAM_STR);
            
            $stat->execute();
            
            $stat->closeCursor();

            $miHash = $conn->query('select @miHash as miHash')->fetch();
            var_dump($miHash);
            die();
        $stat_asesor = $conn->prepare('update cartera_consolidada set Gestor = :asesor where identidad = :identidad and ciclo = :ciclo');
        
        foreach($_POST['beneficiarios'] as $identidad){
            $stat->bindParam(1, $_POST['grupo_solidario'], PDO::PARAM_STR);
            $stat->bindParam(2, $_POST['asesor'], PDO::PARAM_STR);
            $stat->bindParam(3, $_POST['fecha'], PDO::PARAM_STR);
            $stat->bindParam(4, $_POST['municipio'], PDO::PARAM_STR);
            $stat->bindParam(5, $_POST['departamento'], PDO::PARAM_STR);
            $stat->bindParam(6, $identidad, PDO::PARAM_STR);
            $stat->bindParam(7, $_POST['ciclo'], PDO::PARAM_STR);
            $stat->execute();
            $stat->closeCursor();

            $miHash = $conn->query('select @miHash as miHash')->fetch();
            var_dump($miHash);
            die();
            
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

//}



?>