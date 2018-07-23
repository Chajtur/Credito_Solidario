var agregarBuscarCensoListeners = function(){
    
        $('.buscarcenso').each(function(){
            $(this).off('input').on('input', function(){
                buscarCenso($(this), true);
            });
        });
    
    }
    
    var buscarCenso = function(current_elem, notificaciones = true){
        
        let longitud = current_elem.val().length;
        var currelem = current_elem.parent().next().find('#nombre');
        var genero = current_elem.parent().parent().find('#genero');
        var inputelement = current_elem.parent().next().next().find('#ciclo-sugerido');
    
        if(longitud == 13){
            
            if(notificaciones)
                Materialize.toast('Buscando..', 1000);
            currelem.next().addClass('active');
            currelem.val('Buscando...');
    
            var identidad = current_elem.val();
    
            $.ajax({
                type: 'POST',
                url: '../php/credito/buscarcenso.php',
                data: "id="+identidad,
                success: function(data){
                    
                    if(data == "No esta en el censo"){
    
                        currelem.removeAttr('readonly');
                        currelem.val('');
                        if(notificaciones)
                            Materialize.toast('No esta en el censo', 2000);
                        
                    }else{
    
                        var obj = JSON.parse(data);
                        currelem.val(obj.nombre);
                        genero.val(obj.genero);
                        genero.material_select();
    
                        if(notificaciones)
                            Materialize.toast(obj.nombre, 2000);
    
                    }
                    
                    verificarCiclo(identidad, inputelement);
    
                },
                error: function(data){
                    if(notificaciones)
                        Materialize.toast(data, 2000);
                    console.log(data);
                }
            });
    
        }else{
            
            inputelement.val('');
            currelem.val('Nombre');
            currelem.attr('readonly', 'readonly');
    
        }
        
    }
    
    var verificarCiclo = function(id, inputelem){
            
        $.ajax({
            type: 'POST',
            data: 'id='+id,
            url: '../php/credito/verificarciclo.php',
            success: function(data){
    
                inputelem.val(data);
                inputelem.addClass('buscarciclo');
                inputelem.next().addClass('active');
    
            }
        });
    
    }