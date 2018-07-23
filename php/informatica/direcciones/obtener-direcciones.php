<?php

require '../../conection.php';

if(isset($_GET['departamento'])){

    $stat = $conn->prepare('call get_direcciones(:codigo, :parametro);');
    $stat->bindValue(':codigo', '', PDO::PARAM_STR);
    $stat->bindValue(':parametro', '5', PDO::PARAM_STR);
    if($stat->execute()){
        $result = $stat->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }else{
        echo 'false';
    }

}

if(isset($_GET['municipio'], $_POST['data'])){

    $obj = json_decode($_POST['data']);
    $stat = $conn->prepare('call get_direcciones(:codigo, :parametro);');
    $stat->bindValue(':codigo', $obj[0], PDO::PARAM_STR);
    $stat->bindValue(':parametro', '4', PDO::PARAM_STR);
    if($stat->execute()){
        $result = $stat->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }else{
        echo 'false';
    }
    
}

if(isset($_GET['aldea'], $_POST['data'])){
    
    $obj = json_decode($_POST['data']);
    $stat = $conn->prepare('call get_direcciones(:codigo, :parametro);');
    $stat->bindValue(':codigo', $obj[0].$obj[1], PDO::PARAM_STR);
    $stat->bindValue(':parametro', '3', PDO::PARAM_STR);
    if($stat->execute()){
        $result = $stat->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }else{
        echo 'false';
    }
    
}

if(isset($_GET['caserio'], $_POST['data'])){

    $obj = json_decode($_POST['data']);
    $stat = $conn->prepare('call get_direcciones(:codigo, :parametro);');
    $stat->bindValue(':codigo', $obj[0].$obj[1].$obj[2], PDO::PARAM_STR);
    $stat->bindValue(':parametro', '2', PDO::PARAM_STR);
    if($stat->execute()){
        $result = $stat->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }else{
        echo 'false';
    }

}

if(isset($_GET['barrio'], $_POST['data'])){

    $obj = json_decode($_POST['data']);
    $stat = $conn->prepare('call get_direcciones(:codigo, :parametro);');
    $stat->bindValue(':codigo', $obj[0].$obj[1].$obj[2].$obj[3], PDO::PARAM_STR);
    $stat->bindValue(':parametro', '1', PDO::PARAM_STR);
    if($stat->execute()){
        $result = $stat->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }else{
        echo 'false';
    }

}

?>