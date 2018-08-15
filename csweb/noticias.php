<?php require 'php/config.php';?>

<!DOCTYPE html>
<html lang="en">

<?php require 'layout/head.php';?>

<body>

    <?php require 'layout/header.php';?>

    <section class="noticia-portada">
        <div class="slider" id="noticia-destacada">
            <ul id="noticias-portada" class="slides">
                
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
            obtenerNoticias();

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
            $('#anio').on('change', function (evt) {
                let optionSelected = $('option:selected', this);
                let valueSelected = this.value;

                obtenerNoticias(valueSelected);
            });

            obtenerNoticiasPortada();
        });

        function obtenerNoticiasPortada() {
            let noticiasPortada = $('#noticias-portada');
            let noticiasTxt = '';
            let date = new Date();

            $.ajax({
                type: 'GET',
                url: '../php/mercadeo/controlador.php?accion=listar-pagina&tipo=2&anio='+date.getFullYear(),
                success: function (data) {
                    let noticias = JSON.parse(data);
                    
                    $.each(noticias, function (i, noticia) {
                        noticiasTxt += '<li><img src="'+ noticia.url +'" class="responsive-img"></li>';
                    });

                    noticiasPortada.html(noticiasTxt);

                    if (noticias.length > 1) {
                        $('#noticia-destacada').slider({
                            indicators: true,
                            height: 400
                        });
                    } else {
                        $('#noticia-destacada').slider({
                            indicators: false,
                            height: 400
                        });
                    }                    
                }
            });
        }

        function obtenerNoticias(anio) {
            let carouselNoticias = $('#noticias-carousel');
            let date = new Date();
            let anioElegido = date.getFullYear();
            let noticiasTxt = '';

            if (anio) {
                anioElegido = anio;
            }

            $.ajax({
                type: 'GET',
                url: '../php/mercadeo/controlador.php?accion=listar-pagina&tipo=1&anio='+anioElegido,
                success: function (data) {
                    let noticias = JSON.parse(data);
                    $.each(noticias, function (i, noticia) {
                        let fechaUsr = new Date(noticia.fecha);

                        noticiasTxt += '<div class="item">';
                        noticiasTxt += '<div class="card small">';
                        noticiasTxt += '<div class="card-image">';
                        noticiasTxt += '<img src="'+ noticia.url +'" alt="" class="responsive-img">';
                        noticiasTxt += '<span class="card-title">'+ noticia.titulo +'</span>';
                        noticiasTxt += '</div>';
                        noticiasTxt += '<div class="card-content">';
                        noticiasTxt += '<p>'+ noticia.resumen +'</p>';
                        noticiasTxt += '</div>';
                        noticiasTxt += '<div class="card-action">';
                        noticiasTxt += '<span class="noticia-fecha grey lighten-3 black-text tiny">'+ fechaUsr.getDate() + '/' + fechaUsr.getMonth() + '/' + fechaUsr.getFullYear() +'</span>';
                        noticiasTxt += '<a href="noticia.php?noticiaId='+ noticia.noticiaId +'" class="right"><i class="material-icons grey-text text-darken-2 small">add</i></a>';
                        noticiasTxt += '</div>';
                        noticiasTxt += '</div>';
                        noticiasTxt += '</div>';
                    });
                    carouselNoticias.trigger('replace.owl.carousel', [jQuery(noticiasTxt)]);
                    carouselNoticias.trigger('refresh.owl.carousel');
                }
            });
        }
    </script>
    

</body>

</html>