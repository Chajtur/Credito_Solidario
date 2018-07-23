<?php

require '../php/conection.php';

session_start();
$stat = $conn->prepare('call poblar_promesas_de_pago(:user);');
$stat->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
$stat->execute();

$data = $stat->fetchAll(PDO::FETCH_ASSOC);

?>
<div id="work-collapsible">
    <div class="row">
        <div class="col s12">
            <ul id="creditos-list" class="collapsible" data-collapsible="accordion">
                <li class="collapsible-item-header avatar">
                    <i class="material-icons circle green">local_atm</i>
                    <span class="collapsible-title-header">Promesas de Pagos
                        <div class="secondary-content actions">
                            <input class="search-expandida fuzzy-search" type="search" placeholder="buscar" />
                            <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                <i class="material-icons center-align">search</i>
                            </a>
                        </div>
                    </span>
                    <p>Todos los créditos:</p>
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
                                <p class="collapsible-title">Fecha de Promesa</p>
                            </div>
                            <div class="col m3 l3 hide-on-med-and-down">
                                <p class="collapsible-title">Monto</p>
                            </div>
                        </div>
                    </div>
                </li>

                <div class="list collapsible no-padding no-margin z-depth-0">

                    <?php $i=0;?>

                    <?php foreach($data as $credito):?>

                        <li>
                            <div class="collapsible-header sin-icon <?php echo ($credito['hoy'] ? "indigo lighten-3" : "");?>" id="collapsible<?php echo $credito['Numero_Prestamo'];?>">
                                <div class="row">
                                    <div class="col s1 m1 l1 truncate"><?php echo ++$i;?></div>
                                    <div class="col s11 m5 l4 truncate"><span class="nombreb"><?php echo $credito['Nombre_Completo'];?></span></div>
                                    <div class="col s4 m4 l4 hide-on-small-only identidadb truncate"><?php echo $credito['Fecha_Prometida']?></div>
                                    <div class="col s6 m3 l3 hide-on-med-and-down estatusb truncate">L. <?php echo $credito['Monto_Prometido'];?></div>
                                </div>
                                <input type="hidden" id="numero_prestamo" value="<?php echo $credito['Numero_Prestamo'];?>">
                            </div>
                            <div class="collapsible-body no-padding">
                                <div class="card blue-grey white-text z-depth-0 no-margin no-border-radius">
                                    <div class="card-content">
                                        <span class="card-title text-darken-4"><span class="light">Teléfono:</span> <?php echo $credito['Telefono'];?></span>
                                        <div class="row">

                                            <?php if(isset($credito['Identidad'])):?>
                                            <div class="col l6 m6 s12">
                                                <p><span class="light">Identidad:</span> <?php echo $credito['Identidad'];?></p>
                                            </div>
                                            <?php endif;?>
                                            <?php if(isset($credito['Ifi'])):?>
                                            <div class="col l6 m6 s12">
                                                <p><span class="light">IFI:</span> <?php echo $credito['Ifi'];?></p>
                                            </div>
                                            <?php endif;?>
                                            <?php if(isset($credito['Numero_Prestamo'])):?>
                                            <div class="col l6 m6 s12">
                                                <p><span class="light">Numero de Préstamo:</span> <?php echo $credito['Numero_Prestamo'];?></p>
                                            </div>  
                                            <?php endif;?>
                                            <?php if(isset($credito['Monto_Desembolsado'])):?>
                                            <div class="col l6 m6 s12">   
                                                <p><span class="light">Monto:</span> <?php echo $credito['Monto_Desembolsado'];?></p>
                                            </div>   
                                            <?php endif;?>
                                            <?php if(isset($credito['saldo_capital'])):?>
                                            <div class="col l6 m6 s12">   
                                                <p><span class="light">Saldo Capital:</span> <?php echo $credito['saldo_capital'];?></p>
                                            </div>
                                            <?php endif;?>
                                            <?php if(isset($credito['capital_mora'])):?>
                                            <div class="col l6 m6 s12">   
                                                <p><span class="light">Capital en mora:</span> <?php echo $credito['capital_mora'];?></p>
                                            </div>
                                            <?php endif;?>
                                            <?php if(isset($credito['fecha_ultimo_pago'])):?>
                                            <div class="col l6 m6 s12">
                                                <p><span class="light">Último pago:</span> <?php echo $credito['fecha_ultimo_pago'];?></p>
                                            </div>
                                            <?php endif;?>
                                            <?php if(isset($credito['Fecha_Desembolso'])):?>
                                            <div class="col l6 m6 s12">   
                                                <p><span class="light">Fecha de Desembolso:</span> <?php echo $credito['Fecha_Desembolso'];?></p>
                                            </div>
                                            <?php endif;?>
                                            <?php if(isset($credito['total_pago_pendiente'])):?>
                                            <div class="col l6 m6 s12">
                                                <p><span class="light">Pago pendiente:</span> <?php echo $credito['total_pago_pendiente'];?></p>
                                            </div>
                                            <?php endif;?>
                                            <?php if(isset($credito['cuotas_vencidas'])):?>
                                            <div class="col l6 m6 s12">
                                                <p><span class="light">Cuotas vencidas:</span> <?php echo $credito['cuotas_vencidas'];?></p>
                                            </div> 
                                            <?php endif;?>
                                            <?php if(isset($credito['Ciclo'])):?>
                                            <div class="col l6 m6 s12">
                                                <p><span class="light">Ciclo:</span> <?php echo $credito['Ciclo'];?></p>
                                            </div> 
                                            <?php endif;?>
                                            <?php if(isset($credito['Gestor'])):?>
                                            <div class="col l6 m6 s12">
                                                <p><span class="light">Gestor:</span> <?php echo $credito['Gestor'];?></p>
                                            </div> 
                                            <?php endif;?>
                                            <?php if(isset($credito['Supervisor'])):?>
                                            <div class="col l6 m6 s12">    
                                                <p><span class="light">Supervisor:</span> <?php echo $credito['Supervisor'];?></p>
                                            </div>
                                            <?php endif;?>
                                            <?php if(isset($credito['Grupo_Solidario'])):?>
                                            <div class="col l6 m6 s12">    
                                                <p><span class="light">Grupo Solidario:</span> <?php echo $credito['Grupo_Solidario'];?></p>
                                            </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <div class="card-action">
                                        <!--<a href="#!" class="activator green-text text-lighten-3 btn-bitacora">Bitácora</a>-->
                                        <a href="#!" class="green-text text-lighten-3 tooltipped btn-llamar" data-delay="0" data-position="right" data-tooltip="Llamar al Beneficiario"><i class="material-icons">phone_forwarded</i></a>
                                    </div>
                                    <div class="card-reveal blue-grey darken-1 white-text">
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
                                            
                                            
                                            <!--<table class="">
                                                <thead>
                                                    <tr>
                                                        <th data-field="id">Estado</th>
                                                        <th data-field="name">Fecha de Ingreso</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>Ingresado</td>
                                                        <td>22/02/2017 20:19</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Call Center</td>
                                                        <td>23/02/2017 21:40</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Control de Calidad</td>
                                                        <td>24/02/2017 22:00</td>
                                                    </tr>
                                                </tbody>
                                            </table>-->
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </li>

                    <?php endforeach;?>

                </div>
                
                <li class="collapsible-item-header light">
                    <ul id="pag-control" class="pag pagination">
                    </ul>
                </li>

            </ul>

        </div>
    </div>
</div>

<!-- Modal para marcar las observaciones cuando el beneficiario si contestó -->
<div id="modal-si-contesto" class="modal modal-checklist modal-fixed-footer modal-full-height" data-radio="radiogroup1">
    <div class="modal-content modal-content-editar-grupo">
        <div class="">
            <h4 id="beneficiario-nombre" class="light">Contestó</h4>
        </div>
        <form class="row">
            <div id="nodopadre" class="col l12 m12 s12">
                <ul class="collection with-header">
                    <li class="collection-header">
                        <h5 class="light blue-text">Resumen de llamada</h5>
                        <div class="row">
                            <div class="input-field col s12 m12 l12 grey-text truncate no-margin">
                                <p>
                                    <h6>¿Ya pagó el beneficiario?</h6>
                                    <input name="radiogroup1" type="radio" id="siPago" value="1" class="required radiobutton-checklist" />
                                    <label class="tooltipped blue-text text-darken-2" data-position="bottom" data-delay="50" data-tooltip="Arreglo de pago" for="siPago">Si</label>
                                </p>
                                <p>
                                    <input name="radiogroup1" type="radio" id="noPago" value="0" class="required radiobutton-checklist" />
                                    <label class="tooltipped blue-text text-darken-2" data-position="bottom" data-delay="50" data-tooltip="Arreglo de pago" for="noPago">No</label>
                                </p>
                                <label for="arregloPagogroup" id="arregloPagogroup-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <br>
                            <div class="input-field col l6 m6 s12 no-margin" id="containerValorPagado">
                                <input type="text" name="" id="inputValorPagado" placeholder="Valor Pagado">
                            </div>
                        </div>
                    </li>
                    <!--<li class="collection-header">
                        <h5 class="light blue-text">Otros casos</h5>
                        <div class="row">
                            
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="cortoLlamada" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Cortó la llamada" for="cortoLlamada">Cortó la llamada</label>
                                </p>
                                <label for="group16" id="group16-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="dejoMensaje" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Dejó Mensaje" for="dejoMensaje">Dejó Mensaje</label>
                                </p>
                                <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="faltaRTN" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta RTN" for="faltaRTN">Falta RTN</label>
                                </p>
                                <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="estaDeViaje" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Está de viaje" for="estaDeViaje">Está de viaje</label>
                                </p>
                                <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="empleados" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Empleados" for="empleados">Empleados</label>
                                </p>
                                <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="faltaCopiaIdentidad" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta copia de identidad" for="faltaCopiaIdentidad">Falta copia de identidad</label>
                                </p>
                                <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="noDesembolso" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="No desembolsó crédito" for="noDesembolso">No desembolsó crédito</label>
                                </p>
                                <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="enfermedad" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Está enfermo" for="enfermedad">Está enfermo</label>
                                </p>
                                <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="canceladoCredito" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Crédito Cancelado" for="canceladoCredito">Crédito Cancelado</label>
                                </p>
                                <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="noTieneCredito" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="No tiene crédito" for="noTieneCredito">No tiene crédito</label>
                                </p>
                                <label for="nocreditogroup" id="nocreditogroup-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="deViaje" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Está de viaje" for="deViaje">Está de viaje</label>
                                </p>
                                <label for="estadeviajegroup" id="estadeviajegroup-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="abono" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Abonó a pago" for="abono">Abonó a pago</label>
                                </p>
                                <label for="abonoApago" id="abonoApago-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="nombreDeOtraPersona" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Nombre de otra persona" for="nombreDeOtraPersona">Nombre de otra persona</label>
                                </p>
                                <label for="nombreDeOtraPersonaGroup" id="nombreDeOtraPersonaGroup-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                <p>
                                    <input name="radiogroup1" type="radio" id="compromisoDePago" class="required radiobutton-checklist" />
                                    <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Compromiso de pago" for="compromisoDePago">Compromiso de pago</label>
                                </p>
                                <label for="compromisoDePagogroup" id="compromisoDePagogroup-error" class=" error-checkboxbutton error"></label>
                            </div>
                        </div>
                        <br>
                    </li>-->
                    <li class="collection-header">
                        <h5 class="light blue-text">Observación</h5>
                        <div class="row">
                            <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                <p>
                                    <input name="check1s" type="checkbox" id="observCheck1" class="required observacionCheck" />
                                    <label class="tooltipped black-text" data-position="top" data-delay="50" data-tooltip="Agregar observación personalizada" for="observCheck1">Escribir una observación...</label>
                                </p>
                                <label for="check1s" id="check1s-error" class=" error-checkboxbutton error"></label>
                            </div>
                            <div class="input-field col s12 m12 l12 truncate observacion-personalizada-container" id="observacion-personalizada-container">
                                <input id="observacionPersonalizadaPago" type="text" class="observacionInput" placeholder="Escriba la observación">
                            </div>
                        </div>    
                        <br>
                    </li>
                </ul>
                
            </div>
            <br>
            <!--
            <div class="row margin">
                <div class="input-field col s12 l6 offset-l3">
                    <a id="agregar-observacion-call-center" href="#!" class="btn waves-effect waves-light col s12">agregar nueva observación</a>
                </div>
            </div>
            -->
        </form>
    </div>
    <div class="modal-footer">
        <!--<a id="btn-observacion-call-center" href="#!" class="btn-flat waves-effect waves-green blue-text left">Observación</a>-->
        <a id="btn-guardar-observacion" href="#!" class="btn-modal-guardar modal-action waves-effect waves-green btn-flat blue-text">Guardar</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat grey-text">Cancelar</a>
    </div>
</div>
<!-- Modal para marcar las observaciones cuando el beneficiario si contestó -->

<script>

$(document).ready(init);

function openModalLlamo(){

    swal({
        title: "¿Contestó el beneficiario?",
        text: "Realice la llamada al beneficiario y realice la acción correspondiente.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si contestó",
        cancelButtonText: "No contestó",
        closeOnCancel: false
    },
    function(isConfirm){
        reiniciarModalContesto();
        if(isConfirm){
            window.object.contesto = true;
            $('#modal-si-contesto').modal('open');
        }else{
            window.object.contesto = false;
            guardarObservacion();
        }
    });

}

function reiniciarModals(){

    $('.modal-checklist').each(function(index){

        $(this).find('input:radio[name="'+$(this).data('radio')+'"]').attr('checked', false);
        $(this).find('.observacion-personalizada-container').hide();
        $(this).find('.observacion-personalizada-container').hide();
        $(this).find('#observacionPersonalizada').val('');

        if($(this).find('#observCheck1').length){
            $(this).find('#observCheck1')[0].checked = false;
        }else{
            $(this).find('#observCheck')[0].checked = false;
        }
    });

}

function reiniciarObjeto(){
    window.object = {
        contesto: undefined,
        realizo_pago: undefined,
        observacion_personalizada: undefined,
        observacion: undefined,
        monto_pago: undefined
    }
}

function agregarPagoObjeto(){
    window.object.realizo_pago = $(this).val();
    if($(this).val() == '1'){
        window.object.observacion_personalizada = true;
        $('#containerValorPagado').show();
    }else{
        window.object.observacion_personalizada = false;
        window.object.observacion = undefined;
        $('#containerValorPagado').hide();
    }
}

function agregarObservacionObjeto(){
    window.object.monto_pago = $(this).val();
}

function agregarObservacionPersonalizadaObjeto(){
    if($(this).val() == ''){
        window.object.observacion_personalizada = false;
    }else{
        window.object.observacion_personalizada = true;
    }
    window.object.observacionPersonalizadaPago = $(this).val();
}

function mostrarInputObservacionPersonalizadaFocus(){
    if($(this)[0].checked == false){
        window.object.observacion = undefined;
        window.object.observacion_personalizada = false;
        $(this).parent().parent().next().find('#observacionPersonalizada').val('');
    }else{
        window.object.observacion_personalizada = true;
    }
    $(this).parent().parent().next().toggle();
    $(this).parent().parent().next().find('#observacionPersonalizada').focus();
}

function reiniciarModalContesto(){
    $('.observacion-personalizada-container').hide();
    $('#containerValorPagado').hide();
    $('#observacionPersonalizadaPago').val('');
    $('#inputValorPagado').val('');
}

function agregarNumeroPrestamoObject(){
    window.object.numero_prestamo = $(this).find('#numero_prestamo').val();
}

// Guardar observaciones en bitácora
function guardarObservacion(){
    $.ajax({
        type: 'POST',
        url: '../php/call-center-recuperacion/guardar-observacion-promesa-pago.php',
        data: window.object,
        success: function(data){
            swal('Completado');
            recargarPagina();
        }
    });
}

function init(){

    // Materialize
    $('.collapsible').collapsible();
    $('.modal').modal({
        dismissible: false
    });

    // Valores iniciales
    $('#containerValorPagado').hide();
    $('.observacion-personalizada-container').hide();
    $('#breadcrum-title').text('Promesas de pago');
    $('.observacionCheck').change(mostrarInputObservacionPersonalizadaFocus);
    window.object = {
        contesto: undefined,
        realizo_pago: undefined,
        observacion_personalizada: undefined,
        observacion: undefined,
        monto_pago: undefined
    }

    // Eventos
    $('.btn-llamar').click(openModalLlamo);
    $('.modal-close').click(reiniciarModals);
    $('input[name="radiogroup1"]').change(agregarPagoObjeto);
    $('#inputValorPagado').on('input', agregarObservacionObjeto);
    $('#observacionPersonalizadaPago').on('input', agregarObservacionPersonalizadaObjeto);
    $('#btn-guardar-observacion').click(guardarObservacion);
    $('.collapsible-header').click(agregarNumeroPrestamoObject);

    //list object init
    var options = {
        page: 10,
        pagination: true,
        valueNames: [ 'nombreb', 'identidadb', 'estatusb' ],
        fuzzySearch: {
            searchClass: "fuzzy-search",
            location: 0,
            distance: 100,
            threshold: 0.2,
            multiSearch: true
        }
    };
    window.listObj = new List('creditos-list', options);

}

</script>