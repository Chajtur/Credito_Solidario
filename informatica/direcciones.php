<?php

require '../php/conection.php';
session_start();
$stat = $conn->prepare('call listar_direcciones(:iduser);');
$stat->bindValue(':iduser', $_SESSION['user'], PDO::PARAM_STR);
$stat->execute();
$result = $stat->fetchAll(PDO::FETCH_ASSOC);

?>
<script src="../js/plugins/multiselect/multiselect.js"></script>
<!-- Plugin listit by 4Richi -->
<link rel="stylesheet" href="../js/plugins/listit/listit.css">
<script src="../js/plugins/listit/listit.js"></script>
<div class="row">
    <div class="col l4 m5 s12">
        <div class="card blue darken-2">
            <div class="card-content white-text">
                <span class="card-title">Actualización de direcciones</span>
                <p>Ventana para actualizar las direcciones con los códigos de aldea, caserío y barrio a cada crédito que tenga problemas.</p>
            </div>
        </div>
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <span class="card-title">Descripción de cambios</span>
                <div id="indicadoresContainer"></div>
            </div>
            <div class="card-action">
                <a href="#!" class="yellow-text" id="btnRefreshIndicadores"><i class="material-icons right">refresh</i></a>
            </div>
        </div>
    </div>
    <div class="col l8 m7 s12">
        <ul id="listit" class="collection listit">
            <li class="collection-item">
                <span class="title">Codificación de direcciones</span>
            </li>
            <div class="listcontainer collapsible">
            </div>
        </ul>
    </div>
</div>

<!-- Modal Structure -->
<div id="modalSeleccionarDireccion" class="modal" style="max-width:400px !important;">
    <div class="modal-content">
        <h5>Datos de la dirección</h5>
        <div id="multiselect"></div>
        <h5>Observación</h5>
        <div class="input-field">
            <textarea id="textareaobservacion" class="materialize-textarea"></textarea>
            <label for="textareaobservacion">Ingrese una observación</label>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action waves-effect waves-green btn-flat" id="bnGuardarDireccion">Guardar</a>
    </div>
</div>

<script>

$(document).ready(function(){

    $('.modal').modal();

    // Listit
    window.list = $('#listit').listit({
        columnsCount: 3,
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
        headers: ['ID', 'Departamento', 'Municipio', 'Domicilio', 'Negocio', 'Codigo_Domicilio', 'Codigo_Negocio'],
        emptyMessage: '<i class="material-icons orange-text">error</i> No hay elementos en la lista.',
        classes: {
            collapsibleBody: 'blue-grey darken-1 grey-text text-lighten-4',
            collapsibleBodyColumns: 'col s12 m12 l12'
        },
        onClickCollapse: function(event, collapse, body){
            toggleButtons(body);
        },
        buttonsOnElements: [
            {
                button: '<a class="waves-effect waves-blue btn-flat green-text text-lighten-2 right" style="margin-top: 5px" id="btndomicilio"><i class="material-icons left green-text text-lighten-2">home</i> Domicilio</a>',
                buttonOnClick: function(event, element){
                    $('#bnGuardarDireccion').off('click').on('click', function(e){
                        var codigobarrio = $('#selectdepartamento').val()+$('#selectmunicipio').val()+$('#selectaldea').val()+$('#selectcaserio').val()+$('#selectbarrio').val();
                        $(element).find('#codigo_domicilio').text(codigobarrio);       
                        toggleButtons(element);
                        guardarDireccion({
                            idcredito: $(element).find('#id').text(),
                            idbarriocolonia: codigobarrio,
                            observacion: $('#textareaobservacion').val(),
                            tipo: 'C'
                        });
                    });
                    $('#modalSeleccionarDireccion').modal('open');
                }
            },
            {
                button: '<a class="waves-effect waves-blue btn-flat green-text text-lighten-2 right" style="margin-top: 5px" id="btnnegocio"><i class="material-icons left green-text text-lighten-2">store</i> Negocio</a>',
                buttonOnClick: function(event, element){
                    $('#bnGuardarDireccion').off('click').on('click', function(e){
                        var codigobarrio = $('#selectdepartamento').val()+$('#selectmunicipio').val()+$('#selectaldea').val()+$('#selectcaserio').val()+$('#selectbarrio').val();
                        $(element).find('#codigo_negocio').text(codigobarrio);       
                        toggleButtons(element);
                        guardarDireccion({
                            idcredito: $(element).find('#id').text(),
                            idbarriocolonia: codigobarrio,
                            observacion: $('#textareaobservacion').val(),
                            tipo: 'N'
                        });
                    });
                    $('#modalSeleccionarDireccion').modal('open');
                }
            }
        ]
    });

    var toggleButtons = function(body){

        if($(body).find('#codigo_domicilio').text() != 'null'){
            $(body).find('#btndomicilio').attr('disabled', 'disabled');
        }else{
            $(body).find('#btndomicilio').removeAttr('disabled');
        }

        if($(body).find('#codigo_negocio').text() != 'null'){
            $(body).find('#btnnegocio').attr('disabled', 'disabled');
        }else{
            $(body).find('#btnnegocio').removeAttr('disabled');
        }

    }

    var guardarDireccion = function(obj){
        console.log(obj);
        $.ajax({
            type: 'POST',
            url: '../php/informatica/direcciones/insertar-codigo-direccion.php',
            data: obj,
            success: function(data){
                console.log(data);
                if(data != 'false'){   
                    resetModal($('#modalSeleccionarDireccion'));
                    $('#modalSeleccionarDireccion').modal('close');
                    $('#btnRefreshIndicadores').trigger('click');
                    Materialize.toast('Correcto', 2000);
                }else{
                    Materialize.toast('Error', 2000);
                }
            }
        });
    }

    var cargarIndicadores = function(){
        
        var indicadoresContainer = $('#indicadoresContainer');
        var loader = `
        <div class="preloader-wrapper big active center">
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
        `;
        indicadoresContainer.addClass('center');
        indicadoresContainer.empty().append(loader);
        
        $.ajax({
            type: 'POST',
            url: '../php/informatica/direcciones/obtener-indicador-direcciones.php',
            success: function(data){
                var obj = JSON.parse(data);
                var div = $('<div></div>');
                var phoy = $('<p></p>');
                phoy.html('<b>Hoy:</b> '+(obj['Diario'] > 0 ? obj['Diario']+' direcciones actualizadas.' : 'No ha ingresado ninguna dirección.'));
                var ptotal = $('<p></p>');
                ptotal.html('<b>Total:</b> '+(obj['Total'] > 0 ? obj['Total']+' direcciones actualizadas.' : 'No ha ingresado ninguna dirección.'));
                var prestantes = $('<p></p>');
                prestantes.html('<b><p><b>Restantes:</b> :</b> '+obj['Restantes']+' direcciones.');
                div.append(phoy).append(ptotal).append(prestantes);
                indicadoresContainer.removeClass('center');
                indicadoresContainer.empty().append(div);
            }
        });
        
    }
    cargarIndicadores();

    var resetModal = function(modal){
        $(modal).find('select').each(function(){
            $(this).val('');
            $(this).select2();
        });
        $(modal).find('select, textarea').each(function(){
            $(this).val('');
        });
    }

    // Multiselect
    $('#multiselect').multiselect({
        amount: 5,
        defaultValueLabelResult: 'id',
        defaultTextLabelResult: 'nombre',
        labels: ['Departamento', 'Municipio', 'Aldea', 'Caserío', 'Barrio'],
        optionLabels: ['Seleccione un Departamento', 'Seleccione un municipio', 'Seleccione una aldea', 'Seleccione un caserío', 'Seleccione un barrio'],
        sourceData: [
            '../php/informatica/direcciones/obtener-direcciones.php?departamento',
            '../php/informatica/direcciones/obtener-direcciones.php?municipio',
            '../php/informatica/direcciones/obtener-direcciones.php?aldea',
            '../php/informatica/direcciones/obtener-direcciones.php?caserio',
            '../php/informatica/direcciones/obtener-direcciones.php?barrio'
        ],
        select2: true,
        selectIds: ['selectdepartamento', 'selectmunicipio', 'selectaldea', 'selectcaserio', 'selectbarrio']
    });

    $('select.select-multiselect').select2();
    $('.collapsible').collapsible();

    var results = <?php echo json_encode($result);?>;

    $.each(results, function(index, row){
        window.list.insertElement([row.id, row.Departamento, row.municipio, row.Domicilio, row.Negocio, row.idbarriocolonia, row.idbarriocolonianegocio]);
    });

    $('#btnRefreshIndicadores').click(cargarIndicadores);
    
});

</script>