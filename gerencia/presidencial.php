<?php

require_once '../php/plugins/dompdf/autoload.inc.php';
use Dompdf\Adapter\CPDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Exception;
require '../php/conection.php';

$array_meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
$date = new DateTime();
/*beneficiarios*/
$sql = $conn->prepare('
    select count(*), sum(monto_desembolsado) from prestamo where if((ciclo is null), if(monto_desembolsado between 1 and 5000,1,if(monto_desembolsado between 5001 and 10000,2,if(monto_desembolsado between 10001 and 20000,3,1))),ciclo) not in ("2","12","3")
');

$sql->execute();
$beneficiarios = $sql->fetchAll();

/*cartera activa*/
$sql = $conn->prepare('
    select count(a.Numero_Prestamo) as total, sum(a.Monto_Desembolsado) as desembolsado, count(d.Numero_Prestamo) as ciclo1, count(b.numero_prestamo) as ciclo2, count(c.numero_prestamo) as ciclo3 from prestamo a
    left join prestamo d on a.Numero_Prestamo = d.Numero_Prestamo and if((a.ciclo is null), if(a.monto_desembolsado between 1 and 5000,1,if(a.monto_desembolsado between 5001 and 10000,2,if(a.monto_desembolsado between 10001 and 20000,3,1))),a.ciclo) not in ("2","12","3")
    left join prestamo b on a.Numero_Prestamo = b.Numero_Prestamo and if((b.ciclo is null), if(b.monto_desembolsado between 1 and 5000,1,if(b.monto_desembolsado between 5001 and 10000,2,if(b.monto_desembolsado between 10001 and 20000,3,1))),b.ciclo) in ("2","12")
    left join prestamo c on a.Numero_Prestamo = c.Numero_Prestamo and if((c.ciclo is null), if(c.monto_desembolsado between 1 and 5000,1,if(c.monto_desembolsado between 5001 and 10000,2,if(c.monto_desembolsado between 10001 and 20000,3,1))),c.ciclo) = "3"
    where a.Estado_Credito = "Desembolsado" 
');
$sql->execute();
$carteraActiva = $sql->fetchAll();

/*mora total del programa*/
$sql = $conn->prepare('
    select count(b.numero_prestamo) as creditosMorosos, (sum(if(DATEDIFF(current_date,if((a.fecha_ultimo_pago is null or a.fecha_ultimo_pago = "0000-00-00"),a.fecha_desembolso,a.fecha_ultimo_pago)) > 15,if(a.capital_mora < 0, 0, a.capital_mora),0))/sum(a.saldo_capital))*100 as porcentajeMora, sum(if(DATEDIFF(current_date,if((a.fecha_ultimo_pago is null or a.fecha_ultimo_pago = "0000-00-00"),a.fecha_desembolso,a.fecha_ultimo_pago)) > 15,if(a.capital_mora < 0, 0, a.capital_mora),0)) as monto
    from prestamo a
    left join prestamo b on a.Numero_Prestamo = b.Numero_Prestamo and b.capital_mora > 0
    where a.Estado_Credito = "Desembolsado"
');
$sql->execute();
$moraTotalPrograma = $sql->fetchAll();

/*cartera afectada*/
$sql = $conn->prepare('
    select count(*) as creditos, sum(monto_desembolsado) as desembolsado, (sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0))/sum(saldo_capital))*100 as porcentajeMora, sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) as mora
    from prestamo where Usuario_Digitador = "Afectada" and Estado_Credito = "Desembolsado"
');
$sql->execute();
$carteraAfectada = $sql->fetchAll();


/*cartera oficial*/
$sql = $conn->prepare('
    select count(*) as creditos, sum(monto_desembolsado) as desembolsado, (sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0))/sum(saldo_capital))*100 as porcentajeMora, sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) as mora
    from prestamo where (usuario_digitador  <> "Afectada" or usuario_digitador is null) and Estado_Credito = "Desembolsado"
');
$sql->execute();
$carteraOficial = $sql->fetchAll();


/*previa al 25 de julio*/
$sql = $conn->prepare('
    select count(*) as creditos, sum(monto_desembolsado) as desembolsado, (sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0))/sum(saldo_capital))*100 as porcentajeMora, sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) as mora
    from prestamo where (usuario_digitador  <> "Afectada" or usuario_digitador is null) and Estado_Credito = "Desembolsado" and Fecha_Desembolso <= "2016-7-25"
');
$sql->execute();
$antesDeJulio = $sql->fetchAll();


/*despues del 25 de julio*/
$sql = $conn->prepare('
    select count(*) as creditos, sum(monto_desembolsado) as desembolsado, (sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0))/sum(saldo_capital))*100 as porcentajeMora, sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) as mora
    from prestamo where (usuario_digitador  <> "Afectada" or usuario_digitador is null) and Estado_Credito = "Desembolsado" and (Fecha_Desembolso > "2016-7-25" or Fecha_Desembolso is null)
');
$sql->execute();
$despuesDeJulio = $sql->fetchAll();

/*ciclos hisoricos*/
$sql = $conn->prepare('
    select count(a.Numero_Prestamo) as total, sum(a.Monto_Desembolsado) as desembolsado, count(d.Numero_Prestamo) as ciclo1, count(b.numero_prestamo) as ciclo2, count(c.numero_prestamo) as ciclo3 from prestamo a
    left join prestamo d on a.Numero_Prestamo = d.Numero_Prestamo and if((a.ciclo is null), if(a.monto_desembolsado between 1 and 5000,1,if(a.monto_desembolsado between 5001 and 10000,2,if(a.monto_desembolsado between 10001 and 20000,3,1))),a.ciclo) not in ("2","12","3")
    left join prestamo b on a.Numero_Prestamo = b.Numero_Prestamo and if((b.ciclo is null), if(b.monto_desembolsado between 1 and 5000,1,if(b.monto_desembolsado between 5001 and 10000,2,if(b.monto_desembolsado between 10001 and 20000,3,1))),b.ciclo) in ("2","12")
    left join prestamo c on a.Numero_Prestamo = c.Numero_Prestamo and if((c.ciclo is null), if(c.monto_desembolsado between 1 and 5000,1,if(c.monto_desembolsado between 5001 and 10000,2,if(c.monto_desembolsado between 10001 and 20000,3,1))),c.ciclo) = "3"
    
');
$sql->execute();
$ciclosHistorico = $sql->fetchAll();


/*créditos cancelados*/
$sql = $conn->prepare('
    select count(*) where estado_credito = "cancelado"
    
');
$sql->execute();
$creditosCancelados = $sql->fetchAll();

/*créditos castigados*/
$sql = $conn->prepare('
    select count(*) where estado_credito = "castigado"
    
');
$sql->execute();
$creditosCastigados = $sql->fetchAll();


/*query para cancelados y castigados*/
$sql = $conn->prepare('
    select count(*) as totalCreditos,
    (select count(*) from prestamo where Estado_Credito = "Cancelado") as creditosCancelados,
    (select count(*) from prestamo where Estado_Credito = "Castigado") as creditosCastigados
    from prestamo
');

$sql->execute();
$general = $sql->fetchAll();

/*query para saldo de cartera afectada*/
$sql = $conn->prepare('select sum(saldo_capital) from prestamo where usuario_digitador = "Afectada" and estado_credito = "Desembolsado"');
$sql->execute();
$saldoCarteraAfecta = $sql->fetchAll();

/*query para saldo de cartera activa*/
$sql = $conn->prepare('select sum(saldo_capital) from prestamo a
    where (a.usuario_digitador  <> "Afectada" or a.usuario_digitador is null) and Estado_Credito = "Desembolsado"');
$sql->execute();
$saldoCarteraActiva = $sql->fetchAll();

/*query para metaa mensual y anual*/
$sql = $conn->prepare('select a.creditos as Creditos_Mes, a.monto as Monto_Mes, sum(b.creditos) as Creditos_Anual, sum(b.monto) as Monto_Anual from metas_mes a left join metas_mes b
    on 1 = 1
    where a.mes = month(current_date)
');
$sql->execute();
$metas = $sql->fetchAll();

/*query para ejecutado mensual y anual*/
$sql = $conn->prepare('select sum(if(month(Fecha_Desembolso) = month(current_date) and year(fecha_desembolso) = year(current_date),1,0)) as Creditos_Mes, sum(if(month(Fecha_Desembolso) = month(current_date) and year(fecha_desembolso) = year(current_date),monto_desembolsado,0)) as Monto_Mes, count(numero_prestamo) as Creditos_Anual, sum(monto_desembolsado) as Monto_Anual from prestamo where year(fecha_desembolso) = year(current_date)
');
$sql->execute();
$ejecutados = $sql->fetchAll();

/*query para desglose de productos*/
$sql = $conn->prepare('select b.nombre, count(a.Numero_Prestamo), sum(Monto_Desembolsado) from prestamo a, programa b 
    where if(programa is null, "P01", if(programa in ("P02","P05","P07"), "P01", programa)) = b.id and year(fecha_desembolso)=year(current_date)
    group by if(programa is null, "P01", if(programa in ("P02","P05","P07"), "P01", programa));
');
$sql->execute();
$desglose = $sql->fetchAll();

$strDesglose = '';
$contadorNombreProducto = 0;
$contadorCreditosProductos = 0;
$contadorDesembolsoProductos = 0;
$totalCreditos = 0;
$totalDesembolso = 0;
for($i=0; $i< count($desglose); $i++){
    $totalCreditos += $desglose[$i]['1'];
    $totalDesembolso += $desglose[$i]['2'];
    
    $contadorNombreProducto += $desglose[$i]['0'];
    $contadorCreditosProductos += $desglose[$i]['1'];
    $contadorDesembolsoProductos += $desglose[$i]['2'];
    $strDesglose = $strDesglose .'<tr>
                                    <th style="text-align:left;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.($desglose[$i]['0'] == null ? 'Por asignar' : $desglose[$i]['0']).'</th>
                                    <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($desglose[$i]['1']).'</th>
                                    <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">Lps. '.number_format($desglose[$i]['2'], 2, ".", ",").'</th>
                                </tr>';
}

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
<body style="margin: 0 auto;max-width:'.(isset($_GET['descargar']) ? '8' : '6').'00px">
<div style="background-color: #e0e0e0; padding: 15px;">

        <div style="background-color: #fff; padding: 10px; border-bottom: 2px solid #9e9e9e; border-right: 2px solid #9e9e9e;">
            <br>
            <div style="text-align:center;width:100%;"><img src="http://creditosolidario.hn/test/images/logocredito-01.png" alt="" style="display: block;margin-left: auto;margin-right: auto;"></div>
            '.(isset($_GET['descargar']) ? '<br><br>' : '<hr style="margin-left: 130px; margin-right: 130px">').'
            <div class="shadow" style="display:none">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">Mora Total Del Programa</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos Morosos</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">% Porcentaje</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Monto en Lps</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.number_format($moraTotalPrograma[0]['creditosMorosos'], 2, ".", ",").'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$moraTotalPrograma[0]['porcentajeMora'].'%</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($moraTotalPrograma[0]['monto'], 2, ".", ",").'</th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="shadow" style="display:none">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">Total Créditos Cartera Activa</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Cantidad</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Desembolsado</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Ciclo 1</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Ciclo 2</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Ciclo 3</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.number_format($carteraActiva[0]['total']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($carteraActiva[0]['desembolsado'], 2, ".", ",").'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($carteraActiva[0]['ciclo1']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($carteraActiva[0]['ciclo2']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($carteraActiva[0]['ciclo3']).'</th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="shadow" style="display:none">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">Cartera Afectada</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Desembolsado</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">% de Mora</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Mora en Lps</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.number_format($carteraAfectada[0]['creditos']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($carteraAfectada[0]['desembolsado'], 2, ".", ",").'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$carteraAfectada[0]['porcentajeMora'].'%</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($carteraAfectada[0]['mora'], 2, ".", ",").'</th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="shadow">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">Cartera Oficial</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Desembolsado</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Saldo</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">% de Mora</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Mora en Lps</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.number_format($carteraOficial[0]['creditos']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($carteraOficial[0]['desembolsado'], 2, ".", ",").'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($saldoCarteraActiva[0]['0'], 2, ".", ",").'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($carteraOficial[0]['porcentajeMora'], 2, ".", ",").'%</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($carteraOficial[0]['mora'], 2, ".", ",").'</th>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="shadow" style="display:none">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">Cartera Sana previa 25 julio 2016</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Desembolsado</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">% de Mora</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Mora en Lps</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.number_format($antesDeJulio[0]['creditos']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($antesDeJulio[0]['desembolsado'], 2, ".", ",").'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$antesDeJulio[0]['porcentajeMora'].'%</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($antesDeJulio[0]['mora'], 2, ".", ",").'</th>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="shadow" style="display:none">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">Cartera Sana después 25 julio 2016</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Desembolsado</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">% de Mora</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Mora en Lps</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.number_format($despuesDeJulio[0]['creditos']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($despuesDeJulio[0]['desembolsado'], 2, ".", ",").'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$despuesDeJulio[0]['porcentajeMora'].'%</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($despuesDeJulio[0]['mora'], 2, ".", ",").'</th>
                        </tr>
                    </table>
                </div>
            </div>
            <br style="display:none">
            <div class="shadow">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">Meta y cumplimiento del mes de '.$array_meses[$date->format('m') - 1].'</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;"> </th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Meta</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Ejecutado</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Porcentaje</th>
                        </tr>
                        <tr>
                            <th style="text-align:left;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">Créditos</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.number_format($metas[0]['Creditos_Mes']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($ejecutados[0]['Creditos_Mes']).'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format(($ejecutados[0]['Creditos_Mes']/$metas[0]['Creditos_Mes']*100), 2, ".", ",").' %</th>
                        </tr>
                        <tr>
                            <th style="text-align:left;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">Desembolsado</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">L. '.number_format($metas[0]['Monto_Mes'], 2, ".", ",").'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($ejecutados[0]['Monto_Mes'], 2, ".", ",").'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format(($ejecutados[0]['Monto_Mes']/$metas[0]['Monto_Mes']*100), 2, ".", ",").' %</th>
                        </tr>
                        
                    </table>
                </div>
            </div>
            <br>
            <div class="shadow">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">Meta y cumplimiento de año '.date('Y').'</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;"> </th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Meta</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Ejecutado</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Porcentaje</th>
                        </tr>
                        <tr>
                            <th style="text-align:left;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">Créditos</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.number_format($metas[0]['Creditos_Anual']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($ejecutados[0]['Creditos_Anual']).'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format(($ejecutados[0]['Creditos_Anual']/$metas[0]['Creditos_Anual']*100), 2, ".", ",").' %</th>
                        </tr>
                        <tr>
                            <th style="text-align:left;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">Desembolsado</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">L. '.number_format($metas[0]['Monto_Anual'], 2, ".", ",").'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($ejecutados[0]['Monto_Anual'], 2, ".", ",").'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format(($ejecutados[0]['Monto_Anual']/$metas[0]['Monto_Anual']*100), 2, ".", ",").' %</th>
                        </tr>
                        
                    </table>
                </div>
            </div>
            <br>
            <div class="shadow">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">Desglose de Productos '.date('Y').'</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Nombre de Producto</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos desembolsados</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Monto desembolsado</th>
                        </tr>
                        '.$strDesglose.'
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Total</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($totalCreditos).'</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Lps. '.number_format($totalDesembolso, 2, ".", ",").'</th>
                        </tr>
                                
                    </table>
                </div>
            </div>
                    <br>
            <div class="shadow">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;border:none">Histórico</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Empleos directos</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($beneficiarios[0]['count(*)']*1.316).'</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Empleos indirectos</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($beneficiarios[0]['count(*)']*3).'</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Total de Créditos</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($ciclosHistorico[0]['total']).'</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos Cancelados</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($general[0]['creditosCancelados']).'</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos Castigados</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161">'.number_format($general[0]['creditosCastigados']).'</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Ciclo 1 (histórico)</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($ciclosHistorico[0]['ciclo1']).'</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Ciclo 2 (histórico)</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($ciclosHistorico[0]['ciclo2']).'</th>
                        </tr>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Ciclo 3 (histórico)</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($ciclosHistorico[0]['ciclo3']).'</th>
                        </tr>
                        
                    </table>
                </div>
            </div>
            <br>
            <div class="shadow">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">Saldo Cartera Afectada</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Saldo de cartera afectada</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($saldoCarteraAfecta[0]['0'], 2, ".", ",").'</th>
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

if(isset($_GET['descargar'])){
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    // instantiate and use the dompdf class
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($message);
    $dompdf->set_paper("A4", "portrait");
    $dompdf->render();
    $dompdf->stream("Reporte Presidencial");
}else{
    echo $message;
}


?>