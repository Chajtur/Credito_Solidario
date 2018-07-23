<?php


if(isset($_GET['nombre'])){
    
    //echo $_GET['nombre']."<br>";
    
    require '../php/conection.php';
    session_start();

    $user = $_SESSION['user'];
    
    if($_GET['nombre'] == "null"){
       $stat = $conn->prepare('
        SELECT Identidad, Nombre_Completo, Direccion, Negocio, Gestor, Numero_Prestamo
        FROM prestamo a, gsc b
        WHERE Gestor = "por asignar"
        and Estado_Credito = "desembolsado"  and a.Departamento = b.Departamento and b.Id = :user
        
        '); 
        $stat->bindValue(':user', $user, PDO::PARAM_STR);
    } else{
        $stat = $conn->prepare('
        SELECT Identidad, Nombre_Completo, Direccion, Negocio, Gestor, Numero_Prestamo
        FROM prestamo 
        WHERE Gestor = :nombre
        and Estado_Credito = "desembolsado" 
        ');
        $stat->bindValue(':nombre', $_GET['nombre'], PDO::PARAM_STR);
    }
    
    $stat->execute();
    $datos = $stat->fetchAll(PDO::FETCH_ASSOC);
    
    //////////////////////////query para creditos desembolsados por el asesor que se selecciono/////////////////////
    $creditosDesem = $conn->prepare('
    select count(*) as creditos
    from prestamo
    where month(fecha_desembolso) = month(current_date) and year(fecha_desembolso) = year(current_date) and gestor = :nombre
    ');
    $creditosDesem->bindValue(':nombre', $_GET['nombre'], PDO::PARAM_STR);
    $creditosDesem->execute();
    $creditosToal = $creditosDesem->fetchAll(PDO::FETCH_ASSOC);
    
    
    ///////////////////////////query para creditos desembolsados por dia por el asesor que se selecciono/////////////////////
    $creditosdiarios = $conn->prepare('
    select date(fecha_desembolso) as fecha, count(*) as creditos
    from prestamo
    where fecha_desembolso between date_sub(current_date, interval 6 day) and current_date  and gestor = :nombre
    group by day(fecha_desembolso)
    ');
    $creditosdiarios->bindValue(':nombre', $_GET['nombre'], PDO::PARAM_STR);
    $creditosdiarios->execute();
    $creditosPorDia = $creditosdiarios->fetchAll(PDO::FETCH_ASSOC);
    
    //var_dump($creditosPorDia);
    //$string = $creditosPorDia[0]['fecha'];
    
    $dias = [];
    $cantidadPDia = [];
    $semana = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'];
    foreach($creditosPorDia as $diaCantidad){
        $dias[] = $semana[(Date('N', strtotime($diaCantidad['fecha'])))-1];
        $cantidadPDia[] = $diaCantidad['creditos'];
    }
    
    
    ////////////////////////////query para colocacion de creditos por el asesor que se selecciono//////////////////////////////
    $colocacionDesem = $conn->prepare('
    select count(*) as colocacion
    from cartera_consolidada
    where month(fecha_colocacion) = month(current_date) and year(fecha_colocacion) = year(current_date) and gestor = :nombre
    ');
    $colocacionDesem->bindValue(':nombre', $_GET['nombre'], PDO::PARAM_STR);
    $colocacionDesem->execute();
    $colocacionToal = $colocacionDesem->fetchAll(PDO::FETCH_ASSOC);
    
    
    
    ////////////////////////////query para colocacion diaria de creditos por el asesor que se selecciono//////////////////////////////
    $colocaciondiarios = $conn->prepare('
    select date(fecha_colocacion) as fecha, count(*) as creditos
    from cartera_consolidada
    where fecha_colocacion between date_sub(current_date, interval 6 day) and current_date  and gestor = :nombre
    group by date(fecha_colocacion)
    ');
    $colocaciondiarios->bindValue(':nombre', $_GET['nombre'], PDO::PARAM_STR);
    $colocaciondiarios->execute();
    $colocacionPorDia = $colocaciondiarios->fetchAll(PDO::FETCH_ASSOC);
    
    
    //$stringColocacion = $colocacionPorDia[0]['fecha'];
    
    $diasColocacion = [];
    $cantidadPDiaColocacion = [];
    $semana = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'];
    foreach($colocacionPorDia as $diaCantidad){
        $diasColocacion[] = $semana[(Date('N', strtotime($diaCantidad['fecha'])))-1];
        $cantidadPDiaColocacion[] = $diaCantidad['creditos'];
    }
        
    
    
    ///////////////////////////////query para recuperacion  por el asesor que se selecciono////////////////////////////
    $recuperacionDesem = $conn->prepare('
    select sum(a.capital) as recuperacion
    from pagos a, prestamo b
    where month(a.fecha) = month(current_date) and b.gestor = :nombre and a.numero_prestamo = b.numero_prestamo
    ');
    $recuperacionDesem->bindValue(':nombre', $_GET['nombre'], PDO::PARAM_STR);
    $recuperacionDesem->execute();
    $recuperacionToal = $recuperacionDesem->fetchAll(PDO::FETCH_ASSOC);
    
    ////////////////////////////query para colocacion diaria de creditos por el asesor que se selecciono//////////////////////////////
    $recuperaciondiarios = $conn->prepare('
    select fecha, sum(a.capital) as recuperacion
    from pagos a, prestamo b
    where a.fecha between date_sub(current_date, interval 6 day) and current_date  and b.gestor = :nombre and a.numero_prestamo = b.numero_prestamo
    group by fecha
    ');
    $recuperaciondiarios->bindValue(':nombre', $_GET['nombre'], PDO::PARAM_STR);
    $recuperaciondiarios->execute();
    $recuperacionPorDia = $recuperaciondiarios->fetchAll(PDO::FETCH_ASSOC);
    
    
    //$stringColocacion = $colocacionPorDia[0]['fecha'];
    
    $diasRecuperacion = [];
    $cantidadPDiaRecuperacion = [];
    $semana = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'];
    foreach($recuperacionPorDia as $diaCantidad){
        $diasRecuperacion[] = $semana[(Date('N', strtotime($diaCantidad['fecha'])))-1];
        $cantidadPDiaRecuperacion[] = $diaCantidad['recuperacion'];
    }
    

    ////////////////////////////////////////////////////////////////////////////////////////////////
    
    if(isset($_GET['id'])){
    
    
    $stat = $conn->prepare('
        SELECT creditos, metaCreditos, mora, metaMora, porcentajeMora, metaPorcentajeMora, colocacion, metaColocacion, recuperacion, metaRecuperacion 
        FROM metas
        WHERE idUsuario = :id 
        ');
        $stat->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
    $stat->execute();
    $metas = $stat->fetchAll(PDO::FETCH_ASSOC);
        
    
    //echo json_encode($metas);
}
    //query para seleccionar asesores por departamento
    
    $sql = $conn->prepare('
        SELECT a.nombre, a.id
        FROM  gsc b, gsc a
        WHERE b.Departamento = a.departamento and b.Id = :user and a.tipoEmpleado = "Gestor" and a.parent = :user
    ');
    $sql->bindValue(':user', $user, PDO::PARAM_STR);
    $sql->execute();
    $gestores = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    
    //echo count($datos);
    //echo var_dump($datos);
    // echo json_encode($gestores);

}

?>


    <!--SECCION PARA METAS, CARTAS DE ESTADO Y ESTADISTICAS-->
    <div class="section hide">

        <!--CARTAS DE ESTADO-->

        <div class="titulo-header">
            <h4 style="display: inline-block;" class="header">METAS Y ESTADÍSTICAS. </h4>
            <span style="display: inline-block;" class=""><a href="#modalMetaTodas"> (Editar todas las metas)</a></span>
        </div>
        <div class="row">

        <div id="card-stats">
                <div class="row margin">
                    <div class="col s12 m8 l4 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat1" class="card">
                            <div class="card-content   white lighten-2 green-text">
                                <p class="card-stats-title"><i class="material-icons">work</i> Total Desembolsos</p>
                                <h4 id="cartera-activa" class="card-stats-number">
                                <?php 
                                    if(count($creditosToal) > 0){
                                        echo ($creditosToal[0]['creditos'] == null ? "0" : number_format($creditosToal[0]['creditos']));
                                    }else {
                                        echo "0";
                                    }
                                ?>
                                </h4>
                                <p class="card-stats-compare"><i class="material-icons">local_atm</i>
                                    meta mensual de: 
                                    <?php 
                                    if(count($metas) > 0){
                                        echo ($metas[0]['metaCreditos'] == null ? "0" : number_format($metas[0]['metaCreditos']));
                                    } else {
                                        echo "0";
                                    }
                                    
                                    ?>
                                </p>
                            </div>
                            <div class="card-action green lighten-3 center">
                                <!--<div id="clients-bar" class="center-align"></div>-->
                                <a id="btnEditarMeta1" href="#modalMeta1" style="text-transform: lowercase;">
                                    <span class="green-text text-darken-4">editar meta de créditos</span>
                                </a>
                            </div>
                        </div>
                        <div class="card hide-on-med-and-up">
                            <div class="card-content">
                                <span class="card-title">cantidad de créditos diarios</span>
                                <p><canvas id="grahp1Movil" width="100" height="80"></canvas></p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l4 wow fadeInDown" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat2" class="card">
                            <div class="card-content white amber-text">
                                <p class="card-stats-title"><i class="material-icons">attach_money</i> Colocación</p>
                                <h4 id="total-mora" class="card-stats-number">
                                <?php 
                                    if(count($colocacionToal) > 0){
                                        echo ($colocacionToal[0]['colocacion'] == null ? "0" : number_format($colocacionToal[0]['colocacion']));
                                    } else {
                                        echo "0";
                                    }
                                    
                                ?>
                                </h4>
                                <p class="card-stats-compare"><i class="material-icons">local_atm</i> 
                                    meta mensual de: 
                                    <?php 
                                    if(count($metas) > 0){
                                        echo ($metas[0]['metaColocacion'] == null ? "0" : number_format($metas[0]['metaColocacion']));
                                    } else {
                                        echo "0";
                                    }
                                        
                                    ?>
                                    </p>
                            </div>
                            <div class="card-action amber lighten-3 center">
                                <!--<div id="sales-compositebar" class="center-align"></div>-->
                                <a id="btnEditarMeta2" href="#modalMeta2" style="text-transform: lowercase;">
                                    <span class="amber-text text-darken-2">editar meta de colocación</span>
                                </a>
                            </div>
                        </div>
                        <div class="card hide-on-med-and-up">
                            <div class="card-content">
                                <span class="card-title">Colocación diaria</span>
                                <p><canvas id="grahp2Movil" width="100" height="80"></canvas></p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l4 wow fadeInRight" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat3" class="card wow fadeInDown" data-wow-duration="1s">
                            <div class="card-content white red-text">
                                <p class="card-stats-title"><i class="material-icons">warning</i> Recuperación</p>
                                <h4 id="porcentaje-mora" class="card-stats-number red-text">
                                <?php 
                                if(count($recuperacionToal) > 0){
                                    echo ($recuperacionToal[0]['recuperacion'] == null ? "0" : "L. " .number_format($recuperacionToal[0]['recuperacion'], "2",".",","));
                                } else {
                                    echo "0";
                                }
                                ?>
                                </h4>
                                <p class="card-stats-compare"><i class="material-icons">local_atm</i> 
                                meta mensual de: 
                                <?php 
                                    if(count($metas) > 0){
                                        echo ($metas[0]['metaRecuperacion'] == null ? "0" : "L. " .number_format($metas[0]['metaRecuperacion'], "2",".",","));
                                    } else {
                                        echo "0";
                                    }
                                    
                                ?>
                                </p>
                            </div>
                            <div class="card-action red lighten-3 center">
                                <!--
                             -->
                                <div id="graph3movil" class="center-align"></div>
                                <a id="btnEditarMeta3" href="#modalMeta3" style="text-transform: lowercase;">
                                    <span class="red-text text-darken-4">editar meta de recuperación</span>
                                </a>
                            </div>
                        </div>
                        <div class="card hide-on-med-and-up">
                            <div class="card-content">
                                <span class="card-title">Recuperación diaria</span>
                                <p><canvas id="grahp3Movil" width="100" height="80"></canvas></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--GRAFICOS-->
        <div class="row hide-on-small-only">
            <!--GRAFICO 1-->
            <div class="col s12 l4">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Créditos diarios</span>
                        <p><canvas id="grahp1" width="100" height="80"></canvas></p>
                    </div>
                </div>
            </div>

            <!--GRAFICO 2-->
            <div class="col s12 l4">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Colocación diaria</span>
                        <p><canvas id="grahp2" width="100" height="80"></canvas></p>
                    </div>
                </div>
            </div>

            <!--GRAFICO 2-->
            <div class="col s12 l4">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Recuperación diaria</span>
                        <p><canvas id="grahp3" width="100" height="80"></canvas></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--SECCION PARA CARTERAS Y EDICION DE CARTERA-->
    <div class="section">
        <h4 class="header">CARTERA Y REASIGNACIÓN</h4>
        <div class="row">
            <div class="col s12">
                <div id="work-collapsible">
                    <div class="row">
                        <div class="col s12" id="todos-los-creditos">
                            <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                <li class="collapsible-item-header avatar">
                                    <i class="material-icons circle light-blue">list</i>
                                    <span class="collapsible-title-header"><span id="nombreDeAsesor"><?php echo $datos[0]['Gestor']?></span> <span id="idAsesor" class="hiden"><?php echo (isset($_GET['id']) ? $_GET['id'] : 'nada' )?></span>
                                    <div class="secondary-content actions hide-on-med-and-down">
                                        <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                        <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                            <i class="material-icons center-align">search</i>
                                        </a>
                                        <a id="desactivarLista" class="dropdown-button waves-effect waves-light btn-flat nopadding" data-activates='dropdown_listOrder'>
                                            <i class="material-icons center-align">sort</i>
                                        </a>
                                    </div>
                                    </span>
                                    <p>lista créditos de <span id="nombreAsesortitle"><?php echo $datos[0]['Gestor']?></span></p>
                                </li>
                                <li>
                                    <div class="collapsible-header-titles  sin-icon">
                                        <div class="row">
                                            <div class="col s2 m3 l1">
                                                <p class="collapsible-title">#</p>
                                            </div>
                                            <div class="col s4 m3 l2">
                                                <p class="collapsible-title">Identidad</p>
                                            </div>
                                            <div class="col s4 m3 l3 ">
                                                <p class="collapsible-title">Nombre</p>
                                            </div>
                                            <div class="col s6 m3 l5 hide-on-small-only">
                                                <p class="collapsible-title">Dirección</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <div class="list collapsible no-padding no-margin z-depth-0">
                                    <?php $i=0;?>
                                    <?php if(count($datos) > 0):?>
                                    <?php foreach($datos as $creditos):?>
                                    <?php $i++;?>
                                    <li>
                                        <div class="collapsible-header sin-icon">
                                            <div class="row">
                                                <div class="col s2 m3 l1">
                                                    <p class="collapsible-content truncate">
                                                        <input type="checkbox" name="<?php echo $creditos['Numero_Prestamo'];?>" class="filled-in seleccion-credito" id="<?php echo " check ".$i?>" />
                                                        <label style="top: 12px;" for="<?php echo " check ".$i?>"></label>
                                                    </p>
                                                </div>
                                                <div class="col s4 m3 l2">
                                                    <p class="collapsible-content truncate nombre"><?php echo $creditos['Identidad']?></p>
                                                </div>
                                                <div class="col s4 m3 l3  light truncate">
                                                    <p class="collapsible-content gestorg"><?php echo $creditos['Nombre_Completo']?></p>
                                                </div>
                                                <div class="col s6 m3 l5 hide-on-small-only light truncate">
                                                    <p class="collapsible-content estadog"><?php echo $creditos['Direccion']?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapsible-body">
                                            <p class="hide-on-large-only"><b>Identidad: </b>
                                                <?php echo $creditos['Identidad'] == '' ? 'No tiene' : $creditos['Identidad'] ?>
                                            </p>
                                            <p class="hide-on-large-only"><b>Nombre: </b>
                                                <?php echo $creditos['Gestor'] == '' ? 'No tiene' : $creditos['Nombre_Completo'] ?>
                                            </p>
                                            <p><b>Gestor: </b>
                                                <?php echo $creditos['Nombre_Completo'] == '' ? 'No tiene' : $creditos['Gestor'] ?>
                                            </p>
                                            <p><b>Dirección del Domicilio: </b>
                                                <?php echo $creditos['Direccion'] == '' ? 'No tiene' : $creditos['Direccion'] ?>
                                            </p>
                                            <p><b>Dirección del Negocio: </b>
                                                <?php echo $creditos['Negocio'] == '' ? 'No tiene' : $creditos['Negocio'] ?>
                                            </p>
                                        </div>
                                    </li>
                                    <?php endforeach;?>
                                    <?php else:?>
                                    <li class="center">
                                        <h5>No hay ningún beneficiario</h5>
                                    </li>
                                    <?php endif;?>
                                </div>
                                <li>
                                    <div class="collapsible-footer sin-icon" style="border-bottom: 1px solid #e0e0e0; line-height: 30px;">
                                        <div class="row">
                                            <span class="right">total: <?php echo count($datos)?> registros</span>
                                            <ul id="pag-control" class="pag pagination">
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row center">
            <div class="col s12">
                <a id="btnEditarCreditos" class="waves-effect waves-light btn">Editar Créditos</a>
            </div>
        </div>

        <!-- Dropdown Structure -->
        <ul id='dropdown_listOrder' class='dropdown-content'>
            <li><a value="5" href="#!">ver 5</a></li>
            <li><a value="10" href="#!">ver 10</a></li>
            <li><a value="20" href="#!">ver 20</a></li>
            <li><a value="10000" href="#!">ver todo</a></li>
        </ul>

        <!-- Modal Structure -->
        <div id="modal1" class="modal modal-fixed-footer modal-max-width-2">
            <div class="modal-content">
                <h4>Edición de Créditos</h4>
                <p>Seleccione un asesor de la lista para reasignar a los créditos seleccionados.</p>
                <br>
                <div class="input-field col s12 select-corto">
                    <select id="nuevoAsesor">
                        <option value="" disabled selected>Elegir un Asesor</option>
                        <?php $i=0;?>
                            <?php if(count($gestores) > 0):?>
                                <?php foreach($gestores as $gestor):?>
                                    <?php $i++;?>
                                        <option value="1"><?php echo $gestor['nombre']; ?></option>
                                <?php endforeach;?>
                            <?php endif;?>
                    </select>
                    <label>seleccione un asesor</label>
                    <label class="error" id="error-label">Este campo es requerido</label>
                    <br>
                    <p>Se modificarán los siguientes número de prestamos: <span class="blue-text" id="listaAModificar"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <a id="actualizarAsesor" href="#!" class="modal-action modal-close waves-effect waves-green white-text btn btn-flat ">Actualizar</a>
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">cancelar</a>
            </div>
        </div>
    </div>

    <!--MODALES DE EDICION PARA METAS-->
    <div>
        <!-- Modal PARA PRIMERA CARTA -->
        <div id="modalMeta1" class="modal modal-max-width-2">
            <div class="modal-content">
                <h4>Editar Meta de Créditos</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaCreditosIndiv" type="number" class="validate">
                        <label for="metaTodasCreditos" data-error="datos erroneos" data-success="correcto">Meta de créditos</label>
                        <label class="error hide" id="error-label">Este campo es requerido</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="btnEditMetaCreditos" href="#!" class="meta modal-action  waves-effect waves-green btn-flat">Aplicar</a>
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            </div>
        </div>

        <!-- Modal PARA SEGUNDA CARTA -->
        <div id="modalMeta2" class="modal modal-max-width-2">
            <div class="modal-content">
                <h4>Editar Meta de Colocación</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaColocacionIndiv" type="number" class="validate">
                        <label for="metaTodasCreditos" data-error="datos erroneos" data-success="correcto">Meta de colocación</label>
                        <label class="error hide" id="error-label">Este campo es requerido</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="btnEditMetaMora" href="#!" class="meta modal-action  waves-effect waves-green btn-flat">Aplicar</a>
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            </div>
        </div>

        <!-- Modal PARA TERCERA CARTA -->
        <div id="modalMeta3" class="modal modal-max-width-2">
            <div class="modal-content">
                <h4>Editar Meta de Recuperación</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaRecuperacionIndiv" min="5" max="100" type="number" class="validate">
                        <label for="metaTodasCreditos" data-error="datos erroneos" data-success="correcto">Meta Porcentaje de Mora</label>
                        <label class="error hide" id="error-label">Este campo es requerido</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="btnEditMetaPMora" href="#!" class="meta modal-action waves-effect waves-green btn-flat">Aplicar</a>
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            </div>
        </div>

        <!-- Modal PARA TODAS LAS METAS -->
        <div id="modalMetaTodas" class="modal modal-fixed-footer modal-max-width">
            <div class="modal-content">
                <h4>Editar Todas las Metas</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaTodasCreditos" type="number" class="validate">
                        <label for="metaTodasCreditos" data-error="wrong" data-success="right">Meta de créditos</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaTodasMora" type="number" class="validate">
                        <label for="metaTodasMora" data-error="wrong" data-success="right">Meta de Mora</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaTodasPMora" type="number" class="validate">
                        <label for="metaTodasPMora" data-error="wrong" data-success="right">Meta de Porcentaje de Mora</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaTodasColocacion" type="number" class="validate">
                        <label for="metaTodasColocacion" data-error="wrong" data-success="right">Meta de Colocación</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="metaTodasRecuperacion" type="number" class="validate">
                        <label for="metaTodasRecuperacion" data-error="wrong" data-success="right">Meta de Recuperación</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="btnEditMetasTodas" href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Aplicar</a>
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
            </div>
        </div>

    </div>
    
    
    <script>

        $(document).ready(function(){
            
            
            
            $('.meta').on('click', function(){
                window.idModal = $(this).parent().parent().attr('id');
                if($(this).parent().parent().find('.validate').val() == ""){
                    $('.error').removeClass('hide');
                } else {
                    //console.log($(this).parent().parent().find('.validate').val());
                    //console.log($(this).parent().parent().find('.validate').attr('id'));
                    window.montoMeta = $(this).parent().parent().find('.validate').val();
                    window.idInput = $(this).parent().parent().find('.validate').attr('id');
                    swal({
                        title: "Atención!",
                        text: "Se actualizarán las metas que haya modificado. Desea continuar?",
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        confirmButtonText: "Si, Actualizar!",
                        cancelButtonText: "No, cancelar!",
                        showLoaderOnConfirm: true,
                    },
                    function() {
                        $.ajax({
                        type: 'POST',
                        data: {
                            idAsesor: $('#idAsesor').text(),
                            metaMonto: window.montoMeta, 
                            metaInputId: window.idInput
                        },
                        url: 'actualizarMetas.php',
                        success: function(data) {
                            console.log(data);

                            swal({
                                    title: "Bien hecho!",
                                    text: "Los créditos han sido actualizados!",
                                    type: "success"
                                },
                                function(isConfirm) {
                                    if (isConfirm) {
                                        $('#main-container').hide("slide", {
                                            direction: "left"
                                        }, 300, function() {
                                            $('#loading').fadeIn(100, function() {
                                                $('#main-container').load('editarAsesor.php?nombre=' + escape($('#nombreAsesortitle').text())+'&id='+escape($('#idAsesor').text()), function() {
                                                    $('#loading').fadeOut(100, function() {
                                                        $('#main-container').fadeIn(100);
                                                    });
                                                });
                                            });
                                        });
                                        $('#'+window.idModal).modal('close');
                                        $('#'+window.idInput).val("");
                                        
                                    }
                                });
                        }
                        });
                    });
                }
                
                $(this).parent().parent().find('.validate').on('input', function(){
                    $('.error').addClass('hide');
                });
            });
            
            
            $('#btnEditMetasTodas').on('click', function(){
                var datos = {
                    metaTodasCreditos: $('#metaTodasCreditos').val(), 
                    metaTodasMora: $('#metaTodasMora').val(), 
                    metaTodasPMora: $('#metaTodasPMora').val(), 
                    metaTodasColocacion: $('#metaTodasColocacion').val(), 
                    metaTodasRecuperacion: $('#metaTodasRecuperacion').val()
                }
                console.log(datos);
                
                swal({
                        title: "Atención!",
                        text: "Se actualizarán las metas que haya modificado. Desea continuar?",
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        confirmButtonText: "Si, Actualizar!",
                        cancelButtonText: "No, cancelar!",
                        showLoaderOnConfirm: true,
                },
                function() {
                    $.ajax({
                    type: 'POST',
                    data: {
                        idAsesor: $('#idAsesor').text(),
                        metaTodasCreditos: $('#metaTodasCreditos').val(), 
                        metaTodasMora: $('#metaTodasMora').val(), 
                        metaTodasPMora: $('#metaTodasPMora').val(), 
                        metaTodasColocacion: $('#metaTodasColocacion').val(), 
                        metaTodasRecuperacion: $('#metaTodasRecuperacion').val()
                    },
                    url: 'actualizarMetas.php',
                    success: function(data) {
                        console.log(data);

                        swal({
                                title: "Bien hecho!",
                                text: "Los créditos han sido actualizados!",
                                type: "success"
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    $('#main-container').hide("slide", {
                                        direction: "left"
                                    }, 300, function() {
                                        $('#loading').fadeIn(100, function() {
                                            $('#main-container').load('editarAsesor.php?nombre=' + escape($('#nombreAsesortitle').text())+'&id='+escape($('#idAsesor').text()), function() {
                                                $('#loading').fadeOut(100, function() {
                                                    $('#main-container').fadeIn(100);
                                                });
                                            });
                                        });
                                    });
                                    $('#metaTodasCreditos').val("");
                                    $('#metaTodasCreditos').val(""); 
                                    $('#metaTodasPMora').val(""); 
                                    $('#metaTodasColocacion').val(""); 
                                    $('#metaTodasRecuperacion').val("");
                                }
                            });
                    }
                });
                });
                
            });
            
        });//final de document ready

    </script>

    <script>
        $(document).ready(function() {

            var ctxGraph1 = document.getElementById("grahp1");
            var ctxGraph1Movil = document.getElementById("grahp1Movil");

            var ctxGraph2 = document.getElementById("grahp2");
            var ctxGraph2Movil = document.getElementById("grahp2Movil");

            var ctxGraph3 = document.getElementById("grahp3");
            var ctxGraph3Movil = document.getElementById("grahp3Movil");


            var dataGraph1 = {
                labels: <?php echo json_encode($dias);  ?>,
                datasets: [{
                    label: "Creditos  diarios (Ult. 7 días)",
                    backgroundColor: [
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6'
                    ],
                    borderColor: [
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6'
                    ],
                    borderWidth: 1,
                    data: <?php echo json_encode($cantidadPDia);?>
                }]
            };

            new Chart(ctxGraph1, {
                type: "bar",
                data: dataGraph1,
                options: {
                    barValueSpacing: 20,
                    animation: {
                        duration: 0,
                        onComplete: function() {
                            // render the value of the chart above the bar
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "#000";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                    ctx.fillText(dataset.data[i], model.x, model.y - 5);

                                    if (parseInt(dataset.data[i]) > 50) {
                                        dataset.backgroundColor[i] = "#f44336";
                                        dataset.borderColor[i] = "#f44336";
                                    } else if (parseInt(dataset.data[i]) > 9) {
                                        dataset.backgroundColor[i] = "#ffc107";
                                        dataset.borderColor[i] = "#ffc107";
                                    } else {
                                        dataset.backgroundColor[i] = "#4caf50";
                                        dataset.borderColor[i] = "#4caf50";
                                    }
                                }
                            });
                        }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                            }
                        }]
                    }
                }
            });

            new Chart(ctxGraph1Movil, {
                type: "horizontalBar",
                data: dataGraph1,
                options: {
                    barValueSpacing: 20,
                    animation: {
                        duration: 0,
                        onComplete: function() {

                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "#000";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                    ctx.fillText(dataset.data[i], model.x + 25, model.y + 8);

                                    if (parseInt(dataset.data[i]) > 50) {
                                        dataset.backgroundColor[i] = "#f44336";

                                    } else if (parseInt(dataset.data[i]) > 9) {
                                        dataset.backgroundColor[i] = "#ffc107";

                                    } else {
                                        dataset.backgroundColor[i] = "#4caf50";

                                    }
                                }
                            });
                        }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                            }
                        }]
                    }
                }
            });

            /////////////////////////////////////////////////////////////////
        
    
            var dataGraph2 = {
                labels: <?php echo json_encode($diasColocacion); ?>,
                datasets: [{
                    label: "Colocación diaria (Ult. 7 días)",
                    backgroundColor: [
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6'
                    ],
                    borderColor: [
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6'
                    ],
                    borderWidth: 1,
                    data: <?php echo json_encode($cantidadPDiaColocacion); ?>
                }]
            };

            new Chart(ctxGraph2, {
                type: "bar",
                data: dataGraph2,
                options: {
                    barValueSpacing: 20,
                    animation: {
                        duration: 0,
                        onComplete: function() {
                            // render the value of the chart above the bar
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "#000";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                    ctx.fillText(dataset.data[i], model.x, model.y - 5);

                                    if (parseInt(dataset.data[i]) > 50) {
                                        dataset.backgroundColor[i] = "#f44336";
                                        dataset.borderColor[i] = "#f44336";
                                    } else if (parseInt(dataset.data[i]) > 9) {
                                        dataset.backgroundColor[i] = "#ffc107";
                                        dataset.borderColor[i] = "#ffc107";
                                    } else {
                                        dataset.backgroundColor[i] = "#4caf50";
                                        dataset.borderColor[i] = "#4caf50";
                                    }
                                }
                            });
                        }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                            }
                        }]
                    }
                }
            });

            new Chart(ctxGraph2Movil, {
                type: "horizontalBar",
                data: dataGraph2,
                options: {
                    barValueSpacing: 20,
                    animation: {
                        duration: 0,
                        onComplete: function() {

                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "#000";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                    ctx.fillText(dataset.data[i], model.x, model.y - 5);

                                    if (parseInt(dataset.data[i]) > 50) {
                                        dataset.backgroundColor[i] = "#f44336";
                                        dataset.borderColor[i] = "#f44336";
                                    } else if (parseInt(dataset.data[i]) > 9) {
                                        dataset.backgroundColor[i] = "#ffc107";
                                        dataset.borderColor[i] = "#ffc107";
                                    } else {
                                        dataset.backgroundColor[i] = "#4caf50";
                                        dataset.borderColor[i] = "#4caf50";
                                    }
                                }
                            });
                        }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                            }
                        }]
                    }
                }
            });

            /////////////////////////////////////////////////////////////////
        

            var dataGraph3 = {
                labels: <?php echo json_encode($diasRecuperacion);?>,
                datasets: [{
                    label: "Recuperación diaria(ultimos 7 días)",
                    backgroundColor: [
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6'
                    ],
                    borderColor: [
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6',
                        '#29B6F6'
                    ],
                    borderWidth: 1,
                    data: <?php echo json_encode($cantidadPDiaRecuperacion);?>
                }]
            };

            new Chart(ctxGraph3, {
                type: "bar",
                data: dataGraph3,
                options: {
                    barValueSpacing: 20,
                    animation: {
                        duration: 0,
                        onComplete: function() {
                            // render the value of the chart above the bar
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                            //ctx.fillStyle = "#29B6F6";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                    ctx.fillText(dataset.data[i], model.x, model.y - 5);

                                    if (parseInt(dataset.data[i]) > 50) {
                                        dataset.backgroundColor[i] = "#f44336";
                                        dataset.borderColor[i] = "#f44336";
                                    } else if (parseInt(dataset.data[i]) > 9) {
                                        dataset.backgroundColor[i] = "#ffc107";
                                        dataset.borderColor[i] = "#ffc107";
                                    } else {
                                        dataset.backgroundColor[i] = "#4caf50";
                                        dataset.borderColor[i] = "#4caf50";
                                    }
                                }
                            });
                        }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'L. ' +tooltipItem.yLabel ;
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                            }
                        }]
                    }
                }
            });

            new Chart(ctxGraph3Movil, {
                type: "horizontalBar",
                data: dataGraph3,
                options: {
                    barValueSpacing: 20,
                    animation: {
                        duration: 0,
                        onComplete: function() {

                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);

                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function(dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                                    ctx.fillText(dataset.data[i], model.x, model.y - 5);

                                    if (parseInt(dataset.data[i]) > 50) {
                                        dataset.backgroundColor[i] = "#f44336";
                                        dataset.borderColor[i] = "#f44336";
                                    } else if (parseInt(dataset.data[i]) > 9) {
                                        dataset.backgroundColor[i] = "#ffc107";
                                        dataset.borderColor[i] = "#ffc107";
                                    } else {
                                        dataset.backgroundColor[i] = "#4caf50";
                                        dataset.borderColor[i] = "#4caf50";
                                    }
                                }
                            });
                        }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'L. ' +tooltipItem.yLabel;
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                            }
                        }]
                    }
                }
            });

        });

    </script>

    <script>
        $(document).ready(function() {


            $('#breadcrum-title').text($('#nombreDeAsesor').text());

            $('select').material_select();
            $('.modal').modal({
                /*complete: function() { 
                    $('input').val('');
                }*/
            });

            $('#modal1').modal({
                complete: function() {
                    $('#listaAModificar').text('');
                }
            });

            $('.dropdown-button').dropdown({
                inDuration: 300,
                outDuration: 225,
                constrainWidth: false, // Does not change width of dropdown to that of the activator
                hover: false, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: true, // Displays dropdown below the button
                alignment: 'left', // Displays dropdown with edge aligned to the left of button
                stopPropagation: false // Stops event propagation
            });

            $('#dropdown_listOrder').find('a').click(function() {

                listObj.page = $(this).attr('value');
                listObj.update();
            });

            $('.collapsible').collapsible();

            $('.icon-collapse-search').click(function() {
                $('.search-expandida').toggleClass('expanded');
                $('.search-expandida').focus();
            });

            window.seleccionados = [];
            $('.seleccion-credito').change(function() {
                if ($(this)[0].checked == true) {
                    window.seleccionados.push($(this).attr('name'));
                } else {
                    var index = window.seleccionados.indexOf($(this).attr('name'));
                    window.seleccionados.splice(index, 1);
                }
            });

            var options = {
                page: 5,
                pagination: true,
                valueNames: ['codigog', 'nombre', 'gestorg', 'estadog'],
                fuzzySearch: {
                    searchClass: "fuzzy-search",
                    location: 0,
                    distance: 100,
                    threshold: 0.2,
                    multiSearch: true
                }
            };
            window.listObj = new List('todos-los-creditos', options);



            $('#btnEditarCreditos').on('click', function() {

                if (window.seleccionados.length > 0) {
                    $('#btnEditarCreditos').attr('href', '#modal1');
                    console.log(window.seleccionados);
                    var aux = '';
                    $.each(window.seleccionados, function(index, value) {
                        aux += '<br>' + value;
                    });
                    $('#listaAModificar').append(aux);

                } else {
                    $('#btnEditarCreditos').attr('href', '#!');
                    swal({
                        title: "Atención!",
                        text: "No ha seleccionado ningún crédito.",
                        type: "warning",
                        confirmButtonText: "Aceptar"
                    });
                }

            });


            //VERIFICAR QUE EL SELECT NO ESTE VACIO PARA ACTUALIZAR EL ASESOR
            if ($('#nuevoAsesor option:selected').val() == 0) {
                $('#actualizarAsesor').addClass('disabled');
                /*
                        Materialize.toast('Debe elegir un municipio!', 4000);
                        $('#nuevoAsesor').parent().parent().find('.error').show();*/
            }
            $("#nuevoAsesor").on('change', function() {
                $('#actualizarAsesor').removeClass('disabled');
                $('#nuevoAsesor').parent().parent().find('.error').hide();
            });

            $('#actualizarAsesor').on('click', function() {
                //var data_to_send = $.serialize(window.seleccionados);
                swal({
                        title: "Atención!",
                        text: "Se actualizarán los créditos que haya seleccionado. Desea continuar?",
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        confirmButtonText: "Si, Actualizar!",
                        cancelButtonText: "No, cancelar!",
                        showLoaderOnConfirm: true,
                    },
                    function() {
                        $.ajax({
                            type: 'POST',
                            data: {
                                data: JSON.stringify(window.seleccionados),
                                gestor: $('#nuevoAsesor option:selected').text()
                            },
                            url: 'updateAsesor.php',
                            success: function(data) {
                                console.log(data);

                                swal({
                                        title: "Bien hecho!",
                                        text: "Los créditos han sido actualizados!",
                                        type: "success"
                                    },
                                    function(isConfirm) {
                                        if (isConfirm) {
                                            $('#main-container').hide("slide", {
                                                direction: "left"
                                            }, 300, function() {
                                                $('#loading').fadeIn(100, function() {
                                                    $('#main-container').load('editarAsesor.php?nombre=' + escape($('#nombreAsesortitle').text()), function() {
                                                        $('#loading').fadeOut(100, function() {
                                                            $('#main-container').fadeIn(100);
                                                        });
                                                    });
                                                });
                                            });
                                        }
                                    });
                            }
                        });
                    });
            });



        }); //fin del document ready

    </script>
