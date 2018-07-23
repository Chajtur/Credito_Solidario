<?php 

require '../php/conection.php';
session_start();

$stat = $conn->prepare('call obtener_visitas_responsables_pendientes(:user)');
$stat->bindValue(':user', $_SESSION['user']);
$stat->execute();
$visitas = $stat->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Busqueda  -->
<div id="work-collapsible">
    <div class="row">
        <div class="col s12">
            <ul id="visitas-list" class="collapsible" data-collapsible="accordion">
                <li class="collapsible-item-header avatar">
                    <i class="material-icons circle green">directions_walk</i>
                    <span class="collapsible-title-header">Visitas CDA
                        <div class="secondary-content actions">
                            <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                            <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                <i class="material-icons center-align">search</i>
                            </a>
                        </div>
                    </span>
                    <p>Todas las visitas registradas:</p>
                    <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                </li>
                
                <li>
                    <div class="collapsible-header-titles  sin-icon">
                        <div class="row">
                            <div class="col s1 m1 l1">
                                <p class="collapsible-title">#</p>
                            </div>
                            <div class="col s11 m5 l4 ">
                                <p class="collapsible-title">Nombre</p>
                            </div>
                            <div class="col m4 l4 hide-on-small-only">
                                <p class="collapsible-title">Identidad</p>
                            </div>
                            <div class="col m3 l3 hide-on-med-and-down">
                                <p class="collapsible-title">Solucionado</p>
                            </div>
                        </div>
                    </div>
                </li>

                <div class="list collapsible no-padding no-margin z-depth-0">

                    <?php if(count($visitas) > 0):?>
                        
                        <?php $contador = 0;?>

                        <?php foreach($visitas as $visita):?>

                            <li>

                                <div class="collapsible-header sin-icon">
                                    <div class="row">
                                        <div class="col s1 m1 l1 truncate"><?php echo ++$contador;?></div>
                                        <div class="col s11 m5 l4 truncate"><span class="nombreb"><?php echo $visita['nombre'];?></span></div>
                                        <div class="col s4 m4 l4 hide-on-small-only identidadb truncate"><?php echo $visita['identidad'];?></div>
                                        <div class="col s6 m3 l3 hide-on-med-and-down estatusb"><?php echo (($visita['solucion'] != '' && $visita['solucion'] != null) ? '<i class="material-icons green-text">done</i>' : '<i class="material-icons amber-text darken-2">error_outline</i>');?></div>
                                    </div>
                                </div>

                                <div class="collapsible-body no-padding">
                                    <div class="card blue-grey white-text z-depth-0 no-margin no-border-radius">

                                        <div class="card-content">
                                            <!-- <span class="card-title text-darken-4"><span class="light">Consulta:<br></span> </span> -->
                                            <div class="row">
                                                <div class="col l12 m12 s12">
                                                    <p><span class="light">Nombre del beneficiario:</span> <?php echo $visita['nombre'];?></p>
                                                </div>
                                                <div class="col l12 m12 s12">
                                                    <p><span class="light">Teléfono:</span> <?php echo $visita['telefono'];?></p>
                                                </div>
                                                <div class="col l12 m12 s12">
                                                    <p><span class="light">Consulta:</span> <?php echo $visita['consulta'];?></p>
                                                </div>
                                                <div class="col l12 m12 s12">
                                                    <p><span class="light">Solución:</span> <?php echo (($visita['solucion'] == '' || $visita['solucion'] == null) ? '(No se ha solucionado)' : $visita['solucion']);?></p>
                                                </div>
                                                <div class="col l12 m12 s12">
                                                    <p><span class="light">Fecha:</span> <?php echo $visita['fecha'];?></p>
                                                </div>
                                                <div class="col l12 m12 s12">
                                                    <p><span class="light">Responsable:</span> <?php echo $visita['responsable'];?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-action">
                                            <a class="green-text text-lighten-3 btn-solucion btn-abrir-modal" href="#modal_solucion">Solucionar</a>
                                            <input type="hidden" id="id_caso" value="<?php echo $visita['id'];?>">
                                        </div>

                                    </div>

                                </div>

                            </li>

                        <?php endforeach;?>

                    <?php else:?>

                        <li>
                            <div class="collapsible-header sin-icon">
                                <div class="row">
                                    <div class="col s12 m12 l12 center-align"><h5>No hay visitas registradas</h5></div>
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

<!-- Modal Structure -->
<div id="modal_solucion" class="modal">
    <div class="modal-content">
        <h4>Solucionar consulta</h4>
        <div class="input-field">
            <input placeholder="Solución" id="input-solucion" type="text" class="validate">
            <label for="solucion" class="active">Solución a la consulta</label>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action waves-effect waves-green btn-flat" id="btn-guardar-solucion">Guardar</a>
    </div>
</div>


<!-- Busqueda  -->
<script>

$(document).ready(init);

function init(){

    // Eventos
    $('.btn-abrir-modal').click(asignarIdCaso);
    $('#btn-guardar-solucion').click(guardarSolucion);

    // Materialize
    $('.collapsible').collapsible();
    $('.modal').modal();

    // List
    var options = {
        page: 10,
        pagination: true,
        valueNames: [ 'nombreb', 'identidadb' ],
        fuzzySearch: {
            searchClass: "fuzzy-search",
            location: 0,
            distance: 100,
            threshold: 0.2,
            multiSearch: true
        }
    };
    window.listObj = new List('visitas-list', options);

}

function guardarSolucion(){

    // Validaciones
    if($('#input-solucion').val() == '' || $('#input-solucion').val() == null){
        Materialize.toast('El campo de solución está vacío.', 3000);
        return false;
    }

    if($('#input-solucion').val().length < 5){
        Materialize.toast('La solución es muy corta.', 3000);
        return false;
    }

    var obj = {
        id_caso: window.id_caso,
        solucion: $('#input-solucion').val()
    }

    $.ajax({
        type: 'POST',
        url: '../php/common/guardar-solucion-caso.php',
        data: obj,
        success: function(data){
            if(data == 'true'){
                $('#floating-refresh').trigger('click');
                swal('Correcto','Se ha guardado la solución correctamente','success');
                $('#modal_solucion').modal('close');
            }else{
                swal('Error','Ha ocurrido un error al ejecutar la solicitúd en el servidor','error');
            }
        } 
    });

}

function asignarIdCaso(){

    window.id_caso = $(this).parent().find('#id_caso').val();

}

</script>

