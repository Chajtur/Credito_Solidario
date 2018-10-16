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
        <div id="lista-empleados"></div>
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

        $('#registrar_tarea').click(function (evt) {
            let identidadEmpleado = $('#programa').val();
            let identidadBeneficiario = $('#identidad-empleado').val();
            let nombreBeneficiario = $('#nombre-empleado').val();
            registrar(identidadEmpleado, identidadBeneficiario, nombreBeneficiario);
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

    function registrar(identidadBeneficiario, identidadEmpleado, nombreEmpleado) {
        let accion = 'agregar-empleado';
        if (identidadEmpleado) {
            accion = 'actualizar-empleado';
        }

        let empleado = {
            identidad-beneficiario: identidadBeneficiario,
            identidad-empleado: identidadEmpleado,
            nombre: nombreEmpleado,
            accion: accion
        };

        $('#registrar_tarea').addClass('disabled');

        $.ajax({
            url: '../php/asesor-tecnico/solicitud-credito-ctrl.php',
            type: 'POST',
            data: empleado,
            success: function (data) {
                $('#registrar_tarea').removeClass('disabled');
                cerrarModalTarea();
            }
        });
    }

    function obtenerEmpleados(identidadBeneficiario) {
        let listaEmpleados = $('#lista-empleados');
        let empleadosTxt = '<table class="responsive-table">';
        empleadosTxt += '<thead>';
        empleadosTxt += '<tr>';
        empleadosTxt += '<th>Identidad</th>';
        empleadosTxt += '<th>Nombre</th>';
        empleadostxt += '<th></th>';
        empleadostxt += '</tr>';
        empleadostxt += '</thead>';
        empleadostxt += '<tbody>';
        empleadostxt += '</tbody>';
        $.ajax({
            url: '../php/asesor-tecnico/solicitud-credito-ctrl.php?listar-empleados',
            type: 'GET',
            success: function (data) {
                let empleados = JSON.parse(data);
                $.each(empleados, function (i, empleado) {
                    empleadosTxt += '<tr>';
                    empleadosTxt += '<td>'+ empleado.identidad_empleado +'</td>';
                    empleadosTxt += '<td>'+ empleado.nombre_empleado +'</td>';
                    empleadosTxt += '<td>';
                    empleadosTxt += '<a href="#" onclick="mostrarModalAgregar("'+ empleado.identidad_empleado +'", "'+ empleado.identidad_beneficiario +'")"><i class="clear"></i></a>';
                    empleadosTxt += '<a href="#" onclick="eliminarEmpleado("'+ empleado.identidad_empleado +'", "'+ empleado.identidad_beneficiario +'")"><i class="edit"></i></a>';
                    empleadosTxt += '</td>';
                    empleadosTxt += '</tr>';
                });
                empleadostxt += '</tbody>';
            },
            error: function (data) {
                empleadostxt += '</tbody>';
            }
        });
    }
</script>