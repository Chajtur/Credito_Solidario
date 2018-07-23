<?php
try{
    require "../php/conection.php";
    session_start();
    $stat = $conn->prepare('select id, nombre from gsc where tipoEmpleado = "Gestor" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.') order by nombre');
    $stat->execute();
    $gestores = $stat->fetchAll();
}catch(PDOException $e){
    //header('Location: index.php');
}

?>
<div class="section">
<div class="row">
   <div class="col s12 m8 l8 offset-m2 offset-l2">
       <div class="card">
            <div class="card-content">
                <span class="card-title">Crear Grupo</span>
                <form method="post" action="../php/coordinador-digitador/guardar-grupo.php" id="formcreargrupo">

                    <div class="row">

                        <div class="input-field col s5">

                            <select name="gestor" id="gestor" class="browser-default validate" required>

                                <option value="" disabled selected>Seleccionar Asesor</option>

                                <?php foreach($gestores as $gestor):?>

                                    <option value="<?php echo $gestor['id'];?>"><?php echo $gestor['nombre'];?></option>

                                <?php endforeach;?>

                            </select>

                            <!--<label>Seleccione un Asesor</label>-->

                        </div>

                        <div class="input-field col s5">
                            <input id="nombre_grupo" name="nombre_grupo" type="text" class="validate" required>
                            <label for="nombre_grupo">Nombre del Grupo</label>
                        </div>
                        <div class="input-field col s2">

                            <select name="ciclo" id="ciclo" class="required browser-default" required>
                                <option value="" disabled selected>Ciclo</option>
                                <option value="1">Ciclo 1</option>
                                <option value="2">Ciclo 2</option>
                                <option value="3">Ciclo 3</option>
                            </select>

                        </div>

                    </div>
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
                            <center>
                                <!--<button class="btn waves-effect waves-light col s12 blue lighten-3 z-depth-0"><i class="material-icons">add</i></button>-->
                                <a href="#!" id="btnagregarinput" class="btn waves-effect waves-light col s12 blue lighten-3 z-depth-0 tooltipped" data-position="bottom" data-delay="50" data-tooltip="Agregar mas beneficiarios"><i class="material-icons">add</i></a>
                            </center>
                        </div>
                    </div>

                    <br>

                    <div class="row margin">
                        <div class="input-field col s6 offset-s3">

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

                            <button class="btn waves-effect waves-light col s12" id="btnsave">Guardar</button>
                            <!--<a href="#" data-target="modal1" class="btn waves-effect waves-light col s12">Guardar</a>-->
                        </div>
                    </div>

                </form>
            </div>
        </div>
   </div>
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
        <input readonly id="nombre" name="nombre[]" type="text" class="black-text">
        <label for="nombre">Nombre</label>
    </div>
    <div class="input-field col s2">
        <input autocomplete="off" disabled name="ciclo[]" type="text" class="black-text" id="ciclo-sugerido">
        <label for="ciclo-sugerido">Próximo Ciclo</label>
    </div>
    <div class="input-field col s1">
        <a href="#!" id="delete" class="btn-floating waves-effect waves-light z-depth-0 right red lighten-1 deletebtn tooltipped" data-position="right" data-delay="50" data-tooltip="Eliminar"><i class="material-icons">clear</i></a>                                           
    </div>
</div>
<!--DIV CLON-->

    
</div>
    
<script type="text/javascript" src="../credito/buscarcenso.js"></script>                
<script>

    $(document).ready(function(){
        
        $('#breadcrum-parent').text('Créditos');
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
            $('.tooltipped').tooltip();

            $('.deletebtn').each(function(){

                $(this).click(function(){

                    $(this).tooltip('remove');
                    $(this).parent().parent().remove();
                    /*Materialize.toast('Eliminado', 2000);*/

                });

            });
            agregarBuscarCensoListeners();
        });

        agregarBuscarCensoListeners();

        $('#formcreargrupo').on('submit', function(e){

            e.preventDefault();
            var ciclosiguales = true;
            var todosDiferentes = true;
            var vals = [];
            
            //Verificar si los ciclos sugeridos son iguales
            
            $('.invalid').each(function(){
                $(this).removeClass('invalid');
            });
            
            $('.buscarciclo').each(function(){
                
                var tempcurrent = $(this).val();
                $('.buscarciclo').each(function(){
                    if(tempcurrent != $(this).val()){
                        ciclosiguales = false;
                        return ciclosiguales;
                    }
                });
                
            });
            
            if(ciclosiguales){
                
                if($('#ciclo-sugerido').val() == $('#ciclo').val()){ // Si el ciclo sugerido concuerda con el ciclo elegido pasa, sino no
                    
                    $('.buscarcenso').each(function(){
                        vals.push($(this).val());
                    });

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
                    
                    if(todosDiferentes){
                        
                        $('#saveloader').toggle();
                        $('#btnsave').toggle();
                        Materialize.toast('Guardando', 2000);
                        
                        $(this).ajaxSubmit({
                            type: 'POST',
                            url: '../php/coordinador-digitador/guardar-grupo.php',
                            success: function(data){

                                if(data != "error"){
                                    
                                    console.log(data);
                                    
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

                                }else{

                                    $('#saveloader').toggle();
                                    $('#btnsave').toggle();
                                    Materialize.toast('No se ha podido guardar el grupo, intentelo más tarde o contacte al administrador.', 3000);

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
            
        });
        
    });
    
</script>