<?php

    require '../php/conection.php';
    session_start();
    //Captura de los datos que se mostrarán en la ventana
    $stat = $conn->prepare('select distinct a.grupo_solidario_hash, a.Grupo_Solidario, a.gestor, a.Estatus_Prestamo, a.ciclo, b.iddepartamento as Departamento, get_agencia(a.gestor, a.agencia) as agencia, c.idMunicipio as Municipio, a.Fecha_Procesamiento 
        from cartera_consolidada a left join departamento b on a.Departamento = b.nombre left join municipio c on (a.Municipio = c.nombre and c.iddepartamento = b.iddepartamento) where Estatus_Prestamo = "Digitacion" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.') order by digitado desc');
    $stat->execute();
    $grupos = $stat->fetchAll();

    //Stat para capturar los beneficiarios de cada grupo
    $stat = $conn->prepare('select id, identidad, nombre, Fecha_Solicitud, Lugar_Nacimiento, Estado_Civil, 
        Telefono, Telefono2, tipodevivienda, Direccion_Domicilio, alquilacasa, nombre_propietario, telefono_propietario,
        `Sector_Económico` as sector_economico, `Actividad_Económica` as actividad_economica, Tipo_Cliente, Direccion_Negocio, 
        `Direccion Ref1` as direccionref1, `Direccion Ref2` as direccionref2, `Direccion Ref3` as direccionref3, `Direccion Ref4` as direccionref4,
        `Nombre Ref1` as nombreref1, `Nombre Ref2` as nombreref2, `Nombre Ref3` as nombreref3, `Nombre Ref4` as nombreref4,
        `Parentesco Ref1` as parentescoref1, `Parentesco Ref2` as parentescoref2, `Parentesco Ref3` as parentescoref3, `Parentesco Ref4` as parentescoref4,
        `Telefono Ref1` as telefonoref1, `Telefono Ref2` as telefonoref2, `Telefono Ref3` as telefonoref3, `Telefono Ref4` as telefonoref4, digitado,
        NombreAval, TelefonoAval, IdentidadAval, DireccionAval
        from cartera_consolidada 
        where Estatus_Prestamo = "Digitacion" and grupo_solidario_hash = :hash');

    $stat_censo = $conn3->prepare('select * from censo where identidad = :id');

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
            
            $stat_censo->bindValue(':id', $beneficiario['identidad']);
            $stat_censo->execute();
            $persona = $stat_censo->fetch(PDO::FETCH_ASSOC);
            
            $beneficiario['primer_nombre'] = $persona['primerNombre'];
            $beneficiario['segundo_nombre'] = $persona['segundoNombre'];
            $beneficiario['primer_apellido'] = $persona['primerApellido'];
            $beneficiario['segundo_apellido'] = $persona['segundoApellido'];
            $beneficiario['fecha_nacimiento'] = $persona['fechaNacimiento'];
            $beneficiario['genero'] = ($persona['codigoSexo'] == 1) ? 'M' : 'F';
            
            $benef[] = $beneficiario;
            $cant++;
        }
        
        $grupos_beneficiarios[] = [
            'hash' => $grupo['grupo_solidario_hash'],
            'nombre_grupo' => $grupo['Grupo_Solidario'],
            'gestor' => $grupo['gestor'],
            'fecha_procesamiento' => $grupo['Fecha_Procesamiento'],
            'estatus_prestamo' => $grupo['Estatus_Prestamo'],
            'ciclo' => $grupo['ciclo'],
            'departamento' => $grupo['Departamento'],
            'agencia' => $grupo['agencia'],
            'municipio' => $grupo['Municipio'],
            'cantidad_beneficiarios' => $cant,
            'beneficiarios' => $benef
        ];
        
    }

    //Seleccionamos los gestores unicos cuyos creditos están en estado call center para el filtro por gestor
    $stat = $conn->prepare('select distinct gestor from cartera_consolidada where Estatus_Prestamo = "Digitacion" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');
    $stat->execute();
        
    $gestores = $stat->fetchAll();
?>

<style>

.caret {
    margin-top: 18px !important;
    margin-bottom: 18px !important;
}

.select-wrapper {
    height: 66px !important;
}

.input-field {
    height: 88px !important;
}

input:not([type]):disabled, input:not([type])[readonly="readonly"], input[type=text]:disabled, input[type=text][readonly="readonly"], input[type=password]:disabled, input[type=password][readonly="readonly"], input[type=email]:disabled, input[type=email][readonly="readonly"], input[type=url]:disabled, input[type=url][readonly="readonly"], input[type=time]:disabled, input[type=time][readonly="readonly"], input[type=date]:disabled, input[type=date][readonly="readonly"], input[type=datetime]:disabled, input[type=datetime][readonly="readonly"], input[type=datetime-local]:disabled, input[type=datetime-local][readonly="readonly"], input[type=tel]:disabled, input[type=tel][readonly="readonly"], input[type=number]:disabled, input[type=number][readonly="readonly"], input[type=search]:disabled, input[type=search][readonly="readonly"], textarea.materialize-textarea:disabled, textarea.materialize-textarea[readonly="readonly"] {
    color: rgba(0, 0, 0, 0.8) !important;
    cursor: not-allowed !important;
}

input {
    color: rgba(0, 0, 0, 0.8) !important;
}

li.tab.current a{
    color: #2196f3 !important;
    border-bottom: 1px solid #2196f3 !important;
}

li.tab.current a:focus {
    outline: none;
}

li.disabled.tab a{
    color: rgba(0, 0, 0, 0.5) !important;
}

li.tab.done a{
    color: #0D47A1 !important;
    border-bottom: 1px solid #0D47A1 !important;
}

</style>

<div class="section">
    <div class="row">
        <div class="col s12 l4">
            <div class="row" id="beneficiarios-list" data-target="red">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content" id="list-grupos-digitados">
                            <span class="card-title">Buscar Grupos</span>
                            <div class="row">
                                <div class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input placeholder="Buscar Hash" id="buscarHas" type="text" class="validate fuzzy-search">
                                            <label for="buscarHas" class="active">Buscar hash</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form>
                                <ul class="collapsible z-depth-0 list" data-collapsible="accordion">

                                    <?php if(sizeof($grupos_beneficiarios) != 0):?>

                                        <?php $i = 1;?>

                                        <?php foreach($grupos_beneficiarios as $grupo):?>

                                            <li class="grupo-digitado" id="grupo-digitado-<?php echo $i;?>">
                                                <div class="sin-icon collapsible-header btn-elegir-grupo">
                                                    <div class="row">
                                                        <div class="col s2 m2 l2">
                                                            <i class="material-icons amber-text" id="notice-icon">warning</i>
                                                        </div>
                                                        <div class="col s2 m2 l2 hashg amber-text" id="grupo_hash"><?php echo $grupo['hash']; ?></div>
                                                        <div class="col s6 m6 l6 nombreg truncate" id="nombre_grupo"><?php echo $grupo['nombre_grupo']; ?></div>
                                                        <div class="col s6 m6 l2 truncate"><i class="material-icons blue-text">forward</i></div>
                                                    </div>

                                                </div>
                                                <div class="collapsible-body">
                                                    <div class="row margin">
                                                        <fieldset>
                                                            <legend class="grey-text">Beneficiarios</legend>
                                                            <table id="tabla-verificar-call-center" class="">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="grey-text" data-field="id">Nombre</th>
                                                                        <th class="grey-text" data-field="id">Identidad</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php foreach($grupo['beneficiarios'] as $beneficiario):?>

                                                                        <tr class="beneficiario-row beneficiario-en-grupo" id="beneficiario<?php echo $beneficiario['id']; ?>">
                                                                            <td class="grey-text global-beneficiario-nombre">
                                                                                <a href="#!" class="" id="nombre_completo"><?php echo $beneficiario['nombre'];?></a>
                                                                            </td>
                                                                            <td class="grey-text global-beneficiario-identidad" id="td-identidad"><?php echo $beneficiario['identidad'];?></td>
                                                                            <input type="hidden" class="hidden-val" id="idcredito" value="<?php echo $beneficiario['id'];?>"> 
                                                                            <input type="hidden" class="hidden-val" id="identidad" value="<?php echo $beneficiario['identidad']; ?>">
                                                                            <input type="hidden" class="hidden-val" id="primernombre" value="<?php echo $beneficiario['primer_nombre'];?>">
                                                                            <input type="hidden" class="hidden-val" id="segundonombre" value="<?php echo $beneficiario['segundo_nombre'];?>">
                                                                            <input type="hidden" class="hidden-val" id="primerapellido" value="<?php echo $beneficiario['primer_apellido'];?>">
                                                                            <input type="hidden" class="hidden-val" id="segundoapellido" value="<?php echo $beneficiario['segundo_apellido'];?>">
                                                                            <input type="hidden" class="hidden-val" id="nombregrupo" value="<?php echo $grupo['nombre_grupo']; ?>">
                                                                            <input type="hidden" class="hidden-val" id="ciclo" value="<?php echo $grupo['ciclo']; ?>">
                                                                            <input type="hidden" class="hidden-val" id="hash" value="<?php echo $grupo['hash']; ?>">
                                                                            <input type="hidden" class="hidden-val" id="departamento" value="<?php echo $grupo['departamento']; ?>">
                                                                            <input type="hidden" class="hidden-val" id="municipio" value="">
                                                                            <input type="hidden" class="hidden-val" id="aldea" value="">
                                                                            <input type="hidden" class="hidden-val" id="caserio" value="">
                                                                            <input type="hidden" class="hidden-val" id="barrio" value="">
                                                                            <input type="hidden" class="hidden-val" id="fechadenacimiento" value="<?php echo $beneficiario['fecha_nacimiento'];?>">
                                                                            <input type="hidden" class="hidden-val" id="sexo" value="<?php echo $beneficiario['genero'];?>">
                                                                            <input type="hidden" class="hidden-val" id="fechadesolicitud" value="<?php echo $beneficiario['Fecha_Solicitud'];?>">
                                                                            <input type="hidden" class="hidden-val" id="lugardenacimiento" value="<?php echo $beneficiario['Lugar_Nacimiento'];?>">
                                                                            <input type="hidden" class="hidden-val" id="estadocivil" value="<?php echo $beneficiario['Estado_Civil'];?>">
                                                                            <input type="hidden" class="hidden-val" id="telefono" value="<?php echo $beneficiario['Telefono'];?>">
                                                                            <input type="hidden" class="hidden-val" id="celular" value="<?php echo $beneficiario['Telefono2'];?>">
                                                                            <input type="hidden" class="hidden-val" id="tipodevivienda" value="<?php echo $beneficiario['tipodevivienda'];?>">
                                                                            <input type="hidden" class="hidden-val" id="puntodereferencia" value="<?php echo $beneficiario['Direccion_Domicilio'];?>">
                                                                            <input type="hidden" class="hidden-val" id="alquilacasa" value="<?php echo $beneficiario['alquilacasa'];?>">
                                                                            <input type="hidden" class="hidden-val" id="nombrepropietario" value="<?php echo $beneficiario['nombre_propietario'];?>">
                                                                            <input type="hidden" class="hidden-val" id="telefonopropietario" value="<?php echo $beneficiario['telefono_propietario'];?>">
                                                                            <input type="hidden" class="hidden-val" id="sectoreconomico" value="<?php echo $beneficiario['sector_economico'];?>">
                                                                            <input type="hidden" class="hidden-val" id="actividadeconomica" value="<?php echo $beneficiario['actividad_economica'];?>">
                                                                            <input type="hidden" class="hidden-val" id="tipodecliente" value="<?php echo $beneficiario['Tipo_Cliente'];?>">
                                                                            <input type="hidden" class="hidden-val" id="puntodereferencianegocio" value="<?php echo $beneficiario['Direccion_Negocio'];?>">
                                                                            <input type="hidden" class="hidden-val" id="email" value="">
                                                                            <input type="hidden" class="hidden-val" id="direccionref1" value="<?php echo $beneficiario['direccionref1'];?>">
                                                                            <input type="hidden" class="hidden-val" id="direccionref2" value="<?php echo $beneficiario['direccionref2'];?>">
                                                                            <input type="hidden" class="hidden-val" id="direccionref3" value="<?php echo $beneficiario['direccionref3'];?>">
                                                                            <input type="hidden" class="hidden-val" id="direccionref4" value="<?php echo $beneficiario['direccionref4'];?>">
                                                                            <input type="hidden" class="hidden-val" id="departamentonegocio" value="">
                                                                            <input type="hidden" class="hidden-val" id="municipionegocio" value="">
                                                                            <input type="hidden" class="hidden-val" id="aldeanegocio" value="">
                                                                            <input type="hidden" class="hidden-val" id="caserionegocio" value="">
                                                                            <input type="hidden" class="hidden-val" id="barrionegocio" value="">
                                                                            <input type="hidden" class="hidden-val" id="nombreref1" value="<?php echo $beneficiario['nombreref1'];?>">
                                                                            <input type="hidden" class="hidden-val" id="nombreref2" value="<?php echo $beneficiario['nombreref2'];?>">
                                                                            <input type="hidden" class="hidden-val" id="nombreref3" value="<?php echo $beneficiario['nombreref3'];?>">
                                                                            <input type="hidden" class="hidden-val" id="nombreref4" value="<?php echo $beneficiario['nombreref4'];?>">
                                                                            <input type="hidden" class="hidden-val" id="parentescoref1" value="<?php echo $beneficiario['parentescoref1'];?>">
                                                                            <input type="hidden" class="hidden-val" id="parentescoref2" value="<?php echo $beneficiario['parentescoref2'];?>">
                                                                            <input type="hidden" class="hidden-val" id="parentescoref3" value="<?php echo $beneficiario['parentescoref3'];?>">
                                                                            <input type="hidden" class="hidden-val" id="parentescoref4" value="<?php echo $beneficiario['parentescoref4'];?>">
                                                                            <input type="hidden" class="hidden-val" id="telefonoref1" value="<?php echo $beneficiario['telefonoref1'];?>">
                                                                            <input type="hidden" class="hidden-val" id="telefonoref2" value="<?php echo $beneficiario['telefonoref2'];?>">
                                                                            <input type="hidden" class="hidden-val" id="telefonoref3" value="<?php echo $beneficiario['telefonoref3'];?>">
                                                                            <input type="hidden" class="hidden-val" id="telefonoref4" value="<?php echo $beneficiario['telefonoref4'];?>">
                                                                            <input type="hidden" class="hidden-val" id="digitado" value="<?php echo $beneficiario['digitado'];?>">
                                                                            <input type="hidden" class="hidden-val" id="nombreaval" value="<?php echo $beneficiario['NombreAval'];?>">
                                                                            <input type="hidden" class="hidden-val" id="identidadaval" value="<?php echo $beneficiario['IdentidadAval'];?>">
                                                                            <input type="hidden" class="hidden-val" id="telefonoaval" value="<?php echo $beneficiario['TelefonoAval'];?>">
                                                                            <input type="hidden" class="hidden-val" id="direccionaval" value="<?php echo $beneficiario['DireccionAval'];?>">
                                                                        </tr>

                                                                    <?php endforeach;?>

                                                                </tbody>
                                                            </table><br>
                                                                <div class="row">
                                                                    <div class="col l12 center">
                                                                        <a href="#!" modal-trigger class="waves-effect waves-green btn-flat green white-text center" id="btn-guardar-grupo">Guardar</a>
                                                                    </div>
                                                                </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </li>

                                            <?php $i++;?>

                                        <?php endforeach;?>

                                    <?php else:?>

                                        <li>
                                            <div class="sin-icon collapsible-header active">
                                                <div class="row">
                                                    <div class="col s12 m12 l12">
                                                        <h5>No hay grupos</h5>
                                                    </div>
                                                </div>

                                            </div>
                                        </li>

                                    <?php endif;?>

                                </ul>
                                <ul id="pag-control" class="pag pagination">
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l8">
            <div class="card" id="card-input">
                <div class="card-content">
                    <form id="example-advanced-form" action="#">
                        <div class="">
                            <br>
                            <h3>Datos Personales</h3>
                            <section>
                                <div class="wizard-content no-padding">
                                    <!--Fecha, Ciclo y Nombre de Grupo STAR-->
                                    <div class="row">

                                        <div class="col l12 m12 s12">
                                            <h5 class="light">Datos del Crédito</h5>
                                        </div>

                                        <div class="input-field col s12 m12 l6 grey-text">
                                            <label for="input-fechadesolicitud" class="active">Fecha de Solicitud</label>
                                            <input placeholder="Fecha" id="input-fechadesolicitud" type="date" name="input-fechadesolicitud" class="required input-element">
                                        </div>

                                        <div class="input-field col s12 m12 l6 grey-text">
                                            <label for="input-ciclo" class="active">Ciclo</label>
                                            <input placeholder="Ciclo" id="input-ciclo" type="text" name="input-ciclo" class="required input-element">
                                        </div>

                                        <div class="input-field col s12 m12 l6 grey-text">
                                            <label for="input-nombregrupo" class="active">Nombre del Grupo</label>
                                            <input placeholder="Nombre del Grupo" id="input-nombregrupo" type="text" name="input-nombregrupo" class="required input-element">
                                            <input type="hidden" name="" id="input-hash" class="input-element">
                                        </div>

                                        <div class="col s12 m12 l12">
                                            <h5 class="light">Datos del Beneficiario</h5>
                                        </div>

                                        <div class="input-field col s12 m12 l6">
                                            <input placeholder="Primer Nombre" id="input-primernombre" type="text" name="pri_nombre" class="required input-element">
                                            <label for="pri_nombre" class="active">Primer Nombre</label>
                                        </div>

                                        <div class="input-field col s12 m12 l6">
                                            <input placeholder="Segundo Nombre" id="input-segundonombre" type="text" name="seg_nombre" class="input-element">
                                            <label for="seg_nombre" class="active">Segundo Nombre</label>
                                        </div>

                                        <div class="input-field col s12 m12 l6">
                                            <input placeholder="Primer Apellido" id="input-primerapellido" type="text" name="pri_apellido" class="required input-element">
                                            <label for="pri_apellido" class="active">Primer Apellido</label>
                                        </div>

                                        <div class="input-field col s12 m12 l6">
                                            <input placeholder="Segundo Apellido" id="input-segundoapellido" type="text" name="seg_apellido" class="input-element">
                                            <label for="seg_apellido" class="active">Segundo Apellido</label>
                                        </div>

                                        <div class="input-field col s12 m12 l6 grey-text">
                                            <label for="num_id" class="active">Número Identidad</label>
                                            <input placeholder="número de identidad" id="input-identidad" type="text" name="num_id" class="required input-element">
                                        </div>

                                        <div class="input-field col s12 m12 l6">
                                            <input placeholder="Lugar de Nacimiento" id="input-lugardenacimiento" type="text" class="required masked input-element">
                                            <label for="lugar_nacimiento" class="active" data-error="Campo vacío">Lugar de Nacimiento</label>
                                        </div>

                                        <div class="input-field col s12 m12 l6">
                                            <input placeholder="Fecha de Nacimiento" id="input-fechadenacimiento" type="text" class="masked input-element">
                                            <label for="fecha_nacimiento" class="active">Fecha de Nacimiento</label>
                                        </div>

                                        <div class="input-field col s12 m12 l6">
                                            <select class="grey-text input-element " name="estado_civil" id="input-estadocivil" required>
                                                <option value="" disabled selected>Seleccione el Estado Civil</option>
                                                <option value="C">Casado</option>
                                                <option value="S">Soltero</option>
                                                <option value="V">Viudo</option>
                                                <option value="UL">Unión Libre</option>
                                            </select>
                                            <label>Estado Civil</label>
                                            <!-- <label for="estado_civil" class="active" style="padding-top: 0px;">Estado Civil</label> -->
                                        </div>

                                        <div class="input-field col s12 m12 l6">
                                            <select class="grey-text input-element" id="input-sexo">
                                                <option value="" disabled selected>Seleccione el Sexo</option>
                                                <option value="M">Hombre</option>
                                                <option value="F">Mujer</option>
                                            </select>
                                            <label>Sexo</label>
                                        </div>

                                        <div class="col s12 m12 l12">
                                            <h5 class="light">Datos de Contacto</h5>
                                        </div>

                                        <div class="input-field col s12 m12 l6">
                                            <input placeholder="digíte el número de teléfono" id="input-telefono" name="tel_fijo" type="number" minlength="8" class="required masked input-element" data-inputmask="'mask': '9999-9999'">
                                            <label for="tel_fijo" class="active" data-error="Campo vacío">Teléfono Fijo</label>
                                        </div>

                                        <div class="input-field col s6">
                                            <input placeholder="digíte el número de celular" id="input-celular" name="tel_celular" type="number" minlength="8" class="required masked input-element" data-inputmask="'mask': '9999-9999'">
                                            <label for="tel_celular" class="active">Celular</label>
                                        </div>

                                        <div class="input-field col s6">
                                            <input placeholder="Correo Electrónico" id="input-email" type="email" name="dir_email" class="validate input-element">
                                            <label for="dir_email" data-error="escríba una dirección de correo valida" class="active">Email</label>
                                        </div>

                                    </div>
                                    <!--Telefono Fijo, Celular and Email END-->

                                </div>
                            </section>

                            <h3>Datos Domiciliares</h3>
                            <section>
                                <div class="wizard-content no-padding">
                                    <!--Departamento, municipio, colonia STAR-->
                                    <div>   
                                    <!-- <div id="dependency-select"> -->
                                        <div class="row">

                                            <div class="col s12 m12 l12">
                                                <h5 class="light">Ubicación del domicilio</h5>
                                            </div>

                                            <div class="input-field col s12 l6">
                                                <select id="input-departamento" class="input-element">
                                                    <option value="" disabled selected>Seleccione el Departamento</option>
                                                    <?php require '../php/select-departamento.php';?>
                                                </select>
                                                <label>Departamento</label>
                                            </div>

                                            <div class="input-field col s12 l6">
                                                <select id="input-municipio" class="input-element browser-default">
                                                    <!-- <option value="" disabled selected>Municipio</option> -->
                                                </select>
                                                <label class="active">Municipio</label>
                                            </div>

                                            <div class="input-field col s12 l6">
                                                 <select id="input-aldea" class="input-element browser-default">
                                                    <!-- <option value="" disabled selected>Aldea</option> -->
                                                </select>
                                                <label class="active">Aldea</label>
                                            </div>

                                            <div class="input-field col s12 l6">
                                               <select id="input-caserio" class="input-element browser-default">
                                                    <!-- <option value="" disabled selected>Caserío</option> -->
                                                </select>
                                                <label class="active">Caserío</label>
                                            </div>

                                            <div class="input-field col s12 l6">
                                                <select id="input-barrio" class="input-element browser-default">
                                                    <!-- <option value="" disabled selected>Barrio</option> -->
                                                </select>
                                                <label class="active">Barrio</label>
                                            </div>

                                            <div class="input-field col s12 l12">
                                                <label for="calle" class="active">Punto de Referencia</label>
                                                <input placeholder="punto De Referencia" id="input-puntodereferencia" type="text" name="puntoDeReferencia" class="required input-element">
                                            </div>

                                            <div class="col s12 m12 l12">
                                                <h5 class="light">Detalles de la vivienda</h5>
                                            </div>

                                            <div class="input-field col s12 l6">
                                                <select id="input-tipodevivienda" class="required input-element" required>
                                                    <option value="" disabled selected>Seleccione Tipo de Vivienda</option>
                                                    <?php require '../php/select-tipos-viviendas.php';?>
                                                </select>
                                                <label>Tipo de Vivienda</label>
                                            </div>

                                        </div>
                                        
                                    </div>
                                    <!--referencia END-->

                                    <!--si alquila?? STAR-->

                                </div>
                            </section>

                            <h3>Datos del Negocio</h3>
                            <section>
                                <div class="wizard-content no-padding">
                                    <div class="row">

                                        <div class="col s12 m12 l12">
                                            <h5 class="light">Ubicación del Negocio</h5>
                                        </div>

                                        <div class="input-field col l6 m12 s12">
                                            <!-- <input placeholder="Departamento" id="input-departamentonegocio" type="text" class="validate input-element" required> -->
                                            <select id="input-departamentonegocio" class="input-element">
                                                <option value="" disabled selected>Seleccione el Departamento</option>
                                                <?php require '../php/select-departamento.php';?>
                                            </select>
                                            <!-- <label>Departamento del Negocio</label> -->
                                        </div>
                                        <div class="input-field col l6 m12 s12">
                                            <!-- <input placeholder="zona/sector" id="input-municipionegocio" type="text" class="validate input-element" required> -->
                                            <select id="input-municipionegocio" class="input-element browser-default">
                                            </select>
                                            <label class="active">Municipio</label>
                                            <!-- <label>Municipio del Negocio</label> -->
                                        </div>
                                        <div class="input-field col l6 m12 s12">
                                            <select id="input-aldeanegocio" class="input-element browser-default">
                                            </select>
                                            <label class="active">Aldea</label>
                                            <!-- <label>Aldea del Negocio</label> -->
                                        </div>
                                        <div class="input-field col l6 m12 s12">
                                            <select id="input-caserionegocio" class="input-element browser-default">
                                            </select>
                                            <label class="active">Caserío</label>
                                            <!-- <label>Caserio del Negocio</label> -->
                                        </div>
                                        <div class="input-field col l6 m12 s12">
                                            <select id="input-barrionegocio" class="input-element browser-default">
                                            </select>
                                            <label class="active">Barrio</label>
                                            <!-- <label>Barrio del Negocio</label> -->
                                        </div>
                                        <div class="input-field col s12 l12">
                                            <label for="input-puntodereferencianegocio" class="active">Punto de Referencia</label>
                                            <input placeholder="punto De Referencia" id="input-puntodereferencianegocio" type="text" name="puntoDeReferencia" class="required input-element">
                                        </div>

                                        <div class="col s12 m12 l12">
                                            <h5 class="light">Detalles del Negocio</h5>
                                        </div>

                                        <div class="input-field col s6">
                                            <select id="input-sectoreconomico" class="input-element" required>
                                                <option value="" disabled selected>Seleccione sector económico</option>
                                                <option value="Produccion">Producción</option>
                                                <option value="Comercio">Comercio</option>
                                                <option value="Servicios">Servicios</option>
                                            </select>
                                            <label>Sector Económico</label>
                                        </div>

                                        <div class="input-field col s6">
                                            <input placeholder="Seleccione actividad económica" name="actividad-economica" id="input-actividadeconomica" type="text" class="input-element" required>
                                            <label for="actividad-economica" class="active">Actividad Económica</label>
                                        </div>

                                        <div class="input-field col s6">
                                            <select class="input-element" name="tipo-cliente" id="input-tipodecliente" required>
                                                <option value="" disabled selected >Seleccione el tipo de cliente</option>
                                                <option value="Microempresario" >Microempresario</option>
                                                <option value="Emprendedor">Emprendedor</option>
                                            </select>
                                            <label for="tipo-cliente">Tipo de Cliente</label>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </section>

                            <h3>Avales</h3>
                            <section>
                                <div class="wizard-content no-padding">

                                    <!--referencias familiar 1-->
                                    <div class="row">
                                        <div class="col s12 m12 l12">
                                            <h5 class="light">Datos del Aval</h5>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Nombre" id="input-nombreaval" name="nombreaval" type="text" class="input-element">
                                            <label for="nombreaval" class="active">Nombre Completo</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Identidad" id="input-identidadaval" name="identidadaval" type="text" class="input-element">
                                            <label for="identidadaval" class="active">identidad</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Teléfono" id="input-telefonoaval" name="telefonoaval" type="text" class="input-element">
                                            <label for="telefonoaval" class="active">Teléfono</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Dirección" id="input-direccionaval" name="direccionaval" type="text" class="input-element">
                                            <label for="direccionaval" class="active">Dirección</label>
                                        </div>
                                    </div>
                                    <!--referencias familiar 1-->

                                </div>
                            </section>

                            <h3>Referencias</h3>
                            <section>
                                <div class="wizard-content no-padding">

                                    <!--referencias familiar 1-->
                                    <div class="row">
                                        <div class="col s12 m12 l12">
                                            <h5 class="light">Familiar 1</h5>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Nombre" id="input-nombreref1" name="nombreref1" type="text" class="validate input-element" required>
                                            <label for="nombreref1" class="active">Nombre</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Parentesco" id="input-parentescoref1" name="parentescoref1" type="text" class="validate input-element" required>
                                            <label for="parentescoref1" class="active">Parentesco</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Dirección" id="input-direccionref1" name="direccionref1" type="text" class="validate input-element" required>
                                            <label for="direccionref1" class="active">Dirección</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Teléfono" id="input-telefonoref1" name="telefonoref1" type="text" class="validate input-element" required>
                                            <label for="telefonoref1" class="active">Teléfono</label>
                                        </div>
                                    </div>
                                    <!--referencias familiar 1-->

                                    <!--refencias familiar 2-->
                                    <div class="row">
                                        <div class="col s12 m12 l12">
                                            <h5 class="light">Familiar 2</h5>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Nombre" id="input-nombreref2" name="nombreref2" type="text" class="validate input-element" required>
                                            <label for="nombreref2" class="active">Nombre</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Parentesco" id="input-parentescoref2" name="parentescoref2" type="text" class="validate input-element" required>
                                            <label for="parentescoref2" class="active">Parentesco</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Dirección" id="input-direccionref2" name="direccionref2" type="text" class="validate input-element" required>
                                            <label for="direccionref2" class="active">Dirección</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Teléfono" id="input-telefonoref2" name="telefonoref2" type="text" class="validate input-element" required>
                                            <label for="telefonoref2" class="active">Teléfono</label>
                                        </div>
                                    </div>
                                    <!--refencias familiar 2-->

                                    <!--refencias personales 1-->
                                    <div class="row">
                                        <div class="col s12 m12 l12">
                                            <h5 class="light">Personal 1</h5>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Nombre" id="input-nombreref3" name="nombreref3" type="text" class="validate input-element" required>
                                            <label for="nombreref3" class="active">Nombre</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Parentesco" id="input-parentescoref3" name="parentescoref3" type="text" class="validate input-element" required>
                                            <label for="parentescoref3" class="active">Parentesco</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Dirección" id="input-direccionref3" name="direccionref3" type="text" class="validate input-element" required>
                                            <label for="direccionref3" class="active">Dirección</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Teléfono" id="input-telefonoref3" name="telefonoref3" type="text" class="validate input-element" required>
                                            <label for="telefonoref3" class="active">Teléfono</label>
                                        </div>
                                    </div>
                                    <!--refencias personales 1-->

                                    <!--refencias personales 2-->
                                    <div class="row">
                                        <div class="col s12 m12 l12">
                                            <h5 class="light">Personal 2</h5>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Nombre" id="input-nombreref4" name="nombreref4" type="text" class="validate input-element" required>
                                            <label for="nombreref4" class="active">Nombre</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Parentesco" id="input-parentescoref4" name="parentescoref4" type="text" class="validate input-element" required>
                                            <label for="parentescoref4" class="active">Parentesco</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Dirección" id="input-direccionref4" name="direccionref4" type="text" class="validate input-element" required>
                                            <label for="direccionref4" class="active">Dirección</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input placeholder="Teléfono" id="input-telefonoref4" name="telefonoref4" type="text" class="validate input-element" required>
                                            <label for="telefonoref4">Teléfono</label>
                                        </div>
                                    </div>
                                    <!--refencias personales 2-->

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

    <!--modal-content-editar-grupo-->
    <!-- Modal Structure -->
    <div id="modal-digitacion" class="modal modal-fixed-footer">
        <div class="modal-content modal-content-editar-grupo">
            <h5 class="light blue-text no-margin">Selección de Monto y Frecuencia de pago</h5>
            <div class="row">
                <div class="col l12 m12 s12">
                    <ul class="collection">
                        <li class="collection-item row">
                            <div class="col s12 l3">Nombre</div>
                            <div class="col s12 l2">Monto</div>
                            <div class="col s12 l2">Frecuencia Pago</div>
                            <div class="col s12 l2">Valor de Ahorro</div>
                            <div class="col s12 l3">IFI</div>
                        </li>
                        <div id="desembolso-data-beneficiarios">
                        </div>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l6">
                    <div class="input-field">
                        <select id="select-plazo-modal">
                            <option value="" disabled selected>Elige el Plazo</option>
                            <option value="6 MESES">6 Meses</option>
                            <option value="12 MESES">12 Meses</option>
                            <option value="18 MESES">18 Meses</option>
                            <option value="24 MESES">24 Meses</option>
                            <option value="36 MESES">36 Meses</option>
                            <option value="48 MESES">48 Meses</option>
                        </select>
                        <label>Plazo</label>
                    </div>
                </div>
                <div class="col s12 m6 l6">
                    <div class="input-field">
                        <input type="text" name="" id="obervacion">
                        <label for="obervacion">Observación</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action waves-effect waves-green btn-flat" id="modal-guardar">Guardar</a>
        </div>
    </div>
</div>

<li class="collection-item row clon beneficiario-en-modal" id="clon">
    <div class="input-field col s12 l3">
        <input disabled type="text" id="nombre" placeholder="Nombre">
    </div>
    <div class="input-field col s12 l2">
        <input type="text" id="monto" placeholder="Monto" class="valid">
    </div>
    <div class="input-field col s12 l2">
        <input type="text" id="frecuencia" placeholder="Frecuencia" class="valid">
    </div>
    <div class="input-field col s12 l2">
        <input type="text" id="valor" placeholder="Valor" class="valid">
    </div>
    <div class="input-field col s12 l3">
        <select id="ifi" class="browser-default select-ifi">
            <option value="" disabled selected>Elija una</option>
            <?php require '../php/select-ifis.php';?>
        </select>
    </div>
    <input type="hidden" id="idcredito">
    <input type="hidden" id="hash">
</li>

<!--plugin to STEPS-->
<script src="../js/steps/jquery.validate.js" type="text/javascript"></script>
<script src="../js/steps/jquery.steps.js" type="text/javascript"></script>
<script src="../js/steps/wizard.js" type="text/javascript"></script>

<script src="../js/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
<script src="../js/plugins/jquery-inputmask/form-input-mask.js"></script>
<script src="../js/plugins/dependency-select/dependency.select.js"></script>


<script>
    
    $(document).ready(function(){

        $("select[required]").css({display:"inline", height:0, padding:0, width:0, margin:0});

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
        
        $('.btn-elegir-grupo').click(function(){            
            $('#prev-instruct').find('#icon').html('description');
            $('#prev-instruct').find('#text-message').html('Seleccione un crédito para digitar');            
        });


        //<===================================================================================== EACH BENEFICIARIO EN GRUPO ================================================================>

        $('.beneficiario-en-grupo').each(function(){

            //Click a cada beneficiario en grupo
            $(this).find('#nombre_completo').click(function(){

                //INICIALIZACIÓN DE SELECTS 
                // $('#input-municipio').select2();
                // $('#input-municipionegocio').select2();
                // $('#input-aldea').select2();
                // $('#input-aldeanegocio').select2();
                // $('#input-caserio').select2();
                // $('#input-caserionegocio').select2();
                // $('#input-barrio').select2();
                // $('#input-barrionegocio').select2();
                
                if($(this).parent().parent().find('#digitado').val() == "1"){
                    return false;
                }

                // Obtenemos el padre del nombre completo
                var mainparent = $(this).parent().parent();
                
                // Obtenemos el objeto de datos que está en el objeto global de grupos digitados
                var dataObject = window.grupos_digitar[mainparent.find('#idcredito').val()];
                
                // Para cada elemento del dataObject, vamos a asignar valor en cada input respectivo
                $.each(dataObject, function(index, value){
                    var tag = $('#input-'+index).prop('tagName');
                    
                    // Asignamos el valor respectivo al input correspondiente
                    if (value != "") {
                        $('#input-'+index).val(value);
                        $('#input-'+index).attr("readonly","true");
                        $('#input-'+index).addClass('valid');
                        
                        //Si el tag es SELECT reiniciamos el select para definir el value
                        if(tag == "SELECT"){
                            $('#input-'+index+' option[value="'+dataObject.departamento+'"]').attr("selected", "selected");
                            $('#input-'+index).material_select();
                            $('#input-'+index).trigger('change');

                            $('#input-'+index).material_select('destroy');
                            $('#input-'+index).attr("disabled","true");
                            $('#input-'+index).val(value).material_select();
                            $('#input-'+index).addClass('valid');
                        } 
                    }else {
                        $('#input-'+index).val("");
                        $('#input-'+index).removeAttr('readonly');
                        $('#input-'+index).removeClass('valid');

                        if(tag == "SELECT"){
                            // console.log($('#input-'+index));
                        } 
                    }
                    
                });

                // console.log(dataObject);
                mainparent.parent().find('tr').removeClass('blue lighten-5');
                mainparent.addClass('blue lighten-5');
                
                window.currentGroup = mainparent.find('#hash').val();
                window.currentCredito = mainparent.find('#idcredito').val();

                // Ocultamos la ventana de notificacion
                $('#prev-instruct').fadeOut(200, function(){
                
                    // Mostramos el formulario de digitacion
                    $('#card-input').fadeIn(300);

                    //Focus en el campo vacio
                    // $('#input-fechadesolicitud').focus();                        

                });
                
                // Apagamos los collapsible, para evitar que el digitador cambie de grupo sin terminar la digitacion del actual 
                toggleCollapsible('off');

                $('#dependency-select').dependency_select();
            });

            $(this).find('#btn-guardar-grupo').off("click");            
        }); 
        //<--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->


        initObject();  


        asignarSelectListeners();
        
        var options = {
            page: 5,
            pagination: true,
            valueNames: [ 'hashg', 'nombreg' ],
            fuzzySearch: {
                searchClass: "fuzzy-search",
                location: 0,
                distance: 100,
                threshold: 0.2,
                multiSearch: true
            }
        };
        window.listObj = new List('list-grupos-digitados', options);

        //<================================================================================= CLICK MODAL-GUARDAR ===========================================================================>

        // Evento clic para el boton guardar del modal Verifica que todos los campos esten llenos y manda a llamar el ajax de guardar los datos

        $('#modal-guardar').click(function(e){

            var inputAux = true;
            
            $('#desembolso-data-beneficiarios').find('.beneficiario-en-modal').each(function(){
                $(this).find('input.valid').each(function(){
                    if($(this).val() == "" || $(this).val() == null){
                        inputAux = false;
                        return inputAux;
                    }
                });
                return inputAux;
            });
            
            if($('#select-plazo-modal option:selected').val() == "" || $('#select-plazo-modal option:selected').val() == null){
                inputAux = false;
            }
            
            if(!inputAux){
                swal('Error', 'No ha rellenado todos los campos.', 'error');
                return inputAux;
            }
            
            var data = {};
            
            $('#desembolso-data-beneficiarios').find('.beneficiario-en-modal').each(function(){
                
                var tempObject = {};
                
                $(this).find('input').each(function(){
                    tempObject[$(this).attr('id')] = $(this).val();
                });
                
                tempObject['plazo'] = $('#select-plazo-modal option:selected').val();
                tempObject['hash'] = $(this).find('#hash').val();
                tempObject['observ'] = $('#obervacion').val();
                tempObject['ifi'] = $(this).find('#ifi').val();
                
                data[$(this).find('#idcredito').val()] = tempObject;
                
            });
            
            $.ajax({
                type: 'POST',
                url: '../php/digitacion/cambiar-estado.php',
                data: 'data='+JSON.stringify(data),
                success: function(data){
                    console.log(data);
                    if (data == "Success") {
                        swal('Completo', 'Ha guardado los cambios.', 'success');
                        $('#modal-digitacion').modal('close');
                        $('#floating-refresh').trigger('click');
                    } else {
                        swal('Error en la conexión', 'No se pudo guardar, intentelo de nuevo mas tarde.', 'error');
                    }
                }                
            });
        });

    }); 
        //<================================================== <<<<<<<<<<<<<<<<<<<<<<<<<< FIN DEL DOCUMENT.READY >>>>>>>>>>>>>>>>>>>>>>>>>> ==================================================>








    //<================================================================================== INITOBJECT FUNCTION ==============================================================================>
    
    //                                   Inicializa el objeto principal de la ventana, que contiene los datos de todo el grupo Se manda a llamar desde el document.ready


    function initObject() { 

        window.grupos_digitar = {};
        
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
            
            emptyDataObject['digitado'] = false;
            
            var aux = {};
            
            $.each(emptyDataObject, (index, value) => {
                
                aux[index] = $(this).find('#'+index).val();
                
            });
            
            window.grupos_digitar[idcredito] = aux;
            
            //Si el beneficiario actual está digitado, lo marcamos como digitado
            if($(this).find('#digitado').val() == 1){ 
                
                $('#beneficiario'+idcredito).removeClass('blue lighten-5');
                $('#beneficiario'+idcredito).addClass('grey lighten-4');
                $('#beneficiario'+idcredito).find('#td-identidad').addClass('green-text');
                $('#beneficiario'+idcredito).find('#nombre_completo').addClass('green-text').on('click', function(e){
                    e.preventDefault();
                });
                
                //Cambiamos el icono del parent si todos los beneficiarios ya han sido digitados
                var todosDigitados = true;
                
                masterparent = $(this).parent().parent().parent().parent().parent().parent();
                masterparent.find('.beneficiario-en-grupo').each(function(){
                    
                    if($(this).find('#digitado').val() == "0"){
                        todosDigitados = false;
                    }
                    
                });
                var currenthash = $(this).find('#hash').val();
                
                //SI TODOS ESTAN DIGITADOS
                if(todosDigitados){
                    
                    masterparent.find('#grupo_hash').removeClass('amber-text').addClass('green-text');
                    masterparent.find('#notice-icon').removeClass('amber-text').addClass('green-text').html('done_all');
                    $(this).parent().parent().parent().find('#btn-guardar-grupo').removeClass('grey').addClass('green');
                    
                    $(this).parent().parent().parent().find('#btn-guardar-grupo').off('click').on('click', function(){

                        //Definida al final del archivo
                        saveButton(currenthash); 
                    });
                }
            }
        });
    }
    //<------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->




    //<=================================================================================== INITSTEPS FUNCTION ==============================================================================>
    
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

            onStepChanging: function (event, currentIndex, newIndex)
            {
                if (currentIndex > newIndex) {
                    return true;
                }

                $(elem).validate().settings.ignore = ":hidden";
                return $(elem).valid();
            },

            onFinishing: function (event, currentIndex)
            {          

                $(elem).validate().settings.ignore = ":hidden";
                if(!$(elem).valid()) 
                    return $(elem).valid();

                //Asignamos el valor respectivo al input correspondiente
                $.each(window.grupos_digitar[window.currentCredito], function(index, value){
                    
                    var tag = $('#input-'+index).prop('tagName');

                    if (value == "") {
                        window.grupos_digitar[window.currentCredito][index] = $('#input-'+index).val();                        
                    }                                            
                });                 

                window.grupos_digitar[window.currentCredito]['digitado'] = "1";
                // console.log(window.grupos_digitar[window.currentCredito]);
                //<=================================================================== Ajax para ingresar grupo digitado a la BD ===========================================================>
                window.grupos_digitar[window.currentCredito].idcredito = window.currentCredito;
                var json = JSON.stringify(window.grupos_digitar[window.currentCredito]);
                $.ajax({
                    url: '../php/digitacion/guardar-grupo.php',
                    type: 'POST',
                    data: 'data='+json,
                })
                .done(function(data) {
                    // var result = JSON.parse(data);    
                    console.log(data);
                    if (data == "Success") {
                        var grupoCompletado = true;
                        
                        $.each(window.grupos_digitar, function(index, value){
                            
                            if((value['hash'] == window.currentGroup) && value['digitado'] == "0"){
                                grupoCompletado = false;
                            }
                            if(!grupoCompletado) return grupoCompletado;
                        });
                        
                        //SI EL GRUPO ESTA COMPLETADO
                        if(grupoCompletado){
                            
                            var masterparent = $('#beneficiario'+window.currentCredito).parent().parent().parent().parent().parent().parent();
                            masterparent.find('#grupo_hash').removeClass('amber-text').addClass('green-text');
                            masterparent.find('#notice-icon').removeClass('amber-text').addClass('green-text').html('done_all');

                            toggleCollapsible('on');

                            masterparent.find('#btn-guardar-grupo').removeClass('grey').addClass('green');
                            
                            var currenthash = $('#beneficiario'+window.currentCredito).find('#hash').val();
                            
                            masterparent.find('#btn-guardar-grupo').click(function(){
                                
                                //Definida al final del archivo
                                saveButton(currenthash); 
                                
                            });                        
                        } 
                            
                        $('#beneficiario'+window.currentCredito).removeClass('blue lighten-5');
                        $('#beneficiario'+window.currentCredito).addClass('grey lighten-4');
                        $('#beneficiario'+window.currentCredito).find('#td-identidad').addClass('green-text');
                        $('#beneficiario'+window.currentCredito).find('#nombre_completo').addClass('green-text').off('click');
                        
                        $('#card-input').fadeOut(300, function(){
                            $('#prev-instruct').fadeIn(300);
                        });
                        
                        $(elem).children("div").steps('destroy');
                        initSteps(elem);                

                        $('.select2').each(function(){
                            $(this).remove();
                        });             
                        
                        asignarSelectListeners();
                        
                        $('#input-municipio').select2();
                        $('#input-aldea').select2();
                        $('#input-caserio').select2();
                        $('#input-barrio').select2();     
                        $('#input-municipionegocio').select2();
                        $('#input-aldeanegocio').select2();
                        $('#input-caserionegocio').select2();
                        $('#input-barrionegocio').select2();                           
                    } 
                    if (data == "Error 2002" || data == "Catch Fail"){
                        swal('Error en la conexión','No se pudo guardar, intentelo de nuevo mas tarde','warning');
                        enableFinishButton: false;
                    }
                })
                .fail(function() {
                    console.log("Ajax Error");
                })
                //<=========================================================================================================================================================================>                
                
                $(elem).validate().settings.ignore = ":hidden";
                return $(elem).valid();  
            },            

            //Finalización de los steps    
            onFinished: function (event, currentIndex){   

                console.log("OnFinished");

                                                                          
            },
        });

        $(".wizard .actions ul li a").addClass("waves-effect waves-indigo btn");
        $(".wizard .steps ul").addClass("tabs z-depth-1");
        $(".wizard .steps ul li").addClass("tab");
        $('ul.tabs').tabs();
        $('select').material_select();

        $('.select-wrapper.initialized').prev( "ul" ).remove();
        $('.select-wrapper.initialized').prev( "input" ).remove();
        $('.select-wrapper.initialized').prev( "span" ).remove();     
    }  
    //<------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->




    //<============================================================================= SAVEBUTTON FUNCTION ===================================================================================>
    /*
                                                Evento click para el boton de guardar de cada grupo, ubicado abajo de cada tabla de cada grupo
                                                        Toma los valores de los beneficiarios del grupo desde el objeto principal
                                                    y los agrega a un objeto temporal llamado window.tempBeneficiarios, para luego cargarlos
                                                                                        en el modal.
    */
    function saveButton(currhash){

        //Objeto temporal
        window.tempBeneficiarios = []; 

        //recorremos el objeto principal para capturar los creditos del grupo y meterlos al objeto temporal
        $.each(window.grupos_digitar, function(index, value){ 
            if(value.hash == currhash){
                value.idcredito = index;
                window.tempBeneficiarios.push(value);
            }
        });

        //vaciamos la tabla del modal
        $('#desembolso-data-beneficiarios').empty(); 
        
        //Recorremos el nuevo objeto temporal para agregar cada fila al modal
        for(var i = 0; i <= window.tempBeneficiarios.length; i++){ 
            if(window.tempBeneficiarios[i]){
                // console.log(window.tempBeneficiarios[i]);
                var clon = $('#clon').clone(); 
                clon.removeClass('clon'); 
                clon.removeAttr('id'); 
                clon.find('#nombre').val(window.tempBeneficiarios[i].primernombre +' '+ window.tempBeneficiarios[i].primerapellido); 
                clon.find('#idcredito').val(window.tempBeneficiarios[i].idcredito); 
                clon.find('#hash').val(window.tempBeneficiarios[i].hash);
                $('#desembolso-data-beneficiarios').append(clon); 
            }
        }

        $('#modal-digitacion').find('.select-ifi').val(0);

        $('#modal-digitacion').modal('open');

    }
    //<------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->



        
    //<================================================================================= CLEAR SELECTS FUNCTION ============================================================================>

    //                                                           Función que limpia los selects municipio, aldea, caserio, barrio en cascada

    function clearSelects(type,input){
        if (type=="municipio") {
            $('#input-municipio'+input).empty();
            $('#input-municipio'+input).select2();
            $('#input-aldea'+input).empty();
            $('#input-aldea'+input).select2();
            $('#input-caserio'+input).empty();
            $('#input-caserio'+input).select2();
            $('#input-barrio'+input).empty();
            $('#input-barrio'+input).select2();
        }
        if (type=="aldea") {
            $('#input-aldea'+input).empty();
            $('#input-aldea'+input).select2();
            $('#input-caserio'+input).empty();
            $('#input-caserio'+input).select2();
            $('#input-barrio'+input).empty();
            $('#input-barrio'+input).select2();
        }
        if (type=="caserio") {
            $('#input-caserio'+input).empty();
            $('#input-caserio'+input).select2();
            $('#input-barrio'+input).empty();
            $('#input-barrio'+input).select2();
        }                    
        if (type=="barrio") {
            $('#input-barrio'+input).empty();
            $('#input-barrio'+input).select2();
        }
    }    
    //<------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->




    //<============================================================================== INPUTELEMENTS FUNCTION ===============================================================================>
    
    //                                                     Función que llena los selects departamento, municipio, aldea, caserio, barrio


    function inputElements(type,input,departamento,municipio,aldea,caserio) {

        var obj = {
            type: type,
            data: {
                departamento: departamento,
                municipio: municipio,
                aldea: aldea,
                caserio: caserio
            }
        };

        console.log(obj);

        $.ajax({

            type: 'POST',
            url: '../php/digitacion/select-barrio.php',
            data: obj,

            beforeSend: function() {
                if (type=="municipio") {

                    $('#input-municipio'+input).select2('destroy');
                    $('#input-municipio'+input).append('<option value="" disabled selected>Cargando...</option>');                                                                
                    $('#input-municipio'+input).select2();                            
                }         
                if (type=="aldea") {

                    $('#input-aldea'+input).select2('destroy');
                    $('#input-aldea'+input).append('<option value="" disabled selected>Cargando...</option>');                                                                
                    $('#input-aldea'+input).select2();                            
                }    
                if (type=="caserio") {

                    $('#input-caserio'+input).select2('destroy');
                    $('#input-caserio'+input).append('<option value="" disabled selected>Cargando...</option>');                                                                
                    $('#input-caserio'+input).select2();                            
                }   
                if (type=="barrio") {

                    $('#input-barrio'+input).select2('destroy');
                    $('#input-barrio'+input).append('<option value="" disabled selected>Cargando...</option>');                                                                
                    $('#input-barrio'+input).select2();
                }                                   
            },

            success: function(data) {

                console.log(data);

                var result = JSON.parse(data);

                var length = result.length;

                //LLena los selects de cada consulta
                for (var i = 0; i <= length-1; i++) {

                    if (type=="municipio") {
                        $("#input-municipio"+input).append('<Option value="'+result[i].idMunicipio +'">'+result[i].nombre+'</option>');
                    }
                    if (type=="aldea") {
                        $("#input-aldea"+input).append('<Option value="'+result[i].idAldea +'">'+result[i].nombre+'</option>');
                    }
                    if (type=="caserio") {
                        $("#input-caserio"+input).append('<Option value="'+result[i].idCaserio +'">'+result[i].nombre+'</option>');
                    }
                    if (type=="barrio") {
                        $("#input-barrio"+input).append('<Option value="'+result[i].idBarrio +'">'+result[i].nombre+'</option>');
                    }

                }

                //Define los selects como SELECT2
                // $('#input-municipio'+input).select2();
                // $('#input-aldea'+input).select2();
                // $('#input-caserio'+input).select2();
                // $('#input-barrio'+input).select2();

                if (type == "municipio" && length > 0) {
                    $('#input-municipio'+input+' option[value=""]').remove();
                    $('#input-municipio'+input).append('<option value="" disabled selected>Seleccione el Municipio</option>');
                    $('#input-municipio'+input).select2();
                }

                if (type == "aldea" && length > 0) {
                    $('#input-aldea'+input+' option[value=""]').remove();
                    $('#input-aldea'+input).append('<option value="" disabled selected>Seleccione la Aldea</option>');
                    $('#input-aldea'+input).select2();
                }

                if (type == "caserio") {
                    if (length > 0) {
                        $('#input-caserio'+input+' option[value=""]').remove();
                        $('#input-caserio'+input).append('<option value="" disabled selected>Seleccione el caserio</option>');
                        $('#input-caserio'+input).select2();
                    }else{
                        $('#input-caserio'+input+' option[value=""]').remove();
                        $('#input-caserio'+input).append('<option value="0" selected>No tiene Caserios</option>');
                        $('#input-caserio'+input).select2();
                        $('#input-barrio'+input).append('<option value="0" selected>No tiene Barrios</option>');                                
                        $('#input-barrio'+input).select2();
                    }
                }

                if (type == "barrio") {
                    if (length > 0) {
                        $('#input-barrio'+input+' option[value=""]').remove();
                        $('#input-barrio'+input).prepend('<option value="" disabled selected>Seleccione el Barrio</option>');                                
                        $('#input-barrio'+input).select2();
                    }else{
                        $('#input-barrio'+input+' option[value=""]').remove();
                        $('#input-barrio'+input).append('<option value="0" selected>No tiene Barrios</option>');                                
                        $('#input-barrio'+input).select2();   
                    }
                }
            }
        });   
    } 
    //<------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->   
    





    function asignarSelectListeners(){

        //<================================================================================== ON CHANGE SELECTS ============================================================================>
        
        $('#input-departamento').change(function(){
            
            var type = "municipio";
            var departamento = $('#input-departamento').val();
            var municipio = "0";
            var aldea = "0";
            var caserio = "0";
            var input = "";

            // Limpia los Select para ser llenados nuevamente
            clearSelects(type,input);

            // Llena el select con la consulta
            inputElements(type,input,departamento,municipio,aldea,caserio);

        });

        $('#input-departamentonegocio').change(function(){
            
            var type = "municipio";
            var departamento = $('#input-departamentonegocio').val();
            var municipio = "0";
            var aldea = "0";
            var caserio = "0";
            var input = "negocio";

            // Limpia los Select para ser llenados nuevamente
            clearSelects(type,input);

            // Llena el select con la consulta
            inputElements(type,input,departamento,municipio,aldea,caserio);

        });            

        $('#input-municipio').on('change', (function(event) {
            // console.log('onChange Municipio');
            var type = "aldea";
            var departamento = $('#input-departamento').val();
            var municipio = $('#input-municipio').val();
            var aldea = "0";
            var caserio = "0";
            var input = "";

            // Limpia el Select para ser llenado nuevamente
            clearSelects(type,input);

            // Llena el select con la consulta
            inputElements(type,input,departamento,municipio,aldea,caserio);

        }));

        $('#input-municipionegocio').on('change', (function(event) {

            var type = "aldea";
            var departamento = $('#input-departamentonegocio').val();
            var municipio = $('#input-municipionegocio').val();
            var aldea = "0";
            var caserio = "0";
            var input = "negocio";

            // Limpia el Select para ser llenado nuevamente
            clearSelects(type,input);

            // Llena el select con la consulta
            inputElements(type,input,departamento,municipio,aldea,caserio);

        }));

        $('#input-aldea').on('change', (function(event) {

            var type = "caserio";
            var departamento = $('#input-departamento').val();
            var municipio = $('#input-municipio').val();
            var aldea = $('#input-aldea').val();
            var caserio = "0";
            var input = "";

            // Limpia el Select para ser llenado nuevamente
            clearSelects(type,input);

            // Llena el select con la consulta
            inputElements(type,input,departamento,municipio,aldea,caserio);

        }));      

        $('#input-aldeanegocio').on('change', (function(event) {

            var type = "caserio";
            var departamento = $('#input-departamentonegocio').val();
            var municipio = $('#input-municipionegocio').val();
            var aldea = $('#input-aldeanegocio').val();
            var caserio = "0";
            var input = "negocio";

            // Limpia el Select para ser llenado nuevamente
            clearSelects(type,input);

            // Llena el select con la consulta
            inputElements(type,input,departamento,municipio,aldea,caserio);

        }));            

        $('#input-caserio').on('change', (function(event) {

            var type = "barrio";
            var departamento = $('#input-departamento').val();
            var municipio = $('#input-municipio').val();
            var aldea = $('#input-aldea').val();
            var caserio = $('#input-caserio').val();
            var input = "";

            // Limpia el Select para ser llenado nuevamente
            clearSelects(type,input);

            // Llena el select con la consulta
            inputElements(type,input,departamento,municipio,aldea,caserio);

        }));   

        $('#input-caserionegocio').on('change', (function(event) {

            var type = "barrio";
            var departamento = $('#input-departamentonegocio').val();
            var municipio = $('#input-municipionegocio').val();
            var aldea = $('#input-aldeanegocio').val();
            var caserio = $('#input-caserionegocio').val();
            var input = "negocio";

            // Limpia el Select para ser llenado nuevamente
            clearSelects(type,input);

            // Llena el select con la consulta
            inputElements(type,input,departamento,municipio,aldea,caserio);

        }));
        //<--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    }
</script>
