<script src="../js/plugins/pignose-datepicker/dist/moment.min.js"></script>
<link rel="stylesheet" href="../js/plugins/pignose-datepicker/dist/pignose.calendar.css">
<script src="../js/plugins/pignose-datepicker/dist/pignose.calendar.js"></script>
<script type="text/javascript" src="../auxiliar-creditos/buscarcenso.js"></script>

<section class="linea-base">
    <h4>LÍNEA BASE: EVALUACIÓN DE CALIDAD Y CONDICIONES DE VIDA</h4>    
    <div class="row">
        <h5>Información del beneficiario</h5>
        <form id="form-beneficiario">
            <div class="input-field col m6 s12">
                <input type="text" name="beneficiarios[]" id="programa" class="validate buscarcenso" placeholder="Identidad del beneficiario" maxlength="13" required>
                <label for="programa">Identidad del beneficiario</label>
            </div>
            <div class="input-field col m6 s12">
                <input type="text" name="nombre[]" id="nombre" placeholder="Nombre del beneficiario" readonly>
                <label for="nombre">Nombre del beneficiario</label>
            </div>
        </form>
    </div>
    
    <div class="row">
        <h5>Información sobre la vivienda</h5>
        <form id="form-informacion-vivienda">
            <div class="input-field col s12">
                <label>Marque los servicios públicos que tiene en su vivienda</label><br>
                <p>
                    <input type="checkbox" name="chk-energia-electrica" id="chk-energia-electrica" min="0" max="100">
                    <label for="chk-energia-electrica">Energía eléctrica</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-agua-potable" id="chk-agua-potable" min="0" max="100">
                    <label for="chk-agua-potable">Red de agua potable</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-agua-negras" id="chk-agua-negras" min="0" max="100">
                    <label for="chk-agua-negras">Red de aguas negras</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-letrina" id="chk-letrina" min="0" max="100">
                    <label for="chk-letrina">Pozo séptico/Letrina/otro</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-telefono" id="chk-telefono" min="0" max="100">
                    <label for="chk-telefono">Teléfono fijo</label>
                </p>
            </div>
            <div class="input-field col s12 m6">
                <input type="number" name="tiempo-vivienda" id="tiempo-vivienda" min="0" max="20" step="1"><br>
                <label for="tiempo-vivienda">Tiempo de residir en la vivienda</label>
            </div>
            <div class="input-field col s12 m6">
                <input type="number" name="personas-vivienda" id="personas-vivienda" min="0" max="15" step="1"><br>
                <label for="personas-vivenda"># de personas que habitan en la vivienda</label>
            </div>
            <div class="input-field col s12 m6">
                <input type="number" name="familias-vivienda" id="familias-vivienda" min="0" max="4" step="1"><br>
                <label for="familias-vivienda"># de familias que habitan en la vivienda</label>
            </div>
            <div class="input-field col s12 m6">
                <input type="number" name="trabajadores-vivienda" id="trabajadores-vivienda" min="0" max="10" step="1"><br>
                <label for="tarbajadores-vivienda"># de trabajadores que habitan en la vivienda</label>
            </div>
            <div class="input-field col s12 m6">
                <input type="number" name="dependientes-vivienda" id="dependientes-vivienda" min="0" max="10" step="1"><br>
                <label for="dependientes-vivienda"># de dependientes que habitan en la vivienda</label>
            </div>
            <div class="input-field col s12 m6">
                <input type="number" name="desempleados-vivienda" id="desempleados-vivienda" min="0" max="10" step="1"><br>
                <label for="desempleados-vivienda"># de desempleados que habitan en la vivienda</label>
            </div>
            <div class="input-field col s12 m6">
                <select name="material-vivienda" id="material-vivienda">
                    <option value="1">Ladrillo</option>
                    <option value="2">Adobe</option>
                    <option value="3">Madera</option>
                    <option value="4">Bloque</option>
                    <option value="5">Otro</option>
                </select>
                <label for="material-vivienda">Material que predomina en vivienda</label>
            </div>
            <div class="input-field col s12">
                <button type="submit" id="btn-registrar" class="modal-action btn blue white-text">Registrar<i class="material-icons right">send</i> </button>
            </div>
        </form>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('select').material_select();

        $('#btn-registrar').click(function (evt) {
            registrar();
        });

        agregarBuscarCensoListeners(13);
    });

    function registrar() {
        
    }
</script>