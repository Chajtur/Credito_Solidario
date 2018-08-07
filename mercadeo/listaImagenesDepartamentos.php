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
            <div id="grilla-departamentos"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

    });

    function obtenerDepartamentos() {
        let grillaDepartamentos = $('#grilla-departamentos');
        grillaDepartamentos.text('');
        let departamentosTxt = '';

        $.ajax({
            type: 'GET',
            url: '../php/mercadeo/departamentoImagen.php?accion=listar',
            success: function (data) {
                let departamentos = JSON.parse(data);
                $.each(departamentos, function (i, departamento) {
                    departamentosTxt += '<div class="col s12 m4">';
                    departamentosTxt += '<div class="card">';
                    departamentosTxt += '<div class="card-image">';
                    departamentosTxt += '<img src="" alt="">';
                    departamentosTxt += '<span class="card-title"></span>';
                    departamentosTxt += '</div>';
                    departamentosTxt += '<div class="card-content"></div>';
                    departamentosTxt += '<div class="card-action">';
                    departamentosTxt += '<a href="#"></a>';
                    departamentosTxt += '</div>';
                    departamentosTxt += '</div>';
                    departamentosTxt += '</div>';
                });

                grillaDepartamentos.html(departamentosTxt);
            },
            error: function (xhr, status, error) {
                
            }
        });
    }
</script>