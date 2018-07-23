// Archivo utilizado por el área de reportes
// Creado por Rychiv4

$(document).ready(function() {
    
    //Material pickadate
    var desdedata = {
        selectMonths: true,
        selectYears: 5,
        closeOnSelect: true,
        format: 'yyyy-mm-dd'
    }

    var hastadata = {
        selectMonths: true,
        selectYears: 5,
        closeOnSelect: true,
        format: 'yyyy-mm-dd'
    }
    
    $("#date_desde").pickadate(desdedata);
    $("#date_hasta").pickadate(hastadata);
    
    //Material pickadate
    var desdedatarec = {
        selectMonths: true,
        selectYears: 5,
        closeOnSelect: true,
        format: 'yyyy-mm-dd'
    }

    var hastadatarec = {
        selectMonths: true,
        selectYears: 5,
        closeOnSelect: true,
        format: 'yyyy-mm-dd'
    }
    $("#date_desde_rec").pickadate(desdedatarec);
    $("#date_hasta_rec").pickadate(hastadatarec);

    $("select[required]").css({
        display: "inline",
        height: 0,
        padding: 0,
        width: 0
    });
    
    $("#select-all").on('change', function(){
        
        let checked = false;
        let text = 'Seleccione las Agencias...';
        
        if($("#select-all").is(":checked")){
            checked = true;
            text = 'Todas las agencias';
        }
        
        let options_div = $("#options");
        
        options_div.find("input[type=checkbox]").prop('checked', checked);
        options_div.find("input[type=checkbox]").addClass('active selected');
        options_div.find("li").first().find("span").text(text);
        options_div.find("input[type=text]").val(text);
        
        //alert('cambio');
        /*
        $('select').material_select('destroy');
        $('select').material_select();*/
        
    });
    
});
