<?php 

require '../php/conection.php';

session_start();

$user = $_SESSION['user'];

$getSupervisores = $conn->prepare('select nombre, id from gsc where parent = :user and activo = 1');
$getSupervisores->bindValue(':user', $user, PDO::PARAM_STR);
$getSupervisores->execute();
$supervisores = $getSupervisores->fetchAll(PDO::FETCH_ASSOC);

$getGestores = $conn->prepare('select nombre, id from gsc where tipoEmpleado = "Gestor" and parent = :user and activo = 1');
$getGestores->bindValue(':user', $user, PDO::PARAM_STR);
$getGestores->execute();
$gestores = $getGestores->fetchAll(PDO::FETCH_ASSOC);

//var_dump($supervisores);

?>
   

   
   
   
   
   <div class="section">
    <div class="row">
        
            
              <?php if(count($supervisores) > 0):?>
                <div class="input-field col s12 l4">
                   
                    <select class="js-example-data-array js-states browser-default" tabindex="-1" style="width: 100%" id="supervisoresSelect">
                        <option value=""></option>
                        <?php $i=0;?>
                            <?php if(count($supervisores) > 0):?>
                                <?php foreach($supervisores as $supervisor):?>
                                    <?php $i++;?>
                                    <option value="<?php echo $supervisor['id']; ?>"><?php echo $supervisor['nombre']; ?></option>
                                <?php endforeach;?>
                            <?php endif;?>
                    </select>
                    
                </div>
                    
                <div class="input-field col s12 l4">

                    <select class="js-example-data-array js-states browser-default" tabindex="-1" style="width: 100%" id="asesoresSelect">
                        <option value=""></option>
                    </select>

                </div>
                
              <?php else:?>
                   <div class="input-field col s12 l4">
                       
                        <select disabled class="js-example-data-array js-states browser-default" tabindex="-1" style="width: 100%" id="supervisoresSelect">
                          <option value="" disabled selected>No tiene supervisores</option>
                            
                        </select>
                        
                    </div>
                    
                    <div class="input-field col s12 l4">
                       
                        <select class="js-example-data-array js-states browser-default" tabindex="-1" style="width: 100%" id="asesoresSelect">
                            <option value=""></option>
                            <?php $i=0;?>
                                        <?php if(count($gestores) > 0):?>
                                            <?php foreach($gestores as $gestor):?>
                                                <?php $i++;?>
                                                <option value="<?php echo $gestor['id']; ?>"><?php echo $gestor['nombre']; ?></option>
                                            <?php endforeach;?>
                                        <?php endif;?>
                        </select>
                        
                    </div>
              <?php endif;?>
            
    </div>
<br>
    <div class="row">
        <div class="col s12 m12 l12">
            <div id="work-collapsible">
                    <div class="row">
                        <div class="col s12" id="todos-los-creditos">
                            <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                <li class="collapsible-item-header avatar">
                                    <i class="material-icons circle light-blue">list</i>
                                    <span id="superviNombre" class="collapsible-title-header"><?php echo "##";?>
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
                                    <p>cartera de: <span id="nombreAsesortitle"></span></p>
                                </li>
                                <div id="headersList"></div>
                                
                                <div class="list collapsible no-padding no-margin z-depth-0">
                                    
                                    
                                    <li id="nohaynada" class="center">
                                        <h5>No hay ningún beneficiario</h5>
                                    </li>
                                    
                                </div>
                                <li>
                                    <div class="collapsible-footer  sin-icon" style="border-bottom: 1px solid #e0e0e0; line-height: 30px;">
                                        <div class="row">
                                            <span id="totalregistros" class="right">total: <?php echo "##"; ?> registros</span>
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
</div>


<script src="../js/plugins/numeral/numeral.js"></script>

<script>
    $(document).ready(function() {

        $('select').select2();
        $('.collapsible').collapsible();
       
        
        if(window.innerWidth < 993){
            $('#btnFiltrar').css('width','100%');
        }
        
        
    //////////////////////////////////////////////// SUPERVISORES SLECT2 /////////////////////////////////////////////////////
        window.nombreSupervisor = "";
        window.spervisorAsesror = false;
        $("#supervisoresSelect").select2({
            placeholder: 'Seleccione un supervisor',
            //data: data,
        });
        
        $("#supervisoresSelect").on('change', function() {
            //console.log($('#supervisorSelect option:selected').val());
            window.spervisorAsesror = false;
            
            window.nombreSupervisor = $('#supervisoresSelect option:selected').text();
            window.idSupervisor = $('#supervisoresSelect option:selected').val();
            
            
            $('#btnFiltrar').removeClass('disabled');
            $.ajax({
                type: 'POST',
                async: true,
                data: {
                        supervisor: window.nombreSupervisor,
                        id: $('#supervisoresSelect option:selected').val()
                      },
                url: '/csfrontend/coordinadores/'+'carterasFiltradasConsultas.php', 
                success: function(data){
                    var datos = JSON.parse(data);
                    //console.log(datos);
                    
                    $('#superviNombre').text($('#supervisorSelect option:selected').text());
                    $('#nombreAsesortitle').text(window.nombreSupervisor);
                    
                    $('#asesoresSelect').removeAttr('disabled');
                    $('#asesoresSelect').empty();
                    $('#asesoresSelect').append(`<option value=""></option>`);
                    $.each(datos, function(index, value){
                        $('#asesoresSelect').append(`
                            <option value=`+value.id+`>`+value.nombre+`</option>
                        `);
                    });
                    $("#asesoresSelect").select2({
                        placeholder: 'Seleccione un asesor',
                        //data: data,
                    });
                    
                    
                }
            });
            
            //////////////////////////LISTA DE CARTERA/////////////////////////////////////7
            $.ajax({
            type: 'POST',
            async: true,
            data: {
                id_supervisor_cartera: window.idSupervisor
            },
            url: '/csfrontend/coordinadores/'+'carterasFiltradasConsultas.php', 
            success: function(data){
                var listCarteraSupervisor = JSON.parse(data);
                //console.log(data);
                
                if(listCarteraSupervisor.length > 0){
                    $('#headersList').empty();
                    $('#headersList').append(`
                        <li>
                                    <div class="collapsible-header-titles  sin-icon">
                                        <div class="row">
                                            <div class="col s8 m3 l3">
                                                <p class="collapsible-title">Nombre</p>
                                            </div>
                                            <div class="col s3 m3 l2 hide-on-small-only">
                                                <p class="collapsible-title">Créditos</p>
                                            </div>
                                            <div class="col s3 m3 l2">
                                                <p class="collapsible-title">% Mora</p>
                                            </div>
                                            <div class="col s3 m3 l3 hide-on-small-only">
                                                <p class="collapsible-title">Mora</p>
                                            </div>
                                            <div class="col s6 m3 l2 hide-on-small-only">
                                                <p class="collapsible-title">Saldo Capital</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                    `);
                    
                    $('.list').empty();
                    
                    $.each(listCarteraSupervisor, function(index, value){
                        $('.list').append(
                        `<li>
                            <div class="collapsible-header sin-icon">
                                <div class="row">
                                    <div class="col s8 m3 l3">
                                        <p class=" nombre collapsible-content truncate">`+value.gestor+`</p>
                                    </div>
                                    <div class="col s3 m3 l2 hide-on-small-only">
                                        <p class="collapsible-content truncate">`+value.creditos+`</p>
                                    </div>
                                    <div class="col s3 m3 l2">
                                        <p class="collapsible-content truncate">`+numeral(value.porcentajeMora).format('0.00%')+"%"+`</p>
                                    </div>
                                    <div  class="col s3 m3 l3  light truncate hide-on-small-only">
                                        <p class="collapsible-content">`+"L. "+numeral(value.capitalMora).format('$0,0.00')+`</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only light truncate">
                                        <p class="collapsible-content">`+"L. "+numeral(value.saldoCapital).format('$0,0.00')+`</p>
                                    </div>
                                </div>
                            </div>
                            <div class="collapsible-body">
                                <p><b>Cantidad de Créditos: </b>`+numeral(value.creditos).format('00')+`</p>
                               <p><b>Monto Desembolsado: </b>`+"L. "+numeral(value.montoDesembolsado).format('$0,0.00')+`</p>
                               <p><b>Capital en Mora: </b>`+"L. "+numeral(value.capitalMora).format('$0,0.00')+`</p>
                                <p><b>Saldo: </b>`+"L. "+numeral(value.saldoCapital).format('$0,0.00')+`</p>
                            </div>
                        </li>`
                        );
                    });
                    
                    $('#totalregistros').text("total de " + listCarteraSupervisor.length + " registros");
                    $('#titutloNombre').text(window.nombreSupervisor);
                    $('#descripcionNombre').text(window.nombreSupervisor);
                }
            }
        });
        });
        
        
        /////////////////////////////////////////////// ASESORES SLECT2 /////////////////////////////////////////////////////
        
        window.nombreAsesor = "";
        $("#asesoresSelect").select2({
            placeholder: 'Seleccione un asesor',
            //data: data,
        });
        
        window.idAsesor = "";
        $("#asesoresSelect").on('change', function() {
            //console.log($('#supervisorSelect option:selected').text());
            window.spervisorAsesror = true;
            
            window.nombreAsesor = $('#asesoresSelect option:selected').text();
            window.idAsesor = $('#asesoresSelect option:selected').val();
            
            $('#nombreAsesortitle').text(window.nombreAsesor);
            //console.log(window.idAsesor);
            
            $.ajax({
                type: 'POST',
                async: true,
                data: {
                        nombre_asesor_cartera: window.nombreAsesor,
                        id_asesor_list: window.idAsesor
                      },
                url: '/csfrontend/coordinadores/'+'carterasFiltradasConsultas.php', 
                success: function(data){
                    $('#loading').hide();
                   // console.log(data);
                    var datosAsesor = JSON.parse(data);
                    //console.log(datosAsesor);
                    if(data.length > 0){
                         $('#nohaynada').hide();
                    }
                    
                    $('#headersList').empty();
                    
                    
                        $('#headersList').append(`
                        <li>
                            <div class="collapsible-header-titles  sin-icon">
                                <div class="row">
                                    <div class="col s4 m3 l2">
                                        <p class="collapsible-title">Identidad</p>
                                    </div>
                                    <div class="col s5 m3 l3">
                                        <p class="collapsible-title">Nombre</p>
                                    </div>
                                    <div class="col s3 m3 l2">
                                        <p class="collapsible-title">Mora</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only">
                                        <p class="collapsible-title">Saldo Capital</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only">
                                        <p class="collapsible-title">Capital Mora</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `);
                        
                    $('.list').empty();
                        
                    for(var i = 0; i < datosAsesor.length; i++){
                        $('.list').append(
                        `<li>
                            <div class="collapsible-header sin-icon">
                                <div class="row">
                                    <div class="col s4 m3 l2">
                                        <p class="collapsible-content truncate">`+datosAsesor[i].Identidad+`</p>
                                    </div>
                                    <div class="col s5 m3 l3">
                                        <p class="nombre collapsible-content truncate">`+datosAsesor[i].Nombre_Completo+`</p>
                                    </div>
                                    <div  class="col s3 m3 l2  light truncate">
                                        <p class="collapsible-content">`+numeral(datosAsesor[i].mora).format('0.0%')+'%' +`</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only light truncate">
                                        <p class="collapsible-content">`+"L. " +numeral(datosAsesor[i].saldo_capital).format('$0,0.00')+`</p>
                                    </div>
                                    <div class="col s6 m3 l2 hide-on-small-only light truncate">
                                        <p class="collapsible-content">`+"L. " +numeral(datosAsesor[i].capital_mora).format('$0,0.00')+`</p>
                                    </div>
                                </div>
                            </div>
                            <div class="collapsible-body">
                               <p class="hide-on-large-only"><b>Identidad: </b>`+datosAsesor[i].Identidad+`</p>
                               <p class="hide-on-large-only"><b>Nombre: </b>`+datosAsesor[i].Nombre_Completo+`</p>
                               <p><b>Dirección del Domicilio: </b>`+datosAsesor[i].Direccion+`</p>
                                <p><b>Dirección del Negocio: </b>`+datosAsesor[i].Negocio+`</p>
                                <p><b># Prestamo: </b>`+datosAsesor[i].Numero_Prestamo+`</p>
                                <p><b>Saldo Capital: </b>`+"L. " +numeral(datosAsesor[i].saldo_capital).format('$0,0.00')+`</p>
                                <p><b>Capital Mora: </b>`+"L. " +numeral(datosAsesor[i].capital_mora).format('$0,0.00')+`</p>
                                <p><b>% Mora: </b>`+numeral(datosAsesor[i].mora).format('0.00%')+"%"+`</p>
                            </div>
                        </li>`
                        );
                    }
                        
                    $('#totalregistros').text("total de " + datosAsesor.length + " registros");
                    $('#titutloNombre').text(window.nombreAsesor);
                    $('#descripcionNombre').text(window.nombreAsesor);
                
            }
        });
            
        });
        
        
        

    }); // FINAL DE DOCUMENT READY

</script>
