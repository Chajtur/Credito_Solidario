<?php 
    /*if (isset($_GET['accion'])) {
        $accion = 'accion';
    }*/
?>

<div class="row">
    <div class="col s12">
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <span class="card-title blue-text">Nueva noticia</span>
                    <form id="formGuardarNoticia">
                        <div class="input-field">
                            <input type="text" name="titulo" id="titulo" data-length="80">
                            <label for="titulo">Título</label>
                        </div>
                        <div class="input-field">
                            <input type="text" name="fecha" id="fecha" class="datepicker">
                            <label for="fecha">Fecha</label>
                        </div>
                        <div class="input-field">
                            <input type="text" name="hora" id="hora" class="timepicker">
                            <label for="hora">Hora</label>
                        </div>
                        <div class="input-field">
                            <input type="text" name="resumen" id="resumen" data-length="150">
                            <label for="resumen">Resumen</label>
                        </div>
                        <div class="input-field">
                            <textarea name="contenido" id="contenido" class="materialize-textarea"></textarea>
                            <label for="contenido">Contenido</label>
                        </div>
                        <div class="input-field">
                            <select name="estado" id="estado">
                                <option value="1">Activa</option>
                                <option value="0">Inactiva</option>
                            </select>
                            <label for="estado">Estado</label>
                        </div>
                    </form>
                </div>
                <div class="card-action">
                <input type="hidden" name="usuario" id="usuario" value="ADRIAN">
                    <button type="submit" class="btn-flat blue-text" id="btnRegistrar"><i class="material-icons right">send</i>Agregar</button>
                </div>
            </div> 
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('select#estado').material_select();
        $('input#titulo, input#resumen').characterCounter();
        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: 15,
            today: 'Hoy',
            clear: 'Limpiar',
            close: 'Aceptar',
            closeOnSelect: false,
            container: undefined,
            monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',  'Octubre', 'Noviembre', 'Diciembre'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            weekdaysLetter: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            format: 'dd/mm/yyyy'
        });
        $('.timepicker').pickatime({
            default: 'now',
            fromnow: 0,
            twelvehour: false,
            donetext: 'Aceptar',
            cleartext: 'Cancelar',
            container: undefined,
            autoclose: false,
            ampmclickable: true
        });
        $('#btnRegistrar').click(function (evt) {
            $('#btnRegistrar').attr('disabled', 'disabled');
            let userDate = $('#fecha').val();
            let phpDate = userDate.split('/').reverse().join('-');
            let noticia = {
                titulo: $('#titulo').val(),
                contenido: $('#contenido').val(),
                resumen: $('#resumen').val(),
                fecha: phpDate,
                estado: $('#estado').val(),
                usuario: $('#usuario').val(),
                accion: 'agregar'
            };

            $.ajax({
                type: 'POST',
                url: '../php/mercadeo/controlador.php',
                data: noticia,
                success: function (data) {
                    $('#btnRegistrar').removeAttr('disabled');
                    if (data.noticiaId >= 1) {
                        swal('Correcto','Se ha registrado la visita correctamente', 'success');
                        $('#floating-refresh').trigger('click');
                        location.href= 'index.php?accion=editar&noticiaId=' + data.noticiaId;
                    } else {
                        swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                    }
                }
            });

            evt.preventDefault();
        });
    });
</script>