<?php 

require_once '../plugins/dompdf/autoload.inc.php';
use Dompdf\Adapter\CPDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Exception;

require '../conection.php';

// Variables necesarias
$departamento = "Call Center";

$grupos = array(
    "CFED", "CFEE", "CFF0", "CFF1", "CFF2", "CFF3"
);

$direccion = '';
$nombre = 'archivo.pdf';

// Codigo para generars
$stat = $conn->prepare('select distinct supervisor from cartera_consolidada 
where grupo_solidario_hash in ('.'"'.implode('","', $grupos).'"'.')');
$stat->execute();

$supervisores = $stat->fetchAll();

$stat = $conn->prepare('select grupo_solidario_hash, nombre, identidad, grupo_solidario, gestor, ciclo from cartera_consolidada 
where grupo_solidario_hash in ('.'"'.implode('","', $grupos).'"'.') and supervisor = :supervisor');

$string = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prueba documento</title>
    <!-- Compiled and minified CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
    
        * {
            color: #000000 !important;
            font-family: sans-serif;
        }
        
        th, td {
            font-size: 12px;
        }
        
    </style>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
               <img src="../../images/logocredito.png" alt="" class="img-responsive">
            </div>
            <div class="col-xs-2 col-xs-offset-6 col-sm-2 col-sm-offset-6 col-md-2 col-md-offset-6 col-lg-2 col-lg-offset-6">
               <img src="../../images/logo-presidencia.png" alt="" class="img-responsive">
            </div>
        </div>
    </div><br><br><br><br>
  
    <h2>Créditos Recibidos</h2>
    <h4>Departamento: '.$departamento.'</h4>';

foreach($supervisores as $supervisor){
    
    $string .= '
    <table class="table table-bordered">
        <caption>Supervisor: '.$supervisor['supervisor'].'</caption>
        <thead>
          <tr>
              <th>Hash</th>
              <th>Beneficiario</th>
              <th>Identidad</th>
              <th>Nombre Grupo</th>
              <th>Asesor</th>
              <th>Ciclo</th>
          </tr>
        </thead>

        <tbody>';
    
    $stat->bindValue(':supervisor', $supervisor['supervisor'], PDO::PARAM_STR);
    $stat->execute();
    $creditos = $stat->fetchAll();
    
    foreach($creditos as $credito){
        
        $string .= '
        <tr>
            <td>'.$credito['grupo_solidario_hash'].'</td>
            <td>'.$credito['nombre'].'</td>
            <td>'.$credito['identidad'].'</td>
            <td>'.$credito['grupo_solidario'].'</td>
            <td>'.$credito['gestor'].'</td>
            <td>'.$credito['ciclo'].'</td>
        </tr>
        ';
        
    }
    
    $string .= '    
        </tbody>
    </table>
    ';
    
}

$string .= '
</body>
</html>
';

//$html = file_get_contents('archivo.php');
$options = new Options();
$options->set('isRemoteEnabled', true);
// instantiate and use the dompdf class
$dompdf = new Dompdf($options);
$dompdf->loadHtml($string);

// (Optional) Setup the paper size and orientation
//$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

$output = $dompdf->output();
// Output the generated PDF to Browser
file_put_contents($direccion.$nombre, $output);

?>