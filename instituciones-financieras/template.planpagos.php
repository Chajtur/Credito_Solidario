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
    <link rel="stylesheet" href="../../css/custom/nuevo.css">
    <script src="../../css/plugins/bootstrap/js/bootstrap.min.js"></script>
</head>
<body><br>
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="no-margin">Información del Crédito</h4>
                <br>
                <!--<br><br><br><br><br><br><br><br><br>-->
                <table class="table no-margin">
                    <tr>
                        <td><b>Numero de Solicitúd</b></td>
                        <td>99999999</td>
                        <td><b>Productos</b></td>
                        <td>Crédito Simple</td>
                    </tr>
                    <tr>
                        <td><b>Periodicidad de pago</b></td>
                        <td>Quincenal</td>
                        <td><b>Pagos</b></td>
                        <td>0 de 10 por $ 1,290.00</td>
                    </tr>
                    <tr>
                        <td><b>Tasa de Interés</b></td>
                        <td>60.00%</td>
                        <td><b>Estatus</b></td>
                        <td>Autorizado</td>
                    </tr>
                    <tr>
                        <td><b>Fecha de Autorización</b></td>
                        <td>1/Ene/2014</td>
                        <td><b>Fecha de vencimiento</b></td>
                        <td>28/May/2014</td>
                    </tr>
                    <tr>
                        <td><b>Monto Original</b></td>
                        <td>10,000.00</td>
                        <td><b>Tasa de IVA</b></td>
                        <td>12.00%</td>
                    </tr>
                </table>
            </div>
        </div>
        <h4 class="text-center">PLAN DE PAGOS #6</h4>
        <table class="table">
            <tr>
                <th>Pago</th>
                <th>Dia</th>
                <th>Fecha de Pago</th>
                <th>Capital</th>
                <th>Intereses</th>
                <th>Total</th>
                <th>Saldo</th>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
        </table>
        <br><br><br>
        <table class="table">
            <tr>
                <td class="text-center"><b>FIRMA DEL SOLICITANTE <br> SUJETO DE PRUEBAS PARA REPORTAR</b></td>
                <td class="text-center"><b>POR LA EMPRESA <br> DEL SISTEMA ADMINISTRADOR</b></td>
            </tr>
        </table>
        <br>
    </div>
</body>
</html>
';

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

?>

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
</head>
<body><br>
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4 class="no-margin">Información del Crédito</h4>
                <br>
                <!--<br><br><br><br><br><br><br><br><br>-->
                <table class="table no-margin">
                    <tr>
                        <td><b>Numero de Solicitúd</b></td>
                        <td>99999999</td>
                        <td><b>Productos</b></td>
                        <td>Crédito Simple</td>
                    </tr>
                    <tr>
                        <td><b>Periodicidad de pago</b></td>
                        <td>Quincenal</td>
                        <td><b>Pagos</b></td>
                        <td>0 de 10 por $ 1,290.00</td>
                    </tr>
                    <tr>
                        <td><b>Tasa de Interés</b></td>
                        <td>60.00%</td>
                        <td><b>Estatus</b></td>
                        <td>Autorizado</td>
                    </tr>
                    <tr>
                        <td><b>Fecha de Autorización</b></td>
                        <td>1/Ene/2014</td>
                        <td><b>Fecha de vencimiento</b></td>
                        <td>28/May/2014</td>
                    </tr>
                    <tr>
                        <td><b>Monto Original</b></td>
                        <td>10,000.00</td>
                        <td><b>Tasa de IVA</b></td>
                        <td>12.00%</td>
                    </tr>
                </table>
            </div>
        </div>
        <h4 class="text-center">PLAN DE PAGOS #6</h4>
        <table class="table">
            <tr>
                <th>Pago</th>
                <th>Dia</th>
                <th>Fecha de Pago</th>
                <th>Capital</th>
                <th>Intereses</th>
                <th>Total</th>
                <th>Saldo</th>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>JUEVES</td>
                <td>16/Ene/2014</td>
                <td>1,000.00</td>
                <td>250.00</td>
                <td>1,290.00</td>
                <td>9,000.00</td>
            </tr>
        </table>
        <br><br><br>
        <table class="table">
            <tr>
                <td class="text-center"><b>FIRMA DEL SOLICITANTE <br> SUJETO DE PRUEBAS PARA REPORTAR</b></td>
                <td class="text-center"><b>POR LA EMPRESA <br> DEL SISTEMA ADMINISTRADOR</b></td>
            </tr>
        </table>
        <br>
    </div>
</body>
</html>