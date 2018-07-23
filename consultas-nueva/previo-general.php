<div class="section">
    <div class="row">
        <div class="col s12 m4 l6 offset-l3 offset-m4">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title">Buscar en Crédito Solidario</span>
                    <p>Para realizar una búsqueda solamente digite el nombre o la identidad del beneficiario en el cuadro de texto de la barra superior o haga clic en el botón de abajo.</p>
                </div>
                <div class="card-action hide-on-med-and-down">
                    <a href="#!" class="green-text text-lighten-3" id="btn-card-buscar">Buscar</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(init);

    function init(){
        
        // Eventos
        $('#btn-card-buscar').click(buscarClave);

        // Asignar texto al breadcrum
        $('#breadcrum-title').text('Consulta General');
        
        // Elegir el current
        window.current = "general";

    }

    function buscarClave(){
        
        if($('#search').val() != ''){
            $('#search').trigger('submit');
            return false;
        }
        $('#search').focus();
        
    }
    
</script>