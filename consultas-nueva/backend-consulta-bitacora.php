<?php

if(isset($_POST['id'])){

    require '../php/conection.php';
    $stat = $conn->prepare('select estado_credito, fecha, observacion, razon, id_credito from bitacora_creditos 
    where id_credito = :id order by fecha DESC');
    $stat->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
    $stat->execute();
    $result = $stat->fetchAll(PDO::FETCH_ASSOC);
    $stat_observaciones = $conn->prepare('select * from bitacora_creditos 
    where estado_credito = :estado and razon = :razon and id_credito = :id');
    $i=1;

    foreach($result as $fila){

        if($fila['estado_credito'] == "Para Correccion"){

            $stat_observaciones->bindValue(':estado', $result[$i-1]['estado_credito'], PDO::PARAM_STR);
            $stat_observaciones->bindValue(':razon', "Correccion ".$result[$i-1]['estado_credito'], PDO::PARAM_STR);
            $stat_observaciones->bindValue(':id', $fila['id_credito'], PDO::PARAM_STR);
            $stat_observaciones->execute();
            $data = $stat_observaciones->fetchAll(PDO::FETCH_ASSOC);
            $result[$i]['observacion'] = '';
            $j=1;

            foreach($data as $fil){
                $result[$i]['observacion'] .= $fil['observacion'];
                $result[$i]['observacion'] .= ($j < count($data) ? ', <br>' : '');
                $j++;
            }

            if(count($data) == 0){
                $result[$i]['observacion'] = 'Integrante de grupo con corrección';
            }

        }

        $i++;

    }

    echo json_encode($result);

}

?>