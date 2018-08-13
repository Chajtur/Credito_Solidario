<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'POST':
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];

                switch ($accion) {
                    case 'agregar':
                        if (isset($_POST['programaId'])) {
                            $programaId = $_POST['programaId'];
                        }

                        if (isset($_POST['subprograma'])) {
                            $subprograma = $_POST['subprograma'];
                        }

                        if (isset($_POST['descripcion'])) {
                            $descripcion = $_POST['descripcion'];
                        }

                        if (isset($_POST['programa'])) {
                            $programa = $_POST['programa'];
                        }

                        if (isset($_POST['url'])) {
                            $url = $_POST['url'];
                        }

                        $stat = $conn->prepare('call guardar_programa(?,?,?,?,?);');
                        $stat->bindParam(1, $programaId, PDO::PARAM_STR);
                        $stat->bindParam(2, $subprograma, PDO::PARAM_STR);
                        $stat->bindParam(3, $descripcion, PDO::PARAM_STR);
                        $stat->bindParam(4, $programa, PDO::PARAM_STR);
                        $stat->bindParam(5, $url, PDO::PARAM_STR);

                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);
                        } else {
                            $respuesta = array('error' => 1);
                        }

                        echo json_encode($respuesta, 16);
                        break;

                    case 'actualizar':
                        if (isset($_POST['programaId'])) {
                            $programaId = $_POST['programaId'];
                        }

                        if (isset($_POST['subprograma'])) {
                            $subprograma = $_POST['subprograma'];
                        }

                        if (isset($_POST['descripcion'])) {
                            $descripcion = $_POST['descripcion'];
                        }

                        if (isset($_POST['programa'])) {
                            $programa = $_POST['programa'];
                        }

                        $stat = $conn->prepare('call actualizar_programa(?,?,?,?);');
                        $stat->bindParam(1, $programaId, PDO::PARAM_STR);
                        $stat->bindParam(2, $subprograma, PDO::PARAM_STR);
                        $stat->bindParam(3, $descripcion, PDO::PARAM_STR);
                        $stat->bindParam(4, $programa, PDO::PARAM_STR);

                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);
                        } else {
                            $respuesta = array('error' => 1);
                        }

                        echo json_encode($respuesta, 16);
                        break;

                    case 'actualizar-imagen':
                        if (isset($_POST['programaId'])) {
                            $programaId = $_POST['programaId'];
                        }

                        if (isset($_POST['url'])) {
                            $url = $_POST['url'];
                        }

                        $stat = $conn->prepare('call actualizar_imagen_programa(?,?);');
                        $stat->bindParam(1, $programaId, PDO::PARAM_STR);
                        $stat->bindParam(2, $url, PDO::PARAM_STR);

                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);
                        } else {
                            $respuesta = array('error' => 1);
                        }

                        echo json_encode($respuesta, 16);
                        break;

                    case 'eliminar':
                        if (isset($_POST['programaId'])) {
                            $programaId = $_POST['programaId'];
                        }

                        $stat = $conn->prepare('call eliminar_imagen_programa(?);');
                        $stat->bindParam(1, $programaId, PDO::PARAM_STR);

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
            break;

        case 'GET':
            if (isset($_GET['accion'])) {
                $accion = $_GET['accion'];

                switch ($accion) {
                    case 'mostrar':
                        if (isset($_GET['programaId'])) {
                            $programaId = $_GET['programaId'];
                        }

                        $stat = $conn->prepare('call mostrar_programa(?);');
                        $stat->bindParam(1, $programaId, PDO::PARAM_STR);

                        $stat->execute();

                        $programa = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($programa, 64);
                        break;

                    case 'listar':
                        if (isset($_GET['estado'])) {
                            $estado = $_GET['estado'];
                        }

                        if (isset($_GET['busqueda'])) {
                            $busqueda = $_GET['busqueda'];
                        }

                        $stat = $conn->prepare('call mostrar_programas(?,?);');
                        $stat->bindParam(1, $estado, PDO::PARAM_INT);
                        $stat->bindParam(2, $busqueda, PDO::PARAM_STR);

                        $stat->execute();

                        $programas = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($programas, 64);
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
            break;
        
        default:
            # code...
            break;
    }
?>