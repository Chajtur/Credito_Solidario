<?php session_start();?>
<?php if(isset($_POST['data'])):?>

    <?php $data = json_decode($_POST['data'], true);?>

    <?php if(count($data) > 0):?>
   
        <div class="section">
            <div class="row margin">

                <div id="work-collapsible">
                    <div class="row">
                        <div class="col s12">
                            <ul id="beneficiarios-list" class="collapsible" data-collapsible="accordion">
                                <li class="collapsible-item-header avatar">
                                    <i class="material-icons circle light-green">list</i>
                                    <span class="collapsible-title-header">Busqueda General
                                        <div class="secondary-content actions">
                                            <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                            <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                                <i class="material-icons center-align">search</i>
                                            </a>
                                        </div>
                                    </span>
                                    <p>Resultados de la búsqueda:</p>
                                    <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                </li>
                                
                                <li>
                                    <div class="collapsible-header-titles  sin-icon">
                                        <div class="row">
                                            <div class="col s1 m1 l1">
                                                <p class="collapsible-title">#</p>
                                            </div>
                                            <div class="col s11 m5 l4 ">
                                                <p class="collapsible-title">Nombre</p>
                                            </div>
                                            <div class="col m4 l4 hide-on-small-only">
                                                <p class="collapsible-title">Identidad</p>
                                            </div>
                                            <div class="col m3 l3 hide-on-med-and-down">
                                                <p class="collapsible-title">Estado</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <div class="list collapsible no-padding no-margin z-depth-0">
                                    
                                    <?php $i=1;?>
                                    <?php foreach($data as $beneficiario):?>
                                            
                                        <li>
                                            <div class="collapsible-header sin-icon">
                                                <div class="row">
                                                    <div class="col s1 m1 l1 truncate"><?php echo $i;?></div>
                                                    <div class="col s11 m5 l4 truncate"><span class="nombreb"><?php echo $beneficiario['nombre'];?></span></div>
                                                    <div class="col s4 m4 l4 hide-on-small-only identidadb truncate"><?php echo $beneficiario['Identidad'];?></div>
                                                    <div class="col s6 m3 l3 hide-on-med-and-down estatusb truncate"><?php echo $beneficiario['Estatus_Prestamo'];?></div>
                                                </div>
                                            </div>
                                            <div class="collapsible-body no-padding">
                                                <div class="card blue-grey white-text z-depth-0 no-margin no-border-radius">
                                                    <div class="card-content">
                                                        <span class="card-title text-darken-4"><span class="light">Estado:</span> <?php echo $beneficiario['Estatus_Prestamo'];?></span>
                                                        <div class="row">
                                                            <?php if(isset($beneficiario['Identidad'])):?>
                                                            <div class="col l6 m6 s12">
                                                                <p><span class="light">Identidad:</span> <?php echo $beneficiario['Identidad'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['Fecha_Desembolso'])):?>
                                                            <div class="col l6 m6 s12">
                                                                <p><span class="light">Fecha Desembolso:</span> <?php echo $beneficiario['Fecha_Desembolso'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['nombre_ifi'])):?>
                                                            <div class="col l6 m6 s12">
                                                                <p><span class="light">IFI:</span> <?php echo $beneficiario['nombre_ifi'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['Numero_Prestamo'])):?>
                                                            <div class="col l6 m6 s12">
                                                                <p><span class="light">Numero de Préstamo:</span> <?php echo $beneficiario['Numero_Prestamo'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['monto_autorizado'])):?>
                                                            <div class="col l6 m6 s12">   
                                                                <p><span class="light">Monto:</span> <?php echo $beneficiario['monto_autorizado'];?></p>
                                                            </div>   
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['saldo_capital'])):?>
                                                            <div class="col l6 m6 s12">
                                                                <p><span class="light">Saldo Capital:</span> <?php echo $beneficiario['saldo_capital'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['capital_mora'])):?>
                                                            <div class="col l6 m6 s12">   
                                                                <p><span class="light">Capital en mora:</span> <?php echo $beneficiario['capital_mora'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['fecha_ultimo_pago'])):?>
                                                            <div class="col l6 m6 s12">
                                                                <p><span class="light">Último pago:</span> <?php echo $beneficiario['fecha_ultimo_pago'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['fecha_desembolso'])):?>
                                                            <div class="col l6 m6 s12">   
                                                                <p><span class="light">Fecha de Desembolso:</span> <?php echo $beneficiario['fecha_desembolso'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['fecha_colocacion'])):?>
                                                            <div class="col l6 m6 s12">
                                                                <p><span class="light">Fecha de Colocacion:</span> <?php echo $beneficiario['fecha_colocacion'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['total_pago_pendiente'])):?>
                                                            <div class="col l6 m6 s12">
                                                                <p><span class="light">Pago pendiente:</span> <?php echo $beneficiario['total_pago_pendiente'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['cuotas_vencidas'])):?>
                                                            <div class="col l6 m6 s12">
                                                                <p><span class="light">Cuotas vencidas:</span> <?php echo $beneficiario['cuotas_vencidas'];?></p>
                                                            </div> 
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['Ciclo'])):?>
                                                            <div class="col l6 m6 s12">
                                                                <p><span class="light">Ciclo:</span> <?php echo $beneficiario['Ciclo'];?></p>
                                                            </div> 
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['Gestor'])):?>
                                                            <div class="col l6 m6 s12">
                                                                <p><span class="light">Asesor:</span> <?php echo $beneficiario['Gestor'];?></p>
                                                            </div> 
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['Supervisor'])):?>
                                                            <div class="col l6 m6 s12">    
                                                                <p><span class="light">Supervisor:</span> <?php echo $beneficiario['Supervisor'];?></p>
                                                            </div>     
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['documento'])):?>
                                                            <div class="col l6 m6 s12">    
                                                                <p><span class="light">PBS:</span> <?php echo $beneficiario['documento'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['Grupo_Solidario'])):?>
                                                            <div class="col l6 m6 s12">    
                                                                <p><span class="light">Grupo Solidario:</span> <?php echo $beneficiario['Grupo_Solidario'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['grupo_solidario_hash'])):?>
                                                            <div class="col l6 m6 s12">    
                                                                <p><span class="light">Hash:</span> <?php echo $beneficiario['grupo_solidario_hash'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['Correlativo'])):?>
                                                            <div class="col l6 m6 s12">    
                                                                <p><span class="light">Correlativo:</span> <?php echo $beneficiario['Correlativo'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['Producto'])):?>
                                                            <div class="col l6 m6 s12">    
                                                                <p><span class="light">Producto:</span> <?php echo $beneficiario['Producto'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['Observaciones'])):?>
                                                            <div class="col l6 m6 s12">    
                                                                <p><span class="light">Observaciones:</span> <?php echo $beneficiario['Observaciones'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['Archivado'])):?>
                                                            <div class="col l6 m6 s12">    
                                                                <p><span class="light">Archivado:</span> <?php if($beneficiario['Archivado'])
                                                                    echo "Sí";
                                                                else
                                                                    echo "No";
                                                                ?></p>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(isset($beneficiario['PBS'])):?>
                                                            <div class="col l6 m6 s12">    
                                                                <p><span class="light">Documento:</span> <?php echo $beneficiario['PBS'];?></p>
                                                            </div>
                                                            <?php endif;?>
                                                        </div>
                                                    </div>
                                                    <div class="card-action">
                                                        <?php if($_SESSION['tipoEmpleado'] != 'Gestor' && $_SESSION['tipoEmpleado'] != 'Supervisor'):?>
                                                            <a href="#!" class="activator green-text text-lighten-3 btn-bitacora">Bitácora</a>
                                                        <?php endif;?>
                                                        <a href="#!" class="activator green-text text-lighten-3 btn-referencias">Referencias</a>
                                                        <a href="#!" class="activator green-text text-lighten-3 btn-aval">Aval</a>
                                                        <input type="hidden" id="id_credito" value="<?php echo (isset($beneficiario['id']) ? $beneficiario['id'] : '');?>">
                                                        <input type="hidden" id="identidad" value="<?php echo (isset($beneficiario['Identidad']) ? $beneficiario['Identidad'] : '');?>">
                                                        <input type="hidden" id="ciclo" value="<?php echo $beneficiario['Ciclo'];?>">
                                                        <input type="hidden" id="hash" value="<?php echo $beneficiario['grupo_solidario_hash'];?>">
                                                    </div>
                                                    <div class="card-reveal blue-grey darken-1 white-text">
                                                        <span class="card-title text-darken-4"><span id="card-reveal-title"></span><i class="material-icons right">close</i></span>
                                                        
                                                        <div class="container center" id="bitacora-loading">
                                                            <div class="preloader-wrapper active">
                                                                <div class="spinner-layer spinner-green-only">
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
                                                        
                                                            
                                                        <div class="" id="bitacora-content">

                                                            
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <?php $i++;?>
                                    <?php endforeach;?>

                                </div>
                                
                                <li class="collapsible-item-header light">
                                    <ul id="pag-control" class="pag pagination">
                                    </ul>
                                </li>

                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        <div id="modal-aval" class="modal">
            <div class="modal-content">
                <h5>Información del Aval</h5>
                <p>A bunch of text</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
            </div>
        </div>
        
<script>

    $(document).ready(init);

    function init() {

        // Materialize
        $('.modal').modal();
        $('.collapsible').collapsible();
        
        // Event listener para los botones para ver la bitacora del credito actual
        $('.btn-bitacora').click(abrirBitacora);
        $('.btn-aval').click(abrirAval);
        $('.btn-referencias').click(abrirReferencias);
        $('.icon-collapse-search').click(abrirInputBuscar);

        // List.js
        var options = {
            page: 10,
            pagination: true,
            valueNames: [ 'nombreb', 'identidadb', 'estatusb' ],
            fuzzySearch: {
                searchClass: "fuzzy-search",
                location: 0,
                distance: 100,
                threshold: 0.2,
                multiSearch: true
            }
        };
        window.listObj = new List('beneficiarios-list', options);
        
    }

    function abrirBitacora(){
            
        var parent = $(this).parent();
        var idcredito = parent.find('#id_credito').val();
        var bitacoracontent = parent.next().find('#bitacora-content');
        bitacoracontent.empty();
        var loading = parent.next().find('#bitacora-loading');
        var bitacoratitle = parent.next().find('#card-reveal-title');
        bitacoratitle.text('Bitácora');
        
        loading.fadeIn(100, function(){
            
            $.ajax({
                type: 'POST',
                url: 'backend-consulta-bitacora.php',
                data: 'id='+idcredito,
                success: function(data){

                    loading.fadeOut(100, function(){

                        var obj = JSON.parse(data);
                        if(obj.length > 0){
                            var table = $('<table class="fixed_headers"><thead class="stuck"><tr><th data-field="id">Estado</th><th data-field="name">Fecha de Ingreso</th><th data-field="observacion">Observación</th></tr></thead><tbody id="each-container"></tbody></table>');
                            obj.forEach(function(value, index){
                                table.find('#each-container').append('<tr><td>'+value.estado_credito+'</td><td>'+value.fecha+'</td><td>'+value.observacion+'</td></tr>');
                            });
                            bitacoracontent.append(table);
                        }else{
                            bitacoracontent.append('<p>No hay registros en la bitacora debido a que el crédito no fue procesado por el Sistema.</p>');
                        }
                        
                    });

                }
                
            });
            
        });
        
    }

    function abrirAval(){
            
        var parent = $(this).parent();
        var identidad = parent.find('#identidad').val();
        var ciclo = parent.find('#ciclo').val();
        var hash = parent.find('#hash').val();
        var bitacoracontent = parent.next().find('#bitacora-content');
        bitacoracontent.empty();
        var loading = parent.next().find('#bitacora-loading');
        var bitacoratitle = parent.next().find('#card-reveal-title');
        bitacoratitle.text('Aval del Crédito');
        
        loading.fadeIn(100, function(){
            
            $.ajax({
                type: 'POST',
                url: 'aval.php',
                data: 'id='+identidad+'&hash='+hash,
                success: function(data){

                    console.log(data);
                    loading.fadeOut(100, function(){
                        var obj = JSON.parse(data);
                        if(obj.length > 0){
                            
                            var row = $('<div class="row"></div>');
                            obj.forEach(function(value, index){
                                
                                var col = $('<div class="col l6 m6 s12"></div>');
                                
                                    col.append('<p class="no-margin"><span class="truncate">'+value.nombre+'</span></p>');
                                    col.append('<p class="no-margin"><span class="light">Identidad: </span>'+value.Identidad+'</p>');
                                    col.append('<p class="no-margin"><span class="light">Telefono: </span>'+value.telefono+'</p>');
                                    col.append('<p class="no-margin"><span class="light">Saldo Capital: </span>'+value.Saldo_Capital+'</p><br>');
                                
                                row.append(col);
                                
                            });
                            bitacoracontent.append(row);
                            
                        }else{
                            bitacoracontent.append('<p>No se han podido identificar los avales.</p>');
                        }
                    });

                }
            });
            
        });
        
    }

    function abrirReferencias(){

        var parent = $(this).parent();
        var idcredito = parent.find('#id_credito').val();

        var bitacoracontent = parent.next().find('#bitacora-content');
        bitacoracontent.empty();
        var loading = parent.next().find('#bitacora-loading');
        var bitacoratitle = parent.next().find('#card-reveal-title');
        bitacoratitle.text('Referencias');

        loading.fadeIn(100, function(){

            $.ajax({
                type: 'POST',
                url: 'referencia.php',
                data: {
                    id_credito: idcredito
                },
                success: function(data){
                    loading.fadeOut(100, function(){
                        
                        var obj = JSON.parse(data);

                        if(obj.length > 0){

                            if(obj[0].nombre != null){

                                console.log(obj);
                                var table = $(`
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Dirección</th>
                                                <th>Teléfono</th>
                                                <th>Parentesco</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        </tbody>
                                    </table>
                                `);

                                obj.forEach(function(value, index){

                                    if(value.nombre != '' && value.nombre != null){
                                        table.find('#tbody').append(`
                                        <tr>
                                            <td>`+value.nombre+`</td>
                                            <td>`+value.direccion+`</td>
                                            <td>`+value.telefono+`</td>
                                            <td>`+value.parentesco+`</td>
                                        </tr>
                                        `);
                                    }

                                });
                                // console.log(data);

                                bitacoracontent.append(table);

                            }else{

                                bitacoracontent.append('<p class="center">No se han encontrado las referencias</p>');

                            }
                            

                        }else{

                            bitacoracontent.append('<p class="center">No se han encontrado las referencias</p>');

                        }

                        
                        
                    });
                }
            });

        });

    }

    function abrirInputBuscar(){
        $('.search-expandida').toggleClass('expanded');
        $('.search-expandida').focus();
    }

</script>
    
    <?php else:?>
    
        <div class="section">
            <div class="row">
                <div class="col s12 m4 l6 offset-l3 offset-m4">
                    <div class="card grey">
                        <div class="card-content white-text">
                            <span class="card-title">No se encontraron registros</span>
                            <p>Para esta búsqueda en particular no se pudo encontrar ningún registro en la base de datos.</p>
                        </div>
                        <div class="card-action hide-on-med-and-down">
                            <a href="#!" class="grey-text text-lighten-3 onclick-focus-search">Buscar de nuevo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    <?php endif;?>
    
    <script>
        
        $(document).ready(function(){
            $('.onclick-focus-search').click(function(){
                $('#search').val('').focus();
            });
        });
        
    </script>
    
<?php else:?>

    <div class="section">
        <div class="row">
            <div class="col s12 m4 l6 offset-l3 offset-m4">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">No se pudo capturar la consulta</span>
                        <p>Realice correcciones donde sea necesario.</p>
                    </div>
                    <div class="card-action hide-on-med-and-down">
                        <a href="#!" class="green-text text-lighten-3 onclick-focus-search">Buscar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        
        $(document).ready(function(){
            $('.onclick-focus-search').click(function(){
                $('#search').val('').focus();
            });
        });
        
    </script>

<?php endif;?>