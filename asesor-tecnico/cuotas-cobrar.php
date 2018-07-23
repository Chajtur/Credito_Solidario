<!-- Plugin Paginathing required by Tablesearch and listit -->
<script src="../js/plugins/paginathing/paginathing.js"></script>

<!-- Plugin listit by 4Richi -->
<link rel="stylesheet" href="../js/plugins/listit/listit.css">
<script src="../js/plugins/listit/listit.js"></script>

<!-- Plugin Moment -->
<script src="../js/plugins/pignose-datepicker/dist/moment.min.js"></script>

<!-- Plugin Pignose Calendar -->
<link rel="stylesheet" href="../js/plugins/pignose-datepicker/dist/pignose.calendar.css">
<script src="../js/plugins/pignose-datepicker/dist/pignose.calendar.js"></script>
<div class="row">

    <div class="col l5 m5 s12">
        <div style="" id="cadate" class="calender"></div>
    </div>

    <div class="col l7 m7 s12">

        <ul id="listit" class="collection listit">
            <li class="collection-item">
                <span class="title">Pagos del día</span>
            </li>
            <div class="listcontainer collapsible popout">
            </div>
        </ul>

    </div>

</div>
<script>

$(document).ready(function(){
    $('.collapsible').collapsible();
    window.calendar = $("#cadate").pignoseCalendar({
        lang: 'es',
        format: 'YYYY-MM-DD',
        select: function(date, context){
            window.list.loader('show');
            $.ajax({
                type: 'POST',
                url: '../php/asesor-tecnico/pagos-del-dia.php',
                data: {
                    date: date[0]._i
                },
                success: function(data){
                    if(data != 'false'){
                        window.list.removeAllElements();
                        var obj = JSON.parse(data);
                        $.each(obj, function(index, value){
                            window.list.insertElement([value.Beneficiario.toString(), value.fecha_desembolso.toString(), value.ciclo.toString(), value.Cuota.toString(), value.Domicilio.toString(), value.monto_desembolsado.toString(), value.Telefono.toString()]);
                        });
                        window.list.loader('hide');
                    }else{
                        Materialize.toast('Error al obtener los datos', 2000);
                    }
                }
            });
        }
    });

    window.list = $('#listit').listit({
        columnsCount: 3,
        pagination: true,
        headers: ['Beneficiario', 'Fecha Desembolso', 'Ciclo', 'Cuota', 'Domicilio', 'Monto Desembolsado', 'Telefono'],
        emptyMessage: '<i class="material-icons orange-text">error</i> Seleccione un día del calendario.',
        classes: {
            collapsibleBodyColumns: 'col s12 m12 l12',
            collapsibleHeaderColumns: 'col s12 m3 l3'
        }
    });

});

</script>