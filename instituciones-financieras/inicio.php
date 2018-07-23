<?php

session_Start();
require '../php/conection.php';

$stat = $conn->prepare('call obtener_datos_generales_ifi(:nombre_ifi)');
$stat->bindValue(':nombre_ifi', $_SESSION['first_name'], PDO::PARAM_STR);
$stat->execute();
$valores = $stat->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <div class="row">

        <div id="card-stats">

            <div class="row margin">

                <div class="col s12 m8 l3 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat1" class="card">
                        <div class="card-content green white-text">
                            <p class="card-stats-title"><i class="material-icons">history</i> Histórico</p>
                            <h4 id="cartera-activa" class="card-stats-number"><?php echo $valores['cantidadHistorico'];?></h4>
                            <p class="card-stats-compare"><i class="material-icons">local_atm</i> L.
                                <?php echo $valores['montoDesembolsadoHistorico'];?>
                            </p>
                        </div>
                        <div class="card-action green darken-2 center">
                            <!-- <div id="clients-bar" class="center-align"></div>-->
                            <span class="white-text">Saldo Histórico: L. <?php echo $valores['saldoHistorico'];?></span>
                        </div>
                    </div>
                </div>

                <div class="col s12 m8 l3 wow fadeInDown" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat2" class="card">
                        <div class="card-content teal white-text">
                            <p class="card-stats-title"><i class="material-icons">today</i> Actual</p>
                            <h4 id="total-mora" class="card-stats-number"><?php echo $valores['cantidadActual'];?></h4>
                            <p class="card-stats-compare"><i class="material-icons">local_atm</i> L.
                                <?php echo $valores['montoDesembolsadoActual'];?>
                            </p>
                        </div>
                        <div class="card-action teal darken-2 center">
                            <!--<div id="sales-compositebar" class="center-align"></div>-->
                            <span class="white-text"><?php echo $valores['moraActual'];?>% de mora</span>
                        </div>
                    </div>
                </div>

                <div class="col s12 m8 l3 wow fadeInRight" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat3" class="card wow fadeInDown" data-wow-duration="1s">
                        <div class="card-content deep-purple white-text">
                            <p class="card-stats-title"><i class="material-icons">attach_money</i> Recuperado</p>
                            <h4 id="porcentaje-mora" class="card-stats-number"><?php echo $valores['cantidadCreditosRecuperado'];?></h4>
                            <p class="card-stats-compare"><i class="material-icons">local_atm</i> L.
                                <?php echo $valores['montoRecuperado'];?>
                            </p>
                        </div>
                        <div class="card-action deep-purple darken-2 center">
                            <!-- <div id="profit-tristate" class="center-align"></div>-->
                            <span class="white-text"><?php echo $valores['porcentajeRecuperado'];?>% de mora</span>
                        </div>
                    </div>
                </div>

                <div class="col s12 m8 l3">
                    <div id="cardStat4" class="card">
                        <div class="card-content indigo white-text">
                            <p class="card-stats-title"><i class="material-icons">money_off</i> Mora</p>
                            <h4 class="card-stats-number"><?php echo $valores['cantidadMora'];?></h4>
                            <p class="card-stats-compare"><i class="material-icons">local_atm</i> L.
                                <?php echo $valores['montoMora'];?>
                            </p>
                        </div>
                        <div class="card-action indigo darken-2 center">
                            <!--<div id="clients-bar" class="center-align"></div>-->
                            <span class="white-text"><?php echo $valores['moraHistorico'];?>% de mora</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col l4 m4 s12">
            <div class="card-panel" style="height:350px; max-height:350px">
                <canvas id="graphSanosMorosos"></canvas>
            </div>
        </div>

        <div class="col l8 m8 s12">
            <div class="card-panel" style="height:350px; max-height:350px">
                <canvas id="graphSaldoMoraRecuperado"></canvas>
            </div>
        </div>

    </div>

    <script>

        $(document).ready(function(){
            initGraphSaldoMoraRecuperado();
            initGraphSanosMorosos();
        });

        function initGraphSaldoMoraRecuperado(){

            var context2d = document.getElementById('graphSaldoMoraRecuperado').getContext('2d');
            var chartSaldoMoraRecuperado = new Chart(context2d, {
                // The type of chart we want to create
                type: 'horizontalBar',

                // The data for our dataset
                data: {
                    labels: ["Desembolsado", "Recuperado", "Mora"],
                    datasets: [{
                        label: "Total Desembolsado",
                        backgroundColor: ['#03a9f4','#4caf50', '#f44336'],
                        borderColor: 'rgb(255, 255, 255)',
                        data: [100, 20, 10],
                    }]
                },

                // Configuration options go here
                options: {
                    // scales: {
                    //     yAxes: [{
                    //         barPercentage: 0.2
                    //     }]
                    // }
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

        }

        function initGraphSanosMorosos(){

            var context2d = document.getElementById('graphSanosMorosos').getContext('2d');
            var chartSaldoMoraRecuperado = new Chart(context2d, {
                // The type of chart we want to create
                type: 'doughnut',

                // The data for our dataset
                data: {
                    labels: ["Créditos Sanos", "Morosos"],
                    datasets: [{
                        label: "Comparativa Créditos Sanos vs Morosos",
                        backgroundColor: ['#2196f3','#6a1b9a'],
                        borderColor: 'rgb(255, 255, 255)',
                        data: [100, 20],
                    }]
                },

                // Configuration options go here
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

        }
    </script>

</body>
</html>