<?php

/**
 * Archivo para recibir los créditos de archivo
 */

?>
<!-- Plugins requeridos para tablesearch -->
<script src="..\js\plugins\paginathing-master\paginathing.js"></script>
<script src="..\js\plugins\tinysort\tinysort.min.js"></script>

<!-- Plugin tablesearch -->
<link rel="stylesheet" href="../js/plugins/tablesearch2/tablesearch2.css">
<script src="../js/plugins/tablesearch2/tablesearch2.js"></script>

<div class="section">
    <div class="row">
        <div class="col s12 m8 l10 offset-m2 offset-l1">
            <ul class="collection with-header" id="tablesearch2">
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m8 l10 offset-m2 offset-l1">
            <a class="waves-effect waves-light btn-large" id="recibidos-success" disabled><i class="material-icons left">get_app</i>Recibir Créditos</a>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    $('#tablesearch2').tablesearch2({
        title: 'Buscar Créditos para recibir',
        reloadButtonCallback: function(){
            Materialize.toast('Recargando', 2000);
        },
        searchable: true,
        onSearch: function(){
            $('#recibidos-success').removeAttr('disabled');
            window.grupos = [];
        },
        initialMessage: '<i class="material-icons amber-text">info</i> Realice una  búsqueda de faja para mostrar los créditos.',
        // initialRequest: '',
        reloadButtonText: '<i class="material-icons">cached</i>',
        headers: ['ID Crédito', 'Hash', 'Grupo Solidario', 'Asesor Técnico', 'Estatus', 'IFI', 'Ciclo', 'Fecha de Colocación','Beneficiario', 'Supervisor'],
        dataSource: '../php/common/obtener-grupos.php?fajas&search',
        pagination: true,
        sortable: true,
        selectable: true, // Habilitamos que sean seleccionables
        onSelect: function(e, checkbox, li){ // Evento onselect (checkboxes)
            if($(checkbox)[0].checked){
                window.grupos.push($(li).find('#hash').text());
                // Materialize.toast('Checked', 2000);
            }else{
                let ind = window.grupos.indexOf($(li).find('#hash').text());
                window.grupos.splice(ind, 1);
                // Materialize.toast('Unchecked', 2000);
            }
        },
        maxColumns: 5,
        filters: true,
        filterColumns: [1],
        columnClass: ['col s4 m2 l2','col s4 m2 l2','col hide-on-med-and-down l2','col hide-on-small-only m3 l3','col s4 m3 l3'],
        eachCcollapseTitle: 'Detalles del grupo',
        noResultsFoundMessage: 'Ningún registro con ese código de faja.',
        columnNames: ['ID Crédito', 'Hash', 'Grupo Solidario', 'Asesor Técnico', 'Estatus', 'IFI', 'Ciclo', 'Fecha de Colocación', 'Beneficiario', 'Supervisor'],
        paginationObject: {
            perPage: 5,
            limitPagination: 2,
            containerClass: 'collection-item elem with-pagination',
            ulClass: 'pagination',
            prevText: '<i class="material-icons md-18">chevron_left</i>', 
            nextText: '<i class="material-icons md-18">chevron_right</i>', 
            firstText: '<i class="material-icons md-18">first_page</i>',
            lastText: '<i class="material-icons md-18">last_page</i>',
            pageNumbers: true
        }
    });
    
    window.grupos = [];
    
    $('#breadcrum-title').text('Recepción de Créditos');
    
    $('select').material_select();
    
    $('#recibidos-success').click(function(){
        
        // console.log(window.grupos.length);

        if(window.grupos.length == 0){
            swal("Ningún Crédito Seleccionado", "Por favor seleccione los créditos que recibió", "error");
            return false;
        }
            
        swal({
            title: "¿Se le entregaron los creditos seleccionados?",
            text: "Al precionar el boton de Confirmar, los grupos pasarán a Archivo para digitar la línea base",
            type: "warning",
            showCancelButton: true,
            /*confirmButtonColor: "#DD6B55",*/
            confirmButtonText: "Confirmar",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            cancelButtonText: "Cancelar"
        },
        function(){
            $.ajax({
                type: 'POST',
                url: '../php/archivo/recibir-grupo.php',
                data: 'credito='+JSON.stringify(window.grupos),
                success: function(data){

                    if(data){
                        swal({
                            title: "Completado", 
                            text: "El crédito se ha recibido con éxito.", 
                            type: "success"
                        }, function(){
                            window.open('../docs/'+data, '_blank');
                            $('#floating-refresh').trigger('click');
                        });
                    }

                }
            });
        });
        
    });
    
    listaSor();
    
    $('.collapsible').collapsible();

});

function listaSor(){

    var options = {
        page: 10,
        pagination: true,
        valueNames: [ 'codigog', 'nombreg', 'gestorg', 'estadog' ],
        fuzzySearch: {
            searchClass: "fuzzy-search",
            location: 0,
            distance: 100,
            threshold: 0.2,
            multiSearch: true
        }
    };
    window.listObj = new List('recibidos-archivo-list', options);
    
}

</script>