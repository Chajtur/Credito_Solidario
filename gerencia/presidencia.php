<?php 
require '../php/PHPExcel.php';
require '../php/conection.php';

$array_meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
$date = new DateTime();
/*beneficiarios*/
$sql = $conn->prepare('
    select count(*), sum(monto_desembolsado) from prestamo where if((ciclo is null), if(monto_desembolsado between 1 and 5000,1,if(monto_desembolsado between 5001 and 10000,2,if(monto_desembolsado between 10001 and 20000,3,1))),ciclo) not in ("2","12","3")
');

$sql->execute();
$beneficiarios = $sql->fetchAll();


/*cartera oficial*/
$sql = $conn->prepare('
    select count(*) as creditos, sum(monto_desembolsado) as desembolsado, (sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0))/sum(saldo_capital))*100 as porcentajeMora, sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) as mora
    from prestamo where (usuario_digitador  <> "Afectada" or usuario_digitador is null) and Estado_Credito = "Desembolsado"
');
$sql->execute();
$carteraOficial = $sql->fetchAll();


/*ciclos hisoricos*/
$sql = $conn->prepare('
    select count(a.Numero_Prestamo) as total, sum(a.Monto_Desembolsado) as desembolsado, count(d.Numero_Prestamo) as ciclo1, count(b.numero_prestamo) as ciclo2, count(c.numero_prestamo) as ciclo3 from prestamo a
    left join prestamo d on a.Numero_Prestamo = d.Numero_Prestamo and if((a.ciclo is null), if(a.monto_desembolsado between 1 and 5000,1,if(a.monto_desembolsado between 5001 and 10000,2,if(a.monto_desembolsado between 10001 and 20000,3,1))),a.ciclo) not in ("2","12","3")
    left join prestamo b on a.Numero_Prestamo = b.Numero_Prestamo and if((b.ciclo is null), if(b.monto_desembolsado between 1 and 5000,1,if(b.monto_desembolsado between 5001 and 10000,2,if(b.monto_desembolsado between 10001 and 20000,3,1))),b.ciclo) in ("2","12")
    left join prestamo c on a.Numero_Prestamo = c.Numero_Prestamo and if((c.ciclo is null), if(c.monto_desembolsado between 1 and 5000,1,if(c.monto_desembolsado between 5001 and 10000,2,if(c.monto_desembolsado between 10001 and 20000,3,1))),c.ciclo) = "3"
    
');
$sql->execute();
$ciclosHistorico = $sql->fetchAll();


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
    $strDesglose = $strDesglose .'<li class="collection-item">
                                    <div class="row">
                                        <div class="col s4 m4 l5">
                                            <p class="collections-content">'.($desglose[$i]['0'] == null ? 'Por asignar' : $desglose[$i]['0']).'</p>
                                        </div>
                                        <div class="col s4 m4 l4" style="padding-right:120px;">
                                            <p class="collections-content right-align">'.number_format($desglose[$i]['1']).'</p>
                                        </div>
                                        <div class="col s4 m4 l3">
                                            <p class="collections-content right-align">Lps. '.number_format($desglose[$i]['2'], 2, ".", ",").'</p>
                                        </div>
                                    </div>
                                </li>';
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*salones*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado) 
    from prestamo 
    where Fecha_Desembolso >= "2017-3-3" and programa = "P09" 
    group by get_agencia(get_nombre(gestor),agencia)
');

$sql->execute();
$belleza = $sql->fetchAll();

$contadorCreditosSalon = 0;
$contadorDesembolsoSalon = 0;
for($i=0; $i< count($belleza); $i++){
    
    $contadorCreditosSalon += $belleza[$i]['1'];
    $contadorDesembolsoSalon += $belleza[$i]['2'];
    
}

/*taxis*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado) 
    from prestamo 
    where Fecha_Desembolso >= "2017-3-3" and programa = "P08" 
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


/*baberías*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado) 
    from prestamo 
    where Fecha_Desembolso >= "2017-3-3" and programa = "P10" 
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


/*pulperías*/
$sql = $conn->prepare('
    select get_agencia(get_nombre(gestor),agencia), count(*), sum(monto_desembolsado) 
    from prestamo 
    where Fecha_Desembolso >= "2017-3-3" and programa = "P11" 
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

?>


    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="description" content="credito solidario, banca solidaria, credito joven, banca, solidaria, honduras">
        <meta name="keywords" content="credito solidario, banca solidaria, credito joven, banca, solidaria, honduras">
        <title>Gerencial</title>

        <!-- Favicons-->
        <link rel="icon" href="../images/favicon/favicon-32x32.png" sizes="32x32">
        <!-- Favicons-->
        <link rel="apple-touch-icon-precomposed" href="../images/favicon/apple-touch-icon-152x152.png">
        <!-- For iPhone -->
        <meta name="msapplication-TileColor" content="#">
        <meta name="msapplication-TileImage" content="../images/favicon/mstile-144x144.png">
        <!--Tint Titlebar for Chrome-->
        <meta name="theme-color" content="#3F51B5" />
        <!-- For Windows Phone -->


        <!-- CORE CSS-->
        <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
        <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
        <!-- Custome CSS-->
        <link href="../css/custom/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">
        <link rel="stylesheet" href="../css/custom/nuevo.css">
        <link rel="stylesheet" href="../css/custom/tema-indigo.css">
        <link rel="stylesheet" href="../css/custom/search.css">
        <!-- Material-icons-->
        <link href="../fonts/material-icons/material-icons.css" type="text/css" rel="stylesheet" media="screen,projection">

        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
        <link href="../js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
        <link href="../js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
        <!--<link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        
        <style>
     #loaderFrame{
        visibility: hidden;
        height: 1px;
        width: 1px;
     }
  </style>

    </head>

    <body>

        <!-- Start Page Loading -->
        <div class="preloader">
            <div class="statusl">
                <div class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue-only">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Loading -->


        <!-- START HEADER -->
        <header id="header" class="page-topbar">

            <div class="navbar-fixed">
                <nav>
                    <div class="nav-wrapper row">
                        <ul class="left col s3">
                            <li>
                                <h1 class="logo-wrapper">
                        <a href="#" class="brand-logo darken-1">
                            <object type="image/svg+xml" data="../images/logocredito.svg"></object>
                        </a> <span class="logo-text">Materialize</span></h1>
                            </li>
                        </ul>

                        <ul class="right hide-on-med-and-down col s3 nav-right-menu">
                            <li>
                                <a href="#" class="brand-logo right logo2"><img src="../images/logo-presidencia.png" alt=""></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

        </header>
        <!-- END HEADER -->

        <!-- START MAIN -->
        <main class="" id="">

            <!-- START CONTENT -->
            <section id="content">

                <!--breadcrumbs start-->
                <div id="breadcrumbs-wrapper" class="hide-on-med-and-down">

                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <!--<h5 class="breadcrumbs-title">Blank Page</h5>-->
                                <ol class="breadcrumbs">
                                    <li><a href="#">Inicio</a></li>
                                    <li class="active" id="breadcrum-title">Reporte Presidencial</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs end-->

                <!--start container-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l8 offset-l2">
                            <ul class="tabs tabs-fixed-width z-depth-1">
                                <li class="tab col s3"><a class="active" href="#test1">Reporte Presidencial</a></li>
                                <li class="tab col s3"><a href="#test2">Movilizadores</a></li>
                            </ul>
                        </div>
                        <div id="test1" class="col s12 m12 l8 offset-l2">
                            <div class="section">
                               <!--desktop-->
                                <div class="row hide-on-small-only">
                                    <div class="col s12">
                                        <div id="work-collections" class="">
                                            <div class="row">
                                                <div class="col s12 m12 l12">
                                                    <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                                                    <ul id="projects-collection" class="collection z-depth-1">
                                                        <li class="collection-item avatar">
                                                            <i class="material-icons circle light-blue ">timeline</i>
                                                            <span class="collection-header">Meta y cumplimiento</span>
                                                            <p>mes de
                                                                <?php echo $array_meses[$date->format('m') - 1]; ?>
                                                            </p>
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
                                                                    <p class="collections-content">
                                                                        <?php echo number_format($metas[0]['Creditos_Mes']) ?>
                                                                    </p>
                                                                </div>
                                                                <div class="col s3">
                                                                    <p class="collections-content">
                                                                        <?php echo number_format($ejecutados[0]['Creditos_Mes']) ?>
                                                                    </p>
                                                                </div>
                                                                <div class="col s3">
                                                                    <p class="collections-content">
                                                                        <?php echo number_format(($ejecutados[0]['Creditos_Mes']/$metas[0]['Creditos_Mes']*100), 2, ".", ",") ?>%</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="collection-item">
                                                            <div class="row">
                                                                <div class="col s3">
                                                                    <p class="collections-title">Ejecutados</p>
                                                                </div>
                                                                <div class="col s3">
                                                                    <p class="collections-content">L.<?php echo number_format($metas[0]['Monto_Mes'], 2, ".", ",") ?></p>
                                                                </div>
                                                                <div class="col s3">
                                                                    <p class="collections-content">L.<?php echo number_format($ejecutados[0]['Monto_Mes'], 2, ".", ",") ?></p>
                                                                </div>
                                                                <div class="col s3">
                                                                    <p class="collections-content"><?php echo number_format(($ejecutados[0]['Monto_Mes']/$metas[0]['Monto_Mes']*100), 2, ".", ",") ?>%</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <!--movil-->
                                <div class="row hide-on-med-and-up">
                                    <div class="col s12">
                                        <div id="work-collapsible">
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
                                                            <p>mes de <?php echo $array_meses[$date->format('m') - 1]; ?></p>
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
                                                                                            <p class="collapsible-content truncate crediDesembolsados "><?php echo number_format($metas[0]['Creditos_Mes']) ?></p>
                                                                                        </div>
                                                                                        <div class="col s4 m3 l3">
                                                                                            <p class="collapsible-content truncate crediDesembolsados "><?php echo number_format($ejecutados[0]['Creditos_Mes']) ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="collapsible-body"><span class="montoDesembolsado">Porcentaje de Créditos: <?php echo number_format(($ejecutados[0]['Creditos_Mes']/$metas[0]['Creditos_Mes']*100), 2, ".", ",") ?>%</span></div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="collapsible-header sin-icon">
                                                                                    <div class="row">
                                                                                        <div class="col s4 m3 l3">
                                                                                            <p class="collapsible-title truncate nombreAgencia"><span class="blue-text">+</span> Ejecutados</p>
                                                                                        </div>
                                                                                        <div class="col s4 m3 l3">
                                                                                            <p class="collapsible-content truncate crediDesembolsados ">L.<?php echo number_format($metas[0]['Monto_Mes'], 2, ".", ",") ?></p>
                                                                                        </div>
                                                                                        <div class="col s4 m3 l3">
                                                                                            <p class="collapsible-content truncate crediDesembolsados ">L.<?php echo number_format($ejecutados[0]['Monto_Mes'], 2, ".", ",") ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="collapsible-body"><span class="montoDesembolsado">Porcentaje de Ejecutados: <?php echo number_format(($ejecutados[0]['Monto_Mes']/$metas[0]['Monto_Mes']*100), 2, ".", ",") ?>%</span></div>
                                                                            </li>
                                                                
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--desktop-->
                                <div class="row hide-on-small-only">
                                    <div class="col s12">
                                        <div id="work-collections" class="">
                                            <div class="row">
                                                <div class="col s12 m12 l12">
                                                    <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                                                    <ul id="projects-collection" class="collection z-depth-1">
                                                        <li class="collection-item avatar">
                                                            <i class="material-icons circle green ">timeline</i>
                                                            <span class="collection-header">Meta y cumplimiento</span>
                                                            <p>del año <?php echo date('Y') ?></p>
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
                                                                    <p class="collections-content">
                                                                        <?php echo number_format($metas[0]['Creditos_Anual']) ?>
                                                                    </p>
                                                                </div>
                                                                <div class="col s3">
                                                                    <p class="collections-content">
                                                                        <?php echo number_format($ejecutados[0]['Creditos_Anual']) ?>
                                                                    </p>
                                                                </div>
                                                                <div class="col s3">
                                                                    <p class="collections-content">
                                                                        <?php echo number_format(($ejecutados[0]['Creditos_Anual']/$metas[0]['Creditos_Anual']*100), 2, ".", ",") ?>%</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="collection-item">
                                                            <div class="row">
                                                                <div class="col s3">
                                                                    <p class="collections-title">Ejecutados</p>
                                                                </div>
                                                                <div class="col s3">
                                                                    <p class="collections-content">L.
                                                                        <?php echo number_format($metas[0]['Monto_Anual'], 2, ".", ",") ?>
                                                                    </p>
                                                                </div>
                                                                <div class="col s3">
                                                                    <p class="collections-content">L.
                                                                        <?php echo number_format($ejecutados[0]['Monto_Anual'], 2, ".", ",") ?>
                                                                    </p>
                                                                </div>
                                                                <div class="col s3">
                                                                    <p class="collections-content">
                                                                        <?php echo number_format(($ejecutados[0]['Monto_Anual']/$metas[0]['Monto_Anual']*100), 2, ".", ",") ?>%</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <!--movil-->
                                <div class="row hide-on-med-and-up">
                                    <div class="col s12">
                                        <div id="work-collapsible">
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
                                    </div>
                                </div>
                                <!--desktop-->
                                <div class="row hide-on-small-only">
                                    <div class="col s12">
                                        <div id="work-collections" class="">
                                            <div class="row">
                                                <div class="col s12 m12 l12">
                                                    <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                                                    <ul id="projects-collection" class="collection z-depth-1">
                                                        <li class="collection-item avatar">
                                                            <i class="material-icons circle indigo ">timeline</i>
                                                            <span class="collection-header">Desglose de Productos</span>
                                                            <p>del año <?php echo date('Y') ?></p>
                                                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                                        </li>
                                                        <li class="collection-item">
                                                            <div class="row">
                                                                <div class="col s4 m4 l5">
                                                                    <p class="collections-title">Nombre Producto</p>
                                                                </div>
                                                                <div class="col s4 m4 l4">
                                                                    <p class="collections-title">Créditos desembolsados</p>
                                                                </div>
                                                                <div class="col s4 m4 l3">
                                                                    <p class="collections-title">Monto desembolsado</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <?php echo $strDesglose; ?>
                                                            <li class="collection-item">
                                                                <div class="row">
                                                                    <div class="col s5">
                                                                        <p class="collections-content">Total</p>
                                                                    </div>
                                                                    <div class="col s4" style="padding-right:120px;">
                                                                        <p class="collections-content right-align">
                                                                            <?php echo number_format($totalCreditos); ?>
                                                                        </p>
                                                                    </div>
                                                                    <div class="col s3">
                                                                        <p class="collections-content right-align">L.
                                                                            <?php echo number_format($totalDesembolso, 2, ".", ","); ?></p>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--movil-->
                                <div class="row hide-on-med-and-up">
                                    <div class="col s12">
                                        <div id="work-collapsible">
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
                                                                                <div class="collapsible-body"><span class="montoDesembolsado">Monto Desembolsado: L.<?php echo number_format($desglosados['2']); ?></span></div>
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
                                                            <div class="collapsible-body"><span class="montoDesembolsado">Monto Desembolsado: L.<?php echo number_format($totalDesembolso, 2, ".", ","); ?></p></span></div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 l6">
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
                                                <h5>Saldo Cartera Afectada</h5></li>
                                            <li class="collection-item">
                                                <div>Saldo<span class="secondary-content"><?php echo number_format($saldoCarteraAfecta[0]['0'], 2, ".", ","); ?></span></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col s12 l6">
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
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <div id="test2" class="col s12 m12 l8 offset-l2">
                            <div class="section">
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                        <div id="card-alert" class="card blue">
                                            <div class="card-content white-text">
                                                <div class="row center">
                                                    <div class="col s6">
                                                        <p>TOTAL DE CRÉDITOS DESEMBOLSADO: <span style="font-size:18px"><?php echo number_format($contadorCreditosSalon+$contadorCreditosTaxis+$contadorCreditosBarbe+$contadorCreditosPulpe) ; ?> </span></p>
                                                    </div>
                                                    <div class="">
                                                        <div style="right: 470px;" class="headerDivider"></div>
                                                    </div>
                                                    <div class="col s6">
                                                        <p>TOTAL MONTO DESEMBOLSADO: <span style="font-size:18px"> L. <?php echo number_format($contadorDesembolsoSalon+$contadorDesembolsoTaxis+$contadorDesembolsoBarbe+$contadorDesembolsoPulpe, 2, ".", ",") ; ?></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--para desktop-->
                                <div class="row hide-on-small-only">
                                    <div class="col s12">
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
                                                                <div class="col s6 m4 l4">
                                                                    <p class="collections-title">Nombre de Agencia</p>
                                                                </div>
                                                                <div class="col s6 m2 l4 center-align">
                                                                    <p class="collections-title">Créditos desembolsados</p>
                                                                </div>
                                                                <div class="col s6 m2 l4 hide-on-small-only center-align">
                                                                    <p class="collections-title">Monto desembolsado</p>
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
                                                                                    <div class="col s6 m4 l4">
                                                                                        <p class="collections-content nombreAgencia"><?php echo $salones['0'] == null ? 'Por asignar' : $salones['0']; ?></p>
                                                                                    </div>
                                                                                    <div class="col s6 m2 l4">
                                                                                        <p class="collections-content crediDesembolsados center-align"><?php echo $salones['1']; ?></p>
                                                                                    </div>
                                                                                    <div class="col s6 m2 l4 hide-on-small-only">
                                                                                        <p class="collections-content montoDesembolsado center-align">L.<?php echo number_format($salones['2']); ?></p>
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
                                <div class="row hide-on-small-only">
                                    <div class="col s12">
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
                                                                <div class="col s6 m4 l4">
                                                                    <p class="collections-title">Nombre de Agencia</p>
                                                                </div>
                                                                <div class="col s6 m2 l4 center-align">
                                                                    <p class="collections-title">Créditos desembolsados</p>
                                                                </div>
                                                                <div class="col s6 m2 l4 hide-on-small-only center-align">
                                                                    <p class="collections-title">Monto desembolsado</p>
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
                                                                                    <div class="col s6 m4 l4">
                                                                                        <p class="collections-content nombreAgencia">
                                                                                            <?php echo $taxies['0'] == null ? 'Por asignar' : $taxies['0']; ?>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col s6 m2 l4">
                                                                                        <p class="collections-content crediDesembolsados center-align">
                                                                                            <?php echo $taxies['1']; ?>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col s6 m2 l4 hide-on-small-only">
                                                                                        <p class="collections-content montoDesembolsado center-align">
                                                                                            L.
                                                                                            <?php echo number_format($taxies['2']); ?>
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
                                <div class="row hide-on-small-only">
                                    <div class="col s12">
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
                                                                <div class="col s6 m4 l4">
                                                                    <p class="collections-title">Nombre de Agencia</p>
                                                                </div>
                                                                <div class="col s6 m2 l4 center-align">
                                                                    <p class="collections-title">Créditos desembolsados</p>
                                                                </div>
                                                                <div class="col s6 m2 l4 hide-on-small-only center-align">
                                                                    <p class="collections-title">Monto desembolsado</p>
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
                                                                                    <div class="col s6 m4 l4">
                                                                                        <p class="collections-content nombreAgencia">
                                                                                            <?php echo $baberies['0'] == null ? 'Por asignar' : $baberies['0']; ?>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col s6 m2 l4">
                                                                                        <p class="collections-content crediDesembolsados center-align">
                                                                                            <?php echo $baberies['1']; ?>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col s6 m2 l4 hide-on-small-only">
                                                                                        <p class="collections-content montoDesembolsado center-align">
                                                                                            L.
                                                                                            <?php echo number_format($baberies['2']); ?>
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
                                <div class="row hide-on-small-only">
                                    <div class="col s12">
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
                                                                <div class="col s6 m4 l4">
                                                                    <p class="collections-title">Nombre de Agencia</p>
                                                                </div>
                                                                <div class="col s6 m2 l4 center-align">
                                                                    <p class="collections-title">Créditos desembolsados</p>
                                                                </div>
                                                                <div class="col s6 m2 l4 hide-on-small-only center-align">
                                                                    <p class="collections-title">Monto desembolsado</p>
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
                                                                                    <div class="col s6 m4 l4">
                                                                                        <p class="collections-content nombreAgencia">
                                                                                            <?php echo $pulperies['0'] == null ? 'Por asignar' : $pulperies['0']; ?>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col s6 m2 l4">
                                                                                        <p class="collections-content crediDesembolsados center-align">
                                                                                            <?php echo $pulperies['1']; ?>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col s6 m2 l4 hide-on-small-only">
                                                                                        <p class="collections-content montoDesembolsado center-align">
                                                                                            L.
                                                                                            <?php echo number_format($pulperies['2']); ?>
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
                                <!--para moviles-->
                                <div class="row hide-on-med-and-up">
                                    <div class="col s12">
                                        <div id="work-collapsible">
                                            <div class="row">
                                                <div class="col s12" id="todos-los-salones-movil">
                                                    <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                                        <li class="collapsible-item-header avatar">
                                                            <i class="material-icons circle circle pink">spa</i>
                                                            <span class="collapsible-title-header">Salones
                                                                <div class="secondary-content actions">
                                                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                                        <i class="material-icons center-align">search</i>
                                                                    </a>  
                                                                </div>
                                                            </span>
                                                            <p>información acerca movilizador salones</p>
                                                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                                        </li>
                                                        <li>
                                                            <div class="collapsible-header-titles  sin-icon">
                                                                <div class="row">
                                                                    <div class="col s6 m3 l3">
                                                                        <p class="collapsible-title">Nombre de agencia</p>
                                                                    </div>
                                                                    <div class="col s6 m3 l3 ">
                                                                        <p class="collapsible-title">Créditos desembolsados</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <div class="list collapsible no-padding no-margin z-depth-0">
                                                           <?php $i=0;?>
                                                                <?php if(count($belleza) > 0):?>

                                                                    <?php foreach($belleza as $salones):?>
                                                                        <?php $i++;?>
                                                                            <li>
                                                                                <div class="collapsible-header sin-icon">
                                                                                    <div class="row">
                                                                                        <div class="col s6 m3 l3">
                                                                                            <p class="collapsible-content truncate nombreAgencia"><span class="blue-text" style="font-size:14px">+</span> <?php echo $salones['0'] == null ? 'Por asignar' : $salones['0']; ?></p>
                                                                                        </div>
                                                                                        <div class="col s6 m3 l3">
                                                                                            <p class="collapsible-content truncate crediDesembolsados center-align"><?php echo $salones['1']; ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="collapsible-body"><span class="montoDesembolsado">Monto Desembolsado: L.<?php echo number_format($salones['2']); ?></span></div>
                                                                            </li>
                                                                <?php endforeach;?>
                                                                    <?php else:?>
                                                                        <li class="center">
                                                                        <h5>No hay ningún beneficiario</h5></li>
                                                            <?php endif;?>
                                                        </div>
                                                        <li class="collapsible-header-titles  sin-icon">
                                                            <ul id="pag-control" class="pag pagination">
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row hide-on-med-and-up">
                                    <div class="col s12">
                                        <div id="work-collapsible">
                                            <div class="row">
                                                <div class="col s12" id="todos-los-taxis-movil">
                                                    <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                                        <li class="collapsible-item-header avatar">
                                                            <i class="material-icons circle circle amber">local_taxi</i>
                                                            <span class="collapsible-title-header">Taxis
                                                                <div class="secondary-content actions">
                                                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                                                    <a id="nuscartaxis" href="#!" class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                                        <i class="material-icons center-align">search</i>
                                                                    </a>  
                                                                </div>
                                                            </span>
                                                            <p>información acerca movilizador taxis</p>
                                                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                                        </li>
                                                        <li>
                                                            <div class="collapsible-header-titles  sin-icon">
                                                                <div class="row">
                                                                    <div class="col s6 m3 l3">
                                                                        <p class="collapsible-title">Nombre de agencia</p>
                                                                    </div>
                                                                    <div class="col s6 m3 l3 ">
                                                                        <p class="collapsible-title">Créditos desembolsados</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <div class="list collapsible no-padding no-margin z-depth-0">
                                                           <?php $i=0;?>
                                                                <?php if(count($taxis) > 0):?>

                                                                    <?php foreach($taxis as $taxies):?>
                                                                        <?php $i++;?>
                                                                            <li>
                                                                                <div class="collapsible-header sin-icon">
                                                                                    <div class="row">
                                                                                        <div class="col s6 m3 l3">
                                                                                            <p class="collapsible-content truncate nombreAgencia"><span class="blue-text" style="font-size:14px">+ </span><?php echo $taxies['0'] == null ? 'Por asignar' : $taxies['0']; ?></p>
                                                                                        </div>
                                                                                        <div class="col s6 m3 l3">
                                                                                            <p class="collapsible-content truncate crediDesembolsados center-align">+<?php echo $taxies['1']; ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="collapsible-body"><span class="montoDesembolsado">Monto Desembolsado: L.<?php echo number_format($taxies['2']); ?></span></div>
                                                                            </li>
                                                                <?php endforeach;?>
                                                                    <?php else:?>
                                                                        <li class="center">
                                                                        <h5>No hay ningún Datos</h5></li>
                                                            <?php endif;?>
                                                        </div>
                                                        <li class="collapsible-header-titles  sin-icon">
                                                            <ul id="pag-control" class="pag pagination">
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row hide-on-med-and-up">
                                    <div class="col s12">
                                        <div id="work-collapsible">
                                            <div class="row">
                                                <div class="col s12" id="todos-las-barberias-movil">
                                                    <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                                        <li class="collapsible-item-header avatar">
                                                            <i class="material-icons circle circle blue">content_cut</i>
                                                            <span class="collapsible-title-header">Barberías
                                                                <div class="secondary-content actions">
                                                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                                        <i class="material-icons center-align">search</i>
                                                                    </a>  
                                                                </div>
                                                            </span>
                                                            <p>información acerca movilizador Barberías</p>
                                                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                                        </li>
                                                        <li>
                                                            <div class="collapsible-header-titles  sin-icon">
                                                                <div class="row">
                                                                    <div class="col s6 m3 l3">
                                                                        <p class="collapsible-title">Nombre de agencia</p>
                                                                    </div>
                                                                    <div class="col s6 m3 l3 ">
                                                                        <p class="collapsible-title">Créditos desembolsados</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <div class="list collapsible no-padding no-margin z-depth-0">
                                                           <?php $i=0;?>
                                                                <?php if(count($barbarias) > 0):?>

                                                                    <?php foreach($barbarias as $baberies):?>
                                                                        <?php $i++;?>
                                                                            <li>
                                                                                <div class="collapsible-header sin-icon">
                                                                                    <div class="row">
                                                                                        <div class="col s6 m3 l3">
                                                                                            <p class="collapsible-content truncate nombreAgencia"><span class="blue-text" style="font-size:14px">+ </span><?php echo $baberies['0'] == null ? 'Por asignar' : $baberies['0']; ?></p>
                                                                                        </div>
                                                                                        <div class="col s6 m3 l3">
                                                                                            <p class="collapsible-content truncate crediDesembolsados center-align"><?php echo $baberies['1']; ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="collapsible-body"><span class="montoDesembolsado">Monto Desembolsado: L.<?php echo number_format($baberies['2']); ?></span></div>
                                                                            </li>
                                                                <?php endforeach;?>
                                                                    <?php else:?>
                                                                        <li class="center">
                                                                        <h5>No hay ningún Datos</h5></li>
                                                            <?php endif;?>
                                                        </div>
                                                        <li class="collapsible-header-titles  sin-icon">
                                                            <ul id="pag-control" class="pag pagination">
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row hide-on-med-and-up">
                                    <div class="col s12">
                                        <div id="work-collapsible">
                                            <div class="row">
                                                <div class="col s12" id="todos-las-pulperias-movil">
                                                    <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                                        <li class="collapsible-item-header avatar">
                                                            <i class="material-icons circle circle green">store</i>
                                                            <span class="collapsible-title-header">Pulperías
                                                                <div class="secondary-content actions">
                                                                    <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                                                    <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                                        <i class="material-icons center-align">search</i>
                                                                    </a>  
                                                                </div>
                                                            </span>
                                                            <p>información acerca movilizador Pulperías</p>
                                                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                                        </li>
                                                        <li>
                                                            <div class="collapsible-header-titles  sin-icon">
                                                                <div class="row">
                                                                    <div class="col s6 m3 l3">
                                                                        <p class="collapsible-title">Nombre de agencia</p>
                                                                    </div>
                                                                    <div class="col s6 m3 l3 ">
                                                                        <p class="collapsible-title">Créditos desembolsados</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <div class="list collapsible no-padding no-margin z-depth-0">
                                                           <?php $i=0;?>
                                                                <?php if(count($pulperias) > 0):?>

                                                                    <?php foreach($pulperias as $pulperies):?>
                                                                        <?php $i++;?>
                                                                            <li>
                                                                                <div class="collapsible-header sin-icon">
                                                                                    <div class="row">
                                                                                        <div class="col s6 m3 l3">
                                                                                            <p class="collapsible-content truncate nombreAgencia"><span class="blue-text" style="font-size:14px">+ </span><?php echo $pulperies['0'] == null ? 'Por asignar' : $pulperies['0']; ?></p>
                                                                                        </div>
                                                                                        <div class="col s6 m3 l3">
                                                                                            <p class="collapsible-content truncate crediDesembolsados center-align"><?php echo $pulperies['1']; ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="collapsible-body"><span class="montoDesembolsado">Monto Desembolsado: L.<?php echo number_format($pulperies['2']); ?></span></div>
                                                                            </li>
                                                                <?php endforeach;?>
                                                                    <?php else:?>
                                                                        <li class="center">
                                                                        <h5>No hay ningún Datos</h5></li>
                                                            <?php endif;?>
                                                        </div>
                                                        <li class="collapsible-header-titles  sin-icon">
                                                            <ul id="pag-control" class="pag pagination">
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fixed-action-btn vertical click-to-toggle">
                        <a class="btn-floating btn-large green darken-2 waves-effect waves-light">
                          <i class="large material-icons">add</i>
                        </a>
                        <ul>
                          <li class="hide-on-med-and-down"><a taget='_blank' id="printerButton" class="btn-floating red waves-effect waves-light"><i class="material-icons">print</i></a></li>
                          <li><a taget='_blank' href="prueba-vic.php?descargar" class="btn-floating yellow darken-1 waves-effect waves-light"><i class="material-icons">save</i></a></li>
                        </ul>
                    </div>
                </div>

            </section>
            <!-- END CONTENT -->
            
            <iframe id="loaderFrame" ></iframe>
        </main>
        <!-- END MAIN -->


        <!-- START FOOTER -->
        <footer class="page-footer footer-full-width">
            <div class="footer-copyright">
                <div class="container">
                    <span>Copyright © 2017 <a class="grey-text text-lighten-4" href="#" target="_blank">Crédito Solidario</a> All rights reserved.</span>
                    <span class="right"> Desarrollado por <a class="grey-text text-lighten-4" href="http://creditosolidario.hn">Depto. Informática - Crédito Solidario</a></span>
                </div>
            </div>
        </footer>
        <!-- END FOOTER -->


        <!-- ================================================
    Scripts
    ================================================ -->

        <!-- jQuery Library -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="../js/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!--materialize js-->
        <script type="text/javascript" src="../js/materialize.js"></script>
        <!--prism
    <script type="text/javascript" src="js/prism/prism.js"></script>-->
        <!--scrollbar-->
        <script type="text/javascript" src="../js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

        <!--custom-script.js - Add your own theme custom JS-->
        <script src="../js/custom-script.js"></script>

        <!--plugins.js - Some Specific JS codes for Plugin Settings-->
        <script type="text/javascript" src="../js/plugins.js"></script>


        <script src="http://listjs.com/assets/javascripts/list.min.js"></script>
        <script src="../js/plugins/list/list.1.5.0.min.js"></script>




        <!--<script src="../js/plugins/airDate-picker/js/datepicker.js"></script>
    <script src="../js/plugins/airDate-picker/js/i18n/datepicker.es.js"></script>-->

        <script>
            $(document).ready(function () {
                
               

                //Cargar la primera ventana al inicio
                $('.collapsible').collapsible();

                $('#floating-refresh').click(function () {
                    $('#' + window.idbtnmenuactivo).trigger('refresh');
                });

                $("ul.tabs").tabs({
                    onShow: function (tab) {
                        console.log(tab.selector);
                        if (tab.selector == '#test1') {
                            $('#breadcrum-title').text('Reporte Presidencial');
                        } else {
                                var anchoDeCardAlert  = $('#card-alert').width();
                                $('.headerDivider').css('right', anchoDeCardAlert/2+'px');
                                $('#breadcrum-title').text('Reporte de Movilizadores');
                        }

                    }
                });


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
                var listasalon = new List('todos-los-salones-movil', options);
                var listataxis = new List('todos-los-taxis', options);
                var listataxis = new List('todos-los-taxis-movil', options);
                var listabarberias = new List('todos-las-barberias', options);
                var listabarberias = new List('todos-las-barberias-movil', options);
                var listapulperias = new List('todos-las-pulperias', options);
                var listapulperias = new List('todos-las-pulperias-movil', options);

                $('#buscartaxi').click(function () {
                    $('.search-expandida').toggleClass('expanded');
                    $('.search-expandida').focus();
                });
                $('#breadcrum-title').text('Reporte Presidencial');

            });
        </script>
        
        
    <script>
    $(document).ready(function(){
        $('#loaderFrame').load(function(){
            var w = (this.contentWindow || this.contentDocument.defaultView);
            w.print();
        });

        $('#printerButton').click(function(){
            $('#loaderFrame').attr('src', 'prueba-vic.php');
        });
    });
  </script>
  



    </body>

    </html>