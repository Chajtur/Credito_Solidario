<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'POST':
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];

                switch ($accion) {
                    case 'agregar-empleado':
                        if (isset($_POST['identidadBeneficiario'])) {
                            $identidadBeneficiario = $_POST['identidadBeneficiario'];
                        }

                        if (isset($_POST['identidadEmpleado'])) {
                            $identidadEmpleado = $_POST['identidadEmpleado'];
                        }

                        if (isset($_POST['nombre'])) {
                            $nombre = $_POST['nombre'];
                        }

                        $stat = $conn->prepare('call guardar_empleado_beneficiario(?,?,?)');
                        $stat->bindParam(1, $identidadBeneficiario, PDO::PARAM_STR);
                        $stat->bindParam(2, $identidadEmpleado, PDO::PARAM_STR);
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
                        if (isset($_POST['identidadBeneficiario'])) {
                            $identidadBeneficiario = $_POST['identidadBeneficiario'];
                        }

                        if (isset($_POST['identidadEmpleado'])) {
                            $identidadEmpleado = $_POST['identidadEmpleado'];
                        }

                        if (isset($_POST['nombre'])) {
                            $nombre = $_POST['nombre'];
                        }

                        $stat = $conn->prepare('call actualizar_empleado_beneficiario(?,?,?)');
                        $stat->bindParam(1, $identidadBeneficiario, PDO::PARAM_STR);
                        $stat->bindParam(2, $identidadEmpleado, PDO::PARAM_STR);
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
                        if (isset($_POST['identidadBeneficiario'])) {
                            $identidadBeneficiario = $_POST['identidadBeneficiario'];
                        }

                        if (isset($_POST['identidadEmpleado'])) {
                            $identidadEmpleado = $_POST['identidadEmpleado'];
                        }

                        $stat = $conn->prepare('call eliminar_empleado_beneficiario(?,?)');
                        $stat->bindParam(1, $identidadBeneficiario, PDO::PARAM_STR);
                        $stat->bindParam(2, $identidadEmpleado, PDO::PARAM_STR);
                        if ($stat->execute()) {
                            $respuesta = array('error' => 0);

                            echo json_encode($respuesta, 16);
                        } else {
                            $respuesta = array('error' => 1);

                            echo json_encode($respuesta, 16);
                        }
                        break;

                    case 'guardar-linea-base':
                        if (isset($_POST['programa'])) {
                            $programa = $_POST['programa'];
                        }

                        if (isset($_POST[''])) {
                            
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
                        if (isset($_GET['idbeneficiario'])) {
                            $identidadBeneficiario = $_GET['idbeneficiario'];
                        }

                        $stat = $conn->prepare('call obtener_empleados(?);');
                        $stat->bindParam(1, $identidadBeneficiario, PDO::PARAM_STR);
                        $stat->execute();

                        $noticias = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($noticias, 64);
                        break;

                    case 'obtener-empleado':
                        if (isset($_GET['idbeneficiario'])) {
                            $identidadBeneficiario = $_GET['idbeneficiario'];
                        }

                        if (isset($_GET['idempleado'])) {
                            $identidadEmpleado = $_GET['idempleado'];
                        }

                        $stat = $conn->prepare('call obtener_empleado(?, ?);');
                        $stat->bindParam(1, $identidadBeneficiario, PDO::PARAM_STR);
                        $stat->bindParam(2, $identidadEmpleado, PDO::PARAM_STR);
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