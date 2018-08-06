<?php 
    if (isset($_GET['noticiaId'])) {
        $noticiaId = $_GET['noticiaId'];
    }
?>

<!DOCTYPE html>

<html lang="en">

<?php require 'layout/head.php';?>

<body>

    <?php require 'layout/header.php';?>

    <section class="noticia-galeria">
        <div class="container">
            <div class="row">
                <input type="hidden" name="noticiaId" id="noticiaId" value="<?php echo isset($noticiaId) ? $noticiaId : ''; ?>">
                <h3 id='titulo-noticia' class="fondoPrincipal-text center"></h3>
                <hr>
                <div class="slider" id="noticia-slider">
                    <ul id="slides-noticia" class="slides"></ul>
                </div>
            </div>
        </div>
    </section>

    <section class="cuerpo-noticia">
        <div class="container">
            <div class="row">
                <div id="contenido-noticia" class="col s12">
                    
                </div>
            </div>
        </div>
    </section>

    <?php require 'layout/footer.php';?>

    <?php require 'layout/scripts.php';?>

    <script>
        $(document).ready(function () {
            let noticiaId = $('#noticiaId').val();

            obtenerNoticia(noticiaId);
            obtenerImagenesNoticia(noticiaId);
        });

        function obtenerNoticia(noticiaId) {
            let contenidoNoticia = $('#contenido-noticia');
            let tituloNoticia = $('#titulo-noticia');
            let contenidoNoticiaTxt = '';
            
            $.ajax({
                type: 'GET',
                url: '../php/mercadeo/controlador.php?accion=mostrar&noticiaId=' + noticiaId,
                success: function (data) {
                    let noticias = JSON.parse(data);
                    let noticia = noticias[0];
                    contenidoNoticiaTxt += '<p><i>'+ noticia.fecha +'</i></p>';
                    contenidoNoticiaTxt += '<p>'+ noticia.contenido +'</p>'
                    tituloNoticia.text(noticia.titulo.toUpperCase());
                    contenidoNoticia.html(contenidoNoticiaTxt);
                }
            });
        }

        function obtenerImagenesNoticia(noticiaId) {
            let slidesNoticia = $('#slides-noticia');
            let imagenesTxt = '';

            $.ajax({
                type: 'GET',
                url: '../php/mercadeo/controlador.php?accion=listar-imagenes&noticiaId=' + noticiaId,
                success: function (data) {
                    let imagenes = JSON.parse(data);
                    console.log(imagenes);
                    $.each(imagenes, function (i, imagen) {
                        imagenesTxt += '<li><img src="'+ imagen.url +'" alt="" class="responsive img"></li>';
                    });
                    
                    slidesNoticia.html(imagenesTxt);

                    if (imagenes.length > 1) {
                        $('#noticia-slider').slider({
                            indicators: true,
                            height: 400
                        });
                    } else {
                        $('#noticia-slider').slider({
                            indicators: false,
                            height: 400
                        });
                    }
                }
            });
        }
    </script>

</body>

</html>
