<?php

require '../php/conection.php';
session_start();

/*$stat = $conn->prepare('select a.Nombre, a.Identidad, a.Ciclo, b.Nombre as IFI, a.Supervisor, a.Direccion_Domicilio, 
a.Monto_Otorgado, a.Saldo_Capital, a.Fecha_Ultimo_Pago, a.Fecha_Desembolso, a.Fecha_Colocacion, a.Total_Pago_Pendiente, 
a.Gestor, a.documento, a.Cuotas_Vencidas, a.Direccion_Negocio
from cartera_consolidada a left join ifi b on a.ifi = b.id where estatus_prestamo = "Desembolsado" and Gestor = :gestor');*/

/*$stat = $conn->prepare('select a.Nombre_completo, a.Identidad, a.Ciclo, b.Nombre as IFI, a.Supervisor, 
a.Direccion, a.Monto_desembolsado, a.Saldo_Capital, a.Fecha_Ultimo_Pago, a.Fecha_Desembolso, 
c.Fecha_Colocacion, a.Total_Pago_Pendiente, a.Gestor, c.documento, a.Cuotas_Vencidas, a.Negocio
from prestamo a left join ifi b on a.ifi = b.id left join cartera_consolidada c on a.numero_prestamo = c.prestamo_numero 
where estado_credito = "desembolsado" and a.Supervisor = :supervisor');*/

$stat = $conn->prepare('select a.Nombre_completo, a.Identidad, a.Ciclo, b.Nombre as IFI, a.Supervisor, 
a.Direccion, a.Monto_desembolsado, a.Saldo_Capital, a.Fecha_Ultimo_Pago, a.Fecha_Desembolso, 
a.Total_Pago_Pendiente, a.Gestor, a.Cuotas_Vencidas, a.Negocio, a.usuario_digitador as Cartera
from prestamo a 
left join ifi b on a.ifi = b.id 
left join gsc d on d.parent = :user
where estado_credito = "desembolsado" and a.Gestor = d.nombre');

//$stat->bindValue(':supervisor', $_SESSION['first_name'] . ' ' .$_SESSION['last_name'], PDO::PARAM_STR);
$stat->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
$stat->execute();
$result = $stat->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="section">

    <div class="row">
        <div class="col s12">
           <div id="work-collapsible">
                <div class="row">
                    <div class="col s12">
                        <ul id="projects-collection" class="collapsible z-depth-0" data-collapsible="accordion">
                            <li class="collapsible-item-header avatar">
                                <i class="material-icons circle light-blue">list</i>
                                <span class="collapsible-title-header">Cartera Total
                                    <div class="secondary-content actions">
                                        <a href="../php/supervisor/generar-cartera-supervisor.php?supervisor=<?php echo $_SESSION['user'];?>" id="descargarExcel" class="waves-effect waves-light btn-flat nopadding" target="_blank">
                                            <i class="material-icons center-align">cloud_download</i>
                                        </a> 
                                        <a id="desactivarLista" class="dropdown-button waves-effect waves-light btn-flat nopadding" data-activates='dropdown_listOrder'>
                                            <i class="material-icons center-align">sort</i>
                                        </a>
                                    </div>
                                </span>
                                <p>Todos los créditos de los asesores</p>
                            </li>
                            <li>
                                <div class="collapsible-header-titles  sin-icon">
                                    <div class="row">
                                        <div class="col s2 m2 l1">
                                            <p class="collapsible-title">#</p>
                                        </div>
                                        <div class="col s4 m4 l4">
                                            <p class="collapsible-title">Nombre</p>
                                        </div>
                                        <div class="col s3 m3 l3 hide-on-small-only">
                                            <p class="collapsible-title">Identidad</p>
                                        </div>
                                        <div class="col s3 m3 l3 hide-on-small-only">
                                            <p class="collapsible-title">Gestor</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <div class="list collapsible no-padding no-margin z-depth-0">
                                
                                <?php $i=1;?>

                                <?php if(count($result) > 0):?>

                                    <?php foreach($result as $fila):?> 

                                        <li>
                                            <div class="collapsible-header sin-icon">
                                                <div class="row">
                                                    <div class="col s2 m2 l1">
                                                        <p id="nombreAsesor" class="collapsible-content truncate"><?php echo $i;?></p>
                                                    </div>
                                                    <div class="col s4 m4 l4">
                                                        <p class="collapsible-content truncate"><?php echo $fila['Nombre_completo'];?></p>
                                                    </div>
                                                    <div class="col s3 m3 l3 hide-on-small-only light truncate">
                                                        <p class="collapsible-content"><?php echo $fila['Identidad'];?></p>
                                                    </div>
                                                    <div class="col s3 m3 l3 hide-on-small-only light truncate">
                                                        <p class="collapsible-content"><?php echo $fila['Gestor'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapsible-body">
                                                <p><b>Capital en Mora: </b>###</p>
                                                <p><b>Porcentaje Mora: </b>###</p>
                                            </div>
                                        </li>

                                        <?php $i++;?>

                                    <?php endforeach;?>
                                
                                <?php else:?>
                                    
                                    <li>
                                        <div class="collapsible-header sin-icon">
                                            <div class="row">
                                                <div class="col s12 m12 l12">
                                                    <p id="nombreAsesor" class="collapsible-content truncate">No hay ningún crédito</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                <?php endif;?>  
                                
                            </div>
                            <li>
                                <div class="collapsible-footer  sin-icon" style="border-bottom: 1px solid #e0e0e0;">
                                    <div class="row right-align">
                                        <ul id="pag-control" class="pag pagination left">
                                        </ul>
                                        <span>total: <?php echo $i-1;?> registros</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
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

</div>

<script>

$(document).ready(function(){

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

    $('#dropdown_listOrder').find('a').click(function(){
        window.listObj.page = $(this).attr('value');
        window.listObj.update();
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
    window.listObj = new List('projects-collection', options);

});

</script>
