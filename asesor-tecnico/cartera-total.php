<?php

require '../php/conection.php';
session_start();

/*$stat = $conn->prepare('select a.Nombre, a.Identidad, a.Ciclo, b.Nombre as IFI, a.Supervisor, a.Direccion_Domicilio, 
a.Monto_Otorgado, a.Saldo_Capital, a.Fecha_Ultimo_Pago, a.Fecha_Desembolso, a.Fecha_Colocacion, a.Total_Pago_Pendiente, 
a.Gestor, a.documento, a.Cuotas_Vencidas, a.Direccion_Negocio
from cartera_consolidada a left join ifi b on a.ifi = b.id where estatus_prestamo = "Desembolsado" and Gestor = :gestor');*/

$stat = $conn->prepare('select a.Nombre_completo, a.Identidad, a.Ciclo, b.Nombre as IFI, a.Supervisor, a.Direccion, 
a.Monto_desembolsado, a.Saldo_Capital, a.Fecha_Ultimo_Pago, a.Fecha_Desembolso, c.Fecha_Colocacion, a.Total_Pago_Pendiente, 
a.Gestor, c.documento, a.Cuotas_Vencidas, a.Negocio
from prestamo a left join ifi b on a.ifi = b.id left join cartera_consolidada c on a.numero_prestamo = c.prestamo_numero where estado_credito = "desembolsado" and a.Gestor = :gestor');

$stat->bindValue(':gestor', $_SESSION['first_name'] . ' ' .$_SESSION['last_name'], PDO::PARAM_STR);
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
                                <i class="material-icons circle light-blue">list</i>
                                <span class="collapsible-title-header">Cartera Total
                                    <div class="secondary-content actions">
                                        <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                        <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                            <i class="material-icons center-align">search</i>
                                        </a> 
                                        <form action="../php/excel.php" method="post" id="form_excel">
                                            <input type="hidden" name="user_id" id="hidden_id" value="<?php echo $_SESSION['user'];?>">
                                            <button type="submit" class="waves-effect btn-flat nopadding"><i class="material-icons">description</i></button>
                                        </form> 
                                        <a id="desactivarLista" class="dropdown-button waves-effect waves-light btn-flat nopadding" data-activates='dropdown_listOrder'>
                                            <i class="material-icons center-align">sort</i>
                                        </a> 
                                    </div>
                                </span>
                                <p>Información acerca de su cartera total.</p>
                            </li>
                            <li>
                                <div class="collapsible-header-titles sin-icon">
                                    <div class="row">
                                        <div class="col s2 m1 l1"><p class="collapsible-title">#</p></div>
                                        <div class="col s10 m3 l3 "><p id="headerNombre" class="collapsible-title">Nombre</p></div>
                                        <div class="col s6 m3 l3 hide-on-small-only"><p class="collapsible-title">Identidad</p></div>
                                        <div class="col s6 m2 l2 hide-on-small-only"><p class="collapsible-title">Ciclo</p></div>
                                        <div class="col s6 m3 l3 hide-on-small-only"><p class="collapsible-title">IFI</p></div>
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
                                                <div class="col s2 m1 l1"><p class="collapsible-content truncate"><?php echo $i;?></p></div>
                                                <div class="col s10 m3 l3"><p class=" nombre collapsible-content truncate"><?php echo $beneficiario['Nombre_completo'];?></p></div>
                                                <div class="col s6 m3 l3 hide-on-small-only light truncate"><p class="collapsible-content"><?php echo $beneficiario['Identidad'];?></p></div>
                                                <div class="col s6 m2 l2 hide-on-small-only light truncate"><p class="collapsible-content"><?php echo $beneficiario['Ciclo'];?></p></div>
                                                <div class="col s6 m3 l3 hide-on-small-only light truncate"><p class="collapsible-content"><?php echo $beneficiario['IFI'];?></p></div>
                                            </div>
                                        </div>
                                        <div class="collapsible-body no-padding">
                                            <div class="card grey lighten-3 black-text z-depth-0 no-margin no-border-radius">
                                                <div class="card-content">
                                                    <div class="row">

                                                        <?php if($beneficiario['Direccion']):?>
 
                                                        <div class="col l12 m12 s12">
                                                            <p><span class="light">Domicilio:</span> <?php echo $beneficiario['Direccion'];?></p>
                                                        </div>
                                                        <?php endif;?>
                                                        <?php if($beneficiario['Negocio']):?>
                                                        <div class="col l12 m12 s12">
                                                            <p><span class="light">Negocio:</span> <?php echo $beneficiario['Negocio'];?></p>
                                                        </div>
                                                        <?php endif;?>
                                                    </div>
                                                    <div class="row">
                                                        <?php if($beneficiario['Identidad']):?>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Identidad:</span> <?php echo $beneficiario['Identidad'];?></p>
                                                        </div>
                                                        <?php endif;?>
                                                        <?php if($beneficiario['IFI']):?>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">IFI:</span> <?php echo $beneficiario['IFI'];?></p>
                                                        </div>
                                                        <?php endif;?>

                                                        <?php if($beneficiario['Monto_desembolsado']):?>

                                                        <div class="col l6 m6 s12">   
                                                            <p><span class="light">Monto:</span> <?php echo $beneficiario['Monto_desembolsado'];?></p>
                                                        </div>   
                                                        <?php endif;?>
                                                        <?php if($beneficiario['Saldo_Capital']):?>
                                                        <div class="col l6 m6 s12">   
                                                            <p><span class="light">Saldo Capital:</span> <?php echo $beneficiario['Saldo_Capital'];?></p>
                                                        </div>   
                                                        <?php endif;?>
                                                        <?php if($beneficiario['Fecha_Ultimo_Pago']):?>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Último pago:</span> <?php echo $beneficiario['Fecha_Ultimo_Pago'];?></p>
                                                        </div>
                                                        <?php endif;?>
                                                        <?php if($beneficiario['Fecha_Desembolso']):?>
                                                        <div class="col l6 m6 s12">   
                                                            <p><span class="light">Fecha de Desembolso:</span> <?php echo $beneficiario['Fecha_Desembolso'];?></p>
                                                        </div>
                                                        <?php endif;?>
                                                        <?php if($beneficiario['Fecha_Colocacion']):?>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Fecha de Colocacion:</span> <?php echo $beneficiario['Fecha_Colocacion'];?></p>
                                                        </div>
                                                        <?php endif;?>
                                                        <?php if($beneficiario['Total_Pago_Pendiente']):?>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Pago pendiente:</span> <?php echo $beneficiario['Total_Pago_Pendiente'];?></p>
                                                        </div>
                                                        <?php endif;?>
                                                        <?php if($beneficiario['Cuotas_Vencidas']):?>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Cuotas vencidas:</span> <?php echo $beneficiario['Cuotas_Vencidas'];?></p>
                                                        </div> 
                                                        <?php endif;?>
                                                        <?php if($beneficiario['Ciclo']):?>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Ciclo:</span> <?php echo $beneficiario['Ciclo'];?></p>
                                                        </div> 
                                                        <?php endif;?>
                                                        <?php if($beneficiario['Gestor']):?>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">Gestor:</span> <?php echo $beneficiario['Gestor'];?></p>
                                                        </div> 
                                                        <?php endif;?>
                                                        <?php if($beneficiario['Supervisor']):?>
                                                        <div class="col l6 m6 s12">    
                                                            <p><span class="light">Supervisor:</span> <?php echo $beneficiario['Supervisor'];?></p>
                                                        </div>     
                                                        <?php endif;?>
                                                        <?php if($beneficiario['documento']):?>
                                                        <div class="col l6 m6 s12">
                                                            <p><span class="light">PBS:</span> <?php echo $beneficiario['documento'];?></p>
                                                        </div>
                                                        <?php endif;?>
                                                    </div>
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

<!-- Dropdown Structure -->
  <ul id='dropdown_listOrder' class='dropdown-content'>
    <li><a value="5" href="#!">ver 5</a></li>
    <li><a value="10" href="#!">ver 10</a></li>
    <li><a value="20" href="#!">ver 20</a></li>
    <li><a value="10000" href="#!">ver todo</a></li>
  </ul>

<!-- Modal Structure -->
<div id="modal-plan-pago" class="modal modal-fixed-footer modal-max-width">
    <div class="modal-content">
        <h4 class="light blue-text">Plan de pagos</h4>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cuota</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>2012-02-02</td>
                    <td>190</td>
                </tr>
                <tr>
                    <td>2012-02-02</td>
                    <td>190</td>
                </tr>
            </tbody>
        </table>
        <div id="modal-plan-pagos-content"></div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cerrar</a>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.modal').modal();
        $('.btn-plan-pagos').click(function(){

            var today = new Date();
            var fechadesembolso = new Date($(this).parent().find('#fecha-desembolso').val());

            $('#modal-plan-pagos-content').append();
            $('#modal-plan-pago').modal('open');

        });
        $('.dropdown-button').dropdown({
          inDuration: 300,
          outDuration: 225,
          constrainWidth: false, // Does not change width of dropdown to that of the activator
          hover: false, // Activate on hover
          gutter: 0, // Spacing from edge
          belowOrigin: true, // Displays dropdown below the button
          alignment: 'left', // Displays dropdown with edge aligned to the left of button
          stopPropagation: false // Stops event propagation
        });
        
        
        /*$('#desactivarLista').on('click', function(){
            listObj.page = 100000;
            listObj.update();
        });*/
        /*$('#headerNombre').on('click', function(){
            if($('.sort').hasClass('desc')){
                var des = 'asc';
            }else {
                var des = 'desc';
            }
            
            listObj.sort('name', {
              order: 'desc',
              alphabet: "ABCDEFGHIJKLMNOPQRSTUVXYZÅÄÖabcdefghijklmnopqrstuvxyzåäö",
              insensitive: true,
              sortFunction: undefined
            });
            listObj.update();
            
        });*/
        
        
        $('#dropdown_listOrder').find('a').click(function(){
            listObj.page = $(this).attr('value');
            listObj.update();
        });
        
        $('.collapsible').collapsible();
        $('.icon-collapse-search').click(function () {
            $('.search-expandida').toggleClass('expanded');
            $('.search-expandida').focus();
        });
        var options = {
            page: 5,
            pagination: true,
            valueNames: [ 'codigog', 'nombre', 'gestorg', 'estadog' ],
            fuzzySearch: {
                searchClass: "fuzzy-search",
                location: 0,
                distance: 100,
                threshold: 0.2,
                multiSearch: true
            }
        };
        window.listObj = new List('todos-los-beneficiarios', options);
        
        
        
    });
</script>