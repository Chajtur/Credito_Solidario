<?php

require '../conection.php';
require '../plugins/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

if(isset($_GET['prestamo'])){

    $stat = $conn->prepare('call informacion_credito(:prestamo);');
    $stat->bindValue(':prestamo', $_GET['prestamo'], PDO::PARAM_STR);
    $stat->execute();
    $datos_prestamo = $stat->fetch(PDO::FETCH_ASSOC);

    $stat = $conn->prepare('call estado_cuenta(:prestamo);');
    $stat->bindValue(':prestamo', $_GET['prestamo'], PDO::PARAM_STR);
    $stat->execute();
    $estado_cuenta_result = $stat->fetch(PDO::FETCH_ASSOC);

    $stat = $conn->prepare('call historial_pagos(:prestamo);');
    $stat->bindValue(':prestamo', $_GET['prestamo'], PDO::PARAM_STR);
    $stat->execute();
    $historial_pago_result = $stat->fetchAll(PDO::FETCH_ASSOC);

    error_log(json_encode($historial_pago_result));

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();

    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link rel="stylesheet" href="../../css/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/custom/nuevo.css">
        <script src="../../css/plugins/bootstrap/js/bootstrap.min.js"></script>
        <style>

        h1, h2, h3, h4, h5, h6 {
            font-family: sans-serif !important;
        }

        .margin-right {
            margin-right: 15px !important;
        }

        </style>
    </head>
    <body><br>
        <div class="container-fluid">
            <h4 class="text-center">ESTADO DE CUENTA</h4>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="no-margin"><b>Información General</b></h4>
                    <h4>Nombre: '.$datos_prestamo['beneficiario'].'</h4>
                    <table class="table no-margin">
                        <tr>
                            <td class="no-padding"><b>Numero de Préstamo:</b></td>
                            <td class="no-padding">'.$datos_prestamo['numero_prestamo'].'</td>
                            <td class="no-padding"><b>Producto:</b></td>
                            <td class="no-padding">'.$datos_prestamo['nombre'].'</td>
                        </tr>
                        <tr>
                            <td class="no-padding"><b>Periodicidad de pago:</b></td>
                            <td class="no-padding">'.$datos_prestamo['forma_de_pago'].'</td>
                            <td class="no-padding"><b>Rubro:</b></td>
                            <td class="no-padding">'.$datos_prestamo['actividad_economica'].'</td>
                        </tr>
                        <tr>
                            <td class="no-padding"><b>Tasa de Interés:</b></td>
                            <td class="no-padding">'.$datos_prestamo['tasa'].'</td>
                            <td class="no-padding"><b>Estatus:</b></td>
                            <td class="no-padding">'.$datos_prestamo['estado_credito'].'</td>
                        </tr>
                        <tr>
                            <td class="no-padding"><b>Fecha de Autorización:</b></td>
                            <td class="no-padding">'.$datos_prestamo['fecha_desembolso'].'</td>
                            <td class="no-padding"><b>Fecha de vencimiento:</b></td>
                            <td class="no-padding">'.$datos_prestamo['fecha_vencimiento'].'</td>
                        </tr>
                        <tr>
                            <td class="no-padding"><b>Monto Original:</b></td>
                            <td class="no-padding">L. '.$datos_prestamo['monto'].'</td>
                            <td class="no-padding"><b>Ciclo:</b></td>
                            <td class="no-padding">'.$datos_prestamo['ciclo'].'</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="no-margin"><b>Estado del Crédito</b></h4>
                    <h4>Saldo Capital: '.$estado_cuenta_result['saldo_capital'].'</h4>
                    <table class="table no-margin">
                        <tr>
                            <td class="no-padding"><b>Capital Pagado:</b></td>
                            <td class="no-padding text-right margin-right">L. '.($estado_cuenta_result['capital_pagado'] > 0 || $estado_cuenta_result['capital_pagado'] != null ? $estado_cuenta_result['capital_pagado'] : '0.00').'</td>
                            <td class="no-padding"><b>Capital en Mora:</b></td>
                            <td class="no-padding text-right">L. '.($estado_cuenta_result['capital_mora'] > 0 || $estado_cuenta_result['capital_mora'] != null ? $estado_cuenta_result['capital_mora'] : '0.00').'</td>
                        </tr>
                        <tr>
                            <td class="no-padding"><b>Interés Pagado:</b></td>
                            <td class="no-padding text-right margin-right">L. '.($estado_cuenta_result['interes_pagado'] > 0 || $estado_cuenta_result['interes_pagado'] != null ? $estado_cuenta_result['interes_pagado'] : '0.00').'</td>
                            <td class="no-padding"><b>Interés:</b></td>
                            <td class="no-padding text-right">L. '.($estado_cuenta_result['interes'] > 0 || $estado_cuenta_result['interes'] != null ? $estado_cuenta_result['interes'] : '0.00').'</td>
                        </tr>
                        <tr>
                            <td class="no-padding"><b>Mora Pagada:</b></td>
                            <td class="no-padding text-right margin-right">L. '.($estado_cuenta_result['mora_pagada'] > 0 || $estado_cuenta_result['mora_pagada'] != null ? $estado_cuenta_result['mora_pagada'] : '0.00').'</td>
                            <td class="no-padding"><b>Interés moratorio:</b></td>
                            <td class="no-padding text-right">L. '.($estado_cuenta_result['interes_mora'] > 0 || $estado_cuenta_result['interes_mora'] != null ? $estado_cuenta_result['interes_mora'] : '0.00').'</td>
                        </tr>
                        <tr>
                            <td class="no-padding"><b>Total Pagado:</b></td>
                            <td class="no-padding text-right margin-right">L. '.($estado_cuenta_result['total_pagado'] > 0 || $estado_cuenta_result['total_pagado'] != null ? $estado_cuenta_result['total_pagado'] : '0.00').'</td>
                            <td class="no-padding"><b>Total Pendiente:</b></td>
                            <td class="no-padding text-right">L. '.($estado_cuenta_result['total_pendiente'] > 0 || $estado_cuenta_result['total_pendiente'] != null ? $estado_cuenta_result['total_pendiente'] : '0.00').'</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <h4 class="text-center">PAGOS REALIZADOS</h4>
                <table class="table">
                    <tr>
                        <th class="no-padding text-right">#</th>
                        <th class="no-padding text-right">Fecha de Pago</th>
                        <th class="no-padding text-right">Capital</th>
                        <th class="no-padding text-right">Intereses</th>
                        <th class="no-padding text-right">Interés Moratorio</th>
                        <th class="no-padding text-right">Total</th>
                        <th class="no-padding text-right margin-right">Saldo</th>
                    </tr>';
                
    $i = 1;

    $saldo = str_replace(',','',$datos_prestamo['monto']);
    $total_capital = 0;
    $total_interes = 0;
    $total_mora = 0;
    $total_pagos = 0;


    foreach($historial_pago_result as $fila){

        $fecha_pago = new DateTime($fila['fecha']);

        $saldo = $saldo - $fila['capital'];
        $total_capital = $total_capital + $fila['capital'];
        $total_interes = $total_interes + $fila['interes'];
        $total_mora = $total_mora + $fila['mora'];
        $total_pagos = $total_pagos + $fila['total_pagado'];

        $html .= '<tr>
                    <td class="no-padding text-right">'.$i++.'</td>
                    <td class="no-padding text-right">'.$fecha_pago->format('d/m/Y').'</td>
                    <td class="no-padding text-right">L. '.$fila['capital'].'</td>
                    <td class="no-padding text-right">L. '.$fila['interes'].'</td>
                    <td class="no-padding text-right">L. '.$fila['mora'].'</td>
                    <td class="no-padding text-right">L. '.$fila['total_pagado'].'</td>
                    <td class="no-padding text-right margin-right">L. '.number_format($saldo, 2, '.', ',').'</td>
                </tr>';

    }

    $html .= '
                    <tr>
                        <th class="no-padding text-right">=</th>
                        <th class="no-padding text-right">Total</th>
                        <th class="no-padding text-right">L. '.number_format($total_capital, 2, '.', ',').'</th>
                        <th class="no-padding text-right">L. '.number_format($total_interes, 2, '.', ',').'</th>
                        <th class="no-padding text-right">L. '.number_format($total_mora, 2, '.', ',').'</th>
                        <th class="no-padding text-right">L. '.number_format($total_pagos, 2, '.', ',').'</th>
                        <th class="no-padding text-right margin-right"></th>
                    </tr>
                </table>
            </div>
                <br><br><br>
                <table class="table">
                    <tr>
                        <td class="text-center" style="width:50%"><b>Solicitante<br>'.$datos_prestamo['beneficiario'].'</b></td>
                        <td class="text-center" style="width:50%"><b>Crédito Solidario<br>'.$datos_prestamo['ifi'].'</b></td>
                    </tr>
                </table>
                <br>
            </div>
        </body>
        </html>
        ';

    // echo json_encode($obj);

    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('letter', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream();

    // echo $html;

}

?>