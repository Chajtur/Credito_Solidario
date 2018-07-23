<?php

require '../php/conection.php';
session_start();
$stat = $conn->prepare('
select a.Monto_Desembolsado, a.capital_mora, a.saldo_capital, a.fecha_ultimo_pago, 
a.Nombre_Completo, a.Identidad, a.Ciclo, a.Estado_Credito, b.Plazo, a.Fecha_Desembolso,
a.Numero_Prestamo, a.cuotas_vencidas as valor_determinante
from prestamo a left join cartera_consolidada b 
on a.Numero_Prestamo = b.Prestamo_Numero
left join ifi c on a.ifi = c.id 
where estado_credito = "Desembolsado" and c.nombre = "'.$_SESSION['first_name'].'"');
$stat->execute();
$result = $stat->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="section">
    <div class="row margin">
        <div class="col s12">

            <div id="work-collapsible">
                <div class="row">
                    <div class="col s12" id="todos-los-beneficiarios">
                        <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                            <li class="collapsible-item-header avatar">
                                <i class="material-icons circle green darken-2">attach_money</i>
                                <span class="collapsible-title-header">Ventana de Pagos
                                    <div class="box secondary-content ">
                                        <div class="secondary-content actions">
                                            <input class="search-expandida" type="search" placeholder="buscar usuario" id="filtro-text"/>
                                            <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                <i class="material-icons center-align">search</i>
                                            </a>
                                        </div>
                                    </div>
                                </span>
                                <p>Todos los beneficiarios</p>
                                
                                <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                            </li>

                            <li>
                                <div class="collapsible-header-titles  sin-icon">
                                    <div class="row">
                                        <div class="col s2 m1 l1"><p class="collapsible-title">#</p></div>
                                        <div class="col s10 m3 l3 "><p class="collapsible-title">Nombre</p></div>
                                        <div class="col s6 m3 l3 hide-on-small-only"><p class="collapsible-title">Identidad</p></div>
                                        <div class="col s6 m2 l2 hide-on-small-only"><p class="collapsible-title">Ciclo</p></div>
                                        <div class="col s6 m3 l3 hide-on-small-only"><p class="collapsible-title">Estado</p></div>
                                    </div>
                                </div>
                            </li>

                            <div class="list collapsible no-padding no-margin z-depth-0">

                            <?php $i=0;?>
                            <?php if(count($result) > 0):?>

                                <?php foreach($result as $beneficiario):?>
                                    <?php $i++;?>
                                    
                                    <li>
                                        <div class="collapsible-header sin-icon">
                                            <div class="row">
                                                <div class="col s2 m1 l1"><p class="collapsible-content truncate id-items" id="id-item"><?php echo $i;?></p></div>
                                                <div class="col s10 m3 l3"><p class="collapsible-content truncate nombre"><?php echo $beneficiario['Nombre_Completo'];?></p></div>
                                                <div class="col s6 m3 l3 hide-on-small-only light truncate"><p class="collapsible-content identidad"><?php echo $beneficiario['Identidad'];?></p></div>
                                                <div class="col s6 m2 l2 hide-on-small-only light truncate"><p class="collapsible-content ciclo"><?php echo $beneficiario['Ciclo'];?></p></div>
                                                <div class="col s6 m3 l3 hide-on-small-only light truncate"><p class="collapsible-content"><?php echo ($beneficiario['valor_determinante'] == '0' ? 'Al día' : 'Atrasado');?></p></div>
                                                <p class="numeroprestamo hide"><?php echo $beneficiario['Numero_Prestamo'];?></p>
                                            </div>
                                        </div>
                                        <div class="collapsible-body no-padding">
                                            <div class="card grey lighten-3 black-text z-depth-0 no-margin no-border-radius">
                                                <div class="card-content">
                                                    <?php 
                                                    $plazo = (str_replace(' ', '', str_replace('MESES', '', $beneficiario['Plazo'])) == 6 ? 26 : 52);
                                                    $pago = ((0.12/52)*($beneficiario['Monto_Desembolsado']))/(1-(pow((1+(0.12/52)),(-1*(preg_replace("/[^0-9]/","",$plazo))))));
                                                    ?>
                                                    <input type="hidden" id="identidad" value="<?php echo $beneficiario['Identidad'];?>">
                                                    <input type="hidden" id="monto" value="<?php echo $beneficiario['Monto_Desembolsado'];?>">
                                                    <input type="hidden" id="plazo" value="<?php echo $beneficiario['Plazo'];?>">
                                                    <input type="hidden" id="numero-prestamo" value="<?php echo $beneficiario['Numero_Prestamo'];?>">
                                                    <span class="card-title text-darken-4">
                                                        <span class="light">Cuota a pagar:</span> <b>L. <?php echo number_format($pago,2,".",",");?></b>
                                                        <small>(<a href="#!" class="btn-plan-pagos">Ver plan de pagos</a>)</small>
                                                    </span>
                                                    <div class="row">
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Monto desembolsado:</span> L. <span id="monto"><?php echo $beneficiario['Monto_Desembolsado'];?></span></p>
                                                        </div>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Fecha de Desembolso:</span> <span id="fecha-desembolso"><?php echo $beneficiario['Fecha_Desembolso'];?></span> </p>
                                                        </div>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Mora:</span> <?php echo ($beneficiario['capital_mora']/($beneficiario['saldo_capital'] != 0 ? $beneficiario['saldo_capital'] : 1 ))*100;?>% </p>
                                                        </div>
                                                        <div class="col l6 m6 s12">   
                                                            <p><span class="light">Cantidad mora:</span> L. <?php echo $beneficiario['capital_mora'];?></p>
                                                        </div>
                                                        <div class="col l6 m6 s12">   
                                                            <p><span class="light">Ultimo pago:</span> <?php echo $beneficiario['fecha_ultimo_pago'];?></p>
                                                        </div>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Saldo:</span> L. <?php echo $beneficiario['saldo_capital'];?></p>
                                                        </div>
                                                        <div class="col l6 m6 s12">   
                                                            <p><span class="light">Interés:</span> 12%</p>
                                                        </div>
                                                        <div class="col l6 m6 s12">   
                                                            <p><span class="light">Plazo:</span> <span id="plazo-formated"><?php echo preg_replace("/[^0-9]/","",$beneficiario['Plazo']);?></span> meses</p>
                                                        </div>
                                                        <div class="col l6 m6 s12">   
                                                            <p><span class="light">Numero de Préstamo:</span> <span id="" class=""><?php echo $beneficiario['Numero_Prestamo'];?></span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-action">
                                                    <a href="#!" class="btn-bitacora btn blue-text waves-effect z-depth-0 white-text btn-pagar"><i class="material-icons left">credit_card</i>Pagar</a>
                                                    <a href="#!" class="black-text btn-aval btn-flat btn-detalles-credito">Detalles</a>
                                                    <input type="hidden" id="numero-prestamo" value="<?php echo $beneficiario['Numero_Prestamo'];?>">
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                <?php endforeach;?>

                            <?php else:?>

                            <li class="center"><h5>No hay ningún beneficiario</h5></li>

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
</div>
<!-- Modal Structure -->
<div id="modal-plan-pago" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4 class="light blue-text">Plan de pagos<a href="#!" class="right tooltipped green-text btn-generar-pdf" data-delay="10" data-position="bottom" data-tooltip="Generar archivo"><i class="material-icons">description</i></a></h4>
        
        <div class="card-panel z-depth-0 blue-grey white-text">
            <div class="row">
                <div class="col l3 m3 s12">
                    Monto: <span class="light" id="monto-desembolsado"></span>
                </div>
                <div class="col l4 m4 s12">
                    Cantidad de cuotas: <span class="light" id="cantidad-cuotas"></span>
                </div>
                <div class="col l5 m5 s12">
                    Fecha final: <span class="light" id="fecha-final"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col l12 m12 s12">
                <table class="bordered">
                    <thead>
                        <tr>
                            <th>Cuota</th>
                            <th>Fecha</th>
                            <th>Pago</th>
                            <th>Interés</th>
                            <th>Capital</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>

                    <tbody id="tabla-amortizacion">
                    </tbody>
                </table>
            </div>
        </div>
        
        <div id="modal-plan-pagos-content"></div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cerrar</a>
    </div>
</div>
<?php require 'modal-pagos.php';?>
<script>

    $(document).ready(init);

    function init(){

        // Materializes
        $('.modal').modal();
        $('.collapsible').collapsible();
        $('.tooltipped').tooltip({delay:50});

        // Eventos
        $('.icon-collapse-search').click(toggleSearch);
        $('.btn-plan-pagos').click(calcularAmortizacionYMostrar);
        $('.btn-detalles-credito').click(mostrarDetalleCredito);
        $('.btn-pagar').click(abrirModalPagar);
        $('#filtro-text').on('input', buscarEnLista);
        $('.btn-generar-pdf').click(generarPdf);

        // List js
        var options = {
            page: 10,
            pagination: true,
            valueNames: [ 'nombre', 'identidad', 'ciclo', 'numeroprestamo' ],
            fuzzySearch: {
                searchClass: "fuzzy-search",
                location: 0,
                distance: 100,
                threshold: 0.1,
                multiSearch: false
            }
        };
        window.listObj = new List('todos-los-beneficiarios', options);

    }

    function generarPdf(){
        window.open('../php/instituciones-financieras/generar.pdf.amortizacion.php?monto='+window.monto+'&plazo='+window.plazo+'&prestamo='+window.numero_prestamo+'&tabla='+encodeURI(JSON.stringify(window.tablaAmortizacion)),'_blank');
    }

    function abrirModalPagar(){
        $('#modal-pago').modal('open');
    }

    function buscarEnLista(){
        if($(this).val() != '' && $(this).val() !== 'undefined'){
            window.listObj.search($(this).val());
        }else{
            window.listObj.search();
        }
    }

    function mostrarDetalleCredito(){
        var numeroprestamo = $(this).next().val();
        window.numero_prestamo = numeroprestamo;
        window.last = $('#main-container').contents();
        window.items = window.listObj.items;
        window.search = $('#filtro-text').val();
        var firstElementId = $('.id-items').first().text();
        var currentElementId = $(this).parent().parent().parent().parent().find('#id-item').text();
        var diference = currentElementId - firstElementId;
        window.indexItem = currentElementId - diference;
        $('#main-container').hide("slide", { direction: "left" }, 300, function(){
            $('#loading').fadeIn(100, function(){
                $('#main-container').load('detalle.php?prestamo='+numeroprestamo, function(){
                    $('#loading').fadeOut(100, function(){
                        $('#main-container').fadeIn(100);
                    });
                });
            });
        });
    }

    function calcularAmortizacionYMostrar(){

        var plazo = $(this).parent().parent().parent().find('#plazo-formated').text();
        var monto = $(this).parent().parent().parent().find('#monto').val();
        var fechadesembolso = $(this).parent().parent().parent().find('#fecha-desembolso').text();
        var fecha = new Date(fechadesembolso);
        var obj = calcularTablaAmortizacion(plazo,monto,12);

        window.identidad = $(this).parent().parent().parent().find('#identidad').val();
        window.numero_prestamo = $(this).parent().parent().parent().find('#numero-prestamo').val();
        window.monto = $(this).parent().parent().parent().find('#monto').val();
        window.plazo = $(this).parent().parent().parent().find('#plazo').val();

        window.tablaAmortizacion = obj;
        window.tablaAmortizacion.fecha_desembolso = fecha.getFullYear() + "-" + fecha.getMonth() + "-" + fecha.getDate();
        
        $('#tabla-amortizacion').empty();
        $('#cantidad-cuotas').empty();
        $('#monto-desembolsado').empty();
        $('#fecha-final').empty();
        var length = obj.pago.length;
        $('#cantidad-cuotas').text(length-1);
        $('#monto-desembolsado').text(monto);

        for(var i = 1; i < length; i++){
            fecha = fecha.addDays(7);
            $('#tabla-amortizacion').append('<tr><td>'+(i)+'</td><td>'+fecha.getDate()+'/'+(fecha.getMonth()+1)+'/'+fecha.getFullYear()+'</td><td>'+(Math.round(obj.pago[i] * 100) / 100)+'</td><td>'+(Math.round(obj.interes[i] * 100) / 100)+'</td><td>'+(Math.round(obj.amortizacion[i] * 100) / 100)+'</td><td>'+(Math.round(obj.saldo[i] * 100) / 100)+'</td></tr>');
        }

        $('#fecha-final').text(fecha.getDate()+'/'+(fecha.getMonth()+1)+'/'+fecha.getFullYear());
        $('#modal-plan-pago').modal('open');

    }

    function toggleSearch(){
        $('.search-expandida').toggleClass('expanded');
        $('.search-expandida').focus();
    }

    function calcularTablaAmortizacion(plazo, monto, taza){
        var tabla = {
            pago: [],
            interes: [],
            amortizacion: [],
            saldo: []
        }
        switch(plazo){
            case "6": plazo = "26"; break;
            case "12": plazo = "52"; break;
            case "18": plazo = "78"; break;
            default: plazo = "26"; break;
        }
        var interes = (taza/(52*100));
        // calculamos el pago por fecha
        var pago = monto*((interes)/(1-(Math.pow((1+interes),((-1)*plazo)))));
        var saldo = monto;
        tabla['pago'][0] = pago;
        tabla['interes'][0] = interes;
        tabla['amortizacion'][0] = '';
        tabla['saldo'][0] = saldo;
        for(var i = 1; i <= plazo; i++){
            tabla['pago'][i] = pago;
            tabla['interes'][i] = interes*saldo;
            tabla['amortizacion'][i] = pago-tabla['interes'][i];
            saldo = saldo - tabla['amortizacion'][i];
            tabla['saldo'][i] = Math.round(saldo * 100) / 100;
        }
        return tabla;
    }

    // Tools
    Date.prototype.addDays = function(days) {
        var dat = new Date(this.valueOf());
        dat.setDate(dat.getDate() + days);
        return dat;
    }

</script>