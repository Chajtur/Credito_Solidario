<?php
session_start();
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
    <title>Consultas - Crédito Solidario</title>

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
    <!--Sweet Alert-->
    <link rel="stylesheet" href="../js/plugins/sweetalert-master/dist/sweetalert.css">
    <link rel="stylesheet" href="../js/plugins/sweetalert-master/themes/google/google.css">
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
                    </div>
                    <div class="left search col s6 hide-on-med-and-down">
                        <div class="input-field">
                            <input id="search" type="search" placeholder="Busque un Beneficiario" autocomplete="off">
                            <label for="search"><i class="material-icons search-icon">search</i></label>
                            <!--<i class="material-icons">close</i>
                            <a href="#" onClick="limpiarfields();" class="close-search"><i class="material-icons clear-icon">close</i></a>
                        </div>

                    </div>-->
                    <form id="consultar" class="left search col s6 m6 l6 hide-on-med-and-down">
                        <div class="input-field">
                            <input id="search" type="search" placeholder="Realice una búsqueda" autocomplete="off">
                            <label for="search"><i class="material-icons search-icon">search</i></label>
                            <!--<i class="material-icons">close</i>-->
                            <a href="#!" onClick="limpiarfields();" class="close-search"><i class="material-icons clear-icon">close</i></a>
                        </div>
                        <div class="input-field">
                            <input type="checkbox" id="test5"/>
                            <label for="test5">Red</label>
                        </div>
                    </form>
                    <!--<div class="left col s8 hide-on-med-and-down">
                        <h4 style="font-weight: 200;">| Consultas</h4>
                    </div>-->
                    
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

        <!-- START OVERLAY LOGIN  -->
        <div class="overlay-login-container">

            <div class="overlay-login-body">
                <div class="overlay-login-content">
                    <div id="login-page" class="row">
                        <div class="col s12 z-depth-4 card-panel wow slideInLeft" data-wow-duration="2s" data-position="bottom" data-delay="50" data-tooltip="Debe iniciar sesión para poder consultar en el Sistema">
                            <form class="login-form" method="post" id="loginform">
                                <div class="row">
                                    <div class="input-field col s12 center">
                                        <img src="../images/soloLogo.svg" alt="" class=" responsive-img valign profile-image-login">
                                        <!-- <p class="center login-form-text">Iniciar Sesión</p> -->
                                    </div>
                                </div>
                                <div class="row margin">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix grey-text">account_circle</i>
                                        <input id="txtusuario" type="text" name="user" class="validate" required>
                                        <label for="username">Nombre de Usuario</label>
                                    </div>
                                </div>
                                <div class="row margin">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix grey-text">lock</i>
                                        <input id="txtpass" type="password" name="pass" class="validate" required>
                                        <label for="password">Contraseña</label>
                                    </div>
                                </div>
                                <!--<div class="row">
                                    <div class="input-field col s12 m12 l12  login-text">
                                        <input type="checkbox" id="remember-me" />
                                        <label for="remember-me">Recordarme</label>
                                    </div>
                                </div>-->
                                <div class="row">
                                    <div class="input-field col s12">
                                        <!--<input type="submit" value="Enviar">-->
                                        <button type="submit" class="btn waves-effect waves-light col s12" id="btnlogin">Iniciar Sesión</button>
                                        <br><br>
                                        <p class="grey-text"><i class="material-icons yellow-text">warning</i> <br>Ahora debe Iniciar Sesión para realizar consultas en el Sistema.
                                        </p>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            

        </div>
        <!-- END OVERLAY LOGIN  -->

        <!-- START WRAPPER -->
        <div class="wrapper">

            <!-- START LEFT SIDEBAR NAV-->
            <aside id="left-sidebar-nav">
                <ul id="slide-out" class="side-nav fixed leftside-navigation">
                    <li>
                        <div class="userView no-padding">
                            <div class="card no-margin no-border-radius indigo darken-4 white-text center z-depth-0 center with-background">
                                <!--<i class="material-icons medium">dvr</i>-->
                                <div class="card-content">
                                    <?php if(isset($_SESSION['email'], $_SESSION['gender'], $_SESSION['first_name'], $_SESSION['last_name'], $_SESSION['user'], $_SESSION['pass'], $_SESSION['agencia'])):?>
                                        <!-- <a href="#!user"><img class="circle" src="../images/<?php echo ($_SESSION['gender'] == 'F' ? "user-girl" : "user");?>.png"></a> -->
                                        <a href="#!name" class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" data-activates="profile-dropdown"><i class="material-icons right white-text">arrow_drop_down</i><span class="white-text name"><?php echo $_SESSION['first_name']." ".$_SESSION['last_name'];?></span></a>
                                        <a href="#!email"><span class="white-text email truncate"><?php echo $_SESSION['email'];?></span></a>
                                        <ul id="profile-dropdown" class="dropdown-content">
                                            <!-- <li class="menu-btn" data-change="../common/cuenta.php"><a href="#" class="waves-effect waves-light"><i class="material-icons">account_circle</i> Cuenta</a></li>
                                            <li><a href="#"><i class="material-icons">help</i> Ayuda</a></li>
                                            <li class="divider"></li> -->
                                            <li><a href="../php/logout.php"><i class="material-icons">keyboard_backspace</i> Salir</a>
                                            </li>
                                        </ul>
                                    <?php else:?>
                                    <i class="material-icons large">account_circle</i>
                                    <?php endif;?>
                                    <a class="waves-effect waves-light btn green no-margin" href="../login.php">Ingresar</a>
                                </div>
                            </div>
                            <!--<div class="background">
                                <img class="responsive-img" src="../images/2b.jpg">
                            </div>
                            <br><br><br>-->
                        </div>
                    </li>
                    <li id="menu-btn-general" class="menu-btn menu-btn-active" data-change="previo-general.php"><a class="waves-effect waves-light"><i class="material-icons">bookmark</i>Consulta General</a></li>
                    <li id="menu-btn-censo" class="menu-btn" data-change="previo-censo.php"><a class="waves-effect waves-light"><i class="material-icons">person</i>Consulta al Censo</a></li>
                    
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


            <!-- START CONTENT -->
            <section id="content">

                <!--breadcrumbs start-->
                <div id="breadcrumbs-wrapper">
                    <!-- Search for small screen -->
                    <div class="header-search-wrapper grey hide-on-large-only">
                        <i class="material-icons active">search</i>
                        <form id="consultar-movil">
                            <input type="search" id="search" class="header-search-input z-depth-2" placeholder="Buscar Beneficiario">
                        </form>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <!--<h5 class="breadcrumbs-title">Blank Page</h5>-->
                                <ol class="breadcrumbs">
                                    <li><a>Consultas</a></li>
                                    <li class="active" id="breadcrum-title">Consulta General</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs end-->

                <!--start container-->
                <div class="container" id="main-container">
                    
                    <!-- 
                    
                    Aqui va el contenido dinámico
                    
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

    <?php require "../common/footer.php";?>

    <!--
    =====================================================
    Scripts
    =====================================================
    -->

    <!-- jQuery Library -->
    <script type="text/javascript" src="../js/plugins/jquery-2.2.4.min.js"></script>
    <!--materialize js-->
    <script src="../js/plugins/jquery-ui/jquery-ui.min.js"></script>
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
    
    <script src="http://listjs.com/assets/javascripts/list.min.js"></script>
    <script src="../js/plugins/list/list.1.5.0.min.js"></script>
    
    <script src="../js/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="../js/plugins/data-change/data-change.js"></script>
    <script src="../js/plugins/cookie-manager/cookie-manager.js"></script>
    <script src="../js/plugins/jquery.redirect.js/jquery.redirect.js"></script>
    <script>
    
    $(document).ready(init);

    function init(){

        <?php if(!isset($_SESSION['email'], $_SESSION['gender'], $_SESSION['first_name'], $_SESSION['last_name'], $_SESSION['user'], $_SESSION['pass'], $_SESSION['agencia'])):?>
        inicializarOverlayLogin();
        $('#search').prop('disabled', true);
        <?php endif;?>
        // Eventos
        $('#floating-refresh').click(refrescarSeccion);
        $('#loginform').submit(loguearUsuario);
        $('#consultar, #consultar-movil').submit(consultarClave);
        
        $('#main-container').load('previo-general.php', function(){
            $('#loading').hide();
        });
        
        window.current = "general";

    }

    function consultarClave(e){
            
        $('#consultar-movil').blur();
        if($(this).find('#search').val() == ""){
            
            swal({
                title: '<center>Busqueda vacía</center>',
                text: 'No ha escrito nada en el campo de busqueda.',
                type: "warning",
                html: true
            });
            
            return false;
        }
        
        var thisaux = $(this);
        
        $('#main-container').fadeOut(100, function(){
            
            $('#loading').fadeIn(100, function(){
                $.ajax({
                    type: 'POST',
                    data: 'consulta='+window.current+'&parametro='+thisaux.find('#search').val(),
                    url: 'backend-consulta-nueva.php',
                    success: function(data){
                        
                        $('#main-container').load(window.current+'.php', { data: data }, function(){
                            $('#loading').fadeOut(100, function(){
                                $('#main-container').fadeIn(100);
                            });
                        });

                    }
                });
            });
            
        });
        
        return false;
        
    }

    function cargarOverlayLogin(){

    }

    function refrescarSeccion(){
        $('#'+window.idbtnmenuactivo).trigger('refresh');
    }
    
    function loguearUsuario(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '../php/login.php',
            data: {
                user: $('#txtusuario').val(),
                pass: $('#txtpass').val()
            },
            success: function(data){
                if(data == 'true'){
                    window.location.reload();
                }else{
                    Materialize.toast(data);
                }
            }
        });
    }

    function inicializarOverlayLogin(){
        $('.overlay-login-container').css('display', 'inline');
    }

    </script>

</body>

</html>