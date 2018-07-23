<?php

require '../php/conection.php';
session_start();
$stat = $conn->prepare('select distinct grupo_solidario_hash, Grupo_Solidario, gestor, Estatus_Prestamo, ciclo, (select observacion from bitacora_creditos where grupo_hash = grupo_solidario_hash 
    and (razon = "Observacion Auxiliar de Creditos" or razon = "Credito Retenido") order by fecha desc limit 1) as observacion
    from cartera_consolidada where Estatus_Prestamo = "Credito Retenido"
    and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');
$stat->execute();
$grupos = $stat->fetchAll();

$stat = $conn->prepare('select identidad, nombre, id, Estatus_Prestamo 
    from cartera_consolidada where Estatus_Prestamo = "Credito Retenido" 
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
        'observacion' => $grupo['observacion'],
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
                            <div class="col l8">Redimir créditos</div>
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
                                                    <div class="row">
                                                        <div class="col l12 m12 s12">
                                                            <div id="card-alert" class="card blue-grey darken-1 z-depth-0">
                                                                <div class="card-content white-text">
                                                                    <p><b>Observación:</b> <?php echo $grupo['observacion'];?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="input-field col s12 l12 center">
                                                            <a href="#!" id="redimir-grupo" class="redimir-grupo btn waves-effect waves-light green"><i class="material-icons left">thumb_up</i> Redimir grupo</a>
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
                                                <h5>No hay créditos castigados.</h5>
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

<script>

$(document).ready(function() {

    window.identidades = [];

    window.current = {
        hash: ''  
    };    

    window.grupos = [];

    $('#breadcrum-title').text('Redimir Créditos');
    
    $('select').material_select();

    $('.tooltipped').tooltip({delay: 50});

    $('.modal').modal();

    $('.collapsible').collapsible();

    $('.collapsible-header').click(function(){
        window.current.hash = $(this).find('#grupo_hash').val();
    });

    $('.redimir-grupo').click(function(){

        swal({
            title: "¿Está seguro que desea redimir el grupo?",
            text: "Esta acción será registrada en la bitácora y el crédito regresará al departamento correspondiente.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, redimir",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function(){
            $.ajax({
                type: 'POST',
                url: '../php/auxiliar-creditos/redimir.php',
                data: 'hash='+window.current.hash,
                success: function(data){
                    console.log(data);
                    $('#floating-refresh').trigger('click');
                    swal("Redimido", "El crédito ha sido redimido.", "success");
                }
            });
            
        });

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