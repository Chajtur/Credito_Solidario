<?php

try{
    
    if(!isset($conn))
        $conn = new PDO('mysql:host=127.0.0.1;dbname=credito_solidario','credito_solidario_usr','12345678', array(
            PDO::ATTR_PERSISTENT => true //El hecho que las conexiones sean persistentes provoca que haya un aumento en la velocidad de las consultas, pero puede existir una sobrecarga en el servidor de MySql
        ));
    if(!isset($conn2))
        $conn2 = new PDO('mysql:host=127.0.0.1;dbname=larahrm','credito_solidario_usr','12345678', array(
            PDO::ATTR_PERSISTENT => true //El hecho que las conexiones sean persistentes provoca que haya un aumento en la velocidad de las consultas, pero puede existir una sobrecarga en el servidor de MySql
        ));
    if(!isset($conn3))
        $conn3 = new PDO('mysql:host=181.210.15.138;dbname=censo nacional','ricardo','icsric2016', array(
            PDO::ATTR_PERSISTENT => true //El hecho que las conexiones sean persistentes provoca que haya un aumento en la velocidad de las consultas, pero puede existir una sobrecarga en el servidor de MySql
        ));
    if(!isset($conn4))
        $conn4 = new PDO('mysql:host=181.210.15.138;dbname=encuestas','ricardo','icsric2016', array(
            PDO::ATTR_PERSISTENT => true //El hecho que las conexiones sean persistentes provoca que haya un aumento en la velocidad de las consultas, pero puede existir una sobrecarga en el servidor de MySql
        ));
        
}catch(PDOException $e){
    echo "Error ".$e->getCode();
}
    
?>