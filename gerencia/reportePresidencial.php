<?php


require '../php/conection.php';

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
                        <caption style="text-align:center;font-size:18px;color:#424242;">Mora Total Del Programa</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos Morosos</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">% Porcentaje</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Monto en Lps</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.number_format($moraTotalPrograma[0]['creditosMorosos']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$moraTotalPrograma[0]['porcentajeMora'].'%</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($moraTotalPrograma[0]['monto']).'</th>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="shadow">
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
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($carteraActiva[0]['desembolsado']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($carteraActiva[0]['ciclo1']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($carteraActiva[0]['ciclo2']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($carteraActiva[0]['ciclo3']).'</th>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="shadow">
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
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($carteraAfectada[0]['desembolsado']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$carteraAfectada[0]['porcentajeMora'].'%</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($carteraAfectada[0]['mora']).'</th>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="shadow">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;">Cartera Oficial</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Créditos</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Desembolsado</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">% de Mora</th>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Mora en Lps</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161; border-left: 1px solid #616161;">'.number_format($carteraOficial[0]['creditos']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($carteraOficial[0]['desembolsado']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$carteraOficial[0]['porcentajeMora'].'%</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($carteraOficial[0]['mora']).'</th>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="shadow">
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
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($antesDeJulio[0]['desembolsado']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$antesDeJulio[0]['porcentajeMora'].'%</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($antesDeJulio[0]['mora']).'</th>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="shadow">
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
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($despuesDeJulio[0]['desembolsado']).'</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.$despuesDeJulio[0]['porcentajeMora'].'%</th>
                            <th style="text-align:center;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">L. '.number_format($despuesDeJulio[0]['mora']).'</th>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="shadow">
                <div class="overlay">
                    <table>
                        <caption style="text-align:center;font-size:18px;color:#424242;border:none">Historico 2016</caption>
                        <tr>
                            <th style="font-size:12px;border-top: 1px solid #616161 ;border-bottom: 1px solid #616161; border-left: 1px solid #616161; border-right: 1px solid #616161;">Beneficiarios</th>
                            <th style="text-align:right;font-size:12px;border-top: 1px solid #616161;border-bottom: 1px solid #616161; border-right: 1px solid #616161;">'.number_format($beneficiarios[0]['count(*)']).'</th>
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

        </div>
    </div>

</body>
</html>
';

echo $message;

?>