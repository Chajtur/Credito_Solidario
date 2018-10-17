<script src="../js/plugins/pignose-datepicker/dist/moment.min.js"></script>
<link rel="stylesheet" href="../js/plugins/pignose-datepicker/dist/pignose.calendar.css">
<script src="../js/plugins/pignose-datepicker/dist/pignose.calendar.js"></script>
<script type="text/javascript" src="../auxiliar-creditos/buscarcenso.js"></script>
<script type="text/javascript" src="./busquedaCenso.js"></script>

<section class="plan-empleados">
    <h4>GENERACIÓN DE EMPLEO</h4> 
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
            <button class="modal-action btn teal white-text right" id="btn-buscar-empleado">Buscar<i class="material-icons right">refresh</i></button>
            <button class="modal-action btn blue white-text right" id="btn-nuevo-empleado">Nuevo<i class="material-icons right">add</i></button>
        </div>
        <h5>Empleados</h5>
        <div id="lista-empleados"></div>
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
                <input type="hidden" name="accion" id="accion">
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
            let identidadBeneficiario = $('#programa').val();
            let identidadEmpleado = $('#identidad-empleado').val();
            let nombreBeneficiario = $('#nombre-empleado').val();
            registrar(identidadBeneficiario, identidadEmpleado, nombreBeneficiario);
        });

        $('#btn-buscar-empleado').click(function (evt) {
            let identidadBeneficiario = $('#programa').val();
            obtenerEmpleados(identidadBeneficiario);
        });
    });

    function mostrarModalAgregar() {
        $('#accion').val('agregar-empleado');

        $('#form-empleado')[0].reset();

        $('#empleado-modal').modal('open');
    }

    function mostrarModalEditar(identidadBeneficiario, identidadEmpleado) {
        $('#accion').val('actualizar-empleado');

        $('#form-empleado')[0].reset();

        obtenerEmpleado(identidadBeneficiario, identidadEmpleado);

        $('#empleado-modal').modal('open');
    }

    function obtenerEmpleado(identidadBeneficiario, identidadEmpleado, verificacion = false) {
        $.ajax({
            url: '../php/asesor-tecnico/solicitud-credito-ctrl.php?accion=obtener-empleado&idbeneficiario=' + identidadBeneficiario + '&idempleado=' + identidadEmpleado,
            type: 'GET',
            async: true,
            success: function (data) {
                let empleados = JSON.parse(data);
                let empleado = empleados[0];

                $('#identidad-empleado').val(empleado.identidad_empleado);
                $('#nombre-empleado').val(empleado.nombre_empleado);
                if (verificacion) {
                    if (empleados) {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
            error: function (xhr, status, error) {
                alert('Error al obtener los datos: ' + error);
            }
        });
    }

    function cerrarModalTarea() {
        $('#empleado-modal').modal('close');
    }

    function registrar(identidadBeneficiario, identidadEmpleado, nombreEmpleado) {
        let accion = $('#accion').val();

        let empleado = {
            identidadBeneficiario: identidadBeneficiario,
            identidadEmpleado: identidadEmpleado,
            nombre: nombreEmpleado,
            accion: accion
        };

        $('#registrar_tarea').addClass('disabled');

        $.ajax({
            url: '../php/asesor-tecnico/solicitud-credito-ctrl.php',
            type: 'POST',
            data: empleado,
            async: true,
            success: function (data) {
                $('#registrar_tarea').removeClass('disabled');
                let existeEmpleado = obtenerEmpleado(identidadBeneficiario, identidadEmpleado, true);
                console.log('existe', existeEmpleado);
                if (existeEmpleado) {
                    Materialize.toast('El empleado ya esta registrado con este beneficiario.');
                } else {
                    cerrarModalTarea();
                    obtenerEmpleados(identidadBeneficiario);
                }
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
        empleadosTxt += '<th></th>';
        empleadosTxt += '</tr>';
        empleadosTxt += '</thead>';
        empleadosTxt += '<tbody>';
        empleadosTxt += '</tbody>';
        $.ajax({
            url: '../php/asesor-tecnico/solicitud-credito-ctrl.php?accion=listar-empleados&idbeneficiario='+identidadBeneficiario,
            type: 'GET',
            success: function (data) {
                let empleados = JSON.parse(data);
                $.each(empleados, function (i, empleado) {
                    empleadosTxt += '<tr>';
                    empleadosTxt += '<td>'+ empleado.identidad_empleado +'</td>';
                    empleadosTxt += '<td>'+ empleado.nombre_empleado +'</td>';
                    empleadosTxt += '<td>';
                    empleadosTxt += '<a href="#" onclick="mostrarModalEditar(\''+ empleado.identidad_beneficiario +'\', \''+ empleado.identidad_empleado +'\')"><i class="material-icons">edit</i></a>';
                    empleadosTxt += '<a href="#" onclick="eliminarEmpleado(\''+ empleado.identidad_beneficiario +'\', \''+ empleado.identidad_empleado +'\')"><i class="material-icons red-text">clear</i></a>';
                    empleadosTxt += '</td>';
                    empleadosTxt += '</tr>';
                });
                empleadosTxt += '</tbody>';
                listaEmpleados.html(empleadosTxt);
            },
            error: function (xhr, status, error) {
                empleadosTxt += '</tbody>';
                listaEmpleados.html(empleadosTxt);
                alert(error);
            }
        });
    }

    function eliminarEmpleado(identidadBeneficiario, identidadEmpleado) {
        let empleado = {
            identidadBeneficiario: identidadBeneficiario,
            identidadEmpleado: identidadEmpleado,
            accion: 'eliminar-empleado'
        };

        $.ajax({
            url: '../php/asesor-tecnico/solicitud-credito-ctrl.php',
            type: 'POST',
            data: empleado,
            async: true,
            success: function (data) {
                $('#registrar_tarea').removeClass('disabled');
               
                Materialize.toast('Empleado eliminado.', 1000);
                cerrarModalTarea();
                obtenerEmpleados(identidadBeneficiario);
            }
        });
    }
</script>