<?php

require '../php/conection.php';
session_start();
$stat_hojas = $conn->prepare('call obtener_listas_generadas(:user);');
$stat_hojas->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
$stat_hojas->execute();
$hojas = $stat_hojas->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Plugins requeridos para ListIt -->
<script src="..\js\plugins\paginathing-master\paginathing.js"></script>

<link rel="stylesheet" href="../js/plugins/listit/listit.css">
<script src="../js/plugins/listit/listit.js"></script>
<section>

    <div class="row">

        <div class="col l10 m10 s12 offset-l1 offset-m1">
            <br>
            <ul id="listit" class="collection listit">
                <li class="collection-item">
                    <span class="title">Hojas generadas</span>
                    <!-- <a class="btn-flat waves-effect waves-light right" href="#!"><i class="material-icons">add</i></a> -->
                </li>
                <!-- <li class="collection-item with-actions">
                    <div class="input-field">
                        <input placeholder="Buscar" id="search" type="search" class="validate">
                        <i class="material-icons close">close</i>
                    </div>
                </li> -->
                
                <div class="listcontainer collapsible popout">
                </div>
                
            </ul>
        </div>

    </div>

</section>

<script>

$(document).ready(function(){
    
    var cargarHojas = function(){
        var hojas = <?php echo json_encode($hojas);?>;
        $.each(hojas, function(index, hoja){
            window.list.insertElement([hoja.faja, hoja.cantidad, hoja.fecha]);
        });
    }

    window.list = $('#listit').listit({
        columnsCount: 4,
        // unique: [true],
        pagination: true,
        paginationOptions: {
            perPage: 4,
            limitPagination: 4,
            containerClass: 'collection-item elem with-pagination',
            ulClass: 'pagination',
            prevText: '<i class="material-icons md-18">chevron_left</i>', 
            nextText: '<i class="material-icons md-18">chevron_right</i>', 
            firstText: '<i class="material-icons md-18">first_page</i>',
            lastText: '<i class="material-icons md-18">last_page</i>',
            pageNumbers: true
        },
        headers: ['Faja', '# Grupos', 'Fecha', 'Acciones'],
        emptyMessage: '<i class="material-icons orange-text">error</i> No hay hojas generadas.',
        classes: {
            collapsibleBodyColumns: 'col s12 m3 l3',
            collapsibleHeaderColumns: 'col s12 m3 l3'
        },
        buttonsOnElements: [
            {
                button: '<a class="waves-effect waves-blue btn-flat green-text"><i class="material-icons green-text" style="line-height: 36px;margin:0">file_download</i></a>',
                buttonInColumn: 3,
                id: 'eliminar',
                buttonOnClick: function(event, element, btn){
                    $(btn).attr('disabled','disabled');
                    Materialize.toast('Generando faja '+$(element).find('#faja').text(), 2500);
                    $.ajax({
                        type: 'POST',
                        url: '../php/digitacion/generar-hoja.php',
                        data: {
                            codigofaja: $(element).find('#faja').text()
                        },
                        success: function(data){
                            if(data != 'false'){
                                console.log(data);
                                $(btn).removeAttr('disabled');
                                swal("Se ha generado el archivo");
                                window.open(data, '_blank');
                            }else{
                                swal("No se ha podido procesar la hoja");
                            }
                            
                        }
                    });
                }
            }
        ]
    });

    cargarHojas();
});

</script>