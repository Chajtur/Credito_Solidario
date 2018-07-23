<?php

if(isset($_POST['credito'])){
    
    try{
        
        require "../conection.php";

        $creditos = json_decode($_POST['credito']);
        
        $stat = $conn->prepare('update cartera_consolidada set Estatus_Prestamo = "Devuelto" where grupo_solidario_hash = :hash');
        
        foreach($creditos as $hash){
            
            $stat->bindValue(':hash', $hash, PDO::PARAM_STR);
            $stat->execute();
            
        }

        echo 'true';
        
    }catch(PDOException $e){
        
        echo 'false';
        
    }
    
    
}else{

    echo "No capturo";

}

?>