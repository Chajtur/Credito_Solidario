<?php
/*require '../php/auth.php';*/
try{
    
    require "../php/conection.php";
    $stat = $conn->prepare('select idgestor, nombre from gestor order by nombre');
    $stat->execute();
    $gestores = $stat->fetchAll();
}catch(PDOException $e){
    //header('Location: index.php');
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
        <title>Lista de Grupos Devueltos</title>

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
        <!--fa fa fonts-->
        <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!-- Material-icons-->
        <link href="../fonts/material-icons/material-icons.css" type="text/css" rel="stylesheet" media="screen,projection">

        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
        <!-- <link href="../js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        <link href="../js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
        <!--<link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">-->

        <!--Sweet Alert-->
        <link rel="stylesheet" href="../js/plugins/sweetalert-master/dist/sweetalert.css">
        <link rel="stylesheet" href="../js/plugins/sweetalert-master/themes/google/google.css">

        <!--<link rel="stylesheet" href="../js/plugins/candle-switch/css/candlestick.css">
    <link rel="stylesheet" href="../js/plugins/candle-switch/css/candlestick-maerial.css">-->

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
                                <input id="search" type="search" placeholder="Realice una Consulta" autocomplete="off">
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
                                <a href="#!user"><img class="circle" src="../images/user.png"></a>
                                <a href="#!name" class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" data-activates="profile-dropdown"><i class="material-icons right white-text">arrow_drop_down</i><span class="white-text name">Nombre Apellido</span></a>
                                <a href="#!email"><span class="white-text email truncate">user@creditosolidario.hn</span></a>
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

                        <li id="menu-btn-recepcion" class="menu-btn menu-btn-active" data-change="recepcion.php"><a class="waves-effect waves-light"><i class="material-icons">add_box</i>Dashboard</a></li>
                        <li id="menu-btn-verificar" class="menu-btn" data-change="por-verificar.php"><a class="waves-effect waves-light"><i class="material-icons">list</i>Visitas</a></li>

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
                            <input type="text" name="personas[]" id="id_visitado" class="header-search-input z-depth-2" maxlength="15" placeholder="Identidad" required data-inputmask="'mask': '9999-9999-99999'">
                            <!-- <input placeholder="Identidad" name="personas[]" id="id_visitado" type="text" class="validate masked buscarcenso" maxlength="15" required data-inputmask="'mask': '9999-9999-99999'"> -->
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <!--<h5 class="breadcrumbs-title">Blank Page</h5>-->
                                    <ol class="breadcrumbs">
                                        <li><a href="index.html">Inicio</a></li>
                                        <li><a href="#">Asesores</a></li>
                                        <li class="active">Visitas</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--breadcrumbs end-->

                    <!--<div class="container center" id="loading">
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
                </div>-->


                    <!--start container-->
                    <div class="container" id="main-container">
                        <div class="section" id="search-section">
                            <div class="row">
                                <div class="col s12 m8 offset-m2 l8 offset-l2">
                                    <div class="">
                                        <div class="">
                                            <div class="center-align">
                                                <span><i class="material-icons large grey-text" id="search-icon">search</i></span>
                                                <span><i class="material-icons large blue-text" id="searching-icon">autorenew</i></span>
                                                <h4 id="nueva-consulta" class="grey-text text-darken-3">Lista Vacía</h4>
                                                <h6 id="nueva-consulta2" class="grey-text text-darken-2">No ha realizdo ninguna consulta, si desea realizar una busqueda...</h6>
                                                <h6 id="presione-aqui" class="grey-text text-darken-2"> <a href="#!">Presione aquí. </a></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section" id="main-section">
                            <div class="row">
                                <div class="col s12 m12 l4">
                                    <div id="flight-card" class="card">
                                        <div class="card-header blue darken-3">
                                            <div class="card-title  right-align">
                                                <h4 id="titulo-carta" class="flight-card-title">Visita</h4>
                                                <p id="ultima-visita" class="flight-card-date">Ult. Visita 22 Febrero - 03:50 pm</p>
                                                <p id="gestor-visitador" class="flight-card-date">Por: María Velasquez</p>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <img id="user-type-img" src="../images/user-girl.png" alt="persona" class="z-depth-1 right circle responsive-img circle-image-in-card">

                                            <span id="nombre" class="card-title truncate tooltipped" data-position="top" data-delay="50" data-tooltip="">María Eugenia López</span>

                                            <p><i class="material-icons left">credit_card</i><span id="identidad">0801-1985-11478</span></p>
                                            <p><i class="material-icons left">add_location</i>

                                                <input class="with-gap" name="tipo_direccion" type="radio" id="tipo_direccion-d">
                                                <label for="tipo_direccion-d">Domicilio</label>
                                                <input class="with-gap" name="tipo_direccion" type="radio" id="tipo_direccion-n">
                                                <label for="tipo_direccion-n">Negoio</label>

                                            </p>
                                            <p>
                                                <i class="material-icons left">info_outline</i>
                                                <a class="truncate" id="observacion" href="#modal-observacion">+ Agregar Observación</a>
                                            </p>

                                        </div>
                                        <div class="card-action">
                                            <a id="btn-guardar" class="btn-flat waves-effect wave-blue blue-text" href="#!">GUARDAR</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Structure -->
                        <div id="modal-observacion" class="modal">
                            <div class="modal-content modal-content-editar-grupo">
                                <h5>Agregar Observación</h5>
                                <form class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="observacion-texto" class="materialize-textarea"></textarea>
                                            <label for="observacion-texto">Textarea</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <a id="agregar-observacion" href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agregar</a>
                                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
                            </div>
                        </div>

                       <div id="loader-card" style="width:100%; position:absolute; z-index:1;top:510px;" class="center-align">
                           <div class="preloader-wrapper small active center-align">
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

        <!--
    =====================================================
    Scripts
    =====================================================
    -->



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

        <script src="http://listjs.com/assets/javascripts/list.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/list.pagination.js/0.1.1/list.pagination.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/list.fuzzysearch.js/0.1.0/list.fuzzysearch.js"></script>

        <script src="../js/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
        <script src="../js/plugins/data-change/data-change.js"></script>


        <script src="../js/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
        <script src="../js/plugins/jqueryrotate/jquery.rotate.js"></script>
        <script>
            $(document).ready(function () {

                //CÓDIGO PARA CAMBIAR EL TOP A LA IMAGEN DE USUARIO 
                var altoDeCarta = $('.card-header').height();
                var assigTop = altoDeCarta - 37;
                $('.circle-image-in-card').css('top', assigTop);

                // VALIDA SI DE INICIO NINGÚN RADIO ESTA MARCADO Y DESABILITA EL BOTON GUARDAR
                if (!$("input[name='tipo_direccion']:checked").val()) {
                    $('#btn-guardar').attr("disabled", true);
                } else {

                }

                //  FUNCION PARA ESCUCHAR LOS CAMBIOS EN LOS RADIOS BOTONES Y ACTIVAR EL BOTON GUARDAR
                $("input[name='tipo_direccion']").on('change', function () {
                    $('#btn-guardar').attr("disabled", false);
                });


                $('#agregar-observacion').on('click', function () {
                    var textObserv = $('#observacion-texto').val();
                    console.log(textObserv);
                    if (textObserv.length != 0) {
                        $('#observacion').text(textObserv);
                    } else {
                        console.log("no hay nada en el text area");
                    }
                });


                $('#modal-observacion').modal({
                    ready: function (modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
                        $('#observacion-texto').focus();
                    }
                });

            });
        </script>
        <script src="location.js"></script>