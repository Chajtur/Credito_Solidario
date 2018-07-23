$(document).ready(init);

function init(){

    // Inicializar pluggins
    agregarBuscarCensoListeners(); // buscar censo plugin
    $("#selectpersonal").select2();
    $("#commentForm").validate();

    // Materialize
    $('.modal').modal({
        dismissible: false
    });
    $('.tooltipped').tooltip({delay: 50});

    // Select2
    $('#direccion_negocio').select2();
    $('.select2-with-icon-prefix').next().find('.select2-selection.select2-selection--single').first().css('width', 'calc(100% - 42px)');
    $('.select2-with-icon-prefix').next().find('.select2-selection__arrow').first().css('right', '42px');
    $('.select2-with-icon-prefix').next().css('margin-left','42px');
    $('.select2-with-icon-prefix').next().css('margin-right','-42px');

    // Eventos
    $('#btncontinuar').click(validarcampousuario);
    $('#eliminarusuario').click(eliminarVariableUser);
    $('#formguardardatos').submit(guardarDatos);
    $('#btnlimpiar').click(limpiarCampos);

}

function guardarDatos(e){

    e.preventDefault();

    if($('#actividad_economica').val() == ''){
        Materialize.toast('No ha seleccionado la actividad económica');
        return false;
    }

    $.ajax({
        type: 'POST',
        url: 'guardar_informacion.php',
        data: {
            identidad: $('#identidad').val(),
            nombre: $('#nombre').val(),
            telefono: $('#telefono').val(),
            actividad_economica: $('#actividad_economica').val(),
            nombre_negocio: $('#nombre_negocio').val(),
            direccion_negocio: $('#direccion_negocio').val(),
            es_beneficiario: ($('input[name=beneficiariocsgroup]:checked').val() == 'on' ? '1' : '0'),
            optar_credito: ($('input[name=optarcreditogroup]:checked').val() == 'on' ? '1' : '0'),
            porque_optar_credito: $('#credito_por_que').val(),
            interesado_capacitacion: ($('input[name=interesadogroup]:checked').val() == 'on' ? '1' : '0'),
            tema_capacitacion: $('#tema_capacitacion').val()
        },
        success: function(data){
            console.log(data);
            limpiarCampos();
            Materialize.toast('Completo', 1000);
        }
    });

}

function validarcampousuario(){

    if($('#selectpersonal').val() == '' || $('#selectpersonal').val() == null){
        Materialize.toast('No ha seleccionado su nombre', 1000);
        return false;
    }

    guardarUsuario();

}

function limpiarCampos(){
    $('#formguardardatos')[0].reset();
}

function guardarUsuario(){

    $.ajax({
        type: 'POST',
        url: 'guardar_usuario.php',
        data: {
            user: $('#selectpersonal').val(),
            name: $('#selectpersonal option:selected').text()
        },
        success: function(data){
            window.location.reload();
        }
    });

}

function eliminarVariableUser(){
    $.ajax({
        url: 'eliminar_variable_usuario.php',
        success: function(data){
            window.location.reload();
        }
    });
}