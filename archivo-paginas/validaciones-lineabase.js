$(function () {
    $.validator.setDefaults({
       ignore: []
    });
    //Start Validation para Formulario de pestaña Linea Base
    $("#form_lineabase").validate({
        rules: {
            soloParaVivienda: "required",
            tiempo_residir: {
                required: true,
                minlength: 1
            },
            
            cuantos_habitan: {
                required: true,
                minlength: 1
            },
            cuantos_viven: {
                required: true,
                minlength: 1,
                maxlength: 2
            },
            cuantos_trabajan: {
                required: true,
                minlength: 1
            },
            cuantos_Bempleos: {
                required: true,
                minlength: 1
            },
            tieneMicroEmp: "required",
            tendraMicoEmp: "required"
        },
        //For custom messages
        messages: {
            soloParaVivienda: {
                required: "Este Campo es requerido"
            },
            solo_para_vivienda_si: {
                required: "Este Campo es requerido"
            },
            solo_para_vivienda_no: {
                required: "Este Campo es requerido"
            },
            tiempo_residir: {
                required: "Este Campo es requerido",
                minlength: "Dígite más de 3 caracteres"
            },
            
            cuantos_habitan: {
                required: "Este Campo es requerido",
                minlength: "Dígite más de 2 caracteres"
            },
            cuantos_viven: {
                required: "Este Campo es requerido",
                minlength: "Dígite más de 2 caracteres"
            },
            cuantos_trabajan: {
                required: "Este Campo es requerido",
                minlength: "Dígite más de 2 caracteres"
            },
            cuantos_Bempleos: {
                required: "Este Campo es requerido",
                minlength: "Dígite más de 2 caracteres"
            },
            tieneMicroEmp: {
                required: "Este Campo es requerido"
            },
            tendraMicoEmp: {
                required: "Este Campo es requerido"
            }
        },
        errorElement : 'div',
        errorPlacement: function (error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error);
          } else {
            error.insertAfter(element);
          }
        }
    });
    //End Validation para Formulario de pestaña  Linea Base
    //Start Formatter para Formulario de pestaña  Linea Base
    $('#tiempo_residir').formatter({
          'pattern': '{{999}}'
        });
        $('#cuantos_habitan').formatter({
          'pattern': '{{99}}'
        });
        $('#cuantos_viven').formatter({
          'pattern': '{{99}}'
        });
        $('#cuantos_trabajan').formatter({
          'pattern': '{{99}}'
        });
        $('#cuantos_Bempleos').formatter({
          'pattern': '{{99}}'
        });
        $('#id_id_id').formatter({
          'pattern': '{{aaaaaaaaaaaaaaaaaaaa}}'
        });
        $('#id_id_id').formatter({
          'pattern': '{{aaaaaaaaaaaaaaaaaaaa}}'
        });
        $('#id_id_id').formatter({
          'pattern': '{{aaaaaaaaaaaaaaaaaaaa}}'
        });
    //End Formatter para Formulario de pestaña  Linea Base
});