<?php 

$array = explode("/",$_SERVER['PHP_SELF']);
$self = explode(".", end($array))[0];
$directory = $array[count($array) - 2];

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
    <title>Reportes</title>

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
    <!-- Material-icons-->
    <link href="../fonts/material-icons/material-icons.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="../js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="../js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!--<link href="../js/plugins/chartist-../js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">-->
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
                <div class="nav-wrapper">
                    <ul class="left">
                        <li>
                            <h1 class="logo-wrapper">
                      <a href="" class="brand-logo darken-1">
                      <object type="image/svg+xml" data="../images/logocredito.svg"></object>
                      </a> <span class="logo-text">Credito Solidario</span></h1>
                        </li>
                    </ul>
                    <!--<ul id="dropdown1" class="dropdown-content">
                        <li><a href="#!">one</a></li>
                        <li><a href="#!">two</a></li>
                        <li class="divider"></li>
                        <li><a href="#!">three</a></li>
                    </ul>-->
                    <ul class="right hide-on-med-and-down">
                        <li><a class="perfil-on-nav-button" href="#!" data-activates="perfil-on-nav">John Doe<i class="material-icons right">arrow_drop_down</i></a></li>
                        <!--<li class="waves-effect waves-light"><a href="">Sass</a></li>
                        <li class="waves-effect waves-light"><a href="">Components</a></li>-->
                        <!-- Dropdown Trigger -->

                    </ul>
                    <!--<ul class="right hide-on-med-and-down">
                        <li style="margin-right: 75px;">
                            <a href="javascript:void(0);"
                               class="waves-effect waves-block waves-light perfil-on-nav-button"
                               data-activates="perfil-on-nav">
                                <i class="mdi-action-face-unlock"></i>
                                <span>Perfil</span>
                                </a>
                        </li>
                    </ul>-->
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
                <ul id="slide-out" class="side-nav fixed leftside-navigation">
                    <li>
                        <div class="userView">
                            <div class="background">
                                <img class="responsive-img" src="../images/2b.jpg">
                            </div>
                            <a href="#!user"><img class="circle" src="../images/user.png"></a>
                            <a href="#!name" class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" data-activates="profile-dropdown"><i class="material-icons right white-text">arrow_drop_down</i><span class="white-text name">John Doe</span></a>
                            <a href="#!email"><span class="white-text email">johndoe@creditosolidario.hn</span></a>
                            <ul id="profile-dropdown" class="dropdown-content">
                                <li><a href="#"><i class="material-icons">face</i> Perfil</a>
                                </li>
                                <li><a href="#"><i class="material-icons">account_circle</i> Cuenta</a>
                                </li>
                                <li><a href="#"><i class="material-icons">help</i> Ayuda</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="material-icons">keyboard_backspace</i> Salir</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- <li><a href="#!" class="waves-effect waves-light"><i class="material-icons">cloud</i>First Link With Icon</a></li>
                    <li><a href="#!" class="waves-effect waves-light">Second Link</a></li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li class="bold">
                                <a class="collapsible-header waves-effect waves-light">
                                    <i class="material-icons">collections</i> Menejar Imagenes</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a onclick="hideMenuOnClick()" href="#"> Albumes</a>
                                        </li>
                                        <li><a onclick="hideMenuOnClick()" href="#"> Galeria</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li class="bold">
                                <a class="collapsible-header waves-effect waves-light">
                                    <i class="material-icons">collections</i> Menejar Imagenes</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a onclick="hideMenuOnClick()" href="#"> Albumes</a>
                                        </li>
                                        <li><a onclick="hideMenuOnClick()" href="#"> Galeria</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li class="bold">
                                <a class="collapsible-header waves-effect waves-light">
                                    <i class="material-icons">collections</i> Menejar Imagenes</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a onclick="hideMenuOnClick()" href="#"> Albumes</a>
                                        </li>
                                        <li><a onclick="hideMenuOnClick()" href="#"> Galeria</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>-->

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li class="bold">
                                <a class="collapsible-header <?php if($directory == "reportes") echo "active"; ?> waves-effect waves-light">
                                    <i class="material-icons">collections</i> Reportes</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li <?php if($self == "index") echo 'class="active"'; ?>><a onclick="hideMenuOnClick()" href="index.php"> Contabilidad</a>
                                        </li>
                                        <li <?php if($self == "mora") echo 'class="active"'; ?>><a onclick="hideMenuOnClick()" href="mora.php"> Mora</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                    <li><a class="subheader">Enlaces</a></li>
                    <li><a class="waves-effect waves-light" href="#!">Página web</a></li>
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
                    <div class="header-search-wrapper grey hide-on-large-only">
                        <i class="material-icons active">search</i>
                        <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <!--<h5 class="breadcrumbs-title">Blank Page</h5>-->
                                <ol class="breadcrumbs">
                                    <li><a href="index.html">Inicio</a></li>
                                    <li><a href="#">Paginas</a></li>
                                    <li class="active">Pagina en blanco</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs end-->


                <!--start container-->
                <div class="container">
                    <div class="section">