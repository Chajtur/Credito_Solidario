<?php

if(isset($_POST['hash'])){

    require '../conection.php';

    try{

        $stat = $conn->prepare('select ifi, estatus_prestamo from cartera_consolidada where grupo_solidario_hash = :hash limit 1');
        $stat->bindValue(":hash", $_POST['hash'], PDO::PARAM_STR);
        $stat->execute();

        $result = $stat->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($result) == 0){
            echo 'false';
            exit();
        }

        if($result['0']['estatus_prestamo'] == 'Colocado' || $result['0']['estatus_prestamo'] == 'Desembolsado' || $result['0']['estatus_prestamo'] == 'Cancelado' || $result['0']['estatus_prestamo'] == 'Anulado'){
        
            echo 'true';

        }else{

            echo 'El Hash tiene estatus '.$result['0']['estatus_prestamo'];

        }

    }catch(PDOException $e){

        error_log($e->getMessage());
        echo 'error';

    }

}




?>