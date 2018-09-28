<?php 
    //require '../php/auth.php';
    if (isset($_GET['accion'])) {
        $accion = $_GET['accion'];
    }

    if (isset($_GET['noticiaId'])) {
        $noticiaId = $_GET['noticiaId'];
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

        <title>Noticias - Crédito Solidario</title>
    </head>
    <body>
        <!-- INICIO INDICADOR PÁGINA CARGANDO -->
        <!-- FIN INDICADOR PÁGINA CARGANDO -->

        <!-- INICIO HEADER -->
        <header class="page-topbar" id="header">
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
                        <div class="left col s8 hide-on-med-and-down">
                            <h4 style="font-weight: 200;">| MERCADEO</h4>
                        </div>                        
                        <ul class="right hide-on-med-and-down col s2 nav-right-menu">
                            <li>
                                <a href="#" class="brand-logo right logo2"><img src="../images/logo-presidencia.png" alt=""></a>
                            </li>
                        </ul>
                        <div class="col col s8 m8 l8">
                            <ul id="perfil-on-nav" class="dropdown-content">
                                <li>
                                    <a href="#"><i class="material-icons">face</i>
                                        <span class="option-user-select">Perfil</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><i class="material-icons">account_circle</i>
                                        <span class="option-user-select">Cuenta</span>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#"><i class="material-icons">home</i>
                                        <span class="option-user-select">Salir</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- FIN HEADER -->

        <!-- INICIO DE MAIN -->
        <div>
            <!-- INICIO WRAPPER -->
            
                <!-- INICIO SIDEBAR -->
                
                    <ul id="mobile-demo" class="side-nav">
                        <?php require "../common/left-side-menu.php";?>
                        <li><a href="#">Inicio</a></li>
                        <li class="no-padding">
                            <ul class="collapsible" data-collapsible="accordion">
                                <li>
                                    <a href="#!" class="collapsible-header"><i class="material-icons">add_box</i>Noticias</a>                                    
                                    <ul id="menu-noticias" class="collapsible-body">
                                        <li><a class="waves-effect menu-button sidenav-button" id="btn-nueva-noticia" href="#!">Nueva</a></li>
                                        <li><a class="waves-effect menu-button sidenav-button" id="btn-lista-noticia" href="#!">Listar</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#!" class="collapsible-header"><i class="material-icons">add_box</i>Departamentos</a>                                    
                                    <ul id="menu-departamentos" class="collapsible-body">
                                        <li><a class="waves-effect menu-button sidenav-button" id="btn-lista-departamento" href="#!">Listar</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#!" class="collapsible-header"><i class="material-icons">add_box</i>Banco de imagenes</a>                                    
                                    <ul id="menu-banco-imagenes" class="collapsible-body">
                                        <li><a class="waves-effect menu-button sidenav-button" id="btn-lista-banco-imagenes" href="#!">Listar</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#!" class="collapsible-header"><i class="material-icons">add_box</i>Carrusel</a>                                    
                                    <ul id="menu-carrusel" class="collapsible-body">
                                        <li><a class="waves-effect menu-button sidenav-button" id="btn-carrusel" href="#!">Listar</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#!" class="collapsible-header"><i class="material-icons">add_box</i>Productos</a>                                    
                                    <ul id="menu-programa" class="collapsible-body">
                                        <li><a class="waves-effect menu-button sidenav-button" id="btn-programa" href="#!">Listar</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#!" class="collapsible-header"><i class="material-icons">add_box</i>Director</a>                                    
                                    <ul id="menu-director" class="collapsible-body">
                                        <li><a class="waves-effect menu-button sidenav-button" id="btn-director" href="#!">Editar</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#!" class="collapsible-header"><i class="material-icons">add_box</i>Familia</a>
                                    <ul id="menu-familia" class="collapsible-body">
                                    <li><a class="waves-effect menu-button sidenav-button" id="btn-familia" href="#!">Gestionar</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#!" class="collapsible-header"><i class="material-icons">add_box</i>Videos</a>                                    
                                    <ul id="menu-videos" class="collapsible-body">
                                        <li><a class="waves-effect menu-button sidenav-button" id="btn-videos" href="#!">Listar</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <!-- FIN SIDEBAR -->
            <!-- FIN WRAPPER -->

                <!-- INICIO CONTENT -->
                <section id="content">
                    <!-- INICIO DE BREADCRUMBS -->
                    <div class="breadcrumbs-wrapper">
                        <div class="header-search-wrapper grey hide-on-large-only">
                            <i class="material-icons active">search</i>
                            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Buscar Beneficiario">
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <ol class="breadcrumbs">
                                        <li><a href="index.php">Mercadeo</a></li>
                                        <li  class="active" id="breadcrum-title">Noticias</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FIN DE BREADCRUMBS -->
                    <input type="hidden" name="accion" id="accion" value="<?php echo isset($accion) ? $accion : '' ?>">
                    <input type="hidden" name="noticiaId" id="noticiaId" value="<?php echo isset($noticiaId) ? $noticiaId : '' ?>">

                    <div class="container" id="main-container"></div>

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
                <!-- FIN CONTENT -->
            
        </div>
        <!-- FIN DE MAIN -->
        

        <?php require "../common/footer.php";?>

        <!-- jQuery Library -->
        <script type="text/javascript" src="../js/plugins/jquery-3.3.1.min.js"></script>
        <!--materialize js-->
        <!--prism
        <script type="text/javascript" src="js/prism/prism.js"></script>-->
        <!--scrollbar-->
        <script type="text/javascript" src="../js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

        <!--custom-script.js - Add your own theme custom JS-->
        <!-- <script src="../js/custom-script.js"></script> --> 

        <!--plugins.js - Some Specific JS codes for Plugin Settings-->
        <script type="text/javascript" src="../js/plugins.js"></script>
        
        <script type="text/javascript" src="../js/jquery.form.js"></script>
        
        <script src="http://listjs.com/assets/javascripts/list.min.js"></script>
        <script src="../js/plugins/list/list.1.5.0.min.js"></script>
        
        <script src="../js/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
        <script src="../js/plugins/data-change/data-change.js"></script>
        <script src="../js/plugins/cookie-manager/cookie-manager.js"></script>
        <script src="../js/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/materialize.min.js"></script>
        <script src="../js/plugins/select2/select2.min.js"></script>
        <script src="../js/materialize.clockpicker.js"></script>

        <script>
            $(document).ready(function () {
                $('#btn-menu-usuario').sideNav({
                    menuWidth: 300,
                    edge: 'left',
                    closeOnClick: false,
                    draggable: true
                });

                let accion = $('#accion').val();
                let noticiaId = $('#noticiaId').val();

                if (accion == 'editar') {
                    $('#main-container').load('edicionNoticia.php?noticiaId=' + noticiaId, function(){
                        $('#loading').hide();
                    });
                } else {
                    $('#main-container').load('listaNoticias.php', function(){
                        $('#loading').hide();
                    });
                }

                $('#floating-refresh').click(function(){
                    $('#'+window.idbtnmenuactivo).trigger('refresh');
                });

                $('#btn-nueva-noticia').click(function (evt) {
                    $('#main-container').load('nuevaNoticia.php', function(){
                        $('#loading').hide();
                    });

                    evt.preventDefault();
                });

                $('#btn-lista-noticia').click(function (evt) {
                    $('#loading').show();
                    $('#main-container').load('listaNoticias.php', function () {
                        $('#loading').hide();
                    });
                    evt.preventDefault();
                });

                $('#btn-lista-departamento').click(function (evt) {
                    $('#loading').show();
                    $('#main-container').load('listaImagenesDepartamentos.php', function () {
                        $('#loading').hide();
                    });
                    evt.preventDefault();
                });

                $('#btn-lista-banco-imagenes').click(function (evt) {
                    $('#loading').show();
                    $('#main-container').load('bancoImagenes.php', function () {
                        $('#loading').hide();
                    });
                    evt.preventDefault();
                });

                $('#btn-carrusel').click(function (evt) {
                    $('#loading').show();
                    $('#main-container').load('carrusel.php', function () {
                        $('#loading').hide();
                    });
                    evt.preventDefault();
                });

                $('#btn-programa').click(function (evt) {
                    $('#loading').show();
                    $('#main-container').load('programas.php', function () {
                        $('#loading').hide();
                    });
                    evt.preventDefault();
                });

                $('#btn-director').click(function (evt) {
                    $('#loading').show();
                    $('#main-container').load('director.php', function () {
                        $('#loading').hide();
                    });
                    evt.preventDefault();
                });

                $('#btn-familia').click(function (evt) {
                    $('#loading').show();
                    $('#main-container').load('personal.php', function () {
                        $('#loading').hide();
                    });
                    evt.preventDefault();
                });

                $('#btn-videos').click(function (evt) {
                    $('#loading').show();
                    $('#main-container').load('videos.php', function () {
                        $('#loading').hide();
                    });
                    evt.preventDefault();
                });
            });
        </script>

    </body>
</html>