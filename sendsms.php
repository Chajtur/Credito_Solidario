<?php

function sendSMS($url, $data = false){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data));

    $response = curl_exec($curl);
    if($response = "OK"){
        return true;
    }
    return false;
}

try{
    
    $conn1 = new PDO('mysql:host=imhonduras.com;dbname=alertas','admin','Xcphoky3', array(
        PDO::ATTR_PERSISTENT => true //El hecho que las conexiones sean persistentes provoca que haya un aumento en la velocidad de las consultas, pero puede existir una sobrecarga en el servidor de MySql
    ));
    
    $stat = $conn1->prepare("Select * from outbox limit 100");
    $stat->execute();
    $mensajes = $stat->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($mensajes as $fila) {
        $data = array("phone" => $fila['Celular'], "message" => $fila['Mensaje']);
        if(sendSMS("http://192.168.1.141:8080/v1/sms")){
            $stat = $conn1->prepare("Insert into enviados(mensaje, celular) values (:texto, :celular)");
            $stat->bindValue(':texto', $fila['Mensaje'], PDO::PARAM_STR);
            $stat->bindValue(':celular', $fila['Celular'], PDO::PARAM_STR);
            $stat->execute();
            $stat = $conn->prepare("Delete from outbox where no = :id");
            $stat->bindValue(':id', $fila['No'], PDO::PARAM_STR);
            $stat->execute();        
            echo "Datos " . $fila['Mensaje'] . " " . $fila['Celular'] . " borrado";
        }
    }
    echo 'entró';

catch(PDOException $e){
    echo "Error ".$e->getCode();
}
    
?>