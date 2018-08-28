<?php
session_start();
?>
<div class="row">
    <div class="col s12">
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <div id="titulo-tarjeta" class="card-title blue-text"></div>
                    <div class="grilla-imagenes"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalImagen">
    <div class="modal-content">
        <h4>Imagen de la noticia</h4>
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
    $(document).ready(function() {

    });

    function obtenerDepartamento(departamentoId) {
        let tituloTajeta = $('#titulo-tarjeta');

        $.ajax({
            type: 'GET',
            url: '../php/mantenimientos/departamentos.php?accion=mostrar&departamentoId=' + departamentoId,
            success: function (data) {
                let departamentos = JSON.parse(data);
                let departamento = departamentos[0];

                tituloTarjeta.text(departamentos.nombre);
            }
        });
    }
</script>