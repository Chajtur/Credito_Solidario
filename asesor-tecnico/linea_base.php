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
                    <input type="checkbox" name="chk-servicio-vivienda[]" id="energia-electrica" value="energia-electrica" />
                    <label for="energia-electrica">Energía eléctrica</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-servicio-vivienda[]" id="agua-potable" value="agua-potable" />
                    <label for="agua-potable">Red de agua potable</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-servicio-vivienda[]" id="aguas-negras" value="aguas-negras" />
                    <label for="aguas-negras">Red de aguas negras</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-servicio-vivienda[]" id="pozo-septico" value="pozo-septico" />
                    <label for="pozo-septico">Pozo séptico/Letrina/otro</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-servicio-vivienda[]" id="telefono-fijo" value="telefono-fijo" />
                    <label for="telefono-fijo">Teléfono fijo</label>
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
                <label for="trabajadores-vivienda"># de trabajadores que habitan en la vivienda</label>
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
                <button type="button" id="btn-registrar" class="modal-action btn blue white-text">Registrar<i class="material-icons right">send</i> </button>
            </div>
        </form>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('select').material_select();

        $('#btn-registrar').click(function (evt) {
            let idBeneficiario = $('#programa').val();
            registrar();
        });

        agregarBuscarCensoListeners(13);
    });

    function registrar(beneficiario) {
        let serviciosPublicos = [];
        $("input[name='chk-servicio-vivienda[]']:checked").each(function () {
            serviciosPublicos.push($(this).val());
        });
        console.log(serviciosPublicos);
        let idBeneficiario = $('#programa').val();
        let tiempoVivienda = $('#tiempo-vivienda').val();
        let personasVivienda = $('#personas-vivienda').val();
        let familiasVivienda = $('#familias-vivienda').val();
        let trabajadoresVivienda = $('#trabajadores-vivienda').val();
        let dependientesVivienda = $('#dependientes-vivienda').val();
        let desempleadosVivienda = $('#desempleados-vivienda').val();
        let materialVivienda = $('#material-vivienda').val();
        let accion = 'guardar-linea-base';

        let lineaBase = {
            idBeneficiario: idBeneficiario,
            serviciosPublicos: serviciosPublicos.join(','),
            tiempoVivienda: tiempoVivienda,
            personasVivienda: personasVivienda,
            familiasVivienda: familiasVivienda,
            trabajadoresVivienda: trabajadoresVivienda,
            dependientesVivienda: dependientesVivienda,
            desempleadosVivienda: desempleadosVivienda,
            materialVivienda:materialVivienda,
            accion: accion
        };

        $('#btn-registrar').addClass('disabled');

        $.ajax({
            url: '../php/asesor-tecnico/solicitud-credito-ctrl.php',
            type: 'POST',
            data: lineaBase,
            async: true,
            success: function (data) {
                $('#btn-registrar').removeClass('disabled');

                let respuesta = JSON.parse(data);

                $('#btn-registrar').removeClass('disabled');

                if (respuesta.error === 0) {
                    swal('Se han guardado los datos.');
                } else {
                    swal('Error', 'No se han podido guardar los datos.', 'error');
                }
            },
            error: function(xhr, error, status) {
                $('#btn-registrar').removeClass('disabled');
                swal('Error', error, 'error');
            }
        });
    }
</script>