<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'POST':
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];

                switch ($accion) {
                    case 'agregar-archivo':
                        if (isset($_POST['departamentoId'])) {
                            $departamentoId = $_POST['departamentoId'];
                        }
            
                        if (isset($_POST['url'])) {
                            $url = $_POST['url'];
                        }
            
                        if (isset($_POST['estado'])) {
                            $estado = $_POST['estado'];
                        }
            
                        $stat = $conn->prepare('call guardar_imagen_departamento(?, ?, ?);');
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

                    case 'eliminar':
                        if (isset($_POST['departamentoId'])) {
                            $departamentoId = $_POST['departamentoId'];
                        }

                        if (isset($_POST['imagenDepartamentoId'])) {
                            $imagenDepartamentoId = $_POST['imagenDepartamentoId'];
                        }

                        $stat = $conn->prepare('call eliminar_imagen_departamento(?, ?);');
                        $stat->bindParam(1, $departamentoId, PDO::PARAM_STR);
                        $stat->bindParam(2, $imagenDepartamentoId, PDO::PARAM_INT);

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
            }

            switch ($accion) {
                case 'listar-todos':
                    $stat = $conn->prepare('call obtener_imagenes_departamentos();');
                    $stat->execute();

                    $departamentos = $stat->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($departamentos, 64);
                    break;

                case 'listar':
                    if (isset($_GET['departamentoId'])) {
                        $departamentoId = $_GET['departamentoId'];
                    }

                    $stat = $conn->prepare('call obtener_imagen_departamento(?);');
                    $stat->bindParam(1, $departamentoId, PDO::PARAM_STR);
                    $stat->execute();

                    $departamentos = $stat->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($departamentos, 64);
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