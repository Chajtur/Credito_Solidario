<?php 

require '../../php/conection.php';
session_start();

if(isset($_POST['data'])){

    $array = json_decode($_POST['data']);

    $conn4->beginTransaction();

    try{

        $stat = $conn4->prepare('call guardar_respuestas(1, :idpregunta, :respuesta, :usuario);');
        
        foreach($array as $pregunta){
            
            $stat->bindValue(':idpregunta', $pregunta->idpregunta, PDO::PARAM_INT);
            $stat->bindValue(':respuesta', $pregunta->respuesta, PDO::PARAM_STR);
            $stat->bindValue(':usuario', $_SESSION['user'], PDO::PARAM_STR);
            if($stat->execute()){
                // error_log('correcto');
                // error_log(json_encode($stat->errorInfo()));
            }else{
                // error_log('error');
                // error_log(json_encode($stat->errorInfo()));
            }
            $result = $stat->fetchAll();
            $stat->closeCursor();

        }

        $conn4->commit();
        echo 'true';

    }catch(PDOException $e){

        $conn4->rollBack();
        echo 'false';

    }
    

}

?>