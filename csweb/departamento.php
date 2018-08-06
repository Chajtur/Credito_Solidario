<?php
    if ($_GET['departamentoId']) {
        $departamentoId = $_GET['departamentoId'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<?php
    require 'php/config.php';
    require 'layout/head.php';
?>

    <body>
        <?php require 'layout/header.php';?>
        
        <section class="foto-agencia">
            <div class="slider">
                <ul class="slides">
                    <li>
                        <img src="img/agencia.jpg" alt="" class="responsive-img">
                    </li>
                </ul>
            </div>
        </section>

        <section class="informacion-agencia">
            <div class="container">
                <div class="row">
                    <input type="hidden" name="departamentoId" id="departamentoId" value="<?php echo isset($departamentoId) ? $departamentoId : '' ?>">
                    <div class="col s12">
                        <h4 id="titulo-agencia" class="grey-text text-darken-1"></h4>
                    </div>
                    <ul id="tabs-agencias" class="tabs">
                        
                    </ul>
                    <div id="contenido-agencia"></div>
                    <!-- 
<div class="col s12 grey lighten-4 center grey-text text-darken-1" id="agencia-1">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum posuere nisi eu augue ultrices viverra ac sagittis mauris. Donec accumsan.</p>
                        <p><i class="material-icons">phone</i>Teléfono: 2220-1471</p>
                    </div>
                    <div class="col s12 center grey-text text-darken-1" id="agencia-2">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum posuere nisi eu augue ultrices viverra ac sagittis mauris. Donec accumsan.</p>
                        <p><i class="material-icons left-align">phone</i>Teléfono: 2220-1471</p>
                    </div>
                     -->
                    
                </div>
            </div>
        </section>

        <?php require 'layout/footer.php';?>
        <?php require 'layout/scripts.php';?>
        <script>
            $(document).ready(function () {
                $('.slider').slider({
                    indicators: false,
                    height: 500
                });
                let departamentoId = $('#departamentoId').val();
                obtenerDepartamento(departamentoId);
                obtenerAgencias(departamentoId);
            });

            function obtenerDepartamento(departamentoId) {
                let tituloDepartamento = $('#titulo-agencia');

                $.ajax({
                    type: 'GET',
                    url: '../php/mantenimientos/departamentos.php?accion=mostrar&departamentoId=' + departamentoId,
                    success: function (data) {
                        let departamentos = JSON.parse(data);                        
                        let departamento = departamentos[0];
                        console.log(departamento);

                        tituloDepartamento.text(departamento.nombre.toUpperCase());
                    }
                });
            }

            function obtenerAgencias(departamentoId) {
                let agenciasTabs = $('#tabs-agencias');
                let agenciasTxt = '';
                let informacionAgenciaTxt = '';
                let even = true;
                let contenidoAgencia = $('#contenido-agencia');

                $.ajax({
                    type: 'GET',
                    url: '../php/mantenimientos/agencias.php?accion=listar&departamentoId='+ departamentoId,
                    success: function (data) {
                        let agencias = JSON.parse(data);
                        $.each(agencias, function (i, agencia) {
                            agenciasTxt += '<li class="tab"><a href="#agencia-'+ agencia.idAgencia +'">'+ agencia.nombre +'</a></li>';
                            
                            if (even) {
                                informacionAgenciaTxt += '<div class="col s12 center grey-text text-darken-1" id="agencia-'+ agencia.idAgencia +'">';
                            } else {
                                informacionAgenciaTxt += '<div class="col s12 grey lighten-4 center grey-text text-darken-1" id="agencia-'+ agencia.idAgencia +'">';
                            }
                            informacionAgenciaTxt += '<p>'+ agencia.direccion +'</p>';
                            informacionAgenciaTxt += '<p><i class="material-icons">phone</i>'+ agencia.telefono +'</p>';
                            informacionAgenciaTxt += '<div id="map"></div>';
                            informacionAgenciaTxt += '</div>';

                            let posicionAgencia = {
                                lat: parseFloat(agencia.latitud),
                                lng: parseFloat(agencia.longitud)
                            };

                            initMap(posicionAgencia);

                            even = !even;
                        });
                        contenidoAgencia.html(informacionAgenciaTxt);
                        agenciasTabs.html(agenciasTxt);
                        agenciasTabs.tabs({
                            swipeable: true
                        });
                    }
                });
            }

            // Initialize and add the map
            function initMap(posicionAgencia) {
                console.log(posicionAgencia);
                // The location of Uluru
                var uluru = {lat: -25.344, lng: 131.036};
                // The map, centered at Uluru
                var map = new google.maps.Map(
                    document.getElementById('map'), {zoom: 4, center: uluru});
                // The marker, positioned at Uluru
                var marker = new google.maps.Marker({position: uluru, map: map});
            }
        </script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcNsMB5091ztV6GeSmJaUrt93D9aiNRLI&callback=initMap">
        </script>

    </body>

</html>