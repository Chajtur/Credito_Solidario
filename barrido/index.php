
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
    <form class="col s12" id="formguardardatos">
        <div class="col">

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

                    <span class="card-title center-align">Recolección de Información</span>
                    
                        <p>Por favor llene todos los campos requeridos.</p>
                        <div class="row blue-text">
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input id="identidad" type="text" class="validate buscarcenso" required>
                                    <label for="identidad">Identidad</label>
                                </div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">face</i>
                                    <input id="nombre" type="text" class="validate" required>
                                    <label for="nombre">Nombre</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">phone</i>
                                    <input id="telefono" type="number" class="validate" required>
                                    <label for="telefono">Teléfono</label>
                                </div>
                            </div>
                            <div class="row no-margin">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">directions_run</i>
                                    <select id="actividad_economica" class="validate" required>

                                        <option value="" disabled selected>Seleccione una actividad económica</option>
                                        <?php foreach($actividades as $actividad):?>

                                            <option value="<?php echo $actividad['id']?>"><?php echo $actividad['nombre']?></option>
                                        
                                        <?php endforeach;?>

                                    </select>
                                    <label for="actividad_economica">Actividad Económica</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">store_mall_directory</i>
                                    <input id="nombre_negocio" type="text" class="validate" required>
                                    <label for="nombre_negocio">Nombre del Negocio</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">directions_run</i> 
                                    <select id="direccion_negocio" class="validate browser-default select2-with-icon-prefix" required>

                                        <option value="" disabled selected>Seleccione un barrio</option>
                                        <?php if(isset($barrios)):?>
                                            <?php foreach($barrios as $barrio):?>

                                                <option value="<?php echo $barrio['codigo']?>"><?php echo $barrio['Colonia']?></option>
                                            
                                            <?php endforeach;?>
                                        <?php endif;?>

                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    Es beneficiario de Crédito Solidario?
                                    <div class="input-field col s12">
                                        <input name="beneficiariocsgroup" type="radio" id="sibeneficiario" required/>
                                        <label for="sibeneficiario">Si</label>
                                        <input name="beneficiariocsgroup" type="radio" id="nobeneficiario" required/>
                                        <label for="nobeneficiario">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    Si su respuesta es NO, ¿Desea optar a un Crédito Solidario?
                                    <div class="input-field col s12">
                                        <input name="optarcreditogroup" type="radio" id="sioptarcredito" />
                                        <label for="sioptarcredito">Si</label>
                                        <input name="optarcreditogroup" type="radio" id="nooptarcredito" />
                                        <label for="nooptarcredito">No</label>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="credito_por_que" type="text" class="validate">
                                                <label for="credito_por_que">Por qué?</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    Está interesado en recibir capacitación?
                                    <div class="input-field col s12">
                                        <input name="interesadogroup" type="radio" id="siinteresado" />
                                        <label for="siinteresado">Si</label>
                                        <input name="interesadogroup" type="radio" id="nointeresado" />
                                        <label for="nointeresado">No</label>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="tema_capacitacion" type="text" class="validate">
                                                <label for="tema_capacitacion">En qué temas de negocio requiere capacitación?</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>

                <div class="card-action">
                    <input type="submit" value="Guardar" class="btn-flat amber-text">
                    <a href="#!" id="btnlimpiar">Limpiar</a>
                </div>

            </div>

        </div>
    </form>
</div>

<?php require "../common/footer.php";?>

</body>

<!-- Modal Structure -->
<div id="modaluser" class="modal">
    <div class="modal-content">
        <div class="input-field col s12">
            <select id="selectpersonal" class="browser-default">
                <option value="" disabled selected>Elija su nombre</option>
                <?php foreach($personal as $person):?>
                    <option value="<?php echo $person['employee_id'];?>"><?php echo $person['nombre'];?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action waves-effect waves-blue btn-flat amber-text" id="btncontinuar">Continuar</a>
    </div>
</div>

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
<?php if(!isset($_SESSION['user'])):?>

<script>

    $(document).ready(function(){
        $('#modaluser').modal('open');
    });

</script>

<?php endif;?>