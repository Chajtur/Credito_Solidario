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

    var obj = {
        nombre: $('#nombre').val(),
        identidad: $('#inputidentidad').val(),
        telefono: $('#inputtelefono').val(),
        genero: $('#genero').val(),
        es_beneficiario: $('input[name=groupRespuestaPregunta1]:checked').val(),
        merece_continuar: $('input[name=groupRespuestaPregunta2]:checked').val(),
        calificacion_programa: $('input[name=groupRespuestaPregunta3]:checked').val(),
        problema_poco_dinero: ($('#inputproblema_poco_dinero').is(':checked') ? '1' : '0'),
        problema_zona_poca_clientela: ($('#inputproblema_zona_poca_clientela').is(':checked') ? '1' : '0'),
        problema_mantener_finanzas: ($('#inputproblema_mantener_finanzas').is(':checked') ? '1' : '0'),
        problema_llevar_contabilidad: ($('#inputproblema_llevar_contabilidad').is(':checked') ? '1' : '0'),
        problema_inseguridad: ($('#inputproblema_inseguridad').is(':checked') ? '1' : '0'),
        problema_necesita_entrenarse_clientela: ($('#inputproblema_necesita_entrenarse_clientela').is(':checked') ? '1' : '0'),
        problema_desconoce_tecnicas_negocio: ($('#inputproblema_desconoce_tecnicas_negocio').is(':checked') ? '1' : '0'),
        problema_entrenamiento_basico_pc: ($('#inputproblema_entrenamiento_basico_pc').is(':checked') ? '1' : '0'),
        problema_necesita_capacitaciones: ($('#inputproblema_necesita_capacitaciones').is(':checked') ? '1' : '0'),
        ayuda_adicional_brindar: $('#inputayuda_adicional_brindar').val(),
        se_compromete_ayudar_programa: $('input[name=groupRespuestaPregunta4]:checked').val()
    }

    console.log(obj);

    $.ajax({
        type: 'POST',
        url: 'guardar_informacion.php',
        data: obj,
        success: function(data){
            console.log(data);
            limpiarCampos();
            Materialize.toast('¡Guardado satisfactoriamente!', 3000);
            limpiarCampos();
        }
    });

}

function limpiarCampos(){
    $('#formguardardatos')[0].reset();
    $('select').material_select();
}


function eliminarVariableUser(){
    $.ajax({
        url: 'eliminar_variable_usuario.php',
        success: function(data){
            window.location.reload();
        }
    });
}