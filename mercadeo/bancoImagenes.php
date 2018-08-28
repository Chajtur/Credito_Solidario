<?php
    session_start();
?>

<div class="row">
    <div class="card col s12">
        <div class="card-content">
            <span class="card-title blue-text">Gestión del banco de imágenes</span>            
                <div class="row">
                    <div class="col s11"></div>                    
                    <div class="col s1">
                        <button data-position="top" data-delay="50" data-tooltip="Agregar imagen" class="waves-effect waves-light btn teal lighten-2 tooltipped" id="btn-nuevo" name="btn-nuevo"><i class="material-icons">add</i></button>
                        <input type="hidden" name="usuario" id="usuario" value="<?php $_SESSION['user'] ?>">
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
        obtenerBancoImagenes();

        $('.modal').modal({
            dismissible: true,
            inDuration: 300,
            outDuration: 200
        });

        $('#btn-nuevo').click(function (evt) {
            abrirModalImagen();
        });
        $('#btnCancelarImagen').click(function (evt) {
            cerrarModalImagen();
        });
        $('#btnRegistrarImagen').click(function (evt) {
            registrarImagen();
        });
    });

    function obtenerBancoImagenes() {
        let grillaImagenes = $('#grilla-imagenes');
        let imagenesTxt = '';

        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/bancoImagenes.php?accion=listar&estado=1',
            success: function (data) {
                let imagenes = JSON.parse(data);
                console.log(imagenes);
                $.each(imagenes, function (i, imagen) {
                    imagenesTxt += '<div class="col s12 m4">';
                    imagenesTxt += '<div class="card">';
                    imagenesTxt += '<div class="card-image">';
                    imagenesTxt += '<img src="'+ imagen.url +'" alt="">';
                    imagenesTxt += '</div>';
                    imagenesTxt += '<div class="card-action">'
                    imagenesTxt += '<a href="#!" onclick="eliminarImagen('+ imagen.bancoImagenId +')"><i class="material-icons red-text right">clear</i></a>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '</div>';
                });

                grillaImagenes.html(imagenesTxt);
            },
            error: function (xhr, status, error) {

            }
        });
    }

    function abrirModalImagen() {
        $('#modalImagen').modal('open');
    }

    function cerrarModalImagen() {
        $('#modalImagen').modal('close');
    }

    function registrarImagen() {
        let usuario = $('#usuario').val();
        let imagenBanco = document.getElementById('imagen').files[0];

        if (imagenBanco) {
            let data = new FormData();
            data.append('usuario', usuario);
            data.append('accion', 'agregar');
            data.append('etiquetas', 'galeria,banco,beneficiario');
            data.append('modulo', 'galeria');
            data.append('archivo', imagenBanco);

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: data,
                url: 'http://fs.creditosolidario.hn/controlador/archivoControlador.php',
                success: function (data) {
                    let archivoData = JSON.parse(data);

                    if (archivoData.error == 0) {
                        guardarImagen(archivoData.url);
                    } else {
                        console.log('Archivo no enviado.');
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        } else {
            Materialize.toast('Debe seleccionar una imagen.', 2000);
        }
    }

    function guardarImagen(url) {
        let objeto = {
            url: url,
            accion: 'agregar',
            estado: 1
        };

        $.ajax({
            type: 'POST',
            data: objeto,
            url: '../php/mercadeo/bancoImagenes.php',
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se ha registrado la imagen correctamente', 'success');
                    $('#modalImagen').modal('close');
                    obtenerBancoImagenes();
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }

    function eliminarImagen(bancoImagenId) {
        let imagen = {
            bancoImagenId: bancoImagenId,
            accion: 'eliminar'
        };

        $.ajax({
            type: 'POST',
            url: '../php/mercadeo/bancoImagenes.php',
            data: imagen,
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se ha eliminado la imagen correctamente', 'success');
                    obtenerBancoImagenes();
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }
</script>