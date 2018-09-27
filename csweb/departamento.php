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
                <ul id="slide-imagenes" class="slides">
                    
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
                    
                </div>
            </div>
        </section>

        <?php require 'layout/footer.php';?>
        <?php require 'layout/scripts.php';?>
        <script>
            $(document).ready(function () {
                let departamentoId = $('#departamentoId').val();
                obtenerDepartamento(departamentoId);
                obtenerAgencias(departamentoId);
            });

            function obtenerDepartamento(departamentoId) {
                let tituloDepartamento = $('#titulo-agencia');
                let slideImagen = $('#slide-imagenes');
                let imagenesTxt = '';
                let counter = 0;

                $.ajax({
                    type: 'GET',
                    url: '../php/mantenimientos/departamentos.php?accion=mostrar&departamentoId=' + departamentoId,
                    success: function (data) {
                        let departamentos = JSON.parse(data);                        
                        let departamento = departamentos[0];

                        tituloDepartamento.text(departamento.nombre.toUpperCase());
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: '../php/mercadeo/departamentoImagen.php?accion=listar&departamentoId=' + departamentoId,
                    success: function (data) {
                        let imagenes = JSON.parse(data);
                        console.log(imagenes);

                        $.each(imagenes, function(i, imagen) {
                            imagenesTxt += '<li><img src="'+ imagen.url +'" alt="" class="responsive-img"></li>';
                            counter++;
                        });

                        slideImagen.html(imagenesTxt);

                        if (counter > 1) {
                            $('.slider').slider({
                                indicators: true,
                                height: 500
                            });
                        } else {
                            $('.slider').slider({
                                indicators: false,
                                height: 500
                            });
                        }
                    }
                });
            }

            function obtenerAgencias(departamentoId) {
                let agenciasTabs = $('#tabs-agencias');
                let agenciasTxt = '';
                let informacionAgenciaTxt = '';
                let even = true;
                let contenidoAgencia = $('#contenido-agencia');
                let mapa = $('#map');

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
                            informacionAgenciaTxt += '</div>';

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

            
        </script>

    </body>

</html>