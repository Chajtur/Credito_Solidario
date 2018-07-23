<?php 
require '../php/conection.php';

session_start();

$user = $_SESSION['user'];
/*query para obtener datos historicos de las ifi */
$sql = $conn->prepare('select Ifi, b.Nombre, count(Numero_Prestamo) as creditos,
sum(Monto_Desembolsado) as desembolsado, 
sum(saldo_capital) as saldo,
sum(capital_mora) as capita_mora, b.abreviacion  
from prestamo a, ifi b
where a.ifi = b.id
GROUP BY Ifi');
$sql->execute();
$historicoIfis = $sql->fetchAll();

$headersMoraAgenciaCount = array();
$porcentajeMoraAgenciaCount = array();
for($i=0; $i< count($historicoIfis); $i++){
    $headersMoraIfi[$i] = $historicoIfis[$i]["6"] == null ? 'Por asignar' : $historicoIfis[$i]["6"];
    $porcentajeMoraIfiCount[$i] = number_format(($historicoIfis[$i]["5"]/($historicoIfis[$i]["4"] == 0 ? 1 : $historicoIfis[$i]["4"]))*100, 2, ".", ",");
  
    if($porcentajeMoraIfiCount[$i] > 50){
      $colorArray[$i] = "#ef5350";
    }else if($porcentajeMoraIfiCount[$i] > 9) {
      $colorArray[$i] = "#ffd54f";
    }else {
      $colorArray[$i] = "#81c784";
  }
}

//var_dump(json_encode($colorArray));

/*query para obtener los datos  desembolsados de las ifis*/
$sql = $conn->prepare('select Ifi, b.Nombre, count(Numero_Prestamo) as creditos,
sum(Monto_Desembolsado) as desembolsado, 
sum(saldo_capital) as saldo,
sum(capital_mora) as capita_mora, b.abreviacion    
from prestamo a, ifi b
where a.ifi = b.id and a.Estado_Credito = "Desembolsado"
GROUP BY Ifi');
$sql->execute();
$actualIfis = $sql->fetchAll();

$headersMoraAgenciaCount = array();
$porcentajeMoraAgenciaCount = array();
for($i=0; $i< count($actualIfis); $i++){
    $headersMoraIfiActual[$i] = $actualIfis[$i]["6"] == null ? 'Por asignar' : $actualIfis[$i]["6"];
    $porcentajeMoraIfiActualCount[$i] = number_format(($actualIfis[$i]["5"]/($actualIfis[$i]["4"] == 0 ? 1 : $actualIfis[$i]["4"]))*100, 2, ".", ",");
  
    if($porcentajeMoraIfiActualCount[$i] > 50){
      $colorArray2[$i] = "#ef5350";
    }else if($porcentajeMoraIfiActualCount[$i] > 9) {
      $colorArray2[$i] = "#ffd54f";
    }else {
      $colorArray2[$i] = "#81c784";
  }
}

?>
   

   
   
   
   <div class="section">
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 l8">
                            <div id="work-collections" class="hide-on-small-only">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                                        <ul id="projects-collection" class="collection">
                                            <li class="collection-item avatar">
                                                <i class="material-icons circle light-green ">history</i>
                                                <span class="collection-header">Listado por IFIs</span>
                                                <p>Detalles históricos de IfIs</p>
                                            </li>
                                            <li class="collection-item hide-on-small-only">
                                                <div class="row">
                                                    <div class="col s3 l3">
                                                        <p class="collections-title">IFI</p>
                                                    </div>
                                                    <div class="col s3 l3">
                                                        <p class="collections-title">Créditos</p>
                                                    </div>
                                                    <div class="col s4 l3">
                                                        <p class="collections-title">Saldo</p>
                                                    </div>
                                                    <div class="col s3 l3 hide-on-small-only">
                                                        <p class="collections-title">Capital Mora</p>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                            <!--para movil-->
                                            <li class="collection-item hide-on-med-and-up">
                                                <div class="row">
                                                    <div class="col s4 l3">
                                                        <p class="collections-title">IFI</p>
                                                    </div>
                                                    <div class="col s4 l3" style="padding: 0px;">
                                                        <p class="collections-title">Créd/Desem</p>
                                                    </div>
                                                    <div class="col s4 l3" style="padding: 0px;">
                                                        <p class="collections-title">Sald/C.Mora</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php $i=0;?>
                                            <?php if(count($historicoIfis) > 0):?>
                                            <?php foreach($historicoIfis as $datosIfisHistory):?>
                                            <?php $i++;?>

                                            <li class="collection-item hide-on-small-only">
                                                <div class="row">
                                                    
                                                    <div class="col s3 l3 light">
                                                        <p class="collections-content"><?php echo $datosIfisHistory['6']; ?></p>
                                                    </div>
                                                    <div class="col s3 l3 light">
                                                        <p class="collections-content align-left"><?php echo number_format($datosIfisHistory['2'], 0, ".", ","); ?></p>
                                                    </div>
                                                    <div class="col s5 l3 light">
                                                        <p class="collections-content">L. <?php echo number_format($datosIfisHistory['4'], 2, ".", ","); ?></p>
                                                    </div>
                                                    <div class="col s3 l3 light hide-on-small-only">
                                                        <p class="collections-content">L. <?php echo number_format($datosIfisHistory['5'], 2, ".", ","); ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                            <!--para moviles-->
                                            <li class="collection-item hide-on-med-and-up">
                                                <div class="row">
                                                    
                                                    <div class="col s4 l3 light">
                                                        <p class="collections-content"><?php echo $datosIfisHistory['6']; ?></p>
                                                    </div>
                                                    <div class="col s4 l3 light" style="padding: 0px;">
                                                        <p class="collections-content"><?php echo number_format($datosIfisHistory['2'], 2, ".", ","); ?></p>
                                                        <span class="task-cat grey darken-3 collections-content">L. <?php echo number_format($datosIfisHistory['3'], 2, ".", ","); ?></span>
                                                    </div>
                                                    <div class="col s4 l3 light" style="padding: 0px;">
                                                        <p class="collections-content">L. <?php echo number_format($datosIfisHistory['4'], 2, ".", ","); ?></p>
                                                        <span class="task-cat grey darken-3 collections-content">L. <?php echo number_format($datosIfisHistory['5'], 2, ".", ","); ?></span>
                                                    </div>
                                                </div>
                                            </li>

                                            <?php endforeach;?>
                                            <?php else:?>
                                            <li class="center">
                                                <h5>No hay ningún registros</h5>
                                            </li>
                                            <?php endif;?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!--para movil-->
                            <div id="work-collapsible" class="hide-on-large-only">
                    <div class="row">
                        <div class="col s12">
                            <ul id="projects-collection" class="collapsible z-depth-0" data-collapsible="accordion">
                                <li class="collapsible-item-header avatar">
                                    <i class="material-icons circle light-green">history</i>
                                    <span class="collapsible-title-header">Listado de IFIs Historico</span>
                                    <p>Registros históricos por IFIs</p>
                                </li>
                                <li>

                                    <div class="collapsible-header-titles  sin-icon">
                                        <div class="row">
                                           <div class="col s1">
                                                <p class="collapsible-title"></p>
                                            </div>
                                            <div class="col s4">
                                                <p class="collapsible-title">IFI</p>
                                            </div>
                                            <div class="col s6">
                                                <p class="collapsible-title">Créditos</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                
                                <?php $i=0;?>
                                <?php if(count($historicoIfis) > 0):?>
                                <?php foreach($historicoIfis as $datosIfisHistory):?>
                                <?php $i++;?>
                                <li>
                                    <div class="collapsible-header sin-icon">
                                        <div class="row">
                                            <div class="col s1" style="padding: 0px;">
                                                <p class="collapsible-content"><i class="material-icons blue-text">add</i></p>
                                            </div>
                                            <div class="col s4">
                                                <p class="collapsible-content truncate"> <?php echo $datosIfisHistory['6']; ?></p>
                                            </div>
                                            <div class="col s6">
                                                <p class="collapsible-content truncate"><?php echo number_format($datosIfisHistory['2']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapsible-body">
                                        <p><b>Desembolsado: </b> L.<?php echo number_format($datosIfisHistory['3'], 2, ".", ","); ?></p>
                                        <p><b>Saldo: </b> L. <?php echo number_format($datosIfisHistory['4'], 2, ".", ","); ?></p>
                                        <p><b>Capital Mora: </b> L. <?php echo number_format($datosIfisHistory['5'], 2, ".", ","); ?></p>
                                    </div>
                                </li>
                                <?php endforeach;?>
                                <?php else:?>
                                <li class="center">
                                    <h5>No hay ningún registro</h5>
                                </li>
                                <?php endif;?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
                        </div>
                        <div class="col s12 l4">
                            <canvas id="charthistorico" width="100" height="160"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 l8">
                            <div id="work-collections" class="hide-on-small-only">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                                        <ul id="projects-collection" class="collection">
                                            <li class="collection-item avatar">
                                                <i class="material-icons circle light-blue ">update</i>
                                                <span class="collection-header">Listado por IFIs</span>
                                                <p>Detalles Actuales de IfIs</p>
                                            </li>
                                            <li class="collection-item hide-on-small-only">
                                                <div class="row">
                                                    <div class="col s3 l3">
                                                        <p class="collections-title">IFI</p>
                                                    </div>
                                                    <div class="col s3 l3">
                                                        <p class="collections-title">Créditos</p>
                                                    </div>
                                                    <div class="col s4 l3">
                                                        <p class="collections-title">Saldo</p>
                                                    </div>
                                                    <div class="col s3 l3 hide-on-small-only">
                                                        <p class="collections-title">Capital Mora</p>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                            <?php $i=0;?>
                                            <?php if(count($actualIfis) > 0):?>
                                            <?php foreach($actualIfis as $actualIfisActual):?>
                                            <?php $i++;?>

                                            <li class="collection-item hide-on-small-only">
                                                <div class="row">
                                                    
                                                    <div class="col s3 l3 light">
                                                        <p class="collections-content"><?php echo $actualIfisActual['6']; ?></p>
                                                    </div>
                                                    <div class="col s3 l3 light">
                                                        <p class="collections-content"><?php echo number_format($actualIfisActual['2'], 0, ".", ","); ?></p>
                                                    </div>
                                                    <div class="col s5 l3 light">
                                                        <p class="collections-content">L. <?php echo number_format($actualIfisActual['4'], 2, ".", ","); ?></p>
                                                    </div>
                                                    <div class="col s3 l3 light hide-on-small-only">
                                                        <p class="collections-content">L. <?php echo number_format($actualIfisActual['5'], 2, ".", ","); ?></p>
                                                    </div>
                                                </div>
                                            </li>

                                            <?php endforeach;?>
                                            <?php else:?>
                                            <li class="center">
                                                <h5>No hay ningún registro</h5>
                                            </li>
                                            <?php endif;?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!--para movil-->
                            <div id="work-collapsible" class="hide-on-large-only">
                                <div class="row">
                                    <div class="col s12">
                                        <ul id="projects-collection" class="collapsible z-depth-0" data-collapsible="accordion">
                                            <li class="collapsible-item-header avatar">
                                                <i class="material-icons circle light-blue">update</i>
                                                <span class="collapsible-title-header">Listado de IFIs Actuales</span>
                                                <p>Registros actuales por IFIs</p>
                                            </li>
                                            
                                            <li>

                                                <div class="collapsible-header-titles  sin-icon">
                                                    <div class="row">
                                                        <div class="col s1">
                                                            <p class="collapsible-title"></p>
                                                        </div>
                                                        <div class="col s4">
                                                            <p class="collapsible-title">IFI</p>
                                                        </div>
                                                        <div class="col s6">
                                                            <p class="collapsible-title">Créditos</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                            <?php $i=0;?>
                                            <?php if(count($actualIfis) > 0):?>
                                            <?php foreach($actualIfis as $actualIfisActual):?>
                                            <?php $i++;?>
                                            
                                            <li>
                                                <div class="collapsible-header sin-icon">
                                                    <div class="row">
                                                        <div class="col s1" style="padding: 0px;">
                                                            <p class="collapsible-content"><i class="material-icons blue-text">add</i></p>
                                                        </div>
                                                        <div class="col s4">
                                                            <p class="collapsible-content truncate"> <?php echo $actualIfisActual['6']; ?></p>
                                                        </div>
                                                        <div class="col s6">
                                                            <p class="collapsible-content truncate"><?php echo number_format($actualIfisActual['2']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapsible-body">
                                                    <p><b>Desembolsado: </b> L. <?php echo number_format($actualIfisActual['3'], 2, ".", ","); ?></p>
                                                    <p><b>Saldo: </b> L. <?php echo number_format($actualIfisActual['4'], 2, ".", ","); ?></p>
                                                    <p><b>Capital Mora: </b> L. <?php echo number_format($actualIfisActual['5'], 2, ".", ","); ?></p>
                                                </div>
                                            </li>
                                            
                                            <?php endforeach;?>
                                            <?php else:?>
                                            <li class="center">
                                                <h5>No hay ningún registros</h5>
                                            </li>
                                            <?php endif;?>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 l4">
                            <canvas id="chartActuales" width="100" height="160"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {
    $('#breadcrum-title').text('Reporte de IFIS');
    $('.collapsible').collapsible();
        //  OBTENIENDO EL ID PARA EL GRAFICO DE BARRAS
    var ctxBar = document.getElementById("charthistorico");
    var ctxBarActuales = document.getElementById("chartActuales");
    
    if(window.innerWidth < 993){
        $('#chartActuales').attr('height', '130');
        $('#charthistorico').attr('height', '130');
    }
    
    
    var dataBar = {
                labels: <?php echo json_encode($headersMoraIfi);?>,
                datasets: [
                    {
                        label: "Porcentaje de Mora",
                        backgroundColor: <?php echo json_encode($colorArray);?>,
                        borderColor: <?php echo json_encode($colorArray);?>,
                        borderWidth: 1,
                        data: <?php echo json_encode($porcentajeMoraIfiCount);?>,
                    }
                ]
            };
                  
                  
    new Chart(ctxBar, {
                type: "bar",
                data: dataBar,
                options: {
                    barValueSpacing: 50,
                      animation: {
                    duration: 0,
                    onComplete: function () {
                        // render the value of the chart above the bar
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.fillStyle = "#81c784";
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        this.data.datasets.forEach(function (dataset) {
                            for (var i = 0; i < dataset.data.length; i++) {
                                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                ctx.fillText(dataset.data[i]+'%', model.x, model.y - 5);
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
    
    //////////////////////////////////////////////////////////////////////
    
    var dataBarActuales = {
                labels: <?php echo json_encode($headersMoraIfiActual);?>,
                datasets: [
                    {
                        label: "Porcentaje de Mora",
                        backgroundColor: <?php echo json_encode($colorArray2);?>,
                        borderColor: <?php echo json_encode($colorArray2);?>,
                        borderWidth: 1,
                        data: <?php echo json_encode($porcentajeMoraIfiActualCount);?>,
                    }
                ]
            };
    
    new Chart(ctxBarActuales, {
                type: "bar",
                data: dataBarActuales,
                options: {
                    barValueSpacing: 50,
                      animation: {
                    duration: 0,
                    onComplete: function () {
                        // render the value of the chart above the bar
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.fillStyle = "#29B6F6";
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        this.data.datasets.forEach(function (dataset) {
                            for (var i = 0; i < dataset.data.length; i++) {
                                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                ctx.fillText(dataset.data[i]+'%', model.x, model.y - 5);
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

</script>
