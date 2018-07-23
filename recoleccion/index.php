
<?php 

session_start();
require '../php/conection.php';

// Listar personal
$stat = $conn->prepare('call listar_personal();');
$stat->execute();
$personal = $stat->fetchAll(PDO::FETCH_ASSOC);

// Listar actividades económicas
$stat = $conn->prepare('select * from actividad_economica');
$stat->execute();
$actividades = $stat->fetchAll(PDO::FETCH_ASSOC);

if(isset($_SESSION['user'])){
    // Listar barrios colonias
    $stat = $conn->prepare('call listar_direccion_barrido(:user)');
    $stat->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
    $stat->execute();
    $barrios = $stat->fetchAll(PDO::FETCH_ASSOC);
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
    
    <title>Consultas - Crédito Solidario</title>

    <!-- Favicons-->
    <link rel="icon" href="../images/favicon/favicon-32x32.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="../images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#">
    <meta name="msapplication-TileImage" content="../images/favicon/mstile-144x144.png">
    <!-- Tint Titlebar for Chrome-->
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

    <link rel="stylesheet" href="../css/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="../css/plugins/select2/select2.materialize.css">

    <style>
        .select2-with-icon-prefix {
            margin-left: 30px;
        }
    </style>

</head>

<body>
<div class="row">
    <form class="col s10 offset-s1" id="formguardardatos">

        <?php if(isset($_SESSION['name'])):?>

            <ul class="collection">
                <li class="collection-item avatar">
                    <img src="../images/solologo.svg" alt="" class="circle">
                    <span class="title blue-text"><?php echo $_SESSION['name'];?></span>
                    <p>Código Usuario: <br><b><?php echo $_SESSION['user'];?></b>
                    <a href="#!" class="secondary-content tooltipped" data-delay="10" data-position="bottom" data-tooltip="Quitar usuario" id="eliminarusuario">x</a>
                </li>
            </ul>

        <?php endif;?>

        <div class="card white">

            <div class="card-content blue-text">

                <span class="card-title">Recolección de Información</span>

                <p>Datos Personales</p>

                <div class="row blue-text">
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="inputidentidad" type="text" class="validate buscarcenso" maxlength="13" required>
                        <label for="identidad">Identidad</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">face</i>
                        <input id="nombre" type="text" class="validate" required>
                        <label for="nombre">Nombre</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">phone</i>
                        <input id="inputtelefono" type="number" class="validate" maxlength="8" required>
                        <label for="telefono">Teléfono</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">wc</i>
                        <select id="genero" required>
                            <option value="" disabled selected>Género</option>
                            <option value="1">Masculino</option>
                            <option value="2">Femenino</option>
                        </select>
                        <label>Género</label>
                    </div>
                </div>

            </div>

        </div>

        <div class="card white">

            <div class="card-content blue-text">

                <span class="card-title">Preguntas</span>

                <div class="row">
                    <div class="input-field col s12">
                        <p>¿Ha sido beneficiada(o) con el programa Crédito Solidario anteriormente?</p>
                        <p>
                            <input name="groupRespuestaPregunta1" type="radio" value="Si" id="radioPregunta1RespuestaSi" required/>
                            <label for="radioPregunta1RespuestaSi">Si</label>
                        </p>
                        <p>
                            <input name="groupRespuestaPregunta1" type="radio" value="No" id="radioPregunta1RespuestaNo" required/>
                            <label for="radioPregunta1RespuestaNo">No</label>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <p>¿Cree usted que es un buen programa, que es una ayuda importante para la familia y que merece la pena continuar?</p>
                        <p>
                            <input name="groupRespuestaPregunta2" type="radio" value="Si" id="radioPregunta2RespuestaSi" required/>
                            <label for="radioPregunta2RespuestaSi">Si</label>
                        </p>
                        <p>
                            <input name="groupRespuestaPregunta2" type="radio" value="No" id="radioPregunta2RespuestaNo" required/>
                            <label for="radioPregunta2RespuestaNo">No</label>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <p>¿Como calificaría el programa Crédito Solidario como una ayuda para las familias?</p>
                        <p>
                            <input name="groupRespuestaPregunta3" type="radio" value="No ayuda" id="radioPregunta3RespuestaNoayuda" required/>
                            <label for="radioPregunta3RespuestaNoayuda">No ayuda</label>
                        </p>
                        <p>
                            <input name="groupRespuestaPregunta3" type="radio" value="Ayuda poco" id="radioPregunta3RespuestaAyudapoco" required/>
                            <label for="radioPregunta3RespuestaAyudapoco">Ayuda poco</label>
                        </p>
                        <p>
                            <input name="groupRespuestaPregunta3" type="radio" value="Ayuda mucho y debe continuar" id="radioPregunta3RespuestaAyudamucho" required/>
                            <label for="radioPregunta3RespuestaAyudamucho">Ayuda mucho y debe continuar</label>
                        </p>
                        <!-- <p>
                            <input name="groupRespuestaPregunta3" type="radio" value="El programa debe continuar" id="radioPregunta3RespuestaElprogramadebecontinuar" required/>
                            <label for="radioPregunta3RespuestaElprogramadebecontinuar">El programa debe continuar</label>
                        </p> -->
                    </div>
                </div>
        
            </div>

        </div>

        <div class="card white">

            <div class="card-content blue-text">

                <span class="card-title">De continuar el programa, nos gustaría conocer su opinión sobre cómo mejorarlo:</span>

                <div class="row">
                    <div class="col s12">
                        <p>¿Qué tipo de problemas tiene actualmente en su negocio? Marque todos los casos que apliquen.</p>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <p>
                            <input type="checkbox" id="inputproblema_poco_dinero"/>
                            <label for="inputproblema_poco_dinero">Poco dinero de capital de trabajo.</label>
                        </p>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <p>
                            <input type="checkbox" id="inputproblema_zona_poca_clientela"/>
                            <label for="inputproblema_zona_poca_clientela">En mi zona de trabajo hay poca clientela.</label>
                        </p>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <p>
                            <input type="checkbox" id="inputproblema_mantener_finanzas"/>
                            <label for="inputproblema_mantener_finanzas">Me cuesta mantener mis finanzas ordenadas.</label>
                        </p>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <p>
                            <input type="checkbox" id="inputproblema_llevar_contabilidad"/>
                            <label for="inputproblema_llevar_contabilidad">Necesito aprender a llevar mi contabilidad.</label>
                        </p>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <p>
                            <input type="checkbox" id="inputproblema_inseguridad"/>
                            <label for="inputproblema_inseguridad">Inseguridad.</label>
                        </p>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <p>
                            <input type="checkbox" id="inputproblema_necesita_entrenarse_clientela"/>
                            <label for="inputproblema_necesita_entrenarse_clientela">Necesito entrenarme en cómo conseguir clientela.</label>
                        </p>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <p>
                            <input type="checkbox" id="inputproblema_desconoce_tecnicas_negocio"/>
                            <label for="inputproblema_desconoce_tecnicas_negocio">No conozco nuevas técnicas para desarrollar mi negocio o elaborar mis productos.</label>
                        </p>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <p>
                            <input type="checkbox" id="inputproblema_entrenamiento_basico_pc"/>
                            <label for="inputproblema_entrenamiento_basico_pc">Necesito entrenamiento básico en computación.</label>
                        </p>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <p>
                            <input type="checkbox" id="inputproblema_necesita_capacitaciones"/>
                            <label for="inputproblema_necesita_capacitaciones">Como emprendedor de Crédito Solidario, necesito capacitaciones de INFOP para mejorar mi negocio.</label>
                        </p>
                    </div>
                </div>

            </div>

        </div>

        <div class="card white">

            <div class="card-content blue-text">

                <span class="card-title">Especifique o describa su situación actual:</span>

                <div class="row">
                    <div class="input-field col s12">
                        <p>De continuar el programa, ¿Qué tipo de ayuda adicional le gustaría que se brindara?</p>
                        <textarea id="inputayuda_adicional_brindar" class="materialize-textarea" required></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <p>Si el programa continuara, ¿Se comprometería usted a ayudar a mejorarlo poco a poco?</p>
                        <p>
                            <input name="groupRespuestaPregunta4" type="radio" value="Si" id="radioPregunta4RespuestaSi" required/>
                            <label for="radioPregunta4RespuestaSi">Si</label>
                        </p>
                        <p>
                            <input name="groupRespuestaPregunta4" type="radio" value="No" id="radioPregunta4RespuestaNo" required/>
                            <label for="radioPregunta4RespuestaNo">No</label>
                        </p>
                    </div>
                </div>
        
            </div>

            <div class="card-action">
                <a href="#!" id="btnlimpiar" class="grey-text">Limpiar</a>
                <input type="submit" id="btnguardar" class="btn-flat right green-text" value="Guardar"/>
            </div>

        </div>

    </form>
</div>

<?php require "../common/footer.php";?>

</body>

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

<script type="text/javascript" src="../js/plugins/select2/select2.full.min.js"></script>

<script src="../credito/buscarcenso.js"></script>
<script src="../js/plugins/jquery-validation/jquery.validate.js"></script>

<Script src="recoleccion_de_informacion.js"></Script>