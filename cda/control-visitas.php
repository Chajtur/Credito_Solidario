<?php

session_start();
require '../php/conection.php';

$stat = $conn2->prepare('call get_name_employee_id();');
$stat->execute();
$empleados = $stat->fetchAll(PDO::FETCH_ASSOC);

if(in_array($_SESSION['designation'], array(18, 81, 87))){
    $sql = 'call obtener_visitas_cda_ciudad_mujer();';
}else{
    $sql = 'call obtener_visitas_cda();';
}
$stat = $conn->prepare($sql);
$stat->execute();
$visitas = $stat->fetchAll(PDO::FETCH_ASSOC);

?>
<style>

.custom-top {
    top: 0.15rem !important;
}

</style>
<div class="row">

    <div class="col l4 m4 s4">
        <form id="form_guardar_visita">

            <div class="card">

                <div class="card-content">

                    <span class="card-title blue-text">Nuevo Registro de Visita</span>
                    <br>
                    <p>Datos de la Persona</p>

                    <div class="input-field">
                        <i class="material-icons prefix indigo-text">contacts</i>
                        <input id="input_identidad" type="text" maxlength="13" data-length="13" class="validate buscarcenso" placeholder="9999999999999" required>
                        <label for="input_identidad" class="active">Identidad</label>
                    </div>

                    <div class="input-field">
                        <i class="material-icons prefix indigo-text">person</i>
                        <input id="nombre" type="text" class="" placeholder="Nombre de la persona" required>
                        <label for="input_nombre" class="active">Nombre</label>
                    </div>

                    <div class="input-field">
                        <i class="material-icons prefix indigo-text">call</i>
                        <input id="input_telefono" type="text" maxlength="8" data-length="8" class="validate" placeholder="33333333" required>
                        <label for="input_telefono" class="active">Teléfono</label>
                    </div>

                    <div class="input-field">
                        <i class="material-icons prefix indigo-text">message</i>
                        <input type="checkbox" id="input_whatsapp" />
                        <label for="input_whatsapp" class="custom-top">¿Tiene Whatsapp?</label>
                    </div>

                    <br>

                    <div class="input-field">
                        <i class="material-icons prefix indigo-text">email</i>
                        <input id="input_email" type="email" class="validate" placeholder="correo@correo.com">
                        <label for="input_email" class="active">Correo</label>
                    </div>

                    <div class="input-field">
                        <i class="material-icons prefix indigo-text">location_on</i>
                        <input id="input_direccion" maxlength="200" data-length="200" type="text" class="validate" placeholder="Direccion de la persona">
                        <label for="input_direccion" class="active">Dirección</label>
                    </div>

                    <br>

                    <p>Datos de la consulta</p>

                    <div class="input-field">
                        <i class="material-icons prefix indigo-text">directions_run</i>
                        <select class="browser-default select2-with-icon-prefix" id="select_responsable" required>
                            <option value="" disabled selected>Elija un responsable</option>

                            <?php foreach($empleados as $empleado):?>
                                <option value="<?php echo $empleado['employee_id'];?>"><?php echo $empleado['nombre'];?></option>
                            <?php endforeach;?>

                            <option value="<?php echo $_SESSION['user'];?>">CDA</option>
                        </select>
                        <br>
                    </div>

                    <div class="input-field">
                        <i class="material-icons prefix indigo-text">question_answer</i>
                        <textarea maxlength="2048" data-length="2048" id="input_consulta" class="materialize-textarea validate" placeholder="Consulta del Cliente" required></textarea>
                        <label for="input_consulta" class="active">Consulta del Cliente</label>
                    </div>

                    <div class="input-field">
                        <i class="material-icons prefix indigo-text" id="icon">question_answer</i>
                        <textarea maxlength="2048" data-length="2048" id="input_solucion" class="materialize-textarea validate" placeholder="Solución dada" required></textarea>
                        <label for="input_solucion" class="active">Solución</label>
                    </div>

                </div>

                <div class="card-action">
                    <button type="submit" class="btn-flat blue-text" id="btnagregar">Agregar</button>
                </div>

            </div>

        </form>
    </div>

    <div class="col l8 m8 s8">

        <!-- Busqueda  -->
        <div id="work-collapsible">
            <div class="row">
                <div class="col s12">
                    <ul id="visitas-list" class="collapsible" data-collapsible="accordion">
                    
                        <li class="collapsible-item-header avatar">
                            <i class="material-icons circle green">directions_walk</i>
                            <span class="collapsible-title-header">Visitas CDA
                                <div class="secondary-content actions">
                                    <a class="waves-effect waves-light btn-flat nopadding tooltipped generar-excel" id="btnGenerarExcel" data-delay="10" data-position="left" data-tooltip="Exportar a Excel">
                                        <i class="material-icons center-align">description</i>
                                    </a>
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
                                        <p class="collapsible-title">Teléfono</p>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <div class="list collapsible no-padding no-margin z-depth-0">

                            <?php if(count($visitas) > 0):?>
                                
                                <?php $contador = 0;?>

                                <?php foreach($visitas as $visita):?>

                                    <li>

                                        <div class="collapsible-header sin-icon <?php echo (($visita['solucion'] == '' || $visita['solucion'] == null) ? '' : 'tooltipped green-text text-darken-2');?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo (($visita['solucion'] == '' || $visita['solucion'] == null) ? '--No se ha solucionado--' : 'Solución: '.$visita['solucion']);?>">
                                            <div class="row">
                                                <div class="col s1 m1 l1 truncate"><?php echo ++$contador;?></div>
                                                <div class="col s11 m5 l4 truncate"><span class="nombreb"><?php echo $visita['nombre'];?></span></div>
                                                <div class="col s4 m4 l4 hide-on-small-only identidadb truncate"><?php echo $visita['identidad'];?></div>
                                                <div class="col s6 m3 l3 hide-on-med-and-down estatusb truncate"><?php echo $visita['telefono'];?></div>
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
                                                            <p><span class="light">Dirección:</span> <?php echo $visita['direccion'];?></p>
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

                                                <?php if($visita['solucion'] != '' || $visita['solucion'] != null):?>

                                                    <div class="card-action">
                                                        <a href="#" class="btn_cerrar_caso">Cerrar caso</a>
                                                        <input type="hidden" id="id_caso" value="<?php echo $visita['id'];?>">
                                                    </div>

                                                <?php endif;?>

                                                <!-- <div class="card-reveal blue-grey darken-1 white-text">

                                                    <span class="card-title text-darken-4"><span id="card-reveal-title"></span><i class="material-icons right">close</i></span>
                                                    
                                                    <div class="container center" id="bitacora-loading">
                                                        <div class="preloader-wrapper active">
                                                            <div class="spinner-layer spinner-green-only">
                                                                <div class="circle-clipper left">
                                                                    <div class="circle"></div>
                                                                </div>
                                                                <div class="gap-patch">
                                                                    <div class="circle"></div>
                                                                </div>
                                                                <div class="circle-clipper right">
                                                                    <div class="circle"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                        
                                                    <div class="" id="bitacora-content">
                                                        
                                                        
                                                        
                                                    </div>
                                                    
                                                </div> -->

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
        <!-- Busqueda  -->

    </div>
    
</div>

<script type="text/javascript" src="../credito/buscarcenso.js"></script>

<script>

    $(document).ready(init);

    function init(){

        // Plugin buscar censo
        agregarBuscarCensoListeners();
        $('input#input_telefono, textarea#input_consulta, textarea#input_solucion, input#input_direccion, input#input_identidad').characterCounter();

        // Eventos
        $('#form_guardar_visita').submit(guardar_visita);
        $('.icon-collapse-search').click(abrirInputBuscar);
        $('#select_responsable').change(modificarRequisitosDeSolucion);
        $('.btn_cerrar_caso').click(cerrarCaso);
        $('#btnGenerarExcel').click(generarExcel);

        // Materialize
        $('select').material_select();
        $('.collapsible').collapsible();
        $('.tooltipped').tooltip({delay: 200});

        // Select2
        $('#select_responsable').select2();
        $('.select2-with-icon-prefix').next().find('.select2-selection.select2-selection--single').first().css('width', 'calc(100% - 42px)');
        $('.select2-with-icon-prefix').next().find('.select2-selection__arrow').first().css('right', '42px');
        $('.select2-with-icon-prefix').next().css('margin-left','42px');
        $('.select2-with-icon-prefix').next().css('margin-right','-42px');

        // Breadcrum
        $('#breadcrum-title').text('Control de Visitas');

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

    function guardar_visita(e){
        
        $('#btnagregar').attr('disabled', 'disabled');
        e.preventDefault();
        // console.log($('#input_whatsapp'));
        var obj = {
            identidad: $('#input_identidad').val(),
            nombre: $('#nombre').val(),
            telefono: $('#input_telefono').val(),
            whatsapp: ($('#input_whatsapp').prop('checked') ? '1' : '0'),
            correo: $('#input_email').val(),
            direccion: $('#input_direccion').val(),
            consulta: $('#input_consulta').val(),
            solucion: $('#input_solucion').val(),
            responsable: $('#select_responsable').val(),
            usuario: ''
        }

        $.ajax({
            type: 'POST',
            url: '../php/cda/guardar-visita.php',
            data: obj,
            success: function(data){

                if(data == 'true'){
                    swal('Correcto','Se ha registrado la visita correctamente', 'success');
                    $('#floating-refresh').trigger('click');
                }else{
                    swal('Error','Ha ocurrido un error al realizar la operación', 'error');
                }
                $('#btnagregar').removeAttr('disabled');

            }
        });

    }

    function abrirInputBuscar(){
        $('.search-expandida').toggleClass('expanded');
        $('.search-expandida').focus();
    }

    function modificarRequisitosDeSolucion(){

        if($(this).val() != <?php echo '"'.$_SESSION['user'].'"';?>){
            $('#input_solucion').removeAttr('required');
            $('#input_solucion').attr('disabled', 'disabled');
            $('#input_solucion').parent().find('#icon').removeClass('indigo-text');
            $('#input_solucion').parent().find('#icon').addClass('grey-text');
        }else{
            $('#input_solucion').attr('required','required');
            $('#input_solucion').removeAttr('disabled');
            $('#input_solucion').parent().find('#icon').removeClass('grey-text');
            $('#input_solucion').parent().find('#icon').addClass('indigo-text');
        }

    }

    function cerrarCaso(){

        var auxthis = $(this);

        swal({
            title: "¿Está seguro/a de cerrar el caso actual?",
            text: "El caso se registrará como concluido y no podrá ser editado nuevamente.",
            type: "warning",
            showCancelButton: true,
            /*confirmButtonColor: "#DD6B55",*/
            confirmButtonText: "Confirmar",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            cancelButtonText: "Cancelar"
        },
        function(){

            var obj = {
                id_caso: auxthis.parent().find('#id_caso').val()
            }

            $.ajax({
                url: '../php/cda/cerrar-caso.php',
                type: 'POST',
                data: obj,
                success: function(data){

                    if(data == 'true'){
                        swal({
                            title: "Completado", 
                            text: "El caso se ha cerrado con éxito.", 
                            type: "success"
                        }, function(){
                            $('#floating-refresh').trigger('click');
                        });
                    }else{
                        swal({
                            title: "Error", 
                            text: "No se ha podido cerrar el caso. Contacte con el Administrador", 
                            type: "error"
                        }, function(){
                            $('#floating-refresh').trigger('click');
                        });
                    }

                }
            });

        });

    }

    function generarExcel(){

        window.open('../php/cda/generar-archivo.php', '_blank');

    }

</script>