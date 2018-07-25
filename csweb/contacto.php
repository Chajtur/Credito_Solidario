<!DOCTYPE html>

<html lang="en">

<?php require 'layout/head.php';?>

<body>

    <?php require 'layout/header.php';?>

    <div class="parallax-container custom">
        <div class="parallax"><img src="img/BANNERS-01-01.jpg"></div>
        <div class="container">
            <h3 class="white-text">CONTACTO</h3>
        </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="card">
          <div class="card-content">
            <span class="card-title blue-text">Datos de la consulta</span>
            <br />
            <div class="input-field">
                <i class="material-icons prefix indigo-text">contacts</i>
                <input id="input_identidad" type="text" maxlength="13" data-length="13" class="validate buscarcenso" placeholder="9999999999999" required>
                <label for="input_identidad" class="active">Identidad</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix indigo-text">person</i>
                <input id="nombre" type="text" class="" placeholder="Nombre de la persona" required>
                <label for="input_nombre" class="active">Nombre</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix indigo-text">call</i>
                <input id="input_telefono" type="text" maxlength="8" data-length="8" class="validate" placeholder="33333333" required>
                <label for="input_telefono" class="active">Teléfono</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix indigo-text">message</i>
                <input type="checkbox" id="input_whatsapp" />
                <label for="input_whatsapp" class="custom-top">¿Tiene Whatsapp?</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix indigo-text">email</i>
                <input id="input_email" type="email" class="validate" placeholder="correo@correo.com">
                <label for="input_email" class="active">Correo</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix indigo-text">location_on</i>
                <input id="input_direccion" maxlength="200" data-length="200" type="text" class="validate" placeholder="Direccion de la persona">
                <label for="input_direccion" class="active">Dirección</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix indigo-text">question_answer</i>
                <textarea maxlength="2048" data-length="2048" id="input_consulta" class="materialize-textarea validate" placeholder="Consulta del Cliente" required></textarea>
                <label for="input_consulta" class="active">Consulta del Cliente</label>
            </div>
            <div class="card-action right-align">
                <button type="submit" class="btn blue white-text" id="btnagregar">Enviar<i class="material-icons">send</i></button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php require 'layout/footer.php';?>

    <?php require 'layout/scripts.php';?>
    <script>
      $(document).ready(function () {
        
      });
    </script>

</body>

</html>
