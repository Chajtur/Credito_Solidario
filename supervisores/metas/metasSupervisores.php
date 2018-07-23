<?php 

require '../../php/conection.php';
session_start();

$user = $_SESSION['user'];

try{
    $correcto = false;

    $sql = $conn->prepare('
            select b.nombre, a.idUsuario, a.creditos, a.metaCreditos, a.metaColocacion, a.colocacion, 
            a.metaRecuperacion, a.recuperacion, a.metaMora, a.mora
            from metas a inner join gsc b on a.idUsuario = b.id
            where b.tipoEmpleado = "Gestor" and a.parent = :user
            ');
            $sql->bindValue(':user', $user, PDO::PARAM_STR);

            if ($sql->execute()) {
                $carterametas = $sql->fetchAll(PDO::FETCH_ASSOC);
                $correcto = true;

            } else {
                $correcto = false;
                return false;
            }

            //echo json_encode($carterametas);


}catch(PDOException $e){
    echo $e->getMessage();
}


?>

<link rel="stylesheet" href="../gerencia/metas/c3.css">


<!--<div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Elige un Asesor</span>
                    <div class="row">
                        <div class="col s12">
                            <select class="js-example-data-array js-states browser-default" tabindex="-1" style="width: 100%" id="asesoresSelect">
                        <option value=""></option>
                        <?php $i=0;?>
                            <?php if(count($carterametas) > 0):?>
                                <?php foreach($carterametas as $asesor):?>
                                    <?php $i++;?>
                                    <option value="<?php echo $asesor['idUsuario']; ?>"><?php echo $asesor['nombre']; ?></option>
                                <?php endforeach;?>
                            <?php endif;?>
                    </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    
<h4 class="header">Seleccione un Asesor</h4>
<div class="row">
   
    <div class="col s12 l4">
        <select class="js-example-data-array js-states browser-default" tabindex="-1" style="width: 100%" id="asesoresSelect">
            <option value=""></option>
            <?php $i=0;?>
                <?php if(count($carterametas) > 0):?>
                    <?php foreach($carterametas as $asesor):?>
                        <?php $i++;?>
                        <option value="<?php echo $asesor['idUsuario']; ?>"><?php echo $asesor['nombre']; ?></option>
                    <?php endforeach;?>
                <?php endif;?>
        </select>
    </div>
</div>


<!--SECCION PARA LAS CARTAS DE ESTADO DE LAS METAS-->
<div id="seccionCardsMetas" class="section">
    <div class="titulo-header">
        <h4 style="display: inline-block;" class="header">METAS Y ESTADÍSTICAS. </h4>
        <span style="display: inline-block;" class="hide"><a href="#modalTodasLasMetas"> (Editar todas las metas)</a></span>
    </div>
    <div class="row">
        <div class="col s12 m12 l4">
            <div class="card stats-card">
                <div id="graph-card-desembolso" class="graph-card">
                    <span class="graph-card-title">Meta de Desembolso</span>
                    <div class="chartc3" id="chart1"></div>
                </div>
                <div class="card-content">
                    <div class="card-options">
                        <ul>
                            <li><a id="modalmetadesembolsos" class="botonEditarMeta" href="#!"><i class="material-icons tooltipped" data-position="top" data-delay="50" data-tooltip="editar meta desembolsado">more_vert</i></a></li>
                        </ul>
                    </div>
                    <span class="card-title">Comparación a la fecha</span>
                    <span class="stats-counter"><span id="counterDesembolsado" class="counter">0</span><small>este mes.</small></span>
                    <div  class="percent-info green-text tooltipped" data-position="top" data-delay="50" data-tooltip="Meta a cumplir"><span class="metaacumplir" id="percent-info-desembolsado">0</span> <i class="material-icons">trending_up</i></div>
                </div>
                <div class="progress stats-card-progress tooltipped" data-position="top" data-delay="50" data-tooltip="50%">
                    <div id="determinateDesembolsado" class="determinate "></div>
                </div>
            </div>
        </div>

        <div class="col s12 m12 l4">
            <div class="card stats-card">
                <div id="graph-card-colocacion" class="graph-card">
                    <span class="graph-card-title">Meta de Colocación</span>
                    <div class="chartc3" id="chart2"></div>
                </div>
                <div class="card-content">
                    <div class="card-options">
                        <ul>
                            <li><a id="modalmetacolocacion" class="botonEditarMeta" href="#!"><i class="material-icons tooltipped" data-position="top" data-delay="50" data-tooltip="editar meta colocación">more_vert</i></a></li>
                        </ul>
                    </div>
                    <span class="card-title">Comparación a la fecha</span>
                    <span class="stats-counter"><span id="counterColocacion" class="counter">0</span><small>este mes</small></span>
                    <div  class="percent-info green-text tooltipped" data-position="top" data-delay="50" data-tooltip="Meta a cumplir"><span class="metaacumplir" id="percent-info-colocacion">0</span> <i class="material-icons">trending_up</i></div>
                </div>
                <div class="progress stats-card-progress tooltipped" data-position="top" data-delay="50" data-tooltip="50%">
                    <div id="determinateColocacion" class="determinate "></div>
                </div>
            </div>
        </div>

        <div class="col s12 m12 l4">
            <div class="card stats-card">
                <div id="graph-card-recuperacion" class="graph-card">
                    <span class="graph-card-title">Meta de Recuperación</span>
                    <div class="chartc3" id="chart3"></div>
                </div>
                <div class="card-content">
                    <div class="card-options">
                        <ul>
                            <li>
                                <a id="modalmetarecuperacion" class="botonEditarMeta" href="#!"><i class="material-icons tooltipped" data-position="top" data-delay="50" data-tooltip="editar meta recuperación">more_vert</i></a>
                            </li>
                        </ul>
                    </div>
                    <span class="card-title">Comparación a la fecha</span>
                    <span class="stats-counter"><span id="counterRecuperacion" class="counter">0</span><small>este mes</small></span>
                    <div  class="percent-info green-text tooltipped" data-position="top" data-delay="50" data-tooltip="Meta a cumplir"><span class="metaacumplir" id="percent-info-recuperacion">0</span> <i class="material-icons">trending_up</i></div>
                </div>
                <div class="progress stats-card-progress tooltipped" data-position="top" data-delay="50" data-tooltip="50%">
                    <div id="determinateRecuperacion" class="determinate "></div>
                </div>
            </div>
        </div>


    </div>
</div>

<!--SECCION PARA MOSTRAR UN MENSAJE DE EMPTY CONTENT-->
<div id="emptyContent" class="section">
   <br><br><br><br><br>
    <div class="row">
        <div class="col s12 center">
            <i class="material-icons amber-text">warning</i>
            <h4 class="header amber-text">No Ha Seleccionado a Ningún Asesor</h4>
        </div>
    </div>
</div>


<!--SECCION DE MODALES PARA LA EDICION DE LAS METAS-->
<div class="section">
    <!--MODAL PARA LA EDICION DE TODAS LAS METAS -->
    <div>
        <!-- Modal PARA PRIMERA CARTA -->
        <div id="modalMetaDesembolso" class="modal modal-max-width-2">
            <div class="modal-content">
                <h4>Editar Meta de Créditos</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaCreditosIndiv" type="number" class="validate">
                        <label for="metaTodasCreditos" data-error="datos erroneos" data-success="correcto">Meta de créditos</label>
                        <label class="error hide" id="error-label">Este campo es requerido</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="btnEditMetaCreditos" href="#!" class="meta modal-action  waves-effect waves-green btn-flat">Aplicar</a>
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            </div>
        </div>

        <!-- Modal PARA SEGUNDA CARTA -->
        <div id="modalMetaColocacion" class="modal modal-max-width-2">
            <div class="modal-content">
                <h4>Editar Meta de Colocación</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaColocacionIndiv" type="number" class="validate">
                        <label for="metaTodasCreditos" data-error="datos erroneos" data-success="correcto">Meta de colocación</label>
                        <label class="error hide" id="error-label">Este campo es requerido</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="btnEditMetaMora" href="#!" class="meta modal-action  waves-effect waves-green btn-flat">Aplicar</a>
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            </div>
        </div>

        <!-- Modal PARA TERCERA CARTA -->
        <div id="modalMetaRecuperacion" class="modal modal-max-width-2">
            <div class="modal-content">
                <h4>Editar Meta de Recuperación</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaRecuperacionIndiv" min="5" max="100" type="number" class="validate">
                        <label for="metaTodasCreditos" data-error="datos erroneos" data-success="correcto">Meta Porcentaje de Mora</label>
                        <label class="error hide" id="error-label">Este campo es requerido</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="btnEditMetaPMora" href="#!" class="meta modal-action waves-effect waves-green btn-flat">Aplicar</a>
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            </div>
        </div>

        <!-- Modal PARA TODAS LAS METAS -->
        <div id="modalTodasLasMetas" class="modal modal-fixed-footer modal-max-width-2">
            <div class="modal-content">
                <h4>Editar Todas las Metas</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaTodasCreditos" type="number" class="validate">
                        <label for="metaTodasCreditos" >Meta de créditos</label>
                        <label class="error" data-error="wrong" data-success="right" id="error-label">Este campo es requerido</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaTodasMora" type="number" class="validate">
                        <label for="metaTodasMora" >Meta de mora</label>
                        <label data-error="wrong" data-success="right" class="error" id="error-label">Este campo es requerido</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaTodasPMora" type="number" class="validate">
                        <label for="metaTodasPMora" >Meta de Porcentaje de Mora</label>
                        <label data-error="wrong" data-success="right" class="error" id="error-label">Este campo es requerido</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaTodasColocacion" type="number" class="validate">
                        <label for="metaTodasColocacion" >Meta de Colocación</label>
                        <label data-error="wrong" data-success="right" class="error" id="error-label">Este campo es requerido</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaTodasRecuperacion" type="number" class="validate">
                        <label for="metaTodasRecuperacion" >Meta de Recuperación</label>
                        <label data-error="wrong" data-success="right" class="error" id="error-label">Este campo es requerido</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="btnEditMetasTodas" href="#!" class="blue-text modal-action waves-effect waves-green btn-flat">Aplicar</a>
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            </div>
        </div>

    </div>
    
    <!--MODAL PARA LA EDICION DE LA META DE DESEMBOLSOS-->
    
    
    <!--MODAL PARA LA EDICION DE LA META DE COLOCACION-->
    
    
    <!--MODAL PARA LA EDICION DE LA META DE RECUPERACION-->
    
    
</div>


<!--<div id="tablaMetas" class="section">
    <h4 class="header">CARTERA DE METAS</h4>
    <div class="row">
        <div class="col s12">
            <div id="work-collapsible">
                <div class="row">
                    <div class="col s12">
                        <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                            <li class="collapsible-item-header avatar">
                                <i class="material-icons circle light-blue">list</i>
                                <span class="collapsible-title-header">Asesores
                                        <div class="secondary-content actions hide-on-med-and-down">
                                            <a id="sinAsignar" class="editarAsesor waves-effect waves-light btn-flat nopadding tooltipped" data-position="bottom" data-delay="50" data-tooltip="I am tooltip">
                                                <i class="material-icons center-align">list</i>
                                            </a> 
                                        </div>
                                    </span>
                                <p>lista de asesores asignados (edición de metas)</</p>
                            </li>
                            <div class="collapsible-header-titles  sin-icon">
                                <div class="row">
                                    <div class="col s6 m3 l4">
                                        <p class="collapsible-title">Nombre</p>
                                    </div>
                                    <div class="col s6 m3 l2 ">
                                        <p class="collapsible-title">Meta Desembolsado</p>
                                    </div>
                                    <div class="col s6 m3 l3 hide-on-small-only">
                                        <p class="collapsible-title">Meta Colocación</p>
                                    </div>
                                    <div class="col s6 m3 l3 hide-on-small-only">
                                        <p class="collapsible-title">Meta Recuperación</p>
                                    </div>
                                </div>
                            </div>
                            </li>
                            <div class="list collapsible no-padding no-margin z-depth-0" id="tablaCarteraMetas">
                                <?php $i=0;?>
                                <?php if(count($carterametas) > 0):?>
                                <?php foreach($carterametas as $carteraMeta):?>
                                <?php $i++;?>
                                <li class="asesor-li">
                                    <div class="collapsible-header sin-icon">
                                        <div class="row">
                                            <div class="col s6 m3 l4">
                                                <p id="nombreAsesor" class="collapsible-content truncate">
                                                    <?php echo $carteraMeta['nombre']; ?>
                                                </p>
                                            </div>
                                            <div class="col s6 m3 l2">
                                                <p class="collapsible-content truncate">
                                                    <?php echo number_format($carteraMeta['metaCreditos']); ?>
                                                </p>
                                            </div>
                                            <div class="col s6 m3 l3 hide-on-small-only light truncate">
                                                <p class="collapsible-content">
                                                    <?php echo number_format($carteraMeta['metaColocacion']); ?>
                                                </p>
                                            </div>
                                            <div class="col s6 m3 l3 hide-on-small-only light truncate">
                                                <p class="collapsible-content">
                                                    <?php echo number_format($carteraMeta['metaRecuperacion'], 2, ".", ","); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapsible-body">
                                        <p><b>Meta de Mora: </b>
                                            <?php echo number_format($carteraMeta['metaMora'], 2, ".", ","); ?>
                                        </p>
                                        <br>
                                        <p><a class="editarAsesor btn waves-effect waves-light btn-flat white-text">Editar Metas del Asesor<i class="material-icons left">edit</i></a></p>
                                    </div>
                                    <input type="hidden" id="asesorid" value="<?php echo $carteraMeta['idUsuario'];?>">
                                </li>
                                <?php endforeach;?>
                                <?php else:?>
                                <li class="center">
                                    <h5>No hay ningún beneficiario</h5>
                                </li>
                                <?php endif;?>
                            </div>
                            <li>
                                <div class="collapsible-footer  sin-icon" style="border-bottom: 0px solid #e0e0e0;">
                                    <div class="row right-align">
                                        <span>total: <?php echo count($carterametas)?> registros</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->








<script src="../js/plugins/numeral/numeral.js"></script>
<script>
    $(document).ready(function() {

        //CAMBIANDO EL NOMBRE AL BREADCRUM 
        $('#breadcrum-title').text('Detalles de las Metas de sus asesorres');


        //OCULTANDO LA SECCION DE CARTAS DE METAS PARA MOSTRARLAS CUANDO SE SELECCIONE UN ASESOR
        $('#seccionCardsMetas').hide();
        
        $('.error').hide();
        
        //INICIALIZANDO COMPONENTES DE FORMA GENERAL
        $('.tooltipped').tooltip({
            delay: 50
        });
        $('select').select2();
        $('.collapsible').collapsible();
        $('.modal').modal();

        //INICIALIZANDO SELECT2 PARA asesores
        $("#asesoresSelect").select2({
            placeholder: 'Seleccione un asesor',
            //data: data,
        });

        $("#asesoresSelect").on('change', function() {

            window.nombreAsesor = $('#asesoresSelect option:selected').text();
            window.idAsesor = $('#asesoresSelect option:selected').val();

            //IMPRESION EN CONSOLA PARA COMPROBAR LOS DATOS SELECCIONADOS
            console.log(window.nombreAsesor);
            console.log(window.idAsesor);
            
            $('#emptyContent').fadeOut('300');
            $('#seccionCardsMetas').fadeOut('200');
            $('#seccionCardsMetas').fadeIn('300');
            
            //OBTENER DATOS REFERENTES A LAS METAS DEL COORDINADOR SELECCIONADO
            obtenerMetasDelUsuarioSelected(window.idAsesor, "Gestor");
        });
        
        
        
        /////////////////////////////////////////// PETICIONES AJAX //////////////////////////////////////////////////////
        
        function division($a, $b) {         
            if($b == 0)
              return 0;

            return ($a/$b)*100;
        }
        
        function obtenerMetasDelUsuarioSelected(id_usuario, tipo_usuario){
            $.ajax({
            type: 'POST',
            async: true,
            data: {
                id_usuario: id_usuario,
                tipo_usuario: tipo_usuario
            },
            url: 'metas/obtenerMetas.php', 
            success: function(data){
                var metasEmpleado = JSON.parse(data);
                console.log(metasEmpleado);
                
                //SET METAS TO CARTAS Y GRAFICOS
                $('#counterDesembolsado').text((metasEmpleado[0].creditos == null ? '0' : metasEmpleado[0].creditos));
                $('#counterColocacion').text((metasEmpleado[0].colocacion == null ? '0' : metasEmpleado[0].colocacion));
                $('#counterRecuperacion').text('L. ' + (metasEmpleado[0].recuperacion == null ? '0' : metasEmpleado[0].recuperacion));
                
                $('#percent-info-desembolsado').text((metasEmpleado[0].metaCreditos == null ? '0' : metasEmpleado[0].metaCreditos));
                $('#percent-info-colocacion').text((metasEmpleado[0].metaColocacion == null ? '0' : metasEmpleado[0].metaColocacion));
                $('#percent-info-recuperacion').text('L. ' + (metasEmpleado[0].metaRecuperacion == null ? '0' : metasEmpleado[0].metaRecuperacion));
                
                 //CREANDO OBJETO PARA ENVIAR A LA FUNCION QUE INICIALIZA LOS GRAFICOS
                var objGraph = [{
                        dato: division(($('#counterDesembolsado').text() == null ? '0' : $('#counterDesembolsado').text() ), ($('#percent-info-desembolsado').text() == null ? '0' : $('#percent-info-desembolsado').text() ) ),
                        idChart: "#chart1",
                        idContent: "#graph-card-desembolso",
                        idMontoMeta: "#counterDesembolsado",
                        idProgress: "#determinateDesembolsado"
                    },
                    {
                        dato: division(($('#counterColocacion').text() == null ? '0' : $('#counterColocacion').text() ), ($('#percent-info-colocacion').text() == null ? '0' : $('#percent-info-colocacion').text() ) ),
                        idChart: "#chart2",
                        idContent: "#graph-card-colocacion",
                        idMontoMeta: "#counterColocacion",
                        idProgress: "#determinateColocacion"
                    },
                    {
                        dato: division(($('#counterRecuperacion').text() == null ? '0' : $('#counterRecuperacion').text() ), ($('#percent-info-recuperacion').text() == null ? '0' : $('#percent-info-recuperacion').text() ) ),
                        idChart: "#chart3",
                        idContent: "#graph-card-recuperacion",
                        idMontoMeta: "#counterRecuperacion",
                        idProgress: "#determinateRecuperacion"
                    }
                ];

                inicializarGraficos(objGraph);
               
                
                console.log((($('#recuperacionAFecha').text().replace(",", "") == null ? '0' : $('#recuperacionAFecha').text().replace(",", ""))/($('#cRecuperacionMonto').text().replace(",", "") == null ? '0' : $('#cRecuperacionMonto').text().replace(",", "")))*100);
                console.log((($('#colocacionAFecha').text().replace(",", "") == null ? '0' : $('#colocacionAFecha').text().replace(",", ""))/($('#cColocacionMonto').text().replace(",", "") == null ? '0' : $('#cColocacionMonto').text().replace(",", "")))*100);
            }
        });
        }
        
       

        ////////////////////////// FUNCION PARA INICIALIZAR LOS GRAFICOS /////////////////////////////////////////////////


        function inicializarGraficos(objGraph) {

            $.each(objGraph, function(index, value) {
                
                
                $(value.idProgress).parent().attr('data-tooltip', numeral(value.dato).format('0.0%')+"%");
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
                } else if (value.dato >= 30 && value.dato <= 60) {
                    $(value.idContent).addClass('amber darken-2');
                    $(value.idMontoMeta).addClass('amber-text text-darken-2');
                } else if (value.dato > 60 && value.dato <= 90) {
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
                
                $(value.idProgress).css('width', 0 + '%');
                    if (value.dato > 0 && value.dato <= 20) {
                        $(value.idProgress).addClass('red');
                        $(value.idProgress).css('width', value.dato + '%');
                        $(value.idMontoMeta).addClass('red-text');
                    } else if (value.dato > 20 && value.dato <= 50) {
                        $(value.idProgress).addClass('deep-orange');
                        $(value.idProgress).css('width', value.dato + '%');
                        $(value.idMontoMeta).addClass('deep-orange-text');
                    } else if (value.dato > 20 && value.dato <= 50) {
                        $(value.idProgress).addClass('amber');
                        $(value.idProgress).css('width', value.dato + '%');
                        $(value.idMontoMeta).addClass('amber-text');
                    } else if (value.dato > 50 && value.dato <= 80) {
                        $(value.idProgress).addClass('yellow');
                        $(value.idProgress).css('width', value.dato + '%');
                        $(value.idMontoMeta).addClass('yellow-text');
                    } else if (value.dato > 80 && value.dato <= 90) {
                        $(value.idProgress).addClass('lime');
                        $(value.idProgress).css('width', value.dato + '%');
                        $(value.idMontoMeta).addClass('lime-text');
                    } else if (value.dato > 90 && value.dato <= 100) {
                        $(value.idProgress).addClass('green');
                        $(value.idProgress).css('width', value.dato + '%');
                        $(value.idMontoMeta).addClass('green-text');
                    }
                $('.tooltipped').tooltip({
                    delay: 50
                });
                
            });
            
            
             //cONDICIONES PARA TINTAR EL COLOR DE LOS GRAFICOS
            var number = 91;

            

        }

        
        ///////////////////////////////    BOTON PARA GUARDAR LAS TODAS LAS METAS  //////////////////////////////////////////


       /* $('#metaTodasCreditos').on('input', function(){
            $('#metaTodasCreditos').parent().find('#error-label').hide();
        });
        $('#metaTodasMora').on('input', function(){
            $('#metaTodasMora').parent().find('#error-label').hide();
        });
        $('#metaTodasPMora').on('input', function(){
            $('#metaTodasPMora').parent().find('#error-label').hide();
        });
        $('#metaTodasColocacion').on('input', function(){
            $('#metaTodasColocacion').parent().find('#error-label').hide();
        });
        $('#metaTodasRecuperacion').on('input', function(){
            $('#metaTodasRecuperacion').parent().find('#error-label').hide();
        });
        
        window.validateForm = false;
        $('#btnEditMetasTodas').on('click', function(){
            
            if($('#metaTodasCreditos').val() == null || $('#metaTodasCreditos').val() == ""){
                $('#metaTodasCreditos').parent().find('#error-label').show();
                window.validateForm = false;
            } else {
                window.todasMetasDesembolsado = $('#metaTodasCreditos').val();
                window.validateForm = true;
            }
            
            if($('#metaTodasMora').val() == null || $('#metaTodasMora').val() == ""){
                $('#metaTodasMora').parent().find('#error-label').show();
                window.validateForm = false;
            } else {
                window.todasMetasMora = $('#metaTodasMora').val();
                window.validateForm = true;
            }
            
            if($('#metaTodasPMora').val() == null || $('#metaTodasPMora').val() == ""){
                $('#metaTodasPMora').parent().find('#error-label').show();
                window.validateForm = false;
            } else {
                window.todasMetasPMora = $('#metaTodasPMora').val();
                window.validateForm = true;
            }
            
            if($('#metaTodasColocacion').val() == null || $('#metaTodasColocacion').val() == ""){
                $('#metaTodasColocacion').parent().find('#error-label').show();
                window.validateForm = false;
            } else {
                window.todasMetasColocacion = $('#metaTodasColocacion').val();
                window.validateForm = true;
            }
            
            
            if($('#metaTodasRecuperacion').val() == null || $('#metaTodasRecuperacion').val() == ""){
                $('#metaTodasRecuperacion').parent().find('#error-label').show();
                window.validateForm = false;
            } else {
                window.todasMetasRecuperacion = $('#metaTodasRecuperacion').val();
                window.validateForm = true;
            }
            
            if(window.validateForm){
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
                        idAsesor: window.idAsesor,
                        metaTodasCreditos: window.todasMetasDesembolsado, 
                        metaTodasMora: window.todasMetasMora, 
                        metaTodasPMora: window.todasMetasPMora, 
                        metaTodasColocacion: window.todasMetasColocacion, 
                        metaTodasRecuperacion: window.todasMetasRecuperacion
                    },
                    url: 'metas/actualizarMetas.php',
                    success: function(data) {
                        console.log(data);

                        swal({
                                title: "Bien hecho!",
                                text: "Los créditos han sido actualizados!",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    
                                
                                inicializarGraficos(objUpdate);
                                    $('#metaTodasCreditos').val("");
                                    $('#metaTodasMora').val(""); 
                                    $('#metaTodasPMora').val(""); 
                                    $('#metaTodasColocacion').val(""); 
                                    $('#metaTodasRecuperacion').val("");
                                }
                            });
                    }
                    });
                });
            } else {
                Materialize.toast('Verifique la información');
            }
            
        });*/
        
        
        /////////////////////////////////////////////////// actualizar metas 1 a 1 SWEET ALERTS //////////////////////////////////////////////////////////
        $('.botonEditarMeta').on('click', function(){
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
                    idAsesor: window.idAsesor, 
                    idMeta: window.idbtneditar,
                    montoMeta: inputValue
                },
                url: 'metas/actualizarMetas.php',
                success: function(data) {
                    console.log(data);

                    swal({
                            title: "Bien hecho!",
                            text: "Los créditos han sido actualizados!",
                            type: "success"
                        },
                    function(isConfirm) {
                            if (isConfirm) {
                                var padre = $('#'+idbtnmeta).parent().parent().parent().parent().parent();
                                
                                var chartupdate = padre.find('.chartc3').attr('id');
                                
                                var chartupdatecontent = padre.find('.graph-card').attr('id');
                                
                                var chartupdatemontoafecha = padre.find('.counter').attr('id');
                                
                                var chartupdatemetaacumplir = padre.find('.metaacumplir').attr('id');
                                $('#' + chartupdatemetaacumplir).text(inputValue);
                                
                                var progreso = padre.find('.determinate').attr('id');
                                
                                var metaMensual = $('#' + chartupdatemontoafecha).text();
                                var metacumplida = $('#' + chartupdatemetaacumplir).text();
                                
                                
                                var objUpdate = [
                                    {
                                        dato: ((metaMensual/metacumplida)*100),
                                        idChart: '#'+chartupdate,
                                        idContent: '#'+chartupdatecontent,
                                        idMontoMeta: '#'+chartupdatemontoafecha,
                                        idProgress: "#" + progreso
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
