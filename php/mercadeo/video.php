<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'POST':
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];

                switch ($accion) {
                    case 'agregar':
                        if (isset($_POST['id'])) {
                            $id = $_POST['id'];
                        }

                        if (isset($_POST['titulo'])) {
                            $titulo = $_POST['titulo'];
                        }

                        if (isset($_POST['enlace'])) {
                            $enlace = $_POST['enlace'];
                        }

                        if (isset($_POST['fecha'])) {
                            $fecha = $_POST['fecha'];
                        }

                        if (isset($_POST['youtubeId'])) {
                            $youtubeId = $_POST['youtubeId'];
                        }

                        if (isset($_POST['usuario'])) {
                            $usuario = $_POST['usuario'];
                        }

                        if (isset($_POST['estado'])) {
                            $estado = $_POST['estado'];
                        }

                        $stat = $conn->prepare('call guardar_video(?,?,?,?,?,?);');
                        $stat->bindParam(1, $titulo, PDO::PARAM_STR);
                        $stat->bindParam(2, $enlace, PDO::PARAM_STR);
                        $stat->bindParam(3, $fecha, PDO::PARAM_STR);
                        $stat->bindParam(4, $youtubeId, PDO::PARAM_STR);
                        $stat->bindParam(5, $usuario, PDO::PARAM_STR);
                        $stat->bindParam(6, $estado, PDO::PARAM_INT);

                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);
                        } else {
                            $respuesta = array('error' => 1);
                        }

                        echo json_encode($respuesta, 16);
                        break;

                    case 'actualizar':
                        if (isset($_POST['id'])) {
                            $id = $_POST['id'];
                        }

                        if (isset($_POST['titulo'])) {
                            $titulo = $_POST['titulo'];
                        }

                        if (isset($_POST['enlace'])) {
                            $enlace = $_POST['enlace'];
                        }

                        if (isset($_POST['fecha'])) {
                            $fecha = $_POST['fecha'];
                        }

                        if (isset($_POST['youtubeId'])) {
                            $youtubeId = $_POST['youtubeId'];
                        }

                        if (isset($_POST['usuario'])) {
                            $usuario = $_POST['usuario'];
                        }

                        if (isset($_POST['estado'])) {
                            $estado = $_POST['estado'];
                        }

                        $stat = $conn->prepare('call actualizar_video(?,?,?,?,?,?,?);');
                        $stat->bindParam(1, $id, PDO::PARAM_INT);
                        $stat->bindParam(2, $titulo, PDO::PARAM_STR);
                        $stat->bindParam(3, $enlace, PDO::PARAM_STR);
                        $stat->bindParam(4, $fecha, PDO::PARAM_STR);
                        $stat->bindParam(5, $youtubeId, PDO::PARAM_STR);
                        $stat->bindParam(6, $usuario, PDO::PARAM_STR);
                        $stat->bindParam(7, $estado, PDO::PARAM_INT);

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
                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];
                        }

                        $stat = $conn->prepare('call mostrar_video(?);');
                        $stat->bindParam(1, $id, PDO::PARAM_INT);

                        $stat->execute();

                        $video = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($video, 64);
                        break;

                    case 'listar':
                        if (isset($_GET['estado'])) {
                            $estado = $_GET['estado'];
                        }

                        $stat = $conn->prepare('call mostrar_videos(?);');
                        $stat->bindParam(1, $estado, PDO::PARAM_INT);

                        $stat->execute();

                        $videos = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($videos, 64);
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