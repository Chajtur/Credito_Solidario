<?php

require '../php/conection.php';

session_start();
require '../php/conection.php';

$stat = $conn->prepare('call listar_personal();');
$stat->execute();
$personal = $stat->fetchAll(PDO::FETCH_ASSOC);

$stat = $conn->prepare('call listar_encuesta();');
$stat->execute();
$data = $stat->fetchAll(PDO::FETCH_ASSOC);

if(isset($_SESSION['user'])){
    $stat_estadistica = $conn->prepare('call estadistica_encuesta(:user);');
    $stat_estadistica->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
    $stat_estadistica->execute();
    $estadisticas = $stat_estadistica->fetchAll();
};

?>

<!DOCTYPE html>
<html lang="en">
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

    <link rel="stylesheet" href="../css/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="../css/plugins/select2/select2.materialize.css">

</head>
<body>

<div class="container">

    <?php if(isset($_SESSION['name'], $_SESSION['user'])) :
    $stat_estadistica = $conn->prepare('call estadistica_encuesta(:user);');
    $stat_estadistica->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
    $stat_estadistica->execute();
    $estadisticas = $stat_estadistica->fetchAll();
    foreach($estadisticas as $row){
    }

    ?>


        <ul class="collection">
            <li class="collection-item avatar">
                <img src="../images/solologo.svg" alt="" class="circle">
                <span class="title blue-text"><?php echo $_SESSION['name'];?></span>
                <p>Código Usuario: <br><b><?php echo $_SESSION['user'];?></b><br>
                <span class="title">Llamadas hechas en el día: <b><?php echo $row['contador'] ?></b></span>
                <br>
                    <span class="title">Beneficiarios restantes total: <b><?php echo $row['total'];?></b></span>

                <a href="#!" class="secondary-content tooltipped" data-delay="10" data-position="bottom" data-tooltip="Quitar usuario" id="eliminarusuario">x</a>
            </li>
        </ul>
    <?php endif;?>

    <div id="work-collapsible">
        <div class="row">
            <div class="col s12">
                <ul id="creditos-list" class="collapsible" data-collapsible="accordion">
                    <li class="collapsible-item-header avatar">
                        <i class="material-icons circle blue">content_copy</i>
                        <span class="collapsible-title-header">Créditos Asignados
                            <div class="secondary-content actions">
                                <input class="search-expandida fuzzy-search" type="search" placeholder="buscar" />
                                <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                    <i class="material-icons center-align">search</i>
                                </a>
                            </div>
                        </span>
                        <p>Todos los créditos:</p>
                        <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                    </li>
                    
                    <li>
                        <div class="collapsible-header-titles  sin-icon">
                            <div class="row no-margin">
                                <div class="col s1 m1 l1 hide-on-small-only">
                                    <p class="collapsible-title">#</p>
                                </div>
                                <div class="col s12 m5 l4 ">
                                    <p class="collapsible-title">Teléfono</p>
                                </div>
                                <div class="col m4 l3 hide-on-small-only">
                                    <p class="collapsible-title">Nombre</p>
                                </div>
                                <div class="col m4 l2 hide-on-small-only">
                                    <p class="collapsible-title">Identidad</p>
                                </div>
                                <div class="col m3 l2 hide-on-med-and-down">
                                    <p class="collapsible-title">Rubro</p>
                                </div>
                            </div>
                        </div>
                    </li>

                    <div class="list collapsible no-padding no-margin z-depth-0">

                        <?php $i=0;?>

                        <?php foreach($data as $credito):?>

                            <li>
                                <div class="collapsible-header sin-icon" id="collapsible<?php echo $credito['identidad'];?>">
                                    <div class="row no-margin">
                                        <div class="col s2 m1 l1 truncate hide-on-small-only"><?php echo ++$i;?></div>
                                        <div class="col s11 m4 l4 truncate hide-on-small-only"><span id="nombre" class="nombreb"><?php echo $credito['Nombre_Completo'];?></span></div>
                                        <div class="col s12 m3 l3 truncate telefonodb" id="telefono"><?php echo $credito['Telefono']?></div>
                                        <div class="col s4 m3 l2 hide-on-small-only identidadb truncate" id="identidad"><?php echo $credito['identidad']?></div>
                                        <div class="col s6 m3 l2 hide-on-small-only estatusb truncate"><?php echo $credito['rubro'];?></div>
                                    </div>
                                </div>
                            </li>

                        <?php endforeach;?>

                    </div>
                    
                    <li class="collapsible-item-header light">
                        <ul id="pag-control" class="pag pagination">
                        </ul>
                    </li>

                </ul>

            </div>
        </div>
    </div>

</div>

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

<!-- Modal Structure -->
<div id="modalPregunta" class="modal">
    <div class="modal-content">
        <h4>¿Por quién votaría en las próximas elecciones?</h4>
        <form action="#">
            <p>
                <input name="group1" type="radio" id="test1" class="radioSelection" value="Salvador Nasrala"/>
                <label for="test1" class="black-text">Salvador Nasrala</label>
            </p>
            <p>
                <input name="group1" type="radio" id="test2" class="radioSelection" value="Juan Orlando"/>
                <label for="test2" class="black-text">Juan Orlando</label>
            </p>
            <p>
                <input name="group1" type="radio" id="test3" class="radioSelection" value="Luis Zelaya"/>
                <label for="test3" class="black-text">Luis Zelaya</label>
            </p>
            <p>
                <input name="group1" type="radio" id="test4" class="radioSelection" value="No votará"/>
                <label for="test4" class="black-text">No votará</label>
            </p>
            <p>
                <input name="group1" type="radio" id="test5" class="radioSelection" value="Indeciso"/>
                <label for="test5" class="black-text">Indeciso</label>
            </p>
            <p>
                <input name="group1" type="radio" id="test6" class="radioSelection" value="No quiere participar"/>
                <label for="test6" class="black-text">No quiere participar</label>
            </p>
            <p>
                <input name="group1" type="radio" id="test7" class="radioSelection" value="Fuera de servicio"/>
                <label for="test7" class="black-text">Fuera de servicio</label>
            </p>
            <p>
                <input name="group1" type="radio" id="test8" class="radioSelection" value="No contactado"/>
                <label for="test8" class="black-text">No contactado</label>
            </p>
            <p>
                <input name="group1" type="radio" id="test9" class="radioSelection" value="Celular inválido"/>
                <label for="test9" class="black-text">Celular inválido</label>
            </p>
            <p>
                <input name="group1" type="radio" id="test10" class="radioSelection" value="No contesta"/>
                <label for="test10" class="black-text">No contesta</label>
            </p>
            <p>
                <input name="group1" type="radio" id="test11" class="radioSelection" value="El destino que usted solicita no es accesible"/>
                <label for="test11" class="black-text">El destino que usted solicita no es accesible</label>
            </p>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat amber-text" id="btnguardar">Guardar</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat amber-text">Cancelar</a>
    </div>
</div>

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

<script>

$(document).ready(init);

function init(){

    $("#selectpersonal").select2();

    // Materialize
    $('.collapsible').collapsible();

    // Materialize
    $('.modal').modal({
        dismissible: false
    });

    // Eventos
    $('#btncontinuar').click(validarcampousuario);
    $('#eliminarusuario').click(eliminarVariableUser);
    $('.collapsible-header').click(abrirModalEncuesta);
    $('#btnguardar').click(guardarEncuesta);
    $('.radioSelection').click(elegirRespuesta);

}

function abrirModalEncuesta(){
    window.identidad = $(this).find('#identidad').text();
    window.nombre = $(this).find('#nombre').text();
    $('#modalPregunta').modal('open');
}

function validarcampousuario(){

    if($('#selectpersonal').val() == '' || $('#selectpersonal').val() == null){
        Materialize.toast('No ha seleccionado su nombre', 1000);
        return false;
    }

    guardarUsuario();

}

function guardarUsuario(){

    $.ajax({
        type: 'POST',
        url: '../barrido/guardar_usuario.php',
        data: {
            user: $('#selectpersonal').val(),
            name: $('#selectpersonal option:selected').text()
        },
        success: function(data){
            window.location.reload();
        }
    });

}

function guardarEncuesta(){
    $.ajax({
        type: 'POST',
        url: 'guardar_encuesta.php',
        data: {
            identidad: window.identidad,
            nombre: window.nombre,
            respuesta: window.respuesta
        },
        success: function(data){
            Materialize.toast('Guardado', 1000);
            window.location.reload();
        }
    });
}

function elegirRespuesta(){
    window.respuesta = $(this).val();
}

function eliminarVariableUser(){
    $.ajax({
        url: '../barrido/eliminar_variable_usuario.php',
        success: function(data){
            window.location.reload();
        }
    });
}

</script>

<?php if(!isset($_SESSION['user'])):?>

    <script>

        $(document).ready(function(){
            $('#modaluser').modal('open');
        });

    </script>

<?php endif;?>

</body>
é</html>