<?php

require '../php/conection.php';
session_start();
$stat = $conn->prepare('select distinct grupo_solidario_hash, Grupo_Solidario, gestor, Estatus_Prestamo, ciclo 
    from cartera_consolidada where Estatus_Prestamo = "Call Center" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');
$stat->execute();
$grupos = $stat->fetchAll();

$stat = $conn->prepare('select identidad, nombre from cartera_consolidada 
    where Estatus_Prestamo = "Call Center" and grupo_solidario_hash = :hash');

$grupos_beneficiarios = array();

foreach($grupos as $grupo){
    
    $stat->bindValue(':hash', $grupo['grupo_solidario_hash'], PDO::PARAM_STR);
    $stat->execute();
    $beneficiarios = $stat->fetchAll();
    
    $benef = array();
    
    $cant = 0;
    foreach($beneficiarios as $beneficiario){
        $benef[] = $beneficiario;
        $cant++;
    }
    
    $grupos_beneficiarios[] = [
        'hash' => $grupo['grupo_solidario_hash'],
        'nombre_grupo' => $grupo['Grupo_Solidario'],
        'gestor' => $grupo['gestor'],
        'estatus_prestamo' => $grupo['Estatus_Prestamo'],
        'ciclo' => $grupo['ciclo'],
        'cantidad_beneficiarios' => $cant,
        'beneficiarios' => $benef
    ];
    
}

?>
<div class="section">
    <div class="row">
        <div class="col s12 m8 l10 offset-m2 offset-l1">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">
                        <div class="row">
                            <div class="col l8">Lista de grupos ingresados</div>
                            <div class="col l4">

                            </div>
                        </div>
                    </span>
                    <div id="lista-grupos">
                    
                        <input id="buscarHas" type="text" class="validate fuzzy-search" placeholder="Buscar">
                        
                        <ul class="collapsible grupos-recibidos list z-depth-0" data-collapsible="accordion">
                            
                            <li>
                                <div class="collapsible-header sin-icon">
                                    <div class="col s6 l2 codigog" id="grupo-solidario-hash"><b>Hash</b></div>
                                    <div class="col s12 l5 hide-on-med-and-down nombreg" id="nombre-grupo"><b>Nombre del Grupo</b></div>
                                    <div class="col s12 l5 hide-on-med-and-down integrantesg"><b>Gestor</b></div>
                                </div>
                            </li>
                            
                            <?php if(sizeof($grupos_beneficiarios) != 0):?>
                            
                                <?php foreach($grupos_beneficiarios as $grupo):?>
                                    
                                    <li class="">
                                        <div class="collapsible-header sin-icon">
                                            <div class="col s6 l2 codigog truncate" id="grupo-solidario-hash"><?php echo $grupo['hash'];?></div>
                                            <div class="col s12 l5 hide-on-med-and-down nombreg truncate" id="nombre-grupo"><?php echo $grupo['nombre_grupo'];?></div>
                                            <div class="col s12 l5 hide-on-med-and-down integrantesg truncate"><?php echo $grupo['gestor'];?></div>
                                            <!--<div class="col s2 l1">
                                                <a data-idmodal="modal-editar-grupo" class="secondary-content waves-effect waves-blue btn-editar-grupo"><i class="material-icons blue-text">editar</i></a>
                                            </div>-->
                                            <div>
                                                <input type="hidden" id="hidden-gestor" value="<?php echo $grupo['gestor'];?>">
                                                <input type="hidden" id="hidden-ciclo" value="<?php echo $grupo['ciclo'];?>">
                                            </div>
                                        </div>
                                        <div class="collapsible-body">
                                            <div class="row margin">
                                                <div class="col s12 l12">
                                                    <fieldset>
                                                    <legend class="grey-text">Beneficiarios</legend>
                                                    <table id="tabla-beneficiarios" class="black-text">
                                                        <thead>
                                                            <tr>
                                                                <th class="black-text" data-field="id">Nombre</th>
                                                                <th class="black-text" data-field="id">Identidad</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabla-beneficiarios-content"><!--
                                                            <tr>
                                                                <td class="grey-text"><a href="#modal-bitacora-beneficiario">Maria Eugenia Lopez</a></td>
                                                                <td class="grey-text">0801-1999-00325</td>
                                                            </tr>-->
                                                            
                                                            <?php foreach($grupo['beneficiarios'] as $beneficiario):?>
                                                            
                                                                <tr>
                                                                    <td class="blue-text" id="nombre"><?php echo $beneficiario['nombre']?></td>
                                                                    <td class="black-text" id="identidad"><?php echo $beneficiario['identidad']?></td>
                                                                </tr>
                                                            
                                                            <?php endforeach;?>
                                                            
                                                            
                                                        </tbody>
                                                    </table>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                    </li>
                                
                                <?php endforeach;?>
                            
                            <?php else:?>
                            
                                <li>
                                    <div class="collapsible-header sin-icon">
                                        <div class="col s12 l12">
                                            <center>
                                                <h5>No hay nada ingresado.</h5>
                                            </center>
                                        </div>
                                    </div>
                                </li>
                            
                            <?php endif;?>
                            
                        </ul>
                        <ul id="pag-control" class="pag pagination">
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <!--MODAL PARA HASH DE GRUPO-->
    
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4 class="red-text">#¿Esta seguro de editar este grupo?</h4>
            <p>¡Al presionar el botón aceptar se editará el grupo: <span>457898</span></p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
        </div>
    </div>
    <!--MODAL PARA HASH DE GRUPO-->

    <!-- Modal Structure editar grupo -->
    <div id="modal-editar-grupo" class="modal modal-editar-grupo">
        <div class="modal-content modal-content-editar-grupo">
            <div class="row">
                <div class="col s12 m12 l10 offset-l1">
                    <h4>Editar Grupo</h4>
                    <form>
                        <div class="row">
                            <div class="input-field col s5">
                                <select id="select-modal-asesores" class="browser-default">
                                    <option value="" disabled selected>Seleccionar Asesor</option>
                                    <?php require '../php/select-asesores.php';?>
                                </select>
                            </div>
                            <div class="input-field col s4">
                                <input id="nombre_grupo" type="text" class="validate">
                                <label for="nombre_grupo">Nombre del Grupo</label>
                            </div>
                            <div class="input-field col s3">
                                <select id="modal-select-ciclo">
                                    <option value="" disabled selected>Ciclo #</option>
                                    <option value="1">ciclo 1</option>
                                    <option value="2">ciclo 2</option>
                                    <option value="3">ciclo 3</option>
                                </select>
                                <label>Seleccione un ciclo</label>
                            </div>
                        </div>
                        <div id="benen-editar">
                            
                            <!-- Data para beneficiarios -->
                            
                        </div>
                        <div class="row margin">
                            <div class="input-field col s12">
                                <a id="agregar-beneficiario-editar" href="#!" class="btn waves-effect waves-light col s12">agregar nuevo beneficiario</a>
                            </div>
                        </div>
                        <div class="row margin">
                            <div class="input-field col s12 l6 offset-l3">
                                <a id="editar-success" href="#" class="btn waves-effect waves-light col s12 green">Editar</a>
                                <input type="hidden" id="modal-input-grupo-hash">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Structure editar grupo -->

    <!--DIV CLON-->
    <div class="row clon" id="clon">
        <div class="input-field col s4">
            <input id="identidad" type="text" class="validate buscarcenso">
            <label for="identidad">Id Beneficiario 3</label>
        </div>
        <div class="input-field col s5">
            <input disabled id="nombre" type="text" class="validate">
            <label for="nombre_beneficiario3-editar">Nombre Beneficiario 3</label>
        </div>
        <div class="input-field col s2">
            <input autocomplete="off" disabled name="ciclo[]" type="text" class="" id="ciclo-sugerido">
            <label for="ciclo-sugerido">Ciclo</label>
        </div>
        <div class="input-field col s1 center">
            <a class="borrar-beneficiario" href="#!"><i class="material-icons red-text prefix">close</i></a>
        </div>
    </div>
    <!--DIV CLON-->

</div>
<script type="text/javascript" src="../credito/buscarcenso.js"></script>
<script>

$(document).ready(function() {

    agregarBuscarCensoListeners();

    $('#breadcrum-parent').text('Créditos');
    $('#breadcrum-title').text('Lista de Grupos');
    
    $('select').material_select();

    $('#select-modal-asesores').select2();

    $('.modal').modal();

    $('.collapsible').collapsible();

    $('#agregar-beneficiario-editar').click(function(){

        let newelem = $('#clon').clone();
        newelem.toggle();
        newelem.removeAttr('id');
        $('#benen-editar').append(newelem);
        asignarEventosEliminar();
        agregarBuscarCensoListeners();
        /*Materialize.toast('Agregado', 2000);*/

    });

    $('#editar-success').click(function(){
        
        var grupohash = $(this).parent().find('#modal-input-grupo-hash').val();
        
        swal({
                title: "¿Esta seguro de editar el grupo?",
                text: "El grupo "+grupohash+" será editado. Esta acción no se podrá deshacer.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Editar!",
                closeOnConfirm: false
            },
            function(){
                swal("Editado", "El crédito se ha editado con exito.", "success");
                $('#modal-editar-grupo').modal('close');
            }

        );
    });

    asignarEventosEliminar();


    $('#agregar-beneficiario').click(function(){

        let newelem = $('#clon').clone();
        newelem.toggle();
        newelem.removeAttr('id');
        $('#benen').append(newelem);
        asignarEventosEliminar();
        /*Materialize.toast('Agregado', 2000);*/

    });   

    $('#reingreso-success').click(function(){
        swal({
                title: "Esta seguro de Re ingresar?",
                text: "Al precionar el boton de aceptar, el crédito ##### será re-ingresado!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, re-ingresar!",
                closeOnConfirm: false
            },
            function(){
                swal("Ingresado!", "El crédito se ha reingresado con exito.", "success");
                $('#modal-editar-re-ingreso-grupo').modal('close');
            }
        ); 
    });

    /*
    Evento clic para cada botón de editar grupo 
    modifica el modal para que muestre los datos correspondientes para cada grupo
    */

    $('.btn-editar-grupo').click(function(){
        
        //Vaciamos los campos de beneficiario del modal
        $('#benen-editar').empty();
        
        //Asignamos el nombre del grupo al campo de texto del modal
        var nombregrupo = $(this).parent().parent().find('#nombre-grupo').text();
        $('#modal-editar-grupo').find('#nombre_grupo').val(nombregrupo).next().addClass('active');
        
        //Asignamos el gestor
        var nombregestor = $(this).parent().parent().find('#hidden-gestor').val();
        $('#modal-editar-grupo').find('#select-modal-asesores').select2('val', '');
        $('#modal-editar-grupo').find('#select-modal-asesores').select2();
        let value = $('#modal-editar-grupo').find('#select-modal-asesores option:contains('+nombregestor+')').attr('value');
        $('#modal-editar-grupo').find('#select-modal-asesores').val(value).change();
        $('#modal-editar-grupo').find('#select-modal-asesores').select2();
        
        //y el ciclo a los selects
        var ciclo = $(this).parent().parent().find('#hidden-ciclo').val();
        $('#modal-editar-grupo').find('#modal-select-ciclo').val(ciclo).change().material_select();
        
        //Asignamos el valor hidden del grupo hash
        var grupohash = $(this).parent().parent().find('#grupo-solidario-hash').text();
        $('#modal-editar-grupo').find('#modal-input-grupo-hash').val(grupohash);
        
        //obtenemos todos los tr de la tabla dentro del collapsible para obtener las identidades
        //y realizamos un loop foreach para cada identidad
        $(this).parent().parent().parent().find('#tabla-beneficiarios-content').find('tr').each(function(){
            
            //Tomamos el elemento clon, lo clonamos y lo preparamos para ser agregado al modal
            var tempelem = $('#clon').clone();
            tempelem.removeClass('clon');
            tempelem.removeAttr('id');
            tempelem.find('#identidad').next().addClass('active');
            tempelem.find('#identidad').val($(this).find('#identidad').text());
            buscarCenso(tempelem.find('#identidad'), false);
            
            //Agregamos el clon al modal
            $('#benen-editar').append(tempelem);
            
        });
        
        //Abrimos el modal
        $('#'+$(this).attr('data-idmodal')).modal('open');
        
        //Agregamos listeners para validación con el censo
        agregarBuscarCensoListeners();
    });
    
    var options = {
        page: 6,
        pagination: true,
        valueNames: [ 'codigog', 'nombreg' ],
        fuzzySearch: {
            searchClass: "fuzzy-search",
            location: 0,
            distance: 100,
            threshold: 0.2,
            multiSearch: true
        }
    };
    window.listObj = new List('lista-grupos', options);

});

function asignarEventosEliminar(){

    $('.borrar-beneficiario').each(function(){
        $(this).off('click').on('click', function(){
            var elmem = $(this);
            swal({
                title: "Esta seguro de Eliminar?",
                text: "Esto eliminará permanentemente este crédito del grupo ######!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'Cancelar',
                closeOnConfirm: false
            },

             function(isConfirm){
                if (isConfirm) {
                    (elmem).parent().parent().remove();
                    swal({
                        title: "Eliminado!",
                        text: "El crédito ha sido eliminado del grupo!",
                        type: "success",
                        timer:1100
                    });
                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });   

            /*function(){
                swal("Eliminado!", "El crédito ha sido eliminado del grupo!", "success");
                $(this).parent().parent().remove();
                console.log($(this).parent().parent().parent().parent());
            });*/
        });
    });

} 

</script>