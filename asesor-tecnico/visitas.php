
  
   <div class="section" id="search-section">
    <div class="row">
        <div class="col s12 m8 offset-m2 l8 offset-l2">
            <div class="">
                <div class="">
                    <div class="center-align">
                        <span><i class="material-icons large grey-text" id="search-icon">search</i></span>
                        <span><i class="material-icons large blue-text" id="searching-icon">autorenew</i></span>
                        <h4 id="nueva-consulta" class="grey-text text-darken-3">Lista Vacía</h4>
                        <h6 id="nueva-consulta2" class="grey-text text-darken-2">No ha realizdo ninguna consulta, si desea realizar una busqueda...</h6>
                        <h6 id="presione-aqui" class="grey-text text-darken-2"> <a href="#!">Presione aquí. </a></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section" id="main-section">
    <div class="row">
        <div class="col s12 m12 l4">
            <div id="flight-card" class="card">
                <div class="card-header blue darken-3">
                    <div class="card-title  right-align">
                        <h4 id="titulo-carta" class="flight-card-title">Visita</h4>
                        <p id="ultima-visita" class="flight-card-date">Ult. Visita 22 Febrero - 03:50 pm</p>
                        <p id="gestor-visitador" class="flight-card-date">Por: María Velasquez</p>
                    </div>
                </div>
                <div class="card-content">
                    <img id="user-type-img" src="../images/user-girl.png" alt="persona" class="z-depth-1 right circle responsive-img circle-image-in-card">

                    <span id="nombre" class="card-title truncate tooltipped" data-position="top" data-delay="50" data-tooltip="">María Eugenia López</span>

                    <p><i class="material-icons left">credit_card</i><span id="identidad">0801-1985-11478</span></p>
                    <p><i class="material-icons left">add_location</i>

                        <input class="with-gap" name="tipo_direccion" type="radio" id="tipo_direccion-d">
                        <label for="tipo_direccion-d">Domicilio</label>
                        <input class="with-gap" name="tipo_direccion" type="radio" id="tipo_direccion-n">
                        <label for="tipo_direccion-n">Negoio</label>

                    </p>
                    <p>
                        <i class="material-icons left">info_outline</i>
                        <a class="truncate" id="observacion" href="#modal-observacion">+ Agregar Observación</a>
                    </p>

                </div>
                <div class="card-action">
                    <a id="btn-guardar" class="btn-flat waves-effect wave-blue blue-text" href="#!">GUARDAR</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div id="modal-observacion" class="modal">
    <div class="modal-content modal-content-editar-grupo">
        <h5>Agregar Observación</h5>
        <form class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="observacion-texto" class="materialize-textarea"></textarea>
                    <label for="observacion-texto">Textarea</label>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a id="agregar-observacion" href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agregar</a>
        <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
    </div>
</div>

<div id="loader-card" style="width:100%; position:absolute; z-index:1;top:510px;" class="center-align">
    <div class="preloader-wrapper small active center-align">
        <div class="spinner-layer spinner-blue-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>

<script src="js-script/visita-script-1.js"></script>
<script src="js-script/visita-script-principal.js"></script>
<script>

$(document).ready(function(){
    
    $('#breadcrum-title').text('Visitas');
    $('.header-search-wrapper').show();
    
    //CÓDIGO PARA CAMBIAR EL TOP A LA IMAGEN DE USUARIO 
               /* var altoDeCarta = $('.card-header').height();
                console.log("el alto es: " + altoDeCarta);
                var assigTop = altoDeCarta - 37;
                console.log(assigTop);
                $('.circle-image-in-card').css('top', assigTop);*/
    
});

</script>