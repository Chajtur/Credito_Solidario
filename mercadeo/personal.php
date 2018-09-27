<?php
    session_start();
?>

<div class="row">
    <div class="card col s12">
        <form id="formPersonal">
            <div class="card-content">
                <span class="card-title blue-text">Gestión del personal</span>            
                    <div class="row">
                        <div class="input-field col s12">
                            <select name="cargo" id="cargo">
                                
                            </select>
                        </div>
                        
                        <div class="input-field col s12">
                            <input type="text" name="busqueda" placeholder="Búsqueda" id="busqueda" data-length="25" class="validate">
                            <label for="busqueda"></label>
                        </div>
                        
                        <div class="col s1">
                            <button data-position="top" data-delay="50" data-tooltip="Agregar imagen" class="waves-effect waves-light btn teal lighten-2 tooltipped" id="btn-nuevo" name="btn-nuevo"><i class="material-icons">add</i></button>
                            <input type="hidden" name="usuario" id="usuario" value="<?php $_SESSION['user'] ?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row" id="grilla-imagenes"><div >


<div class="modal" id="modalImagen">
    <div class="modal-content">
        <h4>Imagen del carrusel</h4>
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