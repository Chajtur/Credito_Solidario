<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($variable) {
        case 'POST':
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];

                switch ($accion) {
                    case 'agregar-empleado':
                        if (isset($_POST['identidad-beneficiario'])) {
                            $identidadBeneficiario = $_POST['identidad-beneficiario'];
                        }

                        if (isset($_POST['identidad-empleado'])) {
                            $identidadEmpleado = $_POST['identidad-empleado'];
                        }

                        if (isset($_POST['nombre'])) {
                            $nombre = $_POST['nombre'];
                        }

                        $stat = $conn->prepare('call guardar_empleado_beneficiario(?,?,?)');
                        $stat->bindParam(1, $identidadBeneficiario, PDO::PARAM_INT);
                        $stat->bindParam(2, $identidadEmpleado, PDO::PARAM_INT);
                        $stat->bindParam(3, $nombre, PDO::PARAM_STR);

                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);

                            echo json_encode($respuesta, 16);
                        } else {
                            $respuesta = array('error' => 1);

                            echo json_encode($respuesta, 16);
                        }
                        break;

                    case 'actualizar-empleado':
                        if (isset($_POST['identidad-beneficiario'])) {
                            $identidadBeneficiario = $_POST['identidad-beneficiario'];
                        }

                        if (isset($_POST['identidad-empleado'])) {
                            $identidadEmpleado = $_POST['identidad-empleado'];
                        }

                        if (isset($_POST['nombre'])) {
                            $nombre = $_POST['nombre'];
                        }

                        $stat = $conn->prepare('call actualizar_empleado_beneficiario(?,?,?)');
                        $stat->bindParam(1, $identidadBeneficiario, PDO::PARAM_INT);
                        $stat->bindParam(2, $identidadEmpleado, PDO::PARAM_INT);
                        $stat->bindParam(3, $nombre, PDO::PARAM_STR);
                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);

                            echo json_encode($respuesta, 16);
                        } else {
                            $respuesta = array('error' => 1);

                            echo json_encode($respuesta, 16);
                        }
                        break;

                    case 'eliminar-empleado':
                        if (isset($_POST['identidad-beneficiario'])) {
                            $identidadBeneficiario = $_POST['identidad-beneficiario'];
                        }

                        if (isset($_POST['identidad-empleado'])) {
                            $identidadEmpleado = $_POST['identidad-empleado'];
                        }

                        $stat = $conn->prepare('call eliminar_empleado_beneficiario(?,?)');
                        $stat->bindParam(1, $identidadBeneficiario, PDO::PARAM_INT);
                        $stat->bindParam(2, $identidadEmpleado, PDO::PARAM_INT);
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
            # code...
            break;

        case 'GET':
            if (isset($_GET['accion'])) {
                $accion = $_GET['accion'];

                switch ($accion) {
                    case 'listar-empleados':
                        if (isset($_POST['identidad-beneficiario'])) {
                            $identidadBeneficiario = $_POST['identidad-beneficiario'];
                        }

                        $stat = $conn->prepare('call obtener_empleados(?);');
                        $stat->bindParam(1, $identidadBeneficiario, PDO::PARAM_INT);
                        $stat->execute();

                        $noticias = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($noticias, 64);
                        break;

                    case '':
                        if (isset($_POST['identidad-beneficiario'])) {
                            $identidadBeneficiario = $_POST['identidad-beneficiario'];
                        }

                        if (isset($_POST['identidad-empleado'])) {
                            $identidadEmpleado = $_POST['identidad-empleado'];
                        }

                        $stat = $conn->prepare('call obtener_empleado(?, ?);');
                        $stat->bindParam(1, $identidadBeneficiario, PDO::PARAM_INT);
                        $stat->bindParam(2, $identidadEmpleado, PDO::PARAM_INT);
                        $stat->execute();

                        $noticias = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($noticias, 64);
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