$(document).ready(function() {
    
    $('#loginform').on('submit', function(e){
        e.preventDefault();
    });
    
    $('#btnlogin').on('click', function () {
        
        $(this).attr('disabled', 'disabled');
        
        var data = {
            user: $("#txtusuario").val(),
            pass: $("#txtpass").val()
        };
        
        if((data.user == "") || (data.pass == "")){
            
            Materialize.toast("Por favor rellene todos los campos.", 2000);
            $('#btnlogin').removeAttr("disabled");
            
        }else{
            
            $.ajax({
                type: 'POST',
                url: '../php/login-maestro.php',
                data: data,
                cache: false,
                success: function(data){
                    console.log(data);
                    if(data != "2002"){
                        $('#btnlogin').removeAttr("disabled");
                        if(data == "true"){
                            Materialize.toast("Por favor espere...", 2000);
                            window.location.replace('php/redirect.php');
                        }else{
                            Materialize.toast(data, 2000);
                        }
                    }else{
                        $('#btnlogin').removeAttr("disabled");
                        Materialize.toast('Error de conexión, intentelo más tarde.', 3000);
                    }
                    
                },
                error: function(data){
                    Materialize.toast(data, 5000);
                }
            });
            
        }
    });

});