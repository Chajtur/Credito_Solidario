<div class="section">
    <div class="row">
        <div class="col s12 m8 l10 offset-m2 offset-l1">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">
                        <div class="row">
                            <div class="col l8">Reportes de bitácora</div>
                            <div class="col l4">
                            </div>
                        </div>
                    </span>
                    <div id="lista-grupos">
                        
                        <ul class="collapsible grupos-recibidos list z-depth-0" data-collapsible="accordion">
                            
                            <li>
                                <div class="collapsible-header sin-icon">
                                    <div class="col s6 l1 codigog" id="grupo-solidario-hash"><b>#</b></div>
                                    <div class="col s12 l4 hide-on-med-and-down nombreg"><b>Nombre del Reporte</b></div>
                                    <div class="col s12 l4 hide-on-med-and-down integrantesg"><b>Descripción</b></div>
                                    <div class="col s12 l3 hide-on-med-and-down integrantesg center"><b>Acciones</b></div>
                                </div>
                            </li>
                                    
                            <li id="collapsible" class="">
                                <div class="collapsible-header sin-icon">
                                    <div class="col s6 l1 codigog truncate" id="grupo-solidario-hash">1</div>
                                    <div class="col s12 l4 hide-on-med-and-down nombreg truncate" id="nombre-grupo">Reporte de Bitácora</div>
                                    <div class="col s12 l4 hide-on-med-and-down integrantesg truncate">Reporte que contiene todas las observaciones para los créditos entre las fechas</div>
                                    <div class="col s12 l3 hide-on-med-and-down integrantesg truncate center">
                                        <a class="waves-effect waves-light" href="#!" id="btn-generar-reporte-devoluciones"><i class="material-icons green-text">file_download</i></a>
                                    </div>
                                </div>
                            </li>

                            <li id="collapsible" class="">
                                <div class="collapsible-header sin-icon">
                                    <div class="col s6 l1 codigog truncate" id="grupo-solidario-hash">2</div>
                                    <div class="col s12 l4 hide-on-med-and-down nombreg truncate" id="nombre-grupo">Observaciones de Grupos</div>
                                    <div class="col s12 l4 hide-on-med-and-down integrantesg truncate">Observaciones por Grupo (Hash o fecha)</div>
                                    <div class="col s12 l3 hide-on-med-and-down integrantesg truncate center">
                                        <a class="waves-effect waves-light" href="#!" id="btn-generar-reporte-observaciones"><i class="material-icons green-text">file_download</i></a>
                                    </div>
                                </div>
                            </li>

                            <!-- <li id="collapsible" class="">
                                <div class="collapsible-header sin-icon">
                                    <div class="col s6 l1 codigog truncate" id="grupo-solidario-hash">3</div>
                                    <div class="col s12 l4 hide-on-med-and-down nombreg truncate" id="nombre-grupo">Observaciones por fecha</div>
                                    <div class="col s12 l4 hide-on-med-and-down integrantesg truncate">Observaciones por fecha</div>
                                    <div class="col s12 l3 hide-on-med-and-down integrantesg truncate center">
                                        <a class="waves-effect waves-light" href="#!" id="btn-generar-reporte-observaciones-fecha"><i class="material-icons green-text">file_download</i></a>
                                    </div>
                                </div>
                            </li> -->
                            
                        </ul>

                        <ul id="pag-control" class="pag pagination">
                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div id="modal-reporte" class="modal modal-fixed-footer modal-max-width">
    <div class="modal-content">
        <h4 class="light blue-text">Reporte de Devoluciones</h4>
        <div class="row">
            <div class="input-field col s12">
                <select id="departamento-select" class="input-modal-element">
                    <option value="" disabled selected>Elija el departamento</option>
                    <option value="Call Center">Call Center</option>
                    <option value="Control de Calidad">Control de Calidad</option>
                </select>
                <label>Departamento</label>
            </div>
            <div class="input-field col s6">
                <input type="text" id="fecha-antes" class="calendar input-modal-element" placeholder="yyyy-mm-dd"/>
                <label for="fecha-antes" class="active">Desde</label>
            </div>
            <div class="input-field col s6">
                <input type="text" id="fecha-despues" class="calendar input-modal-element" placeholder="yyyy-mm-dd"/>
                <label for="fecha-despues" class="active">Hasta</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">

        <a href="#!" class="btn-flat modal-action modal-btn-loader" id="modal-btn-loader">
            <div class="preloader-wrapper small active right modal-spinner-action">
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
        </a>
        
        <a href="#!" class="modal-action waves-effect waves-green btn-flat blue-text" id="btn-generar-devoluciones">Generar</a>
    </div>
</div>

<!-- Modal Structure -->
<div id="modalObservacionesGrupos" class="modal modal-fixed-footer modal-max-width">
    <div class="modal-content">
        <h4 class="light blue-text">Observaciones de Grupos</h4>
        
        <div class="row">
            <div class="col l12 m12 s12">
                <p>Tipo de reporte</p>
                <p>
                    <input name="groupTipoReporte" type="radio" id="grupo" value="0"/>
                    <label for="grupo">Por grupo</label>
                </p>
                <p>
                    <input name="groupTipoReporte" type="radio" id="fechas" value="1"/>
                    <label for="fechas">Rango de fechas</label>
                </p>
            </div>
            <div class="col l12 m12 s12 complement" id="hashContainer">
                <p>Grupo Hash</p>
                <div class="input-field">
                    <input value="" id="hash" type="text" class="validate" placeholder="Digite el Hash">
                </div>
            </div>
            <div class="col l12 m12 s12 complement" id="fechasContainer">
                <p>Rango de fechas</p>
                <div class="input-field">
                    <input type="text" class="calendar" id="fechaDesde" placeholder="Fecha desde">
                    <input type="text" class="calendar" id="fechaHasta" placeholder="Fecha hasta">
                </div>
            </div>                
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="btn-flat modal-action modal-btn-loader" id="modal-btn-loader">
            <div class="preloader-wrapper small active right modal-spinner-action">
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
        </a>
        <a href="#!" class="modal-action waves-effect waves-green btn-flat blue-text" id="btn-generar-observaciones">Generar</a>
    </div>
</div>
<script src="../js/plugins/pignose-datepicker/dist/moment.min.js"></script>
<script src="../js/plugins/pignose-datepicker/dist/pignose.calendar.js"></script>

<script>

$(document).ready(function() {

    $('.complement').hide();

    window.identidades = [];

    window.current = {
        hash: ''  
    };    

    window.grupos = [];

    $('input.calendar').pignoseCalendar({
        lang: 'es',
		format: 'YYYY-MM-DD' // date format string. (2017-02-02)
	});

    $('.modal-btn-loader').hide();

    $('#breadcrum-title').text('Redimir Créditos');
    
    $('select').material_select();

    $('.tooltipped').tooltip({delay: 50});

    $('.modal').modal();

    $('.collapsible').collapsible();

    $('#btn-generar-reporte-devoluciones').click(function(){
        $('.input-modal-element').each(function(){
            if($(this).attr('id') == 'departamento-select'){
                $(this).val('').material_select();
            }else{
                $(this).val('');
            }
        });
        $('#modal-reporte').modal('open');
    });

    // Para el reporte 1
    $('#btn-generar-devoluciones').click(function(){

        var auxthis = $(this);
        auxthis.parent().find('#modal-btn-loader').show();
        auxthis.hide();

        var obj = {
            departamento: $('#departamento-select').val(),
            desde: $('#fecha-antes').val(),
            hasta: $('#fecha-despues').val()
        }

        $.ajax({
            type: 'POST',
            url: '../php/auxiliar-creditos/reporte-devoluciones.php',
            data: 'data='+JSON.stringify(obj),
            success: function(data){
                console.log(data);
                window.open(data, '_blank');
                swal('Generado correctamente');
                $('#modal-reporte').modal('close');
                auxthis.parent().find('#modal-btn-loader').hide();
                auxthis.show();
            }
        });

    });

    $('#btn-generar-reporte-observaciones').click(function(){
        $('#modalObservacionesGrupos').modal('open');
    });

    $('input[name="groupTipoReporte"]').change(function(){
        $('.complement').hide();
        if($(this).val() == '0'){
            $('#hashContainer').show();
        }else if($(this).val() == '1'){
            $('#fechasContainer').show();
        }
    });

    // Para el reporte 2
    $('#btn-generar-observaciones').click(function(){

        if(!$('input[name="groupTipoReporte"]').val()){
            Materialize.toast('Seleccione el tipo de reporte', 2000);
            return false;
        }

        if($('input[name="groupTipoReporte"]:checked').val() == '0'){
            if($('#hash').val() == ''){
                Materialize.toast('Ingrese el Hash', 2000);
                return false;
            }
        }
        if($('input[name="groupTipoReporte"]:checked').val() == '1'){
            if($('#fechaDesde').val() == '' || $('#fechaHasta').val() == ''){
                Materialize.toast('Ingrese el rango de fechas completo', 2000);
                return false;
            }
        }

        var auxthis = $(this);
        auxthis.parent().find('#modal-btn-loader').show();
        auxthis.hide();

        var obj = {
            tipo: $('input[name="groupTipoReporte"]:checked').val(),
            hash: $('#hash').val(),
            fechaInicial: $('#fechaDesde').val(),
            fechaFinal: $('#fechaHasta').val()
        }

        console.log(obj);

        $.ajax({
            type: 'POST',
            url: '../php/auxiliar-creditos/reporte-observaciones.php',
            data: obj,
            success: function(data){
                console.log(data);
                window.open(data, '_blank');
                swal('Generado correctamente');
                $('#modalObservacionesGrupos').modal('close');
                auxthis.parent().find('#modal-btn-loader').hide();
                auxthis.show();
            }
        });
    });

    var options = {
        page: 6,
        pagination: true,
        valueNames: [ 'codigog', 'nombreg' ],
        fuzzySearch: {
            searchClass: "fuzzy-search",
            location: 0,
            distance: 100,
            threshold: 0.2,
            multiSearch: true
        }
    };

    window.listObj = new List('lista-grupos', options);

});

</script>