<?php

try{
    
    require '../php/conection.php';
    session_start();
    
    // Para los movilizadores
    $movilizadores = '("P08","P09","P10","P11","P15")';
    $programa = ($_SESSION['designation'] == '55' ? ' and programa in '.$movilizadores : '');
    $sql = 'select distinct grupo_solidario_hash, Grupo_Solidario, gestor, Estatus_Prestamo 
    from cartera_consolidada where Estatus_Prestamo = "Para Coordinacion" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')'.$programa;
    
    $stat = $conn->prepare($sql);
    $stat->execute();
    
    $grupos_recibidos = $stat->fetchAll();
    
    $stat = $conn->prepare('select distinct gestor from cartera_consolidada where Estatus_Prestamo = "Para Coordinacion" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');
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
                                <div class="col l8">Créditos Recibidos</div>
                                <div class="col l4">
                                                    
                                </div>
                            </div>
                        </span>
                        <div id="recibidos-coordinadores-list">
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
                            <div class="row">

                                <form id="form-grupos-recibidos">
                                    <div class="col s12">
                                        <ul class="collapsible grupos-recibidos list z-depth-0" data-collapsible="accordion" id="lista-grupos-recibidos">
                                            <li class="">

                                                <div class="collapsible-header sin-icon">
                                                    <div class="col s12 l2">
                                                        Check/Hash
                                                    </div>
                                                    <div class="col s12 l3 hide-on-med-and-down truncate">Nombre del Grupo</div>
                                                    <div class="col s12 l4 hide-on-med-and-down truncate">Gestor</div>
                                                    <div class="col s12 l2 hide-on-med-and-down truncate">Estado</div>
                                                </div>

                                            </li>
                                            
                                            <?php if(count($grupos_recibidos) != 0):?>

                                                <?php foreach($grupos_recibidos as $grupo):?>
                                                   
                                                    <li>
                                                        <div class="collapsible-header sin-icon">
                                                            <div class="col s12 l2">
                                                                <input type="checkbox" class="filled-in checkhash" id="recibido<?php echo ++$i;?>" name="<?php echo $grupo['grupo_solidario_hash'];?>"/>
                                                                <label class="codigog" for="recibido<?php echo $i;?>"><?php echo $grupo['grupo_solidario_hash']?></label>
                                                            </div>
                                                            <div class="col s12 l3 hide-on-med-and-down nombreg truncate"><?php echo $grupo['Grupo_Solidario']?></div>
                                                            <div class="col s12 l4 hide-on-med-and-down gestorg truncate"><?php echo $grupo['gestor']?></div>
                                                            <div class="col s12 l3 hide-on-med-and-down estadog truncate"><?php echo $grupo['Estatus_Prestamo']?></div>
                                                        </div>
                                                    </li>

                                                <?php endforeach;?>

                                            <?php else:?>

                                                <li>
                                                    <div class="collapsible-header sin-icon">
                                                        <div class="col s12 l12">
                                                            <center>
                                                                <h5>No hay créditos Recibidos.</h5>
                                                            </center>
                                                            <!--<input type="checkbox" class="filled-in" id="recibido"/>-->
                                                        </div>
                                                    </div>
                                                </li>

                                            <?php endif;?>
                                            
                                        </ul>
                                        <ul id="pag-control" class="pag pagination">
                                        </ul>
                                    </div>
                                </form>

                            </div>
                            <div class="row">
                                <div class="input-field col s12 l6 offset-l3">
                                    <a id="recibidos-success" href="#!" class="btn waves-effect waves-light col s12 ">Imprimir Lista</a>
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
        
        window.grupos = [];
        
        $('#breadcrum-title').text('Recepción de Créditos');
        
        $('select').material_select();
        
        $('collapsible').collapsible();
    
        $('#select-filtro-gestor').on('change', function(){
        
            $('#buscarHas').val($('#select-filtro-gestor option:selected').val());
            window.listObj.fuzzySearch($('#select-filtro-gestor option:selected').val());
        
        });
        
        $('.checkhash').click(function(){
            
            if($(this)[0].checked){
                window.grupos.push($(this).attr('name'));
            }else{
                let ind = window.grupos.indexOf($(this).attr('name'));
                window.grupos.splice(ind, 1);
            }

            console.log(window.grupos);

        });
        
        $('#recibidos-success').click(function(){
            
            var ningunoMarcado = true;
            
            if(window.grupos.length == 0){
                swal("Ningún Crédito Seleccionado", "Por favor seleccione los créditos que recibió", "error");
                return false;
            }
            
            swal({
                title: "¿Se le entregaron los creditos seleccionados?",
                text: "Al precionar el boton de Confirmar, "+ (window.grupos.length > 1 ? "los "+window.grupos.length+" grupos seleccionados pasarán" : "el grupo seleccionado pasará") +" a la ventana de Aprobación para ser "+(window.grupos.length > 1 ? "procesados" : "procesado"),
                type: "warning",
                showCancelButton: true,
                /*confirmButtonColor: "#DD6B55",*/
                confirmButtonText: "Confirmar",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                cancelButtonText: "Cancelar"
            },
            function(){
                $.ajax({
                    type: 'POST',
                    url: '../php/coordinadores/recibir-grupos.php',
                    data: 'credito='+JSON.stringify(window.grupos),
                    success: function(data){
                        
                        if(data){
                            swal({
                                title: "Completado", 
                                text: "El crédito se ha recibido con exito.", 
                                type: "success"
                            }, function(){
                                window.open('../docs/'+data, '_blank');
                                $('#floating-refresh').trigger('click');
                            });
                        }

                    }
                });
            });
            
        });
                 
        listaSor();
        
    });

function listaSor(){
    
    var options = {
        page: 50,
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
    window.listObj = new List('recibidos-coordinadores-list', options);
    
}
    
</script>