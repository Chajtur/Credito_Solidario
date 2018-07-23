<?php


require '../php/conection.php';

$array_meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
$date = new DateTime();
/*beneficiarios*/
$sql = $conn->prepare('
    select count(*), sum(monto_desembolsado) from prestamo where if((ciclo is null), if(monto_desembolsado between 1 and 5000,1,if(monto_desembolsado between 5001 and 10000,2,if(monto_desembolsado between 10001 and 20000,3,1))),ciclo) not in ("2","12","3")
');

$sql->execute();
$beneficiarios = $sql->fetchAll();

/*cartera activa*/////////////
/*$sql = $conn->prepare('
    select count(a.Numero_Prestamo) as total, sum(a.Monto_Desembolsado) as desembolsado, count(d.Numero_Prestamo) as ciclo1, count(b.numero_prestamo) as ciclo2, count(c.numero_prestamo) as ciclo3 from prestamo a
    left join prestamo d on a.Numero_Prestamo = d.Numero_Prestamo and if((a.ciclo is null), if(a.monto_desembolsado between 1 and 5000,1,if(a.monto_desembolsado between 5001 and 10000,2,if(a.monto_desembolsado between 10001 and 20000,3,1))),a.ciclo) not in ("2","12","3")
    left join prestamo b on a.Numero_Prestamo = b.Numero_Prestamo and if((b.ciclo is null), if(b.monto_desembolsado between 1 and 5000,1,if(b.monto_desembolsado between 5001 and 10000,2,if(b.monto_desembolsado between 10001 and 20000,3,1))),b.ciclo) in ("2","12")
    left join prestamo c on a.Numero_Prestamo = c.Numero_Prestamo and if((c.ciclo is null), if(c.monto_desembolsado between 1 and 5000,1,if(c.monto_desembolsado between 5001 and 10000,2,if(c.monto_desembolsado between 10001 and 20000,3,1))),c.ciclo) = "3"
    where a.Estado_Credito = "Desembolsado" 
');
$sql->execute();
$carteraActiva = $sql->fetchAll();*/

/*mora total del programa*/////////////
/*$sql = $conn->prepare('
    select count(b.numero_prestamo) as creditosMorosos, (sum(if(DATEDIFF(current_date,if((a.fecha_ultimo_pago is null or a.fecha_ultimo_pago = "0000-00-00"),a.fecha_desembolso,a.fecha_ultimo_pago)) > 15,if(a.capital_mora < 0, 0, a.capital_mora),0))/sum(a.saldo_capital))*100 as porcentajeMora, sum(if(DATEDIFF(current_date,if((a.fecha_ultimo_pago is null or a.fecha_ultimo_pago = "0000-00-00"),a.fecha_desembolso,a.fecha_ultimo_pago)) > 15,if(a.capital_mora < 0, 0, a.capital_mora),0)) as monto
    from prestamo a
    left join prestamo b on a.Numero_Prestamo = b.Numero_Prestamo and b.capital_mora > 0
    where a.Estado_Credito = "Desembolsado"
');
$sql->execute();
$moraTotalPrograma = $sql->fetchAll();*/

/*cartera afectada*//////////////
/*$sql = $conn->prepare('
    select count(*) as creditos, sum(monto_desembolsado) as desembolsado, (sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0))/sum(saldo_capital))*100 as porcentajeMora, sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) as mora
    from prestamo where Usuario_Digitador = "Afectada" and Estado_Credito = "Desembolsado"
');
$sql->execute();
$carteraAfectada = $sql->fetchAll();*/


/*cartera oficial*/
$sql = $conn->prepare('
    select count(*) as creditos, sum(monto_desembolsado) as desembolsado, (sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0))/sum(saldo_capital))*100 as porcentajeMora, sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) as mora
    from prestamo where (usuario_digitador  <> "Afectada" or usuario_digitador is null) and Estado_Credito = "Desembolsado"
');
$sql->execute();
$carteraOficial = $sql->fetchAll();


/*previa al 25 de julio*///////////////////////////
/*$sql = $conn->prepare('
    select count(*) as creditos, sum(monto_desembolsado) as desembolsado, (sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0))/sum(saldo_capital))*100 as porcentajeMora, sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) as mora
    from prestamo where (usuario_digitador  <> "Afectada" or usuario_digitador is null) and Estado_Credito = "Desembolsado" and Fecha_Desembolso <= "2016-7-25"
');
$sql->execute();
$antesDeJulio = $sql->fetchAll();*/


/*despues del 25 de julio*////////////////////
/*$sql = $conn->prepare('
    select count(*) as creditos, sum(monto_desembolsado) as desembolsado, (sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0))/sum(saldo_capital))*100 as porcentajeMora, sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) as mora
    from prestamo where (usuario_digitador  <> "Afectada" or usuario_digitador is null) and Estado_Credito = "Desembolsado" and (Fecha_Desembolso > "2016-7-25" or Fecha_Desembolso is null)
');
$sql->execute();
$despuesDeJulio = $sql->fetchAll();*/

/*ciclos hisoricos*/
$sql = $conn->prepare('
    select count(a.Numero_Prestamo) as total, sum(a.Monto_Desembolsado) as desembolsado, count(d.Numero_Prestamo) as ciclo1, count(b.numero_prestamo) as ciclo2, count(c.numero_prestamo) as ciclo3 from prestamo a
    left join prestamo d on a.Numero_Prestamo = d.Numero_Prestamo and if((a.ciclo is null), if(a.monto_desembolsado between 1 and 5000,1,if(a.monto_desembolsado between 5001 and 10000,2,if(a.monto_desembolsado between 10001 and 20000,3,1))),a.ciclo) not in ("2","12","3")
    left join prestamo b on a.Numero_Prestamo = b.Numero_Prestamo and if((b.ciclo is null), if(b.monto_desembolsado between 1 and 5000,1,if(b.monto_desembolsado between 5001 and 10000,2,if(b.monto_desembolsado between 10001 and 20000,3,1))),b.ciclo) in ("2","12")
    left join prestamo c on a.Numero_Prestamo = c.Numero_Prestamo and if((c.ciclo is null), if(c.monto_desembolsado between 1 and 5000,1,if(c.monto_desembolsado between 5001 and 10000,2,if(c.monto_desembolsado between 10001 and 20000,3,1))),c.ciclo) = "3"
    
');
$sql->execute();
$ciclosHistorico = $sql->fetchAll();


/*créditos cancelados*/////////////////////////
/*$sql = $conn->prepare('
    select count(*) where estado_credito = "cancelado"
    
');
$sql->execute();
$creditosCancelados = $sql->fetchAll();*/

/*créditos castigados*///////////////////
/*$sql = $conn->prepare('
    select count(*) where estado_credito = "castigado"
    
');
$sql->execute();
$creditosCastigados = $sql->fetchAll();*/


/*query para cancelados y castigados*///////////////////////////
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
// 2017
$sql = $conn->prepare('call Desglose_Productos(:param);');
$sql->bindValue(':param', '2017', PDO::PARAM_STR);
$sql->execute();
$desglose = $sql->fetchAll();

$contadorNombreProducto = 0;
$contadorCreditosProductos = 0;
$contadorDesembolsoProductos = 0;
$totalCreditos = 0;
$totalDesembolso = 0;
$totalCapitalMora = 0;
$totalSaldoCapital = 0;

for($i=0; $i< count($desglose); $i++){
    $totalCreditos += $desglose[$i]['1'];
    $totalDesembolso += $desglose[$i]['2'];
    $totalCapitalMora += $desglose[$i]['4'];
    $totalSaldoCapital += $desglose[$i]['3'];
    
    $contadorNombreProducto += $desglose[$i]['0'];
    $contadorCreditosProductos += $desglose[$i]['1'];
    $contadorDesembolsoProductos += $desglose[$i]['2'];
}

// 2016
$sql = $conn->prepare('call Desglose_Productos(:param);');
$sql->bindValue(':param', '2016', PDO::PARAM_STR);
$sql->execute();
$desglose2016 = $sql->fetchAll();

$contadorNombreProducto2016 = 0;
$contadorCreditosProductos2016 = 0;
$contadorDesembolsoProductos2016 = 0;
$totalCreditos2016 = 0;
$totalDesembolso2016 = 0;
$totalCapitalMora2016 = 0;
$totalSaldoCapital2016 = 0;

for($i=0; $i< count($desglose2016); $i++){
    $totalCreditos2016 += $desglose2016[$i]['1'];
    $totalDesembolso2016 += $desglose2016[$i]['2'];
    $totalCapitalMora2016 += $desglose2016[$i]['4'];
    $totalSaldoCapital2016 += $desglose2016[$i]['3'];
    
    $contadorNombreProducto2016 += $desglose2016[$i]['0'];
    $contadorCreditosProductos2016 += $desglose2016[$i]['1'];
    $contadorDesembolsoProductos2016 += $desglose2016[$i]['2'];
}

// 2015
$sql = $conn->prepare('call Desglose_Productos(:param);');
$sql->bindValue(':param', '2015', PDO::PARAM_STR);
$sql->execute();
$desglose2015 = $sql->fetchAll();

$contadorNombreProducto2015 = 0;
$contadorCreditosProductos2015 = 0;
$contadorDesembolsoProductos2015 = 0;
$totalCreditos2015 = 0;
$totalDesembolso2015 = 0;
$totalCapitalMora2015 = 0;
$totalSaldoCapital2015 = 0;

for($i=0; $i< count($desglose2015); $i++){
    $totalCreditos2015 += $desglose2015[$i]['1'];
    $totalDesembolso2015 += $desglose2015[$i]['2'];
    $totalCapitalMora2015 += $desglose2015[$i]['4'];
    $totalSaldoCapital2015 += $desglose2015[$i]['3'];
    
    $contadorNombreProducto2015 += $desglose2015[$i]['0'];
    $contadorCreditosProductos2015 += $desglose2015[$i]['1'];
    $contadorDesembolsoProductos2015 += $desglose2015[$i]['2'];
}

// Historico
$sql = $conn->prepare('call Desglose_Productos(:param);');
$sql->bindValue(':param', 'historico', PDO::PARAM_STR);
$sql->execute();
$desglosehistorico = $sql->fetchAll();

$contadorNombreProductohistorico = 0;
$contadorCreditosProductoshistorico = 0;
$contadorDesembolsoProductoshistorico = 0;
$totalCreditoshistorico = 0;
$totalDesembolsohistorico = 0;
$totalCapitalMorahistorico = 0;
$totalSaldoCapitalhistorico = 0;

for($i=0; $i< count($desglosehistorico); $i++){
    $totalCreditoshistorico += $desglosehistorico[$i]['1'];
    $totalDesembolsohistorico += $desglosehistorico[$i]['2'];
    $totalCapitalMorahistorico += $desglosehistorico[$i]['4'];
    $totalSaldoCapitalhistorico += $desglosehistorico[$i]['3'];
    
    $contadorNombreProductohistorico += $desglosehistorico[$i]['0'];
    $contadorCreditosProductoshistorico += $desglosehistorico[$i]['1'];
    $contadorDesembolsoProductoshistorico += $desglosehistorico[$i]['2'];
}

// Cartera Activa
$sql = $conn->prepare('call Desglose_Productos(:param);');
$sql->bindValue(':param', 'activa', PDO::PARAM_STR);
$sql->execute();
$desgloseactiva = $sql->fetchAll();

$contadorNombreProductoactiva = 0;
$contadorCreditosProductosactiva = 0;
$contadorDesembolsoProductosactiva = 0;
$totalCreditosactiva = 0;
$totalDesembolsoactiva = 0;
$totalCapitalMoraactiva = 0;
$totalSaldoCapitalactiva = 0;

for($i=0; $i< count($desgloseactiva); $i++){
    $totalCreditosactiva += $desgloseactiva[$i]['1'];
    $totalDesembolsoactiva += $desgloseactiva[$i]['2'];
    $totalCapitalMoraactiva += $desgloseactiva[$i]['4'];
    $totalSaldoCapitalactiva += $desgloseactiva[$i]['3'];
    
    $contadorNombreProductoactiva += $desgloseactiva[$i]['0'];
    $contadorCreditosProductosactiva += $desgloseactiva[$i]['1'];
    $contadorDesembolsoProductosactiva += $desgloseactiva[$i]['2'];
}

?>

<style>

.custom-select {
    display: inline !important;
    height: 26px !important;
    padding: 2px 0px 2px 0px !important;
    border: 0px !important;
}

</style>

<div class="section">
    <div class="row">
            <div class="col s12 m12 l8">
                <!--desktop-->
                <div id="work-collections" class="">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                            <ul id="projects-collection" class="collection z-depth-1">
                                <li class="collection-item avatar">
                                    <i class="material-icons circle light-blue">timeline</i>
                                    <span class="collection-header">Meta y cumplimiento</span>
                                    <div class="row no-margin no-padding">
                                        <div class="col l4 m4 s12 no-margin no-padding">
                                            <select class="browser-default custom-select blue white-text" id="selectMesesMetaCumplimiento">
                                                <option class="white black-text" value="1">Mes de Enero</option>
                                                <option class="white black-text" value="2">Mes de Febrero</option>
                                                <option class="white black-text" value="3">Mes de Marzo</option>
                                                <option class="white black-text" value="4">Mes de Abril</option>
                                                <option class="white black-text" value="5">Mes de Mayo</option>
                                                <option class="white black-text" value="6">Mes de Junio</option>
                                                <option class="white black-text" value="7">Mes de Julio</option>
                                                <option class="white black-text" value="8">Mes de Agosto</option>
                                                <option class="white black-text" value="9">Mes de Septiembre</option>
                                                <option class="white black-text" value="10">Mes de Octubre</option>
                                                <option class="white black-text" value="11">Mes de Noviembre</option>
                                                <option class="white black-text" value="12">Mes de Diciembre</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!--<div class="secondary-content actions">
                                        <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                        <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                            <i class="material-icons center-align">search</i>
                                        </a>
                                        <form action="" method="" id="">
                                            <input type="hidden" name="user_id" id="hidden_id" value="">
                                            <button type="submit" class="waves-effect btn-flat nopadding"><i class="material-icons">description</i></button>
                                        </form>
                                    </div>-->
                                    <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                
                                </li>
                                <li class="collection-item containerDatosMetaCumplimiento">
                                    <div class="row">
                                        <div class="col s3 m3 l3">
                                            <p class="collections-title"></p>
                                        </div>
                                        <div class="col s3 m3 l3">
                                            <p class="collections-title">Meta</p>
                                        </div>
                                        <div class="col s3 m3 l3">
                                            <p class="collections-title">Ejecutado</p>
                                        </div>
                                        <div class="col s3 m3 l3">
                                            <p class="collections-title">Porcentaje</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="collection-item containerDatosMetaCumplimiento">
                                    <div class="row">
                                        <div class="col s3">
                                            <p class="collections-title">Créditos</p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content" id="metaCreditosElement"></p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content" id="metaCreditosEjecutadoElement"></p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content" id="metaPorcentajeElement"></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="collection-item containerDatosMetaCumplimiento">
                                    <div class="row">
                                        <div class="col s3">
                                            <p class="collections-title">Ejecutados</p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content" id="ejecutadosElement"></p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content" id="ejecutadoEjecutadoElement"></p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content" id="ejecutadoPorcentajeElement"></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="collection-item center" id="loadingcontainer">
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="preloader-wrapper active">
                                                <div class="spinner-layer spinner-green-only">
                                                    <div class="circle-clipper left">
                                                        <div class="circle"></div>
                                                    </div><div class="gap-patch">
                                                        <div class="circle"></div>
                                                    </div><div class="circle-clipper right">
                                                        <div class="circle"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!--desktop-->
                <div id="work-collections" class="hide-on-small-only">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                            <ul id="projects-collection" class="collection z-depth-1">
                                <li class="collection-item avatar">
                                    <i class="material-icons circle green ">timeline</i>
                                    <span class="collection-header">Meta y cumplimiento</span>
                                    <p>del año <?php echo date('Y') ?></p>
                                    <!--<div class="secondary-content actions">
                                        <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                        <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                            <i class="material-icons center-align">search</i>
                                        </a>
                                        <form action="" method="" id="">
                                            <input type="hidden" name="user_id" id="hidden_id" value="">
                                            <button type="submit" class="waves-effect btn-flat nopadding"><i class="material-icons">description</i></button>
                                        </form>
                                    </div>-->
                                    <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s3 m3 l3">
                                            <p class="collections-title"></p>
                                        </div>
                                        <div class="col s3 m3 l3">
                                            <p class="collections-title">Meta</p>
                                        </div>
                                        <div class="col s3 m3 l3">
                                            <p class="collections-title">Ejecutado</p>
                                        </div>
                                        <div class="col s3 m3 l3">
                                            <p class="collections-title">Porcentaje</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s3">
                                            <p class="collections-title">Créditos</p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content"><?php echo number_format($metas[0]['Creditos_Anual']) ?></p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content"><?php echo number_format($ejecutados[0]['Creditos_Anual']) ?></p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content"><?php echo number_format(($ejecutados[0]['Creditos_Anual']/$metas[0]['Creditos_Anual']*100), 2, ".", ",") ?>%</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s3">
                                            <p class="collections-title">Ejecutados</p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content">L.<?php echo number_format($metas[0]['Monto_Anual'], 2, ".", ",") ?></p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content">L.<?php echo number_format($ejecutados[0]['Monto_Anual'], 2, ".", ",") ?></p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content"><?php echo number_format(($ejecutados[0]['Monto_Anual']/$metas[0]['Monto_Anual']*100), 2, ".", ",") ?>%</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--movil-->
                <div id="work-collapsible" class="hide-on-med-and-up">
                                            <div class="row">
                                                <div class="col s12" id="">
                                                    <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                                        <li class="collapsible-item-header avatar">
                                                            <i class="material-icons circle circle light-blue ">timeline</i>
                                                            <span class="collapsible-title-header">Meta y cumplimiento
                                                                <!--<div class="secondary-content actions">
                                                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                                        <i class="material-icons center-align">search</i>
                                                                    </a>  
                                                                </div>-->
                                                            </span>
                                                            <p>del año <?php echo date('Y') ?></p>
                                                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                                        </li>
                                                        <li>
                                                            <div class="collapsible-header-titles  sin-icon">
                                                                <div class="row">
                                                                   <div class="col s4 m3 l3">
                                                                        <p class="collapsible-title"></p>
                                                                    </div>
                                                                    <div class="col s4 m3 l3">
                                                                        <p class="collapsible-title">Meta</p>
                                                                    </div>
                                                                    <div class="col s4 m3 l3 ">
                                                                        <p class="collapsible-title">Ejecutado</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <div class="list collapsible no-padding no-margin z-depth-0">
                                                           
                                                                            <li>
                                                                                <div class="collapsible-header sin-icon">
                                                                                    <div class="row">
                                                                                        <div class="col s4 m3 l3">
                                                                                            <p class="collapsible-title truncate nombreAgencia"><span class="blue-text">+</span> Créditos</p>
                                                                                        </div>
                                                                                        <div class="col s4 m3 l3">
                                                                                            <p class="collapsible-content truncate crediDesembolsados "><?php echo number_format($metas[0]['Creditos_Anual']) ?></p>
                                                                                        </div>
                                                                                        <div class="col s4 m3 l3">
                                                                                            <p class="collapsible-content truncate crediDesembolsados "><?php echo number_format($ejecutados[0]['Creditos_Anual']) ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="collapsible-body"><span class="montoDesembolsado">Porcentaje de Créditos: <?php echo number_format(($ejecutados[0]['Creditos_Anual']/$metas[0]['Creditos_Anual']*100), 2, ".", ",") ?>%</span></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="collapsible-header sin-icon">
                                                                                    <div class="row">
                                                                                        <div class="col s4 m3 l3">
                                                                                            <p class="collapsible-title truncate nombreAgencia"><span class="blue-text">+</span> Ejecutados</p>
                                                                                        </div>
                                                                                        <div class="col s4 m3 l3">
                                                                                            <p class="collapsible-content truncate crediDesembolsados ">L.<?php echo number_format($metas[0]['Monto_Anual'], 2, ".", ",") ?></p>
                                                                                        </div>
                                                                                        <div class="col s4 m3 l3">
                                                                                            <p class="collapsible-content truncate crediDesembolsados ">L.<?php echo number_format($ejecutados[0]['Monto_Anual'], 2, ".", ",") ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="collapsible-body"><span class="montoDesembolsado">Porcentaje de Ejecutados: <?php echo number_format(($ejecutados[0]['Monto_Anual']/$metas[0]['Monto_Anual']*100), 2, ".", ",") ?>%</span></div>
                                                                            </li>
                                                                
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
               
                 <!--desktop-->
                <!--<div id="work-collections" class="hide hide-on-small-only">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <ul id="projects-collection" class="collection z-depth-1">
                                <li class="collection-item avatar">
                                    <i class="material-icons circle indigo ">timeline</i>
                                    <span class="collection-header">Desglose de Productos</span>
                                    <p>del año <?php echo date('Y') ?></p>
                                    <div class="secondary-content actions">
                                        <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                        <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                            <i class="material-icons center-align">search</i>
                                        </a>
                                        <form action="" method="" id="">
                                            <input type="hidden" name="user_id" id="hidden_id" value="">
                                            <button type="submit" class="waves-effect btn-flat nopadding"><i class="material-icons">description</i></button>
                                        </form>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s4 m4 l3 truncate">
                                            <p class="collections-title truncate">Nombre Producto</p>
                                        </div>
                                        <div class="col s4 m4 l3">
                                            <p class="collections-title">Créditos</p>
                                        </div>
                                        <div class="col s4 m4 l3">
                                            <p class="collections-title">Monto</p>
                                        </div>
                                        <div class="col s4 m4 l3">
                                            <p class="collections-title">Monto</p>
                                        </div>
                                        <div class="col s4 m4 l3">
                                            <p class="collections-title">Monto</p>
                                        </div>
                                    </div>
                                </li>
                                <?php echo $strDesglose; ?>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s5">
                                            <p class="collections-content">Total</p>
                                        </div>
                                        <div class="col s4">
                                            <p class="collections-content"><?php echo number_format($totalCreditos); ?></p>
                                        </div>
                                        <div class="col s3">
                                            <p class="collections-content">L.<?php echo number_format($totalDesembolso, 2, ".", ","); ?></p>
                                        </div>
                                    </div>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>-->
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs z-depth-1">
                            <li class="tab"><a class="active" href="#test1" id="tabactivetab">2017</a></li>
                            <li class="tab"><a href="#test2">2016</a></li>
                            <li class="tab"><a href="#test3">2015</a></li>
                            <li class="tab"><a href="#test4">Cartera Activa</a></li>
                            <li class="tab"><a href="#test5">Histórico</a></li>
                        </ul>
                    </div>
                    <div id="test1" class="col s12">
                        <div id="work-collapsible" class="hide-on-med-and-down">
                            <div class="row">
                                <div class="col s12" id="">
                                    <ul id="projects-collection" class="collapsible no-margin no-border" data-collapsible="accordion">
                                        <li class="collapsible-item-header avatar">
                                            <i class="material-icons circle circle blue">timeline</i>
                                            <span class="collapsible-title-header">Desglose de Productos
                                                <!--<div class="secondary-content actions">
                                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                        <i class="material-icons center-align">search</i>
                                                    </a>  
                                                </div>-->
                                            </span>
                                            <p>del año <?php echo date('Y') ?></p>
                                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                        </li>
                                        <li>
                                            <div class="collapsible-header-titles  sin-icon">
                                                <div class="row">
                                                    <div class="col s6 m3 l4">
                                                        <p class="collapsible-title">Nombre de Producto</p>
                                                    </div>
                                                    <div class="col s6 m3 l3 ">
                                                        <p class="collapsible-title">Créditos</p>
                                                    </div>
                                                    <div class="col s6 m3 l4 ">
                                                        <p class="collapsible-title">Monto desembolsado</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <div class="list collapsible no-padding no-margin z-depth-0">
                                            <?php $i=0;?>
                                            <?php if(count($desglose) > 0):?>

                                                <?php foreach($desglose as $desglosados):?>
                                                    <?php $i++;?>
                                                    <li>
                                                        <div class="collapsible-header sin-icon">
                                                            <div class="row">
                                                                <div class="col s6 m3 l4">
                                                                    <p class="collapsible-content truncate nombreAgencia"><span class="blue-text">+</span> <?php echo $desglosados['0'] == null ? 'Por asignar' : $desglosados['0']; ?></p>
                                                                </div>
                                                                <div class="col s6 m3 l3">
                                                                    <p class="collapsible-content truncate crediDesembolsados"><?php echo $desglosados['1']; ?></p>
                                                                </div>
                                                                <div class="col s6 m3 l4">
                                                                    <p class="collapsible-content truncate">L. <?php echo number_format($desglosados['2'], 2, ".", ","); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="collapsible-body">
                                                            <p class="montoDesembolsado">Saldo Capital: L.<?php echo number_format($desglosados['3'], 2, ".", ","); ?></p>
                                                            <p class="montoDesembolsado">Capital En Mora: L.<?php echo number_format($desglosados['4'], 2, ".", ","); ?></p>
                                                        </div>
                                                    </li>
                                                <?php endforeach;?>
                                            <?php else:?>
                                                <li class="center">
                                                <h5>No hay Datos</h5></li>
                                            <?php endif;?>
                                        </div>
                                        <li>
                                            <div class="collapsible-header sin-icon">
                                                <div class="row">
                                                    <div class="col s6 m3 l3">
                                                        <p class="collapsible-content truncate nombreAgencia"><span class="blue-text">+</span> Totales</p>
                                                    </div>
                                                    <div class="col s6 m3 l3">
                                                        <p class="collapsible-content truncate crediDesembolsados center-align"><?php echo number_format($totalCreditos); ?></p>
                                                    </div>
                                                    <div class="col s6 m3 l4">
                                                        <p class="collapsible-content truncate crediDesembolsados center-align">L.<?php echo number_format($totalDesembolso, 2, ".", ","); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapsible-body">
                                                <p class="montoDesembolsado">Saldo Capital: L.<?php echo number_format($totalSaldoCapital, 2, ".", ","); ?></p>
                                                <p class="montoDesembolsado">Capital En Mora: L.<?php echo number_format($totalCapitalMora, 2, ".", ","); ?></p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="test2" class="col s12">
                        <div id="work-collapsible" class="hide-on-med-and-down">
                            <div class="row">
                                <div class="col s12" id="">
                                    <ul id="projects-collection" class="collapsible no-margin no-border" data-collapsible="accordion">
                                        <li class="collapsible-item-header avatar">
                                            <i class="material-icons circle circle blue">timeline</i>
                                            <span class="collapsible-title-header">Desglose de Productos
                                                <!--<div class="secondary-content actions">
                                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                        <i class="material-icons center-align">search</i>
                                                    </a>  
                                                </div>-->
                                            </span>
                                            <p>del año 2016</p>
                                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                        </li>
                                        <li>
                                            <div class="collapsible-header-titles  sin-icon">
                                                <div class="row">
                                                    <div class="col s6 m3 l4">
                                                        <p class="collapsible-title">Nombre de Producto</p>
                                                    </div>
                                                    <div class="col s6 m3 l3 ">
                                                        <p class="collapsible-title">Créditos</p>
                                                    </div>
                                                    <div class="col s6 m3 l4 ">
                                                        <p class="collapsible-title">Monto desembolsado</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <div class="list collapsible no-padding no-margin z-depth-0">
                                            <?php $i=0;?>
                                            <?php if(count($desglose2016) > 0):?>

                                                <?php foreach($desglose2016 as $desglosados):?>
                                                    <?php $i++;?>
                                                    <li>
                                                        <div class="collapsible-header sin-icon">
                                                            <div class="row">
                                                                <div class="col s6 m3 l4">
                                                                    <p class="collapsible-content truncate nombreAgencia"><span class="blue-text">+</span> <?php echo $desglosados['0'] == null ? 'Por asignar' : $desglosados['0']; ?></p>
                                                                </div>
                                                                <div class="col s6 m3 l3">
                                                                    <p class="collapsible-content truncate crediDesembolsados"><?php echo $desglosados['1']; ?></p>
                                                                </div>
                                                                <div class="col s6 m3 l4">
                                                                    <p class="collapsible-content truncate">L. <?php echo number_format($desglosados['2'], 2, ".", ","); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="collapsible-body">
                                                            <p class="montoDesembolsado">Saldo Capital: L.<?php echo number_format($desglosados['3'], 2, ".", ","); ?></p>
                                                            <p class="montoDesembolsado">Capital En Mora: L.<?php echo number_format($desglosados['4'], 2, ".", ","); ?></p>
                                                        </div>
                                                    </li>
                                                <?php endforeach;?>
                                            <?php else:?>
                                                <li class="center">
                                                <h5>No hay Datos</h5></li>
                                            <?php endif;?>
                                        </div>
                                        <li>
                                            <div class="collapsible-header sin-icon">
                                                <div class="row">
                                                    <div class="col s6 m3 l3">
                                                        <p class="collapsible-content truncate nombreAgencia"><span class="blue-text">+</span> Totales</p>
                                                    </div>
                                                    <div class="col s6 m3 l3">
                                                        <p class="collapsible-content truncate crediDesembolsados center-align"><?php echo number_format($totalCreditos2016); ?></p>
                                                    </div>
                                                    <div class="col s6 m3 l4">
                                                        <p class="collapsible-content truncate crediDesembolsados center-align">L.<?php echo number_format($totalDesembolso2016, 2, ".", ","); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapsible-body">
                                                <p class="montoDesembolsado">Saldo Capital: L.<?php echo number_format($totalSaldoCapital2016, 2, ".", ","); ?></p>
                                                <p class="montoDesembolsado">Capital En Mora: L.<?php echo number_format($totalCapitalMora2016, 2, ".", ","); ?></p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="test3" class="col s12">
                        <div id="work-collapsible" class="hide-on-med-and-down">
                            <div class="row">
                                <div class="col s12" id="">
                                    <ul id="projects-collection" class="collapsible no-margin no-border" data-collapsible="accordion">
                                        <li class="collapsible-item-header avatar">
                                            <i class="material-icons circle circle blue">timeline</i>
                                            <span class="collapsible-title-header">Desglose de Productos
                                                <!--<div class="secondary-content actions">
                                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                        <i class="material-icons center-align">search</i>
                                                    </a>  
                                                </div>-->
                                            </span>
                                            <p>del año 2015</p>
                                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                        </li>
                                        <li>
                                            <div class="collapsible-header-titles  sin-icon">
                                                <div class="row">
                                                    <div class="col s6 m3 l4">
                                                        <p class="collapsible-title">Nombre de Producto</p>
                                                    </div>
                                                    <div class="col s6 m3 l3 ">
                                                        <p class="collapsible-title">Créditos</p>
                                                    </div>
                                                    <div class="col s6 m3 l4 ">
                                                        <p class="collapsible-title">Monto desembolsado</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <div class="list collapsible no-padding no-margin z-depth-0">
                                            <?php $i=0;?>
                                            <?php if(count($desglose2015) > 0):?>

                                                <?php foreach($desglose2015 as $desglosados):?>
                                                    <?php $i++;?>
                                                    <li>
                                                        <div class="collapsible-header sin-icon">
                                                            <div class="row">
                                                                <div class="col s6 m3 l4">
                                                                    <p class="collapsible-content truncate nombreAgencia"><span class="blue-text">+</span> <?php echo $desglosados['0'] == null ? 'Por asignar' : $desglosados['0']; ?></p>
                                                                </div>
                                                                <div class="col s6 m3 l3">
                                                                    <p class="collapsible-content truncate crediDesembolsados"><?php echo $desglosados['1']; ?></p>
                                                                </div>
                                                                <div class="col s6 m3 l4">
                                                                    <p class="collapsible-content truncate">L. <?php echo number_format($desglosados['2'], 2, ".", ","); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="collapsible-body">
                                                            <p class="montoDesembolsado">Saldo Capital: L.<?php echo number_format($desglosados['3'], 2, ".", ","); ?></p>
                                                            <p class="montoDesembolsado">Capital En Mora: L.<?php echo number_format($desglosados['4'], 2, ".", ","); ?></p>
                                                        </div>
                                                    </li>
                                                <?php endforeach;?>
                                            <?php else:?>
                                                <li class="center">
                                                <h5>No hay Datos</h5></li>
                                            <?php endif;?>
                                        </div>
                                        <li>
                                            <div class="collapsible-header sin-icon">
                                                <div class="row">
                                                    <div class="col s6 m3 l3">
                                                        <p class="collapsible-content truncate nombreAgencia"><span class="blue-text">+</span> Totales</p>
                                                    </div>
                                                    <div class="col s6 m3 l3">
                                                        <p class="collapsible-content truncate crediDesembolsados center-align"><?php echo number_format($totalCreditos2015); ?></p>
                                                    </div>
                                                    <div class="col s6 m3 l4">
                                                        <p class="collapsible-content truncate crediDesembolsados center-align">L.<?php echo number_format($totalDesembolso2015, 2, ".", ","); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapsible-body">
                                                <p class="montoDesembolsado">Saldo Capital: L.<?php echo number_format($totalSaldoCapital2015, 2, ".", ","); ?></p>
                                                <p class="montoDesembolsado">Capital En Mora: L.<?php echo number_format($totalCapitalMora2015, 2, ".", ","); ?></p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="test4" class="col s12">
                        <div id="work-collapsible" class="hide-on-med-and-down">
                            <div class="row">
                                <div class="col s12" id="">
                                    <ul id="projects-collection" class="collapsible no-margin no-border" data-collapsible="accordion">
                                        <li class="collapsible-item-header avatar">
                                            <i class="material-icons circle circle blue">timeline</i>
                                            <span class="collapsible-title-header">Desglose de Productos
                                                <!--<div class="secondary-content actions">
                                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                        <i class="material-icons center-align">search</i>
                                                    </a>  
                                                </div>-->
                                            </span>
                                            <p>Cartera Activa</p>
                                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                        </li>
                                        <li>
                                            <div class="collapsible-header-titles  sin-icon">
                                                <div class="row">
                                                    <div class="col s6 m3 l4">
                                                        <p class="collapsible-title">Nombre de Producto</p>
                                                    </div>
                                                    <div class="col s6 m3 l3 ">
                                                        <p class="collapsible-title">Créditos</p>
                                                    </div>
                                                    <div class="col s6 m3 l4 ">
                                                        <p class="collapsible-title">Monto desembolsado</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <div class="list collapsible no-padding no-margin z-depth-0">
                                            <?php $i=0;?>
                                            <?php if(count($desgloseactiva) > 0):?>

                                                <?php foreach($desgloseactiva as $desglosados):?>
                                                    <?php $i++;?>
                                                    <li>
                                                        <div class="collapsible-header sin-icon">
                                                            <div class="row">
                                                                <div class="col s6 m3 l4">
                                                                    <p class="collapsible-content truncate nombreAgencia"><span class="blue-text">+</span> <?php echo $desglosados['0'] == null ? 'Por asignar' : $desglosados['0']; ?></p>
                                                                </div>
                                                                <div class="col s6 m3 l3">
                                                                    <p class="collapsible-content truncate crediDesembolsados"><?php echo $desglosados['1']; ?></p>
                                                                </div>
                                                                <div class="col s6 m3 l4">
                                                                    <p class="collapsible-content truncate">L. <?php echo number_format($desglosados['2'], 2, ".", ","); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="collapsible-body">
                                                            <p class="montoDesembolsado">Saldo Capital: L.<?php echo number_format($desglosados['3'], 2, ".", ","); ?></p>
                                                            <p class="montoDesembolsado">Capital En Mora: L.<?php echo number_format($desglosados['4'], 2, ".", ","); ?></p>
                                                        </div>
                                                    </li>
                                                <?php endforeach;?>
                                            <?php else:?>
                                                <li class="center">
                                                <h5>No hay Datos</h5></li>
                                            <?php endif;?>
                                        </div>
                                        <li>
                                            <div class="collapsible-header sin-icon">
                                                <div class="row">
                                                    <div class="col s6 m3 l3">
                                                        <p class="collapsible-content truncate nombreAgencia"><span class="blue-text">+</span> Totales</p>
                                                    </div>
                                                    <div class="col s6 m3 l3">
                                                        <p class="collapsible-content truncate crediDesembolsados center-align"><?php echo number_format($totalCreditosactiva); ?></p>
                                                    </div>
                                                    <div class="col s6 m3 l4">
                                                        <p class="collapsible-content truncate crediDesembolsados center-align">L.<?php echo number_format($totalDesembolsoactiva, 2, ".", ","); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapsible-body">
                                                <p class="montoDesembolsado">Saldo Capital: L.<?php echo number_format($totalSaldoCapitalactiva, 2, ".", ","); ?></p>
                                                <p class="montoDesembolsado">Capital En Mora: L.<?php echo number_format($totalCapitalMoraactiva, 2, ".", ","); ?></p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="test5" class="col s12">
                        <div id="work-collapsible" class="hide-on-med-and-down">
                            <div class="row">
                                <div class="col s12" id="">
                                    <ul id="projects-collection" class="collapsible no-margin no-border" data-collapsible="accordion">
                                        <li class="collapsible-item-header avatar">
                                            <i class="material-icons circle circle blue">timeline</i>
                                            <span class="collapsible-title-header">Desglose de Productos
                                                <!--<div class="secondary-content actions">
                                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                        <i class="material-icons center-align">search</i>
                                                    </a>  
                                                </div>-->
                                            </span>
                                            <p>Histórico</p>
                                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                        </li>
                                        <li>
                                            <div class="collapsible-header-titles  sin-icon">
                                                <div class="row">
                                                    <div class="col s6 m3 l4">
                                                        <p class="collapsible-title">Nombre de Producto</p>
                                                    </div>
                                                    <div class="col s6 m3 l3 ">
                                                        <p class="collapsible-title">Créditos</p>
                                                    </div>
                                                    <div class="col s6 m3 l4 ">
                                                        <p class="collapsible-title">Monto desembolsado</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <div class="list collapsible no-padding no-margin z-depth-0">
                                            <?php $i=0;?>
                                            <?php if(count($desglosehistorico) > 0):?>

                                                <?php foreach($desglosehistorico as $desglosados):?>
                                                    <?php $i++;?>
                                                    <li>
                                                        <div class="collapsible-header sin-icon">
                                                            <div class="row">
                                                                <div class="col s6 m3 l4">
                                                                    <p class="collapsible-content truncate nombreAgencia"><span class="blue-text">+</span> <?php echo $desglosados['0'] == null ? 'Por asignar' : $desglosados['0']; ?></p>
                                                                </div>
                                                                <div class="col s6 m3 l3">
                                                                    <p class="collapsible-content truncate crediDesembolsados"><?php echo $desglosados['1']; ?></p>
                                                                </div>
                                                                <div class="col s6 m3 l4">
                                                                    <p class="collapsible-content truncate">L. <?php echo number_format($desglosados['2'], 2, ".", ","); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="collapsible-body">
                                                            <p class="montoDesembolsado">Saldo Capital: L.<?php echo number_format($desglosados['3'], 2, ".", ","); ?></p>
                                                            <p class="montoDesembolsado">Capital En Mora: L.<?php echo number_format($desglosados['4'], 2, ".", ","); ?></p>
                                                        </div>
                                                    </li>
                                                <?php endforeach;?>
                                            <?php else:?>
                                                <li class="center">
                                                <h5>No hay Datos</h5></li>
                                            <?php endif;?>
                                        </div>
                                        <li>
                                            <div class="collapsible-header sin-icon">
                                                <div class="row">
                                                    <div class="col s6 m3 l3">
                                                        <p class="collapsible-content truncate nombreAgencia"><span class="blue-text">+</span> Totales</p>
                                                    </div>
                                                    <div class="col s6 m3 l3">
                                                        <p class="collapsible-content truncate crediDesembolsados center-align"><?php echo number_format($totalCreditoshistorico); ?></p>
                                                    </div>
                                                    <div class="col s6 m3 l4">
                                                        <p class="collapsible-content truncate crediDesembolsados center-align">L.<?php echo number_format($totalDesembolsohistorico, 2, ".", ","); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapsible-body">
                                                <p class="montoDesembolsado">Saldo Capital: L.<?php echo number_format($totalSaldoCapitalhistorico, 2, ".", ","); ?></p>
                                                <p class="montoDesembolsado">Capital En Mora: L.<?php echo number_format($totalCapitalMorahistorico, 2, ".", ","); ?></p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                <!--movil-->
                <div id="work-collapsible" class="hide-on-large-only">
                                            <div class="row">
                                                <div class="col s12" id="">
                                                    <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                                        <li class="collapsible-item-header avatar">
                                                            <i class="material-icons circle circle blue">timeline</i>
                                                            <span class="collapsible-title-header">Desglose de Porductos
                                                                <!--<div class="secondary-content actions">
                                                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                                        <i class="material-icons center-align">search</i>
                                                                    </a>  
                                                                </div>-->
                                                            </span>
                                                            <p>del año <?php echo date('Y') ?></p>
                                                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                                        </li>
                                                        <li>
                                                            <div class="collapsible-header-titles  sin-icon">
                                                                <div class="row">
                                                                    <div class="col s6 m3 l3">
                                                                        <p class="collapsible-title">Nombre de Producto</p>
                                                                    </div>
                                                                    <div class="col s6 m3 l3 ">
                                                                        <p class="collapsible-title">Créditos desembolsados</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <div class="list collapsible no-padding no-margin z-depth-0">
                                                           <?php $i=0;?>
                                                                <?php if(count($desglose) > 0):?>

                                                                    <?php foreach($desglose as $desglosados):?>
                                                                        <?php $i++;?>
                                                                            <li>
                                                                                <div class="collapsible-header sin-icon">
                                                                                    <div class="row">
                                                                                        <div class="col s6 m3 l3">
                                                                                            <p class="collapsible-content truncate nombreAgencia"><span class="blue-text">+</span> <?php echo $desglosados['0'] == null ? 'Por asignar' : $desglosados['0']; ?></p>
                                                                                        </div>
                                                                                        <div class="col s6 m3 l3">
                                                                                            <p class="collapsible-content truncate crediDesembolsados center-align"><?php echo $desglosados['1']; ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="collapsible-body">
                                                                                    <p class="montoDesembolsado">Monto Desembolsado: L.<?php echo number_format($desglosados['2']); ?></p>
                                                                                    <p class="montoDesembolsado">Saldo Capital: L.<?php echo number_format($desglosados['3'], 2, ".", ","); ?></p>
                                                                                    <p class="montoDesembolsado">Capital En Mora: L.<?php echo number_format($desglosados['4'], 2, ".", ","); ?></p>
                                                                                </div>
                                                                            </li>
                                                                <?php endforeach;?>
                                                                    <?php else:?>
                                                                        <li class="center">
                                                                        <h5>No hay ningún beneficiario</h5></li>
                                                            <?php endif;?>
                                                        </div>
                                                        <li>
                                                            <div class="collapsible-header sin-icon">
                                                                <div class="row">
                                                                    <div class="col s6 m3 l3">
                                                                        <p class="collapsible-content truncate nombreAgencia"><span class="blue-text">+</span> Total</p>
                                                                    </div>
                                                                    <div class="col s6 m3 l3">
                                                                        <p class="collapsible-content truncate crediDesembolsados center-align"><?php echo number_format($totalCreditos); ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="collapsible-body">
                                                                <p class="montoDesembolsado">Monto Desembolsado: L.<?php echo number_format($totalDesembolso, 2, ".", ","); ?></p></p>
                                                                 <p class="montoDesembolsado">Saldo Capital: L.<?php echo number_format($totalSaldoCapital, 2, ".", ","); ?></p>
                                                                <p class="montoDesembolsado">Capital En Mora: L.<?php echo number_format($totalCapitalMora, 2, ".", ","); ?></p>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
            </div>
            <div class="col s12 m4 l4">
                <ul class="collection with-header z-depth-1">
                    <li class="collection-header">
                        <h5>Cartera Oficial</h5></li>
                    <li class="collection-item">
                        <div>Créditos<span class="secondary-content"><?php echo number_format($carteraOficial[0]['creditos']); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Desembolsado<span class="secondary-content"><?php echo number_format($carteraOficial[0]['desembolsado'], 2, ".", ","); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Saldo<span class="secondary-content"><?php echo number_format($saldoCarteraActiva[0]['0'], 2, ".", ","); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>% de mora<span class="secondary-content"><?php echo number_format($carteraOficial[0]['porcentajeMora'], 2, ".", ","); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Mora en Lps<span class="secondary-content"><?php echo number_format($carteraOficial[0]['mora'], 2, ".", ","); ?></span></div>
                    </li>
                </ul>

                <ul class="collection with-header z-depth-1">
                    <li class="collection-header">
                        <h5>Historico</h5></li>
                    <li class="collection-item">
                        <div>Empleos directos<span class="secondary-content"><?php echo number_format($beneficiarios[0]['count(*)']*1.316); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Empleos indirectos<span class="secondary-content"><?php echo number_format($beneficiarios[0]['count(*)']*3); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Total de Créditos<span class="secondary-content"><?php echo number_format($ciclosHistorico[0]['total']); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Créditos Cancelados<span href="#!" class="secondary-content"><?php echo number_format($general[0]['creditosCancelados']) ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Créditos Castigados<span class="secondary-content"><?php echo number_format($general[0]['creditosCastigados']); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Ciclo 1 (histórico)<span class="secondary-content"><?php echo number_format($ciclosHistorico[0]['ciclo1']); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Ciclo 2 (histórico)<span class="secondary-content"><?php echo number_format($ciclosHistorico[0]['ciclo2']); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Ciclo 3 (histórico)<span class="secondary-content"><?php echo number_format($ciclosHistorico[0]['ciclo3']); ?></span></div>
                    </li>
                </ul>
                
                <ul class="collection with-header z-depth-1">
                    <li class="collection-header">
                        <h5>Saldo Cartera Afectada</h5></li>
                    <li class="collection-item">
                        <div>Saldo<span class="secondary-content"><?php echo number_format($saldoCarteraAfecta[0]['0'], 2, ".", ","); ?></span></div>
                    </li>
                </ul>

            </div>
    </div>
</div>


<script>

    $(document).ready(function(){
        
        $('.collapsible').collapsible();
        $('ul.tabs').tabs();
        $('#tabactivetab').trigger('click');
        $('select').material_select();
        $('#selectMesesMetaCumplimiento').change(function(){
            selectMesesMetaCumplimiento($(this).val());
        });

        // Select de meses
        var date = new Date();
        var month = date.getMonth();
        
        $('#selectMesesMetaCumplimiento').val(month+1);
        selectMesesMetaCumplimiento(month+1);
        $('#loadingcontainer').hide();

    });

    function selectMesesMetaCumplimiento(month){

        $('.containerDatosMetaCumplimiento').fadeOut(200, function(){

            $('#loadingcontainer').fadeIn(200);

            $.ajax({
                type: 'POST',
                url: '../php/gerencia/obtener_metas_cumplimiento.php',
                data: {
                    mes: month
                },
                success: function(data){
                    
                    var result = JSON.parse(data);
                    console.log(result);

                    // Creditos
                    $('#metaCreditosElement').text(numeral(result.Creditos_Mes).format('0,0'));
                    $('#metaCreditosEjecutadoElement').text(numeral(result.Creditos_Mensual).format('0,0'));
                    $('#metaPorcentajeElement').text(numeral(((result.Creditos_Mensual)/(result.Creditos_Mes))*100).format('0.00')+'%');

                    // Ejecutado
                    $('#ejecutadosElement').text('L. '+numeral(result.Monto_Mes).format('0,0.00'));
                    $('#ejecutadoEjecutadoElement').text('L. '+numeral(result.Monto_Mensual).format('0,0.00'));
                    $('#ejecutadoPorcentajeElement').text(numeral(((result.Monto_Mensual)/(result.Monto_Mes))*100).format('0.00')+'%');

                    $('#loadingcontainer').fadeOut(200, function(){
                        $('.containerDatosMetaCumplimiento').fadeIn(200);
                    });

                },
                error: function(){
                    alert('error');
                }
            });

        });
        

    }

</script>