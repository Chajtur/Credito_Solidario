<?php
try{
    require "../php/conection.php";
    session_start();
    $stat = $conn->prepare('select id, nombre from gsc where tipoEmpleado = "Gestor" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.') and activo = 1 order by nombre');
    $stat->execute();
    $gestores = $stat->fetchAll();

    $stat_productos = $conn->prepare('call poblar_productos();');
    $stat_productos->execute();
    $productos = $stat_productos->fetchAll(PDO::FETCH_ASSOC);

}catch(PDOException $e){
    //header('Location: index.php');
}

?>
<div class="section">
<div class="row">
    <div class="col s12 m8 l8 offset-m2 offset-l2">
        <form method="post" action="../php/coordinador-digitador/guardar-grupo.php" id="formcreargrupo">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Crear Grupo</span>
                        <div class="section">
                            <div class="row">

                                <div class="input-field col s12 m6 l6">

                                    <select id="select-producto" name="select-producto" class="">
                                        
                                        <!--<option value="" disabled selected>Elija uno</option>-->
                                        
                                        <?php foreach($productos as $fila):?>
                                        
                                            <option value="<?php echo substr($fila['id'], 0, 12);?>"><?php echo $fila['nombre'];?></option>
                                        
                                        <?php endforeach;?>

                                    </select>
                                    <label>Producto</label>

                                </div>

                                <div class="input-field col s12 m6 l6">

                                    <select name="gestor" id="gestor" class="browser-default validate" required>

                                        <option value="" disabled selected>Seleccionar Asesor</option>

                                        <?php foreach($gestores as $gestor):?>

                                            <option value="<?php echo $gestor['id'];?>"><?php echo $gestor['nombre'];?></option>

                                        <?php endforeach;?>

                                    </select>

                                    <!--<label>Seleccione un Asesor</label>-->

                                </div>

                            </div>

                            <div class="row">

                                <div class="input-field col s12 m6 l6">
                                    <input id="nombre_grupo" name="nombre_grupo" type="text" class="validate" required>
                                    <label for="nombre_grupo">Nombre del Grupo</label>
                                </div>
                                <div class="input-field col s12 m6 l6">

                                    <select name="ciclo" id="ciclo" class="required browser-default" required>
                                        <option value="" disabled selected>Ciclo</option>
                                        <option value="1">Ciclo 1</option>
                                        <option value="2">Ciclo 2</option>
                                        <option value="3">Ciclo 3</option>
                                        <option value="11">Readecuación 11</option>
                                        <option value="12">Readecuación 12</option>
                                        <option value="13">Readecuación 13</option>
                                    </select>

                                </div>

                            </div>
                        </div>

                        <br>
                        <div class="divider"></div>
                        <br>

                        <div class="section">
                            <span class="card-title">Beneficiarios</span>
                            <div id="divbeneficiarios">

                                <div class="row">
                                    <div class="input-field col s4">
                                        <input id="programa" name="beneficiarios[]" type="text" class="validate buscarcenso" maxlength="13" required>
                                        <label for="programa">Identidad</label>
                                    </div>
                                    <div class="input-field col s5">
                                        <input readonly id="nombre" name="nombre[]" type="text" class="black-text">
                                        <label for="nombre">Nombre</label>
                                    </div>
                                    <div class="input-field col s3">
                                        <input autocomplete="off" disabled name="ciclo[]" type="text" class="buscarciclo black-text" id="ciclo-sugerido">
                                        <label for="ciclo-sugerido">Próximo Ciclo</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s4">
                                        <input id="programa" name="beneficiarios[]" type="text" class="validate buscarcenso" maxlength="13" required>
                                        <label for="programa">Identidad</label>
                                    </div>
                                    <div class="input-field col s5">
                                        <input readonly id="nombre" name="nombre[]" type="text" class="black-text">
                                        <label for="nombre">Nombre</label>
                                    </div>
                                    <div class="input-field col s3">
                                        <input autocomplete="off" disabled name="ciclo[]" type="text" class="buscarciclo black-text" id="ciclo-sugerido">
                                        <label for="ciclo-sugerido">Próximo Ciclo</label>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                        <!--<button class="btn waves-effect waves-light col s12 blue lighten-3 z-depth-0"><i class="material-icons">add</i></button>-->
                                        <a href="#!" id="btnagregarinput" class="btn-flat white-text waves-effect waves-light green lighten-3 tooltipped" data-position="bottom" data-delay="50" data-tooltip="Agregar mas beneficiarios">Agregar</a>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="divider"></div>
                        <br>

                        <div class="section">
                            <div id="divObservaciones">
                                <span class="card-title">Observaciones</span>
                                <div id="dynamicRows">
                                    <div class="row" id="example">
                                        <div class="input-field col s5">
                                            <input disabled value="Corrección Créditos" id="razonObservacion" type="text" class="validate">
                                            <label for="razonObservacion" class="active">Razón</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input value="" id="observacion" type="text" name="observaciones[]" class="validate" placeholder="Ingrese una observación" required>
                                            <label for="observacion" class="active">Observación</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <a href="#!" id="delete" class="btn-floating waves-effect waves-light z-depth-0 right red lighten-1 tooltipped" data-position="right" data-delay="50" data-tooltip="Eliminar"><i class="material-icons">clear</i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="card-action">

                    <center>
                        <div class="preloader-wrapper small active" id="saveloader" style="display:none">
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
                    </center>
                    <button class="btn-flat white-text blue waves-effect waves-light" id="btnsave" type="submit">Guardar</button>
                    <!--<a href="#" data-target="modal1" class="btn waves-effect waves-light col s12">Guardar</a>-->
                </div>
            </div>
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
        <input id="programa" name="beneficiarios[]" type="text" class="validate buscarcenso" maxlength="13" required>
        <label for="programa">Identidad</label>
    </div>
    <div class="input-field col s5">
        <input readonly id="nombre" name="nombre[]" type="text" class="black-text namefield">
        <label for="nombre">Nombre</label>
    </div>
    <div class="input-field col s2">
        <input autocomplete="off" disabled name="ciclo[]" type="text" class="black-text ciclofield" id="ciclo-sugerido">
        <label for="ciclo-sugerido">Próximo Ciclo</label>
    </div>
    <div class="input-field col s1">
        <a href="#!" id="delete" class="btn-floating waves-effect waves-light z-depth-0 right red lighten-1 deletebtn tooltipped" data-position="right" data-delay="50" data-tooltip="Eliminar"><i class="material-icons">clear</i></a>                                           
    </div>
</div>
<!--DIV CLON-->

    
</div>
    
<script type="text/javascript" src="buscarcenso.js"></script>             
<script>

document.getElementById('formcreargrupo').addEventListener('keypress', function(event) {
    if (event.keyCode == 13) {
        event.preventDefault();
    }
});

(function($){

    var DynamicRows = function(elem, options){

        this.options = options;
        this.container = $(elem);
        this.example = $(elem).find('#example');
        this.example.removeAttr('id').addClass('rowInDynamicRows');
        this.init();

    }

    DynamicRows.prototype = {

        init: function(){
            this.container.empty().append(this.emptyMessage());
            this.renderAddBtn();
        },
        emptyMessage: function(){
            let row = $('<div class="row"></div>');
            let col = $('<div class="col s12 m12 l12 valign-wrapper center-align"></div>');
            col.append(this.options.emptyMessage);
            return row.append(col);
        },
        renderAddBtn: function(){
            var self = this;
            let row = $('<div class="row"></div>');
            let col = $('<div class="col s12 m12 l12"></div>');
            let inputField = $('<div class="input-field"></div>');
            let button = $('<a href="#!" id="" class="btn-flat white-text waves-effect waves-light green lighten-3">Agregar</a>');
            button.click(function(){
                self.addRow();
            });
            row.append(col.append(inputField.append(button)));
            this.container.after(row);
        },
        addRow: function(){
            var self = this;
            var newrow = self.example.clone();
            newrow.find('#delete').click(function(){
                var index = self.container.find('.rowInDynamicRows').index(newrow);
                self.removeRow(index);
            });
            if(self.container.find('.rowInDynamicRows').length == 0){
                self.container.empty();
            }
            self.container.append(newrow);
        },
        removeRow: function(id){
            this.container.find('.rowInDynamicRows').eq(id).remove();
            if(this.container.find('.rowInDynamicRows').length == 0){
                this.container.empty().append(this.emptyMessage());
            }
        }

    }

    DynamicRows.prototype.reset = function(){
        this.container.empty().append(this.emptyMessage());
    }

    $.fn.dynamicRows = function(options){

        var settings = $.extend({
            emptyMessage: 'Vacío'
        }, options);

        var dynamicrows = new DynamicRows(this, settings);
        return dynamicrows;

    }
    
}(jQuery));

    $(document).ready(function(){
        
        $('.tooltipped').tooltip();

        $('#breadcrum-title').text('Creación de Grupos');
        
        $('select').material_select();
        
        $('#gestor').select2();
        
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
            agregarBuscarCensoListeners();
        });

        agregarBuscarCensoListeners();

        $('#btnsave').click(function(){

            if($('#select-producto').val() != 'P01'){

                $('.buscarcenso').removeClass('validate');
                $('.buscarcenso').removeAttr('required');
                $('.buscarcenso').first().attr('required','');
                $('.buscarcenso').first().addClass('validate');
                $('.buscarcenso').removeAttr('name');
                $('.namefield').removeAttr('name');
                $('.ciclofield').removeAttr('name');

                $('.buscarcenso').each(function(){
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

                $('.buscarcenso').attr('required','');
                $('.buscarcenso').addClass('validate');
                $('.buscarcenso').attr('name','beneficiarios[]');
                $('.namefield').attr('name','nombre[]');
                $('.ciclofield').attr('name','ciclo[]');

            }

        });

        $('#formcreargrupo').on('submit', function(e){

            e.preventDefault();

            var thisform = $(this);

            var obj = {
                nombre: $('#nombre_grupo').val().replace('&','and'),
                gestor: $('#gestor').val()
            }

            console.log(obj);

            $.ajax({

                type: 'POST',
                url: '../php/credito/verificar-nombre.php',
                data: 'data='+JSON.stringify(obj),
                success: function(data){

                    var object = JSON.parse(data);
                    console.log(object);
                    if(object.nombre != $('#nombre_grupo').val()){
                        $('#nombre_grupo').val(object.nombre);
                        // swal('Se ha modificado el nombre del grupo','El nombre del grupo está duplicado debido a que el nombre seleccionado generaría un hash existente.','info');
                        swal({
                            title: 'Se ha modificado el nombre del grupo',
                            text: 'El nombre del grupo ha sido reemplazado por '+object.nombre+' debido a que yá existe un grupo hoy ingresado con el nombre expresado.',
                            type: 'info',
                            confirmButtonText: 'Entendido',
                            closeOnConfirm: true
                        },
                        function(){
                            guardarGrupo(thisform);
                        });
                    }else{
                        guardarGrupo(thisform);
                    }

                }

            });

            $('#formcreargrupo').off('submit');
            
        });

        window.dynamicrows = $('#dynamicRows').dynamicRows({
            emptyMessage: '<i class="material-icons blue-text text-lighten-2">info</i> Sin observaciones.'
        });
        
    });

    function guardarGrupo(form){

        var ciclosiguales = true;
        var todosDiferentes = true;
        var vals = [];
        
        //Verificar si los ciclos sugeridos son iguales
        
        $('.invalid').each(function(){
            $(this).removeClass('invalid');
        });
        
        if($('#select-producto').val() == 'P01'){

            $('.buscarciclo').each(function(){
            
                var tempcurrent = $(this).val();
                $('.buscarciclo').each(function(){
                    if(tempcurrent != $(this).val()){
                        ciclosiguales = false;
                        return ciclosiguales;
                    }
                });
                
            });

        }
        
        if(ciclosiguales){
            
            if($('#ciclo-sugerido').val() == $('#ciclo').val()){ // Si el ciclo sugerido concuerda con el ciclo elegido pasa, sino no
                
                $('.buscarcenso').each(function(){
                    vals.push($(this).val());
                });

                if($('#select-producto').val() == 'P01'){

                    for(i = 0; i <= vals.length; i++){
                        for(j = 0; j <= vals.length; j++){
                            if(j != vals.length){
                                if(i == j) j++;
                                if(vals[i] == vals[j]){
                                    todosDiferentes = false; 
                                    $('.buscarcenso').eq(i).addClass('invalid');
                                }
                            }
                        }
                    }

                }
                
                if(todosDiferentes){
                    
                    $('#saveloader').toggle();
                    $('#btnsave').toggle();
                    Materialize.toast('Guardando', 2000);
                    
                    form.ajaxSubmit({
                        type: 'POST',
                        url: '../php/coordinador-digitador/guardar-grupo.php',
                        success: function(data){

                            if(data != "error"){
                                
                                // console.log(data);
                                if(data == "error transaccional"){
                                    swal();
                                    return false;
                                }

                                swal({
                                    title: '<h2 class="red-text"><small class="black-text">Código Hash:</small> '+data+'</h2>',
                                    text: '<h5>¡El grupo se ha creado exitosamente!</h5> <br> Copie el código que aparece en la parte superior y escribalo en el crédito en físico',
                                    html: true,
                                    type: 'success'
                                });
                                
                                /*$('#successhash').modal('open');
                                $('#codigohash').html('#'+data);*/
                                document.getElementById('formcreargrupo').reset();
                                $('#saveloader').toggle();
                                $('#btnsave').toggle();
                                $("#gestor").select2("val", "");
                                $('#gestor').select2();
                                $('#formcreargrupo').find('.clon').remove();
                                window.dynamicrows.reset();

                            }else{

                                $('#saveloader').toggle();
                                $('#btnsave').toggle();
                                Materialize.toast('No se ha podido guardar el grupo, intentelo más tarde o contacte al administrador.', 3000);
                                console.log(data);
                                
                            }
                            
                        }
                        
                    });
                    
                }else{
                    
                    Materialize.toast('Esta ingresando dos o más veces un mismo beneficiario.', 3000);
                    
                }
                
            }else{
                
                $('#ciclo').addClass('invalid');
                Materialize.toast('El ciclo que ha seleccionado no concuerda con el ciclo sugerido.', 3000);
                
            }
            
        }else{
             
            Materialize.toast('Por favor verifique que todos los beneficiarios apliquen al mismo ciclo.', 3000);
            
        }
    }
    
</script>