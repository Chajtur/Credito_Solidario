<?php
    session_start();
?>

<div class="row">
    <div class="card col s12">
        <div class="card-content">
            <span class="card-title blue-text">Gestión de departamentos</span>
            
                <div class="row">
                    <div class="input-field col s11">
                        <select name="departamentos" id="departamentos">
                            
                        </select>
                        <label for="departamentos"></label>
                    </div>
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
        <h4>Imagen del departamento</h4>
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
        obtenerDepartamentos();
        let optionSelected;
        let valueSelected;

        $('.tooltipped').tooltip({delay: 50});

        $('.modal').modal({
            dismissible: true,
            inDuration: 300,
            outDuration: 200
        });

        $('#departamentos').on('change', function (evt) {
            optionSelected = $('option:selected', this);
            valueSelected = this.value;
            $('#departamentoId').val(valueSelected);

            obtenerImagenesDepartamentos(valueSelected);
        });

        $('#btn-nuevo').click(function (evt) {
            abrirModalImagen(valueSelected);
        });
        $('#btnCancelarImagen').click(cerrarModalImagen);
        $('#btnRegistrarImagen').click(function (evt) {
            let departamentoId = $('#departamentoId').val();
            registrarImagen(departamentoId);
        });
    });

    function obtenerDepartamentos() {
        let selectDepartamentos = $('#departamentos');
        selectDepartamentos.text('');
        let departamentosTxt = '<option value="">Seleccione un departamento</option>';

        $.ajax({
            type: 'GET',
            url: '../php/mantenimientos/departamentos.php?accion=listar',
            success: function (data) {
                let departamentos = JSON.parse(data);
                $.each(departamentos, function (i, departamento) {
                    departamentosTxt += '<option value="'+ departamento.iddepartamento +'">'+ departamento.nombre +'</option>';
                });

                selectDepartamentos.html(departamentosTxt);

                $('select').material_select();
            },
            error: function (xhr, status, error) {
                
            }
        });
    }

    function obtenerImagenesDepartamentos(departamentoId) {
        let grillaImagenes = $('#grilla-imagenes');
        grillaImagenes.text('');
        let imagenesTxt = '';

        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/departamentoImagen.php?accion=listar&departamentoId=' + departamentoId,
            success: function (data) {
                let imagenes = JSON.parse(data);
                $.each(imagenes, function (i, imagen) {
                    imagenesTxt += '<div class="col s12 m4">';
                    imagenesTxt += '<div class="card">';
                    imagenesTxt += '<div class="card-image">';
                    imagenesTxt += '<img src="'+ imagen.url +'" alt="">';
                    imagenesTxt += '<span class="card-title"></span>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '<div class="card-action">';
                    imagenesTxt += '<a href="#!" onclick="eliminarImagen(\''+ departamentoId + '\',' + imagen.idImagenDepartamento +')"><i class="material-icons red-text right">clear</i></a>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '</div>';
                    imagenesTxt += '</div>';
                });

                grillaImagenes.html(imagenesTxt);
            }
        });
    }

    function abrirModalImagen(departamentoId) {
        if (departamentoId) {
            $('#modalImagen').modal('open');
        } else {
            Materialize.toast('Debe seleccionar un departamento.', 2000);
        }
    }

    function cerrarModalImagen() {
        $('#modalImagen').modal('close');
    }

    function registrarImagen(departamentoId) {
        let usuario = $('#usuario').val();
        let imagenDepartamento = document.getElementById('imagen').files[0];

        if (imagenDepartamento) {
            let data = new FormData();
            data.append('usuario', usuario);
            data.append('accion', 'agregar');
            data.append('etiquetas', 'departamento');
            data.append('modulo', 'departamento');
            data.append('archivo', imagenDepartamento);

            $('#btnRegistrarImagen').addClass('disabled');

            // Primero hace el guardado de la imagen en el servidor de imagenes.
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: data,
                url: 'http://fs.creditosolidario.hn/controlador/archivoControlador.php',
                success: function (data) {
                    // Despues hace el guardado de la url dentro del sistema.
                    let archivoData = JSON.parse(data);

                    if (archivoData.error == 0) {
                        guardarImagen(archivoData.url, departamentoId);
                    } else {
                        console.log('Archivo no enviado.');
                    }

                    $('#btnRegistrarImagen').removeClass('disabled');
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        } else {
            Materialize.toast('Debe seleccionar una imagen.', 2000);
        }
    }

    function guardarImagen(url, departamentoId) {
        let objeto = {
            url: url,
            departamentoId: departamentoId,
            accion: 'agregar-archivo',
            estado: 1
        };

        $.ajax({
            type: 'POST',
            data: objeto,
            url: '../php/mercadeo/departamentoImagen.php',
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se ha registrado la imagen correctamente', 'success');
                    $('#modalImagen').modal('close');
                    obtenerImagenesDepartamentos(departamentoId);
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }

    function eliminarImagen(departamentoId, imagenDepartamentoId) {
        let imagen = {
            departamentoId: departamentoId,
            imagenDepartamentoId: imagenDepartamentoId,
            accion: 'eliminar'
        };

        $.ajax({
            type: 'POST',
            data: imagen,
            url: '../php/mercadeo/departamentoImagen.php',
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se ha eliminado la imagen correctamente', 'success');
                    obtenerImagenesDepartamentos(departamentoId);
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }
</script>