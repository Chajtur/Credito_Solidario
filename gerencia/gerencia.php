<?php 
require '../php/PHPExcel.php';
require '../php/conection.php';

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
	(select sum(saldo_capital) from prestamo where (usuario_digitador not in ("Tercerizado") or usuario_digitador is null) and estado_credito = "Desembolsado") AS saldo_capital_total,
	(select sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) from prestamo where (usuario_digitador not in ("Tercerizado") or usuario_digitador is null) and estado_credito = "Desembolsado") AS capital_mora_total,
	(select format(((sum(if(Estado_Credito = "Desembolsado",if(capital_mora < 0, 0, capital_mora), 0)) / sum(Monto_Desembolsado)) * 100),4) from prestamo where (usuario_digitador not in ("Tercerizado") or usuario_digitador is null)) as porcentaje_mora
FROM
	prestamo');
$sql->execute();
$general = $sql->fetchAll();



$sql = $conn->prepare('select day(max(fecha_desembolso)) as dia from prestamo');
$sql->execute();
$dia = $sql->fetchAll();


/*cartera oficial*/
$sql = $conn->prepare('
    select count(*) as creditos, sum(monto_desembolsado) as desembolsado, (sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0))/sum(saldo_capital))*100 as porcentajeMora, sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) as mora
    from prestamo 
    where (usuario_digitador  <> "Tercerizado" or usuario_digitador is null) and Estado_Credito = "Desembolsado"
');
$sql->execute();
$carteraOficial = $sql->fetchAll();

/*query para metaa mensual y anual*/
$sql = $conn->prepare('select sum(if(a.mes = month(CURRENT_DATE), a.creditos, 0)) as Creditos_Mes, sum(if(a.mes = month(CURRENT_DATE), a.monto, 0)) as Monto_Mes, sum(a.creditos) 
    as Creditos_Anual, sum(a.monto) as Monto_Anual 
    from metas_mes a
');
$sql->execute();
$metas = $sql->fetchAll();

/*query para ejecutado mensual y anual*/
$sql = $conn->prepare('select sum(if(month(Fecha_Desembolso) = month(current_date) and year(fecha_desembolso) = year(current_date),1,0)) as Creditos_Mes, sum(if(month(Fecha_Desembolso) = month(current_date) and year(fecha_desembolso) = year(current_date),monto_desembolsado,0)) as Monto_Mes, count(numero_prestamo) as Creditos_Anual, sum(monto_desembolsado) as Monto_Anual from prestamo where year(fecha_desembolso) = year(current_date)
');
$sql->execute();
$ejecutados = $sql->fetchAll();

/*query para mora por departamento*/
$sql = $conn->prepare('select departamento,
format(if((sum(capital_mora)/sum(saldo_capital)) is null, 0, (sum(capital_mora)/sum(saldo_capital))) * 100, 2)
from prestamo where Estado_Credito = "Desembolsado" and departamento is not null and usuario_digitador <> "Tercerizado"
group by Departamento');
$sql->execute();
$moraDepartamentos = $sql->fetchAll();

$headersMoraDepartamentoCount = array();
$porcentajeMoraDepartamentoCount = array();
for($i=0; $i< count($moraDepartamentos); $i++){
    $headersMoraDepartamentoCount[$i] = $moraDepartamentos[$i]["0"];
    $porcentajeMoraDepartamentoCount[$i] = $moraDepartamentos[$i]["1"];
}

/*query para MONTO mora por departamento*/
$sql = $conn->prepare('select departamento, if((sum(capital_mora)) is null, 0, (sum(capital_mora)))
from prestamo 
where Estado_Credito = "Desembolsado" and usuario_digitador <> "Tercerizado" group by Departamento');
$sql->execute();
$montoMoraDepartamentos = $sql->fetchAll();

//var_dump($montoMoraDepartamentos);

$headersMontoMoraDepartamentoCount = array();
$montoMoraDepartamentoCount = array();
for($i=0; $i< count($montoMoraDepartamentos); $i++){
    $headersMontoMoraDepartamentoCount[$i] = $montoMoraDepartamentos[$i]["0"];
    $montoMoraDepartamentoCount[$i] = $montoMoraDepartamentos[$i]["1"];
    
}

/**
 * Query para stacked bars chart de desembolsado comparado con recuperado
 */

$stat_stacked = $conn->prepare('select departamento, 
sum(Monto_Desembolsado) - sum(if(estado_credito = "Desembolsado", saldo_capital, 0)) as Recuperado, 
sum(Monto_Desembolsado) - (sum(Monto_Desembolsado) - sum(if(estado_credito = "Desembolsado", saldo_capital, 0))) as Monto from prestamo group by departamento
');
$stat_stacked->execute();
$result_Stacked = $stat_stacked->fetchAll(PDO::FETCH_ASSOC);

$monto_stacked = array();
$recuperado_stacked = array();
$labels_stacked = array();
foreach($result_Stacked as $row){
    $monto_stacked[] = $row['Monto'];
    $recuperado_stacked[] = $row['Recuperado'];
    $labels_stacked[] = $row['departamento'];
}

/*pulperías*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado) 
    from prestamo 
    where programa = "P11" 
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$pulperias = $sql->fetchAll();

$contadorCreditosPulpe = 0;
$contadorDesembolsoPulpe = 0;
for($i=0; $i< count($pulperias); $i++){
    
    $contadorCreditosPulpe += $pulperias[$i]['1'];
    $contadorDesembolsoPulpe += $pulperias[$i]['2'];
}
/*taxis*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado) 
    from prestamo 
    where programa = "P08"
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$taxis = $sql->fetchAll();

$contadorCreditosTaxis = 0;
$contadorDesembolsoTaxis = 0;
for($i=0; $i< count($taxis); $i++){
    
    $contadorCreditosTaxis += $taxis[$i]['1'];
    $contadorDesembolsoTaxis += $taxis[$i]['2'];
    
}
/*salones*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado) 
    from prestamo 
    where programa = "P09"
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$belleza = $sql->fetchAll();

$jsonBelleza = json_encode($belleza);
$contadorCreditosSalon = 0;
$contadorDesembolsoSalon = 0;
for($i=0; $i< count($belleza); $i++){
    
    $contadorCreditosSalon += $belleza[$i]['1'];
    $contadorDesembolsoSalon += $belleza[$i]['2'];
    
}
/*baberías*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado) 
    from prestamo 
    where programa = "P10"
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$barbarias = $sql->fetchAll();

$contadorCreditosBarbe = 0;
$contadorDesembolsoBarbe = 0;
for($i=0; $i< count($barbarias); $i++){
    
    $contadorCreditosBarbe += $barbarias[$i]['1'];
    $contadorDesembolsoBarbe += $barbarias[$i]['2'];
}

$movilizadoresHeader = array("Pulperías", "Taxis", "Salones", "Barberías");
$movilizadoresContidad = array($contadorCreditosPulpe, $contadorCreditosTaxis, $contadorCreditosSalon, $contadorCreditosBarbe);

?>


    <div class="section">
        <div class="row">
            <div id="card-stats">
                <div class="row margin">
                    <div class="col s12 m8 l3 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat1" class="card">
                            <div class="card-content  teal accent-4 white-text">
                                <p class="card-stats-title"><i class="material-icons">show_chart</i> Meta Mensual</p>
                                <h4 id="cartera-activa" class="card-stats-number"><?php echo number_format(($ejecutados[0]['Creditos_Mes']/$metas[0]['Creditos_Mes']*100), 2, ".", ",") ?> %</h4>
                                <p class="card-stats-compare"><i class="material-icons">trending_flat</i> <?php echo number_format($ejecutados[0]['Creditos_Mes']) ?> <span class="green-text text-lighten-5">de</span> <?php echo number_format($metas[0]['Creditos_Mes']) ?>
                                </p>
                            </div>
                            <div class="card-action  teal darken-2">
                                <!-- <div id="clients-bar" class="center-align"></div>-->
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l3 wow fadeInDown" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat2" class="card">
                            <div class="card-content pink lighten-2 white-text">
                                <p class="card-stats-title"><i class="material-icons">swap_horiz</i> Meta Anual</p>
                                <h4 id="total-mora" class="card-stats-number"><?php echo number_format(($ejecutados[0]['Creditos_Anual']/$metas[0]['Creditos_Anual']*100), 2, ".", ",") ?> %</h4>
                                <p class="card-stats-compare"><i class="material-icons">trending_flat</i> <?php echo number_format($ejecutados[0]['Creditos_Anual']) ?> <span class="purple-text text-lighten-5">de</span> <?php echo number_format($metas[0]['Creditos_Anual']) ?>
                                </p>
                            </div>
                            <div class="card-action pink darken-2">
                                <!--<div id="sales-compositebar" class="center-align"></div>-->

                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l3 wow fadeInRight" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat3" class="card wow fadeInDown" data-wow-duration="1s">
                            <div class="card-content blue accent-2 white-text">
                                <p class="card-stats-title"><i class="material-icons">timeline</i> Mora Oficial</p>
                                <h4 id="porcentaje-mora" class="card-stats-number"><?php echo number_format($carteraOficial[0]['porcentajeMora'], 2, ".", ","); ?> %</h4>
                                <p class="card-stats-compare"><i class="material-icons">trending_up</i> L. <?php echo number_format($carteraOficial[0]['mora'], 2, ".", ",") ?>
                                </p>
                            </div>
                            <div class="card-action blue accent-4">
                                <!-- <div id="profit-tristate" class="center-align"></div>-->
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l3 ">
                        <div id="cardStat4" class="card">
                            <div class="card-content deep-purple white-text">
                                <p class="card-stats-title"><i class="material-icons">swap_vert</i> Créditos Oficial</p>
                                <h4 class="card-stats-number"><?php echo number_format($carteraOficial[0]['creditos']) ?></h4>
                                <p class="card-stats-compare"><i class="material-icons">timeline</i> L. <?php echo number_format($carteraOficial[0]['desembolsado'], 2, ".", ",") ?>
                                </p>
                            </div>
                            <div class="card-action  deep-purple darken-2">
                                <!--<div id="clients-bar" class="center-align"></div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col s12 hide-on-med-and-up">
                <div id="card-alert" class="card blue">
                      <div class="card-content white-text">
                       <div class="row center">
                           <div class="col s6">
                               <p>TOTAL DE CRÉDITOS DESEMBOLSADO:  <span style="font-size:18px"><?php echo number_format($general[0]['cantidad_total']) ; ?> </span></p>
                           </div>
                           <div class="headerDivider"></div>
                           <div class="col s6">
                               <p>TOTAL MONTO DESEMBOLSADO:  <span style="font-size:18px"> L. <?php echo number_format($general[0]['monto_desembolsado'], 2, ".", ",") ; ?></span></p>
                           </div>
                       </div>
                      </div>
                      <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                </div>
            </div>
            <div class="col s12 l6 hide-on-small-only">
                <div id="card-alert" class="card blue">
                      <div class="card-content white-text">
                        <p>TOTAL DE CRÉDITOS DESEMBOLSADO:  <span style="font-size:18px"><?php echo number_format($general[0]['cantidad_total']) ; ?> </span></p>
                      </div>
                      <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                </div>
            </div>
            <div class="col s12 l6 hide-on-small-only">
                <div id="card-alert" class="card blue">
                      <div class="card-content white-text">
                           <p>TOTAL MONTO DESEMBOLSADO:  <span style="font-size:18px"> L. <?php echo number_format($general[0]['monto_desembolsado'], 2, ".", ",") ; ?></span></p>
                      </div>
                      <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                </div>
            </div>
        </div>
        
        <div class="row">
           
            <div style="display: none;" class="col s12 m12 l8 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="card">
                    <div class="card-content">
                       <!--el siguiente codigo comentado es para agregar boton de más acciones a las cartas en la esquina superior derecha-->
                        <!--<a class="waves-effect waves-indigo right dropdownPie" data-activates='dropdownPie'>
                            <i class="material-icons grey500">more_vert</i>
                        </a>--> 
                        <span class="card-title">Mora Por Departamento</span>
                        <br>
                    </div>
                    <div>
                        <canvas class="hide-on-small-only" id="myChart" width="224" height="95"></canvas>
                        <canvas class="hide-on-med-and-up" id="myChartmovil" width="244" height="280"></canvas>
                    </div>
                    <!--Card Reveal for the first pie chart-->
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">Card Title
                                            <i class="material-icons right">close</i>
                                        </span>
                        <div class="divider"></div>
                        <br>
                        <table class="bordered striped">
                            <thead>
                                <tr>
                                    <th data-field="id">Name</th>
                                    <th data-field="name">Item Name</th>
                                    <th data-field="price">Item Price</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Alvin</td>
                                    <td>Eclair</td>
                                    <td>$0.87</td>
                                </tr>
                                <tr>
                                    <td>Alan</td>
                                    <td>Jellybean</td>
                                    <td>$3.76</td>
                                </tr>
                                <tr>
                                    <td>Jonathan</td>
                                    <td>Lollipop</td>
                                    <td>$7.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div style="display: none;" class="col s12 m12 l4 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="card">
                    <div class="card-content">
                        <a class="waves-effect waves-indigo right dropdownPolar" data-activates='dropdownPolar'>
                            <i class="material-icons grey500">more_vert</i>
                        </a>
                        <span class="card-title">Estadistica de Creditos</span>
                        <!--<p class="grey-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                <div class="divider"></div>-->
                        <br>
                        <div id="">
                            <canvas id="myChart4" width="100" height="100"></canvas>
                        </div>
                    </div>

                    <!--Card Reveal for the first pie chart-->
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">Card Title
                                            <i class="material-icons right">close</i>
                                        </span>
                        <div class="divider"></div>
                        <br>
                        <table class="bordered striped">
                            <thead>
                                <tr>
                                    <th data-field="id">Name</th>
                                    <th data-field="name">Item Name</th>
                                    <th data-field="price">Item Price</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Alvin</td>
                                    <td>Eclair</td>
                                    <td>$0.87</td>
                                </tr>
                                <tr>
                                    <td>Alan</td>
                                    <td>Jellybean</td>
                                    <td>$3.76</td>
                                </tr>
                                <tr>
                                    <td>Jonathan</td>
                                    <td>Lollipop</td>
                                    <td>$7.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col s12 m12 l0 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="card">
                    <div class="card-content">
                       <!--el siguiente codigo es para agregar boton de menu a la carta-->
                        <!--<a class="waves-effect waves-indigo right dropdownDona" data-activates='dropdownDona'>
                            <i class="material-icons grey500">more_vert</i>
                        </a>-->
                        <span class="card-title">Estadística de Créditos Movilizadores del Comercio</span>
                        <div class="divider"></div>
                        <br>
                        <div id="">
                            <canvas id="myChart3" width="100" height="30"></canvas>
                        </div>
                    </div>

                    <!--Card Reveal for the first pie chart-->
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">Card Title
                                            <i class="material-icons right">close</i>
                                        </span>
                        <div class="divider"></div>
                        <br>
                        <table class="bordered striped">
                            <thead>
                                <tr>
                                    <th data-field="id">Name</th>
                                    <th data-field="name">Item Name</th>
                                    <th data-field="price">Item Price</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Alvin</td>
                                    <td>Eclair</td>
                                    <td>$0.87</td>
                                </tr>
                                <tr>
                                    <td>Alan</td>
                                    <td>Jellybean</td>
                                    <td>$3.76</td>
                                </tr>
                                <tr>
                                    <td>Jonathan</td>
                                    <td>Lollipop</td>
                                    <td>$7.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
        </div>
        
        <div class="row hide">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 l8">
                                <div id="work-collections" class="">
                                    <div class="row">
                                        <div class="col s12 m12 l12">
                                            <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                                            <ul id="projects-collection" class="collection">
                                                <li class="collection-item avatar">
                                                    <i class="material-icons circle light-blue ">list</i>
                                                    <span class="collection-header">Asesores</span>
                                                    <p>registrados en la App</p>
                                                    <!--el siguiente codigo comentado es para agregar la opcion de busqeuda o mas opciones a la lista-->
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
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">Departamento</p>
                                                        </div>
                                                        <div class="col s8 m3 l2">
                                                            <p class="collections-title">Créditos</p>
                                                        </div>
                                                        <div class="col s8 m3 l3">
                                                            <p class="collections-title">Desembolsado</p>
                                                        </div>
                                                        <div class="col s2 hide-on-small-only">
                                                            <p class="collections-title">Saldo</p>
                                                        </div>
                                                        <div class="col s2 hide-on-small-only">
                                                            <p class="collections-title">Capital Mora</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s3 hide-on-small-only light">
                                                            <p class="collections-content">Atlantida</p>
                                                        </div>
                                                        <div class="col s8 m3 l2 light">
                                                            <p class="collections-content">31</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only light">
                                                            <p class="collections-content">10,000</p>
                                                        </div>
                                                        <div class="col s2 hide-on-small-only light">
                                                            <p class="collections-content">45,000.00</p>
                                                        </div>
                                                        <div class="col s2 hide-on-small-only light">
                                                            <p class="collections-content">#######</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s3 hide-on-small-only light">
                                                            <p class="collections-content">Atlantida</p>
                                                        </div>
                                                        <div class="col s8 m3 l2 light">
                                                            <p class="collections-content">31</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only light">
                                                            <p class="collections-content">10,000</p>
                                                        </div>
                                                        <div class="col s2 hide-on-small-only light">
                                                            <p class="collections-content">45,000.00</p>
                                                        </div>
                                                        <div class="col s2 hide-on-small-only light">
                                                            <p class="collections-content">#######</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s3 hide-on-small-only light">
                                                            <p class="collections-content">Atlantida</p>
                                                        </div>
                                                        <div class="col s8 m3 l2 light">
                                                            <p class="collections-content">31</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only light">
                                                            <p class="collections-content">10,000</p>
                                                        </div>
                                                        <div class="col s2 hide-on-small-only light">
                                                            <p class="collections-content">45,000.00</p>
                                                        </div>
                                                        <div class="col s2 hide-on-small-only light">
                                                            <p class="collections-content">#######</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s3 hide-on-small-only light">
                                                            <p class="collections-content">Atlantida</p>
                                                        </div>
                                                        <div class="col s8 m3 l2 light">
                                                            <p class="collections-content">31</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only light">
                                                            <p class="collections-content">10,000</p>
                                                        </div>
                                                        <div class="col s2 hide-on-small-only light">
                                                            <p class="collections-content">45,000.00</p>
                                                        </div>
                                                        <div class="col s2 hide-on-small-only light">
                                                            <p class="collections-content">#######</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s3 hide-on-small-only light">
                                                            <p class="collections-content">Atlantida</p>
                                                        </div>
                                                        <div class="col s8 m3 l2 light">
                                                            <p class="collections-content">31</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only light">
                                                            <p class="collections-content">10,000</p>
                                                        </div>
                                                        <div class="col s2 hide-on-small-only light">
                                                            <p class="collections-content">45,000.00</p>
                                                        </div>
                                                        <div class="col s2 hide-on-small-only light">
                                                            <p class="collections-content">#######</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 l4">
                                <canvas id="myChartBar" width="100" height="110"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Dropdown Structure chart pie 1 -->
        <ul id='dropdownPie' class='dropdown-content'>
            <li><a class="waves-effect waves-indigo"><i class="material-icons left">refresh</i>Actualiza</a></li>
            <li class="divider"></li>
            <li><a class="waves-effect waves-indigo activator"><i class="material-icons left">view_list</i>Detalles</a></li>
        </ul>
        
        <!-- Dropdown Structure chart polar 1 -->
        <ul id='dropdownPolar' class='dropdown-content'>
            <li><a class="waves-effect waves-indigo"><i class="material-icons left">refresh</i>Actualizar</a></li>
            <li class="divider"></li>
            <li><a class="waves-effect waves-indigo activator"><i class="material-icons left">view_list</i>Detalles</a></li>
        </ul>
        
        <!-- Dropdown Structure chart dona 1 -->
        <ul id='dropdownDona' class='dropdown-content'>
            <li><a class="waves-effect waves-indigo"><i class="material-icons left">refresh</i>Actualizar</a></li>
            <li class="divider"></li>
            <li><a class="waves-effect waves-indigo activator"><i class="material-icons left">view_list</i>Detalles</a></li>
        </ul>
        
        <div class="divider"></div>
        
    </div>
    
    
    <!--grafico de monto de mora por departamento-->
    <div class="section">
        <!--<div class="row">
            <div id="infoAlertEmpty" class="col s12 l12">
                <div id="work-collapsible">
                    <div class="row">
                        <div class="col s12">
                            <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header active" style="border-bottom: 0px solid #ddd; */"><i class="material-icons">pie_chart</i>Montos de Mora por Departamentos</div>
                                    <div class="collapsible-body" style="border-bottom: 0px solid #ddd;">
                                        <canvas class="hide-on-small-only" id="montoMoraGraph" width="224" height="75"></canvas>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="row">
            <div id="infoAlertEmpty" class="col s12 l12">
                <div id="work-collapsible">
                    <div class="row">
                        <div class="col s12">
                            <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header active" style="border-bottom: 0px solid #ddd; */"><i class="material-icons">pie_chart</i>Comparación de Monto Desembolsado contra Recuperado</div>
                                    <div class="collapsible-body" style="border-bottom: 0px solid #ddd;">
                                        <canvas class="hide-on-small-only" id="montoMoraGraphNuevo" width="224" height="75"></canvas>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="infoAlertEmpty" class="col s12 l12">
                <div id="work-collapsible">
                    <div class="row">
                        <div class="col s12">
                            <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header active" style="border-bottom: 0px solid #ddd; */"><i class="material-icons">pie_chart</i>Porcentaje de Mora por Departamentos</div>
                                    <div class="collapsible-body" style="border-bottom: 0px solid #ddd;">
                                        <canvas class="hide-on-small-only" id="porcentajeMoraGraph" width="224" height="75"></canvas>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../js/plugins/numeral/numeral.js"></script>
    <script>
        $(document).ready(function () {
            
            /**
             * Función que cambia de color en base al porcentaje
             * Se le envía el porcentaje, el canal verde, el punto de cambio entre el verde y amarillo 
             * y el punto de cambio entre el amarillo y el rojo
             * Retorna el color rbg ya calculado
             **/

            var asignarFondoPorPorcentaje = function(p, chanel, toYellow, toRed){

                var brightness = p/2;
                var objColor = {};
                objColor.red = 0;
                objColor.green = chanel;
                objColor.blue = 50;
                if(p <= toYellow){
                    let auxnum = chanel*p/100*3;
                    objColor.red = auxnum;
                }else if(p <= toRed){
                    let auxnum = chanel*p/100;
                    objColor.red = chanel;
                    objColor.green -= auxnum;
                }else{
                    objColor.red = chanel;
                    let auxnum = chanel*p/100*2;
                    objColor.green -= auxnum;
                    objColor.blue -= brightness;
                }

                objColor.color = 'rgb('+ Math.round(objColor.red)+','+ Math.round(objColor.green)+','+ Math.round(objColor.blue)+')';
                return objColor.color;

            }

            $('.collapsible').collapsible();
            
            $('.dropdownPie').dropdown({
                inDuration: 300,
                outDuration: 225,
                constrainWidth: false, // Does not change width of dropdown to that of the activator
                hover: true, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: true, // Displays dropdown below the button
                alignment: 'right', // Displays dropdown with edge aligned to the left of button
                stopPropagation: true // Stops event propagation
                }
            );
            
            $('.dropdownPolar').dropdown({
                inDuration: 300,
                outDuration: 225,
                constrainWidth: false, // Does not change width of dropdown to that of the activator
                hover: true, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: true, // Displays dropdown below the button
                alignment: 'right', // Displays dropdown with edge aligned to the left of button
                stopPropagation: true // Stops event propagation
                }
            );
            
            $('.dropdownDona').dropdown({
                inDuration: 300,
                outDuration: 225,
                constrainWidth: false, // Does not change width of dropdown to that of the activator
                hover: true, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: true, // Displays dropdown below the button
                alignment: 'right', // Displays dropdown with edge aligned to the left of button
                stopPropagation: true // Stops event propagation
                }
            );
            
            $('.icon-collapse-search').click(function () {
                $('.search-expandida').toggleClass('expanded');
                $('.search-expandida').focus();
            });
            $('#breadcrum-title').text('Dashboard Gerencia');

            $('.collapsible').collapsible();
            $('.dropdown-chart').dropdown({

            });
            $('.tap-target').tapTarget('open');

            var ctx = document.getElementById("porcentajeMoraGraph"); //grafico pastel #1
            var ctxmovil = document.getElementById("myChartmovil"); //grafico pastel #1
            var ctx2 = document.getElementById("myChart2"); // grafico polar #2 NO APARECE, ESTA COMENTADO
            var ctx3 = document.getElementById("myChart3"); // graafico dona #3 
            var ctx4 = document.getElementById("myChart4").getContext("2d"); // grafico polar #4 ES EL TERCERO QUE APARECE
            var ctxBar = document.getElementById("myChartBar");

/////////////////////////////////////////////////////////// DATOS DE GRAFICOS ///////////////////////////////////////////////////////////////////////

            // DATOS DEL GRAFICO PORCENTAJE DE MORA POR DEPARTAMENTOS

            // Creando el arreglo de colores en base al porcentaje
            var auxArrayDataPorcentajeMora = <?php echo json_encode($porcentajeMoraDepartamentoCount); ?>;
            var colorArray = [];
            $.each(auxArrayDataPorcentajeMora, function(index, value){
                colorArray.push(asignarFondoPorPorcentaje(value, 250, 15, 25));
            });
            // Creando el arreglo de colores en base al porcentaje

            var data = { // Datos para el grafico de mora por departamento
                labels: <?php echo json_encode($headersMoraDepartamentoCount);?>,
                datasets: [
                    {
                        label: "Porcentaje de Mora por Departamento",
                        data: <?php echo json_encode($porcentajeMoraDepartamentoCount); ?>,
                        backgroundColor: colorArray
                        // hoverBackgroundColor: [
                        //     "#01579B",
                        //     "#0277BD",
                        //     "#0288D1",
                        //     "#039BE5",
                        //     "#03A9F4",
                        //     "#29B6F6",
                        //     "#4FC3F7",
                        //     "#81D4FA",
                        //     "#B3E5FC",
                        //     "#80DEEA",
                        //     "#4DD0E1",
                        //     "#26C6DA",
                        //     "#00BCD4",
                        //     "#00ACC1",
                        //     "#0097A7",
                        //     "#00838F",
                        //     "#3D5AFE",
                        //     "#304FFE"
                        // ]
                }]
            };
                          
            var datamovil = { // Datos para el grafico de mora por departamento (movil -> no se en que momento se activa)
                labels: <?php echo json_encode($headersMoraDepartamentoCount);?>,
                datasets: [
                    {
                        label: "Porcentaje de Mora por Departamento",
                        data: <?php echo json_encode($porcentajeMoraDepartamentoCount); ?>,
                        backgroundColor: [
                            "#01579B",
                            "#0277BD",
                            "#0288D1",
                            "#039BE5",
                            "#03A9F4",
                            "#29B6F6",
                            "#4FC3F7",
                            "#81D4FA",
                            "#B3E5FC",
                            "#80DEEA",
                            "#4DD0E1",
                            "#26C6DA",
                            "#00BCD4",
                            "#00ACC1",
                            "#0097A7",
                            "#00838F",
                            "#3D5AFE",
                            "#304FFE"
                        ],
                        hoverBackgroundColor: [
                            "#01579B",
                            "#0277BD",
                            "#0288D1",
                            "#039BE5",
                            "#03A9F4",
                            "#29B6F6",
                            "#4FC3F7",
                            "#81D4FA",
                            "#B3E5FC",
                            "#80DEEA",
                            "#4DD0E1",
                            "#26C6DA",
                            "#00BCD4",
                            "#00ACC1",
                            "#0097A7",
                            "#00838F",
                            "#3D5AFE",
                            "#304FFE"
                        ]
                }]
            };

            //DATOS DEL GRAFICO DONA #3
            var data3 = { // Datos para el gráfico de movilizadores
                labels: <?php echo json_encode($movilizadoresHeader);?>,
                datasets: [
                    {
                        data: <?php echo json_encode($movilizadoresContidad);?>,
                        backgroundColor: [
                            "#4CAF50",
                            "#FFC107",
                            "#E91E63",
                            "#2196F3"
                        ],
                        hoverBackgroundColor: [
                            "#388E3C",
                            "#FFA000",
                            "#C2185B",
                            "#1976D2"
                        ]
                }]
            };

            var dataBar = { // Datos para el gráfico de barras por meses
                labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo"],
                datasets: [
                    {
                        label: "primeras",
                        backgroundColor: [
                            '#1C7EBB',
                            '#1C7EBB',
                            '#1C7EBB',
                            '#1C7EBB',
                            '#1C7EBB'
                        ],
                        borderColor: [
                            '#1C7EBB',
                            '#1C7EBB',
                            '#1C7EBB',
                            '#1C7EBB',
                            '#1C7EBB'
                        ],
                        borderWidth: 1,
                        data: [65, 59, 80, 81, 67],
                    },
                    {
                        label: "segundas",
                        backgroundColor: [
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC'
                        ],
                        borderColor: [
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC'
                        ],
                        borderWidth: 0,
                        data: [45, 59, 20, 51, 87],
                    },
                          {
                        label: "segundas",
                        backgroundColor: [
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC'
                        ],
                        borderColor: [
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC'
                        ],
                        borderWidth: 0,
                        data: [25, 49, 30, 21, 37],
                    },{
                        label: "segundas",
                        backgroundColor: [
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC'
                        ],
                        borderColor: [
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC',
                            '#2EC1CC'
                        ],
                        borderWidth: 0,
                        data: [85, 99, 70, 51, 37],
                    }
                ]
            };

///////////////////////////////////////////////////////////// CREACIÓN DE GRAFICOS ////////////////////////////////////////////////////////////////////

            //CREACION DEL GRAFICO PORCENTAJE DE MORA POR DEPARTAMENTO
            var myDoughnutChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            fontColor: '#1C7EBB'
                        }
                    },
                animation: {
                    duration: 0,
                    onComplete: function () {
                        // render the value of the chart above the bar
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.fillStyle = "#000";
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        this.data.datasets.forEach(function (dataset) {
                            for (var i = 0; i < dataset.data.length; i++) {
                                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                ctx.fillText(dataset.data[i]+'%', model.x, model.y + 15);
                            }
                        });
                    }},
                    hover: {
                        // Overrides the global setting
                        mode: 'index',
                        responsive: true,
                        animationDuration: 400
                    },
                    tooltips: {
    	               callbacks: {
      	                 label: function(tooltipItem) {
        	                   return tooltipItem.yLabel + '%';
                            }
                        }
                    },
                    scales: {
                        xAxes: [{
                            stacked: true
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
        
            //CREACION DEL GRAFICO barras #1
            var opt = {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            fontColor: '#1C7EBB'
                        }
                    },
                    animation: {
                    duration: 0,
                    onComplete: function () {
                        // render the value of the chart above the bar
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.fillStyle = "#000";
                        ctx.textAlign = 'right';
                        ctx.textBaseline = 'bottom';
                        this.data.datasets.forEach(function (dataset) {
                            for (var i = 0; i < dataset.data.length; i++) {
                                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                ctx.fillText(dataset.data[i]+'%', model.x + 25, model.y + 8);
                                
                                if(parseInt(dataset.data[i]) > 50){
                                    dataset.backgroundColor[i] = "#f44336";
                                    
                                } else if(parseInt(dataset.data[i]) > 9){
                                     dataset.backgroundColor[i] = "#ffc107";
                                     
                                } else {
                                    dataset.backgroundColor[i] = "#4caf50";
                                    
                                }
                            }
                        });
                    }},
                    hover: {
                        // Overrides the global setting
                        mode: 'index',
                        responsive: true,
                        animationDuration: 400
                    },
                    tooltips: {
    	               callbacks: {
      	                 label: function(tooltipItem) {
        	                   return tooltipItem.yLabel + '%';
                            }
                        }
                    },
                    scales: {
                        xAxes: [{
                            stacked: true
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            var barraMovil = new Chart(ctxmovil, {
                type: 'horizontalBar',
                data: datamovil,
                showTooltips: false,
                options:  opt
            });

            //CREACION DEL GRAFICO DONA #3
            var grafico3 = new Chart(ctx3, {
                type: 'horizontalBar',
                data: data3,
                maintainAspectRatio: false,
                options: {
                    responsive: true,
                    scaleStartValue: 0,
                    animation: {
                        animateScale: true
                    },
                    title: {
                        display: true,
                        text: 'Movilizadores de la Ecónomia'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontColor: '#1C7EBB'
                        }
                    },
                    hover: {
                        // Overrides the global setting
                        mode: 'index',
                        responsive: true,
                        animationDuration: 400
                    },
                    tooltips: {
                        enabled: true,
                        intersect: true
                    },
                    pieceLabel: {
                        mode: 'value',
                        precision: 0,
                        fontSize: 12,
                        fontColor: '#fff'
                    }
                }
            });
            
            
            new Chart(ctxBar, {
                type: "bar",
                data: dataBar,
                options: {
                    barValueSpacing: 20,
                    scales: {
                        yAxes: [{
                            ticks: {
                            min: 0,
                            }
                        }]
                    }
                }
            });
        
        
        ///////////////////////////////////////// GRAFICO DE MONTO DE MORA POR DEPARTAMENTO ////////////////////////////////////////
        var montoMoractx = document.getElementById("montoMoraGraph");
        var dataMonto = { // Datos para el grafico de monto de mora por departamento
            labels:<?php echo json_encode($headersMontoMoraDepartamentoCount); ?> ,
            datasets: 
            [
                {
                    label: "Monto de mora de por deparamento",
                    data: <?php echo json_encode($montoMoraDepartamentoCount);?>,
                    backgroundColor: [
                        "#01579B",
                        "#0277BD",
                        "#0288D1",
                        "#039BE5",
                        "#03A9F4",
                        "#29B6F6",
                        "#4FC3F7",
                        "#81D4FA",
                        "#B3E5FC",
                        "#80DEEA",
                        "#4DD0E1",
                        "#26C6DA",
                        "#00BCD4",
                        "#00ACC1",
                        "#0097A7",
                        "#00838F",
                        "#3D5AFE",
                        "#3D5AFE",
                        "#304FFE"
                    ],
                    hoverBackgroundColor: [
                        "#01579B",
                        "#0277BD",
                        "#0288D1",
                        "#039BE5",
                        "#03A9F4",
                        "#29B6F6",
                        "#4FC3F7",
                        "#81D4FA",
                        "#B3E5FC",
                        "#80DEEA",
                        "#4DD0E1",
                        "#26C6DA",
                        "#00BCD4",
                        "#00ACC1",
                        "#0097A7",
                        "#00838F",
                        "#3D5AFE",
                        "#3D5AFE",
                        "#304FFE"
                    ]
                }
            ]
        };

        //CREACION DEL GRAFICO DE MONTO DE MORA POR DEPARTAMENTO
        // var montoMoraGraph = new Chart(montoMoractx, {
        //     type: 'bar',
        //     data: dataMonto,
        //     options: {
        //         legend: {
        //             display: true,
        //             position: 'top',
        //             labels: {
        //                 fontColor: '#1C7EBB'
        //             }
        //         },
        //         animation: {
        //             duration: 0,
        //             onComplete: function() {
        //                 // render the value of the chart above the bar
        //                 var ctx = this.chart.ctx;
        //                 ctx.font = Chart.helpers.fontString(9, 'normal', Chart.defaults.global.defaultFontFamily);
        //                 ctx.fillStyle = "#000";
        //                 ctx.textAlign = 'center';
        //                 ctx.textBaseline = 'bottom';
        //                 ctx.text
        //                 this.data.datasets.forEach(function(dataset) {
        //                     for (var i = 0; i < dataset.data.length; i++) {
        //                         var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
        //                         ctx.fillText(numeral(dataset.data[i]).format('$0,0.00'), model.x + 2, model.y - 10);
                                
        //                         if(parseInt(dataset.data[i]) > 1000000){
        //                             dataset.backgroundColor[i] = "#f44336";
                                    
        //                         } else if(parseInt(dataset.data[i]) > 500000){
        //                              dataset.backgroundColor[i] = "#ffc107";
                                     
        //                         } else {
        //                             dataset.backgroundColor[i] = "#4caf50";
                                    
        //                         }
        //                     }
        //                 });
        //             }
        //         },
        //         hover: {
        //             // Overrides the global setting
        //             mode: 'index',
        //             responsive: true,
        //             animationDuration: 400
        //         },
        //         tooltips: {
        //             callbacks: {
        //                 label: function(tooltipItem) {
        //                     return tooltipItem.yLabel + '%';
        //                 }
        //             }
        //         },
        //         scales: {
        //             yAxes: [{
        //                 ticks: {
        //                     min: 0,
        //                 }
        //             }]
        //         }
        //     }
        // });

        var montoMoractxnuevo = document.getElementById("montoMoraGraphNuevo");
        console.log(dataMonto);
        var configMoraGraph = {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels_stacked);?>,
                datasets: [{
                    label: "Recuperado",
                    data: <?php echo json_encode($recuperado_stacked);?>,
                    backgroundColor: '#4CAF50'
                }, {
                    label: "Saldo",
                    data: <?php echo json_encode($monto_stacked);?>,
                    backgroundColor: '#C8E6C9'
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        }
        console.log(configMoraGraph);
        var montoMoraGraphnuevo = new Chart(montoMoractxnuevo, configMoraGraph);
        
    });

    </script>