<?php 

require '../../php/conection.php';

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

//query para obtener las metas para coordinadores
$getMetasDeCoordinadores = $conn->prepare('
select SPLIT_STRING(" ", b.nombre, 1) as nombre, a.creditos, a.metaCreditos, a.colocacion, a.metaColocacion, a.recuperacion, a.metaRecuperacion
from metas a, gsc b
where a.tipoEmpleado = "coordinador" and a.idUsuario = b.id
');
$getMetasDeCoordinadores->execute();
$metaDelCoordinador = $getMetasDeCoordinadores->fetchAll(PDO::FETCH_ASSOC);

//var_dump($metaDelCoordinador);

$nombresDeCoordinador = [];
$metaCreditosCoor = [];
$metaColocacionCoor = [];
$metaRecuperacionCoor = [];
foreach($metaDelCoordinador as $metaCoor){
    $nombresDeCoordinador[] = $metaCoor['nombre'];
    
    $metaCreditosCoor[] = division($metaCoor['creditos'], $metaCoor['metaCreditos'] == null ? '0' : $metaCoor['metaCreditos']);
    $metaColocacionCoor[] = division($metaCoor['colocacion'], $metaCoor['metaColocacion'] == null ? '0' : $metaCoor['metaColocacion']);
    $metaRecuperacionCoor[] = division($metaCoor['recuperacion'], $metaCoor['metaRecuperacion'] == null ? '0' : $metaCoor['metaRecuperacion']);
}

function division($a, $b) {         
    if($b == 0)
      return 0;

    return ($a/$b)*100;
}

//var_dump($supervisores);

?>


<link rel="stylesheet" href="metas/c3.css">

<div class="section">
    <h4 class="header">Elija un Coordinador, Supervisor o Asesor</h4>
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
</div>

<div class="section">
    <div class="row">
        <div id="infoAlertEmpty" class="col s12 l12">
            <div id="work-collapsible">
                <div class="row">
                    <div class="col s12">
                        <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                            <li>
                                <div class="collapsible-header active" style="border-bottom: 0px solid #ddd; */"><i class="material-icons">pie_chart</i>Metas por Departamentos</div>
                                <div class="collapsible-body" style="border-bottom: 0px solid #ddd;">
                                    <canvas class="hide-on-small-only" id="myChart" width="224" height="75"></canvas>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="infoAlertUsuario" class="col s12 l10 offset-l1 hide">
            <div id="card-alert" class="card blue">
                <div class="card-content white-text">
                    <p>INFO : Detalles de mas metas del coordinador: ######.</p>
                </div>
                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
    </div>
    
</div>

<div class="section">
    <div id="card-stats" class="row">
        <div class="col s12 m6 l3">
            <div class="card graphCard">
                <div id="cDesembolsos" class="card-content">
                    <span class="card-title white-text">Meta de Desembolso</span>
                    <!--<div class="divider"></div><br>-->
                    <!--<div id="chartcolocacion"></div>-->
                    <div class="chartc3" id="chart1"></div>
                </div>
                <div class="card-action">
                    <div class="row" style="padding-left: 15px; padding-right: 10px">
                        <span class="grey-text">Total de meta: 
                            <span class="metamensual" id="cDesembolsosMonto">0</span>
                            <a class="botonEditarMetaCoor" href="#!" id="modalmetadesembolsos"><i class="material-icons right grey-text">more_vert</i></a>
                        </span>
                    </div>
                    <div class="row" style="padding-left: 15px; padding-right: 10px">
                        <h3 id="desembolsosAFecha" class="montoafecha" style="    display: inline;">0</h3>
                        <i class="material-icons grey-text">trending_up</i> 
                        <span class="grey-text" style="font-size:14px">desembolsados</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3">
            <div class="card graphCard">
                <div id="cColocacion" class="card-content">
                    <span class="card-title white-text">Meta de Colocación</span>
                    <!--<div class="divider"></div><br>-->
                    <!--<div id="chartcolocacion"></div>-->
                    <div class="chartc3" id="chart2"></div>
                </div>
                <div class="card-action">
                    <div class="row" style="padding-left: 15px; padding-right: 10px">
                        <span class="grey-text">Total de meta: 
                        <span class="metamensual" id="cColocacionMonto">0</span>
                        <a class="botonEditarMetaCoor" href="#!" id="modalmetacolocacion"><i class="material-icons right grey-text">more_vert</i></a>
                        </span>
                    </div>
                    <div class="row" style="padding-left: 15px; padding-right: 10px">
                        <h3 id="colocacionAFecha" class="montoafecha" style="display: inline;">0</h3>
                        <i class="material-icons grey-text">trending_up</i> 
                        <span class="grey-text" style="font-size:14px">colocados</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3">
            <div class="card graphCard">
                <div id="cRecuperacion" class="card-content">
                    <span class="card-title white-text">Meta Recuperación</span>
                    <!--<div class="divider"></div><br>-->
                    <!--<div id="chartcolocacion"></div>-->
                    <div class="chartc3" id="chart3"></div>
                </div>
                <div class="card-action">
                    <div class="row" style="padding-left: 15px; padding-right: 10px">
                        <span class="grey-text">Total de meta: 
                        <span class="metamensual" id="cRecuperacionMonto">0</span>
                        <a class="botonEditarMetaCoor" href="#!" id="modalmetarecuperacion"><i class="material-icons right grey-text">more_vert</i></a>
                        </span>
                    </div>
                    <div class="row" style="padding-left: 15px; padding-right: 10px">
                        <h4 id="recuperacionAFecha" class="montoafecha" style="display: inline;">0</h4>
                        <i class="material-icons grey-text">trending_up</i> 
                        <span class="grey-text truncate" style="font-size:14px">recuperados</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3">
            <div class="card graphCard">
                <div id="cMora" class="card-content">
                    <span class="card-title white-text">Porcentaje Mora</span>
                    <!--<div class="divider"></div><br>-->
                    <!--<div id="chartcolocacion"></div>-->
                    <div class="chartc3" id="chart4"></div>
                </div>
                <div class="card-action">
                    <div class="row" style="padding-left: 15px; padding-right: 10px">
                        <span class="grey-text">Total de meta: 
                        <span class="metamensual" id="cMoraMonto">0</span>
                        <a class="botonEditarMetaCoor" href="#!" id="modalmetamora"><i class="material-icons right grey-text">more_vert</i></a>
                        </span>
                    </div>
                    <div class="row" style="padding-left: 15px; padding-right: 10px">
                        <h4 id="moraAFecha" class="montoafecha" style="display: inline;">0</h4>
                        <i class="material-icons grey-text">trending_up</i> 
                        <span class="grey-text" style="font-size:14px">mora</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tablaMetas" class="section">
    <div class="row">
        <div class="col s12">
            <div id="work-collections" class="">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                            <ul id="projects-collection" class="collection z-depth-1">
                                <li class="collection-item avatar">
                                    <i class="material-icons circle light-blue ">list</i>
                                    <span class="collection-header">Detalles de las Metas</span>
                                    <p>lista de <span id="tipoEmpleadoSubTitle">Supervisores</span> de: <span id="nombreDelSuperiorSubTitle">Coordinador</span></p>
                                    <div class="secondary-content actions">
                                        <!--<input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                        <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                            <i class="material-icons center-align">search</i>
                                        </a>-->
                                        <form action="" method="" id="">
                                            <input type="hidden" name="user_id" id="hidden_id" value="">
                                            <button type="submit" class="waves-effect btn-flat nopadding"><i class="material-icons">description</i></button>
                                        </form>
                                    </div>
                                    <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s3 hide-on-small-only">
                                            <p class="collections-title">Nombre</p>
                                        </div>
                                        <div class="col s8 m3 l3">
                                            <p class="collections-title">Meta Desembolsado</p>
                                        </div>
                                        <div class="col s3 hide-on-small-only">
                                            <p class="collections-title">Meta Colocación</p>
                                        </div>
                                        <div class="col s3 hide-on-small-only">
                                            <p class="collections-title">Meta Recuperación</p>
                                        </div>

                                    </div>
                                </li>
                                <div id="tablaCarteraMetas"></div>
                                
                            </ul>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<div class="modales">
     <!-- Modal editar meta desembolsos -->
    <div id="modalmetadesembolsos" class="modal modal-fixed-footer modal-max-width-2">
        <div class="modal-content">
            <h4>Editar meta Desembolsado</h4>
            <p>Esta a punto de modificar la meta de Desembolso </p>
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="ej: 2,457" id="inputMetaDesembolso" type="number" class="validate">
                    <label class="active" for="inputMetaDesembolso" data-error="incorrecto" data-success="correcto">Meta de Desembolso</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Aceptar</a>
        </div>
    </div>
</div>

<script src="../js/plugins/numeral/numeral.js"></script>
<script>
    $(document).ready(function() {

        //CAMBIANDO EL NOMBRE AL BREADCRUM 
        $('#breadcrum-title').text('Detalles de Metas por Coordinador');

        //OCULTANDO DE ENTRADA LOS GRAFICOS REFERENTES A LAS METAS
        $('#card-stats').hide();
        
        //OCULTANDO DE ENTRADA LOS TABLAS REFERENTES A LAS METAS
        $('#tablaMetas').hide();

        //INICIALIZANDO SELECT2 DE FORMA GENERAL
        $('select').select2();
        $('.collapsible').collapsible();
        $('.modal').modal();

        //INICIALIZANDO SELECT2 PARA COORDINADORES
        $("#coordinadoresSelect").select2({
            placeholder: 'Seleccione un coodinador',
            //data: data,
        });

        //DECLARACION DE VARIABLES GLOBALES PARA ALMACENAR EL COORDINADOR SELECCIONADO Y SU ID
        window.nombreCoordinador = "";
        window.idCoordinador = "";

        //EVENTO ON CHANGE PARA EL SELECT2 DE COORDINADORES
        $("#coordinadoresSelect").on('change', function() {
            $('#loading').show();
            
            $('tipoEmpleadoSubTitle').text("Supervisores");
            $('nombreDelSuperiorSubTitle').text("Coordinador");
            
            window.nombreCoordinador = $('#coordinadoresSelect option:selected').text();
            window.idCoordinador = $('#coordinadoresSelect option:selected').val();

            //IMPRESION EN CONSOLA PARA COMPROBAR LOS DATOS SELECCIONADOS
            //console.log(window.nombreCoordinador);
            //console.log(window.idCoordinador);

            $('.collapsible').collapsible('close', 0);
            
            //LLAMAR A FUNCION PARA OBTENER LOS ASESORES Y LLENAR EL SELECT2 DE ASESORES
            obtenerListaAsesores(window.idCoordinador);
            
            //LLAMAR A FUNCION PARA OBTENER LOS ASESORES Y LLENAR EL SELECT2 DE ASESORES
            obtnerListaSupervisores(window.idCoordinador);
            
            //OBTENER DATOS REFERENTES A LAS METAS DEL COORDINADOR SELECCIONADO
            obtenerMetasDelUsuarioSelected(window.idCoordinador, "coordinador");
            
            // mostrar EL BOTON DE EDITAR METAS CUANDO SE SELECCIONE UN SUPERVISOR O ASESOR
            $('.botonEditarMetaCoor').show();
            
            //OBTENER CARTERA DE METAS DEL COORDINADOR
            obtenerCarteraDeMetas(window.idCoordinador, "Supervisor");

            //MOSTRANDO LOS GRAFICOS REFERENTES A LAS METAS
            $('#card-stats').fadeIn(400);
            
            //MOSTRANDO LOS TABLAS REFERENTES A LAS METAS
            $('#tablaMetas').fadeIn(300);
            
            

        });

        //INICIALIZANDO SELECT2 PARA COORDINADORES
        $("#supervisoresSelect").select2({
            placeholder: 'Seleccione un supervisor',
            //data: data,
        });
        
        //EVENTO ON CHANGE DEL SELECT2 DE SUPERVISORES
        $("#supervisoresSelect").on('change', function() {
            $('#loading').show();
            
            $('tipoEmpleadoSubTitle').text("Asesores");
            $('nombreDelSuperiorSubTitle').text("Supervisor");
            
            window.nombreSupervisor = $('#supervisoresSelect option:selected').text();
            window.idSupervisor = $('#supervisoresSelect option:selected').val();
            
            //IMPRESION EN CONSOLA PARA COMPROBAR LOS DATOS SELECCIONADOS
            console.log(window.nombreSupervisor);
            console.log(window.idSupervisor);
            
            //COLLAPSAR EL GRAFICO DE BARRAS PRICIPAL AL SELECCIONAR A UNA PERSONA DEL SELECT
            $('.collapsible').collapsible('close', 0);
            
            //LLAMAR A FUNCION PARA OBTENER LOS ASESORES Y LLENAR EL SELECT2 DE ASESORES
            obtenerAsesoresDelSupervisor(window.idSupervisor);
            
            //OBTENER DATOS REFERENTES A LAS METAS DEL COORDINADOR SELECCIONADO
            obtenerMetasDelUsuarioSelected(window.idSupervisor, 'supervisor');
            
            // OCULTAR EL BOTON DE EDITAR METAS CUANDO SE SELECCIONE UN SUPERVISOR O ASESOR
            $('.botonEditarMetaCoor').hide();
            
            //OBTENER CARTERA DE METAS DEL COORDINADOR
            obtenerCarteraDeMetas(window.idSupervisor, "Gestor");

            //MOSTRANDO LOS GRAFICOS REFERENTES A LAS METAS
            $('#card-stats').fadeOut(500);
            $('#card-stats').fadeIn(500);
            
            //MOSTRANDO LOS TABLAS REFERENTES A LAS METAS
            $('#tablaMetas').fadeOut(500);
            $('#tablaMetas').fadeIn(500);
        });


        //INICIALIZANDO SELECT2 PARA COORDINADORES
        $("#asesoresSelect").select2({
            placeholder: 'Seleccione un asesor',
            //data: data,
        });
        
        //EVENTO ON CHANGE DEL SELECT2 DE ASESORES
        $("#asesoresSelect").on('change', function() {
            
            window.nombreAsesor = $('#asesoresSelect option:selected').text();
            window.idAsesor = $('#asesoresSelect option:selected').val();
            
            //IMPRESION EN CONSOLA PARA COMPROBAR LOS DATOS SELECCIONADOS
            console.log(window.nombreAsesor);
            console.log(window.idAsesor);
            
            //COLLAPSAR EL GRAFICO DE BARRAS PRICIPAL AL SELECCIONAR A UNA PERSONA DEL SELECT
            $('.collapsible').collapsible('close', 0);
            
            //LLAMAR A FUNCION PARA OBTENER LOS ASESORES Y LLENAR EL SELECT2 DE ASESORES
            //obtenerAsesoresDelSupervisor(window.idAsesor);
            
            //OBTENER DATOS REFERENTES A LAS METAS DEL COORDINADOR SELECCIONADO
            obtenerMetasDelUsuarioSelected(window.idAsesor, 'Gestor');
            
            // OCULTAR EL BOTON DE EDITAR METAS CUANDO SE SELECCIONE UN SUPERVISOR O ASESOR
            $('.botonEditarMetaCoor').hide();
            
            //OBTENER CARTERA DE METAS DEL COORDINADOR
            //obtenerCarteraDeMetas(window.idSupervisor, "Gestor");

            //MOSTRANDO LOS GRAFICOS REFERENTES A LAS METAS
            $('#card-stats').fadeOut(500);
            $('#card-stats').fadeIn(500);
            
            //MOSTRANDO LOS TABLAS REFERENTES A LAS METAS
            $('#tablaMetas').fadeOut(300);
        });

////////////////////////// FUNCION PARA INICIALIZAR LOS GRAFICOS /////////////////////////////////////////////////
        

function inicializarGraficos(objGraph) {

    $.each(objGraph, function(index, value) {

        var chart = c3.generate({
            bindto: value.idChart,
            data: {
                columns: [
                    ['data', 0]
                ],
                type: 'gauge',
                onclick: function(d, i) {
                    //console.log("onclick", d, i);
                },
                onmouseover: function(d, i) {
                    //console.log("onmouseover", d, i);
                },
                onmouseout: function(d, i) {
                    //console.log("onmouseout", d, i);
                }
            },
            gauge: {},
            color: {
                pattern: ['#FF0000', '#F6C600', '#0288D1', '#60B044'], // the three color levels for the percentage values.
                threshold: {
                    values: [29, 60, 90, 100]
                }
            },
            size: {
                height: 100
            },
            transition: {
                duration: 1000
            }
        });

        if (value.dato > 0 && value.dato < 30) {
            $(value.idContent).addClass('red darken-2');
            $(value.idMontoMeta).addClass('red-text text-darken-2');
        } else if(value.dato >= 30 && value.dato <= 60){
            $(value.idContent).addClass('amber darken-2');
            $(value.idMontoMeta).addClass('amber-text text-darken-2');
        } else if(value.dato > 60 && value.dato <= 90){
            $(value.idContent).addClass('blue darken-2');
            $(value.idMontoMeta).addClass('blue-text text-darken-2');
        } else {
            $(value.idContent).addClass('green darken-2');
            $(value.idMontoMeta).addClass('green-text text-darken-2');
        }

        setTimeout(function() {
            chart.load({
                columns: [
                    ['data', 100]
                ]
            });
        }, 150);
        setTimeout(function() {
            chart.load({
                columns: [
                    ['data', value.dato]
                ]
            });
        }, 1000);
    });

}


//DATOS DEL GRAFICO DE BARRAS PARA PRESENTAR LAS METAS POR COORDINADOR
var ctx = document.getElementById("myChart");
var data = {
            labels:<?php echo json_encode($nombresDeCoordinador); ?> ,
            datasets: [{
                    label: "Porcentaje de Meta de Crédios",
                    data: <?php echo json_encode($metaCreditosCoor)   ;?>,
                    backgroundColor: [
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292",
                        "#f06292"
                    ],
                    hoverBackgroundColor: [
                        "#01579B",
                        "#0277BD",
                        "#0288D1",
                        "#039BE5",
                        "#03A9F4",
                        "#29B6F6",
                        "#4FC3F7",
                        "#81D4FA",
                        "#B3E5FC",
                        "#80DEEA",
                        "#4DD0E1",
                        "#26C6DA",
                        "#00BCD4",
                        "#00ACC1",
                        "#0097A7",
                        "#00838F",
                        "#3D5AFE",
                        "#3D5AFE",
                        "#304FFE"
                    ]
                },
                {
                    label: "Porcentaje de Meta de Colocación",
                    data: <?php echo json_encode($metaColocacionCoor)   ;?>,
                    backgroundColor: [
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd",
                        "#9575cd"
                    ],
                    hoverBackgroundColor: [
                        "#01579B",
                        "#0277BD",
                        "#0288D1",
                        "#039BE5",
                        "#03A9F4",
                        "#29B6F6",
                        "#4FC3F7",
                        "#81D4FA",
                        "#B3E5FC",
                        "#80DEEA",
                        "#4DD0E1",
                        "#26C6DA",
                        "#00BCD4",
                        "#00ACC1",
                        "#0097A7",
                        "#00838F",
                        "#3D5AFE",
                        "#3D5AFE",
                        "#304FFE"
                    ]
                },
                {
                    label: "Porcentaje de Meta de Recuperación",
                    data: <?php echo json_encode($metaRecuperacionCoor)   ;?>,
                    backgroundColor: [
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac",
                        "#4db6ac"
                    ],
                    hoverBackgroundColor: [
                        "#01579B",
                        "#0277BD",
                        "#0288D1",
                        "#039BE5",
                        "#03A9F4",
                        "#29B6F6",
                        "#4FC3F7",
                        "#81D4FA",
                        "#B3E5FC",
                        "#80DEEA",
                        "#4DD0E1",
                        "#26C6DA",
                        "#00BCD4",
                        "#00ACC1",
                        "#0097A7",
                        "#00838F",
                        "#00838F",
                        "#3D5AFE",
                        "#304FFE"
                    ]
                }
            ]
        };

//CREACION DEL GRAFICO barras #1
var myDoughnutChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        fontColor: '#1C7EBB'
                    }
                },
                animation: {
                    duration: 0,
                    onComplete: function() {
                        // render the value of the chart above the bar
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(9, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.fillStyle = "#000";
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.text
                        this.data.datasets.forEach(function(dataset) {
                            for (var i = 0; i < dataset.data.length; i++) {
                                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                ctx.fillText(dataset.data[i] + '%', model.x + 2, model.y + 15);
                            }
                        });
                    }
                },
                hover: {
                    // Overrides the global setting
                    mode: 'index',
                    responsive: true,
                    animationDuration: 400
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.yLabel + '%';
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                        }
                    }]
                }
            }
        });


//////////////////////////////////////////////////// PETICIONES AJAX /////////////////////////////////////////////////////////
        
        //ESTA PETICION AJAX ES PARA CARGAR EL SELECT2 DE ASESORES DEL COORDINADOR
        function obtenerListaAsesores(id_coordinador){
            $.ajax({
            type: 'POST',
            async: true,
            data: {
                id_coordinador_list_asesores: id_coordinador
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
        }
        
    
    //ESTA PETICION AJAX ES PARA CARGAR EL SELECT2 DE supervisores DEL COORDINADOR
        function obtnerListaSupervisores(id_coordinador){
            //AJAX PARA CARGAR SELECT2 DE SUPERVISORES DEL COORDINADOR
        $.ajax({
            type: 'POST',
            async: true,
            data: {
                id_coordinador_list: id_coordinador
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
        }
        
    
    //ESTA PETICION AJAX ES PARA CARGAR METAS PARA LOS EMPLEADOS SELECCIONADOS
        function obtenerMetasDelUsuarioSelected(id_usuario, tipo_usuario){
            $.ajax({
            type: 'POST',
            async: true,
            data: {
                id_usuario: id_usuario,
                tipo_usuario: tipo_usuario
            },
            url: 'metas/obtenermetas.php', 
            success: function(data){
                var metasCoordinador = JSON.parse(data);
                //console.log(metasCoordinador);
                //SET METAS TO CARTAS Y GRAFICOS
                $('#cDesembolsosMonto').text((metasCoordinador[0].metaCreditos == null ? '0' : metasCoordinador[0].metaCreditos));
                $('#cColocacionMonto').text((metasCoordinador[0].metaColocacion == null ? '0' : metasCoordinador[0].metaColocacion));
                $('#cRecuperacionMonto').text(numeral((metasCoordinador[0].metaRecuperacion == null ? '0' : metasCoordinador[0].metaRecuperacion)).format('$0,0.00'));
                $('#cMoraMonto').text(numeral((metasCoordinador[0].metaMora == null ? '0' : metasCoordinador[0].metaMora)).format('$0,0.00'));
                //SET COMPLETADO DE METAS A LA FECHA TO CARTADS Y GRAFICOS
                $('#desembolsosAFecha').text((metasCoordinador[0].creditos == null ? '0' : metasCoordinador[0].creditos));
                $('#colocacionAFecha').text((metasCoordinador[0].colocacion == null ? '0' : metasCoordinador[0].colocacion));
                $('#recuperacionAFecha').text(numeral((metasCoordinador[0].recuperacion == null ? '0' : metasCoordinador[0].recuperacion)).format('$0,0.00'));
                $('#moraAFecha').text(numeral((metasCoordinador[0].mora == null ? '0' : metasCoordinador[0].mora)).format('$0,0.00'));
                
                //CREANDO OBJETO PARA ENVIAR A LA FUNCION QUE INICIALIZA LOS GRAFICOS
                var objGraph = [
                    {
                        dato: (($('#desembolsosAFecha').text() == null ? '0' : $('#desembolsosAFecha').text())/($('#cDesembolsosMonto').text() == null ? '0' : $('#cDesembolsosMonto').text()))*100,
                        idChart: "#chart1",
                        idContent: "#cDesembolsos",
                        idMontoMeta: "#desembolsosAFecha"
                    },
                    {
                        dato: (($('#colocacionAFecha').text() == null ? '0' : $('#colocacionAFecha').text())/($('#cColocacionMonto').text() == null ? '0' : $('#cColocacionMonto').text()))*100,
                        idChart: "#chart2",
                        idContent: "#cColocacion",
                        idMontoMeta: "#colocacionAFecha"
                    },
                    {
                        dato: (($('#recuperacionAFecha').text().replace(",", "") == null ? '0' : $('#recuperacionAFecha').text().replace(",", ""))/($('#cRecuperacionMonto').text().replace(",", "") == null ? '0' : $('#cRecuperacionMonto').text().replace(",", "")))*100,
                        idChart: "#chart3",
                        idContent: "#cRecuperacion",
                        idMontoMeta: "#recuperacionAFecha"
                    },
                    {
                        dato: (($('#moraAFecha').text().replace(",", "") == null ? '0' : $('#moraAFecha').text().replace(",", ""))/($('#cMoraMonto').text().replace(",", "") == null ? '0' : $('#cMoraMonto').text().replace(",", "")))*100,
                        idChart: "#chart4",
                        idContent: "#cMora",
                        idMontoMeta: "#moraAFecha"
                    }
                ];

                inicializarGraficos(objGraph);
                console.log((($('#recuperacionAFecha').text().replace(",", "") == null ? '0' : $('#recuperacionAFecha').text().replace(",", ""))/($('#cRecuperacionMonto').text().replace(",", "") == null ? '0' : $('#cRecuperacionMonto').text().replace(",", "")))*100);
                console.log((($('#colocacionAFecha').text().replace(",", "") == null ? '0' : $('#colocacionAFecha').text().replace(",", ""))/($('#cColocacionMonto').text().replace(",", "") == null ? '0' : $('#cColocacionMonto').text().replace(",", "")))*100);
            }
        });
        }
        
    //ESTA PETICION AJAX ES PARA CARGAR LA CARTERA PARA TABLAS POR PERSONA SELECCIONADA
        function obtenerCarteraDeMetas(id_empleado, tipo_usuario){
            $('#loading').show();
           $.ajax({
            type: 'POST',
            async: true,
            data: {
                id_empleado: id_empleado,
                tipo_usuario: tipo_usuario
            },
            url: 'metas/obtenercarterametas.php', 
            success: function(data){
                var metasCoordinador = JSON.parse(data);
                $('#loading').hide();
                //console.log(metasCoordinador);
                $('#tablaCarteraMetas').empty();
                $.each(metasCoordinador, function(index, value){
                    $('#tablaCarteraMetas').append(
                        `
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s3 hide-on-small-only">
                                    <p class="collections-title">`+value.nombre+`</p>
                                    <span class="task-cat grey darken-3 collections-content">`+value.idUsuario+`</span>
                                </div>
                                <div class="col s8 m3 l3">
                                    <p class="collections-title">`+numeral(value.metaCreditos).format('00')+ " créditos" +`</p>
                                    <span class="task-cat purple darken-3 collections-content">`+numeral(value.creditos).format('00')+ " desembolsados" +`</span>
                                </div>
                                <div class="col s3 hide-on-small-only">
                                    <p class="collections-title">`+numeral(value.metaColocacion).format('00')+ " créditos" +`</p>
                                    <span class="task-cat grey darken-3 collections-content">`+numeral(value.colocacion).format('00')+ " colocados" +`</span>
                                </div>
                                <div class="col s3 hide-on-small-only">
                                    <p class="collections-title">`+"L. "+numeral(value.metaRecuperacion).format('$0,0.00')+`</p>
                                    <span class="task-cat grey darken-3 collections-content">`+"L. "+numeral(value.recuperacion).format('$0,0.00')+ " recuperado" +`</span>
                                </div>

                            </div>
                        </li>
                        
                        `
                    );
                });
                
                
            }
        }); 
        }
    
    
    //ESTA PETICION AJAX ES PARA CARGAR EL SELECT2 DE ASESORES DEL supervisor
        function obtenerAsesoresDelSupervisor(id_supervisor){
            $.ajax({
            type: 'POST',
            async: true,
            data: {
                id_supervisor_list: id_supervisor
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
        }
        
///////////////////////////////////////////////////  SWEET ALERTS //////////////////////////////////////////////////////////
        $('.botonEditarMetaCoor').on('click', function(){
            window.idbtneditar = $(this).attr('id');
            //console.log(window.idbtneditar);
            editMetas(window.idbtneditar);
        });
        
        function editMetas(idbtnmeta){
             swal({
              title: "Actualizar Meta!",
              text: "Esta a punto de actualizar el monto/valor de la meta:",
              type: "input",
              showCancelButton: true,
              closeOnConfirm: false,
              animation: "slide-from-bottom",
              inputPlaceholder: "ej: 200"
            },
            function(inputValue){
              if (inputValue === false) return false;

              if (inputValue === "") {
                swal.showInputError("este campo es requerido!");
                return false
            }
  
            swal({
                title: "Atención!",
                text: "Se actualizarán las metas que haya modificado. Desea continuar?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "Si, Actualizar!",
                cancelButtonText: "No, cancelar!",
                showLoaderOnConfirm: true,
            },
            function() {
                $.ajax({
                type: 'POST',
                data: {
                    idCoordinador: window.idCoordinador,
                    nombreCoordinador: window.nombreCoordinador, 
                    idMeta: window.idbtneditar,
                    montoMeta: inputValue
                },
                url: 'metas/editar_metas.php',
                success: function(data) {
                    //console.log(data);

                    swal({
                            title: "Bien hecho!",
                            text: "Los créditos han sido actualizados!",
                            type: "success"
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                
                                $('#'+idbtnmeta).prev().text(inputValue);
                                var chartupdate = $('#'+idbtnmeta).parent().parent().parent().parent().find('.chartc3').attr('id');
                                var chartupdatecontent = $('#'+idbtnmeta).parent().parent().parent().parent().find('.card-content').attr('id');
                                var chartupdatemontoafecha = $('#'+idbtnmeta).parent().parent().parent().find('.montoafecha').attr('id');
                                
                                var metaMensual = $('#'+idbtnmeta).parent().find('.metamensual').text();
                                var metacumplida = $('#'+idbtnmeta).parent().parent().find('.montoafecha').text();
                                
                                var objUpdate = [
                                    {
                                        dato: (metaMensual/metacumplida)*100,
                                        idChart: '#'+chartupdate,
                                        idContent: '#'+chartupdatecontent,
                                        idMontoMeta: '#'+chartupdatemontoafecha
                                    }
                                ];
                                inicializarGraficos(objUpdate);
                            }
                        });
                }
                });
            });
        });
        }

    }); //final del document ready

</script>
