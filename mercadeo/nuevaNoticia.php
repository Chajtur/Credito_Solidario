<?php 
    if (isset($_GET['accion'])) {
        $accion = 'accion';
    }

    if (isset($_GET['noticiaId'])) {
        $noticiaId = $_GET['noticiaId'];
    }
?>

<div class="row">
    <div class="col s12">
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <span class="card-title blue-text">Nueva noticia</span>
                    <form id="formGuardarNoticia">
                        <div class="input-field">
                            <input type="text" name="titulo" id="titulo" data-length="80">
                            <label for="titulo">Título</label>
                        </div>
                        <div class="input-field">
                            <input type="text" name="fecha" id="fecha" class="datepicker">
                            <label for="fecha">Fecha</label>
                        </div>
                        <div class="input-field">
                            <input type="text" name="hora" id="hora" class="timepicker">
                            <label for="hora">Hora</label>
                        </div>
                        <div class="input-field">
                            <input type="text" name="resumen" id="resumen" data-length="150">
                            <label for="resumen">Resumen</label>
                        </div>
                        <div class="input-field">
                            <textarea name="contenido" id="contenido" class="materialize-textarea"></textarea>
                            <label for="contenido">Contenido</label>
                        </div>
                        <div class="input-field">
                            <select name="estado" id="estado">
                                <option value="1">Activa</option>
                                <option value="0">Inactiva</option>
                            </select>
                            <label for="estado">Estado</label>
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <input type="hidden" name="usuario" id="usuario" value="ADRIAN">
                    <input type="hidden" name="noticiaId" id="noticiaId">
                    <button type="submit" class="btn-flat blue-text" id="btnRegistrar"><i class="material-icons right">send</i>Registrar</button>
                    <button class="waves-effect waves-light btn blue" id="btnNuevaImagen"><i class="material-icons right">add</i>imagen</button>
                </div>
            </div> 
        </div>
    </div>
</div>
<div class="row">
    <div id="tarjetaImagenes" class="card">
        <div class="card-content">
            <span class="card-title blue-text">Imágenes</span>
            <div id="contenedorImagenes" class="row">    
                
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalImagen">
    <div class="modal-content">
        <h4>Imagen de la noticia</h4>
        <form id="formImagen">
            <div class="file-field input-field">
                <div class="btn">
                    <span>Imagen</span>
                    <input type="file" id="imagen" name="imagen">
                </div>
                <div class="file-path-wrapper">
                    <input type="text" name="imagenPath" id="imagenPath" placeholder="Seleccione una imagen JPG/PNG" class="file-path validate">
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button id="btnRegistrarImagen" class="waves-effect waves-light btn green lighten-2" type="submit">Registrar</button>
        <button id="btnCancelarImagen" class="waves-effect waves-light btn red lighten-2" type="submit">Cancelar</button>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('select#estado').material_select();
        $('input#titulo, input#resumen').characterCounter();
        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: 15,
            today: 'Hoy',
            clear: 'Limpiar',
            close: 'Aceptar',
            closeOnSelect: false,
            container: undefined,
            monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',  'Octubre', 'Noviembre', 'Diciembre'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            weekdaysLetter: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            format: 'dd/mm/yyyy',
            onStart: function () {
                let date = new Date();
                this.set('select', [date.getFullYear(), date.getMonth() + 1, date.getDate()]);
            }
        });
        $('.timepicker').pickatime({
            default: 'now',
            fromnow: 0,
            twelvehour: false,
            donetext: 'Aceptar',
            cleartext: 'Cancelar',
            container: undefined,
            autoclose: false,
            ampmclickable: true
        });
        $('.modal').modal({
            dismissible: true,
            inDuration: 300,
            outDuration: 200
        });

        $('#btnNuevaImagen').click(function (evt) {
            $('#modalImagen').modal('open');
            evt.preventDefault();
        });

        $('#btnCancelarImagen').click(function (evt) {
            $('#modalImagen').modal('close');
            evt.preventDefault();
        });

        $('#btnRegistrar').click(function (evt) {
            let noticiaId = $('#noticiaId').val();
            if (noticiaId) {
                actualizarNoticia(noticiaId);
            } else {
                guardarNoticia();
            }

            evt.preventDefault();
        });

        $('#btnRegistrarImagen').click(function (evt) {
            let usuario = $('#usuario').val();
            let noticiaId = $('#noticiaId').val();
            let imagenNoticia = document.getElementById('imagen').files[0];

            //let form = $('#formImagen');
            let data = new FormData();
            data.append('usuario', usuario);
            data.append('accion', 'agregar');
            data.append('etiquetas', 'noticia');
            data.append('modulo', 'noticia');
            data.append('archivo', imagenNoticia);

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: data,
                url: 'http://localhost/fileServer/controlador/archivoControlador.php',
                success: function (data) {
                    archivoData = JSON.parse(data);

                    if (archivoData.error == 0) {
                        // Llama a una funcion para que guarde la ruta de la imagen en la base de datos
                        guardarImagen(archivoData.url, noticiaId);
                        
                    } else {
                        console.log('Archivo no enviado');
                    }
                },
                error: function () {

                }
            });
            evt.preventDefault();
        });   

        procesarNoticiaId();    
    });

    function procesarNoticiaId() {
        let noticiaId = $('#noticiaId').val();
        if (noticiaId) {
            $('#btnNuevaImagen').show();
        } else {
            // ocultar botn de imagen
            $('#btnNuevaImagen').hide();
        }
    }

    function guardarNoticia() {
        $('#btnRegistrar').addClass('disabled');
        let userDate = $('#fecha').val();
        let phpDate = userDate.split('/').reverse().join('-');
        let hora = $('#hora');
        phpDate = phpDate + ' ' + hora.val() + ':00';

        let noticia = {
            titulo: $('#titulo').val(),
            contenido: $('#contenido').val(),
            resumen: $('#resumen').val(),
            fecha: phpDate, 
            estado: $('#estado').val(),
            usuario: $('#usuario').val(),
            accion: 'agregar'
        };

        $.ajax({
            type: 'POST',
            url: '../php/mercadeo/controlador.php',
            data: noticia,
            success: function (data) {
                let noticiaData = JSON.parse(data);
                $('#btnRegistrar').removeClass('disabled');
                if (noticiaData.noticiaId >= 1) {
                    $('#noticiaId').val(noticiaData.noticiaId);
                    procesarNoticiaId();
                    swal('Correcto','Se ha registrado la noticia correctamente', 'success');
                    $('#floating-refresh').trigger('click');
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }

    function actualizarNoticia(noticiaId) {
        $('#btnRegistrar').addClass('disabled');
        let userDate = $('#fecha').val();
        let phpDate = userDate.split('/').reverse().join('-');
        let noticia = {
            noticiaId: noticiaId,
            titulo: $('#titulo').val(),
            contenido: $('#contenido').val(),
            resumen: $('#resumen').val(),
            fecha: phpDate,
            estado: $('#estado').val(),
            usuario: $('#usuario').val(),
            accion: 'actualizar'
        };

        $.ajax({
            type: 'POST',
            url: '../php/mercadeo/controlador.php',
            data: noticia,
            success: function (data) {
                let respuestaData = JSON.parse(data);
                $('#btnRegistrar').removeClass('disabled');
                if (respuestaData.error == 0) {
                    swal('Correcto','Se ha actuaizado la noticia correctamente', 'success');
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }

    function guardarImagen(url, noticiaId) {
        let objeto = {
            url: url,
            noticiaId: noticiaId,
            accion: 'agregar-archivo'
        };

        $.ajax({
            type: 'POST',
            data: objeto,
            url: '../php/mercadeo/controlador.php',
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se ha registrado la imagen correctamente', 'success');
                    recuperarImagenes(noticiaId);
                    $('#modalImagen').modal('close');
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }

    function recuperarImagenes(noticiaId) {
        let grillaImagenes = $('#contenedorImagenes');
        grillaImagenes.text('');
        let imagenesTxt = '';

        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/controlador.php?accion=listar-imagenes&noticiaId=' + noticiaId,
            success: function (data) {
                let imagenes = JSON.parse(data);
                $.each(imagenes, function (i, imagen) {
                    imagenesTxt += '<div class="col s12 m6 l4">';
                    imagenesTxt += '<div class="card">';
                    imagenesTxt += '<div class="card-image">';
                    imagenesTxt += '<img src="' + imagen.url + '" alt="">';
                    imagenesTxt += '</div>';
                    imagenesTxt += '<div class="card-action right">';
                    imagenesTxt += '<a href="#!" class="btn red" onclick="eliminarImagen(' + imagen.noticiaId +','+ imagen.imagenNoticiaId + ')"><i class="material-icons red">clear</i></a>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '</div>';
                });

                grillaImagenes.html(imagenesTxt);
            }
        });
    }

    function eliminarImagen(noticiaId, imagenId) {
        let objeto = {
            noticiaId: noticiaId,
            imagenId: imagenId,
            accion: 'eliminar-imagen'
        };
        console.log('imagen eliminada.');

        $.ajax({
            type: 'POST',
            data: objeto,
            url: '../php/mercadeo/controlador.php',
            success: function (data) {
                let objetoData = JSON.parse(data);

                if (objetoData.error == 0) {
                    swal('Correcto','Se ha eliminado la imagen correctamente', 'success');
                    recuperarImagenes(noticiaId);
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }
</script>