<div class="container" id="main-container" style="display: block;"><div class="row">

    <div class="col l4 m4 s4 offset-l4 offset-m4 offset-s4">
        <div class="card">
            <div class="card-content">

                <span class="card-title">Generar reportes</span>

                <p>Fechas</p>
                
                <form action="#" id="formData">

                    <div class="row">
                        <div class="col m6">
                            <div class="input-field">
                                <label for="fechaDesde" class="active">Fecha Inicial</label>
                                <input id="fechaDesde" type="text" class="datepicker" placeholder="2012-12-12" required="required">
                            </div>
                        </div>
                        <div class="col m6">
                            <div class="input-field">
                                <label for="fechaHasta" class="active">Fecha Final</label>
                                <input id="fechaHasta" type="text" class="datepicker" placeholder="2012-12-12" required="required">
                            </div>
                        </div>
                    </div>

                    <p>Tipo de reporte</p>

                    <div class="row">
                        <div class="col l12 m12 s12">
                            <p>
                                <input name="groupTipoReporte" type="radio" id="test1" value="1"/>
                                <label for="test1">Llegadas</label>
                            </p>
                            <p>
                                <input name="groupTipoReporte" type="radio" id="test2" value="2"/>
                                <label for="test2">No Marcadas</label>
                            </p>
                        </div>
                    </div>

                </form>

            </div>

            <div class="card-action">
                <a href="#!" class="btn-flat" id="btn-generar">Generar</a>
            </div>

        </div>
    </div>
    

</div>

<script>

    $(document).ready(init);

    function init(){

        $('#btn-generar').click(generarReporte);

        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: 15,
            today: 'Today',
            clear: 'Clear',
            close: 'Ok',
            format: 'yyyy-mm-dd',
            closeOnSelect: false
        });

    }

    function generarReporte(){

        if($('#fechaDesde').val() == '' || $('#fechaDesde').val() == null){
            Materialize.toast('No ha seleccionado la fecha inicial', 2000);
            $('#fechaDesde').validity.valid = false;
            actualizarValidarFormulario('formData');
            return false;
        }

        if($('#fechaHasta').val() == '' || $('#fechaHasta').val() == null){
            Materialize.toast('No ha seleccionado la fecha final', 2000);
            $('#fechaHasta').validity.valid = false;
            actualizarValidarFormulario('formData');
            return false;
        }

        dateInicial = new Date($('#fechaDesde').val());
        dateFinal = new Date($('#fechaHasta').val());

        if(dateFinal < dateInicial){
            Materialize.toast('La fecha incial es menor a la fecha final', 2000);
            return false;
        }        

        if($('input[name=groupTipoReporte]:checked').val() == '' || $('input[name=groupTipoReporte]:checked').val() == null){
            Materialize.toast('Elija un tipo de reporte a generar', 2000);
            return false;
        }

        console.log($('input[name=groupTipoReporte]:checked').val());

        switch($('input[name=groupTipoReporte]:checked').val()){
            case "1":
                window.open('../php/informatica/generar-llegadas.php?fechaDesde='+$('#fechaDesde').val()+'&fechaHasta='+$('#fechaHasta').val(), '_blank');
                break;

            case "2": 
                window.open('../php/informatica/generar-no-marco.php?fechaDesde='+$('#fechaDesde').val()+'&fechaHasta='+$('#fechaHasta').val(), '_blank');
                break;
        }

    }

    function actualizarValidar(idform){
        $('#'+idform+' :input:visible[required="required"]').each(function(){
            if(!this.validity.valid){
                $(this).focus();
                // break
                return false;
            }
        });
    }

</script>

</div>