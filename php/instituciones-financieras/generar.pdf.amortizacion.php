<?php

require '../conection.php';
require '../plugins/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

if(isset($_GET['prestamo'], $_GET['monto'], $_GET['plazo'])){

    $stringObject = urldecode($_GET['tabla']);
    $obj = json_decode($stringObject);

    $stat = $conn->prepare('call informacion_credito(:prestamo);');
    $stat->bindValue(':prestamo', $_GET['prestamo'], PDO::PARAM_STR);
    $stat->execute();
    $datos_prestamo = $stat->fetch(PDO::FETCH_ASSOC);

    $stat = $conn->prepare('call CalcularPagos(:monto, :fecha, :plazo);');
    $stat->bindValue(':monto', $_GET['monto'], PDO::PARAM_STR);
    $stat->bindValue(':fecha', $datos_prestamo['fecha_desembolso'], PDO::PARAM_STR);
    $stat->bindValue(':plazo', $_GET['plazo'], PDO::PARAM_STR);
    $stat->execute();
    $tabla_amortizacion = $stat->fetchAll(PDO::FETCH_ASSOC);

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

        </style>
    </head>
    <body><br>
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="no-margin"><b>Beneficiario:</b> '.$datos_prestamo['beneficiario'].'</h4>
                    <br>
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
                            <td class="no-padding">'.$datos_prestamo['monto'].'</td>
                            <td class="no-padding"><b>Ciclo:</b></td>
                            <td class="no-padding">'.$datos_prestamo['ciclo'].'</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <h4 class="text-center">PLAN DE PAGOS</h4>
                <table class="table">
                    <tr>
                        <th class="no-padding text-center">#</th>
                        <th class="no-padding text-center">Día</th>
                        <th class="no-padding text-center">Fecha de Pago</th>
                        <th class="no-padding text-center">Capital</th>
                        <th class="no-padding text-center">Intereses</th>
                        <th class="no-padding text-center">Total</th>
                        <th class="no-padding text-center">Saldo</th>
                    </tr>';
                
    $i = 0;
    $total_capital = 0;
    $interes = 0;
    $cuota = 0;
    foreach($tabla_amortizacion as $fila){

        $date = new DateTime(str_replace('/', '-', $obj->fecha_desembolso));
        $date->add(new DateInterval('P7D'));
        $currDate = $date->format('d/m/Y');
        $obj->fecha_desembolso = $currDate;
        $dia = $date->format('N');

        $total_capital += $fila['capital'];
        $interes += $fila['interes'];
        $cuota += $fila['cuota'];

        $html .= '<tr>
                    <td class="no-padding text-center">'.($i+1).'</td>
                    <td class="no-padding text-center">'.$dias[$dia-1].'</td>
                    <td class="no-padding text-center">'.$fila['fecha'].'</td>
                    <td class="no-padding text-center">L. '.number_format(floatval($fila['capital']), 2, ',', ' ').'</td>
                    <td class="no-padding text-center">L. '.number_format(floatval($fila['interes']), 2, ',', ' ').'</td>
                    <td class="no-padding text-center">L. '.number_format(floatval($fila['cuota']), 2, ',', ' ').'</td>
                    <td class="no-padding text-center">L. '.number_format(floatval($fila['saldo']), 2, ',', ' ').'</td>
                </tr>';
        $i++;

    }

    $html .= '
                    <tr>
                        <th class="text-center">=</th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                        <th class="text-center">L. '.floor($total_capital).'.00</th>
                        <th class="text-center">L. '.$interes.'</th>
                        <th class="text-center">L. '.(floor($total_capital) + $interes).'</th>
                        <th class="text-center"></th>
                    </tr>
                </table>
            </div>
                <br><br><br>
                <table class="table">
                    <tr>
                        <td class="text-center" style="width:50%"><b>Solicitante<br>'.$datos_prestamo['beneficiario'].'</b></td>
                        <td class="text-center" style="width:50%"><b>Crédito Solidario <br> '.$datos_prestamo['ifi'].'</b></td>
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
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream();

    // echo $html;

}

?>