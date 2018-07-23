<?php

if(isset($_POST['id_caso'])){

    require '../conection.php';

    try{
        $conn->beginTransaction();
        $stmt = $conn->prepare('call cerrar_caso(:id_caso);');
        $stmt->bindValue(':id_caso', $_POST['id_caso'], PDO::PARAM_STR);
        $stmt->execute();
        $conn->commit();
        echo 'true';

    }catch(PDOException $e){
        $conn->rollBack();
        echo 'false';
    }

    

}else{
    echo 'no entra';
}

?>