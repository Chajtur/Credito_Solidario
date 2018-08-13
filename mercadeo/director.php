<div class="row">
    <div class="card horizontal">
        <div class="card-image">
            <img id="imagen-director" name="imagen-director" src="../images/user.png">
        </div>
    </div>
    <div class="card-stacked">
        <div class="card-content" id="contenido-director"></div>
        <div class="card-action">
            <a href="#!" id="btn-cambiar-imagen"><i class="material-icons teal-text">image</i></a>
            <a href="#!" id="btn-cambiar-frase"><i class="material-icons blue-text">create</i></a>
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

        $('#btn-cambiar-frase').click(function (evt) {
            abrirModalFrase();
            evt.preventDefault();
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
            url: '../',
            success: function (data) {
                let directores = JSON.parse(data);
                let director = directores[0];

                if (director.url) {
                    imagenUrl = director.url;
                }

                imagen.attr('src', imagenUrl);
                frase += director.frase + '</p>';

                contenidoDirector.html(frase);
            }
        });
    }
</script>