<?php 

require '../php/conection.php';

session_start();

$user = $_SESSION['user'];

$getCoordinadores = $conn->prepare('select nombre, id from gsc where tipoEmpleado = "Coordinador"');
$getCoordinadores->execute();
$coordinadores = $getCoordinadores->fetchAll(PDO::FETCH_ASSOC);

$getSupervisores = $conn->prepare('select nombre, id from gsc where tipoEmpleado = "Supervisor"');
$getSupervisores->execute();
$supervisores = $getSupervisores->fetchAll(PDO::FETCH_ASSOC);

$getGestores = $conn->prepare('select nombre, id from gsc where tipoEmpleado = "Gestor"');
$getGestores->execute();
$gestores = $getGestores->fetchAll(PDO::FETCH_ASSOC);

//var_dump($supervisores);

?>


<div class="section">
    <div class="row">
        <div class="col s12 l4">
            <select class="js-example-data-array js-states browser-default" tabindex="-1" style="width: 100%" id="coordinadoresSelect">
                <option value=""></option>
                <?php $i=0;?>
                    <?php if(count($coordinadores) > 0):?>
                        <?php foreach($coordinadores as $coordinador):?>
                            <?php $i++;?>
                            <option value="<?php echo $coordinador['id']; ?>"><?php echo $coordinador['nombre']; ?></option>
                        <?php endforeach;?>
                    <?php endif;?>
            </select>
        </div>
        <div class="col s12 l4">
            <select class="js-example-data-array js-states browser-default" tabindex="-1" style="width: 100%" id="supervisoresSelect">
                <option value=""></option>
                <?php $i=0;?>
                    <?php if(count($supervisores) > 0):?>
                        <?php foreach($supervisores as $supervisor):?>
                            <?php $i++;?>
                            <option value="<?php echo $supervisor['id']; ?>"><?php echo $supervisor['nombre']; ?></option>
                        <?php endforeach;?>
                    <?php endif;?>
            </select>
        </div>
        <div class="col s12 l4">
            <select class="js-example-data-array js-states browser-default" tabindex="-1" style="width: 100%" id="asesoresSelect">
                <option value=""></option>
                <?php $i=0;?>
                            <?php if(count($gestores) > 0):?>
                                <?php foreach($gestores as $gestor):?>
                                    <?php $i++;?>
                                    <option value="<?php echo $gestor['id']; ?>"><?php echo $gestor['nombre']; ?></option>
                                <?php endforeach;?>
                            <?php endif;?>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col s12 m12 l12">
            <div id="work-collapsible">
                    <div class="row">
                        <div class="col s12" id="todos-los-creditos">
                            <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                <li class="collapsible-item-header avatar">
                                    <i class="material-icons circle light-blue">list</i>
                                    <span class="collapsible-title-header"><span id="titutloNombre"></span>
                                        <div class="secondary-content actions hide-on-med-and-down">
                                            <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                            <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                <i class="material-icons center-align">search</i>
                                            </a> 
                                            <a id="desactivarLista" class="dropdown-button waves-effect waves-light btn-flat nopadding" data-activates='dropdown_listOrder'>
                                                <i class="material-icons center-align">sort</i>
                                            </a>
                                        </div>
                                    </span>
                                    <p>cartera de: <span id="descripcionNombre"><?php echo "- - -";?></span></p>
                                </li>
                                <div id="headersList"></div>
                                
                                <div class="list collapsible no-padding no-margin z-depth-0">
                                    
                                    
                                    <li id="nohaynada" class="center">
                                        <h5>No hay Resultados</h5>
                                    </li>
                                    
                                </div>
                                <li>
                                    <div class="collapsible-footer  sin-icon" style="border-bottom: 1px solid #e0e0e0; line-height: 30px;">
                                        <div class="row">
                                            <span class="right">total: <span  id="cantidadderegistros"> 0</span> registros</span>
                                            <ul id="pag-control" class="pag pagination">
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


<script src="../js/plugins/numeral/numeral.js"></script>
<script>

$(document).ready(function(){
    
    $('select').select2();
    $('.collapsible').collapsible();
    
    window.coordinadores = "";
    window.asesorSeleccionado = false;
    
    $('.icon-collapse-search').click(function () {
        $('.search-expandida').toggleClass('expanded');
        $('.search-expandida').focus();
    });
    
    var options = {
        valueNames: [ 'nombre' ],
        fuzzySearch: {
            searchClass: "fuzzy-search",
            location: 0,
            distance: 100,
            threshold: 0.2,
            multiSearch: true
        }
    };
    window.listObj = new List('todos-los-creditos', options);
 
    
    //////////////////////////////////////////////////// COORDINADORES //////////////////////////////////////////////////
    
    $("#coordinadoresSelect").select2({
        placeholder: 'Seleccione un coordinador',
        //data: data,
    });
    
    $("#coordinadoresSelect").on('change', function(){
        window.nombreCoordinador = $('#coordinadoresSelect option:selected').text();
        window.idCoordinador = $('#coordinadoresSelect option:selected').val();
        //console.log('Nombre: '+ window.nombreCoordinador + ' id: ' +window.idCoordinador);
        
        //AJAX PARA CARGAR SELECT2 DE SUPERVISORES DEL COORDINADOR
        $.ajax({
            type: 'POST',
            async: true,
            data: {
                id_coordinador_list: window.idCoordinador
            },
            url: 'filtrosCarteras/poblarSelects.php', 
            success: function(data){
                var listSupervisor = JSON.parse(data);
                //console.log(listSupervisor);
                if(listSupervisor.length > 0){
                    //$('#asesoresSelect').empty();
                    $('#supervisoresSelect').empty();
                    $('#supervisoresSelect').append(`<option value=""></option>`);
                    $.each(listSupervisor, function(index, value){
                        $('#supervisoresSelect').append(`
                            <option value=`+value.id+`>`+value.nombre+`</option>
                        `);
                    });
                    
                    /*$("#asesoresSelect").select2({
                        placeholder: 'Seleccione un asesor',
                    });*/
                    
                    $("#supervisoresSelect").select2({
                        placeholder: 'Seleccione un supervisor',
                        //data: data,
                    });
                } else {
                    $('#supervisoresSelect').empty();
                    $('#supervisoresSelect').append(`
                            <option value=`+""+`>`+"Vacío"+`</option>
                    `);
                    $("#supervisoresSelect").select2({
                        placeholder: 'Seleccione un supervisor',
                        //data: data,
                    });
                    $('#headersList').empty();
                    
                    $('.list').empty();
                    $('.list').append(`<li id="nohaynada" class="center">
                                        <h5>No hay Resultados</h5>
                                    </li>`);
                    $('#cantidadderegistros').text("0");
                    $('#titutloNombre').text("no se encontraron registros");
                    $('#descripcionNombre').text("lista vacía");
                }
            }
        });
        
        //ESTA PETICION AJAX ES PARA CARGAR EL SELECT2 DE ASESORES DEL COORDINADOR
        $.ajax({
            type: 'POST',
            async: true,
            data: {
                id_coordinador_list_asesores: window.idCoordinador
            },
            url: 'filtrosCarteras/poblarSelects.php', 
            success: function(data){
                var listAsesores = JSON.parse(data);
                //console.log(listAsesores);
                if(listAsesores.length > 0){
                    //$('#asesoresSelect').empty();
                    $('#asesoresSelect').empty();
                    $('#asesoresSelect').append(`<option value=""></option>`);
                    $.each(listAsesores, function(index, value){
                        $('#asesoresSelect').append(`
                            <option value=`+value.id+`>`+value.nombre+`</option>
                        `);
                    });
                    
                    /*$("#asesoresSelect").select2({
                        placeholder: 'Seleccione un asesor',
                    });*/
                    
                    $("#asesoresSelect").select2({
                        placeholder: 'Seleccione un asesor',
                        //data: data,
                    });
                } else {
                    $('#asesoresSelect').empty();
                    $('#asesoresSelect').append(`
                            <option value=`+""+`>`+"Vacío"+`</option>
                    `);
                    $("#asesoresSelect").select2({
                        placeholder: 'Seleccione un supervisor',
                        //data: data,
                    });
                    $('#headersList').empty();
                    $('.list').empty();
                    $('.list').append(`<li id="nohaynada" class="center">
                                        <h5>No hay Resultados</h5>
                                    </li>`);
                    $('#cantidadderegistros').text("0");
                    $('#titutloNombre').text("no se encontraron registros");
                    $('#descripcionNombre').text("lista vacía");
                    
                }
            }
        });
        
        $('#loading').show();
        
        $.ajax({
            type: 'POST',
            data: {
                id_coordinador_cartera: window.idCoordinador
            },
            url: 'filtrosCarteras/poblarSelects.php', 
            success: function(data){
                $('#loading').hide();
                var listCarteraCoordinador = JSON.parse(data);
                //console.log(listCarteraCoordinador);
                
                if(listCarteraCoordinador.length > 0){
                    $('#headersList').empty();
                    $('#headersList').append(`
                        <li>
                            <div class="collapsible-header-titles  sin-icon">
                                <div class="row">
                                    <div class="col s8 m3 l3">
                                        <p class="collapsible-title">Nombre</p>
                                    </div>
                                    <div class="col s3 m3 l2 hide-on-small-only">
                                        <p class="collapsible-title">Créditos</p>
                                    </div>
                                    <div class="col s3 m3 l2">
                                        <p class="collapsible-title">Porcentaje Mora</p>
                                    </div>
                                    <div class="col s3 m3 l3 hide-on-small-only">
                                        <p class="collapsible-title">Mora</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only">
                                        <p class="collapsible-title">Agencia</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `);
                    
                    $('.list').empty();
                    
                    $.each(listCarteraCoordinador, function(index, value){
                        $('.list').append(
                        `<li>
                            <div class="collapsible-header sin-icon">
                                <div class="row">
                                    <div class="col s8 m3 l3">
                                        <p class="nombre collapsible-content truncate">`+value.Supervisor+`</p>
                                    </div>
                                    <div class="col s3 m3 l2 hide-on-small-only">
                                        <p class="collapsible-content truncate tooltipped" data-position="bottom" data-delay="50" data-tooltip="`+'Ciclo 1: '+value.cantidad_ciclo1+', Ciclo 2: '+value.cantidad_ciclo2+', Ciclo 3: '+value.cantidad_ciclo3+`">`+value.creditos+`</p>
                                    </div>
                                    <div class="col s3 m3 l2">
                                        <p class="collapsible-content truncate">`+numeral(value.porcentajeMora).format('0.00%')+"%"+`</p>
                                    </div>
                                    <div  class="col s3 m3 l3  light truncate hide-on-small-only">
                                        <p class="collapsible-content">`+"L. "+numeral(value.capitalMora).format('$0,0.00')+`</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only light truncate">
                                        <p class="collapsible-content">`+value.agencia+`</p>
                                    </div>
                                </div>
                            </div>
                            <div class="collapsible-body">
                                <div class="row">
                                    <div class="col l6 m6 s12">
                                        <p><b>Cantidad de Créditos: </b>`+numeral(value.creditos).format('0')+`</p>
                                        <p><b>Ciclo 1: </b>`+numeral(value.cantidad_ciclo1).format('0')+`</p>
                                        <p><b>Ciclo 2: </b>`+numeral(value.cantidad_ciclo2).format('0')+`</p>
                                        <p><b>Ciclo 3: </b>`+numeral(value.cantidad_ciclo3).format('0')+`</p>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <p><b>Monto Desembolsado: </b>`+"L. "+numeral(value.montoDesembolsado).format('$0,0.00')+`</p>
                                        <p><b>Saldo Capital: </b>`+"L. "+numeral(value.saldoCapital).format('$0,0.00')+`</p>
                                        <p><b>Capital en Mora: </b>`+"L. "+numeral(value.capitalMora).format('$0,0.00')+`</p>
                                        <p><b>Porcentaje de Mora: </b>`+numeral(value.porcentajeMora).format('0.00%')+"%"+`</p>
                                    </div>
                                </div>
                            </div>
                        </li>`
                        );
                    });
                    $('.tooltipped').tooltip({delay: 50});
                    $('#cantidadderegistros').text(listCarteraCoordinador.length);
                    $('#titutloNombre').text(window.nombreCoordinador);
                    $('#descripcionNombre').text(window.nombreCoordinador);
                } else {
                    
                    /////////////////////////////////////////////////////////////////////
                    
                    $.ajax({
                        type: 'POST',
                        data: {
                            id_coordinador_cartera_asesores: window.idCoordinador
                        },
                        url: 'filtrosCarteras/poblarSelects.php', 
                        success: function(data){
                            $('#loading').hide();
                            //alert(window.idCoordinador);
                            var listCarteraCoordinador = JSON.parse(data);
                            //console.log(data);

                            if(listCarteraCoordinador.length > 0){
                                $('#headersList').empty();
                                $('#headersList').append(`
                                    <li>
                                                <div class="collapsible-header-titles  sin-icon">
                                                    <div class="row">
                                                        <div class="col s8 m3 l3">
                                                            <p class="collapsible-title">Nombre</p>
                                                        </div>
                                                        <div class="col s3 m3 l2 hide-on-small-only">
                                                            <p class="collapsible-title">Créditos</p>
                                                        </div>
                                                        <div class="col s3 m3 l2">
                                                            <p class="collapsible-title">Mora</p>
                                                        </div>
                                                        <div class="col s3 m3 l3 hide-on-small-only">
                                                            <p class="collapsible-title">Desembolsado</p>
                                                        </div>
                                                        <div class="col s6 m3 l2 hide-on-small-only">
                                                            <p class="collapsible-title">Agencia</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                `);

                                $('.list').empty();

                                $.each(listCarteraCoordinador, function(index, value){
                                    $('.list').append(
                                    `<li>
                                        <div class="collapsible-header sin-icon">
                                            <div class="row">
                                                <div class="col s8 m3 l3">
                                                    <p class="nombre collapsible-content truncate">`+value.gestor+`</p>
                                                </div>
                                                <div class="col s3 m3 l2 hide-on-small-only">
                                                    <p class="collapsible-content truncate">`+value.creditos+`</p>
                                                </div>
                                                <div class="col s3 m3 l2">
                                                    <p class="collapsible-content truncate">`+numeral(value.porcentajeMora).format('0.00%')+"%"+`</p>
                                                </div>
                                                <div  class="col s3 m3 l3  light truncate hide-on-small-only">
                                                    <p class="collapsible-content">`+"L. "+numeral(value.montoDesembolsado).format('$0,0.00')+`</p>
                                                </div>
                                                <div class="col s6 m3 l2 hide-on-small-only light truncate">
                                                    <p class="collapsible-content">`+value.agencia+`</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapsible-body">
                                            <p><b>Cantidad de Créditos: </b>`+numeral(value.creditos).format('00')+`</p>
                                           <p><b>Saldo Capital: </b>`+"L. "+numeral(value.saldoCapital).format('$0,0.00')+`</p>
                                           <p><b>Capital en Mora: </b>`+"L. "+numeral(value.capitalMora).format('$0,0.00')+`</p>
                                           <p><b>Porcentaje de Mora: </b>`+numeral(value.porcentajeMora).format('0.00%')+"%"+`</p>
                                        </div>
                                    </li>`
                                    );
                                });
                                $('#cantidadderegistros').text(listCarteraCoordinador.length);
                                $('#titutloNombre').text(window.nombreCoordinador);
                                $('#descripcionNombre').text(window.nombreCoordinador);
                            } 

                        }
                    });
                    
                    /////////////////////////////////////////////////////////////////////
                    
                }
            }
        });

    });
    
    /////////////////////////////////////////////////// SUPERVISORES /////////////////////////////////////////////////////
    
    $("#supervisoresSelect").select2({
        placeholder: 'Seleccione un supervisor',
        //data: data,
    });
    
    $("#supervisoresSelect").on('change', function(){
        window.nombreSupervisor = $('#supervisoresSelect option:selected').text();
        window.idSupervisor = $('#supervisoresSelect option:selected').val();
        //console.log('Nombre: '+ window.nombreSupervisor + ' id: ' +window.idSupervisor);
        $('#loading').show();
        
        $.ajax({
            type: 'POST',
            async: true,
            data: {
                id_supervisor_list: window.idSupervisor
            },
            url: 'filtrosCarteras/poblarSelects.php', 
            success: function(data){
                $('#loading').hide();
                var listAsesor = JSON.parse(data);
                //console.log(listAsesor);
                if(listAsesor.length > 0){
                    $('#asesoresSelect').empty();
                    $('#asesoresSelect').append(`<option value=""></option>`);
                    $.each(listAsesor, function(index, value){
                        $('#asesoresSelect').append(`
                            <option value=`+value.id+`>`+value.nombre+`</option>
                        `);
                    });
                    $("#asesoresSelect").select2({
                        placeholder: 'Seleccione un asesor',
                        //data: data,
                    });
                }else {
                    $('#asesoresSelect').append(`
                            <option value=`+""+`>`+"Vacío"+`</option>
                    `);
                    $("#asesoresSelect").select2({
                        placeholder: 'Seleccione un supervisor',
                        //data: data,
                    });
                    $('#headersList').empty();
                    $('.list').empty();
                    $('.list').append(`<li id="nohaynada" class="center">
                                        <h5>No hay Resultados</h5>
                                    </li>`);
                    $('#cantidadderegistros').text("0");
                    $('#titutloNombre').text("no se encontraron registros");
                    $('#descripcionNombre').text("lista vacía");
                    
                }
            }
        });
        
        $.ajax({
            type: 'POST',
            async: true,
            data: {
                id_supervisor_cartera: window.idSupervisor
            },
            url: 'filtrosCarteras/poblarSelects.php', 
            success: function(data){
                var listCarteraSupervisor = JSON.parse(data);
                //console.log(listAsesor);
                
                if(listCarteraSupervisor.length > 0){
                    $('#headersList').empty();
                    $('#headersList').append(`
                        <li>
                            <div class="collapsible-header-titles  sin-icon">
                                <div class="row">
                                    <div class="col s8 m3 l3">
                                        <p class="collapsible-title">Nombre</p>
                                    </div>
                                    <div class="col s3 m3 l2 hide-on-small-only">
                                        <p class="collapsible-title">Créditos</p>
                                    </div>
                                    <div class="col s3 m3 l2">
                                        <p class="collapsible-title">Porcentaje Mora</p>
                                    </div>
                                    <div class="col s3 m3 l3 hide-on-small-only">
                                        <p class="collapsible-title">Mora</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only">
                                        <p class="collapsible-title">Agencia</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `);
                    
                    $('.list').empty();
                    
                    $.each(listCarteraSupervisor, function(index, value){
                        $('.list').append(
                        `<li>
                            <div class="collapsible-header sin-icon">
                                <div class="row">
                                    <div class="col s8 m3 l3">
                                        <p class="nombre collapsible-content truncate">`+value.gestor+`</p>
                                    </div>
                                    <div class="col s3 m3 l2 hide-on-small-only">
                                        <p class="collapsible-content truncate tooltipped" data-position="bottom" data-delay="50" data-tooltip="`+'Ciclo 1: '+value.cantidad_ciclo1+', Ciclo 2: '+value.cantidad_ciclo2+', Ciclo 3: '+value.cantidad_ciclo3+`">`+value.creditos+`</p>
                                    </div>
                                    <div class="col s3 m3 l2">
                                        <p class="collapsible-content truncate">`+numeral(value.porcentajeMora).format('0.00%')+"%"+`</p>
                                    </div>
                                    <div  class="col s3 m3 l3  light truncate hide-on-small-only">
                                        <p class="collapsible-content">`+"L. "+numeral(value.saldoCapital).format('$0,0.00')+`</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only light truncate">
                                        <p class="collapsible-content">`+value.agencia+`</p>
                                    </div>
                                </div>
                            </div>
                            <div class="collapsible-body">
                                <div class="row">
                                    <div class="col l6 m6 s12">
                                        <p><b>Cantidad de Créditos: </b>`+numeral(value.creditos).format('0')+`</p>
                                        <p><b>Ciclo 1: </b>`+numeral(value.cantidad_ciclo1).format('0')+`</p>
                                        <p><b>Ciclo 2: </b>`+numeral(value.cantidad_ciclo2).format('0')+`</p>
                                        <p><b>Ciclo 3: </b>`+numeral(value.cantidad_ciclo3).format('0')+`</p>
                                    </div>
                                    <div class="col l6 m6 s12">
                                        <p><b>Monto Desembolsado: </b>`+"L. "+numeral(value.montoDesembolsado).format('$0,0.00')+`</p>
                                        <p><b>Saldo Capital: </b>`+"L. "+numeral(value.saldoCapital).format('$0,0.00')+`</p>
                                        <p><b>Capital en Mora: </b>`+"L. "+numeral(value.capitalMora).format('$0,0.00')+`</p>
                                        <p><b>Porcentaje de Mora: </b>`+numeral(value.porcentajeMora).format('0.00%')+"%"+`</p>
                                    </div>
                                </div>
                            </div>
                        </li>`
                        );
                    });
                    $('.tooltipped').tooltip({delay: 50});
                    $('#cantidadderegistros').text(listCarteraSupervisor.length);
                    $('#titutloNombre').text(window.nombreSupervisor);
                    $('#descripcionNombre').text(window.nombreSupervisor);
                }
            }
        });
    });
    
    ///////////////////////////////////////////////////// ASESORES /////////////////////////////////////////////////////////////
    
    $("#asesoresSelect").select2({
        placeholder: 'Seleccione un asesor',
        //data: data,
    });
    
    $("#asesoresSelect").on('change', function(){
        window.nombreAsesor = $('#asesoresSelect option:selected').text();
        window.idAsesor = $('#asesoresSelect option:selected').val();
        window.asesorSeleccionado = true;
        //console.log('Nombre: '+ window.nombreAsesor + ' id: ' +window.idAsesor);
        $('#loading').show();
        
        $.ajax({
                type: 'POST',
                data: {
                        asesor_list: window.nombreAsesor,
                        id_asesor_list: window.idAsesor
                      },
                url: 'filtrosCarteras/poblarSelects.php', 
                success: function(data){
                    $('#loading').hide();
                   // console.log(data);
                    var datosAsesor = JSON.parse(data);
                    console.log(datosAsesor);
                    if(data.length > 0){
                         $('#nohaynada').hide();
                    }
                    
                    $('#headersList').empty();
                    
                    if(window.asesorSeleccionado){
                        $('#headersList').append(`
                        <li>
                            <div class="collapsible-header-titles  sin-icon">
                                <div class="row">
                                    <div class="col s4 m3 l2">
                                        <p class="collapsible-title">Identidad</p>
                                    </div>
                                    <div class="col s5 m3 l3">
                                        <p class="collapsible-title">Nombre</p>
                                    </div>
                                    <div class="col s3 m3 l2">
                                        <p class="collapsible-title">Mora</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only">
                                        <p class="collapsible-title">Saldo Capital</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only">
                                        <p class="collapsible-title">Capital Mora</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `);
                        
                    $('.list').empty();
                        
                    for(var i = 0; i < datosAsesor.length; i++){
                        $('.list').append(
                        `<li>
                            <div class="collapsible-header sin-icon">
                                <div class="row">
                                    <div class="col s4 m3 l2">
                                        <p class="collapsible-content truncate">`+datosAsesor[i].Identidad+`</p>
                                    </div>
                                    <div class="col s5 m3 l3">
                                        <p class="nombre collapsible-content truncate">`+datosAsesor[i].Nombre_Completo+`</p>
                                    </div>
                                    <div  class="col s3 m3 l2  light truncate">
                                        <p class="collapsible-content">`+numeral(datosAsesor[i].mora).format('0.0%')+'%' +`</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only light truncate">
                                        <p class="collapsible-content">`+"L. " +numeral(datosAsesor[i].saldo_capital).format('$0,0.00')+`</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only light truncate">
                                        <p class="collapsible-content">`+"L. " +numeral(datosAsesor[i].capital_mora).format('$0,0.00')+`</p>
                                    </div>
                                </div>
                            </div>
                            <div class="collapsible-body">
                               <p class="hide-on-large-only"><b>Identidad: </b>`+datosAsesor[i].Identidad+`</p>
                               <p class="hide-on-large-only"><b>Nombre: </b>`+datosAsesor[i].Nombre_Completo+`</p>
                               <p><b>Dirección del Domicilio: </b>`+datosAsesor[i].Direccion+`</p>
                                <p><b>Dirección del Negocio: </b>`+datosAsesor[i].Negocio+`</p>
                                <p><b># Prestamo: </b>`+datosAsesor[i].Numero_Prestamo+`</p>
                                <p><b>Saldo Capital: </b>`+"L. " +numeral(datosAsesor[i].saldo_capital).format('$0,0.00')+`</p>
                                <p><b>Capital Mora: </b>`+"L. " +numeral(datosAsesor[i].capital_mora).format('$0,0.00')+`</p>
                                <p><b>% Mora: </b>`+numeral(datosAsesor[i].mora).format('0.00%')+"%"+`</p>
                            </div>
                        </li>`
                        );
                    }
                        
                    $('#cantidadderegistros').text(datosAsesor.length);
                    $('#titutloNombre').text(window.nombreAsesor);
                    $('#descripcionNombre').text(window.nombreAsesor);
                }
            }
        });
    });
    
});

</script>