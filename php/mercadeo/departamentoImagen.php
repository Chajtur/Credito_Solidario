<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'POST':
            if (isset($_POST['departamentoId'])) {
                $departamentoId = $_POST['departamentoId'];
            }

            if (isset($_POST['url'])) {
                $url = $_POST['url'];
            }

            if (isset($_POST['estado'])) {
                $estado = $_POST['estado'];
            }

            $stat = $conn->prepare('call guardar_imagen_departamento(?, ?, ?)');
            $stat->bindParam(1, $departamentoId, PDO::PARAM_STR);
            $stat->bindParam(2, $url, PDO::PARAM_STR);
            $stat->bindParam(3, $estado, PDO::PARAM_INT);            

            if ($stat->execute()) {
                $respuesta = array('error' => 0);
            } else {
                $respuesta = array('error' => 1);
            }

            echo json_encode($respuesta, 16);
            break;
        
        default:
            # code...
            break;
    }
?>