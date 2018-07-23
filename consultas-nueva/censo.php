<?php if(isset($_POST['data'])):?>

    <?php $data = json_decode($_POST['data'], true);?>

    <?php if(count($data) > 0):?>
   
        <div class="section">
            <div class="row margin">
                <div id="work-collapsible">
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
                                        <div class="col m4 l3 hide-on-small-only">
                                            <p class="collapsible-title">Identidad</p>
                                        </div>
                                        <div class="col m3 l2 hide-on-med-and-down">
                                            <p class="collapsible-title truncate">Fecha Nacimiento</p>
                                        </div>
                                        <div class="col m3 l2 hide-on-med-and-down">
                                            <p class="collapsible-title">Género</p>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <div class="list collapsible no-padding no-margin z-depth-0">
                                            
                            <?php $i=1;?>
                            <?php foreach($data as $persona):?>
                                    
                                <li>
                                    <div class="collapsible-header sin-icon">
                                        <div class="row">
                                            <div class="col l1 m1 s2 truncate"><?php echo $i;?></div>
                                            <div class="col l4 m6 s10 truncate"><span class="nombreb"><?php echo $persona['primerNombre'].' '.$persona['segundoNombre'].' '.$persona['primerApellido'].' '.$persona['segundoApellido'];?></span></div>
                                            <div class="col l3 m5 hide-on-small-only identidadb truncate"><?php echo $persona['identidad'];?></div>
                                            <div class="col l2 hide-on-med-and-down estatusb truncate"><?php echo $persona['fechaNacimiento'];?></div>
                                            <div class="col l2 hide-on-med-and-down estatusb truncate"><?php echo $persona['sexo'];?></div>
                                        </div>
                                    </div>
                                    <div class="collapsible-body no-padding">
                                        <div class="card blue-grey white-text z-depth-0 no-margin no-border-radius">
                                            <div class="card-content">
                                                <span class="card-title text-darken-4"><?php echo $persona['primerNombre'].' '.$persona['segundoNombre'].' '.$persona['primerApellido'].' '.$persona['segundoApellido'];?></span>
                                                <div class="row">
                                                    <div class="col l6 m6 s12">
                                                        <p><span class="light">Identidad:</span> <?php echo $persona['identidad'];?></p>
                                                        <p><span class="light">Fecha de Nacimiento:</span> <?php echo $persona['fechaNacimiento'];?></p>
                                                        <p><span class="light">Género:</span> <?php echo ($persona['sexo'] == "M" ? 'Masculino' : 'Femenino');?></p>
                                                    </div>
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
        <script>

            $(document).ready(function() {

                $('.collapsible').collapsible();
                
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
                window.listObj.on('updated', function(){ // Evento que se lanza cuando se realiza algun filtro en la lista
                    if(window.listObj.searched){ // Este parametro es true si esta filtrado, sino no
                        $('#list-counter').hide();
                    }else{
                        $('#list-counter').show();
                    }
                });

                $('.icon').click(function(){
                    $('.search-consultas').toggleClass('expanded');
                    $('.search-consultas').focus();
                });
                
            });

        </script>
    
    <?php else:?>
    
        <div class="section">
            <div class="row">
                <div class="col s12 m4 l6 offset-l3 offset-m4">
                    <div class="card grey">
                        <div class="card-content white-text">
                            <span class="card-title">No se encontraron registros</span>
                            <p>Para esta búsqueda en particular no se pudo encontrar ningún registro en el censo.</p>
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