<div class="row">
    <div class="card horizontal">
        <div class="card-image">
            <img id="imagen-director" name="imagen-director" src="">
        </div>
        <div class="card-stacked">
            <div class="card-content" id="contenido-director"></div>
            <div class="card-action">
                <a href="#!" id="btn-cambiar-imagen"><i class="material-icons teal-text">image</i></a>
                <a href="#!" id="btn-cambiar-frase"><i class="material-icons blue-text">create</i></a>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-imagen">
    <div class="modal-content">
        <h4>Imagen del director</h4>
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
        <input type="hidden" name="directorId" id="directorId">
        <button id="btn-registrar-imagen" class="waves-effect waves-light btn green lighten-2" type="submit">Registrar</button>
        <button id="btn-cancelar-imagen" class="waves-effect waves-light btn red lighten-2" type="submit">Cancelar</button>
    </div>
</div>

<div class="modal" id="modal-frase">
    <div class="modal-content">
        <h4>Frase del director</h4>
        <form id="formImagen">
            <div class="input-field">
                <textarea name="frase" id="frase" class="materialize-textarea"></textarea>
                <label for="frase">Frase</label>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="carruselId" id="carruselId">
        <button id="btn-registrar-frase" class="waves-effect waves-light btn green lighten-2" type="submit">Registrar</button>
        <button id="btn-cancelar-frase" class="waves-effect waves-light btn red lighten-2" type="submit">Cancelar</button>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.modal').modal({
            dismissible: true,
            inDuration: 300,
            outDuration: 200
        });

        $('#btn-cambiar-imagen').click(function (evt) {
            abrirModalImagen();
            evt.preventDefault();
        });

        $('#btn-registrar-imagen').click(function (evt) {
            guardarImagen();
            evt.preventDefault();
        });

        $('#btn-cancelar-imagen').click(function (evt) {
            cerrarModalImagen();
        });

        $('#btn-cambiar-frase').click(function (evt) {
            abrirModalFrase();
            evt.preventDefault();
        });

        $('#btn-cancelar-frase').click(function (evt) {
            cerrarModalFrase();
            evt.preventDefault();
        });

        $('#btn-registrar-frase').click(function (evt) {
            console.log('asd');
            guardarFrase();
        });

        obtenerDatos();
    });

    function abrirModalImagen() {
        $('#modal-imagen').modal('open');
    }

    function cerrarModalImagen() {
        $('#modal-imagen').modal('close');
    }

    function abrirModalFrase() {
        $('#modal-frase').modal('open');
    }

    function cerrarModalFrase() {
        $('#modal-frase').modal('close');
    }

    function obtenerDatos() {
        let imagen = $('#imagen-director');
        let imagenUrl = '../images/user.png';
        let contenidoDirector = $('#contenido-director');
        let frase = '<p>';

        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/director.php?accion=mostrar&directorId=1',
            success: function (data) {
                let directores = JSON.parse(data);
                let director = directores[0];

                if (director.url_imagen) {
                    imagenUrl = director.url_imagen;
                }

                imagen.attr('src', imagenUrl);
                frase += director.frase + '</p>';

                contenidoDirector.html(frase);
            }
        });
    }

    function guardarFrase() {
        let directorId = 1
        let frase = $('#frase');

        $.ajax({
            type: 'POST',
            url: '../php/mercadeo/director.php',
            data: {
                directorId: directorId,
                frase: frase.val(),
                accion: 'actualizar'
            },
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se han registrado los datos correctamente', 'success');
                    frase.val('');
                    cerrarModalFrase();
                    obtenerDatos();
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }

    function guardarImagen() {
        let directorId = 1;
        let imagenDirector = document.getElementById('imagen').files[0];
        let usuario = $('#usuario').val();

        if (imagenDirector) {
            let data = new FormData();
            data.append('usuario', usuario);
            data.append('accion', 'agregar');
            data.append('etiquetas', 'director,web,inicio,index');
            data.append('modulo', 'director');
            data.append('archivo', imagenDirector);

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
                        registrarDatosImagen(directorId, archivoData.url);
                    } else {
                        console.log('Archivo no enviado.');
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        } else {
            swal('Error','Debe seleccionar una imagen para guardar.', 'error');
        }
    }

    function registrarDatosImagen(directorId, url) {
        $.ajax({
            type: 'POST',
            url: '../php/mercadeo/director.php',
            data: {
                directorId: directorId,
                url: url,
                accion: 'actualizar-imagen'
            },
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    swal('Correcto','Se han registrado los datos correctamente', 'success');
                    cerrarModalImagen();
                    obtenerDatos();
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>