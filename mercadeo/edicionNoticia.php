<?php 
    if (isset($_GET['noticiaId'])) {
        $noticiaId = $_GET['noticiaId'];
    }
?>

<div class="row">
    <div class="col s12">
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <span class="card-title blue-text">Editar noticia</span>
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
                        <input type="hidden" name="noticiaId" id="noticiaId" value="<?php echo isset($noticiaId) ? $noticiaId : '' ?>">
                    </form>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn-flat blue-text" id="btnRegistrar"><i class="material-icons right">send</i> Agregar</button>
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
    });

    function cargarNoticia() {
        let idNoticia = $('#noticiaId').val();

        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/controlador.php?accion=mostrar&noticiaId=' + idNoticia,
            success: function (data) {
                $('#titulo').val(data.titulo);
            }
        });
    }
</script>