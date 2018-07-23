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

        <!--OWL SLIDER START-->
        <div class="section">
            <div class="row">
                <div class="col s12">
                    <div class="owl-carousel owl-theme">
                        <div class="item owl-slider-index-img with-mask-name">
                            <img class="" src="img/carrousel/400X400-01.jpg" alt="Owl Image">
                            <span class="name-mask"><b>Luis Fernando Andrade </b><br>
                                <small>Tegucigalpa</small>
                            </span>
                        </div>
                        <div class="item owl-slider-index-img with-mask-name">
                            <img class="" src="img/carrousel/400X400-02.jpg" alt="Owl Image">
                            <span class="name-mask"><b>Maribel Guevara </b><br>
                                <small>Tegucigalpa</small>
                            </span>
                        </div>
                        <div class="item owl-slider-index-img with-mask-name">
                            <img class="" src="img/carrousel/400X400-03.jpg" alt="Owl Image">
                            <span class="name-mask"><b>Jorge Herrera </b><br>
                                <small>Valle de Angeles</small>
                            </span>
                        </div>
                        <div class="item owl-slider-index-img with-mask-name">
                            <img class="" src="img/carrousel/400X400-04.jpg" alt="Owl Image">
                            <span class="name-mask"><b>Fredy Romero </b><br>
                                <small>Tegucigalpa</small>
                            </span>
                        </div>
                        <div class="item owl-slider-index-img with-mask-name">
                            <img class="" src="img/carrousel/400X400-05.jpg" alt="Owl Image">
                            <span class="name-mask"><b>Elda Flores </b><br>
                                <small>Tegucigalpa</small>
                            </span>
                        </div>
                        <div class="item owl-slider-index-img with-mask-name">
                            <img class="" src="img/carrousel/400X400-06.jpg" alt="Owl Image">
                            <span class="name-mask"><b>Karla Díaz </b><br>
                                <small>Nacaome, Valle</small>
                            </span>
                            
                        </div>
                        <div class="item owl-slider-index-img with-mask-name">
                            <img class="" src="img/carrousel/400X400-09.jpg" alt="Owl Image">
                            <span class="name-mask"><b>Felicia Santos </b><br>
                                <small>La Campa, Lempira</small>
                            </span>
                        </div>
                        <div class="item owl-slider-index-img with-mask-name">
                            <img class="" src="img/carrousel/400X400-07.jpg" alt="Owl Image">
                            <span class="name-mask"><b>Manuel Anibal Larios </b><br>
                                <small>Tegucigalpa</small>
                            </span>
                        </div>
                        <div class="item owl-slider-index-img with-mask-name">
                            <img class="" src="img/carrousel/400X400-10.jpg" alt="Owl Image">
                            <span class="name-mask"><b>Jose Walter Henriquez </b><br>
                                <small>Lempira</small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--OWL SLIDER END-->

        <!--ICONOS SECTION START-->
        <div class="section section-icons">

            <div class="header">
                <h2>CRÉDITO SOLIDARIO</h2>
                <p>Una iniciativa que fomenta la economía socialmente inclusiva mediante un programa al servicio de los emprendedores del sector micro empresarial del país, otorgándoles asistencia técnica y crédito solidario.</p>
            </div>

            <div class="section grey lighten-4">
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

        <!--NEWS SECTION START-->
        <div class="section blue" style="padding-bottom: 0px">
            <div class="header">
                <h2>Últimas Noticias</h2>
                <div class="colored-line-center"></div><br>
            </div><br><br>

            <?php $altern = true;?>

            <?php foreach($noticias as $noticia):?>

                <div class="section news-content <?php echo ($altern ? 'noticia-alterna' : 'noticia-normal');?>" id="">
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m6 l6 <?php echo ($altern = !$altern ? 'push-l6' : '')?>">
                                <div class="image-news">
                                    <img class="" src="http://www.creditosolidario.hn/backend/sys/asset/img/noticias/<?php echo $noticia['imagenes']['0']['nombre'];?>" alt="">
                                </div>
                            </div>
                            <div class="col s12 m6 l6 <?php echo ($altern ? 'pull-l6' : '')?> left-align">
                                <!--TITLE-->
                                <h3 class="title-text-news"><?php echo $noticia['titulo'];?></h3>
                                <div class="colored-line-left"></div>
                                <p class=""><?php echo substr($noticia['contenido'], 0, 200).'...';?></p>
                                <a href="noticia.php?id=<?php echo $noticia['id'];?>" class="waves-effect waves-light btn-flat blue white-text right">Ver Más..</a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach;?>

            <!--NOTICIA #2
            <div class="section news-content noticia-alterna" id="noticia2">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6 push-l6">
                            <div class="image-news">
                                <img class="" src="assets/img/img-noticias/noti2.JPG" alt="">
                            </div>
                        </div>
                        <div class="col s12 m6 l6 pull-l6 left-align">
                            <h3 class="title-text-news">Taxistas, salones de belleza, barberías y pulperías reciben 100 millones de lempiras de Crédito Solidario</h3>
                            <div class="colored-line-left"></div>
                            <p class="">Tegucigalpa, 23 de mayo. “Banca Solidaria ha sido un programa que nos ha ayudado a repotenciar nuestras unidades de taxi.</p>
                            <a class="waves-effect waves-light btn-flat blue white-text left">Ver Más..</a>
                        </div>

                    </div>
                </div>
            </div>-->

        </div>

        

        <!--NEWS SECTION END-->

    </main>
    <!--main section END-->

    <?php require 'layout/footer.php';?>

    <?php require 'layout/scripts.php';?>

    <script>
        $(document).ready(function() {

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
