<?php
    session_start();
?>
<script src="../js/plugins/pignose-datepicker/dist/moment.min.js"></script>
<link rel="stylesheet" href="../js/plugins/pignose-datepicker/dist/pignose.calendar.css">
<script src="../js/plugins/pignose-datepicker/dist/pignose.calendar.js"></script>
<script type="text/javascript" src="../auxiliar-creditos/buscarcenso.js"></script>


<!-- MAIN -->
<div class="section">
    <div class="row">
        <div id="contenedorError" class="col s12">

        </div>
    </div>

    <div id="toolbar-agenda" class="row">
        <div class="col s2"><a href="#!" id="btn-nueva-noticia" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Registrar</a></div>
    </div>

    <div id="tareas" class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="card-title">Visitas</div>
                <div id="contenedor-tareas"></div>
            </div>
        </div>
    </div>
</div>
</div>

<div id="tarea-modal" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4>Nueva Visita</h4>
        <form id="tarea-form">
            <div class="input-field col s4">
                <input id="programa" name="beneficiarios[]" type="text" class="validate buscarcenso" maxlength="13" required>
                <label for="programa">Identidad</label>
            </div>
            <div class="input-field col s5">
                <input readonly id="nombre" name="nombre[]" type="text" class="black-text">
                <label for="nombre">Nombre</label>
            </div>
            <div class="input-field">
                <textarea name="detalle" id="detalle" class="materialize-textarea" required maxlength="2000"></textarea>
                <label for="detalle">Detalle</label>
                <input type="hidden" name="accion" id="accion">
                <input type="hidden" name="tareaId" id="tareaId">
                <input type="hidden" name="fecha" id="fecha">
                <input type="hidden" name="latitud" id="latitud">
                <input type="hidden" name="longitud" id="longitud">
                <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['user'] ?>">
            </div>
            <div class="input-field">
                <select class="select" name="tipo-visita" id="tipo-visita">
                    <option value="1">Asistencia técnica</option>
                    <option value="2">Visita de cobro</option>
                </select>
                <label for="tipo-visita">Tipo de visita</label>
            </div>
            <div class="input-field">
                <select class="select" name="domicilio" id="domicilio">
                    <option value="1">Casa</option>
                    <option value="2">Negocio</option>
                </select>
                <label for="domicilio">Domicilio</label>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" id="registrar_tarea" class="modal-action btn blue white-text">Guardar</a>
        <a href="#!" id="cancelar_tarea" class="modal-action btn red white-text" onclick="cerrarModalTarea()">Cancelar</a>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('.collapsible').collapsible();
        $('.select').material_select();

        $('.modal').modal();
        var fechaHoy = obtenerFechaHoy();
        var usuarioActual = $('#usuario').val();
        obtenerTareasLista(fechaHoy, usuarioActual);
        $('#fecha').val(fechaHoy);

        $('#btn-nueva-noticia').click(function (evt) {
            mostrarModalAgregar();
        });

        $('#registrar_tarea').click(function (evt) {
            guardarTarea();
        });
        agregarBuscarCensoListeners(13);
    

        //revisarSiGeolocacionActivado();
    });

    function revisarSiGeolocacionActivado() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {}, 
                function (error) {
                    if (error) {
                        var contenedorError = $('#contenedorError');
                        var errorMensaje = '<p>Debe activar la geolocalizacion en su navegador y después refresque la página.</p>';
                        contenedorError.html(error);
                        var toolbar = $('#toolbar-agenda');
                        var tareas = $('#tareas');
                        toolbar.hide();
                        tareas.hide();
                    }
                }
            );
        }
    }

    function obtenerFechaHoy() {
        var fechaHoy = new Date();
        var dd = fechaHoy.getDate();
        var mm = fechaHoy.getMonth() + 1;
        var yyyy = fechaHoy.getFullYear();

        if (dd < 10) {
        dd = '0' + dd;
        }

        if (mm < 10) {
        mm = '0' + mm;
        }

        var fechaFormateada = yyyy + '-' + mm + '-' + dd;

        return fechaFormateada;
    }

    function mostrarModalAgregar() {
        $('#accion').val('agregar');
        obtenerUbicacion();

        $('#tarea-form')[0].reset();

        $('#tarea-modal').modal('open');
    }

    function cerrarModalTarea() {
        $('#tarea-modal').modal('close');
    }

    function guardarTarea() {
        var url;
        var beneficiario = $('#beneficiario').val();
        var metodoRegistro = $('#accion').val();
        var detalle = $('#detalle').val();
        var fecha = $('#fecha').val();
        var accion = $('#accion').val();
        var usuario = $('#usuario').val();
        var tareaId = $('#tareaId').val();
        var latitud = $('#latitud').val();
        var longitud = $('#longitud').val();
        var tipoVisita = $('#tipo-visita').val();
        var domicilio = $('#domicilio').val();
        var validado = true;
        var mensajes = '';

        if (beneficiario.trim().length <= 0) {
        validado = false;

        mensajes += '- El beneficiario esta vacío.<br />';
        }

        if (detalle.trim().length <=0) {
        validado = false;

        mensajes += '- El detalle esta vacío.<br />';
        }

        if (detalle.trim().length > 2000) {
        validado = false;

        mensajes += '- El detalle no puede ser mayor a 2000 caracteres.<br />';
        }
        
        if (validado == false) {
        Materialize.toast(mensajes, 2000);
        } else {
            var data = {
                'tareaId': tareaId,
                'accion': accion,
                'beneficiarioId': beneficiario,
                'detalle': detalle,
                'fecha': fecha,
                'usuario': usuario,
                'longitud': longitud,
                'latitud': latitud,
                'tipo-visita': tipoVisita,
                'domicilio': domicilio
            };

            url = '../php/asesor-tecnico/agenda.php';

            $('#registrar_tarea').addClass('disabled');
            $('#cancelar_tarea').addClass('disabled');

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (data) {
                    $('#registrar_tarea').removeClass('disabled');
                    $('#cancelar_tarea').removeClass('disabled');
                    $('#tarea-modal').modal('close');
                    fecha = fecha.substring(0, 10);
                    var usuarioVal = $('#usuario').val();
                    obtenerTareasLista(fecha, usuarioVal);
                },
                error: function (xhr, status, error) {
                    alert('Error al guardar datos');
                }
            });
        }
    }

    function obtenerTareasLista(fecha, usuario) {
        $.ajax({
        url: '../php/asesor-tecnico/agenda.php?accion=listar&fecha=' + fecha + '&usuario='+ usuario,
        type: 'GET',
        //dataType: 'JSON',
        async: true,
        success: function (data) {
            var tareas = JSON.parse(data);
            var contenedorTareas = $('#contenedor-tareas');
            if (tareas)
            {
                var tareasTxt = '<table>';
                tareasTxt += '<thead>';
                tareasTxt += '<tr>';
                tareasTxt += '<th>#</th>';
                tareasTxt += '<th>Identidad</th>';
                tareasTxt += '<th>Nombre</th>';
                tareasTxt += '<th>Tipo de visita</th>';
                tareasTxt += '<th>Domicilio</th>';
                tareasTxt += '<th></th>'; 
                tareasTxt += '</tr>';
                tareasTxt += '</thead>';
                var i = 0;
                tareasTxt += '<tbody>';
                $.each(tareas, function (i, tarea) {
                    i++;
                    var descripcionTipoVisita = '';
                    var tipoVisita = parseInt(tarea.tipo_visita);
                    switch (tipoVisita) {
                        case 1:
                            descripcionTipoVisita = 'Asistenica técnica';                            
                            break;
                        
                        case 2:
                            descripcionTipoVisita = 'Visita de cobro';
                            break;
                    
                        default:
                            descripcionTipoVisita = '';
                            break;
                    }

                    var descripcionDomicilio = '';
                    var domicilioId = parseInt(tarea.domicilio);
                    switch (domicilioId) {
                        case 1:
                            descripcionDomicilio = 'Casa';
                            break;

                        case 2:
                            descripcionDomicilio = 'Negocio';
                            break;
                    
                        default:
                            descripcionDomicilio = '';
                            break;
                    }

                    tareasTxt += '<tr>';
                    tareasTxt += '<td>'+ i +'</td>';
                    tareasTxt += '<td>'+ tarea.beneficiarioId +'</td>';
                    tareasTxt += '<td>'+ tarea.nombre +'</td>';
                    tareasTxt += '<td>'+ descripcionTipoVisita +'</td>';
                    tareasTxt += '<td>'+ descripcionDomicilio +'</td>';
                    tareasTxt += '<td>';
                    tareasTxt += '<a href="#" onclick="mostrarModalEditar('+ tarea.tareaId +')"><i class="material-icons blue-text">edit</i></a>';
                    tareasTxt += '<a href="#"><i class="material-icons red-text">clear</i></a>';
                    tareasTxt += '</td>';
                    tareasTxt += '</tr>';
                });
                tareasTxt += '</tbody>';
                tareasTxt += '</table>';
                contenedorTareas.html(tareasTxt);
            } else {
                contenedorTareas.html('<p>No hay tareas qué mostrar.</p>');
            }
        }
        });
    }

    function obtenerUbicacion() {
        console.log('obtenerUbicacion');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(mostrarPosicion);
        } else {
            alert('Este navegador no soporta geolocalización');
        }
    }

    function mostrarPosicion(position) {
        console.log('lat', position.coords.latitude);
        $('#latitud').val(position.coords.latitude);
        $('#longitud').val(position.coords.longitude);
    }

    function mostrarModalEditar(tareaId) {
          $('#accion').val('editar');

          $('#tarea-form')[0].reset();

          $.ajax({
            url: '../php/asesor-tecnico/agenda.php?accion=editar&tareaId=' + tareaId,
            type: 'GET',
            success: function (data) {
                var tareas = JSON.parse(data);
                var tarea = tareas[0];
                console.log(tarea);
                $('#tareaId').val(tarea.tareaId);
                $('#beneficiario').val(tarea.beneficiarioId);
                $('#detalle').val(tarea.detalle);
                $('#fecha').val(tarea.fecha);
                $('#longitud').val(tarea.longitud);
                $('#latitud').val(tarea.latitud);
                $('#tipo-visita').val(tarea.tipo_visita).change();
                $('#tipo-visita').material_select();
                $('#domicilio').val(tarea.domicilio).change();
                $('#domicilio').material_select();
            },
            error: function (xhr, status, error) {
              alert('Error al obtener datos.');
            }
          });

          $('#tarea-modal').modal('open');
        }
</script>