<?php require 'php/config.php';?>

<?php 

require 'php/conn.php';

if(!isset($_GET['id'])){
    header('Location: noticias.php');
}

$stat = $conn->prepare('select a.id, a.titulo, a.contenido, a.lugar, a.fecha, b.idcategoria as idcategoria from noticias a, noticias_con_categoria b 
where a.id = b.idnoticia and a.id = :id limit 1');
$stat->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
$stat->execute();
$noticia = $stat->fetch(PDO::FETCH_ASSOC);

$stat_categorias_noticia = $conn->prepare('select * from noticias_con_categoria a, categorias b where a.idcategoria = b.id and a.idnoticia = :id');
$stat_categorias_noticia->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
$stat_categorias_noticia->execute();
$result_categorias_noticia = $stat_categorias_noticia->fetchAll(PDO::FETCH_ASSOC);

$categorias_noticia = array();
foreach($result_categorias_noticia as $row){
    array_push($categorias_noticia, $row['nombre']);
}

$stat_imagenes = $conn->prepare('select * from imagenes where idnoticia = :id');
$stat_imagenes->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
$stat_imagenes->execute();
$imagenes = $stat_imagenes->fetchAll(PDO::FETCH_ASSOC);

$noticia['imagenes'] = $imagenes;

$stat_noticias_categoria = $conn->prepare('select a.titulo, a.contenido, a.id, c.nombre as nombre_categoria from noticias a, noticias_con_categoria b, categorias c
where a.id = b.idnoticia and b.idcategoria = :categoria and a.activa = 1 and c.id = :categoria');
$stat_noticias_categoria->bindValue(':categoria', $noticia['idcategoria']);
$stat_noticias_categoria->execute();
$noticias_categorias = $stat_noticias_categoria->fetchAll(PDO::FETCH_ASSOC);

$stat_imagenes_categorias = $conn->prepare('select * from imagenes where idnoticia = :id');

$i=0;
foreach($noticias_categorias as $notice){

    $stat_imagenes_categorias->bindValue(':id', $notice['id']);
    $stat_imagenes_categorias->execute();

    $noticias_categorias[$i]['imagenes'] = $stat_imagenes_categorias->fetchAll(PDO::FETCH_ASSOC);

    $i++;

}

// echo json_encode($noticias_categorias);

?>

<!DOCTYPE html>

<html lang="en">

<?php require 'layout/head.php';?>

<?php $date = date_create($noticia['fecha']);?>

<body>

    <?php require 'layout/header.php';?>

    <section class="blue darken-3 no-margin">

        <div class="container main-header">
            <br>
            <h3 class="hide-on-small-only light"><?php echo $noticia['titulo'];?></h3>
            <h5 class="hide-on-med-and-up light"><?php echo $noticia['titulo'];?></h5>
            <br>
            <div class="row">


                <div class="col l7 m8 s12">

                    <div class="slider">
                        <ul class="slides">
                            <!--<li>
                                <img src="https://lorempixel.com/580/250/nature/1">
                                <div class="caption center-align">
                                    <h3>This is our big Tagline!</h3>
                                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                                </div>
                            </li>-->
                            <?php foreach($noticia['imagenes'] as $imagen):?>

                                <li>
                                    <img src="http://www.creditosolidario.hn/backend/sys/asset/img/noticias/<?php echo $imagen['nombre'];?>">
                                </li>

                            <?PHP endforeach;?>
                        </ul>
                    </div>

                </div>

                <div class="col l5 m4 s12">
                    <div class="items-view">
                        <span class="item-view"><h5 class="spec-notice"><i class="material-icons md-24">date_range</i> <?php echo date_format($date, 'd/m/Y');?></h5></span>
                        <span class="item-view"><h5 class="spec-notice"><i class="material-icons">access_time</i> <?php echo date_format($date, 'H:m');?></h5></span>
                        <span class="item-view"><h5 class="spec-notice"><i class="material-icons md-24">filter</i> <?php echo implode(', ', $categorias_noticia);?></h5></span>
                    </div>
                </div>

            </div>
            <!--<div class="divider"></div>-->
        </div>

    </section>

    <section class="container">
        <div class="container"><br><br>
            <div class="row">
                <div class="col l7 m5 s12">
                    <h5><?php echo $noticia['lugar'];?>, <small><?php echo date_format($date, 'd/m/Y');?></small></h5>
                    <p class="noticia-content"><?php echo nl2br($noticia['contenido']);?></p>
                    <div class="noticias-relacionadas row">
                        
                        <div class="col l12 m12 s12">

                            <h5>Noticias de <?php echo $noticias_categorias[0]['nombre_categoria']?></h5>

                        </div>

                        <?php foreach($noticias_categorias as $noticia_categoria):?>

                            <div class="col l6 m6 s12">
                                <div class="card small">
                                    <div class="card-image">
                                        <img src="http://www.creditosolidario.hn/backend/sys/asset/img/noticias/<?php echo $noticia_categoria['imagenes'][0]['nombre'];?>">
                                        <span class="card-title truncate"><?php echo substr($noticia_categoria['titulo'], 0, 50);?></span>
                                    </div>
                                    <div class="card-content">
                                        <p><?php echo substr($noticia_categoria['contenido'], 0, 50);?></p>
                                    </div>
                                    <div class="card-action">
                                        <a href="noticia.php?id=<?php echo $noticia_categoria['id'];?>">Ver noticia</a>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach;?>

                    </div>
                </div>
                <div class="col l4 m6 s12 offset-l1 offset-m1 hide-on-small-only">
                    <?php foreach($noticia['imagenes'] as $imagen):?>

                        <div class="card">
                            <img class="materialboxed responsive-img" src="http://www.creditosolidario.hn/backend/sys/asset/img/noticias/<?php echo $imagen['nombre'];?>">
                        </div>

                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </section>

    <?php require 'layout/footer.php';?>

    <?php require 'layout/scripts.php';?>

</body>

</html>
