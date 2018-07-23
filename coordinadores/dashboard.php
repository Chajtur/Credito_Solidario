<?php

require '../php/conection.php';

session_start();

$user = $_SESSION['user'];
/*query para obtener los creditos, mora y más*/
$sql = $conn->prepare('select count(a.Numero_Prestamo) as cartera, sum(if(a.capital_mora > 0, 1, 0)) as morosos, sum(saldo_capital) as saldo, sum(capital_mora) as mora from prestamo a, departamento c, gsc b where a.Estado_Credito = "Desembolsado" and (split_string(" ",c.idcoordinador,1) = :user or SPLIT_STRING(" ",c.idcoordinador, 2) = :user or SPLIT_STRING(" ",c.idcoordinador, 3) = :user) and c.nombre = a.Departamento and b.parent = :user and b.nombre = a.Supervisor');
$sql->bindValue(':user', $user, PDO::PARAM_STR);
$sql->execute();
$cartasDeEstado = $sql->fetchAll();

/*query para obtener los para tabla y grafico*/
$sql = $conn->prepare('Select get_agencia(a.gestor, a.agencia), count(*) as creditos, sum(a.Monto_Desembolsado) as desembolsado, sum(a.saldo_capital) as saldo, sum(a.capital_mora) as mora
from prestamo a, gsc b
where a.Estado_Credito = "Desembolsado" and a.Supervisor = b.nombre and b.parent = :user
group by get_agencia(a.gestor, a.agencia)');
$sql->bindValue(':user', $user, PDO::PARAM_STR);
$sql->execute();
$porMunicipio = $sql->fetchAll();
console.log($porMunicipio);
$headersMoraAgenciaCount = array();
$porcentajeMoraAgenciaCount = array();
for($i=0; $i< count($porMunicipio); $i++){
    $headersMoraAgenciaCount[$i] = $porMunicipio[$i]["0"] == null ? 'Por asignar' : $porMunicipio[$i]["0"];
    $porcentajeMoraAgenciaCount[$i] = number_format(($porMunicipio[$i]["4"]/$porMunicipio[$i]["3"])*100, 2, ".", ",");
  
}

$sql = $conn->prepare('select metaCreditos from metas where idUsuario = :user');
$sql->bindValue(':user', $user, PDO::PARAM_STR);
$sql->execute();
$metaAnual = $sql->fetchAll();


?>

<div class="section">

    <div class="row">
        <div id="card-stats">
            <div class="row margin">
                <div class="col s12 m8 l3 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat1" class="card">
                        <div class="card-content   white lighten-2 amber-text">
                            <p class="card-stats-title"><i class="material-icons">work</i> Total Créditos</p>
                            <h4 id="cartera-activa" class="card-stats-number"><?php echo number_format($cartasDeEstado[0]['cartera']); ?></h4>
                            <p class="card-stats-compare"><i class="material-icons">local_atm</i> <?php echo number_format($cartasDeEstado[0]['morosos']); ?> Morosos</p>
                        </div>
                        <div class="card-action amber lighten-3 center">
                            <!-- <div id="clients-bar" class="center-align"></div>-->
                            <!--<a href="#!" style="text-transform: lowercase;"><span class="white-text">ver detalles</span></a>-->
                        </div>
                    </div>
                </div>
                <div class="col s12 m8 l3 wow fadeInDown" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat2" class="card">
                        <div class="card-content white green-text">
                            <p class="card-stats-title"><i class="material-icons">attach_money</i> Saldo</p>
                            <h4 id="total-mora" class="card-stats-number">L. <?php echo number_format($cartasDeEstado[0]['saldo'], 2, ".", ","); ?></h4>
                            <p class="card-stats-compare"><i class="material-icons">local_atm</i> L. <?php echo number_format($cartasDeEstado[0]['mora'], 2, ".", ","); ?> en mora</p>
                        </div>
                        <div class="card-action green lighten-3 center">
                            <!--<div id="sales-compositebar" class="center-align"></div>-->
                            <!--<a href="#!" style="text-transform: lowercase;"><span class="white-text">ver detalles</span></a>-->
                        </div>
                    </div>
                </div>
                <div class="col s12 m8 l3 wow fadeInRight" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat3" class="card wow fadeInDown" data-wow-duration="1s">
                        <div class="card-content white red-text">
                            <p class="card-stats-title"><i class="material-icons">warning</i> Porcentaje Mora</p>
                            <h4 id="porcentaje-mora" class="card-stats-number red-text"><?php echo number_format(($cartasDeEstado[0]['mora']/($cartasDeEstado[0]['saldo'] == 0 || $cartasDeEstado[0]['saldo'] == null ? '1' : $cartasDeEstado[0]['saldo']))*100, 2, ".", ","); ?> %</h4>
                            <p class="card-stats-compare"><i class="material-icons red-text">error_outline</i> </p>
                        </div>
                        <div class="card-action red lighten-3 center">
                            <!-- <div id="profit-tristate" class="center-align"></div>-->
                            <!--<a href="#!" style="text-transform: lowercase;"><span class="white-text">ver detalles</span></a>-->
                        </div>
                    </div>
                </div>
                <div class="col s12 m8 l3 wow fadeInRight" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat3" class="card wow fadeInDown" data-wow-duration="1s">
                        <div class="card-content white blue-text">
                            <p class="card-stats-title"><i class="material-icons">work</i> Meta Anual</p>
                            <h4 id="porcentaje-mora" class="card-stats-number blue-text"><?php echo number_format($metaAnual); ?> Créditos</h4>
                            <p class="card-stats-compare"><i class="material-icons blue-text">error_outline</i> </p>
                        </div>
                        <div class="card-action blue lighten-3 center">
                            <!-- <div id="profit-tristate" class="center-align"></div>-->
                            <!--<a href="#!" style="text-transform: lowercase;"><span class="white-text">ver detalles</span></a>-->
                        </div>
                    </div>
                </div>
                <!--<div class="col s12 m8 l3 ">
                    <div id="cardStat4" class="card">
                        <div class="card-content green white-text">
                            <p class="card-stats-title"><i class="material-icons">store</i> Metas</p>
                            <h4 class="card-stats-number">####</h4>
                            <p class="card-stats-compare"><i class="material-icons">local_atm</i> #####</p>
                        </div>
                        <div class="card-action  green darken-2 center">
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 l8">
                            <div id="work-collections" class="">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                                        <ul id="projects-collection" class="collection" style="border: 1px solid #e0e0e0;">
                                            <li class="collection-item avatar">
                                                <i class="material-icons circle light-blue ">list</i>
                                                <span class="collection-header">Listado por Agencias</span>
                                                <p>detalles de créditos por agencias</p>
                                                
                                            </li>
                                            <li class="collection-item">
                                                <div class="row">
                                                    <div class="col s4 m2 l2">
                                                        <p class="collections-title">Municipio</p>
                                                    </div>
                                                    <div class="col s3 m3 l2">
                                                        <p class="collections-title">Créditos</p>
                                                    </div>
                                                    <div class="col s8 m3 l3 hide-on-small-only">
                                                        <p class="collections-title">Desembolsado</p>
                                                    </div>
                                                    <div class="col s3 hide-on-small-only">
                                                        <p class="collections-title">Saldo</p>
                                                    </div>
                                                    <div class="col s4 m3 l2 ">
                                                        <p class="collections-title">Capital Mora</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php $i=0;?>
                                            <?php if(count($porMunicipio) > 0):?>
                                                <?php foreach($porMunicipio as $porAgencias):?>
                                                    <?php $i++;?>
                                                        
                                                        <li class="collection-item">
                                                            <div class="row">
                                                                <div class="col s4 m2 l2 light">
                                                                    <p class="collections-content"><?php echo $porAgencias['0'] == null ? 'Por asignar' : $porAgencias['0'] ?></p>
                                                                </div>
                                                                <div class="col s3 m3 l2 light">
                                                                    <p class="collections-content"><?php echo number_format($porAgencias['1']); ?></p>
                                                                </div>
                                                                <div class="col s3 hide-on-small-only light">
                                                                    <p class="collections-content">L. <?php echo number_format($porAgencias['2'], 2, ".", ","); ?></p>
                                                                </div>
                                                                <div class="col s3 hide-on-small-only light">
                                                                    <p class="collections-content">L. <?php echo number_format($porAgencias['3'], 2, ".", ","); ?></p>
                                                                </div>
                                                                <div class="col s4 m3 l2 light">
                                                                    <p class="collections-content">L. <?php echo number_format($porAgencias['4'], 2, ".", ","); ?></p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        
                                                <?php endforeach;?>
                                            <?php else:?>
                                                <li class="center">
                                                    <h5>No hay ningún beneficiario</h5></li>
                                            <?php endif;?>
                                            <!--<li class="collection-item">
                                                <div class="row">
                                                    <div class="col s3 hide-on-small-only light">
                                                        <p class="collections-content">Atlantida</p>
                                                    </div>
                                                    <div class="col s8 m3 l2 light">
                                                        <p class="collections-content">31</p>
                                                    </div>
                                                    <div class="col s3 hide-on-small-only light">
                                                        <p class="collections-content">10,000</p>
                                                    </div>
                                                    <div class="col s2 hide-on-small-only light">
                                                        <p class="collections-content">45,000.00</p>
                                                    </div>
                                                    <div class="col s2 hide-on-small-only light">
                                                        <p class="collections-content">#######</p>
                                                    </div>
                                                </div>
                                            </li>-->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 l4">
                            <canvas id="myChartBar" width="100" height="110"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {

        $('#breadcrum-title').text('Reporte de desembolsos');
        //  OBTENIENDO EL ID PARA EL GRAFICO DE BARRAS
        var ctxBar = document.getElementById("myChartBar");
        
        
        var dataBar = {
                labels: <?php echo json_encode($headersMoraAgenciaCount);?>,
                datasets: [
                    {
                        label: "Porcentaje de Mora",
                        backgroundColor: [
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
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
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6',
                            '#29B6F6'
                        ],
                        borderWidth: 0,
                        data: <?php echo json_encode($porcentajeMoraAgenciaCount);?>,
                    }
                ]
            };
        
        new Chart(ctxBar, {
                type: "bar",
                data: dataBar,
                options: {
                    barValueSpacing: 20,
                      animation: {
                    duration: 0,
                    onComplete: function () {
                        // render the value of the chart above the bar
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(8, 'normal', Chart.defaults.global.defaultFontFamily);
                        /*ctx.fillStyle = "#29B6F6";*/
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        this.data.datasets.forEach(function (dataset) {
                            for (var i = 0; i < dataset.data.length; i++) {
                                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                ctx.fillText(dataset.data[i]+'%', model.x, model.y + 15);
                                
                                if(parseInt(dataset.data[i]) > 50){
                                    dataset.backgroundColor[i] = "#f44336";
                                    
                                } else if(parseInt(dataset.data[i]) > 9){
                                     dataset.backgroundColor[i] = "#ffc107";
                                     
                                } else {
                                    dataset.backgroundColor[i] = "#4caf50";
                                    
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

</script>
