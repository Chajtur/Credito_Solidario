<?php

require_once '../php/plugins/dompdf/autoload.inc.php';
use Dompdf\Adapter\CPDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Exception;
require '../php/conection.php';

/*salones*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado) 
    from prestamo 
    where Fecha_Desembolso >= "2017-3-3" and Actividad_Economica like "%belle%" 
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$belleza = $sql->fetchAll();

$jsonBelleza = json_encode($belleza);
$prueba = '';
$contadorCreditosSalon = 0;
$contadorDesembolsoSalon = 0;
for($i=0; $i< count($belleza); $i++){
    
    $contadorCreditosSalon += $belleza[$i]['1'];
    $contadorDesembolsoSalon += $belleza[$i]['2'];
    $prueba = $prueba .'<tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.($belleza[$i]['0'] == null ? 'Por asignar' : $belleza[$i]['0']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$belleza[$i]['1'].'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">Lps. '.number_format($belleza[$i]['2']).'</th>
                        </tr>';
}

/*taxis*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado) 
    from prestamo 
    where Fecha_Desembolso >= "2017-3-3" and Actividad_Economica like "%taxis%" 
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$taxis = $sql->fetchAll();


$strTaxis = '';
$contadorCreditosTaxis = 0;
$contadorDesembolsoTaxis = 0;
for($i=0; $i< count($taxis); $i++){
    
    $contadorCreditosTaxis += $taxis[$i]['1'];
    $contadorDesembolsoTaxis += $taxis[$i]['2'];
    $strTaxis = $strTaxis .'<tr>
                                <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.($taxis[$i]['0'] == null ? 'Por asignar' : $taxis[$i]['0']).'</th>
                                <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$taxis[$i]['1'].'</th>
                                <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">Lps. '.number_format($taxis[$i]['2']).'</th>
                            </tr>';
}


/*baberías*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado) 
    from prestamo 
    where Fecha_Desembolso >= "2017-3-3" and Actividad_Economica like "%barbe%" 
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$barbarias = $sql->fetchAll();


$strbaberias = '';
$contadorCreditosBarbe = 0;
$contadorDesembolsoBarbe = 0;
for($i=0; $i< count($barbarias); $i++){
    
    $contadorCreditosBarbe += $barbarias[$i]['1'];
    $contadorDesembolsoBarbe += $barbarias[$i]['2'];
    $strbaberias = $strbaberias .'<tr>
                                    <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.($barbarias[$i]['0'] == null ? 'Por asignar' : $barbarias[$i]['0']).'</th>
                                    <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$barbarias[$i]['1'].'</th>
                                    <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">Lps. '.number_format($barbarias[$i]['2']).'</th>
                                </tr>';
}


/*pulperías*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado) 
    from prestamo 
    where Fecha_Desembolso >= "2017-3-3" and Actividad_Economica like "%pulpe%" 
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$pulperias = $sql->fetchAll();


$strPulperias = '';
$contadorCreditosPulpe = 0;
$contadorDesembolsoPulpe = 0;
for($i=0; $i< count($pulperias); $i++){
    
    $contadorCreditosPulpe += $pulperias[$i]['1'];
    $contadorDesembolsoPulpe += $pulperias[$i]['2'];
    $strPulperias = $strPulperias .'<tr>
                                        <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.($pulperias[$i]['0'] == null ? 'Por asignar' : $pulperias[$i]['0']).'</th>
                                        <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$pulperias[$i]['1'].'</th>
                                        <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">Lps. '.number_format($pulperias[$i]['2']).'</th>
                                    </tr>';
}

$contenido_salones = '
    <div style="background-color: #e0e0e0; padding: 15px;">
        <div style="background-color: #fff; padding: 10px; border-bottom: 2px solid #9e9e9e; border-right: 2px solid #9e9e9e;">
            <br>
            <img src="http://creditosolidario.hn/test/images/logocredito-01.png" alt="">
            <hr style="margin-left: 130px; margin-right: 130px">
            <br>
            <div class="shadow">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">SALONES</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Nombre de Agencia</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos desembolsados</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Monto desembolsado</th>
                        </tr>
                        '.$prueba.'
                    </table>
                </div>
            </div>
            <br>
            
        </div>
    </div>
';

$contenido_taxis = '
    <!-- CONTENIDO DE TAB 2 -->
    <div style="background-color: #e0e0e0; padding: 15px;">
        <div style="background-color: #fff; padding: 10px; border-bottom: 2px solid #9e9e9e; border-right: 2px solid #9e9e9e;">
            <br>
            <img src="http://creditosolidario.hn/test/images/logocredito-01.png" alt="">
            <hr style="margin-left: 130px; margin-right: 130px">
            <br>
            <div class="shadow">
                <div class="overlay">               
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">TAXIS</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Nombre de Agencia</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos desembolsados</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Monto desembolsado</th>
                        </tr>
                        '.$strTaxis.'
                    </table>
                </div>
            </div>
        </div>
    </div>
';

$contenido_barberia = '
    <!-- CONTENIDO DE TAB 3 -->
    <div style="background-color: #e0e0e0; padding: 15px;">
        <div style="background-color: #fff; padding: 10px; border-bottom: 2px solid #9e9e9e; border-right: 2px solid #9e9e9e;">
            <br>
            <img src="http://creditosolidario.hn/test/images/logocredito-01.png" alt="">
            <hr style="margin-left: 130px; margin-right: 130px">
            <br>
            <div class="shadow">                  
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">BARBERÍAS</caption> 
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Nombre de Agencia</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos desembolsados</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Monto desembolsado</th>
                        </tr>
                        '.$strbaberias.'
                    </table>
                </div>
            </div>
        </div>
    </div>
';

$contenido_pulperias = '
    <!-- CONTENIDO DE TAB 4 -->
    <div style="background-color: #e0e0e0; padding: 15px;">
        <div style="background-color: #fff; padding: 10px; border-bottom: 2px solid #9e9e9e; border-right: 2px solid #9e9e9e;">
            <br>
            <img src="http://creditosolidario.hn/test/images/logocredito-01.png" alt="">
            <hr style="margin-left: 130px; margin-right: 130px">
            <br>
            <div class="shadow">                        
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">PULPERÍAS</caption> 
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Nombre de Agencia</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos desembolsados</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Monto desembolsado</th>
                        </tr>
                        '.$strPulperias.'
                    </table>
                </div>
            </div>
        </div>
    </div>
';

$contenido_resumen = '
    <!-- CONTENIDO DE TAB 5 -->
    <div style="background-color: #e0e0e0; padding: 15px;">
        <div style="background-color: #fff; padding: 10px; border-bottom: 2px solid #9e9e9e; border-right: 2px solid #9e9e9e;">
            <br>
            <img src="http://creditosolidario.hn/test/images/logocredito-01.png" alt="">
            <hr style="margin-left: 130px; margin-right: 130px">
            <br>
            <div class="shadow">
                <div class="overlay">               
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">RESUMEN</caption>
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Nombre de Producto</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos desembolsados</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Monto desembolsado</th>
                        </tr>
                        <!--PULPERIAS RESUMEN-->
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">SALONES</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$contadorCreditosSalon.'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">Lps. '.number_format($contadorDesembolsoSalon).'</th>
                        </tr>
                            <!--SALONES RESUMEN-->
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">TAXIS</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$contadorCreditosTaxis.'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">Lps. '.number_format($contadorDesembolsoTaxis).'</th>
                        </tr>
                            <!--TAXIS RESUMEN-->
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">BARBERÍAS</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$contadorCreditosBarbe.'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">Lps. '.number_format($contadorDesembolsoBarbe).'</th>
                        </tr>
                            <!--BARBERIAS RESUMEN-->
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">PULPERÍAS</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$contadorCreditosPulpe.'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">Lps. '.number_format($contadorDesembolsoPulpe).'</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
';

$message = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="icon" href="http://creditosolidario.hn/test/images/favicon/favicon-32x32.png" sizes="32x32">
<link rel="apple-touch-icon-precomposed" href="http://creditosolidario.hn/test/images/favicon/apple-touch-icon-152x152.png">
<link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
<!-- Custome CSS-->
<link href="../css/custom/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">
<link rel="stylesheet" href="../css/custom/nuevo.css">
<link rel="stylesheet" href="../css/custom/tema-indigo.css">
<link rel="stylesheet" href="../css/custom/search.css">
<!-- Material-icons-->
<link href="../fonts/material-icons/material-icons.css" type="text/css" rel="stylesheet" media="screen,projection">
<title>Prueba</title>
<style>
        html {
            font-family: Trebuchet MS, sans-serif;
        }
        img {
            width: auto;
            height: 50px;
            display: block;
            margin: 0 auto;
            margin-top: 0px;
        }
        table {
            font-family: Trebuchet MS, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 6px;
            color: #424242;
        }
        tr:nth-child(even) {
            /*background-color: #dddddd;*/
        }
    </style>
</head>
<body style="margin: 0 auto;max-width:600px">
    <div class="row">
        '.((isset($_GET['descargar'])) ? '' : '
        <div class="col s12">
            <ul class="tabs tabs-fixed-width">
                <li class="tab "><a class="active" href="#test1">Salones</a></li>
                <li class="tab "><a href="#test2">Taxis</a></li>
                <li class="tab "><a href="#test3">Baberías</a></li>
                <li class="tab "><a href="#test4">Pulperías</a></li>
                <li class="tab "><a href="#test5">Resumen</a></li>
            </ul>
        </div>
        ').'

        <div id="test1" class="col s12">
            '.$contenido_salones.'
        </div>

        <div id="test2" class="col s12">
            '.$contenido_taxis.'
        </div>

        <div id="test3" class="col s12">
            '.$contenido_barberia.'
        </div>

        <div id="test4" class="col s12">
            '.$contenido_pulperias.'
        </div>

        <div id="test5" class="col s12">
            '.$contenido_resumen.'
        </div>
    </div>
    '.((isset($_GET['descargar'])) ? '' : '
    <!-- jQuery Library -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <!--materialize <js--></js-->
    <script type="text/javascript" src="../js/materialize.js"></script>
    <!--prism
    <script type="text/javascript" src="js/prism/prism.js"></script>-->
    <!--scrollbar-->
    <script type="text/javascript" src="../js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <!--custom-script.js - Add your own theme custom JS-->
    <script src="../js/custom-script.js"></script>

    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="../js/plugins.js"></script>
    ').'
</body>
</html>
';

if(isset($_GET['descargar'])){
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    // instantiate and use the dompdf class
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($message);
    $dompdf->set_paper("A4", "portrait");
    $dompdf->render();
    $dompdf->stream("Productos Nuevos");
}else{
    echo $message;
}

?>