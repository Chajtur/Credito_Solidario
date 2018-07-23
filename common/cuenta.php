<?PHP 
session_start();
?>
<div class="section">
    <div class="row">
        <div class="col s12 m12 l8 offset-l2">
            <div id="profile-card" class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="" src="../images/2b-cut.jpg" alt="user background">
                </div>
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 m12 l6">
                            <img src="../images/<?php echo ($_SESSION['gender'] == 'F' ? "user-girl" : "user");?>.png" alt="" class="circle responsive-img card-profile-image z-depth-2">
                        </div>
                        <div class="col s12 m12 l6 offset-l6 hide-on-med-and-down">
                            <!-- <a id="redsocial_2" href="" class="btn-floating btn-move-up waves-effect waves-light indigo right modal-trigger">
                                <i class="material-icons">home</i>
                            </a> -->
                            <a id="redsocial_1" href="#modal-contraseña" class="btn-floating btn-move-up waves-effect waves-light blue right modal-trigger tooltipped activator" data-position="top" data-delay="20" data-tooltip="Cambiar contraseña">
                                <i class="material-icons">lock</i>
                            </a>
                            <a id="btn_mail" href="http://mail.creditosolidario.hn" target="_blank" class="btn-floating btn-move-up waves-effect waves-light amber right modal-trigger tooltipped" data-position="top" data-delay="20" data-tooltip="Correo">
                                <i class="material-icons">mail</i>
                            </a>
                            <a id="btn_agencias" href="#!" class="btn-floating activator btn-move-up waves-effect waves-light green right modal-trigger tooltipped" data-position="top" data-delay="20" data-tooltip="Agencias Asignadas">
                                <i class="material-icons">account_balance</i>
                            </a>
                            <!-- <a id="btn_contraseña" href="page-olvido-password.html" class="btn-floating btn-move-up waves-effect waves-light teal right modal-trigger">
                                <i class="material-icons">home</i>
                            </a> -->
                            <!-- <div class="file-field  btn-move-up right">
                                <div id="btn_foto" class="btn-floating waves-effect waves-light red">
                                    <i class="material-icons">vpn_key</i>
                                    <input type="file">
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <a href="#!" class=""> <span class="card-title"><?php echo $_SESSION['first_name']." ".$_SESSION['last_name'];?></span> </a>
                    <p><i class="mdi-action-perm-identity cyan-text text-darken-2"></i><?php echo $_SESSION['designation_name'];?></p>
                    <p><i class="mdi-action-perm-phone-msg cyan-text text-darken-2"></i><?php echo $_SESSION['department_name'];?></p>
                    <p><i class="mdi-communication-email cyan-text text-darken-2"></i><?php echo $_SESSION['email'];?></p>
                    <p id="id_user" hidden=""><i class="mdi-communication-email cyan-text text-darken-2"></i><?php echo $_SESSION['user'];?></p>
                </div>
                
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Agencias Asignadas<i class="material-icons right">close</i></span>
                    <ul class="">
                    <?php foreach($_SESSION['agencia'] as $agencia):?>
                        <li class=""><?php echo $agencia;?></li>
                    <?php endforeach;?>
                    </ul>
                </div>

                <div id="modal-contraseña" class="modal modal-max-width">
                    <div class="modal-content">
                        <h5 class="light blue-text">Cambiar Contraseña</h5>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input type="password" id="contraseña-actual">
                                <label for="contraseña-actual">Contraseña actual</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input type="password" id="contraseña-nueva"  class="validate">
                                <label for="contraseña-nueva">Nueva contraseña</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input type="password" id="contraseña-confirmar" class="validate">
                                <label for="contraseña-confirmar" data-error="Las contraseñas no coinciden" data-success="Correcto">Confirmar contraseña</label>
                            </div>
                        </div>                    
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <br><button id="cambiar-contraseña" class="btn waves-effect waves-light btn-flat" style="color:white">Cambiar</button>
                                <!-- <a href="#!" title="Cambiar contraseña">Cambiar contraseña</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $('.tooltipped').tooltip({delay: 20});
        $('.modal').modal();

        //<=================================== Confirmar contraseña  =======================================>

        //variables
        var pass1 = $('#contraseña-nueva');
        var pass2 = $('#contraseña-confirmar');
        var pass3 = $('#contraseña-actual');

        //función que comprueba las dos contraseñas
        function coincidePassword(){
            var valor1 = pass1.val();
            var valor2 = pass2.val();

            //condiciones dentro de la función
            if(valor1.length!=0 && valor2.length!=0 && valor1==valor2){
                pass2.addClass('valid');
            }
            if(valor1.length!=0 && valor2.length!=0 && valor1!=valor2){
                pass2.addClass('invalid');
            }            
        }

        //ejecuto la función al soltar la tecla
        pass2.blur(function(){
            coincidePassword();
        });    


        //===================================== BOTON GUARDAR ==============================================>

        $('#cambiar-contraseña').click(function(event) {
            if (pass1.val().length==0 || pass2.val().length==0 || pass3.val().length==0) {
                Materialize.toast('Llene todos los campos', 2000);
            }else {
                if(pass1.val()!=pass2.val()){
                    Materialize.toast('La contraseña nueva no coincide', 2000);
                }else {
                    // console.log('Correcto');
                    var obj = {
                        contraseña_actual: pass3.val(),
                        contraseña_nueva: pass1.val(),
                        id_user: $('#id_user').text(),
                    };   
                    var json = JSON.stringify(obj);
                    // console.log(obj);
                    $.ajax({
                        url: '../php/cuenta/cambiar-contrasena.php',
                        type: 'POST',
                        data: 'data='+json,
                    })
                    .done(function(data) {
                        // data2 = $.parseJSON(data);
                        // console.log(data);
                        if (data == '0') {
                            Materialize.toast('La contraseña actual no coincide', 5000);
                            $('#contraseña-actual').focus();
                        }
                        if (data == '1'){
                            Materialize.toast('Contraseña Guardada', 2000);
                            $('#modal-contraseña').modal('close');
                        }
                        if (data == '2'){
                            Materialize.toast('No se pudo guardar la contraseña', 2000);
                        }                        
                        // console.log('SUCCES');
                    })
                    .fail(function() {
                        console.log("error");
                    });        
                }                
            }       
        });
    });
</script>