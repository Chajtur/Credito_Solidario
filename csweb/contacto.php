<!DOCTYPE html>

<html lang="en">

<?php require 'layout/head.php';?>

<body>
<style>

.custom-top {
    top: 0.15rem !important;
}

</style>

    <?php require 'layout/header.php';?>

    <div class="parallax-container custom">
        <div class="parallax"><img src="img/BANNERS-01-01.jpg"></div>
        <div class="container">
            <h3 class="white-text">CONTACTO</h3>
        </div>
    </div>

    <div class="container">
      <div class="row">
        <form id="form_guardar_visita">
            <div class="card">
                <div class="card-content">
                    <span class="card-title blue-text">Datos de la consulta</span>
                    <br />
                    <div class="input-field">
                        <i class="material-icons prefix indigo-text">contacts</i>
                        <input id="input_identidad" type="text" maxlength="13" data-length="13" class="validate buscarcenso" placeholder="9999999999999" required>
                        <label for="input_identidad" class="active">Identidad</label>
                    </div>
                    <div class="input-field ">
                        <i class="material-icons prefix indigo-text">person</i>
                        <input id="nombre" type="text" class="" placeholder="Nombre de la persona" required>
                        <label for="input_nombre" class="active">Nombre</label>
                    </div>
                    <div class="input-field ">
                        <i class="material-icons prefix indigo-text">call</i>
                        <input id="input_telefono" type="text" maxlength="8" data-length="8" class="validate" placeholder="33333333" required>
                        <label for="input_telefono" class="active">Teléfono</label>
                    </div>
                    <div class="input-field ">
                        <i class="material-icons prefix indigo-text">message</i>
                        <input type="checkbox" id="input_whatsapp" />
                        <label for="input_whatsapp" class="custom-top">¿Tiene Whatsapp?</label>
                    </div>
                    <div class="input-field ">
                        <i class="material-icons prefix indigo-text">email</i>
                        <input id="input_email" type="email" class="validate" placeholder="correo@correo.com">
                        <label for="input_email" class="active">Correo</label>
                    </div>
                    <div class="input-field ">
                        <i class="material-icons prefix indigo-text">location_on</i>
                        <input id="input_direccion" maxlength="200" data-length="200" type="text" class="validate" placeholder="Direccion de la persona">
                        <label for="input_direccion" class="active">Dirección</label>
                    </div>
                    <div class="input-field ">
                        <i class="material-icons prefix indigo-text">question_answer</i>
                        <textarea maxlength="2048" data-length="2048" id="input_consulta" class="materialize-textarea validate" placeholder="Consulta del Cliente" required></textarea>
                        <label for="input_consulta" class="active">Consulta del Cliente</label>
                    </div>         
                </div>
                <div class="card-action right-align col s12">
                    <button type="submit" class="waves-effect waves-light btn blue" id="btnagregar">Enviar<i class="material-icons right">send</i></button>
                </div>
            </div>
        </form>
      </div>
    </div>

    <?php require 'layout/footer.php';?>

    <?php require 'layout/scripts.php';?>
    <script>
      $(document).ready(function () {
        $('#form_guardar_visita').submit(guardar_visita);

        function guardar_visita(e){
        
            $('#btnagregar').attr('disabled', 'disabled');
            e.preventDefault();
            // console.log($('#input_whatsapp'));
            var obj = {
                identidad: $('#input_identidad').val(),
                nombre: $('#nombre').val(),
                telefono: $('#input_telefono').val(),
                whatsapp: ($('#input_whatsapp').prop('checked') ? '1' : '0'),
                correo: $('#input_email').val(),
                direccion: $('#input_direccion').val(),
                consulta: $('#input_consulta').val(),
                solucion: $('#input_solucion').val(),
                responsable: $('#select_responsable').val(),
                usuario: ''
            }
            
            $.ajax({
                type: 'POST',
                url: '../php/cda/guardar-visita-web.php',
                data: obj,
                success: function(data){
                    if(data == 'true'){
                        swal('Correcto','Se ha registrado la visita correctamente', 'success');
                        $('#input_identidad').val('');
                        $('#nombre').val('');
                        $('#input_telefono').val('');
                        $('#input_whatsapp').prop('checked', false);
                        $('#input_email').val('');
                        $('#input_direccion').val('');
                        $('#input_consulta').val('');
                        $('#input_solucion').val('');
                        $('#select_responsable').val('');
                    }else{
                        swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                    }
                    $('#btnagregar').removeAttr('disabled');
                }
            });

        }
      });
    </script>

</body>

</html>
