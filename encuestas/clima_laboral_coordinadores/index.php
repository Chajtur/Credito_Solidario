<?php

session_start();
require '../../php/conection.php';
if(!isset($_SESSION['user'])){
    header('Location:../../index.php');
}

$stat = $conn4->prepare('call encuesta_autorizado(2, :user, :cargo);');
$stat->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
$stat->bindValue(':cargo', $_SESSION['designation'], PDO::PARAM_STR);
$stat->execute();
$result = $stat->fetch(PDO::FETCH_NUM);

if($result[0] == '1'){
//($_SESSION['designation'] == "13"){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coordinadores</title>
    <!-- Favicons-->
    <link rel="icon" href="../../images/favicon/favicon-32x32.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="../../images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#">
    <meta name="msapplication-TileImage" content="../../images/favicon/mstile-144x144.png">
    <!--Tint Titlebar for Chrome-->
    <meta name="theme-color" content="#3F51B5" />
    <!-- For Windows Phone -->

    <!-- CORE CSS-->
    <link href="../../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="../../css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!--Sweet Alert-->
    <link rel="stylesheet" href="../../js/plugins/sweetalert-master/dist/sweetalert.css">
    <link rel="stylesheet" href="../../js/plugins/sweetalert-master/themes/google/google.css">
    <!-- Custome CSS-->
    <link href="../../css/custom/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link rel="stylesheet" href="../../css/custom/nuevo.css">
    <link rel="stylesheet" href="../../css/custom/tema-indigo.css">
    <link rel="stylesheet" href="../../css/custom/search.css">
    <!-- Material-icons-->
    <link href="../../fonts/material-icons/material-icons.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="../../js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="../../js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!--<link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">-->

    <link rel="stylesheet" href="../../css/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="../../css/plugins/select2/select2.materialize.css">
    <style>
    
    .justify {
        text-align: justify
    }
    .radioWarning {
        border: solid red 1px;
    }
    .radioMessage {
        margin:5px 0 0 20px
    }

    </style>
</head>
<body>

    <div class="row">
        <div class="col s8 m8 l8 offset-l2 offset-m2 offset-s2">
            <form id="encuesta">
                <div class="card" style="width: 100%">
                    <div class="card-content">
                        <span class="card-title">Encuesta de Clima Laboral</span>
                        <div class="row">
                            <div class="col s12 m12 l12 radioRequired" name="group" data-error="Elija el género">
                                <p class="blue-text">Género</p>
                                <p>
                                    <input name="group" type="radio" id="test3" value="m"/>
                                    <label for="test3">Masculino</label>
                                </p>
                                <p>
                                    <input name="group" type="radio" id="test4" value="f"/>
                                    <label for="test4">Femenino</label>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <p class="justify">
                                <b>Instrucciones:</b> El propósito de este Cuestionario es encontrar las áreas de oportunidad que nos permitan MEJORAR EL AMBIENTE de trabajo en el Programa Crédito Solidario.
                                Recuerda que las respuestas son opiniones basadas en <b>TU</b> experiencia de trabajo, tiene que ser muy <b>SINCERO (A)</b> en lo que responda, ya que este es un instrumento totalmente <b>ANONIMO</b> por lo tanto la información es confidencial.
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <p class="justify">
                                Lee cuidadosamente cada una de las preguntas y marca con una X en el número donde los valores son los siguientes en la casilla correspondiente la respuesta que mejor describa tu opinión. No debe quedar ninguna pregunta en blanco.
                                <br>Posibles respuestas:
                                </p>
                                <ul class="collection">
                                    <li class="collection-item">1. <b>DE ACUERDO (1)</b>: Conformidad o aceptación de una situación laboral.</li>
                                    <li class="collection-item">2. <b>PARCIALMENTE DE ACUERDO (2)</b>: Cierta aceptación a la situación planteada</li>
                                    <li class="collection-item">3. <b>EN DESACUERDO (3)</b>: No aceptación de la situación laboral planteada.</li>
                                </ul>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <p class="justify">
                                Preguntas con sus opciones de respuesta:
                                </p>
                                <ul class="collection" id="preguntaso">
                                    <li class="collection-item">
                                        <div class="row no-margin">
                                            <div class="col s9 m9 l9"><b>O</b></div>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="collection" id="preguntasa">
                                    <li class="collection-item">
                                        <div class="row no-margin">
                                            <div class="col s9 m9 l9"><b>A</b></div>
                                        </div>
                                    </li>
                                </ul> 
                                <ul class="collection" id="preguntasp">
                                    <li class="collection-item">
                                        <div class="row no-margin">
                                            <div class="col s9 m9 l9"><b>P</b></div>
                                        </div>
                                    </li>
                                </ul> 
                                <ul class="collection" id="preguntasi">
                                    <li class="collection-item">
                                        <div class="row no-margin">
                                            <div class="col s9 m9 l9"><b>I</b></div>
                                        </div>
                                    </li>
                                </ul>  
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" value="" id="submitform" style="display:none">
                <a class="waves-effect waves-light btn-large" id="guardarencuesta" disabled><i class="material-icons left">save</i>Guardar</a>
            </form>
        </div>
    </div>

    <!-- jQuery Library -->
    <script type="text/javascript" src="../../js/plugins/jquery-2.2.4.min.js"></script>
    <!--materialize js-->
    <script src="../../js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../../js/materialize.js"></script>
    <!--prism
    <script type="text/javascript" src="js/prism/prism.js"></script>-->
    <!--scrollbar-->
    <script type="text/javascript" src="../../js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <!--custom-script.js - Add your own theme custom JS-->
    <script src="../../js/custom-script.js"></script>

    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="../../js/plugins.js"></script>

    <script type="text/javascript" src="../../js/jquery.form.js"></script>

    <script src="http://listjs.com/assets/javascripts/list.min.js"></script>
    <script src="../../js/plugins/list/list.1.5.0.min.js"></script>

    <script src="../../js/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="../../js/plugins/data-change/data-change.js"></script>
    <script src="../../js/plugins/cookie-manager/cookie-manager.js"></script>
    <script src="../../js/plugins/jquery.redirect.js/jquery.redirect.js"></script>

    <script type="text/javascript" src="../../js/plugins/select2/select2.full.min.js"></script>

    <script src="../../credito/buscarcenso.js"></script>
    <script src="../../js/plugins/jquery-validation/jquery.validate.js"></script>

    <script>
    
    $(document).ready(function(){

        $('#guardarencuesta').removeAttr('disabled');

        $("form#encuesta").submit(function(e){

            e.preventDefault();

            $(".radioRequired").each(function(){
                var rName = $(this).attr('name');
                var checked = $('[name=' + rName + ']').is(':checked');
                if(!checked && !$(this).hasClass('radioWarning')){
                    $(this).addClass('radioWarning');
                    // $(this).append('<div class="chip radioMessage">' + $(this).data("error") + '</div>');
                }
                if(checked){
                    $(this).removeClass('radioWarning');
                }
            });

            if($(".radioWarning").length > 0){
                window.scrollTo(0, ($('.radioWarning').first().offset().top-25));
                Materialize.toast('Por favor rellene los campos en rojo', 3000);
                return false;
            }

            var dat = [];

            $.each($('.radioRequired'), function(index, elem){
                var obj = {};
                var rName = $(this).attr('name');
                obj.idpregunta = $(elem).attr('idpregunta');
                obj.respuesta = $('[name=' + rName + ']:checked').val();
                dat.push(obj);
            });

            Materialize.toast('Enviando..', 2000);
            $('#guardarencuesta').attr('disabled','disabled');

            $.ajax({
                type: 'POST',
                url: 'guardar_encuesta.php',
                data: {
                    data: JSON.stringify(dat)
                },
                success: function(data){
                    if(data != 'false'){
                        Materialize.toast('Se ha guardado la encuesta', 2000, '', function(){
                            location.reload();
                        });
                    }else{
                        Materialize.toast('No se ha guardado la encuesta, contacte con el administrador', 3000);
                        $('#guardarencuesta').removeAttr('disabled');
                    }
                }
            });

        });

        $('#guardarencuesta').on('click', function(){
            $('#submitform').trigger('click');
        });

        var preguntas = {
            o: [
                "Me siento muy satisfecho con mi ambiente de trabajo",
                "En mi  Programa está claramente definida su Misión y Visión.",
                "Considero que hay sentido de identidad y de pertenencia al Programa.",
                "Se desarrolla un plan para lograr los objetivos del Programa",
                "En este Programa,	la	gente	planifica cuidadosamente antes de tomar acción.",
                "Está conforme con la limpieza, higiene y salubridad en su lugar de trabajo",
                "Cuento con los materiales y equipos necesarios para realizar mi trabajo",
                "Me gusta mi trabajo por lo que hago no por lo que recibo monetariamente.",
                "Las herramientas y equipos que utilizo (computadora,	teléfono,	etc.)	son mantenidos en forma adecuada.",
                "Siente que su jefe inmediato está ejecutando bien sus funciones."
            ],
            a: [
                "Mi superior me motiva a cumplir con mi trabajo del a manera que yo considere mejor",
                "Soy responsable del trabajo que realizo",
                "Soy responsable de cumplir los estándares de desempeño y/o rendimiento",
                "Conozco las exigencias de mi trabajo",
                "Me siento comprometido para alcanzar las metas establecidas.",
                "El horario de trabajo me permite atender mis necesidades personales",
                "Siente que este es un buen sitio para trabajar, comparándola con otros Programas que usted conoce.",
                "Hay un ambiente de compromiso con mi equipo de trabajo.",
                "Le aprecian sus superiores por su trabajo y buen rendimiento",
                "Estimulo mi equipo de trabajo porque de igual manera yo recibo estimulación"
            ],
            p: [
                "Tengo mucho trabajo y poco tiempo para realizarlo.",
                "El Programa es un lugar relajado para trabajar.",
                "En casa, a veces temo oír sonar el teléfono porque pudiera tratarse de alguien que llama sobre un problema en el trabajo.",
                "Me siento como si nunca tuviese un día libre.",
                "Muchas de los trabajadores de mi empresa en mi nivel, sufren de un alto estrés, debido a la exigencia de trabajo.",
                "Para desempeñar las funciones de mi puesto tengo que hacer un esfuerzo adicional y retador en el trabajo.",
                "Piensa que en este programa tratan mejor a su personal que otras empresas, por lo tanto no afecta sus niveles de estrés. ",
                "Considera que se iría a trabajar a otra empresa a pesar de la carga de trabajo que incluye su puesto actual.",
                "Con frecuencia ejecutas una planificación de tu tiempo de trabajo.",
                "Estas mejorando la posición del Programa con tu desempeño."

            ],
            i: [
                "Se  me anima a desarrollar mis propias ideas.",
                "Les agrada que yo intente hacer mi trabajo de distinta formas",
                "Se \"valora\" nuevas formas de hacer las cosas, implementar cambios.",
                "Se me impulsa a encontrar nuevas y mejores maneras de hacer el trabajo.",
                "Cuando algo sale mal, nosotros corregimos el motivo del error de manera que el problema no vuelva a suceder.",
                "En mis anteriores trabajos daba sugerencias e hice cambios positivos para mejorar la situación laboral.",
                "Se me involucra en desarrollar actividades de acuerdo a fechas festivas y promover el trabajo en equipo.",
                "Siento que el programa promueve la comunicación con las demás áreas a manera que tengamos conocimiento de cada una de sus responsabilidades.",
                "Nos comprometemos en mejorar las condiciones de clima laboral ",
                "Los	directivos	/	superiores	inmediatos reaccionan de manera positiva ante nuestras nuevas ideas."
            ]
        };

        var generarFila = function(idx, preg, incremento){

            var fila = $("<li></li>");
            var rowli = $('<div></div>');
            var colpregunta = $('<div></div>');

            var genrowr = function(indx, number){

                var colr = $('<div></div>');
                var p = $('<p></p>');
                var input = $('<input>');
                var label = $('<label></label>');
                var id = 'respuesta'+(indx)+number;

                colr.addClass('col s1 m1 l1 center-align');
                input.attr('name', 'pregunta'+(indx));
                input.attr('type', 'radio');
                input.attr('id', id);
                input.attr('value', number);
                // input.attr('required', 'required');
                label.attr('for', id);
                label.text(number);

                return colr.append(p.append(input).append(label));

            }

            fila.addClass('collection-item');
            rowli.addClass('row no-margin');
            rowli.addClass('radioRequired');
            rowli.attr('name', 'pregunta'+(idx+1+incremento));
            rowli.attr('idpregunta', idx+1+incremento);
            rowli.attr('data-error', 'Requerido');
            colpregunta.addClass('col s9 m9 l9');
            colpregunta.append(((idx+incremento)+1+'. ')+preg);

            rowli.append(colpregunta);
            for(var i = 1; i < 4; i++){
                rowli.append(genrowr((idx+1+incremento), i));
            }
            return fila.append(rowli);

        }

        $.each(preguntas.o, function(index, pregunta){
            $('#preguntaso').append(generarFila(index, pregunta, 0));
        });
        $.each(preguntas.a, function(index, pregunta){
            $('#preguntasa').append(generarFila(index, pregunta, 10));
        });
        $.each(preguntas.p, function(index, pregunta){
            $('#preguntasp').append(generarFila(index, pregunta, 20));
        });
        $.each(preguntas.i, function(index, pregunta){
            $('#preguntasi').append(generarFila(index, pregunta, 30));
        });

    });

    </script>
</body>
</html>
<?php 

}
else if($result[0] == '2') {
    echo $_SESSION['first_name'] . ', usted ya lleno la encuesta.';
}
else {
echo "No autorizado";
}

?>