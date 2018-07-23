<?php
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
    <title>Coordinadores - Crédito Solidario</title>

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
    <!--Sweet Alert-->
    <link rel="stylesheet" href="../js/plugins/sweetalert-master/dist/sweetalert.css">
    <link rel="stylesheet" href="../js/plugins/sweetalert-master/themes/google/google.css">
    <link rel="stylesheet" href="../css/custom/nuevo.css">
    <link rel="stylesheet" href="../css/custom/tema-indigo.css">
    <link rel="stylesheet" href="../css/custom/search.css">
    <!-- Material-icons-->
    <link href="../fonts/material-icons/material-icons.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="../js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="../js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!--<link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">-->

    <!--<link rel="stylesheet" href="../js/plugins/jQuery-Plugin-For-Custom-Tri-state-Checkbox-triSwitch/css/jquery.triSwitch.css">-->
    <link rel="stylesheet" href="../js/plugins/candle-switch/css/candlestick.css">
    <link rel="stylesheet" href="../js/plugins/candle-switch/css/candlestick-maerial.css">
    
    <!--<link rel="stylesheet" href="../js/plugins/airDate-picker/css/datepicker.css">-->
    <link rel="stylesheet" href="../js/plugins/pignose-datepicker/dist/pignose.calendar.css">
    <link rel="stylesheet" href="../js/plugins/pignose-datepicker/dist/custom.css">
    
    <link rel="stylesheet" href="../js/plugins/select2/select2/css/select2.css">
    <style>
    .side-nav.fixed.leftside-navigation.collapsible {
        border: none !important;
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
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="navbar-color">
                <div class="nav-wrapper row">

                    <ul class="left col s2">
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
                    <!--<div class="left search col s6 hide-on-med-and-down">
                        <div class="input-field">
                            <input id="search" type="search" placeholder="Busque un Beneficiario" autocomplete="off">
                            <label for="search"><i class="material-icons search-icon">search</i></label>
                            <i class="material-icons">close</i>
                            <a href="#" onClick="limpiarfields();" class="close-search"><i class="material-icons clear-icon">close</i></a>
                        </div>

                    </div>-->
                    
                    <div class="left col s8 hide-on-med-and-down">
                        <h4 style="font-weight: 200;">| <?php echo ($_SESSION['designation'] == '55' ? 'Créditos Mobilizadores' : 'Coordinadores')?></h4>
                    </div>
                    
                    <ul class="right hide-on-med-and-down col s2 nav-right-menu">
                        <!--<li><a class="perfil-on-nav-button" href="#!" data-activates="perfil-on-nav">Victor Alvarado<i class="material-icons right">arrow_drop_down</i></a></li>
                        <li class="waves-effect waves-light"><a href="">Sass</a></li>
                        <li class="waves-effect waves-light"><a href="">Components</a></li>-->
                        <!-- Dropdown Trigger -->
                        <li>
                            <a href="#" class="brand-logo right logo2"><img src="../images/logo-presidencia.png" alt=""></a>
                        </li>
                    </ul>
                    <div class="col col s8 m8 l8">
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
                    </div>

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
                <ul id="slide-out" class="side-nav fixed leftside-navigation collapsible">
                    <?php require "../common/left-side-menu.php";?>
                    <li onclick="hideMenuOnClick()" id="menu-btn-dashboard" class="menu-btn" data-change="dashboard.php"><a class="waves-effect waves-light"><i class="material-icons">dashboard</i>Dashboard</a></li>
                    <li onclick="hideMenuOnClick()" id="menu-btn-agenda" class="menu-btn" data-change="agenda.php"><a class="waves-effect waves-light"><i class="material-icons">list</i>Agenda </a></li>
                    <li onclick="hideMenuOnClick()" id="menu-btn-recepcion" class="menu-btn" data-change="recibidos.php"><a class="waves-effect waves-light"><i class="material-icons">add_box</i>Grupos Recibidos</a></li>
                    <li onclick="hideMenuOnClick()" id="menu-btn-verificar" class="menu-btn" data-change="para-verificar.php"><a class="waves-effect waves-light"><i class="material-icons">list</i>Verificar Créditos</a></li>
                    <li onclick="hideMenuOnClick()" id="menu-btn-reportar" class="menu-btn menu-btn-active" data-change="reportardesembolsos.php"><a class="waves-effect waves-light"><i class="material-icons">report</i>Reportar Desembolsos</a></li>
                    <li onclick="hideMenuOnClick()" id="menu-btn-cfiltradas" class="menu-btn" data-change="carterasfiltradas.php"><a class="waves-effect waves-light"><i class="material-icons">work</i>Carteras</a></li>
                    <li onclick="hideMenuOnClick()" id="menu-btn-documentos" class="menu-btn" data-change="../common/documentos.php"><a class="waves-effect waves-light"><i class="material-icons">description</i>Documentos</a></li>
                    <li>
                        <div class="collapsible-header custom truncate tooltipped" data-position="right" data-delay="10" data-tooltip="Sistema de Gestión de Resultados"><i class="material-icons grey-text text-darken-1">menu</i>Reasignaciones</div><!--<i class="material-icons">account_balance</i>-->
                        <div class="collapsible-body custom">
                            <ul>
                                <li id="menu-btn-reasignar-beneficiarios" class="sin-icon menu-btn" data-change="reasignar-creditos.php"><a onclick="hideMenuOnClick()" class="waves-effect waves-light"><i class="material-icons">keyboard_arrow_right</i>Créditos</a></li>
                                <li id="estado_colocacion" class="sin-icon menu-btn" data-change="reasignacion.php"><a onclick="hideMenuOnClick()" class="waves-effect waves-light"><i class="material-icons">keyboard_arrow_right</i>Asesores</a></li>
                                <li id="menu-btn-reasignar-direcciones" class="sin-icon menu-btn" data-change="../informatica/direcciones.php"><a onclick="hideMenuOnClick()" class="waves-effect waves-light"><i class="material-icons">keyboard_arrow_right</i>Direcciones</a></li>
                            </ul>
                        </div>
                    </li>
                    <li onclick="hideMenuOnClick()" id="menu-btn-casos" class="menu-btn" data-change="../common/casos-coordinadores.php"><a class="waves-effect waves-light"><i class="material-icons">room_service</i>Casos</a></li>
                    <!-- <li>
                        <div class="collapsible-header custom truncate tooltipped" data-position="right" data-delay="10" data-tooltip="Sistema de Gestión de Resultados"><i class="material-icons grey-text text-darken-1">menu</i>SGR</div><!--<i class="material-icons">account_balance</i>-->
                        <!-- <div class="collapsible-body custom">
                            <ul>
                            </ul>
                        </div> -->
                    <!-- </li> -->
                    <li>
                        <div class="divider"></div>
                    </li>
                    
                    <li><a class="subheader">Otras Opciones</a></li>
                    <li><a class="waves-effect waves-light" target="_blank" href="../consultas-nueva/index.php">Consultas</a></li>
                    <li onclick="hideMenuOnClick()" id="menu-btn-descargarCarteras" class="menu-btn" data-change="../common/carteras.php"><a class="waves-effect waves-light"><i class="material-icons">description</i>Descargar Carteras</a></li>
                    <!--<li><a href="re-ingreso-grupos.html" class="waves-effect waves-light"><i class="material-icons">edit</i>Re-Ingreso de Grupos</a></li>-->
                    <!--<li><a href="#!" class="waves-effect waves-light"><i class="material-icons">list</i>Devueltos</a></li>-->


                    <!--<li>
                    <li><a href="#!" class="waves-effect waves-light"><i class="material-icons">add_box</i>Grupos Recibidos</a></li>
                    <li><a href="por-verificar.php" class="waves-effect waves-light"><i class="material-icons">list</i>Verificar Créditos</a></li>
                    
                    <li>
                        <div class="divider"></div>
                    </li>
                    
                    <li><a class="subheader">Subheader</a></li>
                    <li><a class="waves-effect waves-light" href="#!">Consultas</a></li>-->
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
                        <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Buscar Beneficiario">
                    </div>-->
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <!--<h5 class="breadcrumbs-title">Blank Page</h5>-->
                                <ol class="breadcrumbs">
                                    <li><a href="index.html">Coordinadores</a></li>
                                    <li class="active" id="breadcrum-title">Recibimiento de Créditos</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs end-->                

                <!--start container-->
                <div id="main-container" class="container">
                   
                    

                </div>
                <!--end container-->

                
                <div class="container center" id="loading">
                    <br><br>
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
    
    <div id="modal-lock" class="modal modal-custom">
        <div class="modal-content center">
            <div class="row">
                <div class="col s10 offset-s1">
                    <div class="row">
                        <div class="col s6 offset-s3">
                            <img class="circle responsive-img" src="../images/<?php echo ($_SESSION['gender'] == 'F' ? "user-girl" : "user");?>.png">
                        </div>
                    </div>
                    <h><?php echo $_SESSION['first_name'] . ' ' .$_SESSION['last_name'];?></h>
                    <input type="password" name="" id="modal-lock-input-pass" placeholder="Contraseña">
                    <h6><i class="material-icons small grey-text">lock</i><br>Bloqueado</h6>
                </div>
            </div>
            <a href="#!" class="waves-effect waves-green btn" id="btn-modal-submit">Desbloquear</a>
        </div>
    </div>

    <!-- START FOOTER -->
    <?php require "../common/footer.php";?>
    <!-- END FOOTER -->



    <!-- ================================================
    Scripts
    ================================================ -->

    <!-- jQuery Library -->
    <script type="text/javascript" src="../js/plugins/jquery-2.2.4.min.js"></script>
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
    
    <script type="text/javascript" src="../js/jquery.form.js"></script>
    
    <!--<script src="../js/plugins/jQuery-Plugin-For-Custom-Tri-state-Checkbox-triSwitch/js/jquery.triSwitch.js"></script>-->
    <script src="../js/plugins/candle-switch/js/candlestick.js"></script>
    
    <script src="../js/plugins/list/list.1.5.0.min.js"></script>

    <script src="../js/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="../js/plugins/data-change/data-change.js"></script>
    <script src="../js/plugins/chartJS/Chart.bundle.js"></script>
    <script src="../js/plugins/chartJS/Chart.PieceLabel.js"></script>
    <script src="../js/plugins/paginathing/paginathing.js"></script>
    <script src="../js/plugins/cookie-manager/cookie-manager.js"></script>
    <script src="../js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="../js/plugins/select2/select2/js/select2.js"></script>
    <script>
    
    $(document).ready(function(){
        
        /////////////////////////
        
        $('#modal-lock').modal({
            dismissible: false, // Modal can be dismissed by clicking outside of the modal
            opacity: .9, // Opacity of modal background
            inDuration: 100, // Transition in duration
            outDuration: 100,
            startingTop: '30%', // Starting top style attribute
            endingTop: '15%'
        });
        
        if(readCookie('locked')){
            $('#modal-lock').modal('open');
        }
        
        $('#floating-lock').click(function(){
            
            createCookie('locked', true, 1);
            $('#modal-lock-input-pass').val('');
            $('#modal-lock').modal('open');
            
        });

        $('.tooltipped').tooltip({delay: 50});
        
        $('#btn-modal-submit').click(function(){
            
            if($('#modal-lock-input-pass').val() != ""){
                
                $.ajax({
                    url: '../php/unlock.php',
                    type: 'POST',
                    data: 'data='+$('#modal-lock-input-pass').val(),
                    success: function(data){
                        
                        if(data){
                            $('#modal-lock').modal('close');
                            eraseCookie('locked');
                            Materialize.toast('Desbloqueado', 2000);
                        }else{
                            Materialize.toast('Contraseña Incorrecta', 2000);
                            //Materialize.toast($('#modal-lock-input-pass').val(), 2000);
                        }
                        
                    }
                });
                
            }else{
                
                Materialize.toast("No ingresó el password", 2000);
                
            }
            
        });
        
        /////////////////////////
        
        $('#floating-refresh').click(function(){
            $('#'+window.idbtnmenuactivo).trigger('refresh');
        });
        
        $('#main-container').load('reportardesembolsos.php', function(){
            $('#loading').hide();
        });
        
    });
    
    </script>

</body>

</html>