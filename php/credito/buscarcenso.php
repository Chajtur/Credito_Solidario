<?php
if(isset($_POST['id'])){
    
    try{

        require_once "../conection.php"; 
        $stat = $conn3->prepare('select * from censo where identidad = :id');
        $stat->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
        
        if($stat->execute()){
            
            $bool = false;
            
            $result = $stat->fetchAll();
            foreach($result as $dato){
                
                $bool = true;
                $primerNombre = $dato['primerNombre'];
                $primerApellido = $dato['primerApellido'];
                $segundoNombre = $dato['segundoNombre'];
                $segundoApellido = $dato['segundoApellido'];
                $genero = $dato['codigoSexo'];
                
            }
            
            if($bool){

                $obj = (object) array(
                    "nombre" => $primerNombre.' '.$segundoNombre.' '.$primerApellido.' '.$segundoApellido,
                    "genero" => $genero
                );

                echo json_encode($obj);
                
            }else{
                
                echo "No esta en el censo";
                
            }
            
        }

    }catch(PDOException $e){

        echo $e->getMessage();

    }
    
}

?>