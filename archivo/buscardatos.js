/**
 * Archivo para buscar los datos requeridos para asignar un hash
 * Este archivo asigna un eventlistener para el input con clase buscardatos
 * luego al llegar a determinada longitud de la identidad, manda a llamar la función buscarDatos
 */

 // Asignar evento para el elemento con clase buscardatos
 // Es necesario ejecutar esta función para que funcione la busqueda
var agregarBuscarDatosListeners = function(){

    var ciclo = $('#ciclo').val();
    $('.buscardatos').each(function(){
        $(this).off('input').on('input', function(){
            buscarDatos($(this), true, ciclo);
        });
    });

}

// Buscar los datos de asignación de hash
var buscarDatos = function(current_elem, notificaciones = true, ciclo){
    
    let longitud = current_elem.val().length;
    var nombre = current_elem.parent().parent().find('#nombre');
    var fecha = current_elem.parent().parent().find('#fecha');

    // Si la longitud de la identidad es igual a 13
    if(longitud == 13){
        
        // Si las notificaciones están activas
        if(notificaciones)
            Materialize.toast('Buscando..', 1000);
        nombre.next().addClass('active');
        nombre.val('Buscando...');

        var identidad = current_elem.val();

        $.ajax({
            type: 'POST',
            url: '../php/archivo/obtener-datos-asignacion-hash.php',
            data: {
                identidad: identidad,
                ciclo: ciclo
            },
            success: function(data){
                
                console.log(data);
                var obj = JSON.parse(data);

                // Si se encontraron datos para asignación de hash
                if(!jQuery.isEmptyObject(obj)){
                    nombre.val(obj.Nombre);
                    fecha.val(obj.Fecha_Solicitud);
                    if(notificaciones)
                    Materialize.toast(obj.nombre, 2000);
                }else{ // Si no se encuentran se notifica
                    if(notificaciones){
                        nombre.val('Nombre');
                        Materialize.toast('No se ha encontrado ese beneficiario en el ciclo '+ ciclo, 5000);
                    }
                }

            },
            error: function(data){
                if(notificaciones)
                    Materialize.toast(data, 2000);
                console.log(data);
            }
        });

    }else{ // Si la persona aun no ha ingresado 13 carácteres
        
        // inputelement.val('');
        nombre.val('Nombre');
        nombre.attr('readonly', 'readonly');

    }
    
}