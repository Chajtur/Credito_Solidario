$(document).ready(function () {

                /*//CÓDIGO PARA CAMBIAR EL TOP A LA IMAGEN DE USUARIO 
                var altoDeCarta = $('.card-header').height();
                console.log("el alto es: " + altoDeCarta);
                var assigTop = altoDeCarta - 37;
                console.log(assigTop);
                $('.circle-image-in-card').css('top', assigTop);*/

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