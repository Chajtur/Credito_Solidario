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
    <title>Asesor - Técnico</title>

    <!-- Favicons-->
    <link rel="icon" href="../images/favicon/favicon-32x32.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="../images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#">
    <meta name="msapplication-TileImage" content="../images/favicon/mstile-144x144.png">
    <!--Tint Titlebar for Chrome-->
    <meta name="theme-color" content="#3F51B5"/>
    <!-- For Windows Phone -->


    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="../css/custom/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="../fonts/material-icons/material-icons.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link rel="stylesheet" href="../js/plugins/sweetalert-master/dist/sweetalert.css">
    <link rel="stylesheet" href="../js/plugins/sweetalert-master/themes/google/google.css">
    
    <link rel="stylesheet" href="../css/custom/tema-indigo.css">
    <link rel="stylesheet" href="../css/custom/search.css">
    <link href="../js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="../js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link rel="stylesheet" href="../css/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="../css/plugins/select2/select2.materialize.css">
    <link rel="stylesheet" href="../css/materialize.clockpicker.css">

    <style>
        .button-collapse {
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
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
                        <li><a href="#" data-activates="mobile-demo" id="btn-menu-usuario" class="button-collapse show-on-large"><i class="material-icons">menu</i></a></li>
                        <li>
                            <h1 class="logo-wrapper">
                                <a href="#" class="brand-logo darken-1">
                                    <object type="image/svg+xml" data="../images/logocredito.svg"></object>
                                </a>
                                <span class="logo-text">Materialize</span>
                           </h1>
                        </li>
                    </ul>
                    <!--barra de busqueda en el header-->
                    <!--<div class="header-search-wrapper hide-on-med-and-down">
                        <i class="material-icons">search</i>
                        <input type="text" name="Search" class="header-search-input"
                        placeholder="Realice una consulta por Nombre o por Identidad"/>
                    </div>
                    <div class="left search col s6 hide-on-med-and-down">
                        <div class="input-field">
                            <input id=a"search" type="search" placeholder="Busque un Beneficiario" autocomplete="off">
                            <label for="search"><i class="material-icons search-icon">search</i></label>
                            <!--<i class="material-icons">close</i>
                            <a href="#" onClick="limpiarfields();" class="close-search"><i class="material-icons clear-icon">close</i></a>
                        </div>

                    </div>-->
                    
                    <!--<div class="left col s8 hide-on-med-and-down">
                        <h4 style="font-weight: 200;">| Asesores</h4>
                    </div>-->
                    <!--<div class="left search col s6 hide-on-med-and-down">
                            <div class="input-field">
                                <input id="search-visitas" type="search" placeholder="Realice una Consulta" autocomplete="off">
                                <label for="search"><i class="material-icons search-icon">search</i></label>
                                <a href="#" onClick="limpiarfields();" class="close-search"><i class="material-icons clear-icon">close</i></a>
                            </div>
                            
                    </div>-->
                    
                    <div class="left col s8 hide-on-med-and-down">
                        <h4 style="font-weight: 200;">| Asesores técnicos</h4>
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
    <div>
        <!-- START WRAPPER -->
        <div>

            <!-- START LEFT SIDEBAR NAV-->
            
                <ul id="mobile-demo" class="side-nav">
                    <?php require "../common/left-side-menu.php";?>
                    <!--<li><a id="menu-btn-credito-devuelto" class="waves-effect waves-light"><i class="material-icons">edit</i>Créditos Devueltos</a></li>-->
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                        <li class="menu-btn menu-btn-active" data-change="dashboard.php"><a id="menu-btn-dashboard" class="waves-effect waves-light collapsible-header sin-icon"><i class="material-icons">dashboard</i>Dashboard</a></li>      
                        <li>
                            <a class="collapsible-header">Recuperación<i class="material-icons">monetization_on</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li class="menu-btn"><a id="menu-btn-pagos-dia" class="waves-effect waves-light no-margin"><i class="material-icons">keyboard_arrow_right</i>Cuotas por cobrar</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a class="collapsible-header">Carteras<i class="material-icons">add</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li class="menu-btn"><a id="menu-btn-cartera" class="waves-effect waves-light no-margin"><i class="material-icons">list</i>Cartera total</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a class="collapsible-header">Agenda<i class="material-icons">assignment</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li class="menu-btn"><a id="menu-btn-agenda" class="waves-effect waves-light no-margin"><i class="material-icons">keyboard_arrow_right</i>Visualizar</a></li>
                                </ul>
                            </div>
                        </li>

                        </ul>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                    
                    <li><a class="subheader">Otras Opciones</a></li>
                    <li><a class="waves-effect waves-light" target="_blank" href="../consultas-nueva/index.php">Consultas</a></li>
                </ul>

            </aside>
            <!-- END LEFT SIDEBAR NAV-->


            <!-- START CONTENT -->
            <section id="content">

                <!--breadcrumbs start-->
                <div id="breadcrumbs-wrapper">
                    <!-- Search for small screen -->
                    <div class="header-search-wrapper grey hide-on-large-only">
                        <i class="material-icons active">search</i>
                        <input type="tel" name="personas[]" id="id_visitado" class="header-search-input z-depth-2" maxlength="15" placeholder="Identidad" required data-inputmask="'mask': '9999-9999-99999'">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <!--<h5 class="breadcrumbs-title">Blank Page</h5>-->
                                <ol class="breadcrumbs">
                                    <li><a>Créditos</a></li>
                                    <li class="active" id="breadcrum-title">Asesores</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--breadcrumbs end-->
                
                
                <!--start container-->
                <div class="container" id="main-container">
                  
                   <!--
                   Aqui va el contenido de cada ventana que cambiará dinamicamente
                   -->
                    
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
    <script src="../js/plugins/list/list.1.5.0.min.js"></script>
    <script src="../js/plugins/sweetalert-master/dist/sweetalert.min.js"></script>
    <script src="../js/plugins/data-change/data-change.js"></script>
    <script src="../js/plugins/cookie-manager/cookie-manager.js"></script>
    
    <script src="../js/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    <script src="../js/plugins/jquery-mask/jquery.mask.js"></script>
    <script src="../js/plugins/jqueryrotate/jquery.rotate.js"></script>
    <script src="../js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="js-script/principal.js"></script>
    <script>
        $(document).ready(function () {
            $('#btn-menu-usuario').sideNav({
                menuWidth: 300,
                edge: 'left',
                closeOnClick: false,
                draggable: true
            });

            $('#menu-btn-dashboard').click(function (evt) {
                $('#loading').show();
                $('#main-container').load('dashboard.php', function () {
                    $('#loading').hide();
                });
                evt.preventDefault();
            });
            $('#menu-btn-pagos-dia').click(function (evt) {
                $('#loading').show();
                $('#main-container').load('cuotas-cobrar.php', function () {
                    $('#loading').hide();
                });
                evt.preventDefault();
            });
            $('#menu-btn-cartera').click(function (evt) {
                $('#loading').show();
                $('#main-container').load('cartera-total.php', function () {
                    $('#loading').hide();
                });
                evt.preventDefault();
            });
            $('#menu-btn-agenda').click(function (evt) {
                $('#loading').show();
                $('#main-container').load('agenda.php', function () {
                    $('#loading').hide();
                });
                evt.preventDefault();
            });
        });
    </script>

</body>

</html>