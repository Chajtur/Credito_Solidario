<?php

require '../conection.php';

session_start();

if(isset($_POST['data'])){

    $obj = json_decode($_POST['data']);

    try{

        $stat = $conn->prepare('select crear_reasignacion(:idcredito, :iduser, :numero_prestamo, :estado, :asesor_nuevo, :asesor_viejo);');

        foreach($obj as $credito){

            $stat->bindValue('idcredito', ($credito->idcredito == '' || $credito->idcredito == null ? null : $credito->idcredito), ($credito->idcredito == '' || $credito->idcredito == null ? PDO::PARAM_NULL : PDO::PARAM_STR));
            $stat->bindValue('iduser', $_SESSION['user'], PDO::PARAM_STR);
            $stat->bindValue('numero_prestamo', $credito->numero_prestamo, PDO::PARAM_STR);
            $stat->bindValue('estado', 'Aprobado', PDO::PARAM_STR);
            $stat->bindValue('asesor_nuevo', $credito->asesor_nuevo, PDO::PARAM_STR);
            $stat->bindValue('asesor_viejo', $credito->asesor_viejo, PDO::PARAM_STR);
            $stat->execute();
            
        }

        echo 'true';

    }catch(PDOException $e){
        error_log($e->getMessage());
        echo 'false';
    }

}

?>