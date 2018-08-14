<div class="row">
    <div class="card col s12">
        <div class="card-content">
            <span class="card-title blue-text">Gestión de videos</span>
            <form>
                <div class="row">
                    <!-- 
                        <div class="input-field col s10">
                        <i class="material-icons prefix">search</i>
                        <input type="text" name="busqueda" id="busqueda">
                        <label for="busqueda">Búsqueda</label>
                        </div>                  
                        <div class="col s1">
                            <button class="waves-effect waves-light btn green lighten-2" id="btn-buscar" name="btn-buscar"><i class="material-icons">refresh</i></button>
                            <input type="hidden" name="usuario" id="usuario" value="ADRIAN">
                        </div>
                     -->
                    <div class="col s11">
                        
                    </div> 
                    <div class="col s1">
                        <input type="hidden" name="usuario" id="usuario" value="ADRIAN">
                        <button data-position="top" data-delay="50" data-tooltip="Agregar imagen" class="waves-effect waves-light btn teal lighten-2 tooltipped" id="btn-nuevo" name="btn-nuevo"><i class="material-icons">add</i></button>
                    </div>
                </div>
            </form>
            <div class="row" id="grilla-videos"></div>
        </div>
    </div>
</div>

<div class="modal modal-fixed-footer" id="modal-informacion">
    <div class="modal-content">
        <h4>Infomacion del video</h4>
        <form id="form-datos">           
            <div class="input-field">
                <input type="text" name="titulo" placeholder="Título" id="titulo" data-length="20" class="validate">
                <label for="titulo">Título</label>
            </div>
            <div class="input-field">
                <input type="text" name="url" placeholder="Enlace del video" id="url" class="validate">
                <label for="url">Enlace</label>
            </div>
            <div class="input-field">
                <input type="text" name="youtube-id" placeholder="Youtube id" id="youtube-id" class="validate">
                <label for="youtube-id">Youtube id</label>
            </div>      
            <div class="input-field">
                <input type="text" name="fecha" id="fecha" class="datepicker">
                <label for="fecha">Fecha</label>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="video-id" id="video-id">
        <button id="btn-registrar-datos" class="waves-effect waves-light btn green lighten-2" type="submit">Registrar</button>
        <button id="btn-cancelar-datos" class="waves-effect waves-light btn red lighten-2" type="submit">Cancelar</button>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.modal').modal({
            dismissible: true,
            inDuration: 300,
            outDuration: 200
        });

        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: 15,
            today: 'Hoy',
            clear: 'Limpiar',
            close: 'Aceptar',
            closeOnSelect: false,
            container: undefined,
            monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',  'Octubre', 'Noviembre', 'Diciembre'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            weekdaysLetter: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            format: 'dd/mm/yyyy',
            onStart: function () {
                let date = new Date();
                this.set('select', [date.getFullYear(), date.getMonth() + 1, date.getDate()]);
            }
        });

        $('#btn-nuevo').click(function (evt) {
            abrirModalVideo();
            evt.preventDefault();
        });

        $('#btn-cancelar-datos').click(function (evt) {
            cerrarModalVideo();
            evt.preventDefault();
        });

        $('#btn-registrar-datos').click(function (evt) {
            let videoId = $('#video-id').val();
            if (videoId) {
                actualizarVideo(videoId);
            } else {
                registrarVideo();
            }
            evt.preventDefault();
        });

        mostrarVideos();
    });

    function abrirModalVideo(videoId) {
        if (videoId) {
            mostrarVideo(videoId);
        }
        $('#modal-informacion').modal('open');
    }

    function cerrarModalVideo() {
        $('#modal-informacion').modal('close');
    }

    function registrarVideo() {
        let enlace = $('#url');
        let titulo = $('#titulo');
        let fecha = $('#fecha');
        let usuario = $('#usuario');
        let youtubeId = $('#youtube-id');
        let fechaPhp = fecha.val().split('/').reverse().join('-');

        $.ajax({
            type: 'POST',
            url: '../php/mercadeo/video.php',
            data: {
                enlace: enlace.val(),
                titulo: titulo.val(),
                fecha: fechaPhp,
                accion: 'agregar',
                usuario: usuario.val(),
                estado: 1,
                youtubeId: youtubeId.val()
            },
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    enlace.val('');
                    titulo.val('');
                    fecha.val('');
                    youtubeId.val('');
                    cerrarModalVideo();
                    swal('Correcto','Se han registrado los datos correctamente', 'success');
                    mostrarVideos();
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }

    function actualizarVideo(videoId) {
        let enlace = $('#url');
        let titulo = $('#titulo');
        let fecha = $('#fecha');
        let usuario = $('#usuario');
        let youtubeId = $('#youtube-id');
        let fechaPhp = fecha.val().split('/').reverse().join('-');

        $.ajax({
            type: 'POST',
            url: '../php/mercadeo/video.php',
            data: {
                id: videoId,
                enlace: enlace.val(),
                titulo: titulo.val(),
                fecha: fechaPhp,
                accion: 'actualizar',
                usuario: usuario.val(),
                estado: 1,
                youtubeId: youtubeId.val()
            },
            success: function (data) {
                let respuestaData = JSON.parse(data);
                if (respuestaData.error == 0) {
                    enlace.val('');
                    titulo.val('');
                    fecha.val('');
                    youtubeId.val('');
                    cerrarModalVideo();
                    swal('Correcto','Se han registrado los datos correctamente', 'success');
                    mostrarVideos();
                } else {
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
            }
        });
    }

    function mostrarVideo(videoId) {
        let enlace = $('#url');
        let titulo = $('#titulo');
        let fecha = $('#fecha');
        let id = $('#video-id');
        let youtubeId = $('#youtube-id');
        id.val(videoId);

        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/video.php?accion=mostrar&id='+videoId,
            success: function (data) {
                let videos = JSON.parse(data);
                let video = videos[0];
                let fechaUsr = new Date(video.fecha);

                enlace.val(video.enlace);
                titulo.val(video.titulo);
                fecha.val(fechaUsr.getDate() + '/' + fechaUsr.getMonth() + '/' + fechaUsr.getFullYear());
                youtubeId.val(video.youtubeId);
            }
        });
    }

    function mostrarVideos() {
        let grillaVideos = $('#grilla-videos');
        let videosTxt = '';

        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/video.php?accion=listar&estado=1',
            success: function (data) {
                let videos = JSON.parse(data);
                $.each(videos, function (i, video) {
                    let fechaVideo = new Date(video.fecha);
                    let fechaFormateada = fechaVideo.getFullYear() + '/' + fechaVideo.getMonth() + '/' + fechaVideo.getDate();
                    videosTxt += '<div class="col s12 m4">';
                    videosTxt += '<div class="card">';
                    videosTxt += '<div class="card-image">';
                    videosTxt += '<img src="https://i.ytimg.com/vi/'+ video.youtubeId +'/mqdefault.jpg" alt="">';
                    videosTxt += '<span class="card-title"></span>';
                    videosTxt += '</div>';
                    videosTxt += '<div class="card-content"><strong>'+ video.titulo + '</strong><br />' + fechaFormateada +'</div>';
                    videosTxt += '<div class="card-action">';
                    videosTxt += '<a href="#!" onclick="abrirModalVideo('+ video.videoId +')"><i class="material-icons blue-text">create</i></a>';
                    videosTxt += '<a href="#!"><i class="material-icons red-text">clear</i></a>';
                    videosTxt += '</div>';
                    videosTxt += '</div>';
                    videosTxt += '</div>';
                });

                grillaVideos.html(videosTxt);
            }
        });
    }
</script>