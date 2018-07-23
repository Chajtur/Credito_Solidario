<?php

require '../php/conection.php';
session_start();
$stat = $conn->prepare('select nombre_documento, fecha_log, usuario from registro_documentos where usuario = :usuario order by fecha_log desc');
$stat->bindValue(':usuario', $_SESSION['user'], PDO::PARAM_STR);
$stat->execute();
$documentos = $stat->fetchAll();

$stat = $conn->prepare('select distinct month(fecha_log) as mes, fecha_log from registro_documentos where usuario = :usuario group by mes order by fecha_log desc');
$stat->bindValue(':usuario', $_SESSION['user'], PDO::PARAM_STR);
$stat->execute();
$dropdownfilter = $stat->fetchAll();

?>
<div class="section">
    <div class="row">
        <div class="col l10 offset-l1 m10 offset-m1 s10 offset-s1">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">
                        <div class="row">
                            <div class="col l8">Documentos Generados</div>
                            <div class="col l4">
                            </div>
                        </div>
                    </span>
                    <div id="div-documentos">
                        <div class="row">
                            <div class="col s12 l6 input-field">
                                <input id="buscarHas" type="text" class="validate fuzzy-search" placeholder="Filtro por todo">
                            </div>
                            <div class="col s12 l6 input-field">

                                <select id="select-filtro-mes">
                                   
                                    <option value="" disabled selected>Elija uno</option>
                                    
                                    <?php foreach($dropdownfilter as $mes):?>
                                        
                                        <?php $date = new DateTime($mes['fecha_log']);?>
                                        <option value="<?php echo $mes['mes']?>/"><?php echo $date->format('F');?></option>
                                    
                                    <?php endforeach;?>

                                </select>
                                <label>Filtrar por Mes</label>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12" id="">
                                <form>
                                    <ul class="collapsible documentos-generados list z-depth-0" data-collapsible="accordion">

                                        <li class="">
                                            <div class="collapsible-header sin-icon">
                                                <div class="col s6 l7">
                                                    <span class="" for="recibido">Nombre del archivo</span>
                                                </div>
                                                <div class="col s4 l3 truncate">Fecha</div>
                                                <div class="col s2 l2 truncate">Hora</div>
                                            </div>
                                        </li>

                                        <?php if(count($documentos) > 0):?>

                                            <?php foreach($documentos as $documento):?>

                                               <?php $date = new DateTime($documento['fecha_log']);?>

                                                <li>
                                                    <div class="collapsible-header sin-icon">
                                                        <div class="col s6 l7 nombre truncate"><a href="../docs/<?php echo $documento['nombre_documento'];?>" target="_blank"><?php echo $documento['nombre_documento'];?></a></div>
                                                        <div class="col s4 l3 fecha truncate"><?php echo $date->format('d/m/Y');?></div>
                                                        <div class="col s2 l2 hora truncate"><?php echo $date->format('H:i:s');?></div>
                                                    </div>
                                                </li>

                                            <?php endforeach;?>

                                        <?php else:?>

                                            <li>
                                                <div class="collapsible-header sin-icon">
                                                    <div class="col s12 l12">
                                                        <center>
                                                            <h5>No hay documentos generados.</h5>
                                                        </center>
                                                        <!--<input type="checkbox" class="filled-in" id="recibido"/>-->
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
        </div>
    </div>
</div>
<script>

    $(document).ready(function(){
        
        $('#breadcrum-title').text('Documentos Generados');
        
        $('select').material_select();
        
        $('#select-filtro-mes').on('change', function(){
        
            $('#buscarHas').val($('#buscarHas').val()+' '+$('#select-filtro-mes option:selected').val());
            window.listObj.fuzzySearch.search($('#select-filtro-mes option:selected').val());

        });
        
        var options = {
            page: 10,
            valueNames: [ 'nombre', 'fecha', 'hora' ],
            plugins: [
                ListFuzzySearch({
                    searchClass: "fuzzy-search"
                }), ListPagination({})
            ]
        };
        window.listObj = new List('div-documentos', options);
        
    });
    
</script>