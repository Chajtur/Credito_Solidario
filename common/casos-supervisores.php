<!-- Plugins requeridos para tablesearch -->
<script src="..\js\plugins\paginathing-master\paginathing.js"></script>
<script src="..\js\plugins\tinysort\tinysort.min.js"></script>

<!-- Plugin tablesearch -->
<link rel="stylesheet" href="../js/plugins/tablesearch2/tablesearch2.css">
<script src="../js/plugins/tablesearch2/tablesearch2.js"></script>
<div class="row">
    <div class="col s12 m10 l10 offset-l1 offset-m1">
        <ul class="collection with-header" id="tablesearch2">
        </ul>
    </div>
</div>
<!-- Modal Structure -->
<div id="modalsolucionar" class="modal">
    <div class="modal-content">
        <h4>Solucionar el caso</h4>
        <div class="row">
            <div class="col s12 m12 l12">
                <div style="font-size: 20px; font-weight: 350; margin-bottom: 10px;">Detalles del caso</div>
            </div>
            <div class="col s12 m6 l6" style="margin-bottom: 3px;">
                <b>Fecha:</b>
                <span id="solucionfecha"></span>
            </div>
            <div class="col s12 m6 l6" style="margin-bottom: 3px;">
                <b>Responsable:</b>
                <span id="solucionresponsable"></span>
            </div>
            <div class="col s12 m6 l6" style="margin-bottom: 3px;">
                <b>Nombre:</b>
                <span id="solucionnombre"></span>
            </div>
            <div class="col s12 m6 l6" style="margin-bottom: 3px;">
                <b>Telefono:</b>
                <span id="soluciontelefono"></span>
            </div>
            <div class="col s12 m6 l6" style="margin-bottom: 3px;">
                <b>Identidad:</b>
                <span id="solucionidentidad"></span>
            </div>
            <div class="col s12 m6 l6" style="margin-bottom: 3px;">
                <b>Consulta:</b>
                <span id="solucionconsulta"></span>
            </div>
            <div class="col s12 m12 l12" style="margin-bottom: 3px;">
                <div class="input-field">
                    <input id="solucion" type="text" class="">
                    <label for="solucion">Solución</label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" id="guardarsolucion" class="modal-action waves-effect waves-green btn-flat blue-text"><b>Solucionar</b></a>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.modal').modal();
        $('#tablesearch2').tablesearch2({
            title: 'Casos CDA',
            reloadButton: true,
            searchable: false,
            initialMessage: 'Hola',
            initialRequest: '../php/common/casos-coordinadores.php?obtener',
            reloadButtonText: '<i class="material-icons">cached</i>',
            headers: ['Fecha', 'Responsable', 'Nombre', 'Telefono', 'Identidad', 'Consulta', 'Solución', 'Id'],
            dataSource: 'tablesearch2-backend.php?search',
            pagination: true,
            sortable: true,
            eachCcollapseTitle: 'Detalles del caso',
            noResultsFoundMessage: 'Ningún registro',
            columnNames: ['Fecha', 'Responsable', 'Nombre', 'Telefono', 'Identidad', 'Consulta',
                'Solución', 'Id'
            ],
            paginationObject: {
                perPage: 5,
                limitPagination: 4,
                containerClass: 'collection-item elem with-pagination',
                ulClass: 'pagination',
                prevText: '<i class="material-icons md-18">chevron_left</i>',
                nextText: '<i class="material-icons md-18">chevron_right</i>',
                firstText: '<i class="material-icons md-18">first_page</i>',
                lastText: '<i class="material-icons md-18">last_page</i>',
                pageNumbers: true
            },
            filters: true,
            filterColumns: [1],
            buttons: [{
                name: '<i class="material-icons left white-text">done</i> Solucionar Caso',
                extraClasses: 'btn white-text',
                onClick: function (btn, listElement) {
                    $('#solucionfecha').text($(listElement).find('#fecha').text());
                    $('#solucionresponsable').text($(listElement).find('#responsable').text());
                    $('#solucionnombre').text($(listElement).find('#nombre').text());
                    $('#soluciontelefono').text($(listElement).find('#telefono').text());
                    $('#solucionidentidad').text($(listElement).find('#identidad').text());
                    $('#solucionconsulta').text($(listElement).find('#consulta').text());
                    $('#guardarsolucion').attr('idcaso', $(listElement).find('#id').text());
                    $('#modalsolucionar').modal('open');
                }
            }]
        });
        $('#guardarsolucion').click(function(){
            var self = $(this);
            if($('#solucion').val() != '' && $('#solucion').val() != null){
                Materialize.toast('Guardando solución', 3000);
                self.attr('disabled', 'disabled');
                console.log({
                    solucion: $('#solucion').val(),
                    id_caso: self.attr('idcaso')
                });
                $.ajax({
                    type: 'POST',
                    url: '../php/common/guardar-solucion-caso.php',
                    data: {
                        solucion: $('#solucion').val(),
                        id_caso: self.attr('idcaso')
                    },
                    success: function(data){
                        if(data !='false'){
                            Materialize.toast('Se ha guardado la solución', 3000);
                            $('#modalsolucionar').modal('close');
                            $('#floating-refresh').trigger('click');
                        }
                    }
                });
            }else{
                Materialize.toast('Por favor rellene el campo de solución.', 3000);
            }
        });
        $('.collapsible').collapsible();
    });
</script>
