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
                    <div class="col s12">
                        <h4 class="grey-text text-darken-1">FRANCISCO MORAZAN</h4>
                    </div>
                    <ul class="tabs">
                        <li class="tab col s3 active"><a href="#agencia-1">Tegucigalpa</a></li>
                        <li class="tab col s3"><a href="#agencia-2">Valle de Ángeles</a></li>
                    </ul>
                    <div class="col s12 grey lighten-4 center grey-text text-darken-1" id="agencia-1">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum posuere nisi eu augue ultrices viverra ac sagittis mauris. Donec accumsan.</p>
                        <p><i class="material-icons">phone</i>Teléfono: 2220-1471</p>
                    </div>
                    <div class="col s12 center grey-text text-darken-1" id="agencia-2">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum posuere nisi eu augue ultrices viverra ac sagittis mauris. Donec accumsan.</p>
                        <p><i class="material-icons left-align">phone</i>Teléfono: 2220-1471</p>
                    </div>
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
                $('ul.tabs').tabs({
                    swipeable: true
                });
            });
        </script>

    </body>

</html>