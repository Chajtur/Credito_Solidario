<?php

if(isset($_POST['contesto'], $_POST['observacion_personalizada'], $_POST['realizo_pago'], $_POST['numero_prestamo'])){

    require '../conection.php';

    $stat = $conn->prepare('call llamada_promesa_pago_ccc(:contesto, :pago, :monto, :prestamo, :observacion, :fecha)');
    $stat->bindValue(':contesto', ($_POST['contesto'] == 'true' ? '1' : '0'), PDO::PARAM_STR);
    $stat->bindValue(':pago', ($_POST['realizo_pago'] == 'true' ? '1' : '0'), PDO::PARAM_STR);
    $stat->bindValue(':monto', $_POST['monto_pago'], PDO::PARAM_STR);
    $stat->bindValue(':prestamo', $_POST['numero_prestamo'], PDO::PARAM_STR);
    $stat->bindValue(':observacion', ($_POST['observacion_personalizada'] == 'true' ? $_POST['observacionPersonalizadaPago'] : ''), PDO::PARAM_STR);
    $stat->bindValue(':fecha', '', PDO::PARAM_STR);
    echo ($stat->execute() ? 'true' : 'false');
    // error_log(json_encode($_POST));

}

?>