<?php
    session_start();
?>

<div class="row">
    <div class="card col s12">
        <div class="card-content">
            <span class="card-title blue-text">Gestión del personal</span>            
                <div class="row">                        
                    <div class="input-field col s10">
                        <input type="text" name="busqueda" placeholder="Búsqueda" id="busqueda" data-length="25" class="validate">
                        <label for="busqueda"></label>
                    </div>
                    <div class="input-field col s1">
                        <button data-position="top" data-delay="50" data-tooltip="Refrescar" class="waves-effect waves-light btn green lighten-2 tooltipped" id="btn-refrescar" name="btn-refrescar"><i class="material-icons">refresh</i></button>
                    </div>
                    
                    <div class="input-field col s1">
                        <button data-position="top" data-delay="50" data-tooltip="Agregar imagen" class="waves-effect waves-light btn teal lighten-2 tooltipped" id="btn-nuevo" name="btn-nuevo"><i class="material-icons">add</i></button>
                        <input type="hidden" name="usuario" id="usuario" value="<?php //echo $_SESSION['user'] ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="grilla-imagenes"></div>

<div class="modal" id="modal-datos">
    <div class="modal-content">
        <h4>Información del empleado</h4>
        <form id="formDatos">
            <div class="input-field">
                <input type="text" name="nombre" placeholder="Nombre" id="nombre" class="validate">
                <label for="nombre">Nombre</label>
            </div>
            <div class="input-field">
                <input type="text" name="cargo" placeholder="Cargo" id="cargo" class="validate">
                <label for="cargo">Cargo</label>
            </div>
            <div class="input-field">
                <select name="estado" id="estado">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="personal-id" id="personal-id">
        <button id="btnRegistrarDatos" class="waves-effect waves-light btn green lighten-2" type="submit">Registrar</button>
        <button id="btnCancelarDatos" class="waves-effect waves-light btn red lighten-2" type="submit">Cancelar</button>
    </div>
</div>

<div class="modal" id="modal-imagen">
    <div class="modal-content">
        <h4>Foto del empleado</h4>
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
        <input type="hidden" name="personal-id" id="personal-id">
        <button id="btnRegistrarImagen" class="waves-effect waves-light btn green lighten-2" type="submit">Registrar</button>
        <button id="btnCancelarImagen" class="waves-effect waves-light btn red lighten-2" type="submit">Cancelar</button>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('select').material_select();
        $('.modal').modal({
            dismissible: true,
            inDuration: 300,
            outDuracion: 200
        });

        $('#btn-refrescar').click(function (evt) {
            obtenerImagenes();
        });

        $('#btn-nuevo').click(function (evt) {
            abrirModalInformacion();
        });

        $('#btnRegistrarDatos').click(function (evt) {
            guardarDatos();
        });

        $('#btnCancelarDatos').click(function (evt) {
            $('#modal-datos').modal('close');
        });

        $('#btnCancelarImagen').click(function (evt) {
            $('#modal-imagen').modal('close');
        });
    });

    function abrirModalInformacion(personalId) {
        if (personalId) {
            $('#personal-id').val(personalId);
        } else {
            $('#personal-id').val(undefined);
        }
        $('#modal-datos').modal('open');
    }

    function abrirModalImagen(personalId) {
        if (personalId) {
            $('#personal-id').val(personalId);
            $('#imagen').attr('disabled', true);
            $('#imagenPath').attr('disabled', true);
            //mostrarImagen(usuarioId);            
        } else {
            $('#personal-id').val(undefined);
            /*$('#imagenPath').attr('disabled', false);
            $('#imagen').attr('disabled', false);*/
        }
        $('#modal-imagen').modal('open');
    }

    function guardarDatos() {
        let personal = {
            accion: 'agregar-datos',
            nombre: $('#nombre').val(),
            cargo: $('#cargo').val(),
            url: 'http://fs.creditosolidario.hn/uploads/pruebas/2018/09/5bae8cf39f86d8.28113653.png',
            estado: $('#estado').val()
        };

        $.ajax({
            type: 'POST',
            url: '../php/mercadeo/personalCtrl.php',
            data: personal,
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se han registrado los datos correctamente', 'success');
                    $('#modal-datos').modal('close');
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }

    function guardarArchivoImagen() {
        let imagenArchivo = document.getElementById('imagen').files[0];
        let data = new FormData();
        let usuario = $('#usuario').val();
        let id = $('#personal-id');

        data.append('usuario', usuario);
        data.append('accion', 'agregar');
        data.append('etiquetas', 'personal,familiar');
        data.append('modulo', 'familia');
        data.append('archivo', imagenArchivo);

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
                    guardarImagen(id, archivoData.url);
                } else {
                    console.log('Archivo no enviado.');
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    function guardarImagen(personalId, url) {
        let accion = 'agregar-imagen';

        let objeto = {
            id: personalId,
            url: url,
            accion: accion
        };

        $.ajax({
            type: 'POST',
            url: '../php/mercadeo/personalCtrl.php',
            data: objeto,
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se han registrado los datos correctamente', 'success');
                    $('#modal-imagen').modal('close');
                    obtenerImagenes();
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }

    function obtenerImagenes() {
        let grillaImagenes = $('#grilla-imagenes');
        let imagenesTxt = '';

        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/personalCtrl.php?accion=listar&estado=1',
            success: function (data) {
                let imagenes = JSON.parse(data);
                $.each(imagenes, function (i, imagen) {
                    imagenesTxt += '<div class="col s12 m4">';
                    imagenesTxt += '<div class="card">';
                    imagenesTxt += '<div class="card-image">';
                    imagenesTxt += '<img src="'+ imagen.url +'" alt="">';
                    imagenesTxt += '<span class="card-title black-text">'+ imagen.nombre +'</span>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '<div class="card-content">'+ imagen.cargo +'</div>';
                    imagenesTxt += '<div class="card-action">';
                    //imagenesTxt += '<a href="#!" onclick="eliminarImagen('+ imagen.carruselId +')"><i class="material-icons green-text right">image</i></a>';
                    imagenesTxt += '<a href="#!" onclick="abrirModalInformacion('+ imagen.id +')"><i class="material-icons blue-text right">create</i></a>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '</div>';
                });
                grillaImagenes.html(imagenesTxt);
            }
        });
    }

    function mostrarInformacion(personalId) {
        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/personalCtrl?accion=mostrar&id='+personalId,
            success: function (data) {
                
            }
        });
    }
</script>