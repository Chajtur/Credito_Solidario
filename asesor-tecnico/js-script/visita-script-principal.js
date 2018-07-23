$(document).ready(function () {
    /*$('.tooltipped').tooltip({
        delay: 50,
        html: true
    });*/
    $('#main-section').hide();
    $('#searching-icon').hide();
    $('#loader-card').hide();
    $('#presione-aqui').on('click', function () {
        $('#id_visitado').focus();
    });

    //:::::::::::::::::::::::::::

    var options = {
        onComplete: function (cep) {
            buscarCenso(cep, false);
            $('#id_visitado').blur();
            
        },
        onKeyPress: function (cep, event, currentField, options) {
            $('#nombre').val('');
            $('#identidad').val('');
            /*$('#observacion').val('');*/
            $('#observacion-texto').val("");
            $('#observacion').text("+ Agregar una observación");
            $('input[name="tipo_direccion"]:checked').attr('checked', false);
            $('#main-section').fadeOut(300, function () {
                $('#search-section').fadeIn(300);
            });
            $('#searching-icon').hide();
            $('#search-icon').show();
            $('#nueva-consulta').html("Nueva Consulta");
        }
    };

    $('#id_visitado').mask('0000-0000-00000', options);

    //:::::::::::::::::::::::::::



    $('#btn-guardar').on('click', function () {
        //alert(id_visitado.replace(/-/g,""));
        getLocation();
    })

    /*$('label').addClass('acitve');*/
});

function redisignCard() {
    //CÓDIGO PARA CAMBIAR EL TOP A LA IMAGEN DE USUARIO 
    var altoDeCarta = $('.card-header').height();
    console.log("el alto es: " + altoDeCarta);
    var assigTop = altoDeCarta - 37;
    console.log(assigTop);
    $('.circle-image-in-card').css('top', assigTop);

}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    var lat = position.coords.latitude;
    var long = position.coords.longitude;
    var identidad = $('#identidad').text();
    var observacion = $('#observacion').text();
    var tipo_visita = $('#titulo-carta').text();
    var tipo_direccion = $('input[name="tipo_direccion"]:checked').val();
    console.log(
        "Latitude: " + lat + " Longitude: " + long +
        "\nObservación: " + observacion +
        "\nIdentidad: " + identidad +
        "\nTipo visita: " + tipo_visita.toLowerCase() +
        "\nTipo de Direccion: " + tipo_direccion
    );

    $.ajax({
        url: '../php/asesor/guardar-location.php',
        type: 'POST',
        data: {
            latitude: lat,
            longitude: long,
            identidad: identidad,
            observacion: observacion,
            tipo_visita: tipo_visita.toLowerCase(),
            tipo_direccion: tipo_direccion
        },
        beforeSend: function () {
            $('#loader-card').show();
        },
        success: function (data) {
            console.log(data);

            swal({
                    title: "Guardado!",
                    text: "El registro se ha guardado con éxito!",
                    type: "success"
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $('#loader-card').hide();
                        $('#' + window.idbtnmenuactivo).trigger('refresh');
                        /*$('#observacion-texto').text("");
                        $('#observacion').text("+ Agregar una observación");
                        $('input[name="tipo_direccion"]:checked').attr('checked',false); 
                        */
                        $('#id_visitado').val('');
                        setTimeout(function () {
                            $('#id_visitado').focus();
                        }, 1000);


                        /*$('#nombre').attr('data-tooltip',"");
                        $('#nombre').tooltip({delay: 50});*/

                        /*$('#main-section').hide();
                        $('#searching-icon').hide();
                        $('#search-section').show();*/
                    }
                }
            );

        },
        error: function (e) {
            console.log(e);
        },
        always: function () {
            console.log("complete");
        }
    });

}

/*var agregarBuscarCensoListeners = function(){

    $('.buscarcenso').each(function(){
        $(this).off('input').on('input', function(){
            buscarCenso($(this), false);
        });
    });

}*/

var rotation = function () {
    $("#searching-icon").rotate({
        angle: 0,
        animateTo: 180,
        callback: rotation
    });
}


var ultimaVisita = function (identidad) {
    //Consulta de última visita
    $.ajax({
            url: '../php/Asesor/buscar-bitacoraVisitas.php',
            type: 'POST',
            data: {
                id_visitado: identidad
            },
        })
        .done(function (data) {
            console.log(data);
            var obj = JSON.parse(data);

            //Si no existe en bitacora_visistas
            if (obj.length == 0) {
                $('#ultima-visita').text("Nunca visitado");
                $('#gestor-visitador').text("No tiene asesor asignado");

                //Si existe en bitacora_visitas
            } else {
                console.log(obj);
                $('#ultima-visita').text("Últ. Visita " + obj[0].fecha + " - " + obj[0].hora);
                $('#gestor-visitador').text("Por: " + obj[0].nombre);
            }
        })
        .fail(function () {
            console.log("error");
        });

}


var buscarCenso = function (current_elem, notificaciones = true) {

    let longitud = current_elem.length;
    var currelem = $('#nombre');
    console.log("CHEQUEAR ESTO:" + currelem);

    /*
    var inputelement = current_elem.parent().next().next().find('#ciclo-sugerido');*/

    if (longitud == 15) {

        /*if(notificaciones)
        Materialize.toast('Buscando..', 1000);*/
        /*currelem.next().addClass('active');*/

        $('#search-icon').hide();
        $('#searching-icon').show();
        $('#nueva-consulta').html("Buscando...");
        Materialize.toast('Buscando...', 2000)
        rotation();

        var tipoConsulta = "general"
        var identidad = current_elem;
        identidad = identidad.replace(/-/g, "");

        $.ajax({
            type: 'POST',
            url: '../consultas/consultas.php',
            data: {
                consulta: tipoConsulta,
                parametro: identidad
            },
            success: function (data) {
                var obj = JSON.parse(data);

                if (obj.length == 0) {
                    //Si no esta en Banca Solidaria realiza la búsqueda en el censo
                    tipoConsulta = "censo";
                    $.ajax({
                        type: 'POST',
                        url: '../consultas/consultas.php',
                        data: {
                            consulta: tipoConsulta,
                            parametro: identidad
                        },
                        success: function (data) {
                            var obj = JSON.parse(data);
                            console.log(obj);
                            if (obj.length == 0) {
                                console.log("No data");
                                $('#searching-icon').hide();
                                $('#nueva-consulta').html("Sin resultados<br>#ID Inválida");
                            } else {
                                let nombre = obj[0].primerNombre + ' ' + obj[0].segundoNombre + ' ' + obj[0].primerApellido + ' ' + obj[0].segundoApellido;
                                currelem.text(nombre);
                                currelem.attr('data-tooltip', nombre);
                                currelem.tooltip({
                                    delay: 50
                                });
                                $('#identidad').text(obj[0].identidad);
                                console.log("Censo");
                                var levantamiento = "Levantamiento";
                                $('#titulo-carta').text(levantamiento.toUpperCase());
                                //Consulta Últ. Visita
                                ultimaVisita(identidad);
                                $('#ultima-visita').text("Nunca Visitado. No hay fecha disponible");
                                $('#gestor-visitador').text("No tiene asesor asignado");
                                if (obj[0].sexo == "M") {
                                    $('.circle-image-in-card').attr("src", "../images/user.png");
                                } else {
                                    $('.circle-image-in-card').attr("src", "../images/user-girl.png");
                                }
                                $('#search-section').fadeOut(300, function () {
                                    $('#main-section').fadeIn(300);
                                    redisignCard();
                                });

                            }

                            Materialize.toast('Se encontró 1 resultado!', 1000)
                        },
                        error: function (data) {
                            Materialize.toast('Error! Intentelo mas tarde', 2000)
                        }
                    });
                } else {
                    let nombre = obj[0].Nombre;
                    currelem.text(nombre);
                    currelem.attr('data-tooltip', nombre);
                    currelem.tooltip({
                        delay: 50
                    });
                    $('#identidad').text(obj[0].identidad);
                    console.log("Banca Solidaria");
                    var visita = "visita";
                    $('#titulo-carta').text(visita.toUpperCase());
                    //Consulta Últ. Visita
                    ultimaVisita(identidad);
                    if (obj[0].sexo == "M") {
                        $('.circle-image-in-card').attr("src", "../images/user.png");
                    } else {
                        $('.circle-image-in-card').attr("src", "../images/user-girl.png");
                    }
                    $('#search-section').fadeOut(300, function () {
                        $('#main-section').fadeIn(300);
                        redisignCard();
                    });

                }

            },
            error: function (data) {
                /*if(notificaciones){
                    Materialize.toast(data, 2000);
                    console.log(data);
                }*/
            }
        });

    } else {

        currelem.val('Nombre');
        currelem.attr('readonly', 'readonly');

    }

}