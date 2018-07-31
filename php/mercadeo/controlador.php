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

                       // $conn->beginTransaction();
                        $stat = $conn->prepare('call guardar_noticia(:titulo, :contenido, :resumen, :fecha, :estado, :usuario);');
                        $stat->bindValue(':titulo', $titulo, PDO::PARAM_STR);
                        $stat->bindValue(':contenido', $contenido, PDO::PARAM_STR);
                        $stat->bindValue(':resumen', $resumen, PDO::PARAM_STR);
                        $stat->bindValue(':fecha', $fecha, PDO::PARAM_STR);
                        $stat->bindValue(':estado', $estado, PDO::PARAM_STR);
                        $stat->bindValue(':usuario', $usuario, PDO::PARAM_STR);
                        $stat->query();                        

                        $noticiaId = $conn->lastInsertId();
                       // $conn->commit();
                        echo $noticiaId;
                        die();

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
                        $estado = $_GET['estado'];
                        $stat = $conn->prepare('call obtener_noticias(:estado);');
                        $stat->bindValue(':estado', $estado, PDO::PARAM_STR);
                        $stat->execute();

                        $noticias = $stat->fetchAll(PDO::FETCH_ASSOC);

                        echo json_encode($noticias, 16);
                        break;

                    case 'mostrar':
                        if (isset($_GET['noticiaId'])) {
                            $noticiaId = $_GET['noticiaId'];

                            $stat = $conn->prepare('call obtener_noticia(:noticiaId)');
                            $stat->bindValue(':noticiaId', $noticiaId);
                            $stat->execute();

                            $noticia = $stat->fetchAll(PDO::FETCH_ASSOC);

                            echo json_encode($noticia, 16);
                        }                        
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