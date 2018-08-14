<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'POST':
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];

                switch ($accion) {
                    case 'actualizar':
                        if (isset($_POST['directorId'])) {
                            $directorId = $_POST['directorId'];
                        }

                        if (isset($_POST['frase'])) {
                            $frase = $_POST['frase'];
                        }

                        $stat = $conn->prepare('call actualizar_datos_director(?,?);');
                        $stat->bindParam(1, $directorId, PDO::PARAM_INT);
                        $stat->bindParam(2, $frase, PDO::PARAM_STR);

                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);
                        } else {
                            $respuesta = array('error' => 1);
                        }

                        echo json_encode($respuesta, 16);
                        break;

                    case 'actualizar-imagen':
                        if (isset($_POST['directorId'])) {
                            $directorId = $_POST['directorId'];
                        }

                        if (isset($_POST['url'])) {
                            $url = $_POST['url'];
                        }

                        $stat = $conn->prepare('call actualizar_imagen_director(?,?);');
                        $stat->bindParam(1, $directorId, PDO::PARAM_INT);
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
            if (isset($_GET['accion'])) {
                $accion = $_GET['accion'];

                switch ($accion) {
                    case 'mostrar':
                        if (isset($_GET['directorId'])) {
                            $directorId = $_GET['directorId'];
                        }

                        $stat = $conn->prepare('call obtener_director(?);');
                        $stat->bindParam(1, $directorId, PDO::PARAM_INT);

                        $stat->execute();

                        $director = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($director, 64);
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