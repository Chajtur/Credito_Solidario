<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'POST':
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];
                switch ($accion) {
                    case 'agregar':
                        if (isset($_POST['titulo'])) {
                            $titulo = $_POST['titulo'];
                        }

                        if (isset($_POST['contenido'])) {
                            $contenido = $_POST['contenido'];
                        }

                        if (isset($_POST['resumen'])) {
                            $resumen = $_POST['resumen'];
                        }

                        if (isset($_POST['fecha'])) {
                            $fecha = $_POST['fecha'];
                        }
                        
                        if (isset($_POST['estado'])) {
                            $estado = $_POST['estado'];
                        }

                        if (isset($_POST['usuario'])) {
                            $usuario = $_POST['usuario'];
                        }

                        if (isset($_POST['tipo'])) {
                            $tipo = $_POST['tipo'];
                        }

                       // $conn->beginTransaction();
                        $stat = $conn->prepare('call guardar_noticia(?, ?, ?, ?, ?, ?, ?, @noticiaId);');
                        $stat->bindParam(1, $titulo, PDO::PARAM_STR);
                        $stat->bindParam(2, $contenido, PDO::PARAM_STR);
                        $stat->bindParam(3, $resumen, PDO::PARAM_STR);
                        $stat->bindParam(4, $fecha, PDO::PARAM_STR);
                        $stat->bindParam(5, $estado, PDO::PARAM_STR);
                        $stat->bindParam(6, $tipo, PDO::PARAM_INT);
                        $stat->bindParam(7, $usuario, PDO::PARAM_STR);
                        //$stat->bindParam(7, $noticiaId, PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
                        $stat->execute();
                        $stat->closeCursor();

                        $noticia = $conn->query('select @noticiaId as noticiaId;')->fetch();
                        $noticiaId = $noticia['noticiaId'];

                        $noticia = array(
                            'noticiaId' => $noticiaId,
                            'titulo' => $titulo,
                            'contenido' => $contenido,
                            'resumen' => $resumen,
                            'fecha' => $fecha,
                            'estado' => $estado,
                            'usuario' => $usuario
                        );

                        echo json_encode($noticia, 16);                    
                        break;

                    case 'agregar-archivo':
                        if (isset($_POST['noticiaId'])) {
                            $noticiaId = $_POST['noticiaId'];
                        }

                        if (isset($_POST['url'])) {
                            $url = $_POST['url'];
                        }

                        $stat = $conn->prepare('call guardar_imagen_noticia(?, ?);');
                        $stat->bindParam(1, $noticiaId, PDO::PARAM_INT);
                        $stat->bindParam(2, $url, PDO::PARAM_STR);
                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);

                            echo json_encode($respuesta, 16);
                        } else {
                            $respuesta = array('error' => 1);

                            echo json_encode($respuesta, 16);
                        }
                        break;

                    case 'eliminar-imagen':
                        if (isset($_POST['noticiaId'])) {
                            $noticiaId = $_POST['noticiaId'];
                        }

                        if (isset($_POST['imagenId'])) {
                            $imagenId = $_POST['imagenId'];
                        }

                        $stat = $conn->prepare('call eliminar_imagen_noticia(?, ?);');
                        $stat->bindParam(1, $noticiaId, PDO::PARAM_INT);
                        $stat->bindParam(2, $imagenId, PDO::PARAM_INT);
                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);

                            echo json_encode($respuesta, 16);
                        } else {
                            $respuesta = array('error' => 1);

                            echo json_encode($respuesta, 16);
                        }
                        break;

                    case 'actualizar':
                        if (isset($_POST['noticiaId'])) {
                            $noticiaId = $_POST['noticiaId'];
                        }

                        if (isset($_POST['titulo'])) {
                            $titulo = $_POST['titulo'];
                        }

                        if (isset($_POST['contenido'])) {
                            $contenido = $_POST['contenido'];
                        }

                        if (isset($_POST['resumen'])) {
                            $resumen = $_POST['resumen'];
                        }

                        if (isset($_POST['fecha'])) {
                            $fecha = $_POST['fecha'];
                        }
                        
                        if (isset($_POST['estado'])) {
                            $estado = $_POST['estado'];
                        }

                        if (isset($_POST['usuario'])) {
                            $usuario = $_POST['usuario'];
                        }

                        if (isset($_POST['tipo'])) {
                            $tipo = $_POST['tipo'];
                        }

                        $stat = $conn->prepare('call actualizar_noticia(?,?,?,?,?,?,?,?);');
                        $stat->bindParam(1, $noticiaId, PDO::PARAM_INT);
                        $stat->bindParam(2, $titulo, PDO::PARAM_STR);
                        $stat->bindParam(3, $contenido, PDO::PARAM_STR);
                        $stat->bindParam(4, $resumen, PDO::PARAM_STR);
                        $stat->bindParam(5, $fecha, PDO::PARAM_STR);
                        $stat->bindParam(6, $estado, PDO::PARAM_INT);
                        $stat->bindParam(7, $tipo, PDO::PARAM_INT);
                        $stat->bindParam(8, $usuario, PDO::PARAM_STR);

                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);

                            echo json_encode($respuesta, 16);
                        } else {
                            $respuesta = array('error' => 1);

                            echo json_encode($respuesta, 16);
                        }
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
            }

            switch ($accion) {
                case 'listar':
                    $stat = $conn->prepare('call obtener_noticias();');
                    $stat->execute();

                    $noticias = $stat->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($noticias, 64);
                    break;

                case 'listar-pagina':
                    if (isset($_GET['tipo'])) {
                        $tipo = $_GET['tipo'];
                    }

                    if (isset($_GET['anio'])) {
                        $anio = $_GET['anio'];
                    }

                    $stat = $conn->prepare('call obtener_noticias_pagina(?, ?);');
                    $stat->bindParam(1, $tipo, PDO::PARAM_INT);
                    $stat->bindParam(2, $anio, PDO::PARAM_INT);
                    $stat->execute();

                    $noticias = $stat->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($noticias, 64);
                    break;

                case 'mostrar':
                    if (isset($_GET['noticiaId'])) {
                        $noticiaId = $_GET['noticiaId'];
                    }                        

                    $stat = $conn->prepare('call obtener_noticia(?);');
                    $stat->bindParam(1, $noticiaId, PDO::PARAM_INT);
                    $stat->execute();

                    $noticia = $stat->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($noticia, 16);
                    break;

                case 'listar-imagenes':
                    if (isset($_GET['noticiaId'])) {
                        $noticiaId = $_GET['noticiaId'];

                        $stat = $conn->prepare('call obtener_imagenes_noticia(?);');
                        $stat->bindParam(1, $noticiaId, PDO::PARAM_INT);
                        $stat->execute();

                        $imagenes = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($imagenes, 64);
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
            break;
        
        default:
            # code...
            break;
    }
?>