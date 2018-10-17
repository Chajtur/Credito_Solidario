<?php

/**
 * Archivo para digitar la linea base de un grupo
 */

?>
<style>
.complete {
    color: #4CAF50 !important;
    background-color: #E8F5E9 !important;
}
</style>

<!-- Plugins requeridos para tablesearch -->
<script src="..\js\plugins\paginathing-master\paginathing.js"></script>
<script src="..\js\plugins\tinysort\tinysort.min.js"></script>

<!-- Plugin tablesearch -->
<link rel="stylesheet" href="../js/plugins/tablesearch2/tablesearch2.css">
<script src="../js/plugins/tablesearch2/tablesearch2.js"></script>

<div class="section">
    <div class="row">
        <div class="col s12 l4">
            <ul class="collection with-header" id="tablesearch2">
            </ul>
        </div>
        <div class="col s12 m6 l8">
            <div class="card" id="card-input">
                <div class="card-content">
                    <form id="example-advanced-form" action="#">
                        <div>
                            <h3>Línea Base</h3>
                            <section>
                                <div class="wizard-content">
                                    <fieldset>
                                        <legend>Vivienda</legend>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6 grey-text">
                                                <label for="input-tiempoResideVivienda" class="active">Tiempo de residir en la vivienda</label>
                                                <input placeholder="Tiempo" id="input-tiempoResideVivienda" type="number" min="0" max="99" name="tiempoResideVivienda" class="input-element validate" required>
                                                <input type="hidden" name="" id="input-hash" class="input-element">
                                                <input type="hidden" name="" id="input-identidad" class="input-element">
                                                <input type="hidden" name="" id="input-ciclo" class="input-element">
                                                <input type="hidden" name="" id="input-familiar" class="input-element">
                                                <input type="hidden" name="" id="input-enfermedad" class="input-element">
                                            </div>
                                            <div class="input-field col s12 m12 l6 grey-text">
                                            <select class="grey-text input-element" id="input-unidadVivienda">
                                                    <option value="años" selected>Años</option>
                                                    <option value="meses">Meses</option>
                                                </select>                                            
                                            </div>
                                            <div class="input-field col s12 m12 l6 grey-text">
                                                <label for="input-materialVivienda" class="active">Material que predomina en la vivienda</label>
                                                <select class="grey-text input-element" id="input-materialVivienda">
                                                    <option value="" disabled selected>Material</option>
                                                    <option value="ladrillo">Ladrillo</option>
                                                    <option value="bloque">Bloque</option>
                                                    <option value="adobe">Adobe</option>
                                                    <option value="madera">Madera</option>
                                                    <option value="otros">Otros</option>
                                                </select>                                            
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l12 grey-text">
                                                <select multiple class="grey-text input-element" id="input-serviciosPublicos">
                                                  <option value="" disabled selected>Servicios</option>
                                                  <option value="1">Energía eléctrica</option>
                                                  <option value="2">Aguas negras</option>
                                                  <option value="3">Agua potable</option>
                                                  <option value="4">Pozo Séptico/Letrina/Otro</option>
                                                  <option value="5">Telefono fijo</option>
                                                </select>
                                                <label>Marque los servicios públicos que tiene</label>        
                                            </div>                                
                                        </div>
                                    </fieldset>
                                    <br>
                                    <fieldset>
                                        <legend>Familiares</legend>
                                        <div class="row">
                                            <br>
                                            <div class="input-field col s12 m12 l6 grey-text">
                                                <input placeholder="0" id="input-personasHabitan" type="number" min="0" max="30" name="personasHabitan" class="input-element">
                                                <label for="input-personasHabitan" class="active">¿Cuántas personas habitan en la vivienda?</label>
                                            </div>
                                            <div class="input-field col s12 m12 l6 grey-text">
                                                <input placeholder="0" id="input-familiasViven" type="number" min="0" max="20" name="familiasViven" class="input-element">
                                                <label for="input-familiasViven" class="active">¿Cuántas familias viven?</label>
                                            </div>   
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6 grey-text">
                                                <input placeholder="0" id="input-cuantasTrabajan" type="number" min="0" max="30" name="cuantasTrabajan" class="input-element">
                                                <label for="input-cuantasTrabajan" class="active">¿Cuántas trabajan?</label>
                                            </div>
                                            <div class="input-field col s12 m12 l6 grey-text">
                                                <input placeholder="0" id="input-buscanEmpleo" type="number" min="0" max="30" name="buscanEmpleo" class="input-element">
                                                <label for="input-buscanEmpleo" class="active">¿Cuántas buscan empleo?</label>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <br>
                                    <fieldset>
                                        <legend>Negocio</legend>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6 grey-text">
                                                <input type="checkbox" class="filled-in input-element" id="input-tieneMicroempresa" value="0" />
                                                <label for="input-tieneMicroempresa">¿Tiene Microempresa?</label>
                                                <input type="checkbox" class="filled-in input-element" id="input-emprenderMicroempresa" value="0" />
                                                <label for="input-emprenderMicroempresa">¿Va emprender una microempresa?</label>
                                            </div>                                        
                                            <div class="input-field col s12 m12 l6 grey-text">
                                                <input placeholder="0" id="input-empleosGenerara" type="number" min="0" max="99" name="empleosGenerara" class="input-element">
                                                <label for="input-empleosGenerara" class="active">¿Cuántas empleos generará?</label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </section>

                            <h3>Educación</h3>
                            <section>
                                <div class="wizard-content">
                                    <div class="row no-margin">
                                        <!-- <div class="col l6 m6 s6"><h5 class="light">Familiares</h5></div> -->
                                        <div class="col l6 m6 s6 offset-l6">
                                            <a class="waves-effect waves-light btn right" id="btn-add-familiar"><i class="material-icons">add</i></a>
                                        </div>
                                    </div>
                                    <!--<input class="btn right" type="button" id="more_fields" onclick="add_fields();" value="Add More" /><br><br>-->
                                    <div id="edu2">
                                        <div class="row" id="list-familiar-container">
                                            <fieldset class="fieldset-familiar">
                                                <legend class="grey-text">Familiar</legend>
                                                <div class="col s12 m12 l3">
                                                    <label>Nombre</label>
                                                    <input id="Nombre" type="text" name="Nombre" class="required input-element">
                                                    <!--<label for="eNombre" id="eNombre-error" class="error"></label>-->
                                                </div>

                                                <div class="col s12 m12 l1">
                                                    <label>Edad</label>
                                                    <input id="Edad" type="number" min="0" max="99" name="Edad" class="required input-element">
                                                    <!--<label for="fEdad" id="fEdad-error" class="error"></label>-->
                                                </div>

                                                <div class="col s12 m12 l3">
                                                    <label> Educación</label>
                                                    <select required id="Educacion" name="Educacion" class="grey-text browser-default input-element">
                                                        <option value="" disabled selected class="truncate"> </option>
                                                        <option value="Primaria">Primaria</option>
                                                        <option value="Secundaria">Secundaria</option>
                                                        <option value="Superior">Superior</option>
                                                        <option value="Ninguno">Ninguno</option>
                                                    </select>
                                                    <!--<label for="eEducacion" id="eEducacion-error" class="error"></label>-->
                                                </div>

                                                <div class="col s12 m12 l2">
                                                    <label>Oficio</label>
                                                    <input id="Oficio" type="text" name="Oficio" class="required input-element" data-error="errorTxt2">
                                                    <!--<div class="errorTxt2"></div>-->
                                                </div>

                                                <div class="col s12 m12 l2">
                                                    <label> Género</label>
                                                    <select required id="Genero" name="Genero" class="grey-text browser-default input-element">
                                                        <option value="" disabled selected class="truncate"> </option>
                                                        <option value="M">M</option>
                                                        <option value="F">F</option>
                                                    </select>
                                                </div>                                                
                                            </fieldset>
                                        </div>
                                        <div class="row" id="list-familiar-clon">
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <h3>Enfermedades</h3>
                            <section>
                                <div class="wizard-content">
                                    <div class="row no-margin">
                                        <!-- <div class="col l6 m6 s6"><h5 class="light">Familiares</h5></div> -->
                                        <div class="col l6 m6 s6 offset-l6">
                                            <a class="waves-effect waves-light btn right" id="btn-add-enfermedades"><i class="material-icons">add</i></a>
                                        </div>
                                    </div><br>                         
                                    <!-- <fieldset> -->
                                        <div class="row" id="list-enfermedades-container">
                                            <div class="fieldset-enfermedades">
                                                <div class="input-field col s12 m12 l6 grey-text">
                                                    <select class="grey-text input-element browser-default" id="enfermedad" name="Enfermedad">
                                                      <option value="Ninguna" selected>Ninguna</option>
                                                      <option value="Diarrea">Diarrea</option>
                                                      <option value="Infecciones">Infecciones</option>
                                                      <option value="Parásitos">Parásitos</option>
                                                      <option value="Resfriados">Resfriados</option>
                                                      <option value="De la piel">De la piel</option>
                                                      <option value="De los ojos">De los ojos</option>
                                                      <option value="Dengue">Dengue</option>
                                                      <option value="Anemia">Anemia</option>
                                                      <option value="Chikungunya">Chikungunya</option>
                                                      <option value="Otra">Otra</option>
                                                    </select>
                                                    <!-- <label>Enfermedades</label>         -->
                                                </div>
                                                <div class="input-field col s12 m12 l5 grey-text">
                                                    <select class="grey-text input-element input-tratamiento browser-default" id="tratamiento" name="Tratamiento">
                                                      <option value="0" disabled selected>Tratamiento</option>
                                                      <option value="Casero">Casero</option>
                                                      <option value="posta médica">Posta médica</option>
                                                      <option value="Hospital">Hospital</option>
                                                      <option value="Médico particular">Médico particiular</option>
                                                    </select>
                                                    <!-- <label>Tratamiento</label>         -->
                                                </div>   
                                            </div>                                         
                                            <div class="row" id="list-enfermedades-clon">
                                            </div>
                                        </div>
                                    <!-- </fieldset> -->
                                </div>
                            </section>

                            <h3>Revisión</h3>
                            <section>
                                <div class="wizard-content">
                                    <!-- <fieldset> -->
                                        <div class="row">
                                            <div class="input-field col s12 m12 l12 grey-text">
                                                <input type="checkbox" class="filled-in input-element" id="input-infoCorrecta"/>
                                                <label for="input-infoCorrecta">¿La información es correcta?</label>
                                            </div> 
                                        </div>
                                    <!-- </fieldset> -->
                                </div>
                            </section>                                                        
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        
        <div id="prev-instruct" class="col s12 m4 l4 offset-l2 offset-m2">
            <div class="card center z-depth-0">
                <div class="card-content">
                    <i class="material-icons large green-text" id="icon">import_contacts</i>
                    <h5 class="medium" id="text-message">Seleccione un grupo para digitar</h5>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Modal Structure -->
<!--     <div id="modal-digitacion" class="modal modal-fixed-footer">
        <div class="modal-content modal-content-editar-grupo">
            <h5>Selección de Monto y Frecuencia de pago</h5>
            <div class="row margin">
                <ul class="collection">
                    <li class="collection-item row">
                        <div class="col s12 l3">Nombre</div>
                        <div class="col s12 l3">Monto</div>
                        <div class="col s12 l3">Frecuencia Pago</div>
                        <div class="col s12 l3">Valor de Ahorro</div>
                    </li>
                    <div id="desembolso-data-beneficiarios">
                    </div>
                </ul>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="input-field col s12 l6">
                        <select id="select-plazo-modal">
                            <option value="" disabled selected>Elige el Plazo</option>
                            <option value="6 MESES">6 Meses</option>
                            <option value="12 MESES">12 Meses</option>
                        </select>
                        <label>Plazo</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action waves-effect waves-green btn-flat" id="modal-guardar">Guardar</a>
        </div>
    </div> -->
</div>

<div class="clon fieldset-enfermedades" id="enfermedades-clon">
    <div>
        <div class="input-field col s12 m12 l6 grey-text">
            <select class="grey-text browser-default input-element" id="enfermedad" name="Enfermedad">
                <option value="Ninguna" selected>Ninguna</option>
                <option value="Diarrea">Diarrea</option>
                <option value="Infecciones">Infecciones</option>
                <option value="Parásitos">Parásitos</option>
                <option value="Resfriados">Resfriados</option>
                <option value="De la piel">De la piel</option>
                <option value="De los ojos">De los ojos</option>
                <option value="Dengue">Dengue</option>
                <option value="Anemia">Anemia</option>
                <option value="Chikungunya">Chikungunya</option>
                <option value="Otra">Otra</option>
            </select>
        </div>
        <div class="input-field col s12 m12 l5 grey-text">
            <select class="grey-text input-element input-tratamiento browser-default" id="tratamiento" name="Tratamiento">
              <option value="0" disabled selected>Tratamiento</option>
              <option value="Casero">Casero</option>
              <option value="Posta Médica">Posta médica</option>
              <option value="Hospital">Hospital</option>
              <option value="Médico particular">Médico particiular</option>
            </select>
        </div>   
        <div class="col s12 m12 l1">
            <a class="waves-effect waves-light btn-flat-tiny right delete-clon" id="btn-remove-familiar" style="margin-top: 15px"><i class="small material-icons">delete</i></a>
        </div>    
    </div>  
</div> 

<fieldset class="clon fieldset-familiar" id="familiar-clon">
    <div>
        <legend class="grey-text">Familiar</legend>
        <div class="col s12 m12 l3">
            <label>Nombre</label>
            <input id="Nombre" type="text" name="Nombre" class="required input-element">
        </div>

        <div class="col s6 m12 l1">
            <label>Edad</label>
            <input id="Edad" type="number" min="0" max="99" name="Edad" class="required input-element">
        </div>

        <div class="col s12 m12 l3">
            <label>Educación</label>
            <select required id="Educacion" name="Educacion" class="grey-text browser-default input-element">
                <option value="" disabled selected class="truncate"> </option>
                <option value="Primaria">Primaria</option>
                <option value="Secundaria">Secundaria</option>
                <option value="Superior">Superior</option>
                <option value="Ninguno">Ninguno</option>
            </select>
        </div>

        <div class="col s12 m12 l2">
            <label>Oficio</label>
            <input id="Oficio" type="text" name="Oficio" class="required input-element" data-error="errorTxt2">
        </div>

        <div class="col s12 m12 l2">
            <label>Género</label>
            <select required id="Genero" name="Genero" class="grey-text browser-default input-element">
                <option value="" disabled selected class="truncate"> </option>
                <option value="M">M</option>
                <option value="F">F</option>
            </select>
        </div>
        <div class="col s12 m12 l1">
            <a class="waves-effect waves-light btn-flat-tiny right delete-clon" id="btn-remove-familiar" style="margin-top: 15px"><i class="small material-icons">delete</i></a>
        </div>      
    </div>  
</fieldset>

<!--plugin to STEPS-->
<!--<script src="../js/steps/jquery.validate.js" type="text/javascript"></script>-->
<script src="../js/steps/jquery.steps.js" type="text/javascript"></script>
<script src="../js/steps/wizard.js" type="text/javascript"></script>

<script src="../js/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
<script src="../js/plugins/jquery-inputmask/form-input-mask.js"></script>
<script src="../js/plugins/dependency-select/dependency.select.js"></script>


<script>
    
    $(document).ready(function(){
        
        <?php
        
        //session_start();
        
        ?>

        window.table = $('#tablesearch2').tablesearch2({
            title: 'Buscar grupos',
            reloadButtonCallback: function(){
                Materialize.toast('Recargando', 2000);
            },
            searchable: true,
            sortable: true,
            onSearch: function(){
                window.grupos = [];
                $('.btn-elegir-grupo').off('click').on('click', function(){
                    $('#prev-instruct').find('#icon').html('description');
                    $('#prev-instruct').find('#text-message').html('Seleccione un crédito para digitar');
                });
            },
            initialMessage: '<i class="material-icons amber-text">info</i> Realice una búsqueda.',
            // initialRequest: '',
            reloadButtonText: '<i class="material-icons">cached</i>',
            headers: ['Hash', 'Grupo Solidario', 'Gestor', 'Ciclo', 'Agencia'],
            dataSource: '../php/common/obtener-grupos.php?lineabase&search',
            pagination: true,
            onSelect: function(e, checkbox, li){
                if($(checkbox)[0].checked){
                    window.grupos.push($(li).find('#hash').text());
                    // Materialize.toast('Checked', 2000);
                }else{
                    let ind = window.grupos.indexOf($(li).find('#hash').text());
                    window.grupos.splice(ind, 1);
                    // Materialize.toast('Unchecked', 2000);
                }
            },
            maxColumns: 2,
            subData: {
                column: 'beneficiarios',
                title: 'Beneficiarios',
                showReveal: false,
                cardRevealTitleColumnName: 'nombre',
                columnNames: ["id","identidad","nombre","Fecha Solicitud","Lugar Nacimiento","Estado Civil","Telefono","Telefono2","Tipo de Vivienda","Direccion Domicilio","Alquila Casa","Nombre Propietario","Telefono Propietario","Sector Económico","Actividad Economica","Tipo Cliente","Direccion Negocio","Direccion Ref1","Direccion Ref2","Direccion Ref3","Direccion Ref4","Nombre Ref1","Nombre Ref2","Nombre Ref3","Nombre Ref4","Parentesco Ref1","Parentesco Ref2","Parentesco Ref3","Parentesco Ref4","Telefono Ref1","Telefono Ref2","Telefono Ref3","Telefono Ref4","Digitado","Estatus Archivo"],
                onClick: function(e, btn, values, li){
                    // Ocultamos la ventana de notificacion
                    $('#prev-instruct').fadeOut(200, function(){                
                        // Mostramos el formulario de digitacion
                        $('#card-input').fadeIn(300);
                    });

                    //Desactivamos los demas beneficiaros del grupo que no fueron clickeados
                    window.licurrent = li;
                    window.currentButton = btn;
                    $(window.licurrent).find(".subdatabutton:not(.complete)").not(btn).attr('disabled','disabled');

                    // Apagamos los collapsible, para evitar que el digitador cambie de grupo sin terminar la digitacion del actual 
                    toggleCollapsible('off');
                    $('#dependency-select').dependency_select();
                    
                    window.grupo_digitar = {
                        buscanEmpleo: undefined,
                        ciclo: values.ciclo,
                        cuantasTrabajan: undefined,
                        empleosGenerara: undefined,
                        emprenderMicroempresa: undefined,
                        enfermedad: undefined,
                        estatus_archivo: values.estatus_archivo,
                        familiar: undefined,
                        familiasViven: undefined,
                        identidad: values.identidad,
                        hash: values.grupo_solidario_hash,
                        id: values.id,
                        infoCorrecta: undefined,
                        materialVivienda: undefined,
                        personasHabitan: undefined,
                        serviciosPublicos: undefined,
                        tiempoResideVivienda: undefined,
                        tieneMicroempresa: undefined,
                        idusuario: undefined
                    }
                    window.table.togglePaginator('disable');
                }
            },
            columnClass: ['col s4 m4 l4','col s8 m8 l8'],
            collapsibleHeaderClass: 'btn-elegir-grupo',
            collapsibleColumnClasses: ['s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12','s12 m12 l12'],
            eachCcollapseTitle: 'Detalles del grupo',
            noResultsFoundMessage: 'Ningún registro con ese código de faja.',
            columnNames: ['Hash', 'Grupo Solidario', 'Gestor', 'Ciclo', 'Agencia'],
            paginationObject: {
                perPage: 5,
                limitPagination: 2,
                containerClass: 'collection-item elem with-pagination',
                ulClass: 'pagination',
                prevText: '<i class="material-icons md-18">chevron_left</i>', 
                nextText: '<i class="material-icons md-18">chevron_right</i>',
                firstText: '<i class="material-icons md-18">first_page</i>',
                lastText: '<i class="material-icons md-18">last_page</i>',
                pageNumbers: true
            }
        });

        $('.grupo-digitado').each(function(){
            $(this).find('#btn-guardar-grupo').removeClass('green').addClass('grey');
            $(this).click(function(e){
                e.preventDefault();
            });
        });

        window.currentGroup = null;
        window.currentCredito = null;
        
        // Inicializamos los steps del form
        var form = $("#example-advanced-form").show();

        initSteps(form);
        
        $('#card-input').hide();
        
        $('.modal').modal();
        
        $('.collapsible').collapsible();
        
        $('#breadcrum-title').text('Digitación de Créditos');

        $('.beneficiario-en-grupo').each(function(){

            $(this).find('#nombre_completo').click(function(){

                if($(this).parent().parent().find('#estatus_archivo').val() == "3"){
                    return false;
                }

                // Obtenemos el padre del nombre completo
                var mainparent = $(this).parent().parent();
                
                // Obtenemos el objeto de datos que está en el objeto global de grupos digitados
                var dataObject = window.grupo_digitar[mainparent.find('#idcredito').val()];   

                // console.log(dataObject);
                mainparent.parent().find('tr').removeClass('blue lighten-5');
                mainparent.addClass('blue lighten-5');
                
                window.currentGroup = mainparent.find('#hash').val();
                window.currentCredito = mainparent.find('#idcredito').val();

                // console.log(window.currentCredito);
                $('.beneficiario-en-grupo').each(function() {
                    // console.log($(this).find('#idcredito').val());
                    if ($(this).find('#idcredito').val() == window.currentCredito) {
                        //Si el elemento del each es el clickeado, hacemos nada
                    }else{
                        // console.log('estatus_archivo: ' + window.grupo_digitar[$(this).find('#idcredito').val()].estatus_archivo);
                        if (window.grupo_digitar[$(this).find('#idcredito').val()].estatus_archivo == "3") {
                            // console.log('IF');
                            // $('#beneficiario'+$(this).find('#idcredito').val()).removeClass('blue lighten-5');
                            // $('#beneficiario'+$(this).find('#idcredito').val()).addClass('grey lighten-4');
                            // $('#beneficiario'+$(this).find('#idcredito').val()).find('#td-identidad').addClass('green-text');
                            // $('#beneficiario'+$(this).find('#idcredito').val()).find('#nombre_completo').addClass('green-text').off('click');
                        }else{
                            // console.log('ELSE');                    
                            //Si el elemento del each no es el clickeado, lo hacemos gris e inhabilitamos el click en el
                            // console.log($(this).find('#idcredito').val());
                            $('#beneficiario'+$(this).find('#idcredito').val()).removeClass('blue lighten-5');
                            // $('#beneficiario'+$(this).find('#idcredito').val()).addClass('grey lighten-4');
                            $('#beneficiario'+$(this).find('#idcredito').val()).find('#td-identidad').addClass('grey-text');
                            $('#beneficiario'+$(this).find('#idcredito').val()).find('#nombre_completo').addClass('grey-text disabled');
                        }
                    }
                });           

                
            });

            $(this).find('#btn-guardar-grupo').off("click");
        });

        initObject();

        addClickEventListener();      
    }); 
    //***************************************************************************************************************************************************************************************

    
    //                                                                Inicializa el objeto principal de la ventana, que contiene los datos de todo el grupo
    //                                                                                   Se manda a llamar desde el document.ready

    function initObject() { 

        window.grupo_digitar = {};
                
        $('.beneficiario-en-grupo').each(function(){
            
            var idcredito = $(this).find('#idcredito').val();
            
            var emptyDataObject = {};
            
            $('.input-element').each(function(){

                if($(this).attr('id')){

                    var id = $(this).attr('id');
                    var arrayid = id.split("-");
                    emptyDataObject[arrayid[1]] = 0;

                }

            });
            
            emptyDataObject['estatus_archivo'] = 2;
            
            var aux = {};
            
            $.each(emptyDataObject, (index, value) => {
                
                aux[index] = $(this).find('#'+index).val();
                
            });
            
            window.grupo_digitar[idcredito] = aux;
            
            // Si el beneficiario actual está digitado, lo marcamos como digitado
            if($(this).find('#estatus_archivo').val() == 3){ 
                
                $('#beneficiario'+idcredito).removeClass('blue lighten-5');
                $('#beneficiario'+idcredito).addClass('grey lighten-4');
                $('#beneficiario'+idcredito).find('#td-identidad').addClass('green-text');
                $('#beneficiario'+idcredito).find('#nombre_completo').addClass('green-text').on('click', function(e){
                    e.preventDefault();
                });
                
                // Cambiamos el icono del parent si todos los beneficiarios ya han sido digitados                
                var todosDigitados = true;
                
                masterparent = $(this).parent().parent().parent().parent().parent().parent();
                masterparent.find('.beneficiario-en-grupo').each(function(){
                    
                    if($(this).find('#estatus_archivo').val() == "2"){
                        todosDigitados = false;
                    }
                    
                });
                var currenthash = $(this).find('#hash').val();
                
                if(todosDigitados){
                    
                    masterparent.find('#grupo_hash').removeClass('amber-text').addClass('green-text');
                    masterparent.find('#notice-icon').removeClass('amber-text').addClass('green-text').html('done_all');
                    $(this).parent().parent().parent().find('#btn-guardar-grupo').removeClass('grey').addClass('green');
                    
                    $(this).parent().parent().parent().find('#btn-guardar-grupo').off('click').on('click', function(){

                        //Definida al final del archivo
                        saveButton(); 

                    });
                    
                }
            }
        });
    }
    //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


    //                                                                                    Función que inicializa los steps

    function initSteps(elem){
        $(elem).children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slide",
            autoFocus: true,
            labels: {
                    previous: "Anterior",
                    next: "Siguiente",
                    finish: "Finalizar"
                },     

            //Evento que permite validar el formulario, si devuelve true continua al evento onFinished si devuelve false no continua
            onFinishing: function (event, currentIndex){   
                // console.log('onFinishing' + validate);
                return validate;
            },                

            onFinished: function (event, currentIndex){
                //reinicia la variable validate a 0 para que en el siguiente form no pase por default como true
                validate = 0;

                // console.log(window.grupo_digitar[window.currentCredito]);
                //<=======================================================================================================================>
                $.each(window.grupo_digitar, function(index, value){
                    // var tag = $('#input-'+index).prop('tagName');
                    // console.log(tag);
                    // Asignamos el valor respectivo al input correspondiente
                    if(index == 'familiar'){
                        window.grupo_digitar.familiares = [];
                        var familiares = [];
                        $('#edu2').find('.fieldset-familiar').each(function(index, el) {
                            var obj = {};
                            $(this).find('.input-element').each(function(index, el) {
                                // console.log($(this).attr('name') + ':' + $(this).val());
                                obj[$(this).attr('name')] = $(this).val();
                                // console.log(obj);
                            });                  
                            familiares.push(obj);
                            // console.log(familiares);
                            window.grupo_digitar.familiares.push(obj);
                        });
                    }
                    if(index == 'enfermedad'){
                        window.grupo_digitar.enfermedades = [];
                        var enfermedades = [];
                        $('#list-enfermedades-container').find('.fieldset-enfermedades').each(function(index, el) {
                            var obj = {};
                            $(this).find('.input-element').each(function(index, el) {
                                // console.log($(this).attr('name') + ':' + $(this).val());
                                obj[$(this).attr('name')] = $(this).val();
                                // console.log(obj);
                            });                  
                            enfermedades.push(obj);
                            // console.log(familiares);
                            window.grupo_digitar.enfermedades.push(obj);
                        });
                    }                    
                    if (value == undefined) {
                        window.grupo_digitar[index] = $('#input-'+index).val();
                        // console.log(window.grupo_digitar[window.currentCredito][index]);
                        // console.log(index + ' = ' + value);
                    }        
                });
                swal({
                    title: 'Guardando datos',
                    text: '¿Está seguro de guardar los datos?',
                    type: 'info',
                    showCancelButton: true,
                    closeOnConfirm: false,
                    disableButtonsOnConfirm: true,
                    confirmLoadingButtonColor: '#DD6B55'
                },function(confirm){
                    if(confirm){
                        
                        var idusuario = '<?php echo $_SESSION['user'] ?>';
                        console.log(idusuario);
                        window.grupo_digitar["idusuario"] = idusuario;
                        console.log("Lo guardó en el objeto " + window.grupo_digitar[idusuario]);
                        console.log(window.grupo_digitar);

                        $.ajax({
                            type: 'POST',
                            url: '../php/archivo/guardar-linea-base.php',
                            data: {
                                data: JSON.stringify(window.grupo_digitar)
                            },
                            success: function(data){
                                if(data != 'false'){
                                    if($(window.licurrent).find(".subdatabutton:not(.complete)").not(window.currentButton).length == 0){
                                        toggleCollapsible('on');
                                    }
                                    $(window.currentButton).off('click');
                                    $(window.currentButton).addClass('complete');
                                    $(window.licurrent).find(".subdatabutton:not(.complete)").not(window.currentButton).removeAttr('disabled','disabled');
                                    swal('Se han guardado los datos.');
                                }else{
                                    swal('Error', 'No se han podido guardar los datos.', 'error');
                                }
                            }
                        });

                        // console.log(window.grupo_digitar);                
                        $('#card-input').fadeOut(300, function(){
                            $('#prev-instruct').fadeIn(300);
                        });
                        
                        $(elem).children("div").steps('destroy');
                        initSteps(elem);

                        $('#input-emprenderMicroempresa').val('0');
                        $('#input-tieneMicroempresa').val('0');
                        $('#list-familiar-clon').empty();
                        $('#list-enfermedades-clon').empty();
                        addClickEventListener();
                    }
                });

                //<============================= Ajax para ingresar grupo digitado a la BD ==========================================================================================>

                // window.grupo_digitar[window.currentCredito].idcredito = window.currentCredito;
                // var json = JSON.stringify(window.grupo_digitar[window.currentCredito]);
                // $.ajax({
                //     url: '../php/digitacion/guardar-grupo.php',
                //     type: 'POST',
                //     data: 'data='+json,
                // })
                // .done(function(data) {
                //     // var result = JSON.parse(data);                        
                //     console.log(data);
                // })
                // .fail(function() {
                //     console.log("error");
                // })
                // .always(function() {
                //     console.log("complete");
                // });

                //<=================================================================================================================================================================>
            },
        });

        // console.log(window.grupo_digitar[window.currentCredito]);
        $(".wizard .actions ul li a").addClass("waves-effect waves-indigo btn");
        $(".wizard .steps ul").addClass("tabs tabs-fixed-width z-depth-1");
        $(".wizard .steps ul li").addClass("tab");
        $('ul.tabs').tabs();
        $('select').material_select();
        $('.select-wrapper.initialized').prev( "ul" ).remove();
        $('.select-wrapper.initialized').prev( "input" ).remove();
        $('.select-wrapper.initialized').prev( "span" ).remove();            
    }


    //                                                                            Función que crea los listener para añadir los clones 
    
    function addClickEventListener(){
        // Event listener para el boton de agregar nuevos familiares al formulario
        $('#btn-add-familiar').click(function(){
            
            //Limite para la cantidad de familiares
            if($('#list-familiar-clon').find('.fieldset-familiar').length >= 3){ 
                swal('Demasiados familiares','Ha agregado el máximo de familiares','warning');
                return false;
            }
            
            // Clonando al elemento clon
            var clon = $('#familiar-clon').clone();
            clon.removeClass('clon').removeAttr('id');
            clon.find('.input-element').each(function(index, el) {
                $(this).prop('id', $(this).attr('id')+$('#list-familiar-clon').find('.fieldset-familiar').length);
            });
            $('#list-familiar-clon').append(clon);
            $('select').material_select();
            initObject();  
            removeEventListener();       
        });

        
        // Event listener para el boton de agregar nuevas enfermedades
        $('#btn-add-enfermedades').click(function(){
            
            //Limite para la cantidad de familiares
            if($('#list-enfermedades-clon').find('.fieldset-enfermedades').length >= 3){ 
                swal('Demasiados familiares','Ha agregado el máximo de familiares','warning');
                return false;
            }
            
            // Clonando al elemento clon
            var clon = $('#enfermedades-clon').clone();
            clon.removeClass('clon').removeAttr('id');
            $('#list-enfermedades-clon').append(clon);
            $('select').material_select();
            removeEventListener();
            // console.log($('#list-familiar-container').find('.fieldset-familiar'));            
        });          
    }
    //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


    //                                                                     Función Listener que elimina los clon de educación y enfermedades
    function removeEventListener(){
        //Borrar el último clon
        $(".delete-clon").on('click', function () {
            $(this).parent().parent().parent().remove();
        }); 
    }
    //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


    //                                                                  Checkbox que verifica si los datos del beneficiario serán ingresados
    //                                                        Crea la variable validate, la cual tendrá el valor de 1 si el checkbox esta seleccionado

    var validate = 0;
    $(document).on('change', '#input-infoCorrecta', function(){
        if ($(this).is(':checked')) {
            validate = 1;                         
            // console.log('IF: ' + validate); 
        } else {
            validate = 0;
            // console.log('ELSE: ' + validate);
        }
    }); 

    $(document).on('change', '#input-emprenderMicroempresa', function(){
        if ($(this).is(':checked')) {
            $(this).val('1');
            // console.log('IF: ' + validate); 
        }
    });     

    $(document).on('change', '#input-tieneMicroempresa', function(){
        if ($(this).is(':checked')) {
            $(this).val('1');
            // console.log('IF: ' + validate); 
        }
    });    
    //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

</script>

