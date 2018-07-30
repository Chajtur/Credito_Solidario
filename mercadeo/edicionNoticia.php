<div class="row">
    <div class="form col s12">
        <div class="row">
            <div class="input-field col s12">
                <input type="text" name="titulo" id="titulo" data-length="80">
                <label for="titulo">Título</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="fecha" id="fecha" class="datepicker">
                <label for="fecha">Fecha</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="hora" id="hora" class="timepicker">
                <label for="hora">Hora</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="resumen" id="resumen" data-length="150">
                <label for="resumen">Resumen</label>
            </div>
            <div class="input-field col s12">
                <textarea name="contenido" id="contenido" class="materialize-textarea"></textarea>
                <label for="contenido">Contenido</label>
            </div>
            <div class="input-field col s12">
                <select name="estado" id="estado">
                    <option value="1">Activa</option>
                    <option value="0">Inactiva</option>
                </select>
                <label for="estado">Estado</label>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('select#estado').material_select();
        $('input#titulo, input#resumen, textarea#contenido').characterCounter();
        /*$('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year,
            today: 'Today',
            clear: 'Clear',
            close: 'Ok',
            closeOnSelect: false // Close upon selecting a date,
            container: undefined, // ex. 'body' will append picker to body
        });*/
    });
</script>