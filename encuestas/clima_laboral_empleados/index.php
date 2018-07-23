<?php

session_start();
require '../../php/conection.php';
if(!isset($_SESSION['user'])){
    header('Location:../../index.php');
}

$stat = $conn4->prepare('call encuesta_autorizado(1, :user, :cargo);');
$stat->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
$stat->bindValue(':cargo', $_SESSION['designation'], PDO::PARAM_STR);
$stat->execute();
$result = $stat->fetch(PDO::FETCH_NUM);

if($result[0] == '1'){
//if($_SESSION['designation'] == "14"){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Empleados</title>
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
                            <div class="col s12 m12 l12 radioRequired" name="pregunta" idpregunta="0" data-error="Elija el género">
                                <p class="blue-text">Género</p>
                                <p>
                                    <input name="pregunta" type="radio" id="test3" value="m"/>
                                    <label for="test3">Masculino</label>
                                </p>
                                <p>
                                    <input name="pregunta" type="radio" id="test4" value="f"/>
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
                                    <li class="collection-item">1. <b>SIEMPRE (1)</b>: Conformidad o aceptación de una situación laboral que se le expone.</li>
                                    <li class="collection-item">2. <b>CASI SIEMPRE (2)</b>: se implementan en algunas situaciones lo mostrado</li>
                                    <li class="collection-item">3. <b>NUNCA (3)</b>: No aceptación de la situación laboral planteada.</li>
                                </ul>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <p class="justify">
                                Preguntas con sus opciones de respuesta:
                                </p>
                                <ul class="collection" id="preguntassp">
                                    <li class="collection-item">
                                        <div class="row no-margin">
                                            <div class="col s9 m9 l9"><b>SP</b></div>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="collection" id="preguntasc">
                                    <li class="collection-item">
                                        <div class="row no-margin">
                                            <div class="col s9 m9 l9"><b>C</b></div>
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
                                <ul class="collection" id="preguntasa">
                                    <li class="collection-item">
                                        <div class="row no-margin">
                                            <div class="col s9 m9 l9"><b>A</b></div>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="collection" id="preguntasr">
                                    <li class="collection-item">
                                        <div class="row no-margin">
                                            <div class="col s9 m9 l9"><b>R</b></div>
                                        </div>
                                    </li>
                                </ul> 
                                <ul class="collection" id="preguntase">
                                    <li class="collection-item">
                                        <div class="row no-margin">
                                            <div class="col s9 m9 l9"><b>E</b></div>
                                        </div>
                                    </li>
                                </ul> 
                                <ul class="collection" id="preguntaso">
                                    <li class="collection-item">
                                        <div class="row no-margin">
                                            <div class="col s9 m9 l9"><b>O</b></div>
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
            sp: [
                "Salgo del trabajo sintiéndome satisfecho de lo que he hecho y me siento orgulloso(a) del mismo.",
                "En este Programa valoran mi trabajo y no siento el deseo de trabajar en otra empresa.",
                "Conozco muy bien a mis clientes y están recibiendo el servicio que demanda el Programa.",
                "Me levanto sintiéndome motivado en ir a trabajar, no obligado por un salario mensual, sino porque me gusta lo que hago.",
                "Piensa que en este Programa el sueldo de su puesto es el adecuado en comparación a lo que le pagaran en otras empresas."
            ],
            c: [
                "En mi grupo de trabajo, solucionar el problema es más importante que encontrar algún culpable, para que nuestro desempeño sea más efectivo.",
                "Siento que formo parte de un equipo que trabaja hacia una meta común.",
                "Mi superior inmediato toma acciones y trata de hacer cumplir nuestras responsabilidades.",
                "Puedo confiar en mis compañeros de trabajo.",
                "En el trabajo tengo un buen amigo con quien hablar."
            ],
            p: [
                "Siento que a pesar de tener mucho trabajo lo hago en el tiempo requerido,  por lo que mis niveles de estrés son normales.",
                "El Programa  es un lugar relajado para trabajar y he sentido  en alguna ocasión como que estuviese en un día libre.",
                "No temo oír sonar el teléfono cuando me encuentro en mi casa aunque pudiera tratarse de alguien que llama sobre un problema en el trabajo.",
                "Siento que le dedico el tiempo prudente a mi familia a pesar de tener trabajo pendiente.",
                "Se siente concentrado en la mayoría de las actividades que ejecuta, no se encuentra agotado física y mentalmente."
            ],
            a: [
                "Hay evidencia de que mi jefe inmediato me apoya utilizando mis ideas o propuestas para mejorar el trabajo",
                "Considero que mi jefe es flexible y justo ante las peticiones que solicito, me respalda  al 100%.",
                "A mi jefe le interesa que me desarrolle profesionalmente, es fácil hablar  sobre problemas relacionados con el trabajo",
                "Mi jefe inmediato escucha lo que dice su personal y brinda retroalimentación positiva como negativa sobre su desempeño.",
                "La dirección del Programa se interesa por mi futuro profesional  implementando (capacitación, plan de carrera, mejoras de salario, beneficios etc.)"
            ],
            r: [
                "Puedo contar con una felicitación cuando realizo bien mi trabajo por rendimiento positivo.",
                "Mi jefe conoce mis puntos fuertes, débiles y me los hace notar.",
                "Existe reconocimiento de la dirección para el personal por sus esfuerzos y aportaciones al logro de los objetivos y metas del Programa",
                "El instrumento de medición utilizado para evaluar al personal arroja conclusiones justas sobre mi desempeño.",
                "Por mi desempeño me han hecho saber que puedo aspirar a otros puestos."
            ],
            e: [
                "Los objetivos que  fija  mi  jefe para mi trabajo son razonables.",
                "Si se despide a alguien es porque probablemente esa persona se lo merece.",
                "Siento que mi Jefe inmediato le da la misma importancia a mi trabajo como al de los otros miembros del grupo.",
                "Puedo contar con un trato justo por parte de mi jefe y supervisa mi trabajo de manera adecuada.",
                "A mis clientes les agrada el trato que brinda  mi Jefe inmediato."
            ],
            o: [
                "He sentido desarrollo personal y laboral desde mi comienzo en el Programa a la fecha",
                "Se me brindan las capacitaciones necesarias para desarrollarme profesionalmente ",
                "Me siento capaz de aplicar a los diversos concursos internos que se llevan a cabo para poder ascender dentro del Programa",
                "Se me paga lo justo de acuerdo a mi perfil",
                "Considero me siento bien mi puesto de trabajo"
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

        $.each(preguntas.sp, function(index, pregunta){
            $('#preguntassp').append(generarFila(index, pregunta, 0));
        });
        $.each(preguntas.c, function(index, pregunta){
            $('#preguntasc').append(generarFila(index, pregunta, 5));
        });
        $.each(preguntas.p, function(index, pregunta){
            $('#preguntasp').append(generarFila(index, pregunta, 10));
        });
        $.each(preguntas.a, function(index, pregunta){
            $('#preguntasa').append(generarFila(index, pregunta, 15));
        });
        $.each(preguntas.r, function(index, pregunta){
            $('#preguntasr').append(generarFila(index, pregunta, 20));
        });
        $.each(preguntas.e, function(index, pregunta){
            $('#preguntase').append(generarFila(index, pregunta, 25));
        });
        $.each(preguntas.o, function(index, pregunta){
            $('#preguntaso').append(generarFila(index, pregunta, 30));
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