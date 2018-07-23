$(document).ready(function(){
            
            /////////////////////////
        
        $('#modal-lock').modal({
            dismissible: false, // Modal can be dismissed by clicking outside of the modal
            opacity: .9, // Opacity of modal background
            inDuration: 100, // Transition in duration
            outDuration: 100,
            startingTop: '30%', // Starting top style attribute
            endingTop: '15%'
        });
        
        if(readCookie('locked')){
            $('#modal-lock').modal('open');
        }
        
        $('#floating-lock').click(function(){
            
            createCookie('locked', true, 1);
            $('#modal-lock-input-pass').val('');
            $('#modal-lock').modal('open');
            
        });
        
        $('#btn-modal-submit').click(function(){
            
            if($('#modal-lock-input-pass').val() != ""){
                
                $.ajax({
                    url: '../php/unlock.php',
                    type: 'POST',
                    data: 'data='+$('#modal-lock-input-pass').val(),
                    success: function(data){
                        
                        if(data){
                            $('#modal-lock').modal('close');
                            eraseCookie('locked');
                            Materialize.toast('Desbloqueado', 2000);
                        }else{
                            Materialize.toast('Contraseña Incorrecta', 2000);
                            //Materialize.toast($('#modal-lock-input-pass').val(), 2000);
                        }
                        
                    }
                });
                
            }else{
                
                Materialize.toast("No ingresó el password", 2000);
                
            }
            
        });
        
        /////////////////////////
            
            //Cargar la primera ventana al inicio
            
            $('#floating-refresh').click(function(){
                $('#'+window.idbtnmenuactivo).trigger('refresh');
                $('#id_visitado').val("");
                $('#id_visitado').focus();
            });
            
            $('#main-container').load('dashboard.php', function(){
                $('#loading').hide();
            });
        
        });