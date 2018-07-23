<?php 

session_start();

if(isset(
$_POST['identidad'],
$_POST['nombre'],
$_POST['telefono'],
$_POST['whatsapp'],
$_POST['correo'],
$_POST['direccion'],
$_POST['consulta'],
$_POST['solucion'],
$_POST['responsable'])){

    require '../conection.php';

    try{

        $conn->beginTransaction();

        $stat = $conn->prepare('call guardar_visita_cda(:identidad, :nombre, :telefono, :whatsapp, :correo, :consulta, :solucion, :responsable, :usuario, :direccion);');
        $stat->bindValue(':identidad', $_POST['identidad'], PDO::PARAM_STR);
        $stat->bindValue(':nombre', $_POST['nombre'], PDO::PARAM_STR);
        $stat->bindValue(':telefono', $_POST['telefono'], PDO::PARAM_STR);
        $stat->bindValue(':whatsapp', $_POST['whatsapp'], PDO::PARAM_STR);
        $stat->bindValue(':correo', $_POST['correo'], PDO::PARAM_STR);
        $stat->bindValue(':direccion', $_POST['direccion'], PDO::PARAM_STR);
        $stat->bindValue(':consulta', $_POST['consulta'], PDO::PARAM_STR);
        $stat->bindValue(':solucion', ($_POST['solucion'] == '' ? null : $_POST['solucion']), ($_POST['solucion'] == '' ? PDO::PARAM_INT : PDO::PARAM_STR));
        $stat->bindValue(':responsable', $_POST['responsable'], PDO::PARAM_STR);
        $stat->bindValue(':usuario', $_SESSION['user'], PDO::PARAM_STR);
        $stat->execute();
        
        $conn->commit();

        echo 'true';

    }catch(PDOException $e){
        $conn->rollBack();
        echo 'false';
    }

}

    

?>