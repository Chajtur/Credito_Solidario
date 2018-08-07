<?php

/**
 * Ventana para asignar hash a un grupo que no tiene hash
 */

try{
    require "../php/conection.php";
    session_start();
    $stat = $conn->prepare('select id, nombre from gsc where tipoEmpleado = "Gestor" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.') and activo = 1 order by nombre');
    $stat->execute();
    $gestores = $stat->fetchAll();

}catch(PDOException $e){
    //header('Location: index.php');
}

?>
<div class="section">
<div class="row">
    <div class="col s12 m8 l8 offset-m2 offset-l2">
        <form method="post" action="../php/credito/guardar-grupo.php" id="formcreargrupo">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Asignar Hash</span>
                        <div class="section">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <h6>Datos Generales</h6>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <input id="nombre_grupo" name="nombre_grupo" type="text" class="" >
                                    <label for="nombre_grupo">Nombre del Grupo</label>
                                </div>

                                <div class="input-field col s12 m6 l6">

                                    <input id="asesor" name="asesor" type="text" class="" >
                                    <label for="asesor">Asesor Técnico</label>

                                </div>

                            </div>

                            <div class="row">
                                
                                <div class="input-field col s12 m6 l6">

                                    <select name="ciclo" id="ciclo" class=" browser-default" >
                                        <option value="" disabled selected>Ciclo</option>
                                        <option value="1">Ciclo 1</option>
                                        <option value="2">Ciclo 2</option>
                                        <option value="3">Ciclo 3</option>
                                        <option value="11">Readecuación 11</option>
                                        <option value="12">Readecuación 12</option>
                                        <option value="13">Readecuación 13</option>
                                    </select>

                                </div>

                                <div class="input-field col s12 m6 l6">
                                    <label for="fecha" class="active">Fecha de Solicitúd</label>
                                    <input type="date" class="" id="fecha">
                                </div>

                            </div>
                            <br>
                            <div class="row">
                            
                                <div class="col s12 m12 l12">
                                    <h6>Ubicación</h6>
                                </div>

                                <div class="col s12 m12 l12">
                                    <div id="multiselect"></div>
                                </div>

                            </div>
                        </div>                       

                </div>
            </div>
            <div class="card">
                <div class="card-content">

                <span class="card-title">Beneficiarios</span>
                    <div class="section">
                        <div id="divbeneficiarios">
                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="programa" name="beneficiarios[]" type="text" class=" buscardatos" maxlength="13" >
                                    <label for="programa">Identidad</label>
                                </div>
                                <div class="input-field col s4">
                                    <input readonly id="nombre" name="nombre[]" type="text" class="black-text">
                                    <label for="nombre">Nombre</label>
                                </div>
                                <div class="input-field col s4">
                                    <input readonly id="fecha" name="fecha[]" type="text" class="black-text">
                                    <label for="fecha">Fecha</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="programa" name="beneficiarios[]" type="text" class=" buscardatos" maxlength="13" >
                                    <label for="programa">Identidad</label>
                                </div>
                                <div class="input-field col s4">
                                    <input readonly id="nombre" name="nombre[]" type="text" class="black-text">
                                    <label for="nombre">Nombre</label>
                                </div>
                                <div class="input-field col s4">
                                    <input readonly id="fecha" name="fecha[]" type="text" class="black-text">
                                    <label for="fecha">Fecha</label>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <!--<button class="btn waves-effect waves-light col s12 blue lighten-3 z-depth-0"><i class="material-icons">add</i></button>-->
                                <a href="#!" id="btnagregarinput" class="btn-flat white-text waves-effect waves-light green lighten-3 tooltipped" data-position="bottom" data-delay="50" data-tooltip="Agregar mas beneficiarios"><i class="material-icons left">add</i>Agregar Beneficiario</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-large white-text blue waves-effect waves-light" id="btnsave" type="submit">Asignar Hash</button>
        </div>
    </form>
</div>


<!--Aqui van los codigos extras, como Modales, Clon y otros.-->
<!--MODAL PARA HASH DE GRUPO-->
<div id="successhash" class="modal">
    <div class="modal-content">
      <h4 class="red-text" id="codigohash"></h4>
      <p>¡El grupo ha sido creado exitosamente!</p>
      <p><br> Copie el código que aparece en la parte superior y escribalo en el 
          crédito en físico.</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
</div>
<!--MODAL PARA HASH DE GRUPO-->

<!--DIV CLON-->
<div class="row clon" id="clon">
    <div class="input-field col s4">
        <input id="programa" name="beneficiarios[]" type="text" class=" buscardatos" maxlength="13" >
        <label for="programa">Identidad</label>
    </div>
    <div class="input-field col s4">
        <input readonly id="nombre" name="nombre[]" type="text" class="black-text">
        <label for="nombre">Nombre</label>
    </div>
    <div class="input-field col s3">
        <input readonly id="fecha" name="fecha[]" type="text" class="black-text">
        <label for="fecha">Fecha</label>
    </div>
    <div class="input-field col s1">
        <a href="#!" id="delete" class="btn-floating waves-effect waves-light z-depth-0 right red lighten-1 deletebtn tooltipped" data-position="right" data-delay="50" data-tooltip="Eliminar"><i class="material-icons">clear</i></a>                                           
    </div>
</div>
<!--DIV CLON-->

    
</div>

<script type="text/javascript" src="buscardatos.js"></script>
<script src="../js/plugins/select2/select2.min.js"></script>
<script src="../js/plugins/multiselect/multiselect.js"></script>

<script>

    $(document).ready(function(){

        $('#multiselect').multiselect({
            amount: 2,
            labels: ['Departamento', 'Municipio'],
            selectIds: ['departamento', 'municipio'],
            sourceData: ['../php/archivo/departamentos.php', '../php/archivo/municipios.php'],
            select2: true
        });
        
        $('.tooltipped').tooltip();

        $('#breadcrum-title').text('Creación de Grupos');
        
        $('select').material_select();
        
        $('#successhash').modal();
        
        $('#btnagregarinput').click(function(){
                
            let newelem = $('#clon').clone();
            newelem.removeClass('clon');
            newelem.removeAttr('id');
            $('#divbeneficiarios').append(newelem);
            /*Materialize.toast('Agregado', 2000);*/
            // $('.tooltipped').tooltip();

            $('.deletebtn').each(function(){

                $(this).click(function(){

                    // $(this).tooltip('remove');
                    $(this).parent().parent().remove();
                    /*Materialize.toast('Eliminado', 2000);*/

                });

            });
            agregarBuscarDatosListeners();
        });

        agregarBuscarDatosListeners();

        $('#btnsave').click(function(){

            if($('#select-producto').val() != 'P01'){

                $('.buscardatos').removeClass('');
                $('.buscardatos').removeAttr('');
                $('.buscardatos').first().attr('','');
                $('.buscardatos').first().addClass('');
                $('.buscardatos').removeAttr('name');
                $('.namefield').removeAttr('name');
                $('.ciclofield').removeAttr('name');

                $('.buscardatos').each(function(){
                    if($(this).val() != '' && $(this).val() !== 'undefined'){
                        $(this).attr('name','beneficiarios[]');
                    }
                });

                $('.namefield').each(function(){
                    if($(this).val() != '' && $(this).val() !== 'undefined'){
                        $(this).attr('name','nombre[]');
                    }
                });

                $('.ciclofield').each(function(){
                    if($(this).val() != '' && $(this).val() !== 'undefined'){
                        $(this).attr('name','ciclo[]');
                    }
                });

            }
            if($('#select-producto').val() == 'P01'){

                $('.buscardatos').attr('','');
                $('.buscardatos').addClass('');
                $('.buscardatos').attr('name','beneficiarios[]');
                $('.namefield').attr('name','nombre[]');
                $('.ciclofield').attr('name','ciclo[]');

            }

        });

        $('#formcreargrupo').on('submit', function(e){

            e.preventDefault();

            //var thisform = $(this);

            //$('#btnsave').attr('disabled', 'disabled');

            var da = new Date();
            /*var obj = {
                grupo_solidario: $('#nombre_grupo').val().replace('&','and'),
                asesor: $('#asesor').val(),
                ciclo: $('#ciclo').val(),
                fecha: da.getFullYear() + '-' + da.getMonth() + '-' + da.getDate(),
                departamento: $('#departamento').find("option:selected").text(),
                municipio: $('#municipio').find("option:selected").text(),
                beneficiarios: $('input[name="beneficiarios[]"]').map(function(){return $(this).val();}).get()
            }*/

            var obj = {
                grupo_solidario: 'LA BENDICION',
                asesor: 'FRANCISCO',
                ciclo: '1',
                fecha: da.getFullYear() + '-' + da.getMonth() + '-' + da.getDate(),
                departamento: 'depto',
                municipio: 'muni',
                beneficiarios: ['988098897', '19803']
            }

            $.ajax({

                type: 'POST',
                url: '../php/archivo/asignar-hash.php',
                data: obj,
                success: function(data){

                    if(data){
                        var object = JSON.parse(data);
                        console.log(object);
                        if(object.nombre != $('#nombre_grupo').val()){
                            $('#nombre_grupo').val(object.nombre);
                            // swal('Se ha modificado el nombre del grupo','El nombre del grupo está duplicado debido a que el nombre seleccionado generaría un hash existente.','info');
                            swal({
                                title: 'Correcto',
                                text: 'Se ha asignado el hash correctamente',
                                type: 'success',
                                confirmButtonText: 'Entendido',
                                closeOnConfirm: true
                            },function(){
                                $('#floating-refresh').trigger('click');
                            });
                        }
                    }

                }

            });
            
        });
        
    });
    
</script>