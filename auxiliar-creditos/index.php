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
    <title>Créditos - Crédito Solidario</title>

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


    <!-- CORE CSS-->
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
    <!--<link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">-->
    <style>
    
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
          -webkit-appearance: none; 
          margin: 0; 
        }
        
    </style>
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
                    
                    <div class="left col s8 hide-on-med-and-down">
                        <h4 style="font-weight: 200;">| Créditos</h4>
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
                    <li id="menu-btn-crear-grupo" class="menu-btn menu-btn-active" data-change="ingresar-grupo.php"><a class="waves-effect waves-light"><i class="material-icons">add_box</i>Creación de Grupos</a></li>
                    <li id="menu-btn-lista-grupo" class="menu-btn" data-change="lista-grupos.php"><a class="waves-effect waves-ligh"><i class="material-icons">list</i>Lista de Grupos</a></li>
                    <li id="menu-btn-creditos-devueltos" class="menu-btn" data-change="creditos-devueltos.php"><a class="waves-effect waves-light"><i class="material-icons">close</i>Créditos Devueltos</a></li>
                    <li id="menu-btn-re-ingreso-grupo" class="menu-btn" data-change="reingreso-grupos.php"><a class="waves-effect waves-light"><i class="material-icons">rotate_right</i>Re-Ingreso de Grupos</a></li>
                    <li id="menu-btn-recuperar" class="menu-btn" data-change="recuperar.php"><a class="waves-effect waves-light"><i class="material-icons">settings_backup_restore</i>Recuperar Créditos</a></li>
                    <li id="menu-btn-documentos" class="menu-btn" data-change="../common/documentos.php"><a class="waves-effect waves-light"><i class="material-icons">description</i>Documentos</a></li>
                    <li id="menu-btn-reportes" class="menu-btn" data-change="reportes.php"><a class="waves-effect waves-light"><i class="material-icons">description</i>Reportes</a></li>
                    <li id="menu-btn-castigar" class="menu-btn" data-change="castigar.php"><a class="waves-effect waves-light"><i class="material-icons">gavel</i>Retención de Créditos</a></li>
                    <li id="menu-btn-redimir" class="menu-btn" data-change="redimir.php"><a class="waves-effect waves-light"><i class="material-icons">thumb_up</i>Redimir Créditos</a></li>
                    <!--<li><a id="menu-btn-credito-devuelto" class="waves-effect waves-light"><i class="material-icons">edit</i>Créditos Devueltos</a></li>-->

                    <!--<li>
                        <div class="divider"></div>
                    </li>
                    
                    <li><a class="subheader">Subheader</a></li>
                    <li><a class="waves-effect waves-light" href="#!">Consultas</a></li>-->
                </ul>
            <!-- END LEFT SIDEBAR NAV-->


            <!-- START CONTENT -->
            <section id="content">

                <!--breadcrumbs start-->
                <div id="breadcrumbs-wrapper">
                    <!-- Search for small screen -->
                    <div class="header-search-wrapper grey hide-on-large-only">
                        <i class="material-icons active">search</i>
                        <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Buscar Beneficiario">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <!--<h5 class="breadcrumbs-title">Blank Page</h5>-->
                                <ol class="breadcrumbs">
                                    <li><a>Créditos</a></li>
                                    <li class="active" id="breadcrum-title">Creación de Grupos</li>
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
    
    <script type="text/javascript" src="../js/plugins/select2/select2.full.min.js"></script>
    
    <script type="text/javascript" src="../js/jquery.form.js"></script>
    <script src="http://listjs.com/assets/javascripts/list.min.js"></script>
    <script src="../js/plugins/list/list.1.5.0.min.js"></script>
    <!--<script src="http://listjs.com/assets/javascripts/list.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.pagination.js/0.1.1/list.pagination.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.fuzzysearch.js/0.1.0/list.fuzzysearch.js"></script>-->
    <script src="../js/plugins/sweetalert-master/dist/sweetalert.min.js"></script>
    <script src="../js/plugins/data-change/data-change.js"></script>
    <script src="../js/plugins/cookie-manager/cookie-manager.js"></script>
    <script src="../js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
    
        $(document).ready(function(){
            $('#btn-menu-usuario').sideNav({
                menuWidth: 300,
                edge: 'left',
                closeOnClick: false,
                draggable: true
            });
            
            //Cargar la primera ventana al inicio
            
            $('#floating-refresh').click(function(){
                $('#'+window.idbtnmenuactivo).trigger('refresh');
            });
            
            $('#main-container').load('ingresar-grupo.php', function(){
                $('#loading').hide();
            });
        
        });
        
    </script>

</body>

</html>