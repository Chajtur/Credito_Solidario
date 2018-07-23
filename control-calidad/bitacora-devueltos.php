<?php

try{
    
    require '../php/conection.php';
    
    session_start();
    $sql = 'select a.grupo_hash, b.Grupo_Solidario, b.Gestor, a.fecha 
    from bitacora_creditos a left join cartera_consolidada b on a.id_credito = b.id
    where a.razon = "Correccion Control de Calidad" and id_usuario = :usuario group by a.grupo_hash';
    $stat = $conn->prepare($sql);
    $stat->bindValue(':usuario', $_SESSION['user'], PDO::PARAM_STR);
    $stat->execute();
    
    $grupos_devueltos = $stat->fetchAll(PDO::FETCH_ASSOC);
    
    $stat_beneficiarios = $conn->prepare('select distinct a.id_credito, b.grupo_solidario_hash, b.Identidad, b.Nombre from bitacora_creditos a 
    left join cartera_consolidada b on a.id_credito = b.id 
    where b.grupo_solidario_hash = :hash');

    $stat_bitacora = $conn->prepare('select * from bitacora_creditos where razon = "Correccion Control de Calidad" and id_credito = :idcredito and id_usuario = :user');

    $i=0;
    $cantidad_creditos = 0;
    $cantidad_observaciones = 0;
    foreach($grupos_devueltos as $grupo){
        
        $grupos_devueltos[$i]['beneficiarios'] = array();

        $stat_beneficiarios->bindValue(':hash', $grupo['grupo_hash'], PDO::PARAM_STR);
        $stat_beneficiarios->execute();

        $beneficiarios = $stat_beneficiarios->fetchAll(PDO::PARAM_STR);

        foreach ($beneficiarios as $beneficiario){
            
            $beneficiario['bitacora'] = array();

            $stat_bitacora->bindValue(':idcredito', $beneficiario['id_credito'], PDO::PARAM_STR);
            $stat_bitacora->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
            $stat_bitacora->execute();

            $registros = $stat_bitacora->fetchAll(PDO::FETCH_ASSOC);

            $bitacora = array();
            $cantidad_creditos++;

            foreach ($registros as $fila) {
                
                $beneficiario['bitacora'][] = $fila;
                $cantidad_observaciones++;

            }

            $grupos_devueltos[$i]['beneficiarios'][] = $beneficiario;

        }

        $i++;

    }
    
    (object) $grupos = "";

    if($cantidad_creditos && $cantidad_observaciones){
        $grupos['cantidad_creditos'] = $cantidad_creditos;
        $grupos['cantidad_observaciones'] = $cantidad_observaciones;
    }

    $grupos['grupos_devueltos'] = $grupos_devueltos;

    $stat = $conn->prepare('select distinct b.Gestor as gestor
    from bitacora_creditos a left join cartera_consolidada b on a.id_credito = b.id
    where a.razon = "Correccion Control de Calidad" and id_usuario = :usuario group by a.grupo_hash');
    $stat->bindValue(':usuario', $_SESSION['user'], PDO::PARAM_STR);
    $stat->execute();
    
    $gestores = $stat->fetchAll();

}catch(PDOException $e){
    
}

$i = 0;

?>
<div class="section">
    <div class="row">
        <div class="col s12 m8 l10 offset-m2 offset-l1">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">
                        <div class="row">
                            <div class="col l8 tooltipped" data-delay="50" data-position="bottom" data-tooltip="Créditos que han sido registrados en la bitácora con observaciones">Bitácora de devoluciones</div>
                            <div class="col l4">
                            </div>
                        </div>
                    </span>
                    <div id="devueltos-call-center-list">
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

                        <?php if(isset($grupos['cantidad_creditos'])):?>

                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="card-panel blue-grey z-depth-0 white-text">
                                        <div class="row">
                                            <div class="col l3 m3 s12">
                                                <span class="light">Grupos:</span> <?php echo count($grupos_devueltos);?>
                                            </div>
                                            <div class="col l3 m3 s12">
                                                <span class="light">Créditos:</span> <?php echo $grupos['cantidad_creditos'];?>
                                            </div>
                                            <div class="col l3 m3 s12">
                                                <span class="light">Observaciones:</span> <?php echo $grupos['cantidad_observaciones'];?>
                                            </div>
                                            <div class="col l3 m3 s12">
                                                <span class="light">Promedio:</span> <?php echo number_format(($grupos['cantidad_creditos']/($grupos['cantidad_observaciones'] ? $grupos['cantidad_observaciones'] : 1)),2);?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endif;?>

                        <form id="form-grupos-devueltos">
                            <div class="row">

                                <div class="col s12">
                                    <ul class="collapsible grupos-devueltos list z-depth-0" data-collapsible="accordion" id="list-grupos-devueltos">

                                        <li class="">
                                            <b>
                                                <div class="collapsible-header sin-icon">
                                                    <div class="col s2 l2">
                                                        Hash
                                                    </div>
                                                    <div class="col s6 l3 truncate">Nombre del Grupo</div>
                                                    <div class="col s12 l4 hide-on-med-and-down truncate">Gestor</div>
                                                    <div class="col s12 l3 hide-on-med-and-down truncate">Fecha de devolucion</div>
                                                </div>
                                            </b>
                                        </li>

                                        <?php if(count($grupos['grupos_devueltos']) > 0):?>

                                            <?php foreach($grupos['grupos_devueltos'] as $grupo):?>
                                                
                                                <li>
                                                    <div class="collapsible-header sin-icon">
                                                        <div class="col s2 l2 truncate"><i class="material-icons amber-text">access_alarm</i><span class="codigog"><?php echo $grupo['grupo_hash'];?></span></div>
                                                        <div class="col s6 l3 nombreg truncate"><?php echo $grupo['Grupo_Solidario'];?></div>
                                                        <div class="col s12 l4 hide-on-med-and-down gestorg truncate"><?php echo $grupo['Gestor'];?></div>
                                                        <div class="col s12 l3 hide-on-med-and-down estadog truncate"><?php echo $grupo['fecha'];?></div>
                                                    </div>
                                                    <div class="collapsible-body">
                                                        <div class="row">
                                                            <div class="col l10 offset-l1">
                                                                <div><h5 class="light">Beneficiarios</h5></div>
                                                                <table id="tabla-beneficiarios" class="black-text">

                                                                    <thead>
                                                                        <tr>
                                                                            <th class="black-text" data-field="id">Nombre</th>
                                                                            <th class="black-text" data-field="id">Identidad</th>
                                                                            <th class="black-text center" data-field="id">Acciones</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody id="tabla-beneficiarios-content" class="list-beneficiarios"><!--
                                                                        <tr>
                                                                            <td class="grey-text"><a href="#modal-bitacora-beneficiario">Maria Eugenia Lopez</a></td>
                                                                            <td class="grey-text">0801-1999-00325</td>
                                                                        </tr>-->
                                                                        
                                                                        <?php foreach($grupo['beneficiarios'] as $beneficiario):?>

                                                                            <tr class="tr-beneficiario">
                                                                                <td class="grey-text text-darken-3" id="nombre"><?php echo $beneficiario['Nombre'];?></td>
                                                                                <td class="black-text" id="identidad"><?php echo $beneficiario['Identidad'];?></td>
                                                                                <td class="grey-text center-align"><a href="#!" class="tooltipped <?php echo (count($beneficiario['bitacora']) > 0 ? "btn-mostrar-bitacora" : "btn-no-tiene-observacion");?>" data-position="right" data-tooltip="Ver observaciones"><i id="icon" class="material-icons <?php echo (count($beneficiario['bitacora']) > 0 ? "amber-text text-darken-2" : "grey-text text-lighten-2");?>">info</i></a></td>
                                                                                <?php foreach($beneficiario['bitacora'] as $registro):?>
                                                                                    <input type="hidden" class="registro-bitacora" value="<?php echo $registro['observacion'];?>">
                                                                                <?php endforeach;?>
                                                                            </tr>
                                                                        
                                                                        <?php endforeach;?>

                                                                    </tbody>
                                                                </table>
                                                                <div class="divider"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                            <?php endforeach;?>

                                        <?php else:?>

                                            <li>
                                                <div class="collapsible-header sin-icon">
                                                    <div class="col s12 l12">
                                                        <center>
                                                            <h5>No hay créditos registrados.</h5>
                                                        </center>
                                                    </div>
                                                </div>
                                            </li>

                                        <?php endif;?>
                                    </ul>
                                    <ul id="pag-control" class="pag pagination">
                                    </ul>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-bitacora-beneficiario" class="modal">
    <div class="modal-content">
        <h4 class="light blue-text">Observaciones del beneficiario</h4>
        <div id="modal-content">
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-blue btn-flat">Gracias</a>
    </div>
</div>
<script>
    $(document).ready(function(){
        
        $('#breadcrum-title').text('Bitácora de devoluciones');
        
        $('select').material_select();

        $('.tooltipped').tooltip();

        $('.collapsible').collapsible();

        $('.modal').modal();

        $('#select-filtro-gestor').on('change', function(){
        
            $('#buscarHas').val($('#select-filtro-gestor option:selected').val());
            window.listObj.fuzzySearch($('#select-filtro-gestor option:selected').val());
            
        });

        $('.btn-mostrar-bitacora').click(function(){

            $('#modal-bitacora-beneficiario').find('#modal-content').empty();

            $(this).parent().parent().find('.registro-bitacora').each(function(){
                $('#modal-bitacora-beneficiario').find('#modal-content').append('<p><input type="checkbox" id="check1" checked="checked" disabled="disabled"/><label for="check1">'+$(this).val()+'</label></p>');
                console.log($(this).val());
            });

            $('#modal-bitacora-beneficiario').modal('open');
        });

        $('.btn-no-tiene-observacion').click(function(){
            swal('', 'El beneficiario no tiene observaciones registradas', 'info');
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
        window.listObj = new List('devueltos-call-center-list', options); 
    });
</script>