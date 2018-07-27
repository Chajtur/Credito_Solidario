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
        <div class="owl-carousel owl-theme">
            <div class="item">
                <div class="card">
                    <div class="card-image">
                        <img src="img/noticiaPortada.jpg" alt="" class="responsive-img">
                    </div>
                </div>
                <div class="card-content">
                    <span class="card-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet eros metus.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ultricies massa ligula, vitae venenatis massa imperdiet aliquam. Integer finibus nullam.</p>
                </div>
                <div class="card-action">
                    <span class="noticia-fecha grey lighten-3 black-text tiny">27 julio 2018</span>
                    <a href="noticia.php" class="right"><i class="material-icons grey-text text-darken-2 small">add</i></a>
                </div>
            </div>
            <div class="item">
                <div class="card">
                    <div class="card-image">
                        <img src="img/noticiaPortada.jpg" alt="" class="responsive-img">
                    </div>
                </div>
                <div class="card-content">
                    <span class="card-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet eros metus.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ultricies massa ligula, vitae venenatis massa imperdiet aliquam. Integer finibus nullam.</p>
                </div>
                <div class="card-action">
                    <span class="noticia-fecha grey lighten-3 black-text tiny">27 julio 2018</span>
                    <a href="" class="right"><i class="material-icons grey-text text-darken-2 small">add</i></a>
                </div>
            </div>
            <div class="item">
                <div class="card">
                    <div class="card-image">
                        <img src="img/noticiaPortada.jpg" alt="" class="responsive-img">
                    </div>
                </div>
                <div class="card-content">
                    <span class="card-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet eros metus.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ultricies massa ligula, vitae venenatis massa imperdiet aliquam. Integer finibus nullam.</p>
                </div>
                <div class="card-action">
                    <span class="noticia-fecha grey lighten-3 black-text tiny">27 julio 2018</span>
                    <a href="" class="right"><i class="material-icons grey-text text-darken-2 small">add</i></a>
                </div>
            </div>
            <div class="item">
                <div class="card">
                    <div class="card-image">
                        <img src="img/noticiaPortada.jpg" alt="" class="responsive-img">
                    </div>
                </div>
                <div class="card-content">
                    <span class="card-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet eros metus.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ultricies massa ligula, vitae venenatis massa imperdiet aliquam. Integer finibus nullam.</p>
                </div>
                <div class="card-action">
                    <span class="noticia-fecha grey lighten-3 black-text tiny">27 julio 2018</span>
                    <a href="" class="right"><i class="material-icons grey-text text-darken-2 small">add</i></a>
                </div>
            </div>
            <div class="item">
                <div class="card">
                    <div class="card-image">
                        <img src="img/noticiaPortada.jpg" alt="" class="responsive-img">
                    </div>
                </div>
                <div class="card-content">
                    <span class="card-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet eros metus.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ultricies massa ligula, vitae venenatis massa imperdiet aliquam. Integer finibus nullam.</p>
                </div>
                <div class="card-action">
                    <span class="noticia-fecha grey lighten-3 black-text tiny">27 julio 2018</span>
                    <a href="" class="right"><i class="material-icons grey-text text-darken-2 small">add</i></a>
                </div>
            </div>
            <div class="item">
                <div class="card">
                    <div class="card-image">
                        <img src="img/noticiaPortada.jpg" alt="" class="responsive-img">
                    </div>
                </div>
                <div class="card-content">
                    <span class="card-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet eros metus.</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ultricies massa ligula, vitae venenatis massa imperdiet aliquam. Integer finibus nullam.</p>
                </div>
                <div class="card-action">
                    <span class="noticia-fecha grey lighten-3 black-text tiny">27 julio 2018</span>
                    <a href="" class="right"><i class="material-icons grey-text text-darken-2 small">add</i></a>
                </div>
            </div>
        </div>        
    </section>

    <?php require 'layout/footer.php';?>

    <?php require 'layout/scripts.php';?>

    <script>
        $(document).ready(function () {
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
        });
    </script>
    

</body>

</html>