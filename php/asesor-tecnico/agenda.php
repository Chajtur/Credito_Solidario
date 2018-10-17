<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if ($requestMethod == 'POST') {
        if (isset($_POST['accion'])) {          
          $accion = $_POST['accion'];

            switch ($accion) {
                case 'agregar':
                
                    if (isset($_POST['beneficiarioId'])) {
                        $beneficiarioId = $_POST['beneficiarioId'];
                    }

                    if (isset($_POST['detalle'])) {
                        $detalle = $_POST['detalle'];
                    }

                    if (isset($_POST['fecha'])) {
                        $fecha = $_POST['fecha'];
                    }

                    if (isset($_POST['usuario'])) {
                        $usuario = $_POST['usuario'];
                    }

                    if (isset($_POST['longitud'])) {
                        $longitud = $_POST['longitud'];
                    }

                    if (isset($_POST['latitud'])) {
                        $latitud = $_POST['latitud'];
                    }

                    if (isset($_POST['tipo-visita'])) {
                        $tipoVisita = $_POST['tipo-visita'];
                    }

                    if (isset($_POST['domicilio'])) {
                        $domicilio = $_POST['domicilio'];
                    }

                    $stat = $conn->prepare('call guardar_tarea(?,?,?,?,?,?,?,?);');
                    $stat->bindParam(1, $fecha, PDO::PARAM_STR);
                    $stat->bindParam(2, $usuario, PDO::PARAM_STR);
                    $stat->bindParam(3, $beneficiarioId, PDO::PARAM_STR);
                    $stat->bindParam(4, $detalle, PDO::PARAM_STR);
                    $stat->bindParam(5, $latitud, PDO::PARAM_STR);
                    $stat->bindParam(6, $longitud, PDO::PARAM_STR);
                    $stat->bindParam(7, $tipoVisita, PDO::PARAM_INT);
                    $stat->bindParam(8, $domicilio, PDO::PARAM_INT);

                    if ($stat->execute()) {
                        $respuesta = array('error' => 0);
                    } else {
                        $respuesta = array('error' => 1);
                    }

                    echo json_encode($respuesta, 16);
                    break;

                case 'editar':
                    if (isset($_POST['tareaId'])) {
                        $tareaId = $_POST['tareaId'];
                    }

                    if (isset($_POST['beneficiarioId'])) {
                        $beneficiarioId = $_POST['beneficiarioId'];
                    }

                    if (isset($_POST['detalle'])) {
                        $detalle = $_POST['detalle'];
                    }

                    if (isset($_POST['fecha'])) {
                        $fecha = $_POST['fecha'];
                    }

                    if (isset($_POST['usuario'])) {
                        $usuario = $_POST['usuario'];
                    }

                    if (isset($_POST['longitud'])) {
                        $longitud = $_POST['longitud'];
                    }

                    if (isset($_POST['latitud'])) {
                        $latitud = $_POST['latitud'];
                    }

                    if (isset($_POST['tipo-visita'])) {
                        $tipoVisita = $_POST['tipo-visita'];
                    }

                    if (isset($_POST['domicilio'])) {
                        $domicilio = $_POST['domicilio'];
                    }

                    $stat = $conn->prepare('call editar_tarea(?,?,?,?,?,?,?);');
                    $stat->bindParam(1, $beneficiarioId, PDO::PARAM_STR);
                    $stat->bindParam(2, $detalle, PDO::PARAM_STR);
                    $stat->bindParam(3, $usuario, PDO::PARAM_STR);
                    $stat->bindParam(4, $fecha, PDO::PARAM_STR);
                    $stat->bindParam(5, $tipoVisita, PDO::PARAM_INT);
                    $stat->bindParam(6, $domicilio, PDO::PARAM_INT);
                    $stat->bindParam(7, $tareaId, PDO::PARAM_INT);

                    if ($stat->execute()) {
                        $respuesta = array('error' => 0);
                    } else {
                        $respuesta = array('error' => 1);
                    }

                    echo json_encode($respuesta, 16);
                    break;

                case 'eliminar' :
                    if (isset($_POST['tareaId'])) {
                        $tareaId = $_POST['tareaId'];
                    }

                    $stat = $conn->prepare('call eliminar_tarea(?);');
                    $stat->bindParam(1, $tareaId, PDO::PARAM_INT);

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
        }
    } else {
        if (isset($_GET['accion'])) {
            $accion = $_GET['accion'];

            switch ($accion) {
                case 'listar':
                    if (isset($_GET['fecha'])) {
                        $fecha = $_GET['fecha'];
                    }

                    if (isset($_GET['usuario'])) {
                        $usuario = $_GET['usuario'];
                    }

                    $stat = $conn->prepare('call obtener_tareas(?,?);');
                    $stat->bindParam(1, $fecha, PDO::PARAM_STR);
                    $stat->bindParam(2, $usuario, PDO::PARAM_STR);

                    $stat->execute();

                    $tareas = $stat->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($tareas, 16);
                    break;

                case 'editar':
                    if (isset($_GET['tareaId'])) {
                        $tareaId = $_GET['tareaId'];
                    }

                    $stat = $conn->prepare('call obtener_tarea(?);');
                    $stat->bindParam(1, $tareaId, PDO::PARAM_INT);

                    $stat->execute();

                    $tarea = $stat->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($tarea, 16);
                    break;
                default:
                    # code...
                    break;
            }
        }
    }

    function obtenertareas($fecha, $usuario) {
        return obtener_tareas($fecha, $usuario);
    }

    function obtenertarea($tareaId) {
        return obtener_tarea($tareaId);
    }
?>
