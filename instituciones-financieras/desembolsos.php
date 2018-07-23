<?php

require '../php/conection.php';
session_start();
$stat = $conn->prepare('
select a.Monto_Autorizado as Monto_Desembolsado, identidad, a.nombre, Fecha_Solicitud, Fecha_Colocacion, ciclo, ifi, a.id, Estatus_Prestamo
from cartera_consolidada a, ifi c
where estatus_prestamo = "Colocado" and a.ifi = c.id and c.nombre = "'.$_SESSION['first_name'].'"');
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
                                <i class="material-icons circle green darken-2">local_atm</i>
                                <span class="collapsible-title-header">Ventana para Desembolsos
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
                                                <div class="col s10 m3 l3"><p class="collapsible-content truncate nombre"><?php echo $beneficiario['nombre'];?></p></div>
                                                <div class="col s6 m3 l3 hide-on-small-only light truncate"><p class="collapsible-content identidad"><?php echo $beneficiario['identidad'];?></p></div>
                                                <div class="col s6 m2 l2 hide-on-small-only light truncate"><p class="collapsible-content ciclo"><?php echo $beneficiario['ciclo'];?></p></div>
                                                <div class="col s6 m3 l3 hide-on-small-only light truncate"><p class="collapsible-content"><?php echo $beneficiario['Estatus_Prestamo'];?></p></div>
                                            </div>
                                        </div>
                                        <div class="collapsible-body no-padding">
                                            <div class="card grey lighten-3 black-text z-depth-0 no-margin no-border-radius">
                                                <div class="card-content">
                                                    <div class="row">
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Monto desembolsado:</span> L. <span id="monto"><?php echo $beneficiario['Monto_Desembolsado'];?></span></p>
                                                        </div>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Identidad:</span> <?php echo $beneficiario['identidad'];?></p>
                                                        </div>
                                                        <div class="col l6 m6 s12">   
                                                            <p><span class="light">Fecha de Solicitud:</span> <?php echo $beneficiario['Fecha_Solicitud'];?></p>
                                                        </div>
                                                        <div class="col l6 m6 s12">   
                                                            <p><span class="light">Fecha de Colocación:</span> <?php echo $beneficiario['Fecha_Colocacion'];?></p>
                                                        </div>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Ciclo:</span> <?php echo $beneficiario['ciclo'];?></p>
                                                        </div>
                                                        <div class="col l6 m6 s12">   
                                                            <p><span class="light">Ifi:</span> <?php echo $beneficiario['ifi'];?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-action">
                                                    <input type="hidden" id="id_credito" value="<?php echo $beneficiario['id'];?>">
                                                    <a href="#!" class="btn-bitacora btn blue-text waves-effect z-depth-0 white-text btn-desembolsar"><i class="material-icons left">credit_card</i>Desembolsar</a>
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
<script>
    $(document).ready(function(){
        $('.modal').modal();
        $('.collapsible').collapsible();
        $('.icon-collapse-search').click(function () {
            $('.search-expandida').toggleClass('expanded');
            $('.search-expandida').focus();
        });
        $('.btn-desembolsar').click(function(){
            var idcredito = $(this).parent().find('#id_credito').val();
            swal({
                title: "¿Está seguro que desea desembolsar este crédito?",
                text: "Esta acción no se podrá deshacer facilmente.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, desembolsar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function(){
                $.ajax({
                    type: 'POST',
                    url: '../php/ventanilla/desembolsar.php',
                    data: 'id_credito='+idcredito,
                    success: function(data){
                        if(data == true){
                            swal("Desembolsado", "El crédito ha sido desembolsado.", "success");
                        }else{
                            swal("No desembolsado", "No ha sido posible procesar el crédito.", "error");
                        }
                        $('#floating-refresh').trigger('click');
                    }
                })
            });
        });
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
        $('#filtro-text').on('input', function(){
            if($(this).val() != '' && $(this).val() !== 'undefined'){
                window.listObj.search($(this).val());
            }else{
                window.listObj.search();
            }
        });
    });

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
    Date.prototype.addDays = function(days){
        var dat = new Date(this.valueOf());
        dat.setDate(dat.getDate() + days);
        return dat;
    }

</script>