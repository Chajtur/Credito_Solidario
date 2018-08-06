<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'GET':
            if (isset($_GET['accion'])) {
                $accion = $_GET['accion'];
            }

            switch ($accion) {
                case 'mostrar':
                    if (isset($_GET['departamentoId'])) {
                        $departamentoId = $_GET['departamentoId'];
                    }
                    $stat = $conn->prepare('call obtener_departamento(?);');
                    $stat->bindParam(1, $departamentoId, PDO::PARAM_STR);
                    $stat->execute();

                    $departamento = $stat->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($departamento, 16);
                    break;
                    
                case 'listar':
                    $stat = $conn->prepare('call obtener_departamentos();');
                    $stat->execute();

                    $departamentos = $stat->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($departamentos, 64);
                    break;
                
                default:
                    # code...
                    break;
            }
            break;
    }
?>