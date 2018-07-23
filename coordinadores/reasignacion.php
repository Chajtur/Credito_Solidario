<?php
/**
 * Archivo para cambiar asesores de supervisores 
 */


require '../php/conection.php';
session_start();

$stat = $conn->prepare('select * from gsc where tipoEmpleado = "Supervisor" and parent = :id');
$stat->bindValue(':id', $_SESSION['user'], PDO::PARAM_STR);
$stat->execute();
$supervisores = $stat->fetchAll(PDO::FETCH_ASSOC);

?>

<style>

.collection {
    overflow: visible;
}

.with-move-pointer {
    cursor: move;
}

.with-move-pointer:hover {
    background-color: #E3F2FD;
}

.secondary-content.actions {
    position: absolute;
    right: 15px;
    top: 15px;
}

.collection-title {
    font-size: 18px;
    padding-top: 20px !important;
    padding-bottom: 20px !important;
    padding-right: 40px !important;
}
</style>

<div id="card-alert" class="card blue">
    <div class="card-content white-text">
        <p>INFO: Agregue un supervisor para ver la lista de asesores del mismo y realizar modificaciones.</p>
    </div>
    <!-- <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button> -->
</div>

<div class="card-panel no-padding">
    <!-- <span class="card-title">Acciones</span> -->
    <a class="waves-effect waves-light btn-flat" id="btnModalAgregarSupervisor"><i class="material-icons left">add_circle_outline</i>Agregar Supervisor</a>
    <a class="waves-effect waves-light btn-flat" id="btnLimpiarSupervisores" disabled><i class="material-icons left">cached</i>Limpiar</a>
    <a class="waves-effect waves-light btn-flat" id="btnRestaurar" disabled><i class="material-icons left">settings_backup_restore</i>Restaurar</a>
    <a class="waves-effect waves-light btn-flat green-text" id="btnGuardarCambios" disabled><i class="material-icons left">save</i>Guardar</a>
    
</div>


<div class="row" id="supervisoreslistcontainer">

    <div class="col s12 center grey-text">
        <br>
        <i class="material-icons large">info</i>
        <p class="no-margin">No se ha seleccionado ningún supervisor</p>
    </div>

</div>

<br>

<!-- Modal Structure -->
<div id="modalSupervisor" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4>Supervisores</h4>
        <p>Elija un supervisor de la lista para agregarlo al modelo.</p>
        <div class="row">
            <div class="input-field col s12">
                <select id="selectsupervisores">
                    <option value="" disabled selected>Seleccione un supervisor...</option>
                </select>
                <label>Lista de supervisores</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action waves-effect waves-green btn-flat blue white-text" id="btnAgregarSupervisor">Agregar</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
    </div>
</div>

<script>

(function(){

    var sup = <?php echo json_encode($supervisores);?>;

    $.each(sup, function(index, value){
        $('#selectsupervisores').append(`
            <option value="`+value.id+`">`+value.nombre+`</option>
        `);
    });

}());

$(document).ready(function(){

    window.cambios = {};
    window.restore = {};

    $('#breadcrum-title').text('Reasignación de Supervisores');

    // Materialize
    $('select').material_select();
    $('.modal').modal(); 

    // Eventos
    $('#btnModalAgregarSupervisor').click(function(){
        $('#modalSupervisor').modal('open');
    });
    $('#btnAgregarSupervisor').click(agregarSupervisor);
    $('#btnLimpiarSupervisores').click(limpiarSupervisoresfunction);
    $('#btnRestaurar').click(restaurarCambios);
    $('#btnGuardarCambios').click(guardar);

});

function limpiarSupervisoresfunction(){

    $('#supervisoreslistcontainer').fadeOut(200, function(){
        $(this).empty();
        $(this).append(`
            <div class="col s12 center grey-text">
                <br>
                <i class="material-icons large">info</i>
                <p class="no-margin">No se ha seleccionado ningún supervisor</p>
            </div>
        `);
        $(this).fadeIn(200);
        Materialize.toast('Listo', 2000);
        $('#btnLimpiarSupervisores').attr('disabled', 'disabled');
        window.cambios = {};
    });

}

function asignarEventoEliminarSupervisorUI(){

    $('.btneliminarsupervisor').off('click').on('click', function(){
        
        if(window.cambios[$(this).attr('supervisor')].agregar.length > 0 || window.cambios[$(this).attr('supervisor')].eliminar.length > 0){
            Materialize.toast('No se puede remover porque ha sido modificado', 2000);
            return false;
        }

        delete window.cambios[$(this).attr('supervisor')];

        $('#'+$(this).attr('supervisor')).fadeOut(200, function(){
            $(this).remove();
            if($('.collection.conected').length == 0){
                $('#supervisoreslistcontainer').append(`
                    <div class="col s12 center grey-text">
                        <br>
                        <i class="material-icons large">info</i>
                        <p class="no-margin">No se ha seleccionado ningún supervisor</p>
                    </div>
                `);
                $('#btnLimpiarSupervisores').attr('disabled', 'disabled');
                $('#btnRestaurar').attr('disabled', 'disabled');
            }
        });

    });

}

function agregarSupervisor(){

    var repetido = false;
    $.each(window.cambios, function(index, value){
        if(index == $('#selectsupervisores').val()){
            repetido = true;
            return false;
        }
    });

    if(repetido){
        Materialize.toast('Ya agregó el supervisor seleccionado', 2000);
        return false;
    }

    if($('#selectsupervisores').val() == '' || $('#selectsupervisores').val() == null){
        Materialize.toast('No ha seleccionado ningun supervisor', 2000);
        return false;
    }

    var auxthis = $(this);

    auxthis.attr('disabled', 'disabled');
    auxthis.text('Agregando...');

    $.ajax({
        type: 'POST',
        url: '../php/coordinadores/obtener-asesores-gestor.php',
        data: {
            idsupervisor: $('#selectsupervisores').val()
        },
        success: function(data){

            var asesores = JSON.parse(data);
            
            var element = `
            <div class="col l4 m6 s12" id="`+$('#selectsupervisores').val()+`">
                <ul class="collection with-header z-depth-1 conected no-margin" id="sortable`+$('#selectsupervisores').val()+`" supervisor="`+$('#selectsupervisores').val()+`">
                    <li class="collection-item collection-title locked">
                        <span class="title">`+$("#selectsupervisores option:selected").text()+`</span>
                        <div class="secondary-content actions">
                            <a href="#!" supervisor="`+$('#selectsupervisores').val()+`" class="waves-effect waves-light btn-flat nopadding tooltipped btneliminarsupervisor" data-delay="10" data-position="left" data-tooltip="Remover" >
                                <i class="material-icons center-align">clear</i>
                            </a>
                        </div>
                    </li>`;

            $.each(asesores, function(ind, val){
                element += `
                    <li class="collection-item with-move-pointer" supervisor="`+$('#selectsupervisores').val()+`" asesor="`+val.id+`">
                        <div><i class="material-icons left">drag_handle</i>`+val.nombre+`<!--<span class="secondary-content">123,128</span>--></div>
                    </li>`;
            });

            element += `                    
                </ul>  
            </div>`;

            if($('.collection.conected').length == 0){
                $('#supervisoreslistcontainer').empty();
            }

            $('#supervisoreslistcontainer').append(element);

            window.restore[$('#selectsupervisores').val()] = $('#sortable'+$('#selectsupervisores').val()).html();

            $("#sortable"+$('#selectsupervisores').val()).sortable({

                connectWith: ".conected",
                items: "li:not(.locked)",
                update: function(event, ui){

                    // Agregar a eliminar del anterior
                    if($(ui.sender).attr('supervisor') != undefined){
                        if($.inArray($(ui.item).attr('asesor'), window.cambios[$(ui.sender).attr('supervisor')].eliminar) < 0){
                            window.cambios[$(ui.sender).attr('supervisor')].eliminar.push($(ui.item).attr('asesor'));
                        }
                    }
                    
                    // Agregar a agregar del nuevo
                    if($(ui.item).parent().attr('supervisor') != undefined){
                        if($.inArray($(ui.item).attr('asesor'), window.cambios[(ui.item).parent().attr('supervisor')].agregar) < 0){
                            window.cambios[(ui.item).parent().attr('supervisor')].agregar.push($(ui.item).attr('asesor'));
                        }
                    }

                    $('#btnRestaurar').removeAttr('disabled');
                    $('#btnGuardarCambios').removeAttr('disabled');
                    // console.log(window.cambios);
                    // console.log('Anterior: '+$(ui.sender).attr('supervisor'));
                    // console.log('Nuevo: '+$(ui.item).parent().attr('supervisor'));

                }
            }).disableSelection();
            $('.tooltipped').tooltip();

            Materialize.toast('Agregado', 3000, 'rounded');
            $('#modalSupervisor').modal('close');
            asignarEventoEliminarSupervisorUI();

            auxthis.removeAttr('disabled');
            auxthis.text('Agregar');
            $('#btnLimpiarSupervisores').removeAttr('disabled');

        }

    });

    window.cambios[$('#selectsupervisores').val()] = {
        eliminar: [],
        agregar: []
    }

}

function restaurarCambios(){

    $.each(window.restore, function(index, value){
        $('#sortable'+index).empty();
        $('#sortable'+index).append(value);
    });
    asignarEventoEliminarSupervisorUI();

    $.each(window.cambios, function(index, value){
        window.cambios[index].eliminar = [];
        window.cambios[index].agregar = [];
    });

    $('#btnGuardarCambios').attr('disabled', 'disabled');
    $(this).attr('disabled', 'disabled');

}

function guardar(){

    swal({
        title: "¿Está seguro de reasignar los asesores modificados?",
        text: "Al presionar el botón de Confirmar, se guardarán los cambios.",
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
            data: {
                data: JSON.stringify(window.cambios)
            },
            url: '../php/coordinadores/guardar-reasignacion-asesores.php', 
            success: function(data){

                if(data == 'true'){

                    $.each(window.cambios, function(index, value){
                        window.cambios[index].eliminar = [];
                        window.cambios[index].agregar = [];
                    });
                    swal("Completado", "Se han guardado los cambios", "success");
                    recargarRestore();

                }else{

                    Materialize.toast(data);
                    // console.log(data);

                }

            }
        });
    });

}

function recargarRestore(){

    $.each($('.collection.conected'), function(index, element){
        window.restore[$(element).attr('supervisor')] = $(element).html();
    });

    $.each(window.cambios, function(index, value){
        window.cambios[index].eliminar = [];
        window.cambios[index].agregar = [];
    });

    $('#btnRestaurar').attr('disabled', 'disabled');
    $('#btnGuardarCambios').attr('disabled', 'disabled');

}

</script>