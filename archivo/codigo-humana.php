<?php
/**
 * Archivo para crear y asignar cajas con código para humana
 */
?>
<link rel="stylesheet" href="../js/plugins/tablesearch2/tablesearch2.css">
<link rel="stylesheet" href="../js/plugins/listit/listit.css">

<div class="row">
    <div class="col l10 m10 s10 offset-l1 offset-m1 offset-s1">
        <ul class="collection with-header" id="tablesearch2">
        </ul>
        <ul id="listit" class="collection listit">
            <li class="collection-item">
                <span class="title">Créditos para asignar código</span>
                <!-- <a class="btn-flat waves-effect waves-light right" href="#!"><i class="material-icons">add</i></a> -->
            </li>
            <!-- <li class="collection-item with-actions">
                <div class="input-field">
                    <input placeholder="Buscar" id="search" type="search" class="validate">
                    <i class="material-icons close">close</i>
                </div>
            </li> -->
            
            <div class="listcontainer collapsible popout">
            </div>
        </ul>
    </div>
</div>
<div class="row" style="margin-bottom:15px">
    <div class="col l10 m10 s10 offset-l1 offset-m1 offset-s1">
        <a class="waves-effect waves-light btn-large" id="guardar"><i class="material-icons left">save</i>Guardar</a>
    </div>
</div>

<!-- Plugins requeridos para tablesearch -->
<script src="..\js\plugins\paginathing-master\paginathing.js"></script>
<script src="..\js\plugins\tinysort\tinysort.min.js"></script>
<script src="../js/plugins/tablesearch2/tablesearch2.js"></script>
<script src="../js/plugins/listit/listit.js"></script>

<script>

$(document).ready(function(){
    $('#breadcrum-title').text('Código Humana');

    // Configuración de tablesearch2
    $('#tablesearch2').tablesearch2({
        title: 'Buscar Créditos',
        searchPlaceholder: 'Buscar datos',
        reloadButtonCallback: function(){
            Materialize.toast('Recargando', 2000);
        },
        searchable: true,
        initialMessage: '<i class="material-icons orange-text">info</i> Realice una búsqueda para agregar los créditos a la lista.',
        reloadButtonText: '<i class="material-icons">cached</i>',
        headers: ['Hash', 'Beneficiario', 'Identidad', 'Grupo Solidario', 'Teléfono', 'Agencia'],
        dataSource: '../php/archivo/buscar-creditos-humana.php',
        pagination: true,
        onSelect: function(e, checkbox, li){
            if($(checkbox)[0].checked){
                Materialize.toast('Checked', 2000);
            }else{
                Materialize.toast('Unchecked', 2000);
            }
            console.log(window.tablesearch.getAllSelected());
        },
        maxColumns: 5,
        columnClass: ['col s4 m4 l2','col s4 m5 l3','col hide-on-med-and-down l3','col hide-on-small-only m2 l2','col s4 m2 l2'],
        eachCcollapseTitle: 'Detalles del crédito',
        noResultsFoundMessage: 'Ningún registro',
        columnNames: ['Hash', 'Beneficiario', 'Identidad', 'Grupo Solidario', 'Teléfono', 'Agencia'],
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
        buttons: [
            {
                name: 'Agregar',
                extraClasses: 'blue-text',
                onClick: function(btn, listElement){
                    window.list.insertElement([
                        $(listElement).find('#hash').text(),
                        $(listElement).find('#beneficiario').text(),
                        $(listElement).find('#identidad').text(),
                        $(listElement).find('#gruposolidario').text(),
                        $(listElement).find('#telefono').text()
                    ]);
                },
                buttonInHeader: 4
            }
        ]
    });

    // Configuración de listit
    window.list = $('#listit').listit({
        columnsCount: 4,
        unique: [false,false,true],
        headers: ['Hash', 'Beneficiario', 'Identidad', '', 'Teléfono'],
        emptyMessage: '<i class="material-icons orange-text">error</i> Ingrese créditos desde la tabla superior para asignar el código.',
        classes: {
            collapsibleBodyColumns: 'col s12 m3 l3',
            collapsibleHeaderColumns: 'col s12 m3 l3'
        },
        buttonsOnElements: [
            {
                button: '<a class="waves-effect waves-blue btn-flat red-text right" style="margin-top: 5px">Eliminar</a>',
                buttonInColumn: 3,
                buttonOnClick: function(event, element){
                    window.list.removeElement(element.index());
                    Materialize.toast('Elemento eliminado de la lista', 2000);
                },
            }
        ]
    });
    $('.collapsible').collapsible();
    $('#guardar').click(function(){
        var creditos = window.list.getAllElements();
        if(!creditos.length > 0){
            Materialize.toast('No ha listado ningún crédito', 2000);
            return false;
        }
        var obj = [];
        $.each(creditos, function(index, elm){
            obj.push($(elm).find('#hash').text());
        });
        $.ajax({
            type: 'POST',
            url: '../php/archivo/guardar-codigo-humana.php',
            data: {
                creditos: JSON.stringify(obj)
            },
            success: function(data){
                swal('Se ha generado la caja con el código: '+data);
                $('#floating-refresh').trigger('click');
            }
        });
    });
});

</script>