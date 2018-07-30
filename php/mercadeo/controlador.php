<?php
    require '../conection.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
        case 'POST':
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];
                switch ($accion) {
                    case 'agregar':
                        # code...
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
                    case 'listar':
                        $stat = $conn->prepare('call obtener_noticias(:estado);');
                        $stat->bindValue(':estado', $_POST['estado'], PDO::PARAM_STR);
                        $stat->execute();

                        $noticias = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($noticias, 16);
                        break;

                    case 'mostrar':
                        # code...
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