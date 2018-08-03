<div class="row">
    <div class="card col s12">
        <div class="card-content">
            <span class="card-title blue-text">Gestión de noticias</span>
            <form class="">
                <div class="row">
                    <div class="input-field">
                        <i class="material-icons prefix">search</i>
                        <input type="text" name="busqueda" id="busqueda">
                        <label for="busqueda">Búsqueda</label>
                    </div>
                </div>
            </form>
            <div id="grilla-noticias"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        obtenerNoticias();
    });

    function obtenerNoticias() {
        let noticiasContainer = $('#grilla-noticias');
        noticiasContainer.text('');
        let noticiasTxt = '';
        
        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/controlador.php?accion=listar',
            success: function (data) {
                let noticias = JSON.parse(data);
                $.each(noticias, function (i, noticia) {
                    noticiasTxt += '<div class="col s12 m4">';
                    noticiasTxt += '<div class="card">';
                    noticiasTxt += '<div class="card-image">';
                    noticiasTxt += '<img src="'+ noticia.url +'" alt="">';
                    noticiasTxt += '<span class="card-title">'+ noticia.titulo +'</span>';
                    noticiasTxt += '</div>';
                    noticiasTxt += '<div class="card-content">'+ noticia.resumen +'</div>';
                    noticiasTxt += '<div class="card-action">';
                    noticiasTxt += '<a href="index.php?accion=editar&noticiaId=1"><i class="material-icons">create</i></a>';
                    noticiasTxt += '</div>';
                    noticiasTxt += '</div>';
                    noticiasTxt += '</div>';
                });

                noticiasContainer.html(noticiasTxt);
            },
            error: function(xhr, status, error) {

            }
        });
    }
</script>