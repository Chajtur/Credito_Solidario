<!-- Plugin Paginathing required by Tablesearch and listit -->
<script src="../js/plugins/paginathing/paginathing.js"></script>

<!-- Plugin Tablesearch by 4Richi -->
<link rel="stylesheet" href="../js/plugins/tablesearch/tablesearch.css">
<script src="../js/plugins/tablesearch/tablesearch.js"></script>

<!-- Plugin listit by 4Richi -->
<link rel="stylesheet" href="../js/plugins/listit/listit.css">
<script src="../js/plugins/listit/listit.js"></script>

<!-- Plugin Multiselect by 4Richi -->
<script src="../js/plugins/multiselect/multiselect.js"></script>
<div class="row">
    <div class="col l12 m12 s12">

        <ul class="collection tablesearch">
            <li class="collection-item">
                <span class="title">1. Buscar Créditos para reasignar</span>
                <!-- <a class="btn-flat waves-effect waves-light right" href="#!"><i class="material-icons">settings_backup_restore</i></a> -->
            </li>
            <li class="collection-item with-actions">
                <div class="input-field">
                    <input placeholder="Buscar" id="search" type="search" class="validate search">
                    <i class="material-icons close">close</i>
                </div>
            </li>
            <div class="results collapsible popout">
            </div>
        </ul>

        <ul id="listit" class="collection listit">
            <li class="collection-item">
                <span class="title">2. Lista de créditos a reasignar</span>
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

    <div class="col l12 m12 s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title" style="font-weight: 400">3. Elegir el Asesor</span>
                <div class="row">
                    <div class="col l6 m6 s6">
                        <div id="multiselect"></div>
                    </div>
                    <div class="col l6 m6 s6">
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="col l12 m12 s12">
        <a class="btn-large waves-effect waves-blue green" id="btnGuardar">4. <i class="material-icons left">save</i>Guardar</a>
    </div>
</div>
<br>
<script>

$(document).ready(function(){

    $('#btnGuardar').click(function(){

        var creditos = window.list.getAllElements();
        if(!creditos.length > 0){
            Materialize.toast('No ha seleccionado ningún crédito para reasignar', 2000);
            return false;
        }

        if($('#selectAsesor option:selected').val() == '' || $('#selectAsesor option:selected').val() == 0){
            Materialize.toast('Por favor seleccione un asesor', 2000);
            return false;
        }

        var obj = [];
        $.each(creditos, function(index, elem){
            var ct = {};
            ct.idcredito = ($(elem).find('#id').text() === undefined || $(elem).find('#id').text() == '' ? null : $(elem).find('#id').text());
            ct.numero_prestamo = $(elem).find('#numero_prestamo').text();
            ct.asesor_viejo = $(elem).find('#asesor').text();
            ct.asesor_nuevo = $('#selectAsesor option:selected').text();
            obj.push(ct);
        });
        console.log(obj);

        swal({
            title: "¿Está seguro que desea reasignar los créditos seleccionados?",
            text: "Al confirmar, se reasignarán los créditos y será registrado en la base de datos.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí Reasignar",
            cancelButtonText: "No",
            showLoaderOnConfirm: true,
            closeOnConfirm: false
        },
        function(confirmo){
            
            if(confirmo){

                $.ajax({
                    type: 'POST',
                    url: '../php/coordinadores/guardar-reasignacion.php',
                    data: {
                        data: JSON.stringify(obj)
                    },
                    success: function(data){
                        console.log(data);
                        if(data == 'true'){
                            // Materialize.toast('Se han guardado los cámbios', 2000);
                            swal("Correcto", "Se han reasignado los creditos.","success");
                            $('#floating-refresh').trigger('click');
                        }else{
                            swal("Error", "Ha ocurrido un error al reasignar los créditos.","error");
                            // Materialize.toast('Ha ocurrido un error al guardar', 2000);
                        }
                    }
                });
                
            }
            
        });

        
    });

    $('.collapsible').collapsible();

    $('.tablesearch').tablesearch({
        headers: ['Identidad', 'Nombre', 'Asesor', ''],
        reloadBtn: true,
        columnsAmount: 4,
        sourceData: '../consultas-nueva/buscar-credito.php',
        emptyMessage: '<i class="material-icons orange-text">error</i> Realice una búsqueda para obtener los créditos que desea reasignar.',
        buttonsOnElements: [
            {
                button: '<a class="waves-effect waves-blue btn-flat blue-text right" style="margin-top: 5px">Agregar</a>',
                buttonInColumn: 3,
                buttonOnClick: function(event, element){
                    if(window.list.insertElement([
                        $(element).find('#identidad').text(),
                        $(element).find('#nombre').text(),
                        $(element).find('#gestor').text(),
                        $(element).find('#supervisor').text(),
                        $(element).find('#numero_prestamo').text(),
                        $(element).find('#ciclo').text(),
                        $(element).find('#id').text()
                    ])){
                        Materialize.toast('Se ha agregado el crédito a la lista', 2000);
                    }
                }
            }
        ]
    });

    window.list = $('#listit').listit({
        columnsCount: 4,
        unique: [true],
        headers: ['Identidad', 'Nombre', 'Asesor', '', 'Numero_Prestamo', 'Ciclo', 'Id'],
        emptyMessage: '<i class="material-icons orange-text">error</i> Ingrese créditos desde la tabla superior para reasignar.',
        classes: {
            collapsibleBodyColumns: 'col s12 m3 l3',
            collapsibleHeaderColumns: 'col s12 m3 l3'
        },
        buttonsOnElements: [
            {
                button: '<a class="waves-effect waves-blue btn-flat red-text right" style="margin-top: 5px">Eliminar</a>',
                buttonInColumn: 3,
                buttonOnClick: function(event, element){
                    window.list.removeElement(element.index());
                    Materialize.toast('Elemento eliminado de la lista', 2000);
                },
            }
        ]
    });

    // Multiselect
    $('#multiselect').multiselect({
        amount: 1,
        labels: ['Asesor'],
        selectIds: ['selectAsesor'],
        optionLabels: ['Seleccione un asesor'],
        defaultValueLabelResult: 'usuario',
        defaultTextLabelResult: 'nombre',
        sourceData: [
            '../php/coordinadores/listar-asesores.php',
        ]
    });

});

</script>