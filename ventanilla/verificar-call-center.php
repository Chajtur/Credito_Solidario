<?php

require '../php/conection.php';
session_start();
//Captura de los datos que se mostrarán en la ventana
$stat = $conn->prepare('select distinct grupo_solidario_hash, Grupo_Solidario, gestor, Estatus_Prestamo, ciclo 
    from cartera_consolidada where Estatus_Prestamo = "Call Center" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');
$stat->execute();
$grupos = $stat->fetchAll();

//Stat para capturar los beneficiarios de cada grupo
$stat = $conn->prepare('select id, identidad, nombre from cartera_consolidada 
    where Estatus_Prestamo = "Call Center" and grupo_solidario_hash = :hash');

$stat_bitacora = $conn->prepare('select * from bitacora_creditos where id_credito = :idcredito and razon in ("No contesto la llamada", "Contesto la llamada")
having fecha > if((select max(fecha) from bitacora_creditos where id_credito = :idcredito and razon = "Devuelto con correcciones") is null, "2015-1-1", (select max(fecha) from bitacora_creditos where id_credito = :idcredito and razon = "Devuelto con correcciones"));');

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
        
        $cantidad_nocontesto = 0;
        $cantidad_contesto = 0;

        $stat_bitacora->bindValue(':idcredito', $beneficiario['id'], PDO::PARAM_STR);
        $stat_bitacora->execute();
        
        $bitacora = $stat_bitacora->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($bitacora as $fila){
            if($fila['razon'] == "No Contesto la llamada"){
                $cantidad_nocontesto++;
            }
            if($fila['razon'] == "Contesto la llamada"){
                $cantidad_contesto++;
            }
        }

        $beneficiario['bitacora_contesto'] = $cantidad_contesto;
        $beneficiario['bitacora_nocontesto'] = $cantidad_nocontesto;

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
$stat = $conn->prepare('select distinct gestor from cartera_consolidada where Estatus_Prestamo = "Call Center"');
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
                                <input id="buscarHas" type="text" class="validate fuzzy-search" placeholder="Buscar">
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
                                            <div class="collapsible-header sin-icon">
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
                                                                                    <input type="hidden" id="contesto_counter" value="<?php echo $beneficiario['bitacora_contesto'];?>">
                                                                                    <input type="hidden" id="nocontesto_counter" value="<?php echo $beneficiario['bitacora_nocontesto'];?>">
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
                                                            <h5>No hay nada para verificar.</h5>
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
            <div class="">
                <h4 id="beneficiario-nombre" class="light">María Eugenia Lopez</h4>
                <div id="card-alert" class="card blue z-depth-0">
                    <div class="card-content white-text">
                        <p>Instrucciones: Marque las observaciones del crédito una vez halla completado la llamada.</p>
                    </div>
                    <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <form class="row">
                <div id="nodopadre" class="col l12 m12 s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5 class="light blue-text">Documentos faltantes</h5>
                            <div class="row">
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group16" type="checkbox" id="faltaCroquis" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta el croquis" for="faltaCroquis">Falta el croquis</label>
                                    </p>
                                    <label for="group16" id="group16-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group19" type="checkbox" id="faltaRevision" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta revisión (Taxi)" for="faltaRevision">Falta revisión (Taxi)</label>
                                    </p>
                                    <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group19" type="checkbox" id="faltaRTN" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta RTN" for="faltaRTN">Falta RTN</label>
                                    </p>
                                    <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group19" type="checkbox" id="faltaReciboPago" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta  recibo de pago" for="faltaReciboPago">Falta recibo de pago</label>
                                    </p>
                                    <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group19" type="checkbox" id="faltaEstadoCuenta" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta estado de cuenta" for="faltaEstadoCuenta">Falta estado de cuenta</label>
                                    </p>
                                    <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group19" type="checkbox" id="faltaCopiaIdentidad" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta copia de identidad" for="faltaCopiaIdentidad">Falta copia de identidad</label>
                                    </p>
                                    <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group19" type="checkbox" id="faltaReciboPublico" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta copia de recibo público" for="faltaReciboPublico">Falta copia de recibo público</label>
                                    </p>
                                    <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group19" type="checkbox" id="faltaFiniquito" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta finiquito" for="faltaFiniquito">Falta finiquito</label>
                                    </p>
                                    <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group19" type="checkbox" id="faltaDocumentoGarantia" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta documento de garantías" for="faltaDocumentoGarantia">Falta documento de garantías</label>
                                    </p>
                                    <label for="group19" id="group19-error" class=" error-checkboxbutton error"></label>
                                </div>
                            </div>
                            <br>
                        </li>
                        <li class="collection-header">
                            <h5 class="light blue-text">Información errónea</h5>
                            <div class="row">
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group1" type="checkbox" id="nCompletoNo" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Nombres y Apellidos Incorrectos" for="nCompletoNo">Nombres y Apellidos Incorrectos</label>
                                    </p>
                                    <label for="group1" id="group1-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group2" type="checkbox" id="identidadNo" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Identidades Incorrectas" for="identidadNo">Identidades Incorrectas</label>
                                    </p>
                                    <label for="group2" id="group2-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group3" type="checkbox" id="DirecciónDomicilioSi" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Numeros Telefónicos Incorrectos" for="DirecciónDomicilioSi">Numeros Telefónicos Incorrectos</label>
                                    </p>
                                    <label for="group3" id="group3-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group4" type="checkbox" id="estadoCivilNo" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Estado Civil Incorrectos" for="estadoCivilNo">Estado Civil Incorrectos</label>
                                    </p>
                                    <label for="group4" id="group4-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group9" type="checkbox" id="datosDelTrabajo" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Lugar de Trabajo Incorrectos" for="datosDelTrabajo">Lugar de Trabajo Incorrectos</label>
                                    </p>
                                    <label for="group9" id="group9-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group10" type="checkbox" id="datosDelConyuge" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Datos del Conyuge Incorrectos" for="datosDelConyuge">Datos del Conyuge Incorrectos</label>
                                    </p>
                                    <label for="group10" id="grou109-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group11" type="checkbox" id="datosLaboralesDelConyuge" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Datos Laborales del Conyuge Incorrectos" for="datosLaboralesDelConyuge">Datos Laborales del Conyuge Incorrectos</label>
                                    </p>
                                    <label for="group11" id="grou11-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group12" type="checkbox" id="referenciasFamiliares" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Referencias Familiares Incorrectos" for="referenciasFamiliares">Referencias Familiares Incorrectos</label>
                                    </p>
                                    <label for="group12" id="grou12-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group13" type="checkbox" id="referenciasPersonales" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Referencias Personales Incorrectos" for="referenciasPersonales">Referencias Personales Incorrectos</label>
                                    </p>
                                    <label for="group13" id="grou13-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group17" type="checkbox" id="datosNegocioNo" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Datos del Negocio Incorrectos" for="datosNegocioNo">Datos del Negocio Incorrectos</label>
                                    </p>
                                    <label for="group17" id="group17-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group15" type="checkbox" id="datosDomiciliaresIncorrectos" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Datos domiciliares incorrectos" for="datosDomiciliaresIncorrectos">Datos domiciliares incorrectos</label>
                                    </p>
                                    <label for="group15" id="group15-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group90" type="checkbox" id="fechaNacimientoIncorrecta" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Fecha de Nacimiento Incorrecta" for="fechaNacimientoIncorrecta">Fecha de Nacimiento Incorrecta</label>
                                    </p>
                                    <label for="group90" id="group90-error" class=" error-checkboxbutton error"></label>
                                </div>
                            </div>
                            <br>
                        </li>
                        <li class="collection-header">
                            <h5 class="light blue-text">Campos vacíos</h5>
                            <div class="row">
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group14" type="checkbox" id="faltaNumeroIdentidad" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta número de identidad" for="faltaNumeroIdentidad">Falta número de identidad</label>
                                    </p>
                                    <label for="group14" id="grou14-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group15" type="checkbox" id="faltaNombreApellido" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta nombre y/o apellido" for="faltaNombreApellido">Falta nombre y/o apellido</label>
                                    </p>
                                    <label for="group15" id="group15-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group50" type="checkbox" id="faltaEstadoCivil" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta estado civil" for="faltaEstadoCivil">Falta estado civil</label>
                                    </p>
                                    <label for="group50" id="group50-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group51" type="checkbox" id="faltaLugarNacimiento" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta lugar de nacimiento" for="faltaLugarNacimiento">Falta lugar de nacimiento</label>
                                    </p>
                                    <label for="group51" id="group51-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group52" type="checkbox" id="noTraeArrendatario" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="No trae datos del arrendatario" for="noTraeArrendatario">No trae datos del arrendatario</label>
                                    </p>
                                    <label for="group52" id="group52-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group53" type="checkbox" id="faltaNombreColonia" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta nombre de la colonia" for="faltaNombreColonia">Falta nombre de la colonia</label>
                                    </p>
                                    <label for="group53" id="group53-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group54" type="checkbox" id="faltaPuntoReferencia" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta punto de referencia" for="faltaPuntoReferencia">Falta punto de referencia</label>
                                    </p>
                                    <label for="group54" id="group54-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group55" type="checkbox" id="faltaTiempoNegocio" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta tiempo de tener el negocio" for="faltaTiempoNegocio">Falta tiempo de tener el negocio</label>
                                    </p>
                                    <label for="group55" id="group55-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group56" type="checkbox" id="faltaLineaBase" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta línea base" for="faltaLineaBase">Falta línea base</label>
                                    </p>
                                    <label for="group56" id="group56-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group57" type="checkbox" id="faltaLugarTrabajo" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta lugar de trabajo" for="faltaLugarTrabajo">Falta lugar de trabajo</label>
                                    </p>
                                    <label for="group57" id="group57-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group58" type="checkbox" id="faltaEdad" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta la Edad" for="faltaEdad">Falta edad</label>
                                    </p>
                                    <label for="group58" id="group58-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group59" type="checkbox" id="faltaIngresoBruto" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Falta la Edad" for="faltaIngresoBruto">Falta ingreso bruto</label>
                                    </p>
                                    <label for="group59" id="group59-error" class=" error-checkboxbutton error"></label>
                                </div>
                            </div>
                            <br>
                        </li>
                        <li class="collection-header">
                            <h5 class="light blue-text">Errores en la documentación</h5>
                            <div class="row">
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group21" type="checkbox" id="croquisNoSeEntiende" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Croquis Impreciso" for="croquisNoSeEntiende">Croquis Impreciso</label>
                                    </p>
                                    <label for="group21" id="group21-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group18" type="checkbox" id="copiasDocumentosNoCorrespondenDueno" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Copias de documentos no corresponden al dueño" for="copiasDocumentosNoCorrespondenDueno">Copias de documentos no corresponden al dueño</label>
                                    </p>
                                    <label for="group18" id="group18-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group22" type="checkbox" id="documentosManchados" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Solicitud o copias adjuntas manchados" for="documentosManchados">Solicitud o copias adjuntas manchados</label>
                                    </p>
                                    <label for="group22" id="group22-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group24" type="checkbox" id="documentosIlegibles" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Copias de documentos ilegibles" for="documentosIlegibles">Copias de documentos ilegibles</label>
                                    </p>
                                    <label for="group24" id="group24-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group28" type="checkbox" id="recibosDesactualizados" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Recibos públicos desactualizados" for="recibosDesactualizados">Recibos públicos desactualizados</label>
                                    </p>
                                    <label for="group28" id="group28-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group33" type="checkbox" id="desconoceNombreReciboPublico" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="No sabe a nombre de quien aparece la copia del recibo público" for="desconoceNombreReciboPublico">No sabe a nombre de quien aparece la copia del recibo público</label>
                                    </p>
                                    <label for="group33" id="group33-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="otro" type="checkbox" id="gestorNoConcuerda" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="El gestor de la solicitud no concuerda con el sistema" for="gestorNoConcuerda">El gestor de la solicitud no concuerda con el sistema</label>
                                    </p>
                                    <label for="otro" id="otro-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="otronombre" type="checkbox" id="supervisorNoConcuerda" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="El supervisor de la solicitud no concuerda con el sistema" for="supervisorNoConcuerda">El supervisor de la solicitud no concuerda con el sistema</label>
                                    </p>
                                    <label for="otronombre" id="otronombre-error" class=" error-checkboxbutton error"></label>
                                </div>
                            </div>
                            <br>
                        </li>
                        <li class="collection-header">
                            <h5 class="light blue-text">Inconsistencias procedimentales</h5>
                            <div class="row">
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group14" type="checkbox" id="familiaresParientes" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Son familiares o parientes" for="familiaresParientes">Son familiares o parientes</label>
                                    </p>
                                    <label for="group14" id="grou14-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group17" type="checkbox" id="noSeConocenCompañerosCicloI" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="No se conocen los compañeros (Ciclo I)" for="noSeConocenCompañerosCicloI">No se conocen los compañeros (Ciclo I)</label>
                                    </p>
                                    <label for="group17" id="group17-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group18" type="checkbox" id="sonAmbulantes" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Son ambulantes" for="sonAmbulantes">Son ambulantes</label>
                                    </p>
                                    <label for="group18" id="group18-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding">
                                    <p>
                                        <input name="group20" type="checkbox" id="nombreRevisionNoConcuerdaDueno" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Dueño del taxi no concuerda con el reportado" for="nombreRevisionNoConcuerdaDueno">Dueño del taxi no concuerda con el reportado</label>
                                    </p>
                                    <label for="group20" id="group20-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group25" type="checkbox" id="cortoLlamada" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Cortó la llamada" for="cortoLlamada">Cortó la llamada</label>
                                    </p>
                                    <label for="group25" id="group25-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group27" type="checkbox" id="incongruenciasInformacionNegocios" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Incongruencias al solicitar información de los negocios" for="incongruenciasInformacionNegocios">Incongruencias al solicitar información de los negocios</label>
                                    </p>
                                    <label for="group27" id="group27-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group29" type="checkbox" id="mismaActividadEconomica" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Misma actividad económica" for="mismaActividadEconomica">Misma actividad económica</label>
                                    </p>
                                    <label for="group29" id="group29-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group31" type="checkbox" id="incumplimientoZonificacion" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Incumplimiento de zonificación" for="incumplimientoZonificacion">Incumplimiento de Zonificación</label>
                                    </p>
                                    <label for="group31" id="group31-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group32" type="checkbox" id="informacionIntercambiada" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Información de solicitudes intercambiada entre beneficiarios" for="informacionIntercambiada">Información de solicitudes intercambiada entre beneficiarios</label>
                                    </p>
                                    <label for="group32" id="group32-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group34" type="checkbox" id="faltaBeneficiarioGrupo" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Hacen falta beneficiarios en el grupo" for="faltaBeneficiarioGrupo">Hacen falta beneficiarios en el grupo</label>
                                    </p>
                                    <label for="group34" id="group34-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group35" type="checkbox" id="beneficiariosDeMas" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Beneficiarios de la solicitud no concuerdan con el sistema" for="beneficiariosDeMas">Beneficiarios de la solicitud no concuerdan con el sistema</label>
                                    </p>
                                    <label for="group35" id="group35-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group36" type="checkbox" id="varonCiudadMujer" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="El crédito tiene un beneficiario varón (Ciudad Mujer)" for="varonCiudadMujer">El crédito tiene un beneficiario varón (Ciudad Mujer)</label>
                                    </p>
                                    <label for="group36" id="group36-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group60" type="checkbox" id="inquilinosBeneficiarios" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Son inquilinos los beneficiarios del grupo" for="inquilinosBeneficiarios">Son inquilinos los beneficiarios del grupo</label>
                                    </p>
                                    <label for="group60" id="group60-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group70" type="checkbox" id="integrantesEmprendedores" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Los integrantes del grupo son emprendedores" for="integrantesEmprendedores">Los integrantes del grupo son emprendedores</label>
                                    </p>
                                    <label for="group70" id="group70-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group91" type="checkbox" id="actividadEconomicaInvalida" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Actividad económica inválida" for="actividadEconomicaInvalida">Actividad económica inválida</label>
                                    </p>
                                    <label for="group91" id="group91-error" class=" error-checkboxbutton error"></label>
                                </div>
                            </div>
                            <br>
                        </li>
                        <li class="collection-header">
                            <h5 class="light blue-text">Cancelados por petición</h5>
                            <div class="row">
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group30" type="checkbox" id="canceladoPeticionBeneficiario" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Crédito cancelado a petición del beneficiario" for="canceladoPeticionBeneficiario">Cancelado a petición del beneficiario</label>
                                    </p>
                                    <label for="group30" id="group30-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group26" type="checkbox" id="devueltoSupervisor" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Devuelto a petición del Supervisor" for="devueltoSupervisor">Devuelto a petición del Supervisor</label>
                                    </p>
                                    <label for="group26" id="group26-error" class=" error-checkboxbutton error"></label>
                                </div>
                                <div class="input-field col s12 m6 l6 grey-text truncate no-margin no-padding truncate">
                                    <p>
                                        <input name="group26" type="checkbox" id="devueltoSupervisor" class="required checkbox-checklist" />
                                        <label class="tooltipped black-text" data-position="bottom" data-delay="50" data-tooltip="Devuelto a petición del Supervisor" for="devueltoSupervisor">Cancelado a petición del Coordinador</label>
                                    </p>
                                    <label for="group26" id="group26-error" class=" error-checkboxbutton error"></label>
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
        <div class="modal-footer">
            <a id="btn-observacion-call-center" href="#!" class="btn-flat waves-effect waves-green blue-text left">Observación</a>
            <a id="btn-guardar-verificado-call-center" href="#!" class=" modal-action waves-effect waves-green btn-flat blue-text">Verificar</a>
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

    //Agrega el campo de observación personalizado de Call Center
    $('#agregar-observacion-call-center').click(function(){
        
        let newelem = $('#clon').clone();
        newelem.toggle();
        newelem.removeAttr('id');
        $('#nodopadre').append(newelem);
        asignarEventosEliminar();
        /*Materialize.toast('Agregado', 2000);*/
                
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
                    url: '../php/super-digitador/verificar-call-center.php',
                    data: 'data='+JSON.stringify(window.grupos),
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
            //console.log(cantidadVerificados);
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
    
    $('#btn-guardar-verificado-call-center').click(function(){
        
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
            
            if(item.hasClass('error-observ')){
                
                tieneError = true;
                return false;
                
            }else{
                
                if(item.hasClass('warning-observ')){
                
                    tieneWarning = true;
                
                }else if(item.hasClass('success-observ')){

                    tieneSuccess = true;

                }
                
            }
            
        });
        
        //Si el grupo tiene al menos un crédito se asigna el icono de error
            
        if(tieneError){

            $('#'+window.liactive).find('#alert-icon').removeClass('warning-observ');
            $('#'+window.liactive).find('#alert-icon').removeClass('success-observ');
            $('#'+window.liactive).find('#alert-icon').addClass('error-observ');
            window.grupos[window.currentids.parent].con_error = true;
            //Materialize.toast('Tiene Error', 2000);

        }else if(!tieneWarning){

            if(tieneSuccess){

                $('#'+window.liactive).find('#alert-icon').removeClass('warning-observ');
                $('#'+window.liactive).find('#alert-icon').removeClass('error-observ');
                $('#'+window.liactive).find('#alert-icon').addClass('success-observ');
                window.grupos[window.currentids.parent].con_error = false;
                //Materialize.toast('Tiene Success', 2000);

            }

        }

        // Recorremos todos los objetos para encontrar el actual y asignarle verificado
        $.each(window.grupos, function(index, value){
            if(value.hash == window.liactive){
                value.verificado = true;
            }
        });

        $('#modal-observaciones').modal('close');
        
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
        
        // swal("Deleted!", "Your imaginary file has been deleted.", "success");
        var obj = {
            idcredito: auxthis.parent().parent().find('#id_credito').val(),
            hash: auxthis.parent().parent().find('#grupo-hash').val(),
            estado_credito: 'Call Center'
        }
        
        var registrarEnBitacora = function(o){
            $.ajax({
                type: 'POST',
                url: '../php/registrar-bitacora.php',
                data: 'data='+JSON.stringify(o),
                success: function(data){
                    Materialize.toast('Registrado', 2000);
                }
            });
        }
        
        // Si el beneficiario ya había contestado, se abre el modal inmediatamente
        if(auxthis.parent().parent().find('#contesto_counter').val() > 0){
            $('#modal-observaciones').modal('open');
            return false;
        }
        
        // Si el beneficiario no ha contestado por más de 3 veces se devuelve el crédito
        if(auxthis.parent().parent().find('#nocontesto_counter').val() > 2){
            
            // Asignamos iconos y registramos en el objeto principal
            auxthis.parent().parent().find('#icon').removeClass('warning-observ').addClass('error-observ');
            $('#'+auxthis.parent().parent().find('#grupo-hash').val()).find('#alert-icon').removeClass('warning-observ').addClass('error-observ');
            
            console.log(auxthis.parent().parent().find('#grupo-hash').val());
            
            window.grupos[window.currentids.parent].con_error = true;
            window.grupos[window.currentids.parent].verificado = true;
            
            window.grupos[window.currentids.parent].beneficiarios[window.currentids.child].checklist.push({

                id: 'noContesto',
                checked: true,
                text: 'El beneficiario no contestó luego de 3 intentos'

            });
            
            swal('Error', 'El beneficiario no ha contestado en 3 ocasiones, el crédito será devuelto', 'error');
            
            return false;
            
        }

        swal({
            title: "Realice la llamada al beneficiario",
            text: "¿Contestó el beneficiario?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí Contestó",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: false
        },
        function(contesto){
            
            if(contesto){

                // Asignamos 1 en el input hidden que contiene el registro de que si contestó
                auxthis.parent().parent().find('#contesto_counter').val(1);

                // Guardamos en la bitácora el hecho
                obj.razon = 'Contesto la llamada';
                obj.observacion = 'El beneficiario contestó la llamada';
                registrarEnBitacora(obj);
                $('#modal-observaciones').modal('open');
                
            }else{
                
                swal({
                    title: "Confirmación",
                    text: "Se registrará en la bitácora que el beneficiario no contestó.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Si, Confirmar",
                    cancelButtonText: "Cancelar"
                },
                function(){
                    
                    // Incrementamos en 1 el input hidden que contiene la cantidad de llamadas
                    let val = parseInt(auxthis.parent().parent().find('#nocontesto_counter').val()) + 1;
                    auxthis.parent().parent().find('#nocontesto_counter').val(val);

                    // Guardamos en la bitácora el hecho
                    obj.razon = 'No Contesto la llamada';
                    obj.observacion = 'El beneficiario no contestó la llamada';
                    registrarEnBitacora(obj);
                    
                });
                
            }
            
        });
        
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
    
}); //FINALIZA DOCUMENT.READY

/*
Función para inicializar el objeto principal que contendrá la información de todos los grupos y sus checklist
*/
    
function initEmptyObject(){
    
    window.grupos = [];
    
    $('#breadcrum-parent').text('Call Center');
    $('#breadcrum-title').text('Verificación de Créditos');
    
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
    
    //console.log(window.grupos);
    
}
    
</script>