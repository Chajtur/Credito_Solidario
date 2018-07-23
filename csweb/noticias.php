<?php require 'php/config.php';?>

<?php 

require 'php/conn.php';

$stat = $conn->prepare('select * from noticias where activa = 1');
$stat->execute();
$result = $stat->fetchAll(PDO::FETCH_ASSOC);

$noticias = array();

$stat_img = $conn->prepare('select * from imagenes where idnoticia = :id');

foreach($result as $fila){

    $current_noticia = (object)array(
        'id' => $fila['id'],
        'titulo' => $fila['titulo'],
        'contenido' => $fila['contenido'],
        'lugar' => $fila['lugar'],
        'fecha' => $fila['fecha'],
        'ultima_actualizacion' => $fila['ultima_actualizacion'],
        'imagenes' => array()
    );

    $stat_img->bindValue(':id', $fila['id'], PDO::PARAM_STR);
    $stat_img->execute();
    $aux_result = $stat_img->fetchAll(PDO::FETCH_ASSOC);

    foreach($aux_result as $row){
        array_push($current_noticia->imagenes, $row['nombre']);
    }

    array_push($noticias, $current_noticia);

}

?>

<!DOCTYPE html>

<html lang="en">

<?php require 'layout/head.php';?>

<body>

    <?php require 'layout/header.php';?>

    <div class="parallax-container custom">
        <div class="parallax"><img src="img/BANNERS-01-01.jpg"></div>
        <div class="container">
            <h3 class="white-text">NOTICIAS</h3>
        </div>
    </div>

    <?php $altern = true;?>

    <?php foreach($noticias as $noticia):?>

        <div class="section news-content" id="noticia1">
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 l6 <?php echo ($altern = !$altern ? 'push-l6' : '')?>">
                        <div class="image-news">
                            <img class="" src="http://www.creditosolidario.hn/backend/sys/asset/img/noticias/<?php echo $noticia->imagenes['0'];?>" alt="">
                        </div>
                    </div>
                    <div class="col s12 m6 l6 <?php echo ($altern ? 'pull-l6' : '')?> left-align">
                        <!--TITLE-->
                        <h3 class="title-text-news"><?php echo $noticia->titulo;?></h3>
                        <div class="colored-line-left"></div>
                        <p class=""><?php echo substr($noticia->contenido, 0, 200).'...';?></p>
                        <a href="noticia.php?id=<?php echo $noticia->id;?>" class="waves-effect waves-light btn-flat blue white-text right">Ver Más..</a>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach;?>

    <?php require 'layout/footer.php';?>

    <?php require 'layout/scripts.php';?>

</body>

</html>
