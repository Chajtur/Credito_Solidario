<script src="../js/plugins/pignose-datepicker/dist/moment.min.js"></script>
<link rel="stylesheet" href="../js/plugins/pignose-datepicker/dist/pignose.calendar.css">
<script src="../js/plugins/pignose-datepicker/dist/pignose.calendar.js"></script>
<script type="text/javascript" src="../auxiliar-creditos/buscarcenso.js"></script>
<script type="text/javascript" src="./busquedaCenso.js"></script>

<section class="plan-empleados">
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
        <div class="col s12">
            <button class="modal-action btn blue white-text right" id="btn-nuevo-empleado">Nuevo<i class="material-icons right">add</i></button>
        </div>
        <h5>Empleados</h5>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Identidad</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<div id="empleado-modal" class="modal">
    <div class="modal-content">
        <h4>Empleado</h4>
        <form id="form-empleado">
            <div class="input-field col s12">
                <input type="text" name="identidad-empleado" id="identidad-empleado" placeholder="Identidad">
                <label for="identidad-empleado">Identidad</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="nombre-empleado" id="nombre-empleado" placeholder="Nombre">
                <label for="nombre-empleado">Nombre</label>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" id="registrar_tarea" class="modal-action btn blue white-text">Guardar</a>
        <a href="#!" id="cancelar_tarea" class="modal-action btn red white-text" onclick="cerrarModalTarea()">Cancelar</a>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.modal').modal();
        $('#identidad-empleado').focusout(function() {
            let identidad = $('#identidad-empleado');
            let nombre = $('#nombre-empleado');
            buscarEnCenso(identidad, nombre, true);
        });
        
        agregarBuscarCensoListeners(13);

        $('#btn-nuevo-empleado').click(function (evt) {
            mostrarModalAgregar();
        });
    });

    function mostrarModalAgregar() {
        $('#accion').val('agregar');

        $('#form-empleado')[0].reset();

        $('#empleado-modal').modal('open');
    }

    function cerrarModalTarea() {
        $('#empleado-modal').modal('close');
    }
</script>