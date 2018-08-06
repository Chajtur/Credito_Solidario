<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'GET':
            if (isset($_GET['accion'])) {
                $accion = $_GET['accion'];
            }

            switch ($accion) {
                case 'listar':
                    if (isset($_GET['departamentoId'])) {
                        $departamentoId = $_GET['departamentoId'];
                    }

                    $stat = $conn->prepare('call obtener_agencias_departamento(?);');
                    $stat->bindParam(1, $departamentoId, PDO::PARAM_STR);
                    $stat->execute();

                    $agencias = $stat->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($agencias, 16);
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