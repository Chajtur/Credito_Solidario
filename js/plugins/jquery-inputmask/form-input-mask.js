$(document).ready(function() {
    
   $('.masked').inputmask();
    
    $("#tel_fijo").inputmask({
            
            oncomplete: function() {
                // do something
                if($('#tel_fijo').hasClass('invalid')){
                    $('#tel_fijo').removeClass('invalid');
                }
            },
            onincomplete: function() {
                // do something
                $('#tel_fijo').addClass('invalid');
            }
    });
    $("#tel_celular").inputmask({
            
            oncomplete: function() {
                // do something
                if($('#tel_celular').hasClass('invalid')){
                    $('#tel_celular').removeClass('invalid');
                }
            },
            onincomplete: function() {
                // do something
                $('#tel_celular').addClass('invalid');
            }
    });
    
     /*$('label').addClass('acitve');*/
});