<!DOCTYPE html>

<html lang="en">

<?php require 'layout/head.php';?>

<body>

    <?php require 'layout/header.php';?>

    <section class="videos">
        <div class="container">
            <div class="row">
                <h3 class="fondoPrincipal-text center">HISTORIAS DE ÉXITO</h3>
                <hr>
                <div id="historias-exito"></div>
            </div>
        </div>
    </section>

    <div id="modal-video" class="modal" style="width: 560px !important;height: 380px !important;">
        <div class="modal-content no-padding">
            <iframe id="video-enlace" width="560" height="315" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn red">Cerrar</a>
        </div>
    </div>

    <?php require 'layout/footer.php';?>
    <?php require 'layout/scripts.php';?>

    <script>
        $(document).ready(function () {
            $('.modal').modal({
                dismissible: true,
                inDuration: 300,
                outDuration: 200
            });

            let historiasExito = $('#historias-exito');
            let videosTxt = '';

            $.ajax({
                type: 'GET',
                url: '../php/mercadeo/video.php?accion=listar&estado=1',
                success: function (data) {
                    let videos = JSON.parse(data);
                    $.each(videos, function (i, video) {
                        let fechaVideo = new Date(video.fecha);
                        let fechaFormateada = fechaVideo.getFullYear() + '/' + fechaVideo.getMonth() + '/' + fechaVideo.getDate();
                        videosTxt += '<div class="col s12 m3">';
                        videosTxt += '<div class="card">';
                        videosTxt += '<div class="card-image">';
                        videosTxt += '<img src="https://i.ytimg.com/vi/'+ video.youtubeId +'/mqdefault.jpg" alt="">';
                        videosTxt += '<span class="card-title"></span>';
                        videosTxt += '<a href="#!" onclick="abrirModalVideo(\''+ video.youtubeId +'\')" class="btn-floating halfway-fab waves-effect waves-light"><i class="material-icons red">play_arrow</i></a>';
                        videosTxt += '</div>';
                        videosTxt += '<div class="card-content"><strong>'+ video.titulo + '</strong><br />' + fechaFormateada +'</div>';
                        videosTxt += '<div class="card-action">';
                        //videosTxt += '<a href="#!" onclick="abrirModalVideo('+ video.videoId +')"><i class="material-icons blue-text">create</i></a>';
                        //videosTxt += '<a href="#!"><i class="material-icons red-text">clear</i></a>';
                        videosTxt += '</div>';
                        videosTxt += '</div>';
                        videosTxt += '</div>';
                    });

                    historiasExito.html(videosTxt);
                }
            });
        });

        function abrirModalVideo(youtubeId, titulo) {
            $('#video-enlace').attr('src', 'https://www.youtube.com/embed/'+youtubeId);
            $('#modal-video').modal('open');
        }

        function cerrarModalVideo() {
            $('#video-enlace').attr('src','');
            $('#modal-video').modal('close');
        }
    </script>