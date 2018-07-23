<?php

require '../php/conection.php';

$stat_ifi = $conn->prepare('select * from ifi');
$stat_ifi->execute();
$ifis = $stat_ifi->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Plugins requeridos para tablesearch -->
<script src="..\js\plugins\paginathing-master\paginathing.js"></script>
<script src="..\js\plugins\tinysort\tinysort.min.js"></script>

<!-- Plugin tablesearch -->
<link rel="stylesheet" href="../js/plugins/tablesearch2/tablesearch2.css">
<script src="../js/plugins/tablesearch2/tablesearch2.js"></script>

<link rel="stylesheet" href="../js/plugins/listit/listit.css">
<script src="../js/plugins/listit/listit.js"></script>

<section>

    <div class="row">
    
        <div class="col l10 m10 s12 offset-l1 offset-m1">

            <br>

            <label>Seleccione una IFI</label>
            <select class="" id="select-ifis">
                <option value="" disabled selected>Elija una opción</option>
            </select>


        </div>

    </div>

    <div class="row">

        <div class="col l10 m10 s12 offset-l1 offset-m1">
            <ul class="collection with-header" id="tablesearch2">
            </ul>
        </div>

    </div>

    <div class="row">

        <div class="col l10 m10 s12 offset-l1 offset-m1">
            <ul id="listit" class="collection listit" style="margin-top: 0px;border-radius: 0px 0px 2px 2px;">
                <li class="collection-item">
                    <span class="title">Lista para generar hoja</span>
                    <!-- <a class="btn-flat waves-effect waves-light right" href="#!"><i class="material-icons">add</i></a> -->
                </li>
                <!-- <li class="collection-item with-actions">
                    <div class="input-field">
                        <input placeholder="Buscar" id="search" type="search" class="validate">
                        <i class="material-icons close">close</i>
                    </div>
                </li> -->
                
                <div class="listcontainer collapsible">
                </div>
            </ul>
        </div>

    </div>
    <div class="row">
        <div class="col l10 m10 s12 offset-l1 offset-m1">
            <a class="waves-effect waves-light btn-large" id="btn-generar-archivo"><i class="material-icons left">file_download</i>Generar hoja</a>
        </div>
    </div>
    <br>

</section>

<script>

$(document).ready(function(){

    var agregarEliminarHashEvent = function(){
        $('.remove-hash').off('click').on('click', function(){
            var string = $(this).parent().next().val();
            window.grupos.splice(window.grupos.indexOf(string), 1);
        })
    }

    var loadIfisOnSelect = function(){
        var ifis = <?php echo json_encode($ifis);?>;
        var select = $('#select-ifis');
        $.each(ifis, function(index, value){
            let option = $('<option></option>');
            option.val(value.id);
            option.text(value.Nombre);
            select.append(option);
        });
        $('select').material_select();
    }
    
    $('#breadcrum-title').text('Generación de Hoja para archivo');

    $('#tablesearch2').tablesearch2({
        title: 'Buscar de créditos para agregar',
        searchPlaceholder: 'Búsqueda de créditos para bajar',
        // reloadButton: true,
        // initialRequest: '../php/common/obtener-grupos.php?archivo&inicial',
        reloadButtonText: '<i class="material-icons">cached</i>',
        // reloadButtonCallback: function(){

        // },
        headers: ['Hash', 'Grupo Solidario', 'Agencia', 'Departamento'],
        dataSource: '../php/common/obtener-grupos.php?archivo&search',
        pagination: true,
        sortable: true,
        initialMessage: 'Los créditos buscados aparecerán acá',
        eachCcollapseTitle: 'Detalles del Grupo',
        noResultsFoundMessage: 'Ningún crédito encontrado',
        columnNames: ['Hash', 'Grupo Solidario', 'Asesor', 'Supervisor', 'Ifi', 'Ciclo', 'Fecha de Colocación'],
        paginationObject: {
            perPage: 4,
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
                onClick: function(btn, listElement, e){
                    if(!$('#select-ifis').val()){
                        Materialize.toast('Por favor seleccione la IFI', 3000);
                        return false;
                    }
                    if($('#select-ifis').val() == $(listElement).find('#ifi').text()){
                        if(window.list.insertElement([
                            $(listElement).find('#hash').text(),
                            $(listElement).find('#gruposolidario').text(),
                            $(listElement).find('#asesor').text(),
                            $(listElement).find('#supervisor').text(),
                            $(listElement).find('#ifi').text(),
                            $(listElement).find('#ciclo').text(),
                            $(listElement).find('#fechadecolocacion').text()
                        ], function(newElement){
                            $(newElement).find('#eliminar').click(function(){
                                $(btn).removeAttr("disabled");
                            });
                        })){
                            $(btn).attr('disabled','disabled');
                            window.grupos.push($(listElement).find('#hash').text());
                            Materialize.toast('Se ha agregado el crédito a la lista', 2000);
                        }
                    }else{
                        Materialize.toast('La IFI del grupo no coincide con la seleccionada', 3500);
                    }
                },
                buttonInHeader: 3
            }
        ]
    });

    window.list = $('#listit').listit({
        columnsCount: 4,
        unique: [true],
        pagination: true,
        paginationOptions: {
            perPage: 4,
            limitPagination: 4,
            containerClass: 'collection-item elem with-pagination',
            ulClass: 'pagination',
            prevText: '<i class="material-icons md-18">chevron_left</i>', 
            nextText: '<i class="material-icons md-18">chevron_right</i>', 
            firstText: '<i class="material-icons md-18">first_page</i>',
            lastText: '<i class="material-icons md-18">last_page</i>',
            pageNumbers: true
        },
        headers: ['Hash', 'Grupo Solidario', 'Asesor', 'Supervisor', 'Ifi', 'Ciclo', 'Fecha de Colocación'],
        emptyMessage: '<i class="material-icons orange-text">error</i> Ingrese grupos a la lista.',
        classes: {
            collapsibleBodyColumns: 'col s12 m3 l3',
            collapsibleHeaderColumns: 'col s12 m3 l3'
        },
        buttonsOnElements: [
            {
                button: '<a class="waves-effect waves-blue btn-flat red-text">Eliminar</a>',
                buttonInColumn: 3,
                id: 'eliminar',
                buttonOnClick: function(event, element){
                    let ind = window.grupos.indexOf($(element).find('#hash').text());
                    window.grupos.splice(ind, 1);
                    window.list.removeElement(element.index());
                    Materialize.toast('Elemento eliminado de la lista', 2000);
                },
            }
        ]
    });

    window.grupos = [];
    window.ifi = $('#select-ifis').val();

    loadIfisOnSelect();

    $('#btn-loader').hide();

    $('.collapsible').collapsible();

    $('#select-ifis').change(function(e){
        var self = this;
        var restartList = function(){
            window.ifi = $('#select-ifis').val();
            window.list.removeAllElements();
            window.grupos = [];
        }
        if(window.ifi == $('#select-ifis').val()){
            return false;
        }
        if(window.list.getHowManyElements() > 0){
            swal({
                title: "¿Está seguro/a?",
                text: "Si cambia la IFI, los grupos que ha agregado a la lista serán eliminados",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, cambiar IFI",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true,
                html: false
            },function(confirm){
                if(confirm){
                    restartList();
                }else{
                    $(self).val(window.ifi);
                    $(self).material_select('destroy');
                    $(self).material_select();
                }
            });
        }else{
            restartList();
        }
    });

    $('#btn-generar-archivo').click(function(){

        if(window.grupos.length == 0){
            swal("No ha agregado ningún Hash al archivo");
            // Materialize.toast('No ha agregado ningún Hash al archivo', 2000);
            return false;
        }
        
        $(this).attr('disabled','disabled');
        // $('#btn-loader').show();
        Materialize.toast('Generando', 2000);

        $.ajax({
            type: 'POST',
            url: '../php/digitacion/generar-hoja-archivo.php',
            data: {
                grupos: JSON.stringify(window.grupos),
                ifi: window.ifi
            },
            success: function(data){
                if(data != 'false'){
                    var obj = JSON.parse(data);
                // $('#btn-loader').hide();
                    $('#floating-refresh').trigger('click');
                    swal("Se ha generado el archivo en el código de faja "+obj.codigo_faja);
                    window.open(obj.ruta, '_blank');
                }else{
                    swal("No se ha podido procesar la hoja");
                }
                
            }
        });

    });

    $('#btn-agregar-hash').click(function(){

        if($('#input-hash').val() == ''){
            Materialize.toast('Por favor ingrese un hash', 1000);
            $('#input-hash').focus();
            return false;
        }

        if($('#input-hash').val().length < 4 || $('#input-hash').val().length > 8){
            Materialize.toast('No es un hash válido', 1000);
            $('#input-hash').focus();
            return false;
        }

        if($.inArray($('#input-hash').val(), window.grupos) != -1){
            console.log($('#input-hash').val());
            console.log(window.grupos);
            Materialize.toast('El grupo ya ha sido agregado', 1000);
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '../php/digitacion/verificar-hash.php',
            data: {
                hash: $('#input-hash').val()
            },
            success: function(data){

                if(data == 'true'){
                    $('#grupos-agregados').append(`
                        <div class="chip">
                            <div>`+$('#input-hash').val()+`
                                <i class="close material-icons remove-hash">close</i>
                            </div>
                            <input type="hidden" id="hash" value="`+$('#input-hash').val()+`"/>
                        </div>
                    `);
                    agregarEliminarHashEvent();
                    window.grupos.push($('#input-hash').val());
                }else{
                    if(data == 'false'){
                        Materialize.toast('El Hash no existe', 5000);
                    }else{
                        Materialize.toast(data, 5000);
                    }
                }
                
            }
        });

    });

});


</script>