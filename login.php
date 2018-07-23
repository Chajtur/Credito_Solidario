
<?php

session_start();
if(isset($_SESSION['email'])
&& isset($_SESSION['gender'])
&& isset($_SESSION['first_name'])
&& isset($_SESSION['last_name'])
&& isset($_SESSION['user'])
&& isset($_SESSION['pass'])
&& isset($_SESSION['agencia']))
{
    header('Location: php/redirect.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Inicio de Sesión</title>

    <!-- Favicons-->
    <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->


    <!-- CORE CSS-->

    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link rel="stylesheet" href="css/custom/nuevo.css">
    <link rel="stylesheet" href="css/custom/tema-indigo.css">
    <!-- Custome CSS-->
    <link href="css/custom/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="fonts/material-icons/material-icons.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/animate-css/animate.css" type="text/css" rel="stylesheet" media="screen,projection">

</head>

<body class="blue darken-4">

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


    <div id="login-page" class="row">
        <div class="col s12 z-depth-4 card-panel wow slideInLeft" data-wow-duration="2s">
            <form class="login-form" method="post" id="loginform">
                <div class="row">
                    <div class="input-field col s12 center">
                        <img src="images/soloLogo.svg" alt="" class=" responsive-img valign profile-image-login">
                        <p class="center login-form-text">Iniciar Sesión</p>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix grey-text">account_circle</i>
                        <input id="txtusuario" type="text" name="user" class="validate">
                        <label for="username">Nombre de Usuario</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix grey-text">lock</i>
                        <input id="txtpass" type="password" name="pass" class="validate">
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
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        <p class="margin right-align medium-small"><a href="consultas-nueva/index.php">Regresar Consultas</a></p>
                    </div>
                </div>

            </form>
        </div>
    </div>



    <!-- ================================================
    Scripts
    ================================================ -->

    <!-- jQuery Library -->
    <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="js/materialize.js"></script>
    <!--prism-->
    <script type="text/javascript" src="js/plugins/prism/prism.js"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="js/custom-script.js"></script>
    <!--wow.js - Add animation to items while scrollins-->
    <script type="text/javascript" src="js/wow-animation/wow.min.js"></script>
    
    <script src="js/login.js"></script>
    <!--init the wow.js script-->
    <script>
        new WOW().init();
    </script>

    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="js/plugins.js"></script>
    
    <?php if(isset($_GET['conn_exception'])):?>

        <script>
            $(document).ready(function(){
                Materialize.toast('No se ha podido conectar con el servidor, por favor intentelo más tarde', 5000);
            });
        </script>
       
    <?php endif;?>
    
    <?php if(isset($_GET['no_auth'])):?>

        <script>
            $(document).ready(function(){
                Materialize.toast('Para ingresar, inicie sesión', 5000);
            });
        </script>
       
    <?php endif;?>
    
</body>

</html>