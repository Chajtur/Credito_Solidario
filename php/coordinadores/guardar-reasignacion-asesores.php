<?php

require '../conection.php';

if(isset($_POST['data'])){

    $obj = json_decode($_POST['data']);
    
    $stat = $conn->prepare('update gsc set parent = :supervisor where id = :asesor');

    try{

        foreach($obj as $supervisor => $datos){

            $stat->bindValue(':supervisor', $supervisor, PDO::PARAM_STR);

            foreach($datos->agregar as $asesor){

                $stat->bindValue(':asesor', $asesor, PDO::PARAM_STR);
                $stat->execute();

            }

        }
        
        echo 'true';

    }catch(PDOException $e){

        echo 'false';

    }

}

?>