<?php

require '../php/conection.php';
session_start();
$stat = $conn->prepare('select count(*) as cantidad, sum(a.capital) as suma_pagos, (
    select count(*) as cantidad
    from cartera_consolidada
    where Estatus_Prestamo = "Colocado"
    and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')
) as desembolsos_pendientes, (
    select count(*) as cantidad
    from cartera_consolidada
    where Estatus_Prestamo = "Desembolsado"
    and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')
) as cantidad_desembolsos, (
    select sum(Monto_Autorizado) as cantidad
    from cartera_consolidada
    where Estatus_Prestamo = "Desembolsado"
    and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')
) as cantidad_dinero_desembolsos,(
    select count(*) as cantidad
    from cartera_consolidada
    where Estatus_Prestamo = "Desembolsado"
    and Fecha_Desembolso >= concat(YEAR(CURRENT_DATE()), "-", month(current_date()), "-", "01")
    and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')
) as desembolsos_mes from pagos a 
left join prestamo b on a.numero_prestamo = b.Numero_Prestamo 
where b.agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');

$stat->execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);

?>
<!--start container-->
<div class="container">
    <div class="section">
        <div class="row">
            <div id="card-stats">
                <div class="row margin">
                    <div class="col s12 m8 l4 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat1" class="card">
                            <div class="card-content  teal accent-4 white-text">
                                <p class="card-stats-title"><i class="material-icons">timeline</i> Pagos totales</p>
                                <h4 id="cartera-activa" class="card-stats-number"><?php echo $result['cantidad'];?></h4>
                                <p class="card-stats-compare"><i class="material-icons">equalizer</i> <?php echo $result['suma_pagos'];?> <span class="green-text text-lighten-5">recuperado</span>
                                </p>
                            </div>
                            <div class="card-action  teal darken-2">
                                <!-- <div id="clients-bar" class="center-align"></div>-->
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l4 wow fadeInDown" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat2" class="card">
                            <div class="card-content pink lighten-2 white-text">
                                <p class="card-stats-title"><i class="material-icons">trending_down</i>Desembolsos</p>
                                <h4 id="total-mora" class="card-stats-number"><?php echo $result['cantidad_desembolsos'];?></h4>
                                <p class="card-stats-compare"><i class="material-icons">equalizer</i>L. <?php echo number_format($result['cantidad_dinero_desembolsos'], 2, '.',',');?> <span class="purple-text text-lighten-5">total</span>
                                </p>
                            </div>
                            <div class="card-action pink darken-2">
                                <!--<div id="sales-compositebar" class="center-align"></div>-->

                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l4 wow fadeInRight" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat3" class="card wow fadeInDown" data-wow-duration="1s">
                            <div class="card-content blue accent-2 white-text">
                                <p class="card-stats-title"><i class="material-icons">equalizer</i> Pendientes</p>
                                <h4 id="porcentaje-mora" class="card-stats-number"><?php echo $result['desembolsos_pendientes'];?></h4>
                                <p class="card-stats-compare"><i class="material-icons">equalizer</i><?php echo $result['desembolsos_mes'];?> <span class="blue-grey-text text-lighten-5">desembolsos més</span>
                                </p>
                            </div>
                            <div class="card-action blue accent-4">
                                <!-- <div id="profit-tristate" class="center-align"></div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l4 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="card">
                    <div class="card-content">
                        <a class="waves-effect waves-indigo right dropdownPie" data-activates='dropdownPie'>
                            <i class="material-icons grey500">more_vert</i>
                        </a>
                        <span class="card-title">Estadistica de Creditos</span>
                        <!--<p class="grey-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                <div class="divider"></div>-->
                        <br>
                        <div id="">
                            <canvas id="myChart" width="100" height="100"></canvas>
                        </div>
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
            <div class="col s12 m12 l4 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="card">
                    <div class="card-content">
                        <a class="waves-effect waves-indigo right dropdownPolar" data-activates='dropdownPolar'>
                            <i class="material-icons grey500">more_vert</i>
                        </a>
                        <span class="card-title">Estadistica de Creditos</span>
                        <!--<p class="grey-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                <div class="divider"></div>-->
                        <br>
                        <div id="">
                            <canvas id="myChart4" width="100" height="100"></canvas>
                        </div>
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
            <div class="col s12 m12 l4 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="card">
                    <div class="card-content">
                        <a class="waves-effect waves-indigo right dropdownDona" data-activates='dropdownDona'>
                            <i class="material-icons grey500">more_vert</i>
                        </a>
                        <span class="card-title">Estadistica de Creditos</span>
                        <!--<p class="grey-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                <div class="divider"></div>-->
                        <br>
                        <div id="">
                            <canvas id="myChart3" width="100" height="100"></canvas>
                        </div>
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
                                            <ul id="projects-collection" class="collection">
                                                <li class="collection-item avatar">
                                                    <i class="material-icons circle light-blue ">list</i>
                                                    <span class="collection-header">Asesores</span>
                                                    <p>registrados en la App</p>
                                                    <div class="secondary-content actions">
                                                        <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                                        <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                            <i class="material-icons center-align">search</i>
                                                        </a>
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
                                                            <p class="collections-title">Departamento</p>
                                                        </div>
                                                        <div class="col s8 m3 l3">
                                                            <p class="collections-title">Créditos/Morosos</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">Desembolsado</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">Saldo/C. en Mora</p>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">Atlantida</p>
                                                        </div>
                                                        <div class="col s8 m3 l3">
                                                            <p class="collections-title">31</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">10,000</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">45,000.00</p>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">Atlantida</p>
                                                        </div>
                                                        <div class="col s8 m3 l3">
                                                            <p class="collections-title">31</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">10,000</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">45,000.00</p>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">Atlantida</p>
                                                        </div>
                                                        <div class="col s8 m3 l3">
                                                            <p class="collections-title">31</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">10,000</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">45,000.00</p>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">Atlantida</p>
                                                        </div>
                                                        <div class="col s8 m3 l3">
                                                            <p class="collections-title">31</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">10,000</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">45,000.00</p>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">Atlantida</p>
                                                        </div>
                                                        <div class="col s8 m3 l3">
                                                            <p class="collections-title">31</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">10,000</p>
                                                        </div>
                                                        <div class="col s3 hide-on-small-only">
                                                            <p class="collections-title">45,000.00</p>
                                                        </div>

                                                    </div>
                                                </li>
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
        
        <!--<div class="row">
            <div class="col s12">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
            <div class="col s12">
                <canvas id="myChart2" width="400" height="400"></canvas>
            </div>
        </div>-->
        
        <!-- Dropdown Structure chart pie 1 -->
        <ul id='dropdownPie' class='dropdown-content'>
            <li><a class="waves-effect waves-indigo"><i class="material-icons left">refresh</i>Actualiza</a></li>
            <li class="divider"></li>
            <li><a class="waves-effect waves-indigo activator"><i class="material-icons left">view_list</i>Detalles</a></li>
        </ul>
        
        <!-- Dropdown Structure chart polar 1 -->
        <ul id='dropdownPolar' class='dropdown-content'>
            <li><a class="waves-effect waves-indigo"><i class="material-icons left">refresh</i>Actualizar</a></li>
            <li class="divider"></li>
            <li><a class="waves-effect waves-indigo activator"><i class="material-icons left">view_list</i>Detalles</a></li>
        </ul>
        
        <!-- Dropdown Structure chart dona 1 -->
        <ul id='dropdownDona' class='dropdown-content'>
            <li><a class="waves-effect waves-indigo"><i class="material-icons left">refresh</i>Actualizar</a></li>
            <li class="divider"></li>
            <li><a class="waves-effect waves-indigo activator"><i class="material-icons left">view_list</i>Detalles</a></li>
        </ul>
        <div class="divider"></div>
    </div>
</div>


<script>
        $(document).ready(function () {
            
            $('.dropdownPie').dropdown({
                inDuration: 300,
                outDuration: 225,
                constrainWidth: false, // Does not change width of dropdown to that of the activator
                hover: true, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: true, // Displays dropdown below the button
                alignment: 'right', // Displays dropdown with edge aligned to the left of button
                stopPropagation: true // Stops event propagation
                }
            );
            
            $('.dropdownPolar').dropdown({
                inDuration: 300,
                outDuration: 225,
                constrainWidth: false, // Does not change width of dropdown to that of the activator
                hover: true, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: true, // Displays dropdown below the button
                alignment: 'right', // Displays dropdown with edge aligned to the left of button
                stopPropagation: true // Stops event propagation
                }
            );
            
            $('.dropdownDona').dropdown({
                inDuration: 300,
                outDuration: 225,
                constrainWidth: false, // Does not change width of dropdown to that of the activator
                hover: true, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: true, // Displays dropdown below the button
                alignment: 'right', // Displays dropdown with edge aligned to the left of button
                stopPropagation: true // Stops event propagation
                }
            );
            
            $('.icon-collapse-search').click(function () {
                $('.search-expandida').toggleClass('expanded');
                $('.search-expandida').focus();
            });
            $('#breadcrum-title').text('##############');

            $('.collapsible').collapsible();
            $('.dropdown-chart').dropdown({

            });
            $('.tap-target').tapTarget('open');


            var ctx = document.getElementById("myChart"); //grafico pastel #1
            var ctx2 = document.getElementById("myChart2"); // grafico polar #2 NO APARECE, ESTA COMENTADO
            var ctx3 = document.getElementById("myChart3"); // graafico dona #3 
            var ctx4 = document.getElementById("myChart4").getContext("2d"); // grafico polar #4 ES EL TERCERO QUE APARECE
            var ctxBar = document.getElementById("myChartBar");



/////////////////////////////////////////////////////////// DATOS DE GRAFICOS ///////////////////////////////////////////////////////////////////////

            // DATOS DEL GRAFICO PASTEL #1
            var data = {
                labels: [
                    "Blue Dark",
                    "Blue dark1",
                    "Blue dark2"
                ],
                datasets: [
                    {
                        data: [30, 50, 20],
                        backgroundColor: [
                            "#0d47a1",
                            "#1565c0",
                            "#1976d2"
                        ],
                        hoverBackgroundColor: [
                            "#2196f3",
                            "#42a5f5",
                            "#64b5f6"
                        ]
                }]
            };


            //DATOS DEL GRAFICO POLAR #2
            /*var data2 = {
                labels: [
                    "Blue",
                    "grey",
                    "teal"
                ],
                datasets: [
                    {
                        data: [50, 20,30],
                        backgroundColor: [
                            "#009688",
                            "#00bfa5",
                            "#00bfa5"
                        ],
                        hoverBackgroundColor: [
                            "#009688",
                            "#00bfa5",
                            "#00bfa5"
                        ]
                }]
            };*/

            //DATOS DEL GRAFICO POLAR #4, ESTE SI APARECE
            var data4 = {
                datasets: [{
                    data: [
                        20,
                        25,
                        30,
                        35
                    ],
                    backgroundColor: [
                        "rgba(255, 0, 0, 0.5)",
                        "rgba(100, 255, 0, 0.5)",
                        "rgba(200, 50, 255, 0.5)",
                        "rgba(0, 100, 255, 0.5)"
                    ],
                    label: 'My dataset' // for legend
                }],
                labels: [
                    "Red",
                    "Green",
                    "Yellow",
                    "Grey"
                ]
            };


            //DATOS DEL GRAFICO DONA #3
            var data3 = {
                labels: [
                    "###########",
                    "###########",
                    "###########"
                ],
                datasets: [
                    {
                        data: [30, 50, 20],
                        backgroundColor: [
                            "#0d47a1",
                            "#1976d2",
                            "#2196f3"
                        ],
                        hoverBackgroundColor: [
                            "#0d47a1",
                            "#1976d2",
                            "#2196f3"
                        ]
                }]
            };

            var dataBar = {
                labels: ["January", "February", "March", "April"],
                datasets: [
                    {
                        label: "My First dataset",
                        backgroundColor: [
                            '#0d47a1',
                            '#1565c0',
                            '#1976d2',
                            '#1e88e5'
                        ],
                        borderColor: [
                            '#0d47a1',
                            '#1565c0',
                            '#1976d2',
                            '#1e88e5'
                        ],
                        borderWidth: 1,
                        data: [65, 59, 80, 81],
                    }
                ]
            };

///////////////////////////////////////////////////////////// CREACIÓN DE GRAFICOS ////////////////////////////////////////////////////////////////////

            //CREACION DEL GRAFICO PASTEL #1
            var myDoughnutChart = new Chart(ctx, {
                type: 'pie',
                data: data,
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Custom Chart Title'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontColor: 'rgb(255, 99, 132)'
                        }
                    },
                    hover: {
                        // Overrides the global setting
                        mode: 'index',
                        responsive: true,
                        animationDuration: 400
                    },
                    tooltips: {
                        intersect: true
                    }
                }
            });


            //CREACION DEL GRAFICO POLAR #2, PERO ESTA COMENTADO
            /*var grafico2 = new Chart(ctx2, {
                type: 'polarArea',
                data: data2,
                maintainAspectRatio: false,
                options: {
                    responsive: true,
                   scaleStartValue: 0,
                    animation:{
                        animateScale:true
                    },
                    title: {
                        display: true,
                        text: 'Custom Chart Title'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontColor: 'rgb(255, 99, 132)'
                        }
                    },
                    hover: {
                        // Overrides the global setting
                        mode: 'index',
                        responsive: true,
                        animationDuration: 400
                    },
                    tooltips: {
                        enabled: true,
                        intersect: true
                    }/*,
                    pieceLabel: {
                        mode: 'percentage',
                        precision: 0,
                        fontSize: 12,
                        fontColor: '#fff'
                    }*/
            //}
            //  });*/


            //CREACION DEL GRAFICO POLAR #4
            var grafico2 = new Chart(ctx4, {
                type: 'polarArea',
                data: data4,
                options: {
                    title: {
                        display: true,
                        text: 'Custom Chart Title'
                    },
                    legend: {
                        position: 'bottom',

                    },
                    scaleShowLabelBackdrop: true,
                    scaleBackdropColor: "rgba(255,255,255,0.75)",
                    scaleBeginAtZero: true,
                    scaleBackdropPaddingY: 2,
                    scaleBackdropPaddingX: 2,
                    scaleShowLine: true,
                    segmentShowStroke: true,
                    segmentStrokeColor: "#fff",
                    segmentStrokeWidth: 2,
                    animationSteps: 100,
                    tooltipCornerRadius: 2,
                    animationEasing: "easeOutBounce",
                    animateRotate: true,
                    animateScale: false,
                    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
                    responsive: true
                }
            });

            //CREACION DEL GRAFICO DONA #3
            var grafico3 = new Chart(ctx3, {
                type: 'doughnut',
                data: data3,
                maintainAspectRatio: false,
                options: {
                    responsive: true,
                    scaleStartValue: 0,
                    animation: {
                        animateScale: true
                    },
                    title: {
                        display: true,
                        text: 'Custom Chart Title'
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontColor: 'rgb(255, 99, 132)'
                        }
                    },
                    hover: {
                        // Overrides the global setting
                        mode: 'index',
                        responsive: true,
                        animationDuration: 400
                    },
                    tooltips: {
                        enabled: true,
                        intersect: true
                    },
                    pieceLabel: {
                        mode: 'percentage',
                        precision: 0,
                        fontSize: 12,
                        fontColor: '#fff'
                    }
                }
            });
            
            
            new Chart(ctxBar, {
                type: "bar",
                data: dataBar,
                options: {
                    scales: {
                        xAxes: [{
                            stacked: true
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });

        });
</script>