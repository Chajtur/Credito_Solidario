<div class="row">
    <div class="card col s12">
        <div class="card-content">
            <span class="card-title blue-text">Gestión del banco de imágenes</span>            
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
                    imagenesTxt += '<img src="" alt="">';
                    imagenesTxt += '<span class="card-title"></span>';
                    imagenesTxt += '</div>';
                });
                grillaImagenes.html(imagenesTxt);
            }
        });
    }
</script>