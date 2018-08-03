<?php require 'php/config.php';?>

<!DOCTYPE html>
<html lang="en">

<?php require 'layout/head.php';?>

<body>

    <?php require 'layout/header.php';?>

    <section class="noticia-portada">
        <div class="slider" id="noticia-destacada">
            <ul class="slides">
                <li>
                    <img src="img/noticiaPortada.jpg" alt="" class="responsive-img">
                </li>
            </ul>
        </div>
    </section>

    <section class="noticias-anio">
        <h3 class="fondoPrincipal-text">Noticias anuales</h3>
        <div class="row">
            <form id="formNoticia" class="col s12">
                <div class="row">
                    <div class="input-field col s6"></div>
                    <div class="input-field inline col s6">
                        <select name="anio" id="anio">
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
                        </select>
                        <label for="anio">Año</label>
                    </div>
                </div>
            </form>
        </div>
        <div id="noticias-carousel" class="owl-carousel owl-theme"></div>        
    </section>

    <?php require 'layout/footer.php';?>

    <?php require 'layout/scripts.php';?>

    <script>
        $(document).ready(function () {
            //obtenerNoticias();

            $('#noticia-destacada').slider({
                indicators: false,
                height: 400
            });

            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                responsiveClass: true,
                autoplay: true,
                autoplayTimeout: 3000,
                nav: false,
                navText: '',
                responsive: {
                    0: {
                        items: 2,
                        nav: true
                    },
                    600: {
                        items: 3,
                        nav: false
                    },
                    1000: {
                        items: 3,
                        nav: false,
                        loop: false
                    }
                }
            });

            $('select').material_select();

            obtenerNoticias();
        });

        function obtenerNoticias() {
            let carouselNoticias = $('#noticias-carousel');
            carouselNoticias.text('');

            $.ajax({
                type: 'GET',
                url: '../php/mercadeo/controlador.php?accion=listar',
                success: function (data) {
                    //console.log(data);
                    let noticias = JSON.parse(data);
                    $.each(noticias, function (i, noticia) {
                        let noticiasTxt = '';
                        noticiasTxt += '<div class="item">';
                        noticiasTxt += '<div class="card">';
                        noticiasTxt += '<div class="card-image">';
                        noticiasTxt += '<img src="img/noticiaPortada.jpg" alt="" class="responsive-img">';
                        noticiasTxt += '<span class="card-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet eros metus.</span>';
                        noticiasTxt += '</div>';
                        noticiasTxt += '<div class="card-content">';
                        noticiasTxt += '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ultricies massa ligula, vitae venenatis massa imperdiet aliquam. Integer finibus nullam.</p>';
                        noticiasTxt += '</div>';
                        noticiasTxt += '<div class="card-action">';
                        noticiasTxt += '<span class="noticia-fecha grey lighten-3 black-text tiny">27 julio 2018</span>';
                        noticiasTxt += '<a href="noticia.php" class="right"><i class="material-icons grey-text text-darken-2 small">add</i></a>';
                        noticiasTxt += '</div>';
                        noticiasTxt += '</div>';
                        noticiasTxt += '</div>';

                        //console.log(noticiasTxt);

                       //$('.owl-carousel').owlCarousel('add', noticiasTxt).owlCarousel('update');
                       console.log($('.owl-carousel'));
                       $('.owl-carousel').trigger('add.owl.carousel', [$('<div>bar</div>'), 0]).trigger('refresh.owl.carousel');
                    });

                    //carouselNoticias.html(noticiasTxt);
                }
            });
        }
    </script>
    

</body>

</html>