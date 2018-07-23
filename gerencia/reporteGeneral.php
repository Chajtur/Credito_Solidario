<?php

require '../php/conection.php';

//$archivo = new PHPExcel();

$date = new DateTime();

$sql = $conn->prepare('
select count(*) as  cantidad, sum(Monto_Desembolsado) as monto_total 
from prestamo 
where Fecha_Desembolso between "'.$date->format("Y-m-").'01" and "'.$date->format("Y-m-d").'"');
$sql->execute();
$mes = $sql->fetchAll();

$array_meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

$sql = $conn->prepare('
select count(*), sum(monto_desembolsado) from prestamo where if((ciclo is null), if(monto_desembolsado between 1 and 5000,1,if(monto_desembolsado between 5001 and 10000,2,if(monto_desembolsado between 10001 and 20000,3,1))),ciclo) not in ("2","12","3")');
$sql->execute();
$query_beneficiario = $sql->fetchAll();



$sql = $conn->prepare('
SELECT
	count(*) AS cantidad_total,
	round(sum(Monto_Desembolsado), 2) AS monto_desembolsado,
	(select sum(saldo_capital) from prestamo where (usuario_digitador = "Limpia") and estado_credito = "Desembolsado") AS saldo_capital_total,
	(select sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0)) from prestamo where (usuario_digitador = "Limpia") and estado_credito = "Desembolsado") AS capital_mora_total,
	(select format((((sum(if(DATEDIFF(current_date,if((fecha_ultimo_pago is null or fecha_ultimo_pago = "0000-00-00"),fecha_desembolso,fecha_ultimo_pago)) > 15,if(capital_mora < 0, 0, capital_mora),0))) / sum(saldo_capital)) * 100),4) from prestamo where (usuario_digitador = "Limpia") and estado_credito = "Desembolsado") as porcentaje_mora
FROM
	prestamo');
$sql->execute();
$general = $sql->fetchAll();

$sql = $conn->prepare('select creditos, monto from metas_mes where mes = MONTH(CURRENT_DATE())');
$sql->execute();
$meta = $sql->fetch(PDO::FETCH_ASSOC);

$sql = $conn->prepare('select day(max(fecha_desembolso)) as dia, year(max(fecha_desembolso)) as anio from prestamo');
$sql->execute();
$dia = $sql->fetchAll();


?>


    <div class="section">
        <div class="row">
            <div class="col s12 m12 l8">
                <div id="card-alert" class="card blue">
                      <div class="card-content white-text">
                        <p>INFO : Aquí se presenta la información relacionada con el reporte general</p>
                      </div>
                      <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                </div>
                <div id="work-collections" class="">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                            <ul id="projects-collection" class="collection z-depth-1">
                                <li class="collection-item avatar">
                                    <i class="material-icons circle light-blue ">timeline</i>
                                    <span class="collection-header">Metas del Mes de <?php echo $array_meses[$date->format('m') - 1]; ?></span>
                                    <p>información acerca de las metas mensuales</p>
                                    <!--<div class="secondary-content actions">
                                        <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                        <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                            <i class="material-icons center-align">search</i>
                                        </a>
                                    </div>-->
                                    <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s6 m6 l6">
                                            <p class="collections-title">Meta de Créditos</p>
                                        </div>
                                        <div class="col s6 m6 l6">
                                            <p class="collections-title">Meta de Monto</p>
                                        </div>

                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s6">
                                            <p class="collections-content"><?php echo number_format($meta['creditos'], 2, ".", ",") ?></p>
                                            <span class="task-cat green darken-3 collections-content"><?php echo number_format(($mes[0]['cantidad'] / $meta['creditos'])*100) ?>% completado</span>
                                        </div>
                                        <div class="col s6">
                                            <p class="collections-content">L. <?php echo number_format($meta['monto'], 2, ".", ",") ?></p>
                                            <span class="task-cat green darken-3 collections-content"><?php echo number_format(($mes[0]['monto_total'] / $meta['monto']) * 100) ?>% completado</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="work-collections" class="">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                            <ul id="projects-collection" class="collection z-depth-1">
                                <li class="collection-item avatar">
                                    <i class="material-icons circle amber ">trending_down</i>
                                    <span class="collection-header">Faltante para completar Meta de <?php echo $array_meses[$date->format('m') - 1]; ?></span>
                                    <p>información acerca de las faltantes para completar metas</p>
                                    <!--<div class="secondary-content actions">
                                        <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                        <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                            <i class="material-icons center-align">search</i>
                                        </a>
                                    </div>-->
                                    <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s6 m6 l6">
                                            <p class="collections-title">Créditos faltantes para colocar</p>
                                        </div>
                                        <div class="col s6 m6 l6">
                                            <p class="collections-title">Monto faltante para desembolsar</p>
                                        </div>

                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s6">
                                            <p class="collections-content"><?php echo number_format($meta['creditos'] - $mes[0]['cantidad'], 2, ".", ",") ?> créditos</p>
                                            <span class="task-cat red darken-3 collections-content"><?php echo number_format((($meta['creditos'] - $mes[0]['cantidad'])/$meta['creditos'])*100) ?>% faltante</span>
                                        </div>
                                        <div class="col s6">
                                            <p class="collections-content">L. <?php echo number_format($meta['monto'] - $mes[0]['monto_total'], 2, ".", ",") ?></p>
                                            <span class="task-cat red darken-3 collections-content"><?php echo number_format((($meta['monto'] - $mes[0]['monto_total']) / $meta['monto'])*100) ?>% faltante</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m4 l4">
                <ul class="collection with-header z-depth-1">
                    <li class="collection-header">
                        <h5><?php echo $array_meses[$date->format('m') - 1]. ', '.$dia[0]['dia']; ?></h5></li>
                    <li class="collection-item">
                        <div>Cantidad Total de Créditos<span class="secondary-content"><?php echo number_format($mes[0]['cantidad']); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Monto Total Desembolsado<span class="secondary-content">L.<?php echo number_format($mes[0]['monto_total'], 2, ".", ","); ?></span></div>
                    </li>
                </ul>

                <ul class="collection with-header z-depth-1">
                    <li class="collection-header">
                        <h5>Historico</h5></li>
                    <li class="collection-item">
                        <div>Cantidad Total de Créditos<span class="secondary-content"><?php echo number_format($general[0]['cantidad_total']); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Total Desembolsado<span class="secondary-content">L.<?php echo number_format($general[0]['monto_desembolsado'], 2, ".", ","); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Beneficiarios<span class="secondary-content"><?php echo number_format($query_beneficiario[0]["count(*)"]); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Saldo Capital<span href="#!" class="secondary-content">L.<?php echo number_format($general[0]['saldo_capital_total'], 2, ".", ","); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>Capital en Mora<span class="secondary-content">L.<?php echo number_format($general[0]['capital_mora_total'], 2, ".", ","); ?></span></div>
                    </li>
                    <li class="collection-item">
                        <div>% de Mora<span class="secondary-content"><?php echo $general[0]['porcentaje_mora'].'%'; ?></span></div>
                    </li>
                </ul>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {

            $('.icon-collapse-search').click(function () {
                $('.search-expandida').toggleClass('expanded');
                $('.search-expandida').focus();
            });
            $('#breadcrum-title').text('Reporte General');
            
            
            $("#card-alert .close").click(function(){
                $(this).closest('#card-alert').fadeOut('slow');
            });

        });
    </script>