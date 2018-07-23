<?php

require '../php/conection.php';

$stat = $conn->prepare('select gestor, count(*) as cantidad from prestamo 
where Estado_Credito = "Desembolsado" and gestor is not null 
group by gestor');
$stat->execute();

$result = $stat->fetchAll(PDO::FETCH_ASSOC);

$stat_gestores = $conn->prepare('select nombre, id from gsc where tipoEmpleado = "Gestor"');
$stat_gestores->execute();
$gestores = $stat_gestores->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="row">
    <div class="col l10 m12 s12 offset-l1">
        <div class="row">
            <div class="col l8 m8 s12">
                <div id="work-collections" class="">
                    <div class="row">
                        <div class="col s12 m12 l12" id="list-asesores">
                            <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                            <ul id="projects-collection" class="collection z-depth-1" style="border: none !important;">
                                <li class="collection-item avatar">
                                    <i class="material-icons circle light-blue ">list</i>
                                    <span class="collection-header">Nombres de Gestores</span>
                                    <p>Reemplazar en la tabla de prestamo</p>
                                    <div class="secondary-content actions">
                                        <input class="search-expandida fuzzy-search" type="search" placeholder="Filtrar nombre"/>
                                        <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                            <i class="material-icons center-align">search</i>
                                        </a>
                                        <a id="desactivarLista" class="dropdown-button waves-effect waves-light btn-flat nopadding" data-activates='dropdown_listOrder'>
                                            <i class="material-icons center-align">sort</i>
                                        </a> 
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s8 m8 l8">
                                            <p class="collections-title">Nombre</p>
                                        </div>
                                        <div class="col s4 m4 l4 center">
                                            <p class="collections-title">Cantidad</p>
                                        </div>

                                    </div>
                                </li>

                                <div class="list">

                                <?php if(count($result) > 0):?>

                                    <?php foreach($result as $fila):?>

                                        <li class="collection-item">
                                            <div class="row">
                                                <div class="col s8 m8 l8">
                                                    <p class="collections-title"><a href="#!" class="hoverable-gestor nombre gestorlistener"><?php echo $fila['gestor'];?></a></p>
                                                </div>
                                                <div class="col s4 m4 l4 center">
                                                    <p class="collections-title" id="cantidad"><?php echo $fila['cantidad'];?></p>
                                                </div>
                                            </div>
                                        </li>

                                    <?php endforeach;?>

                                <?php else:?>

                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s12 m12 l12 center">
                                                <p class="">No se pudo capturar los gestores</p>
                                            </div>
                                        </div>
                                    </li>

                                <?php endif;?>

                                </div>

                                <li class="collection-item" style="border-top: 1px solid #e0e0e0; padding: 10px 10px 10px 10px !important;">
                                    <ul id="pag-control" class="pag pagination"></ul>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l4 m4 s12">
                <div class="card blue-grey lighten-5">
                    <div class="card-content">
                        <div class="input-field">
                            <input type="text" name="" id="antiguoGestor" class="placeholder-custom" placeholder="Elija un Gestor de la lista">
                            <label for="antiguoGestor" class="grey-text text-darken-3 active">Reemplazar</label>
                        </div>
                        <div class="input-field">
                            <select id="selectGestores" class="browser-default">
                                <option value="" disabled selected>Seleccione un gestor</option>
                                <?php foreach($gestores as $gestor):?>
                                    <option value="<?php echo $gestor['nombre'];?>"><?php echo $gestor['nombre'];?></option>
                                <?php endforeach;?>
                            </select>
                            <label for="selectGestores" class="grey-text text-darken-3 active">Por</label>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="#!" class="blue-text" id="btn-remplazar">Reemplazar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<ul id='dropdown_listOrder' class='dropdown-content'>
    <li><a value="5" href="#!">ver 5</a></li>
    <li><a value="10" href="#!">ver 10</a></li>
    <li><a value="20" href="#!">ver 20</a></li>
    <li><a value="10000" href="#!">ver todo</a></li>
</ul>

<script>

    $(document).ready(function(){

        var removeSelectedClassFromAllPages = function(){
            $.each(window.listObj.items, function(index, value){
                $(value.elm).find('.selected').each(function(){
                    $(this).removeClass('selected');
                });
            });
        }

        $('select').material_select();
        $('#breadcrum-title').text('Renombrar Gestores');
        $('#selectGestores').select2();
        $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrainWidth: false, // Does not change width of dropdown to that of the activator
            hover: false, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: true, // Displays dropdown below the button
            alignment: 'right', // Displays dropdown with edge aligned to the left of button
            stopPropagation: false // Stops event propagation
        });

        $('.gestorlistener').click(function(){
            $('#antiguoGestor').val($(this).text());
            $('#antiguoGestor').focus();
            removeSelectedClassFromAllPages();
            $(this).addClass('selected');
        });

        $('#antiguoGestor').on('input', function(){
            removeSelectedClassFromAllPages();
        });

        $('.icon-collapse-search').click(function () {
            $('.search-expandida').toggleClass('expanded');
            $('.search-expandida').focus();
        });

        $('#dropdown_listOrder').find('a').click(function(){
            listObj.page = $(this).attr('value');
            listObj.update();
        });

        $('#btn-remplazar').click(function(){
            if($('#antiguoGestor').val() == ''){
                Materialize.toast('Por favor seleccione el gestor a reemplazar', 3000);
                return false;
            }
            if($('#selectGestores').val() == '' || $('#selectGestores').val() == null){
                Materialize.toast('Por favor seleccione el gestor por el que se reemplazará', 3000);
                return false;
            }

            var lastQuantity = $(window.listObj.get("nombre", $('#antiguoGestor').val())[0].elm).find('#cantidad').text();
            var newQuantity = $(window.listObj.get("nombre", $('#selectGestores').val())[0].elm).find('#cantidad').text();

            if(1 < 0){
                swal({
                    title: 'Alerta de inconsistencia',
                    text: 'Está modificando un gestor con cantidad de créditos superior al nuevo',
                    type: 'warning',
                    confirmButtonText: 'Esta bién'
                });
                return false;
            }

            swal({
                title: "¿Está seguro del reemplazo?",
                text: "Esta acción será dificil de reparar.",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, reemplazar',
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },function(){
                $.ajax({
                    type: 'POST',
                    url: '../php/informatica/renombrar-gestores.php',
                    data: {
                        antiguo: $('#antiguoGestor').val(),
                        nuevo: $('#selectGestores').val()
                    },
                    success: function(data){
                        if(data == 'true'){
                            swal("Reemplazado", "Se ha reemplazado correctamente.", "success");
                            $('#floating-refresh').trigger('click');
                        }else{
                            swal("Error", "Algo ha salido mal.", "error");
                        }
                    }
                });
            });
        });

        var options = {
            page: 5,
            pagination: true,
            valueNames: ['nombre'],
            fuzzySearch: {
                searchClass: "fuzzy-search",
                location: 0,
                distance: 100,
                threshold: 0.2,
                multiSearch: true
            }
        };
        window.listObj = new List('list-asesores', options);

    });

</script>