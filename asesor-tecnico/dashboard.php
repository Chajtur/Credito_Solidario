<?php

require '../php/conection.php';
session_start();
$usuario		= $_SESSION['first_name']." ".$_SESSION['last_name'];
console.log($usuario);

/*query para obtener los departamentos*/
$sql = $conn->prepare('select count(*) as Cartera, sum(Monto_Desembolsado) as Desembolsado, sum(saldo_capital) as Saldo, sum(capital_mora) as Mora, sum(capital_mora)/sum(saldo_capital)*100 as Porcentaje from prestamo where Estado_Credito = "Desembolsado" and gestor = :usuario');


$sql->bindValue(':usuario', $usuario, PDO::PARAM_STR);

$sql->execute();
$cardstats = $sql->fetchAll();
 //var_dump($cardstats);
?>



<!--c3 chart-->
<link rel="stylesheet" href="../asesor/charts-asesor/c3-asesor.css">

<!--animate css-->
<link rel="stylesheet" href="../js/plugins/animate-css/animate.css">


<div class="secction">

    <div class="section">

        <!--card stats start-->
        <div id="card-stats">
            <div class="row">
                <div class="col s12 m6 l4 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat1" class="card">
                        <div class="card-content  teal accent-4 white-text">
                            <p class="card-stats-title"><i class="material-icons">timeline</i> Cartera Activa</p>
                            <h4 id="cartera-activa" class="card-stats-number"><?php echo $cardstats[0]["Cartera"]?></h4>
                            <!--<p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-up"></i> 15% <span class="green-text text-lighten-5">desde ayer</span>
                            </p>-->
                        </div>
                        <div class="card-action  teal darken-2">
                            <div id="clients-bar" class="center-align"></div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l4 wow fadeInDown" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat2" class="card">
                        <div class="card-content pink lighten-2 white-text">
                            <p class="card-stats-title"><i class="material-icons">trending_down</i>Total de Mora</p>
                            <h4 id="total-mora" class="card-stats-number">L. <?php echo number_format($cardstats[0]["Mora"], 2, ".", ","); ?></h4>
                            <!--<p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-up"></i> 70% <span class="purple-text text-lighten-5">en la última semana</span>
                            </p>-->
                        </div>
                        <div class="card-action pink darken-2">
                            <div id="sales-compositebar" class="center-align"></div>

                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l4 wow fadeInRight" data-wow-offset="10" data-wow-duration="1.5s">
                    <div id="cardStat3" class="card wow fadeInDown" data-wow-duration="1s">
                        <div class="card-content blue accent-2 white-text">
                            <p class="card-stats-title"><i class="material-icons">equalizer</i> Porcentaje Mora</p>
                            <h4 id="porcentaje-mora" class="card-stats-number"><?php echo number_format($cardstats[0]["Porcentaje"], 2, ".", ","); ?>%</h4>
                            <!--<p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-up"></i> 80% <span class="blue-grey-text text-lighten-5">último mes</span>
                            </p>-->
                        </div>
                        <div class="card-action blue accent-4">
                            <div id="profit-tristate" class="center-align"></div>
                        </div>
                    </div>
                </div>
                <!--<div class="col s12 m6 l3">
                                    <div id="cardStat4" class="card">
                                        <div class="card-content deep-purple white-text">
                                            <p class="card-stats-title"><i class="mdi-editor-insert-drive-file"></i> Clientes en baja</p>
                                            <h4 class="card-stats-number">498</h4>
                                            <p class="card-stats-compare"><i class="mdi-hardware-keyboard-arrow-down"></i> 3% <span class="deep-purple-text text-lighten-5">último mes</span>
                                            </p>
                                        </div>
                                        <div class="card-action  deep-purple darken-2">
                                            <div id="invoice-line" class="center-align"></div>
                                        </div>
                                    </div>
                                </div>-->
            </div>
        </div>
        <!--card stats end-->
        <div class="divider grey"></div>

    </div>

    <!--first line of charts-->
    <div class="section hide">
        <div class="row">
            <div class="col s12 m12 l6 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="card">
                    <div class="card-content">
                        <a class="waves-effect waves-indigo right dropdown-chart" data-activates='dropdown1'>
                            <i class="material-icons grey500">more_vert</i>
                        </a>
                        <span class="card-title">Estadistica de Creditos</span>
                        <p class="grey-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                        <div class="divider"></div>
                        <br>
                        <div id="chart1"></div>
                    </div>

                    <!--Card Reveal for the first pie chart-->
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">Card Title
                                            <i class="material-icons right">close</i>
                                        </span>
                        <div class="divider"></div>
                        <br>
                        <table class="bordered striped">
                            <thead>
                                <tr>
                                    <th data-field="id">Name</th>
                                    <th data-field="name">Item Name</th>
                                    <th data-field="price">Item Price</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Alvin</td>
                                    <td>Eclair</td>
                                    <td>$0.87</td>
                                </tr>
                                <tr>
                                    <td>Alan</td>
                                    <td>Jellybean</td>
                                    <td>$3.76</td>
                                </tr>
                                <tr>
                                    <td>Jonathan</td>
                                    <td>Lollipop</td>
                                    <td>$7.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col s12 m12 l6 wow fadeInRight" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="card">
                    <div class="card-content">
                        <a class="waves-effect waves-indigo right dropdown-chart" data-activates='dropdown2'>
                            <i class="material-icons grey500">more_vert</i>
                        </a>
                        <span class="card-title">Estadistica de Creditos 2</span>
                        <p class="grey-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                        <div class="divider"></div>
                        <br>
                        <div id="chartPie2"></div>
                    </div>

                    <!--Card Reveal for the second pie chart-->
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">Card Title 2
                                            <i class="material-icons right">close</i>
                                        </span>
                        <div class="divider"></div>
                        <br>
                        <table class="bordered striped">
                            <thead>
                                <tr>
                                    <th data-field="id">Name</th>
                                    <th data-field="name">Item Name</th>
                                    <th data-field="price">Item Price</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Alvin</td>
                                    <td>Eclair</td>
                                    <td>$0.87</td>
                                </tr>
                                <tr>
                                    <td>Alan</td>
                                    <td>Jellybean</td>
                                    <td>$3.76</td>
                                </tr>
                                <tr>
                                    <td>Jonathan</td>
                                    <td>Lollipop</td>
                                    <td>$7.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dropdown Structure chart pie 1 -->
        <ul id='dropdown1' class='dropdown-content'>
            <li><a onclick="reloapie1()" class="waves-effect waves-indigo"><i class="material-icons left">refresh</i>Actualizar</a></li>
            <li class="divider"></li>
            <li><a class="waves-effect waves-indigo activator"><i class="material-icons left">view_list</i>Detalles</a></li>
        </ul>
        <!-- Dropdown Structure chart pie 2 -->
        <ul id='dropdown2' class='dropdown-content'>
            <li><a onclick="reloapie2()" class="waves-effect waves-indigo"><i class="material-icons left">refresh</i>Actualizar</a></li>
            <li class="divider"></li>
            <li><a class="waves-effect waves-indigo activator"><i class="material-icons left">view_list</i>Detalles</a></li>
        </ul>
    </div>
    <!--first line of charts-->

    <!--second line of charts-->
    <div class="section hide">
        <div class="row">
            <div class="col s12 m12 l8 wow slideInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="card">
                    <div class="card-content">
                        <a class="waves-effect waves-indigo right">
                            <i class="material-icons grey500">refresh</i>
                        </a>
                        <span class="card-title">Estadistica de Otras</span>
                        <p class="grey-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                        <div class="divider"></div>
                        <br>
                        <div id="highchart5" style="height: 300px; margin: 0 auto"></div>
                    </div>

                </div>
            </div>
            <div class="col s12 m12 l4 wow slideInRight" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Card Title</span>
                        <div class="divider"></div>
                        <br>
                        <ul class="collection">

                            <li class="collection-item avatar">
                                <i class="material-icons circle">folder</i>
                                <span class="title">Title</span>
                                <p>First Line
                                    <br> Second Line
                                </p>
                                <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons circle green">insert_chart</i>
                                <span class="title">Title</span>
                                <p>First Line
                                    <br> Second Line
                                </p>
                                <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
                            </li>
                            <li class="collection-item avatar">
                                <i class="material-icons circle red">play_arrow</i>
                                <span class="title">Title</span>
                                <p>First Line
                                    <br> Second Line
                                </p>
                                <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-action">
                        <a class="waves-effect wave-indigo" href="#">This is a link</a>
                        <a class="waves-effect wave-indigo" href="#">This is a link</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--second line of charts-->

</div>


<!--c3 chart js-->
<script src="../js/plugins/d3/d3.js"></script>
<script src="../js/plugins/d3/c3/c3.js"></script>
<script src="../asesor/charts-asesor/c3-asesor.js"></script>

<!--sparklines chart-->
<script src="../js/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="../asesor/charts-asesor/sparklines-asesor.js"></script>

<!--hight chart-->
<script type="text/javascript" src="../js/plugins/highcharts/highcharts.js"></script>
<script src="../asesor/charts-asesor/hightchart-asesor.js"></script>

<!-- wow.js - Add animation to items-->
<script type="text/javascript" src="../js/wow-animation/wow.js"></script>
<!--init the wow.js script-->
<script>
    $(document).ready(function(){
       $('.dropdown-chart').dropdown({
            inDuration: 300,
            outDuration: 125,
            constrain_width: false, // Does not change width of dropdown to that of the activator
            hover: false, // Activate on click
            alignment: 'right', // Aligns dropdown to left or right edge (works with constrain_width)
            gutter: 0, // Spacing from edge
            belowOrigin: true // Displays dropdown below the button
        });
        
        $('.header-search-wrapper').hide();
        
        
        
    });
    new WOW().init();
</script>