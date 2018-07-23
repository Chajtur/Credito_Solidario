<?php

require '../php/conection.php';

/*salones*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado), sum(saldo_capital), sum(capital_mora)
    from prestamo 
    where Fecha_Desembolso >= "2017-3-3" and programa = "P09" 
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$belleza = $sql->fetchAll();

$contadorCreditosSalon = 0;
$contadorDesembolsoSalon = 0;
$contadorSaldoCapital = 0;
$contadorCapitalMora = 0;
for($i=0; $i< count($belleza); $i++){
    
    $contadorCreditosSalon += $belleza[$i]['1'];
    $contadorDesembolsoSalon += $belleza[$i]['2'];
    $contadorSaldoCapital += $belleza[$i]['3'];
    $contadorCapitalMora += $belleza[$i]['4'];
}

/*taxis*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado), sum(saldo_capital), sum(capital_mora)
    from prestamo 
    where Fecha_Desembolso >= "2017-3-3" and programa = "P08" 
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$taxis = $sql->fetchAll();



$contadorCreditosTaxis = 0;
$contadorDesembolsoTaxis = 0;
$contadorSaldoCapitalTaxis = 0;
$contadorCappitalMoraTaxis = 0;
for($i=0; $i< count($taxis); $i++){
    
    $contadorCreditosTaxis += $taxis[$i]['1'];
    $contadorDesembolsoTaxis += $taxis[$i]['2'];
    
    $contadorSaldoCapitalTaxis += $taxis[$i]['3'];
    $contadorCappitalMoraTaxis += $taxis[$i]['4'];
}


/*baberías*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado), sum(saldo_capital), sum(capital_mora)
    from prestamo 
    where Fecha_Desembolso >= "2017-3-3" and programa = "P10" 
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$barbarias = $sql->fetchAll();


$contadorCreditosBarbe = 0;
$contadorDesembolsoBarbe = 0;
$contadorSaldoCapitalBarbe = 0;
$contadorCapitalMoraBarbe = 0;
for($i=0; $i< count($barbarias); $i++){
    
    $contadorCreditosBarbe += $barbarias[$i]['1'];
    $contadorDesembolsoBarbe += $barbarias[$i]['2'];
    
    $contadorSaldoCapitalBarbe += $barbarias[$i]['3'];
    $contadorCapitalMoraBarbe += $barbarias[$i]['4'];
}


/*pulperías*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado), sum(saldo_capital), sum(capital_mora)
    from prestamo 
    where Fecha_Desembolso >= "2017-3-3" and programa = "P11" 
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$pulperias = $sql->fetchAll();

$contadorCreditosPulpe = 0;
$contadorDesembolsoPulpe = 0;
$contadorSaldoCapitalPulpe = 0;
$contadorCapitalMoraPulpe = 0;
for($i=0; $i< count($pulperias); $i++){
    
    $contadorCreditosPulpe += $pulperias[$i]['1'];
    $contadorDesembolsoPulpe += $pulperias[$i]['2'];
    
    $contadorSaldoCapitalPulpe += $pulperias[$i]['3'];
    $contadorCapitalMoraPulpe += $pulperias[$i]['4'];
}

?>

<script>
$(document).ready(function(){
    $('ul.tabs').tabs();
  });

</script>

    <div class="section">
        <!--card stats-->
        <div class="row">
            <div id="card-stats">
                <div class="row margin">
                    <div class="col s12 m8 l3 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat1" class="card">
                            <div class="card-content  pink white-text">
                                <p class="card-stats-title"><i class="material-icons">spa</i> Salones</p>
                                <h4 id="cartera-activa" class="card-stats-number"><?php echo $contadorCreditosSalon; ?></h4>
                                <p class="card-stats-compare"><i class="material-icons">local_atm</i> L.
                                    <?php echo number_format($contadorDesembolsoSalon, 2, ".", ",") ?>
                                </p>
                            </div>
                            <div class="card-action pink darken-2 center">
                                <!-- <div id="clients-bar" class="center-align"></div>-->
                                <span class="white-text"><?php echo number_format(($contadorCapitalMora/$contadorSaldoCapital)*100) ?>% de mora</span>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l3 wow fadeInDown" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat2" class="card">
                            <div class="card-content amber white-text">
                                <p class="card-stats-title"><i class="material-icons">local_taxi</i> Taxis</p>
                                <h4 id="total-mora" class="card-stats-number"><?php echo $contadorCreditosTaxis ?></h4>
                                <p class="card-stats-compare"><i class="material-icons">local_atm</i> L.
                                    <?php echo number_format($contadorDesembolsoTaxis, 2, ".", ",") ?>
                                </p>
                            </div>
                            <div class="card-action amber darken-2 center">
                                <!--<div id="sales-compositebar" class="center-align"></div>-->
                                <span class="white-text"><?php echo number_format(($contadorCappitalMoraTaxis/$contadorSaldoCapitalTaxis)*100) ?>% de mora</span>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l3 wow fadeInRight" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat3" class="card wow fadeInDown" data-wow-duration="1s">
                            <div class="card-content blue white-text">
                                <p class="card-stats-title"><i class="material-icons">content_cut</i> Barberías</p>
                                <h4 id="porcentaje-mora" class="card-stats-number"><?php echo $contadorCreditosBarbe ?></h4>
                                <p class="card-stats-compare"><i class="material-icons">local_atm</i> L.
                                    <?php echo number_format($contadorDesembolsoBarbe, 2, ".", ",") ?>
                                </p>
                            </div>
                            <div class="card-action blue darken-2 center">
                                <!-- <div id="profit-tristate" class="center-align"></div>-->
                                <span class="white-text"><?php echo number_format(($contadorCapitalMoraBarbe/$contadorSaldoCapitalBarbe)*100) ?>% de mora</span>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l3 ">
                        <div id="cardStat4" class="card">
                            <div class="card-content green white-text">
                                <p class="card-stats-title"><i class="material-icons">store</i> Pulperías</p>
                                <h4 class="card-stats-number"><?php echo $contadorCreditosPulpe ?></h4>
                                <p class="card-stats-compare"><i class="material-icons">local_atm</i> L.
                                    <?php echo number_format($contadorDesembolsoPulpe, 2, ".", ",") ?>
                                </p>
                            </div>
                            <div class="card-action  green darken-2 center">
                                <!--<div id="clients-bar" class="center-align"></div>-->
                                <span class="white-text"><?php echo number_format(($contadorCapitalMoraPulpe/$contadorSaldoCapitalPulpe)*100) ?>% de mora</span>
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
                               <p>TOTAL DE CRÉDITOS DESEMBOLSADO:  <span style="font-size:18px"><?php echo number_format($contadorCreditosSalon+$contadorCreditosTaxis+$contadorCreditosBarbe+$contadorCreditosPulpe) ; ?> </span></p>
                           </div>
                           <div class="headerDivider"></div>
                           <div class="col s6">
                               <p>TOTAL MONTO DESEMBOLSADO:  <span style="font-size:18px"> L. <?php echo number_format($contadorDesembolsoSalon+$contadorDesembolsoTaxis+$contadorDesembolsoBarbe+$contadorDesembolsoPulpe, 2, ".", ",") ; ?></span></p>
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
                        <p>TOTAL DE CRÉDITOS DESEMBOLSADO:  <span style="font-size:18px"><?php echo number_format($contadorCreditosSalon+$contadorCreditosTaxis+$contadorCreditosBarbe+$contadorCreditosPulpe) ; ?> </span></p>
                      </div>
                      <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                </div>
            </div>
            <div class="col s12 l6 hide-on-small-only">
                <div id="card-alert" class="card blue">
                      <div class="card-content white-text">
                           <p>TOTAL MONTO DESEMBOLSADO:  <span style="font-size:18px"> L. <?php echo number_format($contadorDesembolsoSalon+$contadorDesembolsoTaxis+$contadorDesembolsoBarbe+$contadorDesembolsoPulpe, 2, ".", ",") ; ?></span></p>
                      </div>
                      <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <ul class="tabs tabs-fixed-width z-depth-1">
                    <li class="tab col s3"><a class="active" href="#test1">salones</a></li>
                    <li class="tab col s3"><a href="#test2">Taxis</a></li>
                    <li class="tab col s3"><a href="#test3">Barberías</a></li>
                    <li class="tab col s3"><a href="#test4">Pulperías</a></li>
                    <div class="indicator" style="right: 871px; left: 0px;"></div>
                </ul>
            </div>
        </div>
        
        <div id="test1" class="col s12">
            <div id="work-collections" class="">
                <div class="row">
                    <div class="col s12 m12 l12" id="todos-los-salones">
                        <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                        <ul id="projects-collection" class="collection z-depth-1">
                            <li class="collection-item avatar">
                                <i class="material-icons circle pink ">spa</i>
                                <span class="collection-header">Salones</span>
                                <p>información acerca movilizador salones</p>
                                <div class="secondary-content actions">
                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                        <i class="material-icons center-align">search</i>
                                    </a>
                                </div>
                                <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                            </li>
                            <li class="collection-item">
                                <div class="row">
                                    <div class="col s6 m4 l2">
                                        <p class="collections-title">Agencia</p>
                                    </div>
                                    <div class="col s6 m2 l3 center-align">
                                        <p class="collections-title">Créditos desembolsados</p>
                                    </div>
                                    <div class="col s6 m2 l3 center-align">
                                        <p class="collections-title">Créditos desembolsados</p>
                                    </div>
                                    <div class="col s6 m2 l2 center-align">
                                        <p class="collections-title">Saldo Capital</p>
                                    </div>
                                    <div class="col s6 m2 l2 center-align">
                                        <p class="collections-title">Capital Mora</p>
                                    </div>
                                </div>
                            </li>
                            <div class="list">
                                <?php $i=0;?>
                                    <?php if(count($belleza) > 0):?>

                                        <?php foreach($belleza as $salones):?>
                                            <?php $i++;?>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6 m4 l2">
                                                            <p class="collections-content nombreAgencia"><?php echo $salones['0'] == null ? 'Por asignar' : $salones['0']; ?></p>
                                                        </div>
                                                        <div class="col s6 m2 l3">
                                                            <p class="collections-content crediDesembolsados center-align"><?php echo $salones['1']; ?></p>
                                                        </div>
                                                        <div class="col s6 m2 l3 hide-on-small-only">
                                                            <p class="collections-content montoDesembolsado center-align">
                                                                L. <?php echo number_format($salones['2']); ?>
                                                            </p>
                                                        </div>
                                                        <div class="col s6 m2 l2 hide-on-small-only">
                                                            <p class="collections-content montoDesembolsado center-align">
                                                                L. <?php echo number_format($salones['3'], 2, ".", ","); ?>
                                                            </p>
                                                        </div>
                                                        <div class="col s6 m2 l2 hide-on-small-only">
                                                            <p class="collections-content montoDesembolsado center-align">
                                                                L. <?php echo number_format($salones['4'], 2, ".", ","); ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>

                                                <?php endforeach;?>
                                                    <?php else:?>
                                                        <li class="center">
                                                            <h5>No hay ningún beneficiario</h5></li>
                                                        <?php endif;?>
                            </div>

                            <li class="collection-item">
                                <ul id="pag-control" class="pag pagination">
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="test2" class="col s12">
             <div id="work-collections" class="">
                <div class="row">
                    <div class="col s12 m12 l12" id="todos-los-taxis">
                        <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                        <ul id="projects-collection" class="collection z-depth-1">
                            <li class="collection-item avatar">
                                <i class="material-icons circle amber ">local_taxi</i>
                                <span class="collection-header">Taxis</span>
                                <p>información acerca movilizador taxi</p>
                                <div class="secondary-content actions">
                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                        <i class="material-icons center-align">search</i>
                                    </a>
                                </div>
                                <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                            </li>
                            <li class="collection-item">
                                <div class="row">
                                    <div class="col s6 m4 l2">
                                        <p class="collections-title">Nombre de Agencia</p>
                                    </div>
                                    <div class="col s6 m2 l3 center-align">
                                        <p class="collections-title">Créditos desembolsados</p>
                                    </div>
                                    <div class="col s6 m2 l3 hide-on-small-only center-align">
                                        <p class="collections-title">Monto desembolsado</p>
                                    </div>
                                    <div class="col s6 m2 l2 hide-on-small-only center-align">
                                        <p class="collections-title">Saldo Capital</p>
                                    </div>
                                    <div class="col s6 m2 l2 hide-on-small-only center-align">
                                        <p class="collections-title">Capital Mora</p>
                                    </div>
                                </div>
                            </li>
                            <div class="list">
                                <?php $i=0;?>
                                    <?php if(count($taxis) > 0):?>

                                        <?php foreach($taxis as $taxies):?>
                                            <?php $i++;?>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6 m4 l2">
                                                            <p class="collections-content nombreAgencia"><?php echo $taxies['0'] == null ? 'Por asignar' : $taxies['0']; ?></p>
                                                        </div>
                                                        <div class="col s6 m2 l3">
                                                            <p class="collections-content crediDesembolsados center-align"><?php echo $taxies['1']; ?></p>
                                                        </div>
                                                        <div class="col s6 m2 l3 hide-on-small-only">
                                                            <p class="collections-content montoDesembolsado center-align">
                                                                L. <?php echo number_format($taxies['2']); ?>
                                                            </p>
                                                        </div>
                                                        <div class="col s6 m2 l2 hide-on-small-only">
                                                            <p class="collections-content montoDesembolsado center-align">
                                                                L. <?php echo number_format($taxies['3'], 2, ".", ","); ?>
                                                            </p>
                                                        </div>
                                                        <div class="col s6 m2 l2 hide-on-small-only">
                                                            <p class="collections-content montoDesembolsado center-align">
                                                                L. <?php echo number_format($taxies['4'], 2, ".", ","); ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>

                                                <?php endforeach;?>
                                                    <?php else:?>
                                                        <li class="center">
                                                            <h5>No hay ningún beneficiario</h5></li>
                                                        <?php endif;?>
                            </div>

                            <li class="collection-item">
                                <ul id="pag-control" class="pag pagination">
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="test3" class="col s12">
            <div id="work-collections" class="">
                <div class="row">
                    <div class="col s12 m12 l12" id="todos-las-barberias">
                        <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                        <ul id="projects-collection" class="collection z-depth-1">
                            <li class="collection-item avatar">
                                <i class="material-icons circle blue ">content_cut</i>
                                <span class="collection-header">Baberías</span>
                                <p>información acerca movilizador barberías</p>
                                <div class="secondary-content actions">
                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                        <i class="material-icons center-align">search</i>
                                    </a>
                                </div>
                                <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                            </li>
                            <li class="collection-item">
                                <div class="row">
                                    <div class="col s6 m4 l2">
                                        <p class="collections-title">Nombre de Agencia</p>
                                    </div>
                                    <div class="col s6 m2 l3 center-align">
                                        <p class="collections-title">Créditos desembolsados</p>
                                    </div>
                                    <div class="col s6 m2 l3 hide-on-small-only center-align">
                                        <p class="collections-title">Monto desembolsado</p>
                                    </div>
                                    <div class="col s6 m2 l2 hide-on-small-only center-align">
                                        <p class="collections-title">Saldo Capital</p>
                                    </div>
                                    <div class="col s6 m2 l2 hide-on-small-only center-align">
                                        <p class="collections-title">Capital Mora</p>
                                    </div>
                                </div>
                            </li>
                            <div class="list">
                                <?php $i=0;?>
                                    <?php if(count($barbarias) > 0):?>

                                        <?php foreach($barbarias as $baberies):?>
                                            <?php $i++;?>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6 m4 l2">
                                                            <p class="collections-content nombreAgencia"><?php echo $baberies['0'] == null ? 'Por asignar' : $baberies['0']; ?></p>
                                                        </div>
                                                        <div class="col s6 m2 l3">
                                                            <p class="collections-content crediDesembolsados center-align"><?php echo $baberies['1']; ?></p>
                                                        </div>
                                                        <div class="col s6 m2 l3 hide-on-small-only">
                                                            <p class="collections-content montoDesembolsado center-align">
                                                                L. <?php echo number_format($baberies['2']); ?>
                                                            </p>
                                                        </div>
                                                        <div class="col s6 m2 l2 hide-on-small-only">
                                                            <p class="collections-content montoDesembolsado center-align">
                                                                L. <?php echo number_format($baberies['3'], 2, ".", ","); ?>
                                                            </p>
                                                        </div>
                                                        <div class="col s6 m2 l2 hide-on-small-only">
                                                            <p class="collections-content montoDesembolsado center-align">
                                                                L. <?php echo number_format($baberies['4'], 2, ".", ","); ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>

                                                <?php endforeach;?>
                                                    <?php else:?>
                                                        <li class="center">
                                                            <h5>No hay ningún beneficiario</h5></li>
                                                        <?php endif;?>
                            </div>

                            <li class="collection-item">
                                <ul id="pag-control" class="pag pagination">
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="test4" class="col s12">
            <div id="work-collections" class="">
                <div class="row">
                    <div class="col s12 m12 l12" id="todos-las-pulperias">
                        <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                        <ul id="projects-collection" class="collection z-depth-1">
                            <li class="collection-item avatar">
                                <i class="material-icons circle green ">store</i>
                                <span class="collection-header">Pulpería</span>
                                <p>información acerca movilizador pulpería</p>
                                <div class="secondary-content actions">
                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                        <i class="material-icons center-align">search</i>
                                    </a>
                                </div>
                                <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                            </li>
                            <li class="collection-item">
                                <div class="row">
                                    <div class="col s6 m4 l2">
                                        <p class="collections-title">Nombre de Agencia</p>
                                    </div>
                                    <div class="col s6 m2 l3 center-align">
                                        <p class="collections-title">Créditos desembolsados</p>
                                    </div>
                                    <div class="col s6 m2 l3 hide-on-small-only center-align">
                                        <p class="collections-title">Monto desembolsado</p>
                                    </div>
                                    <div class="col s6 m2 l2 hide-on-small-only center-align">
                                        <p class="collections-title">Saldo Capital</p>
                                    </div>
                                    <div class="col s6 m2 l2 hide-on-small-only center-align">
                                        <p class="collections-title">Capital Mora</p>
                                    </div>
                                </div>
                            </li>
                            <div class="list">
                                <?php $i=0;?>
                                    <?php if(count($pulperias) > 0):?>

                                        <?php foreach($pulperias as $pulperies):?>
                                            <?php $i++;?>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s6 m4 l2">
                                                            <p class="collections-content nombreAgencia"><?php echo $pulperies['0'] == null ? 'Por asignar' : $pulperies['0']; ?></p>
                                                        </div>
                                                        <div class="col s6 m2 l3">
                                                            <p class="collections-content crediDesembolsados center-align"><?php echo $pulperies['1']; ?></p>
                                                        </div>
                                                        <div class="col s6 m2 l3 hide-on-small-only">
                                                            <p class="collections-content montoDesembolsado center-align">
                                                                L. <?php echo number_format($pulperies['2']); ?>
                                                            </p>
                                                        </div>
                                                        <div class="col s6 m2 l2 hide-on-small-only">
                                                            <p class="collections-content montoDesembolsado center-align">
                                                                L. <?php echo number_format($pulperies['3'], 2, ".", ","); ?>
                                                            </p>
                                                        </div>
                                                        <div class="col s6 m2 l2 hide-on-small-only">
                                                            <p class="collections-content montoDesembolsado center-align">
                                                                L. <?php echo number_format($pulperies['4'], 2, ".", ","); ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>

                                                <?php endforeach;?>
                                                    <?php else:?>
                                                        <li class="center">
                                                            <h5>No hay ningún beneficiario</h5></li>
                                                        <?php endif;?>
                            </div>

                            <li class="collection-item">
                                <ul id="pag-control" class="pag pagination">
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {

            $('.collapsible').collapsible();
            
            
            /*OPTIMIZAR ESTE CODIGO MAS TARDE*/
             $('#tab1').on('click',function(){
                $('ul.tabs').tabs('select_tab', 'test1');
            });
             $('#tab2').on('click',function(){
                $('ul.tabs').tabs('select_tab', 'test2');
            });
            $('#tab3').on('click',function(){
                $('ul.tabs').tabs('select_tab', 'test3');
            });
             $('#tab4').on('click',function(){
                $('ul.tabs').tabs('select_tab', 'test4');
            });
            /*OPTIMIZAR ESTE CODIGO MAS TARDE*/
          
           
            var options = {
                page: 6,
                pagination: true,
                valueNames: ['nombreAgencia', 'crediDesembolsados', 'montoDesembolsado'],
                fuzzySearch: {
                    searchClass: "fuzzy-search",
                    location: 0,
                    distance: 100,
                    threshold: 0.2,
                    multiSearch: true
                }
            };
            var listasalon = new List('todos-los-salones', options);
            var listataxis = new List('todos-los-taxis', options);
            var listabarberias = new List('todos-las-barberias', options);
            var listapulperias = new List('todos-las-pulperias', options);
            
            
            $('.icon-collapse-search').click(function () {
                $('.search-expandida').toggleClass('expanded');
                $('.search-expandida').focus();
            });
            $('#breadcrum-title').text('Reporte de Movilizadores');
             
            
        });
        
    </script>
    <script>
        $(window).load(function() {
            var anchoDeCardAlert  = $('#card-alert').width();
            $('.headerDivider').css('right', (anchoDeCardAlert/2)+'px');
        });</script>