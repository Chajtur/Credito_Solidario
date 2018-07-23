<?php

require '../php/conection.php';
session_start();
//Captura de los datos que se mostrarán en la ventana
$stat = $conn->prepare('select distinct grupo_solidario_hash, Grupo_Solidario, gestor, Estatus_Prestamo, ciclo 
    from cartera_consolidada where Estatus_Prestamo = "Control de Calidad" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');
$stat->execute();
$grupos = $stat->fetchAll();

//Stat para capturar los beneficiarios de cada grupo
$stat = $conn->prepare('select id, identidad, nombre from cartera_consolidada 
    where Estatus_Prestamo = "Control de Calidad" and grupo_solidario_hash = :hash');

$grupos_beneficiarios = array();

//Para cada grupo capturado
foreach($grupos as $grupo){
    
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

//Seleccionamos los gestores unicos cuyos creditos están en estado call center para el filtro por gestor
$stat = $conn->prepare('select distinct gestor from cartera_consolidada where Estatus_Prestamo = "Control de Calidad" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');
$stat->execute();
    
$gestores = $stat->fetchAll();

?>


<div class="section">
    <div class="row">
        <div class="col s10 offset-s1">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">
                        <div class="row">
                            <div class="col l8">Verificación de Créditos</div>
                            <div class="col l4">
                            </div>
                        </div>
                    </span>
                    <div id="por-verificar-list">
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
                        <br class="hide-on-large-only">
                        <br class="hide-on-large-only">
                        <div class="row">

                            <form>
                                <div class="col s12">
                                    <ul class="collapsible grupos-recibidos list z-depth-0" data-collapsible="accordion">
                                       
                                        <li class="">
                                            <div class="collapsible-header">
                                                <div class="col s12 l2">
                                                    <span class="" for="recibido">Hash</span>
                                                </div>
                                                <div class="col s12 l3 hide-on-med-and-down truncate">Nombre del Grupo</div>
                                                <div class="col s12 l3 hide-on-med-and-down truncate hide-on-med-and-down">Gestor</div>
                                                <div class="col s12 l2 hide-on-med-and-down truncate hide-on-med-and-down">Estado</div>
                                            </div>
                                        </li>
                                        
                                        <?php if(count($grupos_beneficiarios) != 0):?>
                                           
                                            <?php $i = 0;?>
                                            
                                            <?php foreach($grupos_beneficiarios as $grupo):?>

                                                <li class="li-grupo" id="<?php echo $grupo['hash'];?>">

                                                    <div class="collapsible-header">
                                                        <div class="col s12 l2">
                                                            <i id="alert-icon" class="material-icons left warning-observ"></i>
                                                            <span class="codigog global-codigo-grupo-hash" for="recibido"><?php echo $grupo['hash'];?></span>
                                                        </div>
                                                        <div class="col s12 l3 hide-on-med-and-down nombreg truncate global-nombre-grupo"><?php echo $grupo['nombre_grupo'];?></div>
                                                        <div class="col s12 l3 hide-on-med-and-down gestorg truncate hide-on-med-and-down global-gestor"><?php echo $grupo['gestor'];?></div>
                                                        <div class="col s12 l2 hide-on-med-and-down estadog truncate hide-on-med-and-down global-estatus-prestamo"><?php echo $grupo['estatus_prestamo'];?></div>
                                                        <input type="hidden" name="" class="global-ciclo" value="<?php echo $grupo['ciclo'];?>">
                                                        <input type="hidden" name="" class="global-cantidad-beneficiarios" value="<?php echo $grupo['cantidad_beneficiarios'];?>">
                                                    </div>

                                                    <div class="collapsible-body">
                                                        <div class="row margin">
                                                            <br>
                                                            <div class="col s12 l10 offset-l1">
                                                                <fieldset>
                                                                    <legend class="grey-text">Beneficiarios</legend>
                                                                    <table id="tabla-verificar-call-center" class="striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="grey-text" data-field="id">Nombre</th>
                                                                                <th class="grey-text" data-field="id">Identidad</th>
                                                                                <th class="grey-text" data-field="id">Observaciones</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                            <?php $j = 0;?>
                                                                            
                                                                            <?php foreach($grupo['beneficiarios'] as $beneficiario):?>

                                                                                <tr class="beneficiario-row">
                                                                                    <td class="grey-text global-beneficiario-nombre"><a href="#!" class="a-open-checklist"><?php echo $beneficiario['nombre'];?></a></td>
                                                                                    <td class="grey-text global-beneficiario-identidad"><?php echo $beneficiario['identidad'];?></td>
                                                                                    <td class="grey-text center-align"><i id="icon" class="material-icons warning-observ"></i></td>
                                                                                    <input type="hidden" id="parent-index" value="<?php echo $i;?>">
                                                                                    <input type="hidden" id="child-index" value="<?php echo $j;?>">
                                                                                    <input type="hidden" id="grupo-hash" value="<?php echo $grupo['hash'];?>">
                                                                                    <input type="hidden" id="id_credito" value="<?php echo $beneficiario['id'];?>">
                                                                                </tr>
                                                                                
                                                                                <?php $j++;?>

                                                                            <?php endforeach;?>

                                                                        </tbody>
                                                                    </table>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </li>
                                                
                                                <?php $i++;?>
                                                
                                            <?php endforeach;?>
                                        
                                        <?php else:?>
                                        
                                            <li>
                                                <div class="collapsible-header sin-icon">
                                                    <div class="col s12 l12">
                                                        <center>
                                                            <h5>No hay nada recibido.</h5>
                                                        </center>
                                                    </div>
                                                </div>
                                            </li>
                                        
                                        <?php endif;?>
                                        
                                    </ul>
                                    <ul id="pag-control" class="pag pagination">
                                    </ul>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12 l4 offset-l4">
                                        <a id="verificados-success" href="#!" class="btn waves-effect waves-light col s12 ">Guardar</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal para marcar las observaciones de Call-Center -->
    <div id="modal-observaciones" class="modal  modal-fixed-footer modal-full-height">
        <div class="modal-content modal-content-editar-grupo">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h4 id="beneficiario-nombre" class="light">María Eugenia Lopez</h4>
                    <div id="card-alert" class="card blue z-depth-0">
                        <div class="card-content white-text">
                            <p>Instrucciones: Marque las observaciones del crédito una vez verifique el crédito.</p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="row">
                        <div id="nodopadre" class="col l12 m12 s12">
                            <ul class="collection with-header">
                                <li class="collection-header">
                                    <h5 class="light blue-text">Datos faltantes</h5>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group1" type="checkbox" id="CasillasEnBlanco" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Casillas en Blanco" for="CasillasEnBlanco">Casillas en Blanco</label>
                                            </p>
                                            <label for="group1" id="group1-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group3" type="checkbox" id="ProductoFormaIncompleto" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Producto y forma de distribución incompleto" for="ProductoFormaIncompleto">Producto y forma de distribución incompleto</label>
                                            </p>
                                            <label for="group3" id="group3-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group13" type="checkbox" id="LineaBaseIncompleta" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Linea base incompleta" for="LineaBaseIncompleta">Linea base incompleta</label>
                                            </p>
                                            <label for="group13" id="grou13-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group13" type="checkbox" id="NoFirmaSupervisor" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="No tiene firma del supervisor" for="NoFirmaSupervisor">No tiene firma del supervisor</label>
                                            </p>
                                            <label for="group13" id="grou13-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group13" type="checkbox" id="NoFirmaAsesorTecnico" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="No tiene firma del asesor tecnico" for="NoFirmaAsesorTecnico">No tiene firma del asesor tecnico</label>
                                            </p>
                                            <label for="group13" id="grou13-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group13" type="checkbox" id="NoRTN" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="No trae RTN numerico" for="NoRTN">No trae RTN numerico</label>
                                            </p>
                                            <label for="group13" id="grou13-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group65" type="checkbox" id="noTraeReciboPago" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="No trae ultimo recibo de pago (en cero)" for="noTraeReciboPago">No trae ultimo recibo de pago (en cero)</label>
                                            </p>
                                            <label for="group65" id="grou65-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                    </div>
                                    <br>
                                </li>
                                <li class="collection-header">
                                    <h5 class="light blue-text">Errores en la solicitud</h5>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group11" type="checkbox" id="SolicitudManchonesTachaduras" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Solicitud con manchones o tachaduras" for="SolicitudManchonesTachaduras">Solicitud con manchones o tachaduras</label>
                                            </p>
                                            <label for="group11" id="grou11-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group13" type="checkbox" id="IdentidadMalEstado" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Identidad en mal estado" for="IdentidadMalEstado">Identidad en mal estado</label>
                                            </p>
                                            <label for="group13" id="grou13-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group13" type="checkbox" id="LetraNoLegible" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Letra no legible" for="LetraNoLegible">Letra no legible</label>
                                            </p>
                                            <label for="group13" id="grou13-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group66" type="checkbox" id="fechaNacimientoIncorrecta" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Fecha de nacimiento incorrecta" for="fechaNacimientoIncorrecta">Fecha de nacimiento incorrecta</label>
                                            </p>
                                            <label for="group66" id="grou66-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                    </div>
                                    <br>
                                </li>
                                <li class="collection-header">
                                    <h5 class="light blue-text">Plan de Negocio</h5>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="planNegocios" type="checkbox" id="PlanDeNegociosIncompleto" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Plan de Negocios Incompleto" for="PlanDeNegociosIncompleto">Plan de Negocios Incompleto</label>
                                            </p>
                                            <label for="planNegocios" id="planNegocios-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group4" type="checkbox" id="ProyeccionVentasErronea" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Proyección de ventas erronea" for="ProyeccionVentasErronea">Proyección de ventas erronea</label>
                                            </p>
                                            <label for="group4" id="group4-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group5" type="checkbox" id="EstacionalidadVentasInconsistencias" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" for="EstacionalidadVentasInconsistencias" data-position="bottom" data-delay="50" data-tooltip="Estacionalidad de ventas con inconsistencias">Estacionalidad de ventas con inconsistencias</label>
                                            </p>
                                            <label for="group5" id="group5-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group7" type="checkbox" id="PlanNegociosInconsistente" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" for="PlanNegociosInconsistente" data-position="bottom" data-delay="50" data-tooltip="Plan de negocios inconsistente">Plan de negocios inconsistente</label>
                                            </p>
                                            <label for="group7" id="group7-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                    </div>
                                    <br>
                                </li>
                                <li class="collection-header">
                                    <h5 class="light blue-text">Plan de Inversión</h5>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group8" type="checkbox" id="CuadroCostosInconsistente" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Cuadro de costos inconsistente" for="CuadroCostosInconsistente">Cuadro de costos inconsistente</label>
                                            </p>
                                            <label for="group8" id="group8-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group9" type="checkbox" id="CuadroEgresosInconsistente" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Cuadro de egresos inconsistente" for="CuadroEgresosInconsistente">Cuadro de egresos inconsistente</label>
                                            </p>
                                            <label for="group9" id="group9-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group10" type="checkbox" id="EstadoPatrimonialInconsistente" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Estado patrimonial inconsistente" for="EstadoPatrimonialInconsistente">Estado patrimonial inconsistente</label>
                                            </p>
                                            <label for="group10" id="grou109-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group12" type="checkbox" id="CostosGastosMayoresIngresos" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Costos y gastos mayores a ingresos" for="CostosGastosMayoresIngresos">Costos y gastos mayores a ingresos</label>
                                            </p>
                                            <label for="group12" id="grou12-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                    </div>
                                    <br>
                                </li>
                                <li class="collection-header">
                                    <h5 class="light blue-text">Errores procedimentales</h5>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group13" type="checkbox" id="ExcedenteIngresosNoNecesitaCredito" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Excedente de ingresos muestran que no necesita el credito" for="ExcedenteIngresosNoNecesitaCredito">Excedente de ingresos muestran que no necesita el credito</label>
                                            </p>
                                            <label for="group13" id="grou13-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group45" type="checkbox" id="ingresosNoCoinciden" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Ingresos de la solicitud no coinciden con ingresos consultados al beneficiario" for="ingresosNoCoinciden">Ingresos de la solicitud no coinciden con ingresos consultados al beneficiario</label>
                                            </p>
                                            <label for="group45" id="grou45-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group46" type="checkbox" id="ingresosNoCoinciden" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Ingresos de la solicitud no coinciden con ingresos consultados al beneficiario" for="ingresosNoCoinciden">Ingresos de la solicitud no coinciden con ingresos consultados al beneficiario</label>
                                            </p>
                                            <label for="group46" id="grou46-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group14" type="checkbox" id="actualizarServiciosPublicos" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Actualizar Servicios Públicos" for="actualizarServiciosPublicos">Servicios públicos desactualizados</label>
                                            </p>
                                            <label for="group43" id="grou14-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group44" type="checkbox" id="justificaionNoValida" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Justificación no válida" for="justificaionNoValida">Justificación no válida</label>
                                            </p>
                                            <label for="group44" id="grou44-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group6" type="checkbox" id="CuotasNoJustificadas" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" for="CuotasNoJustificadas" data-position="bottom" data-delay="50" data-tooltip="Cuotas atrasadas no justificadas">Cuotas atrasadas no justificadas</label>
                                            </p>
                                            <label for="group6" id="group6-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 grey-text truncate">
                                            <p>
                                                <input name="group13" type="checkbox" id="NoPagoTiempoForma" class="required filled-in checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="No pago en tiempo y en forma" for="NoPagoTiempoForma">No pago en tiempo y en forma</label>
                                            </p>
                                            <label for="group13" id="grou13-error" class="green-text error-checkboxbutton error"></label>
                                        </div>
                                    </div>
                                    <br>
                                </li>
                                <li class="collection-header">
                                    <h5 class="light blue-text">Personalizado</h5>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                            <p>
                                                <input name="group30" type="checkbox" id="observacionCheck" class="required checkbox-checklist" />
                                                <label class="tooltipped black-text" data-position="top" data-delay="50" data-tooltip="Agregar observación personalizada" for="observacionCheck">Observación...</label>
                                            </p>
                                            <label for="group30" id="group30-error" class=" error-checkboxbutton error"></label>
                                        </div>
                                        <div class="input-field col s12 m12 l12 truncate" id="observacion-personalizada-container">
                                            <input id="observacionPersonalizada" type="text" class="" placeholder="Escriba la observación">
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
            </div>
        </div>
        <div class="modal-footer">
            <a id="btn-observacion-call-center" href="#!" class="btn-flat waves-effect waves-green blue-text left">Observación</a>
            <a id="btn-guardar-verificado-ctrl-calidad" href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat blue-text">Verificar</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat grey-text">Cancelar</a>
        </div>
    </div>
    <!-- Modal para marcar las observaciones de Call-Center -->



    <!--DIV CLON-->
    <div class="row clon" id="clon">
        <div class="input-field col s12 l11">
            <input id="id_beneficiario3-editar" type="text" class="validate">
            <label for="id_beneficiario3-editar">Observación</label>
        </div>
        <div class="input-field col s12 l1 center">
            <a class="borrar-observacion" href="#!"><i class="material-icons red-text prefix waves-effect waves-green">close</i></a>
        </div>
    </div>
    <!--DIV CLON-->
</div>




<script>

$(document).ready(function(){
    
    $('#breadcrum-title').text('Verificación de Créditos');
    
    /*
    ===INICIALIZACIONES===
    */
    
    $('#observacion-personalizada-container').hide();

    window.currentids = {
        parent: 0,
        child: 0
    }
    
    $('.collapsible').collapsible();
    
    $('.modal').modal();
    
    $('select').material_select();
    
    $('.tooltipped').tooltip();
    
    initEmptyObject(); //Función que inicializa el objeto principal que contiene el estado de cada grupo con sus beneficiarios
    
    /*
    ===EVENTOS===
    */
    
    //Evento change para el filtro por gestor
    $('#select-filtro-gestor').on('change', function(){
        
        $('#buscarHas').val($('#select-filtro-gestor option:selected').val());
        window.listObj.fuzzySearch($('#select-filtro-gestor option:selected').val()); //El objeto global del filtro por gestor se encuentra en window.listObj 
        
    });
    
    //Agrega el campo de observación personalizado de Call Center
    $('#agregar-observacion-ctrl-calidad').click(function(){
                
        let newelem = $('#clon').clone();
        newelem.toggle();
        newelem.removeAttr('id');
        $('#nodopadre').append(newelem);
        asignarEventosEliminar();
        /*Materialize.toast('Agregado', 2000);*/
                
    });

    // evento para mostrar el textfield al marcar la observación personalizada
    $('#observacionCheck').change(function(){

        if($(this)[0].checked == false){
            $('#observacionPersonalizada').val('');
        }
        $('#observacion-personalizada-container').toggle();
        $('#observacionPersonalizada').focus();
    });

    $('#btn-observacion-call-center').click(function(){
        $('#modal-observaciones').find('.modal-content').first().animate({
            scrollTop: $('#modal-observaciones').find('.modal-content').prop("scrollHeight") 
        }, 'slow');
        if($('#observacionCheck')[0].checked == false){
            $('#observacionCheck').trigger('click');
        }

    });
    
    //Evento clic para el boton de guardar cambios a los grupos verificados
    $('#verificados-success').click(function(){ // Boton de guardar
        
        /*
        Validación para ver si todos los grupos han sido verificados
        */
        
        var swalGuardar = function(){ //Metemos en una variable el sweet alert que envia los datos al archivo php
            
            swal({
                title: "¿Desea guardar los cambios?",
                text: "Los grupos serán verificados y se guardarán los cambios de forma permanente!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, guardar",
                cancelButtonText: "Cancelar",
                showLoaderOnConfirm: true,
                closeOnConfirm: false
            },
            function(){

                $.ajax({

                    type: 'POST',
                    url: '../php/coordinador-digitador/verificar-control-calidad.php',
                    data: {
                        data: JSON.stringify(window.grupos)
                    },  
                    success: function(data){
                            
                        if(data == "true"){
                            
                            //Materialize.toast(data);
                            //console.log(data);
                            swal("Guardado con éxito!", "Se han verificado los creditos.","success");
                            $('#floating-refresh').trigger('click'); //Actualizamos el main-container gracias a data-change.js
                            
                        }else{
                         
                            Materialize.toast('Error', 2000);
                            
                        }

                    }

                });
                
            });
            
        }
        
        /*
        Para verificar si todos los créditos de la ventana están verificados o no
        */
        
        var cantidadVerificados = 0;
        var ningunoVerificado = true;
        
        $.each(window.grupos, function(index, value){
            
            if(value.verificado){
                cantidadVerificados++;
                ningunoVerificado = false;
            }
            
        });
        
        if(ningunoVerificado){
            swal({
                
                title: "No ha verificado ningún grupo",
                text: "Termine de verificar uno o más grupos para poder guardar",
                type: "error",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Entendido",
                closeOnConfirm: false

            });
            return false;
        }
        
        if(cantidadVerificados < window.grupos.length){
            
            console.log(cantidadVerificados);
            swal({
                
                title: "Hay grupos sin verificar",
                text: "¿Esta seguro que desea continuar? Solo se guardarán los grupos que estén completamente verificados.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Continuar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false

            }, function(){
                
                swalGuardar();
                
            });
            
        }else{
            
            swalGuardar();
            
        }    
        
    });
    
    /*
    Event listener para el boton Verificar
    */
    
    $('#btn-guardar-verificado-ctrl-calidad').click(function(){
        
        //inicializacion de variables
        var cambioIcono = false; //Booleana para verificar si ya se cambió el icono
        var todosDesmarcados = true; //Booleana para verificar si todos los checkbox están desmarcados
        var todosVerificados = false; //Booleana para verificar que todos los grupos estén verificados
        
        window.grupos[window.currentids.parent].beneficiarios[window.currentids.child].checklist = []; //Vaciamos la checklist antígua en el objeto principal
        
        //Loop foreach para verificar el estado de todos los checkbox 
        $(".checkbox-checklist").each(function(){
            
            //Agregando al objeto en caso que el checkbox esté marcado y cambia el icono si no se ha cambiado
            if($(this)[0].checked){
                
                //Agregando al checklist del grupo actual el checkbox marcado
                if($(this).attr('id') == 'observacionCheck'){
                    window.grupos[window.currentids.parent].beneficiarios[window.currentids.child].checklist.push({

                        id: $(this).attr('id'),
                        checked: $(this)[0].checked,
                        text: $('#observacionPersonalizada').val()

                    });
                }else{
                    //Agregando al checklist del grupo actual el checkbox marcado
                    window.grupos[window.currentids.parent].beneficiarios[window.currentids.child].checklist.push({

                        id: $(this).attr('id'),
                        checked: $(this)[0].checked,
                        text: $(this).next().text()

                    });
                }
                
                //Si no se ha cambiado el icono, que se cambie
                if(!cambioIcono){
                    
                    var current = $('#'+window.liactive).find('.beneficiario-row').eq(window.currentids.child);
                    current.find('#icon').removeClass('warning-observ');
                    current.find('#icon').removeClass('success-observ');
                    current.find('#icon').addClass('error-observ');
                    
                    cambioIcono = true;
                    
                    //var mainicon = $('#'+window.liactive).find('#alert-icon');
                }
                
                //Con un checkbox que esté marcado se hace falsa la variable todosDesmarcados
                todosDesmarcados = false;
                
            }

        });
        
        //Si al finalizar el loop anterior la variable todosDesmarcados sigue true, entonces cambia el icono a success
        if(todosDesmarcados){
                
            var current = $('#'+window.liactive).find('.beneficiario-row').eq(window.currentids.child);
            current.find('#icon').removeClass('warning-observ');
            current.find('#icon').removeClass('error-observ');
            current.find('#icon').addClass('success-observ');

        }
        
        /*
        Verificación para saber si todos los créditos de un grupo fueron verificados
        */
        
        var tieneWarning = false; //Booleana para saber si el grupo tiene algun crédito con Warning
        var tieneError = false; //Booleana para saber si el grupo tiene algun crédito con Error
        var tieneSuccess = false; //Booleana para saber si el grupo tiene algun crédito con Success
        
        //Recorremos todos los li con clase beneficiario-row para ver el estado de cada crédito del grupo
        $('#'+window.liactive).find('.beneficiario-row').each(function(){
            
            var item = $(this).find('#icon');
            
            if(item.hasClass('warning-observ')){
                
                tieneWarning = true;
                return false;
                
            }else{
                
                if(item.hasClass('error-observ')){
                
                    tieneError = true;
                
                }else if(item.hasClass('success-observ')){

                    tieneSuccess = true;

                }
                
            } 
            
        });
        
        //Si el grupo no tenia ningún crédito con warning entonces verifica si tenia alguno de error, en caso contrario se le asigna success
        if(!tieneWarning){
            
            if(tieneError){
            
                $('#'+window.liactive).find('#alert-icon').removeClass('warning-observ');
                $('#'+window.liactive).find('#alert-icon').removeClass('success-observ');
                $('#'+window.liactive).find('#alert-icon').addClass('error-observ');
                window.grupos[window.currentids.parent].con_error = true;
                //Materialize.toast('Tiene Error', 2000);

            }else{

                if(tieneSuccess){

                    $('#'+window.liactive).find('#alert-icon').removeClass('warning-observ');
                    $('#'+window.liactive).find('#alert-icon').removeClass('error-observ');
                    $('#'+window.liactive).find('#alert-icon').addClass('success-observ');
                    //Materialize.toast('Tiene Success', 2000);

                }

            }
            
            $.each(window.grupos, function(index, value){
                if(value.hash == window.liactive){
                    value.verificado = true;
                }
            });
            
        }
        
    }); //Fin del evento clic del boton verificar
    
    /*
    Evento click para abrir el checklist de cada crédito
    Abre el modal
    */
    
    $('.a-open-checklist').click(function(){
        
        var auxthis = $(this);
        var parentid = $(this).parent().parent().find('#grupo-hash').val();
        
        window.liactive = parentid;
        
        $('.checkbox-checklist').each(function(){
            if($(this)[0].checked == true){
                $(this).trigger('click');
            }
        });
        
        if($('#observacionCheck').prop('checked')){
            $('#observacionCheck').trigger('click');
        }

        var parentid = $(this).parent().parent().find('#parent-index').val();
        var childid = $(this).parent().parent().find('#child-index').val();
        
        window.currentids.parent = parentid;
        window.currentids.child = childid;
        
        
        $('#beneficiario-nombre').text(window.grupos[window.currentids.parent].beneficiarios[window.currentids.child].nombre);        
        var arraychecklist = window.grupos[window.currentids.parent].beneficiarios[window.currentids.child].checklist;
        
        $.each(arraychecklist, function(index, obj){
           if(obj.id == 'observacionCheck'){
                $('#'+obj.id).trigger('click');
                $('#observacionPersonalizada').val(obj.text);
            }else{
                $('#'+obj.id)[0].checked = true;
            }
        });
        
        $('#modal-observaciones').modal('open');
        $('#modal-observaciones').find('.modal-content').first().animate({
            scrollTop: 0
        }, 200);
        
    });
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
    window.listObj = new List('por-verificar-list', options);
    
    $("#card-alert .close").click(function(){
        $(this).closest('#card-alert').fadeOut('slow');
    });

}); //FINALIZA DOCUMENT.READY

//ELIMINAR OBSERVACIONES INPUT QUE NO SE DESEEN    
function asignarEventosEliminar(){
    
    $('.borrar-observacion').each(function(){
        
        $(this).off('click').on('click', function(){
            
            var elmem = $(this);
            (elmem).parent().parent().remove();
            
        });
        
    });
    
}

/*
Función para inicializar el objeto principal que contendrá la información de todos los grupos y sus checklist
*/
    
function initEmptyObject(){
    
    window.grupos = [];
    
    $('#breadcrum-title').text('Verificar Créditos');
    
    $('.global-codigo-grupo-hash').each(function(index){
        
        var beneficiarios = [];
        
        $(this).parent().parent().parent().find('.global-beneficiario-nombre').each(function(index){
            
            var tempbeneficiario = {
                nombre: $(this).text(),
                identidad: $(this).next().text(),
                id_credito: $(this).parent().find('#id_credito').val(),
                checklist: []
            }
            
            beneficiarios.push(tempbeneficiario);
            
        });
        
        var tempobject = {
            hash: $(this).text(),
            nombre_grupo: $('.global-nombre-grupo').eq(index).text(),
            gestor: $('.global-gestor').eq(index).text(),
            estatus_prestamo: $('.global-estatus-prestamo').eq(index).text(),
            ciclo: $('.global-ciclo').eq(index).val(),
            cantidad_beneficiarios: $('.global-cantidad-beneficiarios').eq(index).val(),
            beneficiarios: beneficiarios,
            verificado: false,
            con_error: false
        }
        
        window.grupos.push(tempobject);
        
    });
    
    console.log(window.grupos);
    
}
    
</script>