<?php require 'php/config.php';?>

<?php

require 'php/conn.php';

$stat = $conn->prepare('select * from noticias where activa = 1 order by fecha desc limit 2');
$stat->execute();
$noticias = $stat->fetchAll(PDO::FETCH_ASSOC);

$stat_imagenes = $conn->prepare('select * from imagenes where idnoticia = :id');

$i=0;
foreach($noticias as $noticia){
    $stat_imagenes->bindValue(':id', $noticia['id'], PDO::PARAM_STR);
    $stat_imagenes->execute();
    $noticias[$i]['imagenes'] = $stat_imagenes->fetchAll(PDO::FETCH_ASSOC);
    $i++;
}

// echo json_encode($noticias);

?>

<!DOCTYPE html>
<html lang="en">

<?php require 'layout/head.php';?>

<body>

    <?php require 'layout/header.php';?>

    <!--main section STAR-->
    <main>
    
        <!--BANNER REVOLUTION SLIDER START-->
        <section class="rev_slider_wrapper" id="inicio">
            <div class="rev_slider matrox-slider">
                <ul>

                    <!-- slide 1 start -->
                    <li data-transition="zoomin" 
                    data-slotamount="7" 
                    data-easein="Power4.easeInOut" 
                    data-easeout="Power4.easeInOut" 
                    data-masterspeed="2000" 
                    data-thumb="assets/img/banner/presi2.jpg" 
                    data-rotate="0" 
                    data-saveperformance="off" 
                    data-title="Crédito Solidario" 
                    data-description="">

                        <!-- MAIN IMAGE -->
                        <img src="assets/img/banner/presi2.jpg" 
                        alt="" data-bgposition="center center" 
                        data-kenburns="on" 
                        data-duration="10000" 
                        data-ease="Linear.easeNone" 
                        data-scalestart="100" 
                        data-scaleend="120" 
                        data-rotatestart="0" 
                        data-rotateend="0" 
                        data-offsetstart="0 -500" 
                        data-offsetend="0 500" 
                        data-bgparallax="10" 
                        class="rev-slidebg" 
                        data-no-retina>
                        <!-- LAYERS -->

                        <div class="tp-overlay"></div>

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption NotGeneric-Title tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']" data-fontsize="['70','70','70','45']" data-lineheight="['70','70','70','50']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power2.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="1000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 5; white-space: nowrap;padding:10px 20px 10px 20px;">Crédito Solidario
                        </div>

                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption rev-subheading white-text tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['62','62','62','61']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-start="1500" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap;">Tu Banca Solidaria
                        </div>

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption NotGeneric-Icon  tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['-120,'-120,'-120,'-120]" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-style_hover="cursor:default;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="2000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap;padding:10px 10px 10px 10px;"><img src="img/logo_cs.png" alt="">
                        </div>
                    </li>
                    <!-- slide 1 end -->

                    <!-- slide 2 start -->
                    <li data-transition="zoomin" 
                    data-slotamount="7" 
                    data-easein="Power4.easeInOut" 
                    data-easeout="Power4.easeInOut" 
                    data-masterspeed="2000" 
                    data-thumb="assets/img/banner/presi.JPG" 
                    data-rotate="0" 
                    data-saveperformance="off" 
                    data-title="Créditos Otorgados" 
                    data-description="">

                        <!-- MAIN IMAGE -->
                        <img src="assets/img/banner/presi.JPG" 
                        alt="" 
                        data-bgposition="center center" 
                        data-kenburns="on" 
                        data-duration="10000" 
                        data-ease="Linear.easeNone" 
                        data-scalestart="100" 
                        data-scaleend="120" 
                        data-rotatestart="0"
                        data-rotateend="0" 
                        data-offsetstart="0 -500" 
                        data-offsetend="0 500" 
                        data-bgparallax="10" 
                        class="rev-slidebg" 
                        data-no-retina>
                        <!-- LAYERS -->

                        <div class="tp-overlay"></div>

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption NotGeneric-Title tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']" data-fontsize="['70','70','70','45']" data-lineheight="['70','70','70','50']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power2.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="1000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 5; white-space: nowrap;padding:10px 20px 10px 20px;">
                            100,000<br class="show-on-small-only"> Créditos Otorgados
                            <!--TEXTO EN GRANDE (TITULO)-->
                        </div>

                        <!-- LAYER NR. 2 -->
                        <!--<div class="tp-caption rev-subheading white-text tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['62','62','62','61']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-start="1500" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap;">MÁS DE 100,000 CRÉDITOS OTORGADOS
                            
                        </div>-->

                        <!-- LAYER NR. 3 -->
                        <!--<div class="tp-caption NotGeneric-Icon  tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['-68','-68','-68','-68']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-style_hover="cursor:default;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="2000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap;padding:10px 10px 10px 10px;"><i class="material-icons">menu</i>
                        </div>-->
                    </li>
                    <!-- slide 2 end -->

                    <!-- slide 3 start -->
                    <li data-transition="zoomin" 
                    data-slotamount="7" 
                    data-easein="Power4.easeInOut" 
                    data-easeout="Power4.easeInOut" 
                    data-masterspeed="2000" 
                    data-thumb="assets/img/banner/EVENTOINFOP.jpg" 
                    data-rotate="0" 
                    data-saveperformance="off" 
                    data-title="Agencias" 
                    data-description="">

                        <!-- MAIN IMAGE -->
                        <img src="assets/img/banner/MAPA-01.jpg" 
                        alt="" 
                        data-bgposition="center center" 
                        data-kenburns="on" 
                        data-duration="10000" 
                        data-ease="Linear.easeNone" 
                        data-scalestart="100"
                        data-scaleend="120" 
                        data-rotatestart="0"
                        data-rotateend="0" 
                        data-offsetstart="0 0" 
                        data-offsetend="0 0" 
                        data-bgparallax="10" 
                        class="rev-slidebg" 
                        data-no-retina>
                        <!-- LAYERS -->

                        <div class="tp-overlay"></div>

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption NotGeneric-Title tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['top','top','top','top']" data-voffset="['0','0','0','0']" data-fontsize="['70','70','70','45']" data-lineheight="['70','70','70','50']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power2.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="1000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 5; white-space: nowrap;padding:10px 20px 10px 20px;">
                            Cobertura en los 18 Departamentos
                        </div>

                        <!-- LAYER NR. 2 -->
                        <!--<div class="tp-caption rev-subheading white-text tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['62','62','62','61']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-start="1500" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap;">
                            
                        </div>-->

                        <!-- LAYER NR. 3 -->
                        <!--<div class="tp-caption NotGeneric-Icon  tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['-68','-68','-68','-68']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-style_hover="cursor:default;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="2000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap;padding:10px 10px 10px 10px;"><i class="material-icons">menu</i>
                        </div>-->
                    </li>
                    <!-- slide 3 end -->

                    <!-- slide 4 start -->
                    <li data-transition="zoomin" 
                    data-slotamount="7" 
                    data-easein="Power4.easeInOut" 
                    data-easeout="Power4.easeInOut" 
                    data-masterspeed="2000" 
                    data-thumb="assets/img/banner/CHEQUE.jpg" 
                    data-rotate="0" 
                    data-saveperformance="off" 
                    data-title="Cobertura" 
                    data-description="">

                        <!-- MAIN IMAGE -->
                        <img src="assets/img/banner/CHEQUE.jpg" 
                        alt="" 
                        data-bgposition="center center" 
                        data-kenburns="on" 
                        data-duration="10000" 
                        data-ease="Linear.easeNone" 
                        data-scalestart="100" 
                        data-scaleend="120" 
                        data-rotatestart="0" 
                        data-rotateend="0" 
                        data-offsetstart="0 -500" 
                        data-offsetend="0 500" 
                        data-bgparallax="10" 
                        class="rev-slidebg" 
                        data-no-retina>
                        <!-- LAYERS -->

                        <div class="tp-overlay"></div>

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption NotGeneric-Title tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']" data-fontsize="['70','70','70','45']" data-lineheight="['70','70','70','50']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power2.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="1000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 5; white-space: nowrap;padding:10px 20px 10px 20px;">
                            45 Agencias a nivel Nacional
                            <!--TEXTO EN GRANDE (TITULO)-->
                        </div>

                        <!-- LAYER NR. 2 -->
                        <!--<div class="tp-caption rev-subheading white-text tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['62','62','62','61']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-start="1500" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap;">MÁS DE 100,000 CRÉDITOS ENTREADOS
                            
                        </div>-->

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption NotGeneric-Icon  tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['-68','-68','-68','-68']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-style_hover="cursor:default;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="2000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap;padding:10px 10px 10px 10px;"><i class="material-icons">menu</i>
                        </div>
                    </li>
                    <!-- slide 4 end -->

                    <!-- slide 5 start -->
                    <li data-transition="zoomin" 
                    data-slotamount="7" 
                    data-easein="Power4.easeInOut" 
                    data-easeout="Power4.easeInOut" 
                    data-masterspeed="2000" 
                    data-thumb="assets/img/banner/cheque2.JPG" 
                    data-rotate="0" 
                    data-saveperformance="off" 
                    data-title="Empleos" 
                    data-description="">

                        <!-- MAIN IMAGE -->
                        <img src="assets/img/banner/cheque2.JPG" 
                        alt="" 
                        data-bgposition="center center" 
                        data-kenburns="on" 
                        data-duration="10000" 
                        data-ease="Linear.easeNone" 
                        data-scalestart="100" 
                        data-scaleend="120" 
                        data-rotatestart="0" 
                        data-rotateend="0" 
                        data-offsetstart="0 -500" 
                        data-offsetend="0 500" 
                        data-bgparallax="10" 
                        class="rev-slidebg" 
                        data-no-retina>
                        <!-- LAYERS -->

                        <div class="tp-overlay"></div>

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption NotGeneric-Title tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']" data-fontsize="['70','70','70','45']" data-lineheight="['70','70','70','50']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power2.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="1000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 5; white-space: nowrap;padding:10px 20px 10px 20px;">
                            63,095 Empleos <br class="show-on-small-only">directos generados <br>a través de los <br class="show-on-small-only">créditos otorgados
                            <!--TEXTO EN GRANDE (TITULO)-->
                        </div>

                        <!-- LAYER NR. 2 -->
                        <!--<div class="tp-caption rev-subheading white-text tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['62','62','62','61']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" data-start="1500" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 6; white-space: nowrap;">MÁS DE 100,000 CRÉDITOS ENTREADOS
                            
                        </div>-->

                        <!-- LAYER NR. 3 -->
                        <!--<div class="tp-caption NotGeneric-Icon  tp-resizeme rs-parallaxlevel-0" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['-68','-68','-68','-68']" data-width="none" data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;" data-style_hover="cursor:default;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;" data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];" data-mask_out="x:inherit;y:inherit;" data-start="2000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap;padding:10px 10px 10px 10px;"><i class="material-icons">menu</i>
                        </div>-->
                    </li>
                    <!-- slide 5 end -->

                </ul>
            </div>
            <!-- end revolution slider -->
        </section>
        <!--BANNER REVOLUTION SLIDER END-->

        <!-- INICIO CONTADORES -->
        <section class="contadores center">
            <div class="row">
                <div class="col 12 m4">                    
                    <h2>230</h2>
                    <p>CRÉDITOS OTOROGADOS<p>
                </div>
                <div class="col 12 m4">
                    <h2>230</h2>
                    <p>DESEMBOLSOS<p>
                </div>
                <div class="col 12 m4">
                    <h2>230</h2>
                    <p>EMPLEOS GENERADOS<p>
                </div>
            </div>
        </section>
        <!-- FIN CONTADORES -->

        <!-- INICIO AGENCIAS -->
        <section class="agencias">
            <div class="carousel center" data-indicators="true">
                <div class="carousel-fixed-item center middle-indicator">
                    <div class="left">
                        <a href="Previo" class="movePrevCarousel middle-indicator-text waves-effect waves-light content-indicator"><i class="material-icons left middle-indicator-text black-text">chevron_left</i></a>
                    </div>
                    
                    <div class="right">
                        <a href="Siguiente" class="moveNextCarousel middle-indicator-text waves-effect waves-light content-indicator"><i class="material-icons right middle-indicator-text black-text">chevron_right</i></a>
                    </div>                    
                </div>
                <a href="#departamento-1" class="carousel-item">
                    <div>
                        <div>
                            <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img circle">
                        </div>
                        <div>
                            <span>Francisco Morazan</span>
                        </div>
                    </div>
                </a>
                <a href="#departamento-1" class="carousel-item">
                    <div>
                        <div>
                            <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img circle">
                        </div>
                        <div>
                            <span>Francisco Morazan</span>
                        </div>
                    </div>
                </a>
                <a href="#departamento-1" class="carousel-item">
                    <div>
                        <div>
                            <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img circle">
                        </div>
                        <div class="card-content">
                            <span>Francisco Morazan</span>
                        </div>
                    </div>
                </a>
                <a href="#departamento-1" class="carousel-item">
                    <div>
                        <div>
                            <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img circle">
                        </div>
                        <div class="card-content">
                            <span>Francisco Morazan</span>
                        </div>
                    </div>
                </a>       
                <a href="#departamento-1" class="carousel-item">
                    <div>
                        <div>
                            <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img circle">
                        </div>
                        <div>
                            <span>Francisco Morazan</span>
                        </div>
                    </div>
                </a>
                <a href="#departamento-1" class="carousel-item">
                    <div>
                        <div>
                            <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img circle">
                        </div>
                        <div>
                            <span>Francisco Morazan</span>
                        </div>
                    </div>
                </a>
                <a href="#departamento-1" class="carousel-item">
                    <div>
                        <div>
                            <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img circle">
                        </div>
                        <div class="card-content">
                            <span>Francisco Morazan</span>
                        </div>
                    </div>
                </a>
                <a href="#departamento-1" class="carousel-item">
                    <div>
                        <div>
                            <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img circle">
                        </div>
                        <div class="card-content">
                            <span>Francisco Morazan</span>
                        </div>
                    </div>
                </a>         
            </div>
        </section>
        <!-- FIN AGENCIAS -->

        <!--INICIO GALERIA-->
        <section class="galeria">            
            <div class="row">
                <div class="col s12 m6 l3">
                    <img src="img/carrousel/400X400-05.jpg" alt="" data-caption="Nombre de la señora y el lugar" class="responsive-img materialboxed">
                </div>
                <div class="col s12 m6 l3">
                    <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img materialboxed">
                </div>
                <div class="col s12 m6 l3">
                    <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img materialboxed">
                </div>
                <div class="col s12 m6 l3">
                    <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img materialboxed">
                </div>
                <div class="col s12 m6 l3">
                    <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img materialboxed">
                </div>
                <div class="col s12 m6 l3">
                    <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img materialboxed">
                </div>
                <div class="col s12 m6 l3">
                    <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img materialboxed">
                </div>
                <div class="col s12 m6 l3">
                    <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img materialboxed">
                </div>
            </div>            
        </section>
        <!--FIN GALERIA-->

        <!--ICONOS SECTION START-->
        <div class="section section-icons">

            <div class="header">
                <h2>CRÉDITO SOLIDARIO</h2>
                <p>Una iniciativa que fomenta la economía socialmente inclusiva mediante un programa al servicio de los emprendedores del sector micro empresarial del país, otorgándoles asistencia técnica y crédito solidario.</p>
            </div>

            <div class="section">
                <div class="container">

                    <!--   Icon Section   -->
                    <div class="row">
                        <div class="col s12 m6 l3 wow fadeInLeft">
                            <div class="icon-block icon-services">
                                <div class="row">
                                    <div class="col l8 m8 s8 center offset-l2 offset-m2 offset-s2">
                                        <img src="img/icons/ICONOS-01.png" alt="" class="responsive-img">
                                    </div>
                                    <div class="col l12 m12 s12">
                                        <h5 class="center">Créditos Escalonados</h5>
                                    </div>
                                    <div class="col l12 m12 s12">
                                        <p class="light center-align">3 ciclos de Créditos escalonados que te ayudan a generar un historial crediticio.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l3 wow fadeInRight" data-wow-delay="0.6s">
                            <div class="icon-block icon-services">
                                <div class="row">
                                    <div class="col l8 m8 s8 center offset-l2 offset-m2 offset-s2">
                                        <img src="img/icons/ICONOS-03.png" alt="" class="responsive-img">
                                    </div>
                                    <div class="col l12 m12 s12">
                                        <h5 class="center">Créditos Movilizadores</h5>
                                    </div>
                                    <div class="col l12 m12 s12">
                                        <p class="light center-align">Tiene como objetivo potenciar y desarrollar la economía del país apoyando diversos rubros como ser: Taxistas, Salas de Belleza, Barberías y Pulperías.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l3 wow fadeInLeft">
                            <div class="icon-block icon-services">
                                <div class="row">
                                    <div class="col l8 m8 s8 center offset-l2 offset-m2 offset-s2">
                                        <img src="img/icons/ICONOS-04.png" alt="" class="responsive-img">
                                    </div>
                                    <div class="col l12 m12 s12">
                                        <h5 class="center">Bici Solidaria</h5>
                                    </div>
                                    <div class="col l12 m12 s12">
                                        <p class="light center-align">Crédito Solidario y FUNDEIMH te traen una nueva propuesta que le brinda movilidad a tu negocio.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l3 wow fadeInLeft">
                            <div class="icon-block icon-services">
                                <div class="row">
                                    <div class="col l8 m8 s8 center offset-l2 offset-m2 offset-s2">
                                        <img src="img/icons/ICONOS-02.png" alt="" class="responsive-img">
                                    </div>
                                    <div class="col l12 m12 s12">
                                        <h5 class="center">Crédito  Rural</h5>
                                    </div>
                                    <div class="col l12 m12 s12">
                                        <p class="light center-align">La opción para beneficiar a pequeños y medianos productores, procesadores y comercializadores de maíz, frijol y otros cultivos.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--ICONOS SECTION END-->

        <!-- INICIO NOTICIAS -->
        <section class="noticias">
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <div class="titulo center">
                            <span class="white black-text">ULTIMAS NOTICIAS</span>            
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="noticia">
                            <h3 class="center">Nueve empresas campesinas reciben 20 millonres de lempiras de Crédito Solidario</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sed neque sollicitudin, imperdiet erat non, aliquam lectus. Cras quis viverra augue. Aenean elementum felis ut finibus convallis. Vestibulum arcu metus, porta gravida pharetra ut, interdum vitae ligula. Aliquam sodales, massa sodales aliquet porta, felis ligula suscipit diam, vitae laoreet mi.</p>
                            <div class="center">
                                <a href="#" class="btn fondoPrincipal">Leer mas...</a>
                            </div>
                        </div>
                        <div class="noticia">
                            <h3 class="center">Nueve empresas campesinas reciben 20 millonres de lempiras de Crédito Solidario</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sed neque sollicitudin, imperdiet erat non, aliquam lectus. Cras quis viverra augue. Aenean elementum felis ut finibus convallis. Vestibulum arcu metus, porta gravida pharetra ut, interdum vitae ligula. Aliquam sodales, massa sodales aliquet porta, felis ligula suscipit diam, vitae laoreet mi.</p>
                            <div class="center">
                                <a href="#" class="btn fondoPrincipal">Leer mas...</a>
                            </div>
                        </div>
                    </div>                    
                </div>                
            </div>
            
                        
        </section>
        <!-- FIN NOTICIAS -->

        <section class="director">
            <div class="container">
                <div class="row">
                    <div class="col s12 m4">
                        <img src="img/carrousel/400X400-05.jpg" alt="" class="responsive-img">
                    </div>
                    <div class="col s12 m8">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare, sapien tempus malesuada sollicitudin, mi erat euismod ante, vel lacinia ante arcu a massa. Fusce efficitur sodales mi eu semper. Sed scelerisque lacus nisl, eget porta libero dignissim semper. Sed lacus lectus, luctus a convallis non, imperdiet vel eros. In vitae tortor ligula. Cras sollicitudin quam nec est hendrerit, at euismod massa vestibulum. Aenean placerat tellus vel elit suscipit gravida ac sed mauris. Sed vehicula vestibulum velit nec lacinia. Vestibulum non tincidunt dui, in semper mi. Praesent non diam ex. Vivamus ac pellentesque tortor. Donec tempor turpis et libero convallis.</p>
                    </div>
                </div>
            </div>
        </section>
        

        <!--NEWS SECTION END-->

    </main>
    <!--main section END-->

    <?php require 'layout/footer.php';?>

    <?php require 'layout/scripts.php';?>

    <script>
        $(document).ready(function() {
            $('.materialboxed').materialbox();
            $('.carousel').carousel({
                dist: 0,
                padding: 20,
                fullWidth: false,
                indicators: false,
                duration: 100
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

            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                responsiveClass: true,
                autoplay: true,
                autoplayTimeout: 3000,
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
        });
        
    </script>
</body>

</html>
