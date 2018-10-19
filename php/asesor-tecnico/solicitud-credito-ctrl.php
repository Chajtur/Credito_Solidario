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
                        $sql_guardar_linea_base = 'call guardar_linea_base(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);';

                        $date = date_create();
                        $id = date_format($date, 'U');
                        $ciclo = 0;
                        $unidadVivienda = 'Años';
                        $energia_electrica = 0;
                        $agua_potable = 0;
                        $aguas_negras = 0;
                        $telefono_fijo = 0;
                        $tieneMicroempresa = 0;
                        $emprenderMicroempresa = 0;

                        if (isset($_POST['usuario'])) {
                            $idusuario = $_POST['usuario'];
                        } else {
                            $idusuario = 'unUsuario';
                        }

                        if (isset($_POST['idBeneficiario'])) {
                            $identidad = $_POST['idBeneficiario'];
                        }

                        if (isset($_POST['tiempoVivienda'])) {
                            $tiempoVivienda = $_POST['tiempoVivienda'];
                        }

                        if (isset($_POST['serviciosPublicos'])) {
                            $serviciosPublicos = $_POST['serviciosPublicos'];
                            $serviciosPublicosArr = explode(',', $serviciosPublicos);

                            foreach ($serviciosPublicosArr as $algo) { 
                                if ($algo == 'energia-electrica') {
                                    $energia_electrica = 1;
                                    break;
                                }
                            }

                            if (array_search('agua-potable', $serviciosPublicosArr)) {
                                $agua_potable = 1;
                            }

                            if (array_search('aguas-negras', $serviciosPublicosArr)) {
                                $aguas_negras = 1;
                            }

                            if (array_search('pozo-septico', $serviciosPublicosArr)) {
                                $pozo_septico = 1;
                            }

                            if (array_search('telefono-fijo', $serviciosPublicosArr)) {
                                $telefono_fijo = 1;
                            }                            
                        }

                        if (isset($_POST['personasVivienda'])) {
                            $personasVivienda = $_POST['personasVivienda'];
                        }

                        if (isset($_POST['familiasVivienda'])) {
                            $familiasVivienda = $_POST['familiasVivienda'];
                        }

                        if (isset($_POST['trabajadoresVivienda'])) {
                            $trabajadoresVivienda = $_POST['trabajadoresVivienda'];
                        }

                        if (isset($_POST['dependientesVivienda'])) {
                            $dependientesVivienda = $_POST['dependientesVivienda'];
                        }

                        if (isset($_POST['desempleadosVivienda'])) {
                            $desempleadosVivienda = $_POST['desempleadosVivienda'];
                        }

                        if (isset($_POST['materialVivienda'])) {
                            $materialVivienda = $_POST['materialVivienda'];
                        }

                        if (isset($_POST['cantidadDependientes'])) {
                            $cantidadDependientes = $_POST['cantidadDependientes'];
                        }

                        $stat = $conn->prepare($sql_guardar_linea_base);
                        $stat->bindParam(1, $id, PDO::PARAM_STR);
                        $stat->bindParam(2, $identidad, PDO::PARAM_STR);
                        $stat->bindParam(3, $ciclo, PDO::PARAM_STR);
                        $stat->bindParam(4, $materialVivienda, PDO::PARAM_STR);
                        $stat->bindParam(5, $personasVivienda, PDO::PARAM_STR);
                        $stat->bindParam(6, $familiasVivienda, PDO::PARAM_STR);
                        $stat->bindParam(7, $trabajadoresVivienda, PDO::PARAM_STR);
                        $stat->bindParam(8, $desempleadosVivienda, PDO::PARAM_STR);
                        $stat->bindParam(9, $energia_electrica, PDO::PARAM_STR);
                        $stat->bindParam(10, $aguas_negras, PDO::PARAM_STR);
                        $stat->bindParam(11, $agua_potable, PDO::PARAM_STR);
                        $stat->bindParam(12, $pozo_septico, PDO::PARAM_STR);
                        $stat->bindParam(13, $telefono_fijo, PDO::PARAM_STR);
                        $stat->bindParam(14, $tieneMicroempresa, PDO::PARAM_STR);
                        $stat->bindParam(15, $emprenderMicroempresa, PDO::PARAM_STR);
                        $stat->bindParam(16, $unidadVivienda, PDO::PARAM_STR);
                        $stat->bindParam(17, $tiempoVivienda, PDO::PARAM_STR);
                        $stat->bindParam(18, $idusuario, PDO::PARAM_STR);
                        $stat->bindParam(19, $dependientesVivienda, PDO::PARAM_STR);

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