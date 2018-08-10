<div class="row">
    <div class="card col s12">
        <div class="card-content">
            <span class="card-title blue-text">Gestión del carrusel</span>            
                <div class="row">
                    <div class="col s11"></div>                    
                    <div class="col s1">
                        <button data-position="top" data-delay="50" data-tooltip="Agregar imagen" class="waves-effect waves-light btn teal lighten-2 tooltipped" id="btn-nuevo" name="btn-nuevo"><i class="material-icons">add</i></button>
                        <input type="hidden" name="usuario" id="usuario" value="ADRIAN">
                        <input type="hidden" name="departamentoId" id="departamentoId">
                    </div>
                </div>
            
            <div id="grilla-imagenes"></div>
        </div>
    </div>
</div>

<div class="modal" id="modalImagen">
    <div class="modal-content">
        <h4>Imagen de la galería</h4>
        <form id="formImagen">
            <div class="input-field">
                <input type="text" name="etiqueta-principal" placeholder="Etiqueta principal" id="etiqueta-principal" data-length="25" class="validate">
                <label for="etiqueta-principal"></label>
            </div>
            <div class="input-field">
                <input type="text" name="etiqueta-secundaria" placeholder="Etiqueta secundaria" id="etiqueta-secundaria" data-length="25" class="validate">
                <label for="etiqueta-secundaria"></label>
            </div>
            <div class="input-field">
                <select name="alineacion" id="alineacion">
                    <option value="1">Centro</option>
                    <option value="2">Izquierda</option>
                    <option value="3">Derecha</option>
                </select>
                <label for="alineacion">Alineación de las etiquetas</label>
            </div>
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
        <input type="hidden" name="carruselId" id="carruselId">
        <button id="btnRegistrarImagen" class="waves-effect waves-light btn green lighten-2" type="submit">Registrar</button>
        <button id="btnCancelarImagen" class="waves-effect waves-light btn red lighten-2" type="submit">Cancelar</button>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.modal').modal({
            dismissible: true,
            inDuration: 300,
            outDuration: 200
        });

         $('input#etiqueta-principal, input#etiqueta-secundaria').characterCounter();

        //$('select').material_select();
        $('#alineacion').material_select();

        $('#btn-nuevo').click(function (evt) {
            abrirModalImagen();
        });
        $('#btnCancelarImagen').click(function (evt) {
            cerrarModalImagen();
        });
        $('#btnRegistrarImagen').click(function (evt) {
            let carruselId = $('#carruselId').val();
            registrarImagen(carruselId);
        });

        obtenerImagenes();
    });

    function obtenerImagenes() {
        let grillaImagenes = $('#grilla-imagenes');
        let imagenesTxt = '';

        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/carrusel.php?accion=listar&estado=1',
            success: function (data) {
                let imagenes = JSON.parse(data);
                $.each(imagenes, function (i, imagen) {
                    imagenesTxt += '<div class="col s12 m4">';
                    imagenesTxt += '<div class="card">';
                    imagenesTxt += '<div class="card-image">';
                    imagenesTxt += '<img src="'+ imagen.url +'" alt="">';
                    imagenesTxt += '<span class="card-title">'+ imagen.etiquetaPrincipal +'</span>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '<div class="card-content">'+ imagen.etiquetaSecundaria +'</div>';
                    imagenesTxt += '<div class="card-action">';
                    imagenesTxt += '<a href="#!" onclick="eliminarImagen('+ imagen.carruselId +')"><i class="material-icons red-text right">clear</i></a>';
                    imagenesTxt += '<a href="#!" onclick="abrirModalImagen('+ imagen.carruselId +')"><i class="material-icons blue-text right">create</i></a>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '</div>';
                });
                grillaImagenes.html(imagenesTxt);
            }
        });
    }

    function abrirModalImagen(carruselId) {
        if (carruselId) {
            $('#carruselId').val(carruselId);
            $('#imagen').attr('disabled', true);
            $('#imagenPath').attr('disabled', true);
            mostrarImagen(carruselId);            
        } else {
            $('#carruselId').val(undefined);
            $('#imagenPath').attr('disabled', false);
            $('#imagen').attr('disabled', false);
        }
        $('#modalImagen').modal('open');
    }

    function cerrarModalImagen() {
        $('#formImagen').get(0).reset();
        $('#modalImagen').modal('close');
    }

    function mostrarImagen(carruselId) {
        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/carrusel.php?accion=mostrar&carruselId=' + carruselId,
            success: function (data) {
                let imagenes = JSON.parse(data);
                let imagen = imagenes[0];
                console.log(imagen.alineacion);
                $('#etiqueta-principal').val(imagen.etiquetaPrincipal);
                $('#etiqueta-secundaria').val(imagen.etiquetaSecundaria);
                $('#alineacion').val(imagen.alineacion).trigger('change');
                $('#imagenPath').val(imagen.url);
                $('#alineacion').material_select();
            }
        });
    }

    function registrarImagen(carruselId) {
        let etiquetaPrincipal = $('#etiqueta-principal').val();
        let etiquetaSecundaria = $('#etiqueta-secundaria').val();
        let alineacion = $('#alineacion').val();
        let usuario = $('#usuario').val();
        let imagenCarrusel = document.getElementById('imagen').files[0];
        let rutaImagen = $('#imagenPath').val();

        if (imagenCarrusel || carruselId) {
            let data = new FormData();
            data.append('usuario', usuario);
            data.append('accion', 'agregar');
            data.append('etiquetas', 'galeria,banco,beneficiario');
            data.append('modulo', 'galeria');
            data.append('archivo', imagenCarrusel);

            if (carruselId) {
                guardarImagen(carruselId, etiquetaPrincipal, etiquetaSecundaria, alineacion, rutaImagen, usuario);
            } else {
                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: data,
                    url: 'http://localhost/fileServer/controlador/archivoControlador.php',
                    success: function (data) {
                        let archivoData = JSON.parse(data);
                        if (archivoData.error == 0) {
                            guardarImagen(undefined, etiquetaPrincipal, etiquetaSecundaria, alineacion, archivoData.url, usuario);
                        } else {
                            console.log('Archivo no enviado.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        } else {
            Materialize.toast('Debe seleccionar una imagen.', 2000);
        }
    }

    function guardarImagen(carruselId, etiquetaPrincipal, etiquetaSecundaria, alineacion, url, usuario) {
        let accion = 'agregar';

        if (carruselId) {
            accion = 'actualizar';
        }

        let objeto = {
            carruselId: carruselId,
            etiquetaPrincipal: etiquetaPrincipal,
            etiquetaSecundaria: etiquetaSecundaria,
            alineacion: alineacion,
            estado: 1,
            url: url,
            usuario: usuario,
            accion: accion
        };

        $.ajax({
            type: 'POST',
            url: '../php/mercadeo/carrusel.php',
            data: objeto,
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se ha registrado la imagen correctamente', 'success');
                    $('#modalImagen').modal('close');
                    obtenerImagenes();
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            },
            error: function (xhr, status, error) {

            }
        });
    }

    function eliminarImagen(carruselId) {
        $.ajax({
            type: 'POST',
            url: '../php/mercadeo/carrusel.php',
            data: {
                carruselId: carruselId,
                accion: 'eliminar'
            },
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se ha eliminado la imagen correctamente', 'success');
                    $('#modalImagen').modal('close');
                    obtenerImagenes();
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            },
            error: function (xhr, status, error) {

            }
        });
    }
</script>