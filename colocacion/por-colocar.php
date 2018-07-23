<?php

require '../php/conection.php';

$stat_productos = $conn->prepare('select * from programa');
$stat_productos->execute();
$productos = $stat_productos->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Plugins requeridos para tablesearch -->
<script src="..\js\plugins\paginathing-master\paginathing.js"></script>
<script src="..\js\plugins\tinysort\tinysort.min.js"></script>

<!-- Plugin tablesearch -->
<link rel="stylesheet" href="../js/plugins/tablesearch2/tablesearch2.css">
<script src="../js/plugins/tablesearch2/tablesearch2.js"></script>

<link rel="stylesheet" href="../js/plugins/listit/listit.css">
<script src="../js/plugins/listit/listit.js"></script>

<div class="section">
    <div class="row">
       
        <div class="col l10 m10 s12 offset-l1 offset-m1">

            <ul class="collection with-header" id="tablesearch2">
            </ul>

        </div>

        <div class="col l10 m10 s12 offset-l1 offset-m1">

            <div class="card-panel" style="margin-bottom: 0px;padding: 21px 21px 12px 21px;border-radius: 2px 2px 0px 0px;">
                    
                <div class="row">
                    
                    <div class="input-field col s12 m5 l5">

                        <select id="select-producto">
                                
                            <option value="" disabled selected>Elija uno</option>
                            
                            <?php foreach($productos as $fila):?>
                            
                                <option value="<?php echo substr($fila['id'], 0, 12);?>"><?php echo $fila['subprograma'];?></option>
                            
                            <?php endforeach;?>

                        </select>
                        <label>Producto</label>

                    </div>
                    
                    <div class="col s12 m5 l5 input-field">
                        <select id="select-ifi-colocacion">

                            <option value="" disabled selected>Elija una</option>
                            
                            <?php require '../php/select-ifis.php';?>

                        </select>
                        <label>IFI</label>
                    </div>
                    
                    <div class="col s12 m2 l2 input-field">
                        <select id="select-fondo-colocacion">

                            <option value="" disabled selected>Elija uno</option>
                            
                            <?php require '../php/select-fondos.php';?>

                        </select>
                        <label>Fondo</label>
                    </div>
                    
                </div>
            
            </div>

            <ul id="listit" class="collection listit" style="margin-top: 0px;border-radius: 0px 0px 2px 2px;">
                <li class="collection-item">
                    <span class="title">Lista para generar PBS</span>
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

        <div class="col l10 m10 s12 offset-l1 offset-m1">
            <a href="#!" class="btn-large" id="btn-colocarpbs"><i class="material-icons left">playlist_add_check</i>Colocar PBS</a>
        </div>
        
    </div>
</div>
<div id="modal-precedente" class="modal modal-max-width">
    <div class="modal-content center">
        <h5 class="blue-text light">Precedente</h5>

        <div class="preloader-wrapper small active" id="modal-precedente-loading">
            <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>

        <div id="modal-content">
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-blue btn-flat blue-text">Cerrar</a>
    </div>
</div>

<div id="modal-observacion" class="modal modal-max-width">
    <div class="modal-content center">
        <h5 class="blue-text light">Observación</h5>

        <p id="observacion-paragraph"></p>

        <div id="modal-content">
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-blue btn-flat blue-text">Cerrar</a>
    </div>
</div>

<script>
    
$(document).ready(function(){
    
    $('#tablesearch2').tablesearch2({
        title: 'Créditos para Colocar',
        searchPlaceholder: 'Buscar crédito para colocar',
        reloadButton: true,
        initialRequest: '../php/common/obtener-grupos.php?inicial&estado=colocacion',
        reloadButtonText: '<i class="material-icons">cached</i>',
        // reloadButtonCallback: function(){

        // },
        headers: ['Hash', 'Agencia', 'Departamento', 'Ciclo', 'Acciones'],
        dataSource: '../php/common/obtener-grupos.php?search&estado=colocacion',
        pagination: true,
        sortable: true,
        maxColumns: 5,
        columnClass: ['col s2 m2 l2','col s3 m3 l3','col s3 m3 l3','col s2 m2 l2','col s2 m2 l2'],
        eachCcollapseTitle: 'Detalles del Grupo',
        noResultsFoundMessage: 'Ningún crédito para colocar',
        columnNames: ['Hash', 'Agencia', 'Departamento', 'Ciclo', 'Nombre del Grupo', 'Asesor Técnico', 'Supervisor', 'Estado', 'Observación', 'Beneficiarios'],
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
        subData: {
            column: 'beneficiarios',
            title: 'Beneficiarios',
            cardRevealTitleColumnName: 'nombre',
            columnNames: ['Nombre','Identidad','Fecha de Solicitud','Fecha de Nacimiento','Lugar de Nacimiento','Estado Civil','Telefono','Telefono 2','Codigo barrio','Tipo de Vivienda','Dirección del Domicilio','Sector Económico','Actividad Económica','Tipo Cliente','Tipo de Persona','Codigo barrio negocio','Dirección del Negocio','Nombre Referencia 1','Parentezco Referencia 1','Dirección Referencia 1','Teléfono Referencia 1','Nombre Referencia 2','Parentezco Referencia 2','Dirección Referencia 2','Teléfono Referencia 2','Nombre Referencia 3','Parentezco Referencia 3','Dirección Referencia 3','Teléfono Referencia 3','Nombre Referencia 4','Parentezco Referencia 4','Dirección Referencia 4','Teléfono Referencia 4','Nombre del Aval','Identidad del Aval','Teléfono del Aval','Dirección del Aval', 'Monto', 'Forma de Pago', 'Plazo'],
            arrayType: 'assoc' // index or assoc
        },
        filters: true,
        filterColumns: [1,2],
        buttons: [
            {
                name: '<i class="material-icons blue-text" style="line-height: 36px;margin:0">info</i>',
                extraClasses: 'blue-text',
                onClick: function(btn, listElement){
                    $('#modal-content').empty();
                    $('#modal-precedente-loading').show();
                    var id = $(listElement).find('#hash').text();
                    $('#modal-precedente').modal('open');
                    $.ajax({
                        type: "POST",
                        url: "../php/consultar-precedente.php",
                        data: "id="+id,
                        success: function(data){
                            $('#modal-content').text(data);
                            $('#modal-precedente-loading').hide();
                        }
                    });
                },
                buttonInHeader: 4
            },
            {
                name: '<i class="material-icons blue-text" style="line-height: 36px;margin:0">add</i>',
                extraClasses: 'blue-text',
                onClick: function(btn, listElement){
                    if(window.list.insertElement([
                        $(listElement).find('#hash').text(),
                        $(listElement).find('#gruposolidario').text(),
                        $(listElement).find('#agencia').text(),
                        $(listElement).find('#departamento').text(),
                        $(listElement).find('#gruposolidario').text(),
                        $(listElement).find('#supervisor').text(),
                        $(listElement).find('#asesortécnico').text()
                    ], function(newElement){
                        $(newElement).find('#eliminar').click(function(){
                            $(btn).removeAttr("disabled");
                        });
                    })){
                        $(btn).attr("disabled","disabled");
                        window.gruposParaColocar.push($(listElement).find('#hash').text());
                        Materialize.toast('Se ha agregado el crédito a la lista', 2000);
                    }
                },
                buttonInHeader: 4
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
        headers: ['Hash', 'Grupo Solidario', 'Agencia', 'Acciones', 'Grupo Solidario', 'Supervisor', 'Asesor Técnico'],
        emptyMessage: '<i class="material-icons orange-text">error</i> Ingrese grupos para generar el PBS.',
        classes: {
            collapsibleBodyColumns: 'col s12 m3 l3',
            collapsibleHeaderColumns: 'col s12 m3 l3'
        },
        buttonsOnElements: [
            {
                button: '<a class="waves-effect waves-blue btn-flat red-text"><i class="material-icons red-text" style="line-height: 36px;margin:0">clear</i></a>',
                buttonInColumn: 3,
                id: 'eliminar',
                buttonOnClick: function(event, element){
                    let ind = window.gruposParaColocar.indexOf($(element).find('#hash').text());
                    window.gruposParaColocar.splice(ind, 1);
                    window.list.removeElement(element.index());
                    Materialize.toast('Elemento eliminado de la lista', 2000);
                }
            }
        ]
    });

    $('#select-producto').val('P01');

    window.gruposParaColocar = [];
    
    $('.modal').modal();

    $('#breadcrum-title').text('Colocación de Créditos');
    
    $('#btn-colocarpbs').click(function(event){
        
        $('.invalid').each(function(){
            $(this).removeClass('invalid');
        });
        
        if(window.gruposParaColocar.length == 0){
            swal("No ha ingresado ningún grupo al PBS");
            return false;
        }
        if($('#select-ifi-colocacion').val() == null){
            $('#select-ifi-colocacion').addClass('invalid').material_select();
            Materialize.toast('Por favor seleccione la IFI', 2000);
            return false;
        }
        if($('#select-fondo-colocacion').val() == null){
            $('#select-fondo-colocacion').addClass('invalid').material_select();
            Materialize.toast('Por favor seleccione el Fondo', 2000);
            return false;
        }
        
        swal({
            title: "¿Está seguro de colocar este PBS?",
            text: "El PBS será colocado con los datos seleccionados.",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Colocar",
            closeOnConfirm: false
        },
        function(){

            var obj = {
                grupos_hash: window.gruposParaColocar,
                ifi: $('#select-ifi-colocacion').val(),
                fondo: $('#select-fondo-colocacion').val(),
                producto: $('#select-producto').val()
            }

            $.ajax({
                type: 'POST',
                url: '../php/colocacion/colocar-credito.php',
                data: 'data='+JSON.stringify(obj),
                success: function(data){
                    
                    if(data){
                        console.log(data);
                        $('#floating-refresh').trigger('click');
                        swal({
                            title: "Colocado", 
                            text: "El PBS ha sido colocado.", 
                            type: "success"
                        }, function(){
                            window.open('../docs/excel/'+data, '_blank');
                            $('#floating-refresh').trigger('click');
                        });
                    }else{
                        swal("Error", "No se pudo colocar el PBS.", "error");
                    }

                }
            });

        });
        
    });
    
    $('#breadcrum-title').text('Colocación de Créditos');
    
    $('select').material_select();
    
    $('.collapsible').collapsible();
    
    $('.tooltipped').tooltip();
    
    $('[href="#!"].btn-observacion').off('click').on('click', function(){
        var observ = $(this).parent().parent().find('#grupoObservacion').val();
        $('#modal-observacion').find('#observacion-paragraph').empty();
        $('#modal-observacion').find('#observacion-paragraph').text(observ);
        console.log(observ);
        $('#modal-observacion').modal('open');
    });

});
    
</script>