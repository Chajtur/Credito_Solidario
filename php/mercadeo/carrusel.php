<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'POST':
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];

                switch ($accion) {
                    case 'agregar':
                        if (isset($_POST['etiquetaPrincipal'])) {
                            $etiquetaPrincipal = $_POST['etiquetaPrincipal'];
                        }

                        if (isset($_POST['etiquetaSecundaria'])) {
                            $etiquetaSecundaria = $_POST['etiquetaSecundaria'];
                        }

                        if (isset($_POST['alineacion'])) {
                            $alineacion = $_POST['alineacion'];
                        }

                        if (isset($_POST['estado'])) {
                            $estado = $_POST['estado'];
                        }

                        if (isset($_POST['url'])) {
                            $url = $_POST['url'];
                        }

                        if (isset($_POST['usuario'])) {
                            $usuario = $_POST['usuario'];
                        }

                        $stat = $conn->prepare('call guardar_imagen_carrusel(?,?,?,?,?,?)');
                        $stat->bindParam(1, $etiquetaPrincipal, PDO::PARAM_STR);
                        $stat->bindParam(2, $etiquetaSecundaria, PDO::PARAM_STR);
                        $stat->bindParam(3, $alineacion, PDO::PARAM_INT);
                        $stat->bindParam(4, $estado, PDO::PARAM_INT);
                        $stat->bindParam(5, $url, PDO::PARAM_STR);
                        $stat->bindParam(6, $usuario, PDO::PARAM_STR);

                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);
                        } else {
                            $respuesta = array('error' => 1);
                        }

                        echo json_encode($respuesta, 16);
                        break;

                    case 'actualizar':
                        if (isset($_POST['carruselId'])) {
                            $carruselId = $_POST['carruselId'];
                        }

                        if (isset($_POST['etiquetaPrincipal'])) {
                            $etiquetaPrincipal = $_POST['etiquetaPrincipal'];
                        }

                        if (isset($_POST['etiquetaSecundaria'])) {
                            $etiquetaSecundaria = $_POST['etiquetaSecundaria'];
                        }

                        if (isset($_POST['alineacion'])) {
                            $alineacion = $_POST['alineacion'];
                        }

                        if (isset($_POST['usuario'])) {
                            $usuario = $_POST['usuario'];
                        }

                        $stat = $conn->prepare('call actualizar_imagen_carrusel(?,?,?,?,?);');
                        $stat->bindParam(1, $carruselId, PDO::PARAM_INT);
                        $stat->bindParam(2, $etiquetaPrincipal, PDO::PARAM_STR);
                        $stat->bindParam(3, $etiquetaSecundaria, PDO::PARAM_STR);
                        $stat->bindParam(4, $alineacion, PDO::PARAM_INT);
                        $stat->bindParam(5, $usuario, PDO::PARAM_STR);

                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);
                        } else {
                            $respuesta = array('error' => 1);
                        }

                        echo json_encode($respuesta, 16);
                        break;

                    case 'eliminar':
                        if (isset($_POST['carruselId'])) {
                            $carruselId = $_POST['carruselId'];
                        }

                        $stat = $conn->prepare('call eliminar_imagen_carrusel(?);');
                        $stat->bindParam(1, $carruselId, PDO::PARAM_INT);

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
                        if (isset($_GET['carruselId'])) {
                            $carruselId = $_GET['carruselId'];
                        }

                        $stat = $conn->prepare('call mostrar_imagen_carrusel(?)');
                        $stat->bindParam(1, $carruselId, PDO::PARAM_INT);

                        $stat->execute();

                        $imagen = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($imagen, 64);
                        break;
                    
                    case 'listar':
                        if (isset($_GET['estado'])) {
                            $estado = $_GET['estado'];
                        }

                        $stat = $conn->prepare('call mostrar_imagenes_carrusel(?)');
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