<?php 

require '../php/conection.php';

session_start();

$user = $_SESSION['user'];

/*query para obtener los creditos, mor y más*/
$sql = $conn->prepare('
select b.id, a.gestor, count(*) as creditos, sum(a.Monto_Desembolsado) as montoDesembolsado, sum(a.saldo_capital) as saldoCapital, sum(if(a.capital_mora>0,capital_mora,0)) as capitalMora, (sum(a.capital_mora)/sum(a.saldo_capital))*100 as porcentajeMora 
from prestamo a 
left join gsc b on a.Gestor = b.nombre 
where b.parent = :user and Estado_Credito = "desembolsado" group by a.Gestor
');
$sql->bindValue(':user', $user, PDO::PARAM_STR);
$sql->execute();
$asesores = $sql->fetchAll();

$headersNombreAsesorList = array();
$porcentajeMoraAsesorCount = array();
$totalCreditosSupervisor = 0;
$totalDesembolsadosSupervisor = 0;
$totalSaldoCapitalSupervisor = 0;
$totalCapitalMoraSupervisor = 0;
$totalPorcentajeMoraSupervisor = 0;
for($i=0; $i< count($asesores); $i++){
    $headersNombreAsesorList[$i] = $asesores[$i]["1"] == null ? 'Por asignar' : explode(" ", $asesores[$i]["1"], -3);
    $porcentajeMoraAsesorCount[$i] = number_format($asesores[$i]["6"]);
    
    $totalCreditosSupervisor += number_format($asesores[$i]['creditos']);
    $totalDesembolsadosSupervisor += $asesores[$i]['montoDesembolsado'];
    $totalSaldoCapitalSupervisor += $asesores[$i]['saldoCapital'];
    $totalCapitalMoraSupervisor += $asesores[$i]['capitalMora'];
    $totalPorcentajeMoraSupervisor += $asesores[$i]['porcentajeMora'];
}

?>
   

   
<div class="section">
    <!--CARTAS DE ESTADO-->
    <div class="row">
        <div id="card-stats">
            <div class="row margin">
                <div class="col s12 m8 l4 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat1" class="card">
                        <div class="card-content   green lighten-2 white-text">
                            <p class="card-stats-title"><i class="material-icons">work</i> Total Créditos</p>
                            <h4 id="cartera-activa" class="card-stats-number"><?php echo $totalCreditosSupervisor; ?></h4>
                            <p class="card-stats-compare"><i class="material-icons">local_atm</i> L. <?php echo number_format($totalDesembolsadosSupervisor, '2', '.', ','); ?></p>
                        </div>
                        <div class="card-action green  center">
                            <!--<div id="clients-bar" class="center-align"></div>
                            <a href="#!" style="text-transform: lowercase;"><span class="black-text">ver detalles</span></a>-->
                        </div>
                    </div>
                </div>
                <div class="col s12 m8 l4 wow fadeInDown" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat2" class="card">
                        <div class="card-content amber white-text">
                            <p class="card-stats-title"><i class="material-icons">attach_money</i> Saldo Capital</p>
                            <h4 id="total-mora" class="card-stats-number">L. <?php echo number_format($totalSaldoCapitalSupervisor, '2', '.', ','); ?></h4>
                            <p class="card-stats-compare"><i class="material-icons">local_atm</i> L. <?php echo number_format($totalCapitalMoraSupervisor, '2', '.', ','); ?></p>
                        </div>
                        <div class="card-action amber  center">
                            <!--<div id="sales-compositebar" class="center-align"></div>-->
                            <!--<a href="#!" style="text-transform: lowercase;"><span class="white-text">ver detalles</span></a>-->
                        </div>
                    </div>
                </div>
                <div class="col s12 m8 l4 wow fadeInRight" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat3" class="card wow fadeInDown" data-wow-duration="1s">
                        <div class="card-content red white-text">
                            <p class="card-stats-title"><i class="material-icons">warning</i> Porcentaje Mora</p>
                            <h4 id="porcentaje-mora" class="card-stats-number"><?php echo number_format(($totalCapitalMoraSupervisor/($totalSaldoCapitalSupervisor == 0 ? 1 : $totalSaldoCapitalSupervisor))*100, '2', '.', ',')?>%</h4>
                            <p class="card-stats-compare"><i class="material-icons">error_outline</i></p>
                        </div>
                        <div class="card-action red  center">
                            <!-- <div id="profit-tristate" class="center-align"></div>-->
                            <!--<a href="#!" style="text-transform: lowercase;"><span class="white-text">ver detalles</span></a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--TABLA DE ASESORES-->
    <div class="row hide-on-med-and-down">
        <div class="col s12">
            <div class="card">
                <div class="card-content" style="padding: 12px;">
                    <div class="row">
                        <div class="col s12 l8">
                            <div id="work-collapsible">
                                <div class="row">
                                    <div class="col s12">
                                        <ul id="projects-collection" class="collapsible z-depth-0" data-collapsible="accordion">
                                            <li class="collapsible-item-header avatar">
                                                <i class="material-icons circle light-blue">list</i>
                                                <span class="collapsible-title-header">Asesores
                                                    <div class="secondary-content actions hide-on-med-and-down">
                                                        <a id="sinAsignar" class="editarAsesor waves-effect waves-light btn-flat nopadding tooltipped" data-position="bottom" data-delay="50" data-tooltip="I am tooltip">
                                                            <i class="material-icons center-align">list</i>
                                                        </a> 
                                                    </div>
                                                </span>
                                                <p>lista de asesores asignados (edición de cartera)</p>
                                            </li>
                                            <li>
                                                <div class="collapsible-header-titles  sin-icon">
                                                    <div class="row">
                                                        <div class="col s6 m3 l4">
                                                            <p class="collapsible-title">Nombre</p>
                                                        </div>
                                                        <div class="col s6 m3 l2 ">
                                                            <p class="collapsible-title">Créditos</p>
                                                        </div>
                                                        <div class="col s6 m3 l3 hide-on-small-only">
                                                            <p class="collapsible-title">Desembolsado</p>
                                                        </div>
                                                        <div class="col s6 m3 l3 hide-on-small-only">
                                                            <p class="collapsible-title">Saldo Capital</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <div class="list collapsible no-padding no-margin z-depth-0">
                                               <?php $i=0;?>
                                                    <?php if(count($asesores) > 0):?>
                                                        <?php foreach($asesores as $asesor):?>
                                                            <?php $i++;?>
                                                                <li class="asesor-li">
                                                                    <div class="collapsible-header sin-icon">
                                                                        <div class="row">
                                                                            <div class="col s6 m3 l4">
                                                                                <p id="nombreAsesor" class="collapsible-content truncate"><?php echo $asesor['gestor']; ?></p>
                                                                            </div>
                                                                            <div class="col s6 m3 l2">
                                                                                <p class="collapsible-content truncate"><?php echo number_format($asesor['creditos']); ?></p>
                                                                            </div>
                                                                            <div class="col s6 m3 l3 hide-on-small-only light truncate">
                                                                                <p class="collapsible-content"><?php echo number_format($asesor['montoDesembolsado'], 2, ".", ","); ?></p>
                                                                            </div>
                                                                            <div class="col s6 m3 l3 hide-on-small-only light truncate">
                                                                                <p class="collapsible-content"><?php echo number_format($asesor['saldoCapital'], 2, ".", ","); ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="collapsible-body">
                                                                        <p><b>Capital en Mora: </b><?php echo number_format($asesor['capitalMora'], 2, ".", ","); ?></p>
                                                                        <p><b>Porcentaje Mora: </b><?php echo number_format($asesor['porcentajeMora']); ?> %</p>
                                                                        <br>
                                                                        <p><a class="editarAsesor btn waves-effect waves-light btn-flat white-text">Editar Cartera del Asesor<i class="material-icons left">edit</i></a></p>
                                                                    </div>
                                                                    <input type="hidden" id="asesorid" value="<?php echo $asesor['id'];?>">
                                                                </li>
                                                        <?php endforeach;?>
                                                    <?php else:?>
                                                            <li class="center">
                                                                <h5>No hay ningún beneficiario</h5>
                                                            </li>
                                                <?php endif;?>
                                            </div>
                                            <li>
                                                <div class="collapsible-footer  sin-icon" style="border-bottom: 1px solid #e0e0e0;">
                                                    <div class="row right-align">
                                                        <span>total: <?php echo count($asesores)?> registros</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 l4">
                            <canvas id="moraPorAsesorDesktop" width="100" height="110"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--TABLA DE ASESORES PARA MOVILES-->
    <div class="row hide-on-large-only">
        <div class="col s12">
            <div id="work-collapsible">
                <div class="row">
                    <div class="col s12">
                        <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                            <li class="collapsible-item-header avatar">
                                <i class="material-icons circle light-blue">list</i>
                                <span class="collapsible-title-header">Asesores
                                    <div class="secondary-content actions">
                                        <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                        <a id="sinAsignar" class="editarAsesor waves-effect waves-light btn-flat nopadding">
                                            <i class="material-icons center-align">list</i>
                                        </a> 
                                    </div>
                                </span>
                                <p>lista de asesores asignados</</p>
                            </li>
                            <li>
                                <div class="collapsible-header-titles  sin-icon">
                                    <div class="row">
                                        <div class="col s8 m3 l3">
                                            <p class="collapsible-title">Nombre</p>
                                        </div>
                                        <div class="col s4 m3 l3 ">
                                            <p class="collapsible-title">Créditos</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <div class="list collapsible no-padding no-margin z-depth-0">
                               <?php $i=0;?>
                                    <?php if(count($asesores) > 0):?>
                                        <?php foreach($asesores as $asesor):?>
                                            <?php $i++;?>
                                            <li>
                                                <div class="collapsible-header sin-icon">
                                                    <div class="row">
                                                        <div class="col s8 m3 l3">
                                                            <p id="nombreAsesor" class="collapsible-content truncate"><?php echo $asesor['gestor']; ?></p>
                                                        </div>
                                                        <div class="col s4 m3 l3">
                                                            <p class="collapsible-content truncate"><?php echo number_format($asesor['creditos']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapsible-body">
                                                    <p><b>Desembolsado: </b>L. <?php echo number_format($asesor['montoDesembolsado'], 2, ".", ","); ?></p>
                                                    <p><b>Saldo: </b>L. <?php echo number_format($asesor['saldoCapital'], 2, ".", ","); ?></p>
                                                    <p><b>Capital en Mora: </b>L. <?php echo number_format($asesor['capitalMora'], 2, ".", ","); ?></p>
                                                    <br>
                                                    <p><a class="editarAsesor btn waves-effect waves-light btn-flat white-text">Editar Asesor<i class="material-icons left">edit</i></a></p>
                                                </div>
                                            </li>
                                        <?php endforeach;?>
                                    <?php else:?>
                                        <li class="center">
                                            <h5>No hay ningún beneficiario</h5>
                                        </li>
                                <?php endif;?>
                            </div>
                            <li>
                                <div class="collapsible-footer  sin-icon">
                                    <div class="row right-align">
                                        <span>total: <?php echo count($asesores)?> registros</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row hide-on-large-only">
        <div class="col s12">
            <div class="card">
                <div class="card-content" style="padding: 12px;">
                    <h5 class="header">Mora por asesor</h5>
                    <canvas id="moraPorAsesorMovil" width="100" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
     <!--TABLA DE ASESORES PARA MOVILES-->
</div>

<script>
    $(document).ready(function(){

        $('#breadcrum-title').text('Dashboard');

        $('.collapsible').collapsible();
        $('.tooltipped').tooltip({delay: 50});
        
        $('.asesor-li').click(function(){
            window.currentidasesor = $(this).find('#asesorid').val();
        });
        
        var nombreAsesor;
        $('.editarAsesor').on('click', function(){
            if($(this).attr('id') == "sinAsignar"){
                console.log("bonton sin asignar");
                nombreAsesor = "null";
            } else {
                nombreAsesor = $(this).parent().parent().parent().find("#nombreAsesor").text();
                console.log(nombreAsesor);
            }
            editarAsesor(nombreAsesor);
        });
        
        
        function editarAsesor(nombre){
            $('#main-container').hide("slide", { direction: "left" }, 300, function(){
                $('#loading').fadeIn(100, function(){
                    $('#main-container').load('editarAsesor.php?nombre='+escape(normalize(nombre))+'&id='+escape(window.currentidasesor), function(){
                        $('#loading').fadeOut(100, function(){
                            $('#main-container').fadeIn(100);
                        });
                    });
                });
            });
        }
        
        
        var ctxBarMovil = document.getElementById("moraPorAsesorMovil");
        var ctxBarDesktop = document.getElementById("moraPorAsesorDesktop");
        
        
        var dataBarMovil = {
                labels: <?php echo json_encode($headersNombreAsesorList);?>,
                datasets: [
                    {
                        label: "Porcentaje de Mora",
                        backgroundColor: [
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6'
                        ],
                        borderColor: [
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6'
                        ],
                        borderWidth: 1,
                        data: <?php echo json_encode($porcentajeMoraAsesorCount);?>
                    }
                ]
            };
        
        new Chart(ctxBarMovil, {
                type: "bar",
                data: dataBarMovil,
                options: {
                    barValueSpacing: 20,
                      animation: {
                    duration: 0,
                    onComplete: function () {
                        // render the value of the chart above the bar
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                        //ctx.fillStyle = "#29B6F6";
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        this.data.datasets.forEach(function (dataset) {
                            for (var i = 0; i < dataset.data.length; i++) {
                                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                ctx.fillText(dataset.data[i]+'%', model.x, model.y - 5);
                                
                                if(parseInt(dataset.data[i]) > 50){
                                    dataset.backgroundColor[i] = "#f44336";
                                    dataset.borderColor[i] = "#f44336";
                                } else if(parseInt(dataset.data[i]) > 9){
                                     dataset.backgroundColor[i] = "#ffc107";
                                     dataset.borderColor[i] = "#ffc107";
                                } else {
                                    dataset.backgroundColor[i] = "#4caf50";
                                    dataset.borderColor[i] = "#4caf50";
                                }
                            }
                        });
                    }},
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
        
        
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        var dataBarDesktop = {
            labels: <?php echo json_encode($headersNombreAsesorList);?>,
            datasets: [
                {
                    label: "Porcentaje de Mora por Asesor",
                    backgroundColor: [
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6'
                    ],
                    borderColor: [
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6'
                    ],
                    borderWidth: 1,
                    data: <?php echo json_encode($porcentajeMoraAsesorCount);?>
                }
            ]
        };
        
        new Chart(ctxBarDesktop, {
                type: "bar",
                data: dataBarDesktop,
                options: {
                    barValueSpacing: 20,
                      animation: {
                    duration: 0,
                    onComplete: function () {
                        // render the value of the chart above the bar
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                        //ctx.fillStyle = "#29B6F6";
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        this.data.datasets.forEach(function (dataset) {
                            for (var i = 0; i < dataset.data.length; i++) {
                                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                ctx.fillText(dataset.data[i]+'%', model.x, model.y - 5);
                                
                                if(parseInt(dataset.data[i]) > 50){
                                    dataset.backgroundColor[i] = "#f44336";
                                    dataset.borderColor[i] = "#f44336";
                                } else if(parseInt(dataset.data[i]) > 9){
                                     dataset.backgroundColor[i] = "#ffc107";
                                     dataset.borderColor[i] = "#ffc107";
                                } else {
                                    dataset.backgroundColor[i] = "#4caf50";
                                    dataset.borderColor[i] = "#4caf50";
                                }
                            }
                        });
                    }},
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

    });

    var normalize = (function() {
    var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç", 
        to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
        mapping = {};
    
    for(var i = 0, j = from.length; i < j; i++ )
        mapping[ from.charAt( i ) ] = to.charAt( i );
    
    return function( str ) {
        var ret = [];
        for( var i = 0, j = str.length; i < j; i++ ) {
            var c = str.charAt( i );
            if( mapping.hasOwnProperty( str.charAt( i ) ) )
                ret.push( mapping[ c ] );
            else
                ret.push( c );
        }      
        return ret.join( '' );
    }
    
    })();

</script>
