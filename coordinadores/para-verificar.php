<?php

require '../php/conection.php';
session_start();

// Para los movilizadores
$movilizadores = '("P08","P09","P10","P11","P15","P03")';
$programa = ($_SESSION['designation'] == '55' ? ' and programa in '.$movilizadores : '');
$sql = 'select distinct grupo_solidario_hash, Grupo_Solidario, gestor, Estatus_Prestamo 
from cartera_consolidada where Estatus_Prestamo = "Coordinacion" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')'.$programa;

$stat = $conn->prepare($sql);
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
$stat = $conn->prepare('select distinct gestor from cartera_consolidada where Estatus_Prestamo = "Coordinacion" and agencia in ('.'"'.implode('","', $_SESSION['agencia']).'"'.')');
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
                                    <ul class="collapsible grupos-recibidos list z-depth-0" id="list-grupos" data-collapsible="accordion">
                                       
                                        <li>
                                          <div class="collapsible-header sin-icon">
                                              <div class="col s12 l2 no-padding">Acción</div>
                                              <div class="col s12 l1 no-padding">Hash</div>
                                              <div class="col s12 l3 no-padding">Grupo</div>
                                              <div class="col s12 l3 no-padding">Gestor</div>
                                              <div class="col s12 l2 no-padding">estado</div>
                                          </div>
                                        </li>   
                
                                        <?php if(count($grupos_beneficiarios) != 0):?>
                                           
                                        <?php $i = 0;?>
                                            
                                        <?php foreach($grupos_beneficiarios as $grupo):?>
                                        
                                        <li class="li-grupo" id="<?php echo $grupo['hash'];?>">
                                            <div class="col s12 l1">
                                            <!--<p class="p-tri-switch">-->
                                                <input type="checkbox" id="ts-loop<?php echo $i;?>" class="denegarAprobar"/>
                                            <!--</p>-->
                                            </div>
                                            <div class="col s12 l1 center candlestick-wrapper"><a id="btn-observacion" class="tooltipped grey-text lighten-4 btn-modal-observacion" data-position="top" data-delay="50" data-tooltip="Observación"><i class="material-icons">visibility</i></a></div>
                                            <div class="collapsible-header sin-icon">
                                                <div>
                                                    <div class="col s12 l1 hide-on-med-and-down codigog truncate global-codigo-grupo-hash" id="lbl-grupo-hash"><?php echo $grupo['hash'];?></div>
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
                                                            <table id="tabla-verificar-call-center" class="">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="grey-text" data-field="id">Nombre</th>
                                                                        <th class="grey-text" data-field="id">Identidad</th>
                                                                        <th class="grey-text center" data-field="id">Acciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php $j = 0;?>

                                                                    <?php foreach($grupo['beneficiarios'] as $beneficiario):?>

                                                                        <tr class="beneficiario-row">
                                                                            <td class="grey-text global-beneficiario-nombre"><a href="#!" class="a-open-checklist"><?php echo $beneficiario['nombre'];?></a></td>
                                                                            <td class="grey-text global-beneficiario-identidad"><?php echo $beneficiario['identidad'];?></td>
                                                                            <td class="grey-text center"><a href="#!" id="" class="tooltipped btn-modal-bitacora" data-position="right" data-delay="50" data-tooltip="Mostrar Bitácora"><i class="material-icons">update</i></a></td>
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

<div id="modal-bitacora-beneficiario" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4 class="light blue-text">Bitácora</h4>

        <div class="container center" id="bitacora-loading">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
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

        <div id="content-container">

            <table class="bordered">
                <thead>
                    <tr>
                        <th>Razon</th>
                        <th>Observación</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Usuario</th>
                    </tr>
                </thead>

                <tbody id="tbody-column-row">
                </tbody>
            </table>

        </div>
        
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Gracias</a>
    </div>
</div>

<div id="modal-observacion-ben" class="modal">
    <div class="modal-content">
        <h4 class="light blue-text">Observación</h4>
        <div class="input-field">
            <input id="input-observacion" type="text" class="">
            <label for="observacion">Texto</label>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Listo</a>
    </div>
</div>
<!--<script src="../js/plugins/candle-switch/js/candlestick.js"></script>
      -->
<script>
       
    $(document).ready(function(){

        window.currentindex = "";

        $('.btn-modal-observacion').click(function(){

            var hash = $(this).parent().parent().find('#lbl-grupo-hash').text();

            $.each(window.grupos, function(index, value){
                if(value.hash == hash){
                    window.currentindex = index;
                    return false;
                }
            });

            $('#input-observacion').val('');
            $('#input-observacion').next().removeClass('active');
            if(window.grupos[window.currentindex].observacion){
                $('#input-observacion').val(window.grupos[window.currentindex].observacion);
                $('#input-observacion').next().addClass('active');
            } 

        });

        $('.btn-modal-bitacora').click(function(){

            var id_credito = $(this).parent().parent().find('#id_credito').val();

            $('#bitacora-loading').fadeIn(100);
            $('#content-container').fadeOut(100);
            $('#modal-bitacora-beneficiario').modal('open');

            $.ajax({
                type: 'POST',
                url: '../php/coordinadores/obtener-bitacora.php',
                data: 'id='+id_credito,
                success: function(data){
                    
                    var obj = JSON.parse(data);
                    $.each(obj, function(index, value){
                        $('#tbody-column-row').append('<tr><td>'+value.razon+'</td><td>'+value.observacion+'</td><td>'+value.fecha+'</td><td>'+value.estado_credito+'</td><td>'+value.nombre+'</td></tr>');
                    });
                    $('#bitacora-loading').fadeOut(100, function(){
                        $('#content-container').fadeIn(100);
                    });

                }
            });

        });

        $('#input-observacion').on('input', function(){
            window.grupos[window.currentindex].observacion = $(this).val();
            if($('#'+window.grupos[window.currentindex].hash).find('#btn-observacion').hasClass('yellow-text')){
                $('#'+window.grupos[window.currentindex].hash).find('#btn-observacion').removeClass('yellow-text').addClass('green-text');
            }
        });

        $('.modal').modal();

        initModal();

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

                var btnobserv = $(this).parent().parent().parent().next().find('#btn-observacion');

                if(thishidden.val() == "0"){

                    btnobserv.removeClass('grey-text lighten-4').addClass('yellow-text');
                    btnobserv.attr('href', '#modal-observacion-ben');

                }else{

                    btnobserv.removeClass('yellow-text').addClass('grey-text lighten-4');
                    btnobserv.removeAttr('href');
                    if(window.grupos[window.currentindex].observacion){
                        delete window.grupos[window.currentindex].observacion;
                        $('#input-observacion').val('');
                    }

                }
                
            });
            
        });
        
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
        window.listObj = new List('por-verificar-list', options);
    
        $('#select-filtro-gestor').on('change', function(){
        
            $('#buscarHas').val($('#select-filtro-gestor option:selected').val());
            window.listObj.fuzzySearch($('#select-filtro-gestor option:selected').val());
        
        });        
        
        $('#verificados-success').click(function(){
            
            var ningunCambio = true;
            $.each(window.grupos, function(index, value){
                if(value.estado){
                    // console.log(value.estado);
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
                    url: '../php/coordinadores/completar-verificar.php', //falta progrmas este archivo//
                    success: function(data){

                        //Materialize.toast(data, 2000);
                        if(data == true){

                            swal("Completado", "¡Los créditos se han procesado correctamente!", "success");
                            $('#floating-refresh').trigger('click');

                        }else{

                            Materialize.toast(data);
                            // console.log(data);

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

function initModal(){

    $('#content-container').fadeOut();

}

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
    
    // console.log(window.grupos);
    
}
    
</script>