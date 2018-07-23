<?php

try{
    
    require '../php/conection.php';
    session_start();
    $stat = $conn->prepare('select distinct grupo_solidario_hash, Grupo_Solidario, gestor, Estatus_Prestamo, ciclo 
    from cartera_consolidada where Estatus_Prestamo = "Devuelto" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');
    $stat->execute();
    
    $grupos_reingreso = $stat->fetchAll();
    
    //Stat para capturar los beneficiarios de cada grupo
    $stat = $conn->prepare('select id, identidad, nombre from cartera_consolidada 
        where Estatus_Prestamo = "Devuelto" and grupo_solidario_hash = :hash');

    $grupos_beneficiarios = array();

    //Para cada grupo capturado
    foreach($grupos_reingreso as $grupo){

        //Se obtienen los beneficiarios
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
    
    $stat = $conn->prepare('select distinct gestor from cartera_consolidada where Estatus_Prestamo = "Devuelto"');
    $stat->execute();
    
    $gestores = $stat->fetchAll();
    
}catch(PDOException $e){
    
}

$i = 0;

?>
<div class="section">
    <div class="row">
        <div class="col s12 m8 l10 offset-m2 offset-l1">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">
                        <div class="row">
                            <div class="col l8">Créditos para Reingreso</div>
                            <div class="col l4">
                            </div>
                        </div>
                    </span>
                    <div id="recibidos-call-center-list">
                        <div class="row">
                            <div class="col s12 l6 input-field">
                                <input id="buscarHas" type="text" class="validate fuzzy-search" placeholder="código de Grupo">
                            </div>
                            <div class="col s12 l6 input-field">

                                <select id="select-filtro-gestor">
                                   
                                    <option value="" disabled selected>Elija uno</option>

                                    <?php foreach($gestores as $gestor):?>

                                        <option value="<?php echo substr($gestor['gestor'], 0, 12);?>"><?php echo $gestor['gestor'];?></option>

                                    <?php endforeach;?>

                                </select>
                                <label>Filtrar por Gestor</label>

                            </div>
                        </div>
                        <form id="form-grupos-recibidos">
                            <div class="row">

                                    <div class="col s12">
                                        <ul class="collapsible grupos-recibidos list z-depth-0" data-collapsible="accordion" id="list-grupos-recibidos">

                                            <li class="">

                                                <div class="collapsible-header sin-icon">
                                                    <div class="col s12 l2">
                                                        Check/Hash
                                                    </div>
                                                    <div class="col s12 l3 hide-on-med-and-down truncate">Nombre del Grupo</div>
                                                    <div class="col s12 l5 hide-on-med-and-down truncate">Gestor</div>
                                                    <div class="col s12 l2 hide-on-med-and-down truncate center">Ciclo</div>
                                                </div>

                                            </li>

                                            <?php if(count($grupos_beneficiarios) != 0):?>

                                                <?php foreach($grupos_beneficiarios as $grupo):?>
                                                   
                                                    <li id="collapsible<?php echo $grupo['hash'];?>">
                                                        <div class="collapsible-header sin-icon" id="header">
                                                            <div class="col s12 l2">
                                                                <input type="checkbox" class="filled-in checkhash" id="checkbox<?php echo $grupo['hash'];?>" name="<?php echo $grupo['hash'];?>"/>
                                                                <label class="codigog" for="checkbox<?php echo $grupo['hash'];?>"><?php echo $grupo['hash']?></label>
                                                            </div>
                                                            <div class="col s12 l3 nombreg truncate" id="nombre_grupo"><?php echo $grupo['nombre_grupo']?></div>
                                                            <div class="col s12 l5 hide-on-med-and-down gestorg truncate" id="nombre_gestor"><?php echo $grupo['gestor']?></div>
                                                            <div class="col s12 l2 hide-on-med-and-down estadog truncate center"><?php echo $grupo['ciclo']?></div>
                                                            <input type="hidden" id="grupo_hash" value="<?php echo $grupo['hash'];?>">
                                                            <input type="hidden" id="ciclo" value="<?php echo $grupo['ciclo'];?>">
                                                        </div>
                                                        <div class="collapsible-body no-padding-custom">
                                                            <br>
                                                            <div class="row margin">
                                                                <div class="col l11 m11 s11 offset-l1"><h5 class="light">Beneficiarios</h5></div>
                                                                <div class="col s12 l10 offset-l1">
                                                                    <table id="tabla-verificar-call-center" class="">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="black-text" data-field="id">Nombre</th>
                                                                                <th class="black-text" data-field="id">Identidad</th>
                                                                                <th class="black-text center" data-field="id">Acciones</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="list-beneficiarios">

                                                                            <?php $j = 0;?>

                                                                            <?php foreach($grupo['beneficiarios'] as $beneficiario):?>

                                                                                <tr class="beneficiario-row">
                                                                                    <td class="grey-text global-beneficiario-nombre"><a href="#!" class="a-open-checklist" id="nombre"><?php echo $beneficiario['nombre'];?></a></td>
                                                                                    <td class="grey-text global-beneficiario-identidad" id="identidad"><?php echo $beneficiario['identidad'];?></td>
                                                                                    <td class="grey-text center-align"><a href="#!" class="tooltipped btn-eliminar-beneficiario" data-position="right" data-tooltip="Eliminar"><i id="icon" class="material-icons red-text text-darken-2">delete</i></a></td>
                                                                                    <input type="hidden" class="hidden-identidad" value="<?php echo $beneficiario['identidad'];?>">
                                                                                </tr>

                                                                                <?php $j++;?>

                                                                            <?php endforeach;?>

                                                                        </tbody>
                                                                    </table>
                                                                    <div class="divider"></div>
                                                                    <div class="center">
                                                                        <a class="waves-effect waves-light btn-flat green-text btn-open-modal-agregar-beneficiario" href="#!"><i class="material-icons">add</i></a>
                                                                        <input type="hidden" id="cantidad-beneficiarios" value="<?php echo $j;?>">
                                                                    </div>                                                                    
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
                                                                <h5>No hay créditos para reingreso.</h5>
                                                            </center>
                                                            <!--<input type="checkbox" class="filled-in" id="recibido"/>-->
                                                        </div>
                                                    </div>
                                                </li>

                                            <?php endif;?>

                                        </ul>
                                        <ul id="pag-control" class="pag pagination">
                                        </ul>
                                    </div>

                            </div>
                            <div class="row">
                                <div class="input-field col s12 l6 offset-l3">
                                    <a id="recibidos-success" href="#!" class="btn waves-effect waves-light col s12 ">Re-ingresar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-agregar-beneficiario" class="modal modal-fixed-footer modal-max-width">
    <div class="modal-content">
        <h5 class="light">Nuevo beneficiario</h5>
        <div class="row">
            <div class="input-field col l12 m12 s12">
                <input type="text" name="" id="benefidentidad" class="buscarcenso" maxlength="13">
                <label for="benefidentidad">Identidad</label>
            </div>
            <div class="input-field col l12 m12 s12">
                <input type="text" name="" readonly id="nombre">
                <label for="benefnombre">Nombre</label>
            </div>
            <div class="input-field col l12 m12 s12">
                <input type="text" name="" readonly id="ciclo-sugerido">
                <label for="benefciclo">Ciclo que aplica</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action waves-effect waves-green btn-flat blue-text" id="modal-btn-agregar-beneficiario">Agregar</a>
    </div>
</div>

<div id="modal-alert" class="modal modal-fixed-footer modal-max-width">
    <div class="modal-content">
        <h5 class="light red-text" id="modal-title"></h5>
        <p id="modal-text"></p>
        <div class="row" id="modal-alert-content">
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat blue-text" id="modal-btn-agregar-beneficiario">Entendido</a>
    </div>
</div>

<table class="clon">
    <tr class="beneficiario-row" id="table-row-clon">
        <td class="grey-text global-beneficiario-nombre"><a href="#!" class="a-open-checklist" id="nombre"></a></td>
        <td class="grey-text global-beneficiario-identidad" id="identidad"></td>
        <td class="grey-text center-align"><a href="#!" class="tooltipped btn-eliminar-beneficiario" data-position="right" data-tooltip="Eliminar" id="btn-eliminar"><i id="icon" class="material-icons red-text text-darken-2">delete</i></a></td>
    </tr>
</table>


<script type="text/javascript" src="buscarcenso.js"></script>
<script>
$(document).ready(function () {
    
    agregarBuscarCensoListeners();

    window.identidades = [];
    
    window.current = {
        group: '',
        ciclo: ''
    };
    
    window.grupos = [];
    
    $('.hidden-identidad').each(function(){
        window.identidades.push($(this).val());
    });
    
    $('.modal').modal();
    
    $('.collapsible-header').click(function(){
        window.current.group = $(this).find('#grupo_hash').val(); // obtengo el id del grupo que se selecciono
        window.current.ciclo = $(this).find('#ciclo').val(); // obtengo el id del grupo que se selecciono
    });
    
    $('#breadcrum-parent').text('Créditos');
    $('#breadcrum-title').text('Reingreso de Grupos');
    
    $('select').material_select();
    
    $('.tooltipped').tooltip({delay: 50});
    
    $('#select-filtro-gestor').on('change', function(){
        
        $('#buscarHas').val($('#select-filtro-gestor option:selected').val());
        window.listObj.fuzzySearch($('#select-filtro-gestor option:selected').val());
        
    });
    
    $('.btn-open-modal-agregar-beneficiario').click(function(){
        
        // Esto solo es para saber en que parte de la tabla tengo que agregar el nuevo beneficiario
        $('#modal-agregar-beneficiario').find('input').each(function(){
            $(this).val('');
            $(this).next().removeClass('active');
        });
        $('#modal-agregar-beneficiario').modal('open'); // Abro el modal
        
        // Woow mula de ciencia
    });
    
    $('.checkhash').click(function(){
        
        var obj = createEmptyObjectElement();
        
        var hash = $(this).attr('name');
        
        if($(this).prop('checked')){
            
            obj.hash = $(this).attr('name');
            window.grupos.push(obj);
            
        }else{
            
            var currentObj = {};
            var noDesmarcar = false;
            
            $.each(window.grupos, function(index, value){
                
                if(value.hash == hash){
                    currentObj = value;
                    return false;
                }
                
            });
            
            if(currentObj.eliminar.length != 0 || currentObj.agregar.length != 0){
                swal({
                    title: "¿Está seguro?",
                    text: "Si desmarca el grupo se perderán los cambios que habia realizado en el.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Si, desmarcar",
                    cancelButtonText: "Cancelar"
                },
                function(confirmo){
                    
                    if(confirmo){
                        
                        // Agregamos lo eliminado
                        $.each(currentObj.eliminar, function(index, value){
                            
                            // Clonamos y agregamos la fila
                            var clon = $('#table-row-clon').clone();
                            clon.removeClass('clon').removeAttr('id');

                            // Asignamos el nombre de la persona al td
                            clon.find('#nombre').text(value.nombre);

                            // Asignamos el event listener para el boton de eliminar
                            clon.find('#btn-eliminar').click(function(){
                                eliminarThis($(this));
                            });

                            // Asignamos la identidad en el td
                            clon.find('#identidad').text(value.identidad);
                            
                            $('#collapsible'+window.current.group).find('#list-beneficiarios').append(clon);
                            
                        });
                        
                        // Eliminamos lo agregado
                        $.each(currentObj.agregar, function(index, value){
                            $.each($('#collapsible'+window.current.group).find('#list-beneficiarios').find('tr'), function(i, v){
                                if($(this).find('#identidad').text() == value.identidad){
                                    $(this).remove();
                                }
                            });
                        });
                        
                        $('#checkbox'+window.current.group).removeAttr('checked');
                        $('#checkbox'+window.current.group)[0].checked = false;
                        
                    }else{
                        $('#checkbox'+window.current.group).removeAttr('checked');
                        $('#checkbox'+window.current.group).attr('checked', 'true');
                        $('#checkbox'+window.current.group)[0].checked = true;
                        noDesmarcar = true;
                    }
                    
                    if(noDesmarcar) return false;
            
                    var currhash = $(this).attr('name'), ind = 0;
                    $.each(window.grupos, function(index, value){
                        if(value.hash == currhash){
                            ind = index;
                            return false;
                        }
                    });
                    window.grupos.splice(ind, 1);
                    
                });
            }
            
        }
        
        //console.log(window.grupos);
        
    });
    
    $('#modal-btn-agregar-beneficiario').click(function(){
        
        // Esto se ejecuta cuando termino de digitar el nuevo beneficiario al grupo
        
        if($('#modal-agregar-beneficiario').find('#benefidentidad').val() == '' || $('#modal-agregar-beneficiario').find('#benefidentidad').val().length < 13){
            swal('Rellene los campos', 'Antes de agregar un beneficiario debe completar los campos', 'warning');
            return false;
        }
        
        if($('#modal-agregar-beneficiario').find('#nombre').val() == 'Buscando...'){
            swal('Por favor espere a que el sistema detecte el nombre de la persona o a que se habilite el campo para que pueda ingresarlo.');
            return false;
        }
        
        if($('#modal-agregar-beneficiario').find('#nombre').val() == ''){
            swal('Rellene los campos', 'El campo de nombre está vacío', 'warning');
            return false;
        }
        
        if($('#modal-agregar-beneficiario').find('#ciclo-sugerido').val() == ''){
            swal('Por favor espere a que se termine de verificar el ciclo');
            return false;
        }
        
        if($('#modal-agregar-beneficiario').find('#ciclo-sugerido').val() != window.current.ciclo){
            swal('La persona que desea agregar al grupo no aplica al ciclo correspondiente.');
            return false;
        }
        
        // Verificamos si no está en el grupo actual
        var yaEnGrupo = false;
        $('#collapsible'+window.current.group).find('tr').each(function(ind){
            if($(this).find('#identidad').text() == $('#modal-agregar-beneficiario').find('#benefidentidad').val()){
                yaEnGrupo = true;
                //console.log('Hola');
                return false;
            }
        });
        if(yaEnGrupo){
            swal('La persona ya está en el grupo.');
            return false;
        }
        
        // Verificamos si no está en el arreglo de identidades
        var yaEnOtroGrupo = false;
        $.each(window.identidades, function(ind, val){
            if(val == $('#modal-agregar-beneficiario').find('#benefidentidad').val()){
                yaEnOtroGrupo = true;
                return false;
            }
        });
        if(yaEnOtroGrupo){
            swal('La persona ya está en otro grupo para reingreso.');
            return false;
        }else{
            window.identidades.push($('#modal-agregar-beneficiario').find('#benefidentidad').val());
        }
        
        // Tomamos la información del beneficiario a agregar
        var beneficiario = {
            nombre: '',
            identidad: ''
        }
        
        // Asignamos los valores correspondientes
        beneficiario.nombre = $('#modal-agregar-beneficiario').find('#nombre').val();
        beneficiario.identidad = $('#modal-agregar-beneficiario').find('#benefidentidad').val();
        
        if(!$('#checkbox'+window.current.group).length){
            window.current.group = $('.collapsible-header.active').first().find('#grupo_hash').val(); // obtengo el id del grupo que se selecciono
            window.current.ciclo = $('.collapsible-header.active').first().find('#ciclo').val();
        }
        
        if($('#checkbox'+window.current.group)[0].checked){
            
            // Recorremos para encontrar el objeto respectivo dentro del window.grupos
            $.each(window.grupos, function(index, value){
                if(value.hash == window.current.group){
                    
                    var agregado = false;
                    
                    $.each(value.agregar, function(ind, val){
                        if(val.identidad == beneficiario.identidad){
                            agregado = true;
                            return false;
                        }
                    });
                    
                    var eliminado = false;
                    
                    // Eliminamos el elemento a ingresar si está en el arreglo de eliminación
                    $.each(value.eliminar, function(ind, val){
                        if(val.identidad == beneficiario.identidad){
                            value.eliminar.splice(ind, 1);
                            eliminado = true;
                            return false;
                        }
                    });
                    
                    // Al encontrarlo, agregamos el elemento a agregar al grupo
                    if(!agregado && !eliminado){
                        value.agregar.push(beneficiario);
                        value.cantidad = value.cantidad + 1;
                    }
                    
                    return false; // Terminamos el ciclo foreach
                }
            });
            
        }else{
            
            // Creamos el objeto temporal que deberia agregarse al window.grupos, debido a que no existe actualmente
            var obj = createEmptyObjectElement();
            obj.cantidad = obj.cantidad + 1;
            
            obj.hash = window.current.group; // Asignamos valores respectivos
            obj.agregar.push(beneficiario); // Asignamos valores respectivos
            window.grupos.push(obj); // Agregamos el grupo a window.grupos
            $('#checkbox'+window.current.group)[0].checked = true; // Marcamos el checkbox
            
        }
        
        // Clonamos y agregamos la fila
        var clon = $('#table-row-clon').clone();
        clon.removeClass('clon').removeAttr('id');
        
        // Asignamos el nombre de la persona al td
        clon.find('#nombre').text($('#modal-agregar-beneficiario').find('#nombre').val()); 
        
        // Asignamos el event listener para el boton de eliminar
        clon.find('#btn-eliminar').click(function(){
            
            eliminarListenerObjectModifier($(this));
            eliminarThis($(this));
            
        });
        
        // Asignamos la identidad en el td
        clon.find('#identidad').text($('#modal-agregar-beneficiario').find('#benefidentidad').val());
        
        $('#collapsible'+window.current.group).find('#list-beneficiarios').append(clon);
        
        $('#modal-agregar-beneficiario').find('input').each(function(){
            $(this).val('');
            $(this).next().removeClass('active');
        });
        
        // Marcamos el checkbox del grupo debido a la modificación
        if(!$('#checkbox'+window.current.group).prop('checked') || $('#checkbox'+window.current.group).attr('checked') == 'checked'){
            $('#checkbox'+window.current.group)[0].checked = true;
        }
        
        Materialize.toast('Agregado', 2000);
        $('#modal-agregar-beneficiario').modal('close');
        
    });
    
    $('.btn-eliminar-beneficiario').click(function(){
        
        // Ambas definidas al final del archivo y asignadas también en el click del boton eliminar 
        // del nuevo beneficiario desde el boton del modal
        eliminarListenerObjectModifier($(this));
        eliminarThis($(this)); // Ahora si eliminamos al beneficiario
        
    });
    
    $('#recibidos-success').click(function(){

        if(window.grupos.length == 0){
            swal("Ningún Crédito Seleccionado", "Por favor seleccione los créditos que desea reingresar", "error");
            return false;
        }
        
        // Inicia el modal si encuentra un grupo con menos de 2 beneficiarios
        var modalcol = $('<div class="col l12 m12 s12"></div>');
        modalcol.append('<p><b>Código Hash</b></p>');
        
        var faltanBeneficiarios = false;
        $.each(window.grupos, function(index, value){
            
            if(value.cantidad < 2){
                var hash = $('<p><span class="light">'+value.hash+'</span></p>');
                modalcol.append(hash);
                
                if(!faltanBeneficiarios)
                    faltanBeneficiarios = true;
            }
            
        });
        
        if(faltanBeneficiarios){
            
            $('#modal-alert').find('#modal-title').text('Hay Grupos erroneos');
            $('#modal-alert').find('#modal-text').text('No se pueden reingresar créditos con menos de 2 beneficiarios. Por favor verifique los grupos siguientes:');
            $('#modal-alert').find('#modal-alert-content').empty();
            $('#modal-alert').find('#modal-alert-content').append(modalcol);
            $('#modal-alert').modal('open');
            return false;
        }
        
        swal({
            title: "¿Esta seguro/a de re-ingresar el grupo al sistema?",
            text: "El crédito pasará de nuevo por todo el proceso de verificación.",
            type: "warning",
            showCancelButton: true,
            /*confirmButtonColor: "#DD6B55",*/
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            cancelButtonText: "Cancelar"
        },
        function(){
            $.ajax({
                type: 'POST',
                url: '../php/super-digitador/reingreso-grupo.php',
                data: 'data='+JSON.stringify(window.grupos),
                success: function(data){
                    if(data){
                        $('#floating-refresh').trigger('click');
                        console.log(data);
                        swal({
                            title: "Completado", 
                            text: "El crédito se ha recibido con éxito.", 
                            type: "success"
                        });
                    }
                }
            });
        });
        
    });
    
    listaSor();
    
    $('.collapsible').collapsible();
    
});

function listaSor(){
    
    var options = {
        page: 10,
        pagination: true,
        valueNames: [ 'codigog', 'nombreg', 'gestorg', 'estadog' ],
        fuzzySearch: {
            searchClass: "fuzzy-search",
            location: 0,
            distance: 100,
            threshold: 0.2,
            multiSearch: true
        }
    };
    window.listObj = new List('recibidos-call-center-list', options);
    
}
    
function eliminarThis(elem){
    
    var auxthis = elem;
        
    swal({
        title: "¿Está seguro que desea eliminar el beneficiario?",
        text: "El beneficiario ya no estará disponible en el grupo.",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Eliminar",
        closeOnConfirm: true
    },
    function(){
        auxthis.parent().parent().fadeOut(300, function(){
            auxthis.parent().parent().remove();
        });
        
        if(!$('#checkbox'+window.current.group).prop('checked')){
            $('#checkbox'+window.current.group).attr('checked', 'true');
        }
        swal("Eliminado", "El beneficiario ha sido eliminado.", "success");
    });
    
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

    var ind = 0;
    $.each(window.identidades, function(index, value){
        if(beneficiario.identidad == value){
            ind = index;
            return false;
        }
    });
    window.identidades.splice(ind, 1);
    
    if($('#checkbox'+window.current.group).prop('checked')){

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

    }else{

        // Creamos el objeto temporal que deberia agregarse al window.grupos, debido a que no existe actualmente
        var obj = createEmptyObjectElement();
        obj.cantidad = obj.cantidad - 1;
        
        obj.hash = window.current.group; // Asignamos valores respectivos
        obj.eliminar.push(beneficiario); // Asignamos valores respectivos
        window.grupos.push(obj); // Agregamos el grupo a window.grupos
        $('#checkbox'+window.current.group)[0].checked = true; // Marcamos el checkbox
    }
}
    
function createEmptyObjectElement(){
    var empty = {
        hash: '',
        gestor: '',
        ciclo: '',
        nombre_grupo: '',
        cantidad: '',
        eliminar: [],
        agregar: []
    }
    empty.cantidad = parseInt($('#collapsible'+window.current.group).find('#cantidad-beneficiarios').val());
    empty.gestor = $('#collapsible'+window.current.group).find('#nombre_gestor').text();
    empty.ciclo = $('#collapsible'+window.current.group).find('#ciclo').val();
    empty.nombre_grupo = $('#collapsible'+window.current.group).find('#nombre_grupo').text();
    return empty;
}
</script>