$(document).ready(function(){
    
    $('.collapsible').collapsible();
    
    $('.modal').modal();
    
    $('#agregar-observacion-call-center').click(function(){
                
                let newelem = $('#clon').clone();
                newelem.toggle();
                newelem.removeAttr('id');
                $('#nodopadre').append(newelem);
                asignarEventosEliminar();
                /*Materialize.toast('Agregado', 2000);*/
                
});
    
    chequiar();
    $('#btn-guardar-verificado-call-center').click(function(){
        validar();
        verificaGrupos();
    });
    
var options = {
        page: 6,
        valueNames: [ 'codigog', 'nombreg', 'gestorg', 'estadog' ],
        plugins: [
            ListFuzzySearch(), ListPagination({})
        ]
};
    window.listObj = new List('por-verificar-list', options);        
    
/*$('').click(function(){
    swal({
        title: "Esta seguro de Editar?",
        text: "Al precionar el boton de acertar, el crédito ##### será Editado!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Editar!",
        closeOnConfirm: false
    },
    function(isConfirm){
        if (isConfirm) {
                    swal({
                        title: "Guardado!",
                        text: "El crédito ha sido verificado!",
                        type: "success",
                        timer:1100
                    });
                } else {
                 swal("Cancelado", "Cancelado :)", "error");
                }
    }

  );
});*/
    
    
    /*document.addEventListener("DOMContentLoaded", function (event) {
        alert("ggkg");
        var cheques = document.getElementsByClassName('observ');
        $.each(cheques, function(index, value){
            cheques[index].addEventListener('change', function(event){
                if(cheques[index].checked){
                    alert(funciona);
                }else{
                    alert("no funca");
                }
            });
        });
        
        
    });*/
    
    
    
}); //FINALIZA DOCUMENT.READY

//ELIMINAR OBSERVACIONES INPUT QUE NO SE DESEEN    
function asignarEventosEliminar(){
    
    $('.borrar-observacion').each(function(){
        $(this).off('click').on('click', function(){
            var elmem = $(this);
            (elmem).parent().parent().remove();    
            /*function(){
                swal("Eliminado!", "El crédito ha sido eliminado del grupo!", "success");
                $(this).parent().parent().remove();
                console.log($(this).parent().parent().parent().parent());
            });*/
        });
    });
    
}

function chequiar(){
        var cheques = document.getElementsByClassName('observ');
        var count = 0;
        $(".observ").each(function(){
            $(this)[0].addEventListener('change', function(event){
                if($(this)[0].checked){
                    if(count < 1){
                        $('#ben1').removeClass('warning-observ');
                        $('#ben1').addClass('error-observ');
                    }
                    count++;
                    alert(count);
                }else{
                    alert("no funca");
                }
            });
        });
}

function verificaGrupos() {
    var error = 0;
    var warning = 0;
    var succsess = 0;

$("#tabla-verificar-call-center tr").each(function(rowIndex) {
		
    $(this).find("td").each(function(cellIndex) {
        if ($(this).children().hasClass('warning-observ')){
            warning++;
        }else if($(this).children().hasClass('error-observ')){
            error++;
        }else if($(this).children().hasClass('success-observ')){
            succsess++;
        }
        alert(warning+": warnig" + error+": errores" + succsess+": correctos");
    });
});
    if(warning > 0){
        alert(warning+"créditos no han sido verificados");
    }else if(error > 0){
        alert("hay problemas con "+error+ "créditos");
        $('#alert-icono').removeClass('warning-observ');
        $('#alert-icono').addClass('error-observ');
    }else if(succsess > 0){
        alert(succsess+ "créditos estan sin errores");
        $('#alert-icono').removeClass('warning-observ');
        $('#alert-icono').addClass('success-observ');
    }
}

function validar(){
    var cheques = document.getElementsByClassName('observ');
    var count = 0;
    $.each(cheques, function(index){
        if(cheques[index].checked){
            count++;
        }
    });
    
    if(count > 0){
        alert(count+" errores");
        $('#ben1').removeClass('warning-observ');
        $('#ben1').addClass('error-observ');
    }else{
        $('#ben1').removeClass('warning-observ');
        $('#ben1').addClass('success-observ');
    }
}