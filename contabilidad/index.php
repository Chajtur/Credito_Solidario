<?php 
require '../php/PHPExcel.php';
require '../php/conection.php';
require '../php/auth.php';
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
    <title>Contabilidad</title>

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
    <link href="../js/plugins/chartisJs/chartist.css" type="text/css" rel="stylesheet" media="screen,projection">
    
    <link href="../js/plugins/d3/c3/c3.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!--<link rel="stylesheet" href="metas/c3.css">-->
    
    <!--Sweet Alert-->
    <link rel="stylesheet" href="../js/plugins/sweetalert-master/dist/sweetalert.css">
    <link rel="stylesheet" href="../js/plugins/sweetalert-master/themes/google/google.css">
    
    <!--<link rel="stylesheet" href="../js/plugins/airDate-picker/css/datepicker.css">-->
    <link rel="stylesheet" href="../js/plugins/pignose-datepicker/dist/pignose.calendar.css">
    <link rel="stylesheet" href="../js/plugins/pignose-datepicker/dist/custom.css">
    
    <!--<link rel="stylesheet" href="../css/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="../css/plugins/select2/select2.materialize.css">-->
    <link rel="stylesheet" href="../js/plugins/select2/select2/css/select2.css">

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
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="navbar-color">
                <div class="nav-wrapper row">

                    <ul class="left col s3">
                        <li>
                            <h1 class="logo-wrapper">
                                <a href="#" class="brand-logo darken-1">
                                    <object type="image/svg+xml" data="../images/logocredito.svg"></object>
                                </a> <span class="logo-text">Materialize</span></h1>
                        </li>
                    </ul>
                    <!--barra de busqueda en el header-->
                    <!--<div class="header-search-wrapper hide-on-med-and-down">
                        <i class="material-icons">search</i>
                        <input type="text" name="Search" class="header-search-input"
                        placeholder="Realice una consulta por Nombre o por Identidad"/>
                        </div>-->

                    <!--<form class="left search col s6 hide-on-med-and-down">
                            <div class="input-field">
                                <input id="search" type="search" placeholder="Realice una Consulta" autocomplete="off">
                                <label for="search"><i class="material-icons search-icon">search</i></label>
                                <a href="#" onClick="limpiarfields();" class="close-search"><i class="material-icons clear-icon">close</i></a>
                            </div>
                        </form>-->

                    <ul class="right hide-on-med-and-down col s3 nav-right-menu">
                        <!--<li><a class="perfil-on-nav-button" href="#!" data-activates="perfil-on-nav">Victor Alvarado<i class="material-icons right">arrow_drop_down</i></a></li>
                            <li class="waves-effect waves-light"><a href="">Sass</a></li>
                            <li class="waves-effect waves-light"><a href="">Components</a></li>-->
                        <!-- Dropdown Trigger -->
                        <li>
                            <a href="#" class="brand-logo right logo2"><img src="../images/logo-presidencia.png" alt=""></a>
                        </li>
                    </ul>

                    <!--<div class="col col s8 m8 l8">
                            <ul id="perfil-on-nav" class="dropdown-content">
                                <li><a href="#"><i class="material-icons">face</i>
                        <span class="option-user-select">Perfil</span>
                        </a>
                                </li>
                                <li><a href="#"><i class="material-icons">account_circle</i>
                        <span class="option-user-select">Cuenta</span>
                        </a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="material-icons">home</i>
                        <span class="option-user-select">Salir</span>
                        </a>
                                </li>
                            </ul>
                        </div>-->

                </div>
            </nav>
        </div>
        <!-- end header nav-->
    </header>
    <!-- END HEADER -->

    <!-- START MAIN -->
    <div id="main">
        <!-- START WRAPPER -->
        <div class="wrapper">

            <!-- START LEFT SIDEBAR NAV-->
            <aside id="left-sidebar-nav">
                <ul id="slide-out" class="side-nav fixed leftside-navigation collapsible no-border" data-collapsible="accordion">
                    <?php require '../common/left-side-menu.php';?>
                    <li id="estado_colocacion" class="sin-icon menu-btn menu-btn-active" data-change="../gerencia/coldesrec/colocacion.php"><a onclick="hideMenuOnClick()" class="waves-effect waves-light"><i class="material-icons">border_color</i>Colocación</a></li>
                    <li id="estado_desembolsos" class="sin-icon menu-btn" data-change="../gerencia/coldesrec/desembolsos.php"><a onclick="hideMenuOnClick()" class="waves-effect waves-light"><i class="material-icons">publish</i>Desembolsos</a></li>
                    <li id="estado_recuperacion" class="sin-icon menu-btn" data-change="../gerencia/coldesrec/recuperacion.php"><a onclick="hideMenuOnClick()" class="waves-effect waves-light"><i class="material-icons">attach_money</i>Recuperación</a></li>
                    <li id="estado_pendiente_desembolso" class="sin-icon menu-btn" data-change="coldesrec/pendiente_desembolso.php"><a onclick="hideMenuOnClick()" class="waves-effect waves-light"><i class="material-icons">monetization_on</i>Pendiente Desembolso</a></li>
                    <li onclick="hideMenuOnClick()" id="menu-btn-descargarCarteras" class="menu-btn" data-change="../common/carteras.php"><a class="waves-effect waves-light"><i class="material-icons">work</i>Descargar Carteras</a></li>
                    
                    <!--<li id="colocacion" class="sin-icon menu-btn" data-change="coldesrec/colocacion.php"><a onclick="hideMenuOnClick()" class="waves-effect waves-light"><i class="material-icons">edit</i>Colocación</a></li>-->
                    <!--<li id="menu-btn-crear-grupo" class="menu-btn" data-change="prueba1.php"><a class="waves-effect waves-light"><i class="material-icons">work</i>Reporte de Carteras</a></li>-->
                    <li>
                        <div class="divider"></div>
                    </li>
                    <li><a class="subheader">Más Opciones</a></li>
                    <li><a class="waves-effect waves-light" href="../php/generar_carteras.php">Generar Carteras</a></li>
                    <li><a class="waves-effect waves-light" target="_blank" href="../consultas-nueva/index.php">Consultas</a></li>
                </ul>
                <a href="#" data-activates="slide-out" class="sidebar-collapse  waves-effect waves-light hide-on-large-only">
                    <i class="material-icons white600 md-36">menu</i>
                </a>

            </aside>
            <!-- END LEFT SIDEBAR NAV-->


            <!-- START CONTENT -->
            <section id="content">

                <!--breadcrumbs start-->
                <div id="breadcrumbs-wrapper">
                    <!-- Search for small screen -->
                    <!--<div class="header-search-wrapper grey hide-on-large-only">
                            <i class="material-icons active">search</i>
                            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
                        </div>-->
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <!--<h5 class="breadcrumbs-title">Blank Page</h5>-->
                                <ol class="breadcrumbs">
                                    <li><a href="#">Inicio</a></li>
                                    <li class="active" id="breadcrum-title">Reportes Gerenciales</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs end-->

                <!--start container-->
                <div class="container" id="main-container">

                    <!-- Floating Action Button -->
                    <!--<div class="fixed-action-btn toolbar">
                        <a class="btn-floating btn-large red waves-effect waves-light">
                            <i class="large material-icons">mode_edit</i>
                        </a>
                        <ul>
                            <li class="waves-effect waves-light"><a href="#!"><i class="material-icons">insert_chart</i></a></li>
                            <li class="waves-effect waves-light"><a href="#!"><i class="material-icons">format_quote</i></a></li>
                            <li class="waves-effect waves-light"><a href="#!"><i class="material-icons">publish</i></a></li>
                            <li class="waves-effect waves-light"><a href="#!"><i class="material-icons">attach_file</i></a></li>
                        </ul>
                    </div>-->
                    <!-- Floating Action Button -->
                </div>
                <!--end container-->

                <div class="container center" id="loading">
                    <br>
                    <br>
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

            </section>
            <!-- END CONTENT -->


        </div>
        <!-- END WRAPPER -->

    </div>
    <!-- END MAIN -->

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large green" id="floating-refresh">
            <i class="large material-icons">refresh</i>
        </a>
    </div>
    <?php require '../common/footer.php';?>
    <!-- END FOOTER -->

    <div class="preloader-tb" id="loading-indicator">
        <div class="statusl-tb">
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


   <script src="../js/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
   
    <script src="../js/plugins/pignose-datepicker/dist/moment.min.js"></script>
    <script src="../js/plugins/pignose-datepicker/dist/pignose.calendar.js"></script>

    <script src="../js/plugins/data-change/data-change.js"></script>
    <script src="../js/plugins/chartJS/Chart.bundle.js"></script>
    <script src="../js/plugins/chartJS/Chart.PieceLabel.js"></script>
    <script src="../js/plugins/chartisJs/chartist.js"></script>
    
    <script src="../js/plugins/d3/c3/c3.js"></script>
    <script src="../js/plugins/d3/d3.js"></script>
    
    <script src="../js/plugins/select2/select2/js/select2.js"></script>


    <!--<script src="../js/plugins/airDate-picker/js/datepicker.js"></script>
    <script src="../js/plugins/airDate-picker/js/i18n/datepicker.es.js"></script>-->

    <script>
        $(document).ready(function() {

            //Cargar la primera ventana al inicio

            $('#floating-refresh').click(function() {
                $('#' + window.idbtnmenuactivo).trigger('refresh');
            });

            $('#main-container').load('coldesrec/colocacion.php', function() {
                $('#loading').hide();
            });

        });

    </script>



</body>

</html>
