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
<script>

$(document).ready(function(){
    $('#tablesearch2').tablesearch2({
        title: 'Casos CDA',
        reloadButton: true,
        searchable: false,
        initialMessage: 'Hola',
        initialRequest: '../php/common/casos-coordinadores.php?obtener',
        reloadButtonText: '<i class="material-icons">cached</i>',
        headers: ['Fecha', 'Responsable', 'Nombre', 'Telefono', 'Identidad', 'Consulta', 'Solución'],
        dataSource: '../php/common/casos-coordinadores.php?search',
        pagination: true,
        sortable: true,
        eachCcollapseTitle: 'Detalles del caso',
        noResultsFoundMessage: 'Ningún registro',
        columnNames: ['Fecha', 'Responsable', 'Nombre', 'Telefono', 'Identidad', 'Consulta', 'Solución'],
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
        buttons: [
            {
                name: '<i class="material-icons blue-text" style="line-height: 36px;margin:0">info</i>',
                extraClasses: 'blue-text',
                onClick: function(btn, listElement){
                    Materialize.toast('clicked', 2000);
                },
                buttonInHeader: 4
            },
            {
                name: '<i class="material-icons blue-text" style="line-height: 36px;margin:0">add</i>',
                extraClasses: 'blue-text',
                onClick: function(btn, listElement){
                    Materialize.toast('clicked', 2000);
                },
                buttonInHeader: 4
            }
        ]
    });
    $('.collapsible').collapsible();
});
</script>