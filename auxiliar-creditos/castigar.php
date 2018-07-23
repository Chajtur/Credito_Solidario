<?php

require '../php/conection.php';
session_start();
$stat = $conn->prepare('select distinct grupo_solidario_hash, Grupo_Solidario, gestor, Estatus_Prestamo, ciclo from cartera_consolidada 
    where Estatus_Prestamo in ("Ingresado", "Call Center", "Para Control de Calidad", "Control de Calidad", "Para Coordinacion", "Coordinacion", "Para Digitacion", "Digitacion", "Para Colocacion", "Colocacion", "Devuelto", "Para Correccion") 
    and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');
$stat->execute();
$grupos = $stat->fetchAll();

$stat = $conn->prepare('select identidad, nombre, id, Estatus_Prestamo 
    from cartera_consolidada where Estatus_Prestamo in ("Ingresado", "Call Center", "Para Control de Calidad", "Control de Calidad", "Para Coordinacion", "Coordinacion", "Para Digitacion", "Digitacion", "Para Colocacion", "Colocacion", "Devuelto", "Para Correccion")
    and grupo_solidario_hash = :hash');

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
                            <div class="col l8">Grupos en el sistema</div>
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
                                    <div class="col s12 l4 hide-on-med-and-down nombreg"><b>Nombre del Grupo</b></div>
                                    <div class="col s12 l5 hide-on-med-and-down integrantesg"><b>Gestor</b></div>
                                </div>
                            </li>
                            
                            <?php if(sizeof($grupos_beneficiarios) != 0):?>
                            
                                <?php foreach($grupos_beneficiarios as $grupo):?>
                                    
                                    <li id="collapsible<?php echo $grupo['hash'];?>" class="">
                                        <div class="collapsible-header">
                                            <div class="col s6 l2 codigog truncate" id="grupo-solidario-hash"><?php echo $grupo['hash'];?></div>
                                            <div class="col s12 l4 hide-on-med-and-down nombreg truncate" id="nombre-grupo"><?php echo $grupo['nombre_grupo'];?></div>
                                            <div class="col s12 l5 hide-on-med-and-down integrantesg truncate"><?php echo $grupo['gestor'];?></div>
                                            <!--<div class="col s2 l1">
                                                <a data-idmodal="modal-editar-grupo" class="secondary-content waves-effect waves-blue btn-editar-grupo"><i class="material-icons blue-text">editar</i></a>
                                            </div>-->
                                            <div>
                                                <input type="hidden" id="hidden-gestor" value="<?php echo $grupo['gestor'];?>">
                                                <input type="hidden" id="hidden-ciclo" value="<?php echo $grupo['ciclo'];?>">
                                                <input type="hidden" id="grupo_hash" value="<?php echo $grupo['hash'];?>">
                                                <input type="hidden" id="ciclo" value="<?php echo $grupo['ciclo'];?>">
                                            </div>
                                        </div>
                                        <div class="collapsible-body">
                                            <div class="row margin">
                                                <div class="col s12 l10 offset-l1">                                                                                                      
                                                    <div><h5 class="light blue-text">Beneficiarios</h5></div>
                                                    <table id="tabla-beneficiarios" class="black-text">
                                                        <thead>
                                                            <tr>
                                                                <th class="black-text" data-field="id">Nombre</th>
                                                                <th class="black-text" data-field="id">Identidad</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabla-beneficiarios-content" class="list-beneficiarios">
                                                            <!--<tr>
                                                                <td class="grey-text"><a href="#modal-bitacora-beneficiario">Maria Eugenia Lopez</a></td>
                                                                <td class="grey-text">0801-1999-00325</td>
                                                            </tr>-->
                                                            
                                                            <?php foreach($grupo['beneficiarios'] as $beneficiario):?>
                                                            
                                                                <tr class="tr-beneficiario">
                                                                    <td class="black-text" id="nombre"><?php echo ucfirst(strtolower($beneficiario['nombre']));?></td>
                                                                    <td class="black-text" id="identidad"><?php echo $beneficiario['identidad'];?></td>
                                                                    <input type="hidden" class="hidden-identidad" value="<?php echo $beneficiario['identidad'];?>">
                                                                    <input type="hidden" class="hidden-id" id="id-credito" value="<?php echo $beneficiario['id'];?>"> 
                                                                    <input type="hidden" class="hidden-id" id="estatus" value="<?php echo $beneficiario['Estatus_Prestamo'];?>"> 
                                                                </tr>
                                                            
                                                            <?php endforeach;?>
                                                            
                                                            
                                                        </tbody>
                                                    </table>
                                                    <div class="divider"></div>
                                                    <div class="row">
                                                        <div class="input-field col s12 l12 center">
                                                            <a href="#!" id="castigar-grupo" class="castigar-grupo btn waves-effect waves-light red"><i class="material-icons left">gavel</i>Retener grupo</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                
                                <?php endforeach;?>
                            
                            <?php else:?>
                            
                                <li>
                                    <div class="collapsible-header sin-icon">
                                        <div class="col s12 l12">
                                            <center>
                                                <h5>No hay créditos.</h5>
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
</div>

<div id="modal-castigar" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4 class="light blue-text">Observaciones de castigo</h4>
        <div id="card-alert" class="card blue z-depth-0">
            <div class="card-content white-text">
                <p>Marque el beneficiario por el que se está castigando el crédito.</p>
            </div>
            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <ul class="collapsible z-depth-0" data-collapsible="expandable" id="beneficiarios-list">
            
        </ul>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action waves-effect waves-red btn-flat red-text" id="btn-modal-castigar-grupo">Retener grupo</a>
        <a href="#!" class="modal-action waves-effect waves-red btn-flat" id="btn-modal-cancelar">Cancelar</a>
    </div>
</div>

<div class="clon">
    <ul>
        <li id="clon" class="beneficiario-en-modal">
            <div class="collapsible-header sin-icon">
                <input type="checkbox" id="test" class="checkbox-beneficiario-observacion"/>
                <label for="test" class="black-text" id="nombre-beneficiario"><span id="nombre">Nombre de la persona</span> (<span id="identidad">9999999999</span>)</label>
            </div>
            <div class="collapsible-body">
                <span>
                    <div class="row">
                        <div class="input-field col s12">
                        <input id="observacion" type="text" class="validate">
                        <label class="active" for="observacion">Observación</label>
                        <input type="hidden" id="hidden-id-credito" value="">
                        <input type="hidden" id="hidden-estatus" value="">
                        </div>
                    </div>
                </span>
            </div>
        </li>
    </ul>
    
</div>


<script>

$(document).ready(function() {

    window.identidades = [];

    window.current = {
        hash: ''  
    };    

    window.grupos = [];

    $('#breadcrum-title').text('Retención de Créditos');
    
    $('.hidden-identidad').each(function(){
        window.identidades.push($(this).val());
    });
    
    $('select').material_select();

    $('.tooltipped').tooltip({delay: 50});

    $('.modal').modal();

    $('.collapsible').collapsible();

    $('.collapsible-header').click(function(){
        window.current.hash = $(this).find('#grupo_hash').val();
    });

    $('.castigar-grupo').click(function(){

        var list = $('#modal-castigar').find('#beneficiarios-list');
        list.empty();
        
        var i = 1;
        $('#collapsible'+window.current.hash).find('.tr-beneficiario').each(function(){
            var clon = $('#clon').clone();
            clon.find('#nombre-beneficiario').find('#nombre').text($(this).find('#nombre').text());
            clon.find('#nombre-beneficiario').find('#identidad').text($(this).find('#identidad').text());
            clon.find('#hidden-id-credito').val($(this).find('#id-credito').val());
            clon.find('#hidden-estatus').val($(this).find('#estatus').val());
            clon.find('#test').attr('id', clon.find('#test').attr('id')+i);
            clon.find('#nombre-beneficiario').attr('for', clon.find('#nombre-beneficiario').attr('for')+i);
            clon.removeAttr('id');
            list.append(clon);
            i++;
        });
        agregarCheckboxListeners();
        $('#modal-castigar').modal('open');

    });

    $("#card-alert .close").click(function(){
        $(this).closest('#card-alert').fadeOut('slow');
    });

    $('#btn-modal-cancelar').click(function(){
        swal({
            title: "¿Está seguro?",
            text: "Perderá los cambios que ha realizado en esta ventana.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, cancelar",
            cancelButtonText: "No, regresar"
        },
        function(){
            $('#modal-castigar').modal('close');
        });
    });

    $('#btn-modal-castigar-grupo').click(function(){

        window.data = {
            hash: window.current.hash,
            beneficiarios: []
        }

        $('#modal-castigar').find('.beneficiario-en-modal').each(function(){

            var emptyBenef = {
                id: '',
                nombre: '',
                identidad: '',
                conObservacion: false,
                observacion: '',
                estatus: ''
            }

            if($(this).find('.checkbox-beneficiario-observacion').first()[0].checked == true){
                emptyBenef.conObservacion = true;
                emptyBenef.observacion = $(this).find('#observacion').val();
            }

            emptyBenef.estatus = $(this).find('#hidden-estatus').val();
            emptyBenef.id = $(this).find('#hidden-id-credito').val();
            emptyBenef.nombre = $(this).find('#nombre').text();
            emptyBenef.identidad = $(this).find('#identidad').text();
            window.data.beneficiarios.push(emptyBenef);

        });

        swal({
            title: "¿Está seguro de retener el grupo seleccionado?",
            text: "Esta acción se registrará en la bitácora de observaciones.",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Si, Retener",
            cancelButtonText: "Cancelar"
        },
        function(){
            $.ajax({
                type: 'POST',
                url: '../php/auxiliar-creditos/castigar.php',
                data: 'data='+JSON.stringify(window.data),
                success: function(data){
                    if(data == true){
                        $('#modal-castigar').modal('close');
                        $('#floating-refresh').trigger('click');
                        swal('Se ha retenido el grupo');
                    }else{
                        swal('Se dió un error durante la ejecución');
                    }
                    
                }
            });
        });

        // console.log(window.data);

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

//Función que devuelve el índice de un objeto del arreglo
function removeObjectFromArray(myArray, searchTerm, property) {
    // console.log(myArray);
    // console.log(searchTerm);
    // console.log(property);
    for(var i = 0, len = myArray.length; i < len; i++) {
        if (myArray[i][property] === searchTerm){
            myArray.splice( i, 1 );
            return false;
        }
    }
}

function eliminarListenerObjectModifier(auxthis){
    // Tomamos la información del beneficiario a eliminar
    var beneficiario = {
        nombre: '',
        identidad: ''
    }
    
    // Asignamos los valores correspondientes
    beneficiario.nombre = auxthis.parent().parent().find('#nombre').text();
    beneficiario.identidad = auxthis.parent().parent().find('#identidad').text();

    // console.log(window.identidades);
    var ind = 0;
    $.each(window.identidades, function(index, value){
        if(beneficiario.identidad == value){
            ind = index;
            return false;
        }
    });
    window.identidades.splice(ind, 1);
    
    // Recorremos para encontrar el objeto respectivo dentro del window.grupos

    $.each(window.grupos, function(index, value){
        if(value.hash == window.current.group){

            var agregado = false;

            $.each(value.agregar, function(ind, val){
                if(val.identidad == beneficiario.identidad){
                    value.agregar.splice(ind, 1);
                    agregado = true;
                    return false;
                }
            });

            // Al encontrarlo, agregamos el elemento a eliminar al objeto
            if(!agregado){
                value.eliminar.push(beneficiario);
            }
            value.cantidad = value.cantidad - 1;

            return false; // Terminamos el ciclo foreach
        }
    });
    
    // console.log(window.current);

    // }else{

    //     // Creamos el objeto temporal que deberia agregarse al window.grupos, debido a que no existe actualmente
    //     var obj = createEmptyObjectElement();
    //     obj.cantidad = obj.cantidad - 1;
        
    //     obj.hash = window.current.group; // Asignamos valores respectivos
    //     obj.eliminar.push(beneficiario); // Asignamos valores respectivos
    //     window.grupos.push(obj); // Agregamos el grupo a window.grupos
    //     $('#checkbox'+window.current.group)[0].checked = true; // Marcamos el checkbox
    // }
}

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

function agregarCheckboxListeners(){
    $('#modal-castigar .collapsible').off('click');

    $('.checkbox-beneficiario-observacion').change(function(){
        var index = $('#modal-castigar .collapsible-header').index($(this).parent());
        if($(this)[0].checked == true){
            $('#modal-castigar .collapsible').collapsible('open', index);
            $(this).parent().next().find('#observacion').focus();
        }else{
            $('#modal-castigar .collapsible').collapsible('close', index);
        }
    });
}
</script>