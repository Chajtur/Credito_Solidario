<!DOCTYPE html>
<html lang="en">

<?php
    require 'php/config.php';
    require 'layout/head.php';
?>

<body>

    <?php require 'layout/header.php';?>

    <!--main section STAR-->
    <main>
    
        <!--BANNER REVOLUTION SLIDER START-->
        <section class="" id="inicio">
            <div id="slider-principal" class="slider">
                <ul id="main-slider" class="slides"></ul>
            </div>
        </section>
        <!--BANNER REVOLUTION SLIDER END-->

        <!-- INICIO CONTADORES -->
        <section class="contadores center">
            <div class="row">
                <div class="col s12 m4">                    
                    <h1 class='numscroller' data-min='1' data-max='230' data-delay='5' data-increment='10'>230</h1>
                    <p>CRÉDITOS OTORGADOS<p>
                </div>
                <div class="col s12 m4">
                    <h1 class='numscroller' data-min='1' data-max='230' data-delay='5' data-increment='10'>230</h1>
                    <p>DESEMBOLSOS<p>
                </div>
                <div class="col s12 m4">
                    <h1 class='numscroller' data-min='1' data-max='230' data-delay='5' data-increment='10'>230</h1>
                    <p>EMPLEOS GENERADOS<p>
                </div>
            </div>
        </section>
        <!-- FIN CONTADORES -->

        <!-- INICIO AGENCIAS -->
        <section class="agencias">
            <div id="carousel-departamentos" class="carousel center" data-indicators="true">
                    
            </div>
        </section>
        <!-- FIN AGENCIAS -->

        <!--INICIO GALERIA-->
        <section class="galeria">            
            <div id="banco-imagenes" class="row">
                
            </div>            
        </section>
        <!--FIN GALERIA-->

        <!--ICONOS SECTION START-->
        <div class="section section-icons">
            <div class="header">
                <h2>CRÉDITO SOLIDARIO</h2>
                <p>Una iniciativa que fomenta la economía socialmente inclusiva mediante un programa al servicio de los emprendedores del sector micro empresarial del país, otorgándoles asistencia técnica y crédito solidario.</p>
            </div>
            <div class="container">
                <div id="carousel-programas" class="owl-carousel owl-theme">
                    
                </div>
            </div>            
        </div>

        <!--ICONOS SECTION END-->

        <!-- INICIO NOTICIAS -->
        <section class="noticias">
            <div class="col s12">
                <div class="titulo center">
                    <span class="white black-text">ULTIMAS NOTICIAS</span>            
                </div>
            </div>
            <div class="container">
                <div class="row">                    
                    <div id="ultimas-noticias" class="col s12">
                        
                    </div>                    
                </div>                
            </div>
            
                        
        </section>
        <!-- FIN NOTICIAS -->

        <!-- INICIO DIRECTOR -->
        <section class="director">
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <div class="card horizontal">
                            <div class="card-image">
                                <img id="imagen-director" src="" alt="" class="responsive-img">
                            </div>
                            <div class="card-stacked">
                                <div id="contenido-director" class="card-content">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- FIN DIRECTOR END -->

        <section class="redes-sociales">
            <div id="slider-redes-sociales" class="slider">
                <ul class="slides">
                    <li>
                        <img src="img/redesSociales.jpg" class="responsive-img" alt="">
                    </li>
                </ul>
            </div>
        </section>

        <section class="mapa">
            <div id="map"></div>
        </section>

        <!-- <div>
         <input type = "button" onclick = "getLocation();" value = "ubicacion"/>
        </div> -->

    </main>
    <!--main section END-->

    <?php require 'layout/footer.php';?>

    <?php require 'layout/scripts.php';?>
    <script src="js/numscroller-1.0.js"></script>

    <script>
        $(document).ready(function() {            
            $('#slider-redes-sociales').slider({
                indicators: false,
                height: 400
            });

            $('.moveNextCarousel').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                $('.carousel').carousel('next');
            });

            // move prev carousel
            $('.movePrevCarousel').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                $('.carousel').carousel('prev');
            });

            function getCounter(startCount,  endCount, time, html) {
                data = {
                    startCount: starCount,
                    endCount: endCount,
                    time: time
                };
            }

            obtenerCarrusel();
            obtenerDepartamentos();
            obtenerGaleria();
            obtenerProgramas();
            obtenerUltimasNoticias();
            obtenerDirector();
            obtenerAgencias();
            //getLocation();
        });

        //mostrarMapaAgencias(ubicacionAgencias);

        function obtenerAgencias() {
            let mapa = $('#map');
            let ubicacionAgencias = [];

            $.ajax({
                type: 'GET',
                url: '../php/mantenimientos/agencias.php?accion=listar-todos',
                success: function (data) {
                    let agencias = JSON.parse(data);
                    
                    $.each(agencias, function(i, agencia) {
                        if (agencia.latitud && agencia.longitud)
                        {
                            let ubicacionAgencia = {
                                lat: parseFloat(agencia.latitud),
                                lng: parseFloat(agencia.longitud)
                            };

                            ubicacionAgencias.push(ubicacionAgencia);
                        }
                    });
                    mostrarMapaAgencias(ubicacionAgencias);
                }
            });
        }

        function mostrarMapaAgencias(ubicaciones) {
            let ubicacion = ubicaciones[0];
            let map = new google.maps.Map(
                document.getElementById('map'), {
                    zoom: 7.5, 
                    center: new google.maps.LatLng(14.932456, -86.908908)//,
                    //mapTypeId: google.maps.MapTypeId.ROADMAP
                }
            );

            let infowindow = new google.maps.InfoWindow();

            let marker, i;

            for (i = 0; i < ubicaciones.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(ubicaciones[i].lat, ubicaciones[i].lng),
                    map: map
                });

                (function (marker) {
                    google.maps.event.addListener(marker, 'click', function () {
                        let directionsService = new google.maps.DirectionsService();
                        let directionsDisplay = new google.maps.DirectionsRenderer();
                        
                        let options = {timeout:60000};

                        navigator.geolocation.getCurrentPosition(
                            function (location) {
                                let origin = {
                                    lat: location.coords.latitude,
                                    lng: location.coords.longitude
                                };
                                
                                let request = {
                                    origin: origin,
                                    destination: marker.getPosition(),
                                    travelMode: 'DRIVING'
                                };
                                
                                directionsDisplay.setMap(map);
                                directionsService.route(request, function(result, status) {
                                    if (status == 'OK') {
                                        directionsDisplay.setDirections(result);
                                    }
                                });
                            },
                            function (error) {
                                if(err.code == 1) {
                                    alert("Error: Access is denied!");
                                } else if( err.code == 2) {
                                    alert("Error: Position is unavailable!");
                                }
                            }, options);
                    });
                })(marker);
            }
            
        }
        function obtenerCarrusel() {
            let carruselPrincipal = $('#main-slider');
            let imagenesTxt = '';
            let alineaciones = ['center', 'left', 'right'];

            $.ajax({
                type: 'GET',
                url: '../php/mercadeo/carrusel.php?accion=listar&estado=1',
                success: function (data) {
                    let imagenes = JSON.parse(data);
                    $.each(imagenes, function (i, imagen) {
                        imagenesTxt += '<li>';
                        imagenesTxt += '<img src="'+ imagen.url +'">';
                        imagenesTxt += '<div class="caption '+ alineaciones[imagen.alineacion - 1] +'-align">';
                        imagenesTxt += '<h3>'+ imagen.etiquetaPrincipal +'</h3>';
                        imagenesTxt += '<h5 class="light grey-text text-lighten-3">'+ imagen.etiquetaSecundaria +'</h5>';
                        imagenesTxt += '</div>';
                        imagenesTxt += '</li>';
                    });
                    carruselPrincipal.html(imagenesTxt);
                    $('#slider-principal').slider({
                        height: 600
                    });
                },
                error: function (xhr, status, error) {

                }
            });
        }

        function obtenerDepartamentos() {
            let departamentosTxt = '';
            let carouselDepartamentos = $('#carousel-departamentos');

            /*departamentosTxt += '<div class="carousel-fixed-item center middle-indicator">';
            departamentosTxt += '<div class="left">';
            departamentosTxt += '<a href="#Previo" class="movePrevCarousel middle-indicator-text waves-effect waves-light content-indicator"><i class="material-icons left middle-indicator-text black-text">chevron_left</i></a>';
            departamentosTxt += '</div>';
            departamentosTxt += '<div class="right">';
            departamentosTxt += '<a href="#Siguiente" class="moveNextCarousel middle-indicator-text waves-effect waves-light content-indicator"><i class="material-icons right middle-indicator-text black-text">chevron_right</i></a>';
            departamentosTxt += '</div>';
            departamentosTxt += '</div>';*/

            $.ajax({
                type: 'GET',
                url: '../php/mercadeo/departamentoImagen.php?accion=listar-todos',
                success: function (data) {
                    let departamentos = JSON.parse(data);
                    
                    $.each(departamentos, function (i, departamento) {
                        departamentosTxt += '<a class="carousel-item" href="departamento.php?departamentoId='+ departamento.idDepartamento +'">';
                        //departamentosTxt += '<div>';
                        departamentosTxt += '<div>';
                        departamentosTxt += '<img src="'+ departamento.url +'" alt="" class="responsive-img circle">';
                        departamentosTxt += '</div>';
                        departamentosTxt += '<div>';
                        departamentosTxt += '<span>'+ departamento.nombre +'</span>';
                        departamentosTxt += '</div>';
                        //departamentosTxt += '</div>';
                        departamentosTxt += '</a>';
                    });

                    carouselDepartamentos.html(departamentosTxt);

                    carouselDepartamentos.carousel({
                        dist: 0,
                        padding: 20,
                        fullWidth: false,
                        indicators: false,
                        duration: 100
                    });
                }
            });
        }

        function obtenerGaleria() {
            let bancoImagenes = $('#banco-imagenes');
            let imagenesTxt = '';

            $.ajax({
                type: 'GET',
                url: '../php/mercadeo/bancoImagenes.php?accion=listar&estado=1',
                success: function (data) {
                    let imagenes = JSON.parse(data);
                    $.each(imagenes, function (i, imagen) {
                        imagenesTxt += '<div class="col s12 m6 l3">';
                        imagenesTxt += '<img src="'+ imagen.url +'" alt="" class="responsive-img materialboxed">';
                        imagenesTxt += '</div>';
                    });
                    bancoImagenes.html(imagenesTxt);
                    $('.materialboxed').materialbox();
                },
                error: function (xhr, status, error) {

                }
            });
        }

        function obtenerProgramas() {
            let carouselProgramas = $('#carousel-programas');
            let programasTxt = '';

            $.ajax({
                type: 'GET',
                url: '../php/mantenimientos/programa.php?estado=1&accion=listar',
                success: function (data) {
                    let programas = JSON.parse(data);
                    $.each(programas, function (i, programa) {
                        programasTxt += '<div class="item">';
                        programasTxt += '<img src="'+ programa.url_imagen +'" alt="" class="responsive-img">';
                        programasTxt += '<h5 class="center">'+ programa.subprograma +'</h5>';
                        programasTxt += '<p>'+ programa.descripcion +'</p>';
                        programasTxt += '</div>';
                    });
                    carouselProgramas.html(programasTxt);

                    carouselProgramas.owlCarousel({
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
                                items: 5,
                                nav: false,
                                loop: false
                            }
                        }
                    });
                }
            });
        }

        function obtenerUltimasNoticias() {
            let ultimasNoticias = $('#ultimas-noticias');
            let noticiasTxt = '';

            $.ajax({
                type: 'GET',
                url: '../php/mercadeo/controlador.php?accion=ultimas-noticias&limite=3',
                success: function (data) {
                    let noticiasDB = JSON.parse(data);
                    $.each(noticiasDB, function (i, noticia) {
                        noticiasTxt += '<div class="noticia">';
                        noticiasTxt += '<h3 class="center">'+ noticia.titulo +'</h3>';
                        noticiasTxt += '<p>'+ noticia.resumen +'</p>';
                        noticiasTxt += '<div class="center">';
                        noticiasTxt += '<a href="noticia.php?noticiaId='+ noticia.noticiaId.trim() +'" class="btn fondoPrincipal">Leer mas...</a>';
                        noticiasTxt += '</div>';
                        noticiasTxt += '</div>';
                    });
                    ultimasNoticias.html(noticiasTxt);
                }
            });
        }

        function obtenerDirector() {
            let imagen = $('#imagen-director');
            let imagenUrl = '../images/user.png';
            let contenidoDirector = $('#contenido-director');
            let frase = '<p>';

            $.ajax({
                type: 'GET',
                url: '../php/mercadeo/director.php?accion=mostrar&directorId=1',
                success: function (data) {
                    let directores = JSON.parse(data);
                    let director = directores[0];

                    if (director.url_imagen) {
                        imagenUrl = director.url_imagen;
                    }

                    imagen.attr('src', imagenUrl);
                    frase += director.frase + '</p>';

                    contenidoDirector.html(frase);
                }
            });
        }
        
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcNsMB5091ztV6GeSmJaUrt93D9aiNRLI">
    </script>
</body>

</html>
