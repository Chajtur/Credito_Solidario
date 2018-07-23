<?php

require '../plugins/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

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
    <script src="../../js/plugins/jquery-2.2.4.min.js"></script>
    <script src="../../css/plugins/bootstrap/js/bootstrap.min.js"></script>
    <style>

    @page { margin: 10px; }

    .no-padding {
        padding: 0 !important;
    }

    .no-margin {
        margin: 0 !important;
    }

    .half-padding-left {
        padding: 0px 0px 0px 5px !important;
    }

    img.logo-img {
        margin-left: 55px !important;
        width: 50px;
    }

    body {
        font-size: 8px !important;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: sans-serif !important;
    }

    </style>
</head>
<body>
    <img src="logocs.png" class="logo-img">
    <br><br>
    <h4 class="no-margin no-padding text-center"><b>RECIBO DE PAGO</b></h4>
    <h4 class="no-margin no-padding text-center">Código de pago: 999</h4>
    <h4 class="no-margin no-padding text-center">Fecha actual: 99/99/9999</h4>
    <h4 class="no-margin no-padding text-center">Crédito Solidario</h4>
    <h4 class="no-margin no-padding text-center">Nombre de la IFI</h4>
    <br>
    <table class="">
        <tr>
            <td class="no-padding text-right"><b>Cantidad Pagada:</b></td>
            <td class="half-padding-left">L. 198.00</td>
        </tr>
        <tr>
            <td class="no-padding text-right"><b>Fecha:</b></td>
            <td class="half-padding-left">25/08/2017 8:00:00</td>
        </tr>
        <tr>
            <td class="no-padding text-right"><b>Capital:</b></td>
            <td class="half-padding-left">L. 186.00</td>
        </tr>
        <tr>
            <td class="no-padding text-right"><b>Interes:</b></td>
            <td class="half-padding-left">L. 8.00</td>
        </tr>
        <tr>
            <td class="no-padding text-right"><b>Saldo:</b></td>
            <td class="half-padding-left">L. 4,792.00</td>
        </tr>
        <tr>
            <td class="no-padding text-right"><b>Agencia:</b></td>
            <td class="half-padding-left">La Mosquitia</td>
        </tr>
    </table>

    <!-- <br><br><br>
    <table class="table">
        <tr>
            <td class="text-center"><b>FIRMA DEL SOLICITANTE <br> SUJETO DE PRUEBAS PARA REPORTAR</b></td>
            <td class="text-center"><b>POR LA EMPRESA <br> DEL SISTEMA ADMINISTRADOR</b></td>
        </tr>
    </table>
    <br>-->
</body>
</html>
';

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper(array(0,0,180,300));
$dompdf->set_option('dpi', 72);

// echo $html;

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

echo $html;

?>