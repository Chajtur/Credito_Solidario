
<?php

if(isset($_GET['prestamo'])){
    
    require '../php/conection.php';
    $stat = $conn->prepare('
    select a.Monto_Desembolsado, a.capital_mora, a.saldo_capital, a.fecha_ultimo_pago, 
    a.Nombre_Completo, a.Identidad, a.Ciclo, a.Estado_Credito, b.Plazo, a.Fecha_Desembolso,
    a.Numero_Prestamo, a.Nombre_Completo, b.Identidad, a.Estado_Credito, a.cuotas_vencidas
    from prestamo a left join cartera_consolidada b 
    on a.Numero_Prestamo = b.Prestamo_Numero 
    where estado_credito = "Desembolsado" and a.Numero_Prestamo = :prestamo
    ');
    $stat->bindValue(':prestamo', $_GET['prestamo'], PDO::PARAM_STR);
    $stat->execute();
    $datos = $stat->fetch(PDO::FETCH_ASSOC);

    $stat_pagos = $conn->prepare('select * from pagos where numero_prestamo = :numero');
    $stat_pagos->bindValue(':numero', $_GET['prestamo'], PDO::PARAM_STR);
    $stat_pagos->execute();
    $pagos = $stat_pagos->fetchAll(PDO::FETCH_ASSOC);

}

?>
<div class="section">
    <div class="row">
        <div class="col l12 m12 s12 no-padding">
            <div class="row">
                <div class="col l12 m12 s12 no-padding">
                    <a href="#!" class="btn-flat waves-effect transparent z-depth-0 black-text" id="btn-regresar"><i class="material-icons left">arrow_back</i>Regresar</a>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($_GET['prestamo']) && isset($datos)):?>
    <input type="hidden" id="numero-prestamo" value="<?php echo $_GET['prestamo'];?>">
    <div class="row margin">
        <div class="col s12 m4 l4">
            <div class="card">
                <div class="card-content center">
                    <a style="" class="waves-effect waves-light btn z-depth-0 white-text btn-pagar"><i class="material-icons left">credit_card</i>Realizar Pago</a>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Datos Personales</span>
                    <div class="divider"></div>
                    <div class="title-personal-mosquitia">
                        <h5>Nombre:</h5>
                        <p><?php echo $datos['Nombre_Completo'];?></p>
                        <h5>Identidad:</h5>
                        <p><?php echo $datos['Identidad'];?></p>
                        <h5>Estado:</h5>
                        <p><?php echo $datos['Estado_Credito'];?></p>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Información  del Crédito</span>
                    <div class="divider"></div>
                    <div class="title-personal-mosquitia">
                        <h5>Cuota:</h5>
                        <?php 
                        $plazo = ($datos['Ciclo'] == 1 ? 26 : ($datos['Ciclo'] == 2 ? 52 : ($datos['Ciclo'] == 3 ? 78 : 26)));
                        $pago = ((0.12/52)*($datos['Monto_Desembolsado']))/(1-(pow((1+(0.12/52)),(-1*(preg_replace("/[^0-9]/","",$plazo))))));
                        ?>
                        <p><?php echo $pago;?></p>
                        <h5>Cuotas vencidas</h5>
                        <p><?php echo $datos['cuotas_vencidas'];?></p>
                        <h5>Monto del préstamo:</h5>
                        <p>L.<?php echo $datos['Monto_Desembolsado'];?></p>
                        <h5>Saldo Capital:</h5>
                        <p>L.<?php echo $datos['saldo_capital'];?></p>
                    </div>
                </div>
            </div>
            
            <!--<div class="card">
                <div class="card-content">
                    <span class="card-title">Reporte de Pagos!</span>
                    <p>Realiza un reporte de los pagos recibidos en un rango de fecha de tu elección.</p>
                    <form>
                        <div class="row">
                            <div class="input-field col s12">
                                <select>
                                    <option value="" disabled selected>Seleccione una IFI</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                </select>
                                <label>Materialize Select</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="fechadesde" type="date" class="datepicker">
                                <label for="fechadesde">Fecha desde</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="fechahasta" type="date" class="datepicker">
                                <label for="fechahasta">Fecha hasta</label>
                            </div>
                        </div>
                        <div class="row margin">
                            <div class="input-field col s12">
                                <a href="#" class="btn waves-effect waves-light col s12">Aceptar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>-->
            <!--<div class="card">
                <div class="card-content">
                    <span class="card-title">Cartera Total</span>
                    <p>Realice una impresión de la cartera total.</p>
                    <form action="">

                        <div class="row margin">
                            <div class="input-field col s12">
                                <a href="#" class="btn waves-effect waves-light col s12">Realizar Reporte</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>-->
        </div>
        <div class="col s12 m8 l8">
            <div id="work-collapsible">
                <div class="row">
                    <div class="col s12" id="todos-los-beneficiarios">
                        <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                            <li class="collapsible-item-header avatar">
                                <i class="material-icons circle green darken-2">attach_money</i>
                                <span class="collapsible-title-header">Todos los pagos
                                    <div class="box secondary-content ">
                                        <div class="secondary-content actions">
                                            <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                            <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                <i class="material-icons center-align">search</i>
                                            </a>
                                        </div>
                                    </div>
                                </span>
                                <p>Nombre del Beneficiario</p>
                                
                                <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                            </li>

                            <li>
                                <div class="collapsible-header-titles  sin-icon">
                                    <div class="row">
                                        <div class="col s2 m1 l1"><p class="collapsible-title">#</p></div>
                                        <div class="col s10 m3 l3 "><p class="collapsible-title">Fecha</p></div>
                                        <div class="col s6 m3 l3 hide-on-small-only"><p class="collapsible-title">Capital</p></div>
                                        <div class="col s6 m2 l2 hide-on-small-only"><p class="collapsible-title">Intereses</p></div>
                                        <div class="col s6 m3 l3 hide-on-small-only"><p class="collapsible-title">Total pago</p></div>
                                    </div>
                                </div>
                            </li>

                            <div class="list collapsible no-padding no-margin z-depth-0">

                                <?php if(isset($pagos)):?>

                                    <?php if(count($pagos) > 0 ):?>

                                        <?php foreach($pagos as $pago):?>

                                            <li>
                                                <div class="collapsible-header sin-icon">
                                                    <div class="row">
                                                        <div class="col s2 m1 l1"><p class="collapsible-content truncate id-items" id="id-item">1</p></div>
                                                        <div class="col s10 m3 l3"><p class="collapsible-content truncate"></p><?php echo $pago['fecha'];?></div>
                                                        <div class="col s6 m3 l3 hide-on-small-only light truncate"><p class="collapsible-content">L. <?php echo $pago['capital'];?></p></div>
                                                        <div class="col s6 m2 l2 hide-on-small-only light truncate"><p class="collapsible-content">L. <?php echo $pago['interes'];?></p></div>
                                                        <div class="col s6 m3 l3 hide-on-small-only light truncate"><p class="collapsible-content">L. <?php echo $pago['total_pagado'];?></p></div>
                                                    </div>
                                                </div>
                                            </li>

                                        <?php endforeach;?>

                                    <?php else:?>

                                        <li>
                                            <div class="collapsible-header sin-icon center">
                                                <div class="row">
                                                    <div class="col s12 m12 l12"><p class="collapsible-content truncate id-items" id="id-item">Ningún pago registrado.</p></div>
                                                </div>
                                            </div>
                                        </li>

                                    <?php endif;?>

                                <?php else:?>

                                <li>
                                    <div class="collapsible-header sin-icon center">
                                        <div class="row">
                                            <div class="col s12 m12 l12"><p class="collapsible-content truncate id-items" id="id-item">No se pudieron capturar los pagos.</p></div>
                                        </div>
                                    </div>
                                </li>

                                <?php endif;?>

                            </div>

                            <li class="collapsible-item-header light">
                                <ul id="pag-control" class="pag pagination">
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php endif;?>
</div>
<?php require 'modal-pagos.php';?>
<script>

$(document).ready(function(){
    $('#btn-regresar').click(function(){
        $('#main-container').hide("slide",{ direction: "right" },300, function(){
            $('#main-container').empty();
            $('#main-container').append(window.last);
            $('#main-container').show("slide",{ direction: "left" },300);
            window.listObj.items = window.items;
            window.listObj.update();
            window.listObj.show(window.indexItem, 10);
            if(window.search !== 'undefined' && window.search != ''){
                window.listObj.search('');
                window.listObj.search(window.search);
            }
        });
    });
    $('.icon-collapse-search').click(function () {
        $('.search-expandida').toggleClass('expanded');
        $('.search-expandida').focus();
    });
    $('.btn-pagar').click(function(){
        $('#modal-pago').modal('open');
    });
    var options = {
        page: 10,
        pagination: true,
        valueNames: [ 'codigog', 'nombreg', 'gestorg', 'estadog' ],
        fuzzySearch: {
            searchClass: "fuzzy-search",
            location: 0,
            distance: 100,
            threshold: 0.1,
            multiSearch: false
        }
    };
    var list = new List('todos-los-beneficiarios', options);
});

</script>
