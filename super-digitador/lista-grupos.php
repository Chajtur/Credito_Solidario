<?php

require '../php/conection.php';
session_start();
$stat = $conn->prepare('select distinct grupo_solidario_hash, Grupo_Solidario, gestor, Estatus_Prestamo, ciclo 
    from cartera_consolidada where Estatus_Prestamo in ("Ingresado", "Para Control de Calidad", "Para Coordinacion", "Para Digitacion", "Call Center") and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');
$stat->execute();
$grupos = $stat->fetchAll();

$stat = $conn->prepare('select identidad, nombre from cartera_consolidada 
    where Estatus_Prestamo in ("Ingresado", "Para Control de Calidad", "Para Coordinacion", "Para Digitacion", "Call Center") and grupo_solidario_hash = :hash');

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
<?php
    try{
        require "../php/conection.php";
        $stat = $conn->prepare('select id, nombre from gsc where tipoEmpleado = "Gestor" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.') order by nombre');
        $stat->execute();
        $gestores = $stat->fetchAll();
    }catch(PDOException $e){
        //header('Location: index.php');
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
                                    <div class="col s12 l5 hide-on-med-and-down nombreg"><b>Nombre del Grupo</b></div>
                                    <div class="col s12 l5 hide-on-med-and-down integrantesg"><b>Gestor</b></div>
                                </div>
                            </li>
                            
                            <?php if(sizeof($grupos_beneficiarios) != 0):?>
                            
                                <?php foreach($grupos_beneficiarios as $grupo):?>
                                    
                                    <li id="collapsible<?php echo $grupo['hash'];?>" class="">
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
                                                <input type="hidden" id="grupo_hash" value="<?php echo $grupo['hash'];?>">
                                                <input type="hidden" id="ciclo" value="<?php echo $grupo['ciclo'];?>">
                                            </div>
                                        </div>
                                        <div class="collapsible-body">
                                            <div class="row margin">
                                                <div class="col s12 l12">
                                                    <div class="row">
                                                        <table class="black-text">
                                                            <thead>
                                                                <tr>
                                                                    <th class="black-text col s6 l6" data-field="id">Nombre del Grupo</th>
                                                                    <th class="black-text col s5 l5" data-field="id">Gestor</th>
                                                                    <!-- <th class="black-text col s1 l1 right" data-field="id">Acciones</th> -->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="col s6 l6">
                                                                        <input type="text" style="padding-top: 19px;" class="edicion-nombreGrupo" name="edicion-nombreGrupo" value="<?php echo $grupo['nombre_grupo'];?>" placeholder="Nombre del grupo">
                                                                    </td>
                                                                    <td class="col s6 l6" style="padding-top: 19px;">
                                                                        <select name="edicion-gestor" class="edicion-gestor browser-default validate" required>

                                                                            <option value="" disabled="" selected><?php echo $grupo['gestor'];?></option>

                                                                            <?php foreach($gestores as $gestor):?>

                                                                                <option value="<?php echo $gestor['id'];?>"><?php echo $gestor['nombre'];?></option>

                                                                            <?php endforeach;?>

                                                                        </select>  
                                                                    </td>
                                                                    
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                                                                      
                                                    <div><h5 class="light">Beneficiarios</h5></div>
                                                    <table id="tabla-beneficiarios" class="black-text">
                                                        <thead>
                                                            <tr>
                                                                <th class="black-text" data-field="id">Nombre</th>
                                                                <th class="black-text" data-field="id">Identidad</th>
                                                                <th class="black-text center" data-field="id">Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tabla-beneficiarios-content" class="list-beneficiarios"><!--
                                                            <tr>
                                                                <td class="grey-text"><a href="#modal-bitacora-beneficiario">Maria Eugenia Lopez</a></td>
                                                                <td class="grey-text">0801-1999-00325</td>
                                                            </tr>-->
                                                            
                                                            <?php foreach($grupo['beneficiarios'] as $beneficiario):?>
                                                            
                                                                <tr class="tr-beneficiario">
                                                                    <td class="blue-text" id="nombre"><?php echo $beneficiario['nombre']?></td>
                                                                    <td class="black-text" id="identidad"><?php echo $beneficiario['identidad']?></td>
                                                                    <td class="grey-text center-align"><a href="#!" class="tooltipped btn-eliminar-beneficiario" data-position="right" data-tooltip="Eliminar"><i id="icon" class="material-icons red-text text-darken-2">delete</i></a></td>
                                                                    <input type="hidden" class="hidden-identidad" value="<?php echo $beneficiario['identidad'];?>">
                                                                </tr>
                                                            
                                                            <?php endforeach;?>
                                                            
                                                            
                                                        </tbody>
                                                    </table>
                                                    <div class="divider"></div>
                                                    <div class="center">
                                                        <a class="waves-effect waves-light btn-flat green-text btn-open-modal-agregar-beneficiario tooltipped" data-position="right" data-tooltip="Agregar Beneficiario" href="#!"><i class="material-icons">add</i></a>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="input-field col s12 l6 offset-l3">
                                                            <a href="#!" id="guardar-cambios" class="guardar-cambios btn waves-effect waves-light col s12 ">Guardar Cambios</a>
                                                        </div>
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
    <!--DIV CLON-->

</div>
<script type="text/javascript" src="buscarcenso.js"></script>
<script>

$(document).ready(function() {

    $('.guardar-cambios').attr('disabled', 'true');

    window.identidades = [];

    window.current = {
        group: '',
        ciclo: '',
        nombre: '',
        cnombre: '',
        gestor: '',
        cgestor:'',
        beneficiarios: [],
        borrarBeneficiarios: [],
        agregarBeneficiarios: []   
    };    

    window.grupos = [];

    $('.hidden-identidad').each(function(){
        window.identidades.push($(this).val());
    });    

    agregarBuscarCensoListeners();

    $('.edicion-gestor').select2();
    
    $('#breadcrum-title').text('Lista de Grupos');
    
    $('select').material_select();

    $('.tooltipped').tooltip({delay: 50});

    $('#select-modal-asesores').select2();

    $('.modal').modal();

    $('.collapsible').collapsible();

    $('.collapsible-header').click(function(){
        // console.log($(this).find('#grupo_hash').val());
        window.current.group = $(this).find('#grupo_hash').val(); // obtengo el id del grupo que se selecciono
        window.current.ciclo = $(this).find('#ciclo').val(); // obtengo el ciclo del grupo que se selecciono
        window.current.gestor = $(this).find('#hidden-gestor').val(); // obtengo el gestor del grupo que se selecciono
        window.current.nombre = $(this).find('#nombre-grupo').html(); // obtengo el nombre del grupo que se selecciono
        $(this).parent().find('.tr-beneficiario').each(function() {
            var tempObj = {
                nombre: $(this).find('#nombre').text(),
                identidad: $(this).find('#identidad').text()
            }
            window.current.beneficiarios.push(tempObj); 
            // window.current.beneficiarios[] = tempObj; 
            // console.log(tempObj);
        });
    });    

    $('.edicion-nombreGrupo').change(function() {
        window.current.nombre = $(this).val();
        window.current.cnombre = 1; //Bandera para actualizar solamente el campo en el php
        // console.log(window.current);        
        $(this).parent().parent().parent().parent().parent().parent().find('#guardar-cambios').removeAttr('disabled');
    });

    $('.edicion-gestor').change(function() {
        window.current.gestor = $("option:selected", this).text();
        window.current.cgestor = 1; //Bandera para actualizar solamente el campo en el php
        // console.log(window.current);        
        $(this).parent().parent().parent().parent().parent().parent().find('#guardar-cambios').removeAttr('disabled');
    });    

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

    $('.btn-eliminar-beneficiario').click(function(){
        
        // Ambas definidas al final del archivo y asignadas también en el click del boton eliminar 
        // del nuevo beneficiario desde el boton del modal
        eliminarListenerObjectModifier($(this));
        eliminarThis($(this)); // Ahora si eliminamos al beneficiario        
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
            swal('La persona ya está en otro grupo.');
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
        window.current.agregarBeneficiarios.push(beneficiario);
        window.current.beneficiarios.push(beneficiario);
        
        $('#collapsible'+window.current.group).find('#guardar-cambios').removeAttr('disabled');
        
        // if(!$('#checkbox'+window.current.group).length){
        //     window.current.group = $('.collapsible-header.active').first().find('#grupo_hash').val(); // obtengo el id del grupo que se selecciono
        //     window.current.ciclo = $('.collapsible-header.active').first().find('#ciclo').val();
        // }
        
        // if($('#checkbox'+window.current.group)[0].checked){
            
            // Recorremos para encontrar el objeto respectivo dentro del window.grupos
            // $.each(window.grupos, function(index, value){
            //     if(value.hash == window.current.group){
                    
            //         var agregado = false;
                    
            //         $.each(value.agregar, function(ind, val){
            //             if(val.identidad == beneficiario.identidad){
            //                 agregado = true;
            //                 return false;
            //             }
            //         });
                    
            //         var eliminado = false;
                    
            //         // Eliminamos el elemento a ingresar si está en el arreglo de eliminación
            //         $.each(value.eliminar, function(ind, val){
            //             if(val.identidad == beneficiario.identidad){
            //                 value.eliminar.splice(ind, 1);
            //                 eliminado = true;
            //                 return false;
            //             }
            //         });
                    
            //         // Al encontrarlo, agregamos el elemento a agregar al grupo
            //         if(!agregado && !eliminado){
            //             value.agregar.push(beneficiario);
            //             value.cantidad = value.cantidad + 1;
            //         }
                    
            //         return false; // Terminamos el ciclo foreach
            //     }
            // });
            
        // }else{
            
        //     // Creamos el objeto temporal que deberia agregarse al window.grupos, debido a que no existe actualmente
        //     var obj = createEmptyObjectElement();
        //     obj.cantidad = obj.cantidad + 1;
            
        //     obj.hash = window.current.group; // Asignamos valores respectivos
        //     obj.agregar.push(beneficiario); // Asignamos valores respectivos
        //     window.grupos.push(obj); // Agregamos el grupo a window.grupos
        //     $('#checkbox'+window.current.group)[0].checked = true; // Marcamos el checkbox
            
        // }
        
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
        
        $('#collapsible'+window.current.group).find('.list-beneficiarios').append(clon);
        
        $('#modal-agregar-beneficiario').find('input').each(function(){
            $(this).val('');
            $(this).next().removeClass('active');
        });
        
        // Marcamos el checkbox del grupo debido a la modificación
        // if(!$('#checkbox'+window.current.group).prop('checked') || $('#checkbox'+window.current.group).attr('checked') == 'checked'){
        //     $('#checkbox'+window.current.group)[0].checked = true;
        // }
        
        Materialize.toast('Agregado', 2000);
        // console.log(window.current);
        // console.log(beneficiario);
        // console.log(window.current);    
        $('#modal-agregar-beneficiario').modal('close');        
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

    $('.guardar-cambios').click(function(){

        // if(window.grupos.length == 0){
        //     swal("Ningún Crédito Seleccionado", "Por favor seleccione los créditos que desea reingresar", "error");
        //     return false;
        // }
        
        // Inicia el modal si encuentra un grupo con menos de 2 beneficiarios
        var modalcol = $('<div class="col l12 m12 s12"></div>');
        modalcol.append('<p><b>Código Hash</b></p>');

        var faltanBeneficiarios = false;
        // $.each(window.current.beneficiarios, function(index, value){
            
            // console.log(window.current.beneficiarios);
            if(window.current.beneficiarios.length < 2){
                var hash = $('<p><span class="light">'+window.current.group+'</span></p>');
                modalcol.append(hash);
                
                if(!faltanBeneficiarios)
                    faltanBeneficiarios = true;
            }
            
        // });
        
        if(faltanBeneficiarios){
            
            $('#modal-alert').find('#modal-title').text('¡ADVERTENCIA!');
            $('#modal-alert').find('#modal-text').text('No se puede guardar el crédito con menos de 2 beneficiarios.');
            $('#modal-alert').find('#modal-alert-content').empty();
            $('#modal-alert').find('#modal-alert-content').append(modalcol);
            $('#modal-alert').modal('open');
            return false;
        }
        
        swal({
            title: "¿Esta seguro/a que desesa guardar los cambios?",
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
                url: '../php/credito/modificar-grupo.php',
                data: 'data='+JSON.stringify(window.current),
                success: function(data){
                    // if(data){
                        $('#floating-refresh').trigger('click');
                        // console.log(data);
                        swal({
                            title: "Completado", 
                            text: "El crédito se ha recibido con éxito.", 
                            type: "success"
                        });
                    // }
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
        // Tomamos la información del beneficiario a eliminar
        var beneficiario = {
            nombre: '',
            identidad: ''
        }
        
        // Asignamos los valores correspondientes
        beneficiario.nombre = auxthis.parent().parent().find('#nombre').text();
        beneficiario.identidad = auxthis.parent().parent().find('#identidad').text();
        // console.log(window.current.beneficiarios);
        removeObjectFromArray(window.current.beneficiarios, beneficiario.identidad, "identidad");
        window.current.borrarBeneficiarios.push(beneficiario);
        $(auxthis).parent().parent().parent().parent().parent().find('#guardar-cambios').removeAttr('disabled');
        
        auxthis.parent().parent().fadeOut(300, function(){
            auxthis.parent().parent().remove();
        });

        // if(!$('#checkbox'+window.current.group).prop('checked')){
        //     $('#checkbox'+window.current.group).attr('checked', 'true');
        // }

        // console.log(window.current);

        swal("Eliminado", "El beneficiario ha sido eliminado.", "success");
    });    
}

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
console.log("Hola Mundo!");
</script>