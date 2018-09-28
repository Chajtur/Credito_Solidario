<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'POST':
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];

                switch ($accion) {
                    case 'agregar-datos':
                        if (isset($_POST['nombre'])) {
                            $nombre = $_POST['nombre'];
                        }

                        if (isset($_POST['cargo'])) {
                            $cargo = $_POST['cargo'];
                        }

                        if (isset($_POST['url'])) {
                            $url = $_POST['url'];
                        }

                        if (isset($_POST['estado'])) {
                            $estado = $_POST['estado'];
                        }
                        
                        $stat = $conn->stat('call guardar_usuarios_pagina(?,?,?,?);');
                        $stat->bindParam(1, $nombre, PDO::PARAM_STR);
                        $stat->bindParam(2, $cargo, PDO::PARAM_STR);
                        $stat->bindParam(3, $url, PDO::PARAM_STR);
                        $stat->bindParam(4, $estado, PDO::PARAM_INT);

                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);
                        } else {
                            $respuesta = array('error' => 1);
                        }

                        echo json_encode($respuesta, 16);
                        break;

                    case 'actualizar-datos':
                        if (isset($_POST['id'])) {
                            $id = $_POST['id'];
                        }

                        if (isset($_POST['nombre'])) {
                            $nombre = $_POST['nombre'];
                        }

                        if (isset($_POST['cargo'])) {
                            $cargo = $_POST['cargo'];
                        }

                        $stat = $conn->stat('call actualizar_usuario_pagina(?,?,?,?);');
                        $stat->bindParam(1, $id, PDO::PARAM_INT);
                        $stat->bindParam(2, $nombre, PDO::PARAM_STR);
                        $stat->bindParam(3, $cargo, PDO::PARAM_STR);
                        $stat->bindParam(4, $estado, PDO::PARAM_INT);

                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);
                        } else {
                            $respuesta = array('error' => 1);
                        }

                        echo json_encode($respuesta, 16);
                        break;

                    case 'agregar-imagen':
                        if (isset($_POST['id'])) {
                            $id = $_POST['id'];
                        }

                        if (isset($_POST['url'])) {
                            $url = $_POST['url'];
                        }

                        $stat = $conn->stat('call actualizar_imagen_usuario_pagina(?,?,?);');
                        $stat->bindParam(1, $id, PDO::PARAM_INT);
                        $stat->bindParam(2, $url, PDO::PARAM_STR);

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
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];
                
                switch ($accion) {
                    case 'listar':
                        if (isset($_POST['estado'])) {
                            $estado = $_POST['estado'];
                        }

                        $stat = $conn->prepare('call listar_usuarios_pagina(?);');
                        $stat->bindParam(1, $estado, PDO::PARAM_INT);

                        $stat->execute();

                        $imagenes = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($imagenes, 64);
                        break;

                    case 'mostrar':
                        if (isset($_POST['id'])) {
                            $estado = $_POST['id'];
                        }

                        $stat = $conn->prepare('call mostrar_usuario_pagina(?);');
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