<?php

if(isset($_POST['desde'], $_POST['hasta'], $_POST['por'], $_POST['consolidar'])){

    try{

        require '../conection.php';

        foreach($_POST as $index => $value){
            if($value == ""){
                $_POST[$index] = null;
            }
        }

        $stat = $conn->prepare('call obtener_pendiente_desembolsar(:tipo, :fecha1, :fecha2, :agrupar);');
        $stat->bindValue(':tipo', $_POST['por'], PDO::PARAM_INT);
        $stat->bindValue(':fecha1', $_POST['desde'], PDO::PARAM_STR);
        $stat->bindValue(':fecha2', $_POST['hasta'], PDO::PARAM_STR);
        $stat->bindValue(':agrupar', $_POST['consolidar'], PDO::PARAM_INT);
        $stat->execute();
        $result = $stat->fetchAll(PDO::FETCH_NUM);

        echo json_encode($result);

    }catch(PDOException $e){

        error_log($e->getMessage());
        echo 'false';

    }

    

}

?>