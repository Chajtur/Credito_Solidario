<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'POST':
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];

                switch ($accion) {
                    case 'agregar':
                        if (isset($_POST['estado'])) {
                            $estado = $_POST['estado'];
                        }

                        if (isset($_POST['url'])) {
                            $url = $_POST['url'];
                        }

                        $stat = $conn->prepare('call guardar_imagen_banco(?,?);');
                        $stat->bindParam(1, $url, PDO::PARAM_STR);
                        $stat->bindParam(2, $estado, PDO::PARAM_INT);

                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);
                        } else {
                            $respuesta = array('error' => 1);
                        }

                        echo json_encode($respuesta, 16);
                        break;

                    case 'eliminar':
                        if (isset($_POST['bancoImagenId'])) {
                            $bancoImagenId = $_POST['bancoImagenId'];
                        }

                        $stat = $conn->prepare('call eliminar_imagen_banco(?);');
                        $stat->bindParam(1, $bancoImagenId, PDO::PARAM_INT);

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
                    case 'listar':
                        if (isset($_GET['estado'])) {
                            $estado = $_GET['estado'];
                        }

                        $stat = $conn->prepare('call obtener_imagenes_banco(?);');
                        $stat->bindParam(1, $estado, PDO::PARAM_INT);

                        $stat->execute();

                        $imagenes = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($imagenes, 64);
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