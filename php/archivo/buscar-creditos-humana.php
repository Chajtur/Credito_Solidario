<?php

/**
 * Archivo para buscar los créditos para listar en la tabla para generar caja de humana
 * @param search via post (palabra clave de busqueda, debe ser un hash)
 * @author Rychiv4
 */

require '../conection.php';
if(isset($_POST['search'])){
    $search = $_POST['search'];
    $stat = $conn->prepare('call buscar_creditos_humana(:palabra);');
    $stat->bindValue(':palabra', $search, PDO::PARAM_STR);
    $stat->execute();
    echo json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
}


?>