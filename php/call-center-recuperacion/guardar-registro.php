<?php

if(isset($_POST['contesto'], $_POST['id_credito'], $_POST['checklist'], $_POST['observacion_personalizada'])){

    require '../conection.php';

    $sql = 'call guardar_bitacora_ccc(:id_credito, :contesto, :checklist, :observacion, :fecha_arreglo, :monto);';

    $stat = $conn->prepare($sql);
    $stat->bindValue(':id_credito', $_POST['id_credito'], PDO::PARAM_STR);
    $stat->bindValue(':contesto', ($_POST['contesto'] == 'true' ? '1' : '0'), PDO::PARAM_STR);
    $stat->bindValue(':checklist', $_POST['checklist'], PDO::PARAM_STR);
    $stat->bindValue(':fecha_arreglo', (isset($_POST['fecha_arreglo_pago']) ? $_POST['fecha_arreglo_pago'] : ''), PDO::PARAM_STR);
    $stat->bindValue(':monto', (isset($_POST['monto']) ? $_POST['monto'] : ''), PDO::PARAM_STR);

    if($_POST['observacion_personalizada'] == 'true' && isset($_POST['observacion'])){

        error_log('Estado: Con observacion personalizada');
        $stat->bindValue(':observacion', $_POST['observacion'], PDO::PARAM_STR);

    }else{

        error_log('Estado: Sin observacion personalizada');
        $stat->bindValue(':observacion', null, PDO::PARAM_NULL);

    }
    
    echo $stat->execute();

}

?>