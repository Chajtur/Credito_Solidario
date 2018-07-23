<?php

require 'PHPExcel.php';
require_once 'conection.php';

//$archivo = new PHPExcel();

$date = new DateTime();

$sql = $conn->prepare('
select count(*) as  cantidad, sum(Monto_Desembolsado) as monto_total 
from prestamo 
where Fecha_Desembolso between "'.$date->format("Y-m-").'01" and "'.$date->format("Y-m-d").'"');
$sql->execute();
$mes = $sql->fetchAll();

$array_meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

$sql = $conn->prepare('
select ifi, fondo, if((ciclo is null), if(monto_desembolsado between 1 and 5000,1,if(monto_desembolsado between 5001 and 10000,2,if(monto_desembolsado between 10001 and 20000,3,1))),ciclo) as tempciclo, count(*) as beneficiario, sum(monto_desembolsado), Identidad 
from prestamo 
where Fecha_Desembolso <= "'.$date->format("Y-m-").'31" group by tempciclo having tempciclo = 1;');
$sql->execute();
$query_beneficiario = $sql->fetchAll();

$sql = $conn->prepare('
SELECT
	count(*) AS cantidad_total,
	round(sum(Monto_Desembolsado), 2) AS monto_desembolsado,
	(select sum(saldo_capital) from prestamo where (usuario_digitador not in ("Afectada") or usuario_digitador is null) and estado_credito = "Desembolsado") AS saldo_capital_total,
	(select sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) from prestamo where (usuario_digitador not in ("Afectada") or usuario_digitador is null) and estado_credito = "Desembolsado") AS capital_mora_total,
	(select format((((sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0))) / sum(saldo_capital)) * 100),4) from prestamo where (usuario_digitador not in ("Afectada") or usuario_digitador is null) and estado_credito = "Desembolsado") as porcentaje_mora
FROM
	prestamo');
$sql->execute();
$general = $sql->fetchAll();

$sql = $conn->prepare('select creditos, monto from metas_mes where mes = MONTH(CURRENT_DATE())');
$sql->execute();
$meta = $sql->fetch(PDO::FETCH_ASSOC);

$sql = $conn->prepare('select day(max(fecha_desembolso)) as dia, year(max(fecha_desembolso)) as anio from prestamo');
$sql->execute();
$dia = $sql->fetchAll();



$message = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="icon" href="http://creditosolidario.hn/test/images/favicon/favicon-32x32.png" sizes="32x32">
<link rel="apple-touch-icon-precomposed" href="http://creditosolidario.hn/test/images/favicon/apple-touch-icon-152x152.png">
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
<body style="margin: 0 auto;max-width:500px">
<div style="background-color: #e0e0e0; padding: 15px;">

        <div style="background-color: #fff; padding: 10px; border-bottom: 2px solid #9e9e9e; border-right: 2px solid #9e9e9e;">
            <br>
            <img src="http://creditosolidario.hn/test/images/logocredito-01.png" alt="">
            <hr style="margin-left: 130px; margin-right: 130px">
            <div class="shadow">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">'.$array_meses[$date->format('m') - 1]. ', '.$dia[0]['dia'].' del '.$dia[0]['anio'].'</caption>
                        <tr>
                            <th colspan="2" style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Cantidad de Créditos</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($mes[0]['cantidad']).'</th>
                        </tr>
                        <tr>
                            <th colspan="2" style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Monto Total Desembolsado</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($mes[0]['monto_total']).'</th>
                        </tr>
                        <tr>
                            <th colspan="3" style="font-size:12px;text-align: center;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Meta del Mes</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;"></th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">Valor</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">% Completado</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos Meta</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($meta['creditos']).'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format(($mes[0]['cantidad'] / $meta['creditos'])*100).'%</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Monto Meta</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($meta['monto']).'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format(($mes[0]['monto_total'] / $meta['monto']) * 100).'%</th>
                        </tr>
                        <tr>
                            <th colspan="3" style="font-size:12px;text-align: center;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Faltante para completar Meta</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;"></th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">Valor</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">% Faltante</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos faltantes para colocar</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;color: #FF0000;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($meta['creditos'] - $mes[0]['cantidad']).'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;color: #FF0000;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format((($meta['creditos'] - $mes[0]['cantidad'])/$meta['creditos'])*100).'%</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Monto faltante para desembolsar</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;color: #FF0000;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($meta['monto'] - $mes[0]['monto_total']).'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;color: #FF0000;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format((($meta['monto'] - $mes[0]['monto_total']) / $meta['monto'])*100).'%</th>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="shadow">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;border:none">Historico 2015/2016</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Cantidad total de créditos</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($general[0]['cantidad_total']).'</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Monto total desembolsado</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($general[0]['monto_desembolsado']).'</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Beneficiarios</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($query_beneficiario[0]['beneficiario']).'</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Saldo Capital</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($general[0]['saldo_capital_total']).'</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Capital en mora</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($general[0]['capital_mora_total']).'</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Porcentaje de Mora</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">% '.$general[0]['porcentaje_mora'].'</th>
                        </tr>

                    </table>
                </div>
            </div>
            <br>

        </div>
    </div>

</body>
</html>
';

$para = "r1c4rd0.v4@gmail.com" . ", ";
$para .= "rvalladares@creditosolidario.hn" . ", ";
/*$para .= "rvalladares@creditosolidario.hn" . ", ";*/
//$para .= "vanegiron57@gmail.com" . ", ";
$para .= "vito8916@gmail.com" . ", ";
$para .= "jose.chajtur@imhonduras.com" . ", ";
$para .= "jchajtur@creditosolidario.hn" . ", ";
$para .= "vanegiron57@gmail.com";
$para .= "vcaballero@creditosolidario.hn";

$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$cabeceras .= 'To: Lic. Vanessa Caballero <vanegiron57@gmail.com>' . "\r\n";
$cabeceras .= 'From: Credito Solidario <consultas@creditosolidario.hn>' . "\r\n";
/*$para = "r1c4rd0.v4@gmail.com, rvalladares@creditosolidario.hn, vito8916@gmail.com, vanegiron57@gmail.com";*/


//if(mail($para, "Envío de Reporte Diario", $message, $cabeceras)){
    echo $message;
/*}else{
    echo "No Enviado";
}*/

?>