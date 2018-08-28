<?php
    session_start();
?>

<div class="row">
    <div class="card col s12">
        <div class="card-content">
            <span class="card-title blue-text">Gestión de programas</span>
            <form>
                <div class="row">
                    <div class="input-field col s10">
                        <i class="material-icons prefix">search</i>
                        <input type="text" name="busqueda" id="busqueda">
                        <label for="busqueda">Búsqueda</label>
                    </div>                  
                    <div class="col s1">
                        <button class="waves-effect waves-light btn green lighten-2" id="btn-buscar" name="btn-buscar"><i class="material-icons">refresh</i></button>
                        <input type="hidden" name="usuario" id="usuario" value="<?php $_SESSION['user'] ?>">
                    </div>
                    <div class="col s1">
                     <!-- 
                         <button data-position="top" data-delay="50" data-tooltip="Agregar imagen" class="waves-effect waves-light btn teal lighten-2 tooltipped" id="btn-nuevo" name="btn-nuevo"><i class="material-icons">add</i></button>
                      -->
                    </div>
                </div>
            </form>                  
            <div id="grilla-imagenes"></div>
        </div>
    </div>
</div>

<div class="modal modal-fixed-footer" id="modal-informacion">
    <div class="modal-content">
        <h4>Infomacion del producto</h4>
        <form id="form-datos">
            <div class="input-field">
                <input type="text" name="id-programa" placeholder="Id" id="id-programa" data-length="6" class="validate" disabled>
                <label for="id-programa"></label>
            </div>            
            <div class="input-field">
                <input type="text" name="subprograma" placeholder="Subprograma" id="subprograma" data-length="50" class="validate" disabled>
                <label for="subprograma"></label>
            </div>
            <div class="input-field">
                <input type="text" name="descripcion" placeholder="Descripción" id="descripcion" data-length="5000" class="validate">
                <label for="etiqueta-secundaria"></label>
            </div>
            <div class="input-field">
                <select name="programa" id="programa">
                    <option value="Escalonado">Escalonado</option>
                    <option value="Crédito Rural">Crédito Rural</option>
                    <option value="Banca Joven">Banca Joven</option>
                    <option value="Bici Solidaria">Bici Solidaria</option>
                    <option value="Movilizador">Movilizador</option>
                    <option value="MIPYME">MIPYME</option>
                    <option value="Ayuda Solidaria">Ayuda Solidaria</option>
                </select>
                <label for="programa">Programa</label>
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
        <input type="hidden" name="programa-id" id="programa-id">
        <button id="btn-registrar-datos" class="waves-effect waves-light btn green lighten-2" type="submit">Registrar</button>
        <button id="btn-cancelar-datos" class="waves-effect waves-light btn red lighten-2" type="submit">Cancelar</button>
    </div>
</div>

<div class="modal" id="modal-imagen">
    <div class="modal-content">
        <h4>Cambiar del producto</h4>
        <form id="form-imagen">
            <div class="file-field input-field">
                <div class="btn">
                    <span>Imagen</span>
                    <input type="file" id="imagen-actualizada" name="imagen-actualizada">
                </div>
                <div class="file-path-wrapper">
                    <input type="text" name="imagenPath-actualizada" id="imagenPath-actualizada" placeholder="Seleccione una imagen JPG/PNG" class="file-path validate">
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="programa-id-imagen" id="programa-id-imagen">
        <button id="btn-registrar-imagen" class="waves-effect waves-light btn green lighten-2" type="submit">Registrar</button>
        <button id="btn-cancelar-imagen" class="waves-effect waves-light btn red lighten-2" type="submit">Cancelar</button>
    </div>
</div>

<script>
    $(document).ready( function(){
        $('.modal').modal({
            dismissible: true,
            inDuration: 300,
            outDuration: 200
        });

        $('input#id-programa, input#subprograma, input#descripcion').characterCounter();

        $('#programa').material_select();

        $('#btn-registrar-datos').click(function (evt) {
            let programaId = $('#programa-id').val();
            console.log(programaId);
            registrarImagen(programaId);
        });

        $('#btn-registrar-imagen').click(function (evt) {
            let programaId = $('#programa-id-imagen').val();
            console.log(programaId);
            registrarImagen(programaId);
        });

        $('#btn-nuevo').click(function (evt) {
            abrirModalInformacion();
        });

        $('#btn-cancelar-datos').click(function (evt) {
            cerrarModalInformacion();
        });

        $('#btn-cancelar-imagen').click(function (evt) {
            cerrarModalImagen();
        });

        $('#btn-buscar').click(function (evt) {
            let busqueda = $('#busqueda').val();
            obtenerImagenes(busqueda);

            evt.preventDefault();
        });

        obtenerImagenes('');
    });

    function abrirModalImagen(programaId) {
        $('#programa-id-imagen').val(programaId);
        $('#modal-imagen').modal('open');
    }

    function cerrarModalImagen() {
        $('#programa-id-imagen').val(undefined);
        $('#modal-imagen').modal('close');
    }

    function obtenerImagenes(busqueda) {
        let grillaImagenes = $('#grilla-imagenes');
        let programasTxt = '';

        $.ajax({
            type: 'GET',
            url: '../php/mantenimientos/programa.php?accion=listar&estado=1&busqueda='+busqueda,
            success: function (data) {
                let programas = JSON.parse(data);
                console.log(programas);
                $.each(programas, function (i, programa) {
                    let urlImagen = programa.url_imagen;
                    if (!urlImagen) {
                        urlImagen = '../images/imagen-defecto.jpg';
                    }
                    programasTxt += '<div class="col s12 m4">';
                    programasTxt += '<div class="card">';
                    programasTxt += '<div class="card-image">';
                    programasTxt += '<img src="'+ urlImagen +'" alt="sin imagen" />';
                    //programasTxt += '<span class="card-title grey-text">'+  +'</span>';
                    programasTxt += '</div>';
                    programasTxt += '<div class="card-content"><strong>'+ programa.subprograma +'<br /></strong>'+ programa.descripcion +'</div>';
                    programasTxt += '<div class="card-action">';
                    programasTxt += '<a href="#!" onclick="abrirModalImagen(\''+ programa.id +'\')"><i class="material-icons teal-text">image</i></a>';
                    programasTxt += '<a href="#!" onclick="abrirModalInformacion(\''+ programa.id +'\')"><i class="material-icons blue-text">create</i></a>';
                   // programasTxt += '<a href="#!" onclick="eliminarProducto(\''+ programa.id +'\')"><i class="material-icons red-text">clear</i></a>';
                    programasTxt += '</div>';
                    programasTxt += '</div>';
                    programasTxt += '</div>';
                });

                grillaImagenes.html(programasTxt);
            }
        });
    }

    function abrirModalInformacion(programaId) {
        if (programaId) {
            $('#programa-id').val(programaId);
            $('#imagen').attr('disabled', true);
            $('#imagenPath').attr('disabled', true);
            mostrarDatos(programaId);
        } else {
            $('#programa-id').val(undefined);
            $('#imagenPath').attr('disabled', false);
            $('#imagen').attr('disabled', false);
        }
        $('#modal-informacion').modal('open');
    }

    function cerrarModalInformacion() {
        $('#form-datos').get(0).reset();
        $('#modal-informacion').modal('close');
    }

    function mostrarDatos(programaId) {
        $.ajax({
            type: 'GET',
            url: '../php/mantenimientos/programa.php?accion=mostrar&programaId=' + programaId,
            success: function (data) {
                let programas = JSON.parse(data);
                let programa = programas[0];
                $('#id-programa').val(programaId);
                $('#subprograma').val(programa.subprograma);
                $('#descripcion').val(programa.descripcion);
                $('#programa').val(programa.programa).trigger('change');
                $('#imagenPath').val(programa.url);
                $('#programa').material_select();
            }
        });
    }

    function registrarImagen(productoId) {
        let idPrograma = $('#id-programa').val();
        let subprograma = $('#subprograma').val();
        let descripcion = $('#descripcion').val();
        let programa = $('#programa').val();
        let usuario = $('#usuario').val();
        let imagenSubPrograma = document.getElementById('imagen').files[0];
        let rutaImagen = $('#imagenPath').val();

        if (!imagenSubPrograma) {
            imagenSubPrograma = document.getElementById('imagen-actualizada').files[0];
        }

        if (imagenSubPrograma || productoId) {
            let data = new FormData();
            data.append('usuario', usuario);
            data.append('accion', 'agregar');
            data.append('etiquetas', 'programa,producto');
            data.append('modulo', 'programa');
            data.append('archivo', imagenSubPrograma);

            if (productoId) {
                if (imagenSubPrograma) {
                    idPrograma = $('#programa-id-imagen').val();
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
                                guardarDatos(idPrograma, subprograma, descripcion, programa, archivoData.url, 'actualizar-imagen');
                            } else {
                                console.log('Archivo no enviado.');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(error);
                        }
                    });
                } else {
                    guardarDatos(idPrograma, subprograma, descripcion, programa, rutaImagen, 'actualizar');
                }
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
                            guardarDatos(idPrograma, subprograma, descripcion, programa, archivoData.url, 'agregar');
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

    function guardarDatos(idPrograma, subprograma, descripcion, programa, url, accion) {
        let objeto = {
            programaId: idPrograma,
            subprograma: subprograma,
            descripcion: descripcion,
            programa: programa,
            url: url,
            accion: accion
        };
        let busqueda = $('#busqueda').val();

        $.ajax({
            type: 'POST',
            url: '../php/mantenimientos/programa.php',
            data: objeto,
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se han registrado los datos correctamente', 'success');
                    cerrarModalInformacion();
                    cerrarModalImagen();
                    obtenerImagenes(busqueda);
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }

    function eliminarProducto(idPrograma) {
        let busqueda = $('#busqueda').val();

        $.ajax({
            type: 'POST',
            url: '../php/mantenimientos/programa.php',
            data: {
                programaId: idPrograma,
                accion: 'eliminar'
            },
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se ha eliminado el registro correctamente', 'success');
                    cerrarModalInformacion();
                    obtenerImagenes(busqueda);
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }
</script>