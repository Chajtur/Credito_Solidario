<?php

require '../php/conection.php';
session_start();
//Captura de los datos que se mostrarán en la ventana
$stat = $conn->prepare('select distinct grupo_solidario_hash, Grupo_Solidario, gestor, Estatus_Prestamo, ciclo 
    from cartera_consolidada where Estatus_Prestamo = "Coordinacion" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');
$stat->execute();
$grupos = $stat->fetchAll();

//Stat para capturar los beneficiarios de cada grupo
$stat = $conn->prepare('select id, identidad, nombre from cartera_consolidada 
    where Estatus_Prestamo = "Coordinacion" and grupo_solidario_hash = :hash');

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
$stat = $conn->prepare('select distinct gestor from cartera_consolidada where Estatus_Prestamo = "Coordinacion"');
$stat->execute();
    
$gestores = $stat->fetchAll();

?>
   

<!--<link rel="stylesheet" href="../js/plugins/candle-switch/css/candlestick.css">
    <link rel="stylesheet" href="../js/plugins/candle-switch/css/candlestick-maerial.css">-->
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

                                        <option value="<?php echo $gestor['gestor'];?>"><?php echo $gestor['gestor'];?></option>

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
                                    <ul class="collapsible grupos-recibidos list z-depth-0" id="list-grupos" data-collapsible="accordion">
                                       
                                        <li>
                                          <div class="collapsible-header sin-icon">
                                              <div class="col s12 l2">Acción</div>
                                              <div class="col s12 l1">Hash</div>
                                              <div class="col s12 l3">Grupo</div>
                                              <div class="col s12 l3">Gestor</div>
                                              <div class="col s12 l2">estado</div>
                                          </div>
                                        </li>   
                
                                        <?php if(count($grupos_beneficiarios) != 0):?>
                                           
                                        <?php $i = 0;?>
                                            
                                        <?php foreach($grupos_beneficiarios as $grupo):?>
                                        
                                        <li class="li-grupo" id="<?php echo $grupo['hash'];?>">
                                            <div class="col s12 l2">
                                            <!--<p class="p-tri-switch">-->
                                                <input type="checkbox" id="ts-loop<?php echo $i;?>" class="denegarAprobar"/>
                                            <!--</p>-->
                                            </div>
                                            <div class="collapsible-header sin-icon">
                                                <div>
                                                    <div class="col s12 l1 hide-on-med-and-down codigog truncate global-codigo-grupo-hash"><?php echo $grupo['hash'];?></div>
                                                </div>
                                                <div class="col s12 l3 hide-on-med-and-down nombreg truncate global-nombre-grupo"><?php echo $grupo['nombre_grupo'];?></div>
                                                <div class="col s12 l3 gestorg truncate hide-on-med-and-down global-gestor"><?php echo $grupo['gestor'];?></div>
                                                <div class="col s12 l2 estadog truncate hide-on-med-and-down global-estatus-prestamo"><?php echo $grupo['estatus_prestamo'];?></div>
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

    
</div>
  
<script>
       
    $(document).ready(function(){
        
        /*swtichTriple();*/
        $('#breadcrum-title').text('Verificación de Créditos');
        
        var denegarAprobar = $('.denegarAprobar');
        denegarAprobar.candlestick();
        /*denegarAprobar.candlestick('reset');*/
        $('.candlestick-toggle').css('left', '20px');
        $('.candlestick-toggle').css('top', '-3px');
        
    
        /*
        ===INICIALIZACIONES===
        */
        
        initEmptyObject();
        
        window.currentids = {
            parent: 0,
            child: 0
        }
    
        $('.collapsible').collapsible();
        
    
        $('select').material_select();
    
        $('.tooltipped').tooltip();
        
        $('.denegarAprobar').each(function(){
            
            var thishidden = $(this);
            thishidden.change(function(){
                
                var currid = thishidden.parent().parent().parent().parent().attr('id');
                
                $.each(window.grupos, function(index, value){
                    if(value.hash == currid){
                        value.estado = thishidden.val();
                        //console.log(value);
                        //console.log(value);
                    }
                });
                
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
    
        $('#select-filtro-gestor').on('change', function(){
        
            $('#buscarHas').val($('#select-filtro-gestor option:selected').text());
            window.listObj.fuzzySearch.search($('#select-filtro-gestor option:selected').text());
        
        });        
        
        $('#verificados-success').click(function(){
            
            var ningunCambio = true;
            $.each(window.grupos, function(index, value){
                if(value.estado){
                    console.log(value.estado);
                    ningunCambio = false;
                }
                return ningunCambio;
            });
            
            if(ningunCambio){
                swal("Nada modificado", "Por favor marque al menos un grupo");
                return false;
            }
            
            swal({
                title: "¿Esta seguro que desea procesar los créditos marcados?",
                text: "Al presionar el botón de Confirmar, los créditos serán procesados según el estado que usted ha seleccionado.",
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
                    data: {
                        data: JSON.stringify(window.grupos)
                    },
                    url: '../php/coordinador-digitador/verificar-coordinacion.php',
                    success: function(data){

                        //Materialize.toast(data, 2000);
                        if(data == true){

                            swal("Completado", "¡Los créditos se han procesado correctamente!", "success");
                            $('#floating-refresh').trigger('click');

                        }else{

                            Materialize.toast(data);
                            console.log(data);

                        }

                    }
                });
            });
            
        });
        
        /*listaSor();*/
        
    });

    /*function listaSor(){
    
    var options = {
            page: 6,
            valueNames: [ 'codigog', 'nombreg', 'gestorg', 'estadog' ],
            plugins: [
                ListFuzzySearch(), ListPagination({})
            ]
    };
    window.listObj = new List('recibidos-coordinadores-list', options);
    
}*/

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
            estado: null
        }
        
        window.grupos.push(tempobject);
        
    });
    
    console.log(window.grupos);
    
}
    
</script>