<?php //require '../php/auth.php'; ?>

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
        <link rel="stylesheet" href="../css/plugins/select2/select2.min.css">
        <link rel="stylesheet" href="../css/plugins/select2/select2.materialize.css">
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
        <div id="main">
            <!-- INICIO WRAPPER -->
            <div class="wrapper">
                <!-- INICIO SIDEBAR -->
                <aside id="left-sidebar-nav">
                    <ul class="side-nav fixed leftside-navigation">
                        <?php require "../common/left-side-menu.php";?>
                        <li class="menu-btn menu-btn-active">
                            <a href="#" class="waves-effect waves-light">
                                <i class="material-icons">add_box</i>Noticias
                            </a>
                        </li>
                    </ul>
                </aside>
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
                                        <li><a href="index.html">Mercadeo</a></li>
                                        <li  class="active" id="breadcrum-title">Noticias</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FIN DE BREADCRUMBS -->

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
        </div>
        <!-- FIN DE MAIN -->

        <div class="fixed-action-btn">
            <a class="btn-floating btn-large indigo darken-3" id="floating-refresh">
                <i class="large material-icons">build</i>
            </a>
            <ul>
                <li><a href="" id="agregar-noticia" class="btn-floating teal lighten-2"><i class="material-icons">add</i></a></li>
                <li><a href="" id="refrescar-noticias" class="btn-floating green lighten-2"><i class="material-icons">refresh</i></a></li>
            </ul>
        </div>

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
        <script type="text/javascript" src="../js/materialize.js"></script>
        <script src="../js/plugins/select2/select2.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#floating-refresh').click(function(){
                    $('#'+window.idbtnmenuactivo).trigger('refresh');
                });
                
                $('#main-container').load('listaNoticias.php', function(){
                    $('#loading').hide();
                });

                $('#agregar-noticia').click(function (evt) {
                    $('#main-container').load('edicionNoticia.php', function(){
                        $('#loading').hide();
                    });

                    evt.preventDefault();
                });

                $('#refrescar-noticias').click(function (evt) {
                    $('#main-container').load('listaNoticias.php', function(){
                        $('#loading').hide();
                    });

                    evt.preventDefault();
                });
            });

            function obtenerNoticias() {
                var noticiasContainer = $('#grilla-noticias');
                
                /*$.ajax({
                    type: 'GET',
                    url: '../mercadeo/index.php?accion=listar',
                    dataType: 'JSON',
                    success: function (data) {
                        $.each(data, function (i, noticia) {
                            noticiasContainer.append(
                                '<div class="col s12 m4">',
                                    '<div class="card">',
                                        '<div class="card-image">',
                                            '<img src="" alt="">',
                                            '<span class="card-title">'+ noticia.titulo +'</span>',
                                        '</div>',
                                        '<div class="card-content">'+ noticia.resumen +'</div>',
                                        '<div class="card-action">',
                                            '<a href="#"><i class="material-icons">create</i></a>',
                                        '</div>',
                                    '</div>',
                                '</div>'
                            );
                        });
                    },
                    error: function(xhr, status, error) {

                    }
                });*/
            }
        </script>

    </body>
</html>