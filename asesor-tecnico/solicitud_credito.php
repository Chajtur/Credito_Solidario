<script src="../js/plugins/pignose-datepicker/dist/moment.min.js"></script>
<link rel="stylesheet" href="../js/plugins/pignose-datepicker/dist/pignose.calendar.css">
<script src="../js/plugins/pignose-datepicker/dist/pignose.calendar.js"></script>
<script type="text/javascript" src="../auxiliar-creditos/buscarcenso.js"></script>

<section class="linea-base">
    <h1>LÍNEA BASE: EVALUACIÓN DE CALIDAD Y CONDICIONES DE VIDA</h1>
    <h2>Información sobre la vivienda.</h2>
    <div class="row">
        <form id="form-informacion-vivienda">
            <div class="input-field col s12">
                <input type="text" name="tiempo-vivienda" id="tiempo-vivienda" placeholder="Tiempo de residir en la vivienda">
                <label for="tiempo-vivienda">Tiempo de residir en la vivienda</label>
            </div>
            <div class="input-field col s12">
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
                <p>
                    <input type="checkbox" name="chk-energia-electrica" id="chk-energia-electrica">
                    <label for="chk-energia-electrica">Energía eléctrica</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-agua-potable" id="chk-agua-potable">
                    <label for="chk-agua-potable">Red de agua potable</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-agua-negras" id="chk-agua-negras">
                    <label for="chk-agua-negras">Red de aguas negras</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-letrina" id="chk-letrina">
                    <label for="chk-letrina">Pozo séptico/Letrina/otro</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-telefono" id="chk-telefono">
                    <label for="chk-telefono">Teléfono fijo</label>
                </p>
                <label>Marque los servicios públicos que tiene en su vivienda</label>
            </div>
            <div class="input-field col s12">
                <input type="range" name="personas-vivienda" id="personas-vivienda">
                <label for="personas-vivienda"># de personas que habitan en la vivienda</label>
            </div>
            <div class="input-field col s12">
                <input type="range" name="familias-vivienda" id="familias-vivienda">
                <label for="familias-vivienda"># de familias que habitan en la vivienda</label>
            </div>
            <div class="input-field col s12">
                <input type="range" name="trabajadores-vivienda" id="trabajadores-vivienda">
                <label for="trabajadores-vivienda"># de trabajadores que habitan en la vivienda</label>
            </div>
            <div class="input-field col s12">
                <input type="range" name="dependientes-vivienda" id="dependientes-vivienda">
                <label for="dependientes-vivienda"># de dependientes que habitan en la vivienda</label>
            </div>
            <div class="input-field col s12">
                <input type="range" name="desempleados-vivienda" id="desempleados-vivienda">
                <label for="dependientes-vivienda"># de desempleados que habitan en la vivienda</label>
            </div>
        </form>
    </div>
</section>