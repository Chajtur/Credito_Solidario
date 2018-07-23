<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="credito solidario, banca solidaria, credito joven, banca, solidaria, honduras">
    <meta name="keywords" content="credito solidario, banca solidaria, credito joven, banca, solidaria, honduras">
    <title>Editar Grupo</title>

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
                    <div class="left search col s6 hide-on-med-and-down">
                        <div class="input-field">
                            <input id="search" type="search" placeholder="Busque un Beneficiario" autocomplete="off">
                            <label for="search"><i class="material-icons search-icon">search</i></label>
                            <!--<i class="material-icons">close</i>-->
                            <a href="#" onClick="limpiarfields();" class="close-search"><i class="material-icons clear-icon">close</i></a>
                        </div>

                    </div>
                    <ul class="right hide-on-med-and-down col s3 nav-right-menu">
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
                <ul id="slide-out" class="side-nav fixed leftside-navigation">
                    <li>
                        <div class="userView">
                            <div class="background">
                                <img class="responsive-img" src="../images/2b.jpg">
                            </div>
                            <a href="#!user"><img class="circle" src="../images/user-girl.png"></a>
                            <a href="#!name" class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" data-activates="profile-dropdown"><i class="material-icons right white-text">arrow_drop_down</i><span class="white-text name">María Amador</span></a>
                            <a href="#!email"><span class="white-text email">maria@creditosolidario.hn</span></a>
                            <ul id="profile-dropdown" class="dropdown-content">
                                <li><a href="#"><i class="material-icons">face</i> Perfil</a>
                                </li>
                                <li><a href="#"><i class="material-icons">account_circle</i> Cuenta</a>
                                </li>
                                <li><a href="#"><i class="material-icons">help</i> Ayuda</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="../php/logout.php"><i class="material-icons">keyboard_backspace</i> Salir</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="index.php" class="waves-effect waves-light"><i class="material-icons">add_box</i>Creación de Grupos</a></li>
                    <li><a href="#!" class="waves-effect waves-light"><i class="material-icons">edit</i>Editar Grupos</a></li>
                    <li><a href="lista-grupos.html" class="waves-effect waves-light"><i class="material-icons">list</i>Lista de Grupos</a></li>
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li class="bold">
                                <a class="collapsible-header waves-effect waves-light">
                                    <i class="material-icons">call_missed</i> Créditos Devueltos</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a onclick="hideMenuOnClick()" href="#"> Call-Center</a>
                                        </li>
                                        <li><a onclick="hideMenuOnClick()" href="#"> Control de Calidad</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <div class="divider"></div>
                    </li>
                    <li><a class="subheader">Subheader</a></li>
                    <li><a class="waves-effect waves-light" href="#!">Consultas</a></li>
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
                        <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Buscar Beneficiario">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <!--<h5 class="breadcrumbs-title">Blank Page</h5>-->
                                <ol class="breadcrumbs">
                                    <li><a href="index.php">Creación de Grupos</a></li>
                                    <li class="active">Editar Grupos</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs end-->


                <!--start container-->
                <div class="container">
                    <div class="section">
                       <div class="row">
                           <div class="col s12 m8 l6 offset-m2 offset-l3">
                               <div class="card">
                                    <div class="card-content">
                                        <span class="card-title">
                                            <div class="row">
                                                <div class="col l8">Editar Grupo: </div>
                                                <div class="col l4">
                                                    <input id="buscarHas" type="text" class="validate" placeholder="código de Grupo">
                                                </div>
                                            </div>
                                        </span>
                                        <form>
                                            <div class="row">
                                                <div class="input-field col s6">
                                                    <select>
                                                      <option value="" disabled selected>Seleccionar Asesor</option>
                                                      <option value="1">Alexander</option>
                                                      <option value="2">Claudia</option>
                                                      <option value="3">Ana Ucles</option>
                                                      <option value="4">Alvaro</option>
                                                      <option value="5">Gloria</option>
                                                      <option value="6">Dolores</option>
                                                      <option value="7">Donald</option>
                                                    </select>
                                                    <label>Seleccione un Asesor</label>
                                                </div>
                                                <div class="input-field col s6">
                                                    <input id="plazo" type="text" class="validate">
                                                    <label for="plazo">Nombre del Grupo</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s6">
                                                    <input id="programa" type="text" class="validate">
                                                    <label for="programa">Id Beneficiario 1</label>
                                                </div>
                                                <div class="input-field col s6">
                                                    <input disabled  id="Taza" type="text" class="validate">
                                                    <label for="Taza">Nombre Beneficiario 1</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s6">
                                                    <input id="programa" type="text" class="validate">
                                                    <label for="programa">Id Beneficiario 2</label>
                                                </div>
                                                <div class="input-field col s6">
                                                    <input disabled  id="Taza" type="text" class="validate">
                                                    <label for="Taza">Nombre Beneficiario 2</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s6">
                                                    <input id="programa" type="text" class="validate">
                                                    <label for="programa">Id Beneficiario 3</label>
                                                </div>
                                                <div class="input-field col s6">
                                                    <input disabled  id="Taza" type="text" class="validate">
                                                    <label for="Taza">Nombre Beneficiario 3</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s6">
                                                    <input id="programa" type="text" class="validate">
                                                    <label for="programa">Id Beneficiario 4</label>
                                                </div>
                                                <div class="input-field col s6">
                                                    <input disabled  id="Taza" type="text" class="validate">
                                                    <label for="Taza">Nombre Beneficiario 4</label>
                                                </div>
                                            </div>
                                            <div class="row margin">
                                                <div class="input-field col s6 offset-s3">
                                                    <a href="#" data-target="modal1" class="btn waves-effect waves-light col s12">Guardar</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                           </div>
                       </div>
                        
                    </div>
                    <!-- Floating Action Button -->
                    <div class="fixed-action-btn toolbar">
                        <a class="btn-floating btn-large red waves-effect waves-light">
                            <i class="large material-icons">mode_edit</i>
                        </a>
                        <ul>
                            <li class="waves-effect waves-light"><a href="#!"><i class="material-icons">insert_chart</i></a></li>
                            <li class="waves-effect waves-light"><a href="#!"><i class="material-icons">format_quote</i></a></li>
                            <li class="waves-effect waves-light"><a href="#!"><i class="material-icons">publish</i></a></li>
                            <li class="waves-effect waves-light"><a href="#!"><i class="material-icons">attach_file</i></a></li>
                        </ul>
                    </div>
                    <!-- Floating Action Button -->
                    
                    <!--MODAL PARA HASH DE GRUPO-->
                        <!-- Modal Structure -->
                          <div id="modal1" class="modal">
                            <div class="modal-content">
                              <h4 class="red-text">#¿Esta seguro de editar este grupo?</h4>
                              <p>¡Al presionar el botón aceptar se editará el grupo: <span>457898</span></p>
                            </div>
                            <div class="modal-footer">
                              <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
                            </div>
                          </div>
                    <!--MODAL PARA HASH DE GRUPO-->
                </div>
                <!--end container-->
            </section>
            <!-- END CONTENT -->


        </div>
        <!-- END WRAPPER -->

    </div>
    <!-- END MAIN -->


    <!-- START FOOTER -->
    <footer class="page-footer">
        <div class="footer-copyright">
            <div class="container">
                <span>Copyright © 2016 <a class="grey-text text-lighten-4" href="#" target="_blank">Credito Solidario</a> All rights reserved.</span>
                <span class="right"> Desarrollado por <a class="grey-text text-lighten-4" href="#">Credito Solidario</a></span>
            </div>
        </div>
    </footer>
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


</body>

</html>