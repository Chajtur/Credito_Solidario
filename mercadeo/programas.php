<div class="row">
    <div class="card col s12">
        <div class="card-content">
            <span class="card-title blue-text">Gestión de programas</span>            
                <div class="row">
                    <div class="col s11"></div>                    
                    <div class="col s1">
                        <button data-position="top" data-delay="50" data-tooltip="Agregar imagen" class="waves-effect waves-light btn teal lighten-2 tooltipped" id="btn-nuevo" name="btn-nuevo"><i class="material-icons">add</i></button>
                        <input type="hidden" name="usuario" id="usuario" value="ADRIAN">
                    </div>
                </div>
            
            <div id="grilla-imagenes"></div>
        </div>
    </div>
</div>

<div class="modal modal-fixed-footer" id="modal-informacion">
    <div class="modal-content">
        <h4>Imagen de la galería</h4>
        <form id="formImagen">
            <div class="input-field">
                <input type="text" name="id-programa" placeholder="Id" id="id-programa" data-length="6" class="validate">
                <label for="id-programa"></label>
            </div>            
            <div class="input-field">
                <input type="text" name="subprograma" placeholder="Subprograma" id="subprograma" data-length="50" class="validate">
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
    $(document).ready( function(){
        $('.modal').modal({
            dismissible: true,
            inDuration: 300,
            outDuration: 200
        });

        $('input#id-programa, input#subprograma input#descripcion').characterCounter();

        $('#programa').material_select();

        $('#btn-nuevo').click(function (evt) {
            abrirModalInformacion();
        });

        $('#btnCancelarImagen').click(function (evt) {
            cerrarModalInformacion();
        });
    });

    function abrirModalInformacion() {
        $('#modal-informacion').modal('open');
    }

    function cerrarModalInformacion() {
        $('#modal-informacion').modal('close');
    }
</script>