(function($){
    "use strict";
    
    $.fn.dependency_select = function(params){
        window.mainRequirements = {
            needme: {},
            ineed: {},
            status: []
        };
        window.idCurrent = $(this).attr('id');
        $(this).find('select.engaged').each(function(index){
            // Obteniendo los anteriores
            var before = [];
            for(var i = 0; i < index; i++){
                before.push($('select.engaged')[i]);
            }
            window.mainRequirements.ineed[$(this).attr('id')] = before;
            // Obteniendo los que van despues
            var after = [];
            var i = index-1;
            while(i>=0){
                after.push($('select.engaged')[i]);
                i--;
            }
            window.mainRequirements.needme[$(this).attr('id')] = after;
            window.mainRequirements.status.push({
                id: $(this).attr('id'),
                avaliable: ($(this).val()) ? true : false
            });
        });
        $(this).find('select.engaged').on('change', function(){
            var idselect = $(this).attr('id');
            $.each(window.mainRequirements.status, function(index, value){
                if(value.id == idselect) value.avaliable = true;
                var habilitado = true;
                $.each(window.mainRequirements.ineed[value.id], function(newindex, newvalue){
                    if(!window.mainRequirements.status[newindex].avaliable) habilitado = false;
                });
                $("#"+window.idCurrent).find('#'+value.id).prop('disabled', !habilitado).material_select();
            });
        });
    }
}(jQuery));