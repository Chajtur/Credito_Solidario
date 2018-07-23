<!-- Modal Structure -->
<div id="modal-consulta-footer" class="modal modal-fixed-footer">
    <div class="modal-content">
        <div class="row no-margin">
            <form id="form-search">
                <div class="col l8 m8 s12 offset-l2 offset-m2">
                    <div class="input-field input-search-for-modal-consulta-footer">
                        <i class="material-icons">search</i>
                        <input placeholder="Buscar Beneficiario" id="palabra_clave" type="text" class="input-search validate">
                    </div>
                </div>
            </form>
        </div>
        <div class="row">

            <div class="container center" id="busqueda-loading">
                <div class="preloader-wrapper active">
                    <div class="spinner-layer spinner-green-only">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                            <div class="gap-patch">
                                <div class="circle">
                            </div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="work-collapsible">
                <div class="row">
                    <div class="col s12 no-padding">
                        <ul id="result-buscar-beneficiario-list" class="collapsible z-depth-0" data-collapsible="accordion">
                            <li class="collapsible-item-header avatar">
                                <i class="material-icons circle light-green">list</i>
                                <span class="collapsible-title-header">Busqueda General
                                    <div class="secondary-content actions">
                                        <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                        <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                            <i class="material-icons center-align">search</i>
                                        </a>
                                    </div>
                                </span>
                                <p>Resultados de la búsqueda:</p>
                                <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                            </li>
                            
                            <li>
                                <div class="collapsible-header-titles  sin-icon">
                                    <div class="row no-margin">
                                        <div class="col s1 m1 l1">
                                            <p class="collapsible-title">#</p>
                                        </div>
                                        <div class="col s11 m5 l4">
                                            <p class="collapsible-title">Nombre</p>
                                        </div>
                                        <div class="col m4 l4 hide-on-small-only">
                                            <p class="collapsible-title">Identidad</p>
                                        </div>
                                        <div class="col m3 l3 hide-on-med-and-down">
                                            <p class="collapsible-title">Estado</p>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <div class="list collapsible consulta-collapsible no-padding no-margin z-depth-0" id="busqueda-list-results">
                            </div>
                            
                            <li class="collapsible-item-header light">
                                <ul id="pag-control" class="pag pagination">
                                </ul>
                            </li>

                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cerrar</a>
    </div>
</div>

<script>

$(document).ready(init);

function abrirModalConsultasFooter(){
    $('.collapsible.consulta-collapsible').collapsible();
    $('#modal-consulta-footer').modal('open');
}

function buscarBeneficiario(e){

    e.preventDefault();

    $('#work-collapsible').fadeOut(100, function(){
        $('#busqueda-loading').fadeIn(100);
    });

    $.ajax({
        type: 'POST',
        url: '../php/common/buscar-beneficiario.php',
        data: {
            palabra_clave: $('#palabra_clave').val()
        },
        success: function(data){

            $('#busqueda-loading').fadeOut(100, function(){

                $('#work-collapsible').fadeIn(100);
                var obj = JSON.parse(data);
                $('#busqueda-list-results').empty();

                $.each(obj, function(index, value){
                    $('#busqueda-list-results').append(`
                        <li>
                            <div class="collapsible-header sin-icon">
                                <div class="row no-margin">
                                    <div class="col s1 m1 l1 truncate">`+(index+1)+`</div>
                                    <div class="col s11 m5 l4 truncate"><span class="nombreb">`+value.nombre+`</span></div>
                                    <div class="col s4 m4 l4 hide-on-small-only identidadb truncate">`+value.Identidad+`</div>
                                    <div class="col s6 m3 l3 hide-on-med-and-down estatusb truncate">`+value.Estatus_Prestamo+`</div>
                                </div>
                            </div>
                            <div class="collapsible-body no-padding">
                                <div class="card blue-grey white-text z-depth-0 no-margin no-border-radius">
                                    <div class="card-content">
                                        <span class="card-title text-darken-4"><span class="light">Estado:</span> `+value.Estatus_Prestamo+`</span>
                                        <div class="row no-margin">
                                            <div class="col l6 m6 s12">
                                                <p><span class="light">Identidad:</span> `+value.Identidad+`</p>
                                            </div>
                                            <div class="col l6 m6 s12">
                                                <p><span class="light">Fecha Desembolso:</span> `+value.fecha_desembolso+`</p>
                                            </div>
                                            <div class="col l6 m6 s12">
                                                <p><span class="light">IFI:</span> `+value.nombre_ifi+`</p>
                                            </div>
                                            <div class="col l6 m6 s12">
                                                <p><span class="light">Ciclo:</span> `+value.ciclo+`</p>
                                            </div> 
                                            <div class="col l6 m6 s12">    
                                                <p><span class="light">Supervisor:</span> `+value.Supervisor+`</p>
                                            </div>
                                            <div class="col l6 m6 s12">    
                                                <p><span class="light">Hash:</span> `+value.grupo_solidario_hash+` (`+parseInt(value.grupo_solidario_hash, 16)+`)</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-action">
                                        <a href="#!" class="activator green-text text-lighten-3 btn-bitacora">Bitácora</a>
                                        <a href="#!" class="activator green-text text-lighten-3 btn-aval right">Aval</a>
                                    </div>
                                    <div class="card-reveal blue-grey darken-1 white-text">
                                        <span class="card-title text-darken-4"><span id="card-reveal-title"></span><i class="material-icons right">close</i></span>
                                        
                                        <div class="container center" id="bitacora-loading">
                                            <div class="preloader-wrapper active">
                                                <div class="spinner-layer spinner-green-only">
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
                                        
                                            
                                        <div class="" id="bitacora-content">
                                            
                                            
                                            <!--<table class="">
                                                <thead>
                                                    <tr>
                                                        <th data-field="id">Estado</th>
                                                        <th data-field="name">Fecha de Ingreso</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>Ingresado</td>
                                                        <td>22/02/2017 20:19</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Call Center</td>
                                                        <td>23/02/2017 21:40</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Control de Calidad</td>
                                                        <td>24/02/2017 22:00</td>
                                                    </tr>
                                                </tbody>
                                            </table>-->
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </li>
                    `);
                });

                var options = {
                    page: 10,
                    pagination: true,
                    valueNames: [ 'nombreb', 'identidadb', 'estatusb' ],
                    fuzzySearch: {
                        searchClass: "fuzzy-search",
                        location: 0,
                        distance: 100,
                        threshold: 0.2,
                        multiSearch: true
                    }
                };
                var listObj = new List('result-buscar-beneficiario-list', options);

            });

        }
    });
}

function init(){

    // Materialize
    $('.collapsible.consulta-collapsible').collapsible();

    // Inicializaciones
    $('#work-collapsible').hide();
    $('#busqueda-loading').hide();

    // Eventos
    $('#modal-consulta-footer-activator').click(abrirModalConsultasFooter);
    $('#form-search').on('submit', buscarBeneficiario);

}

</script>
