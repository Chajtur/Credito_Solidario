$(document).ready(function(){
    
        $("#cadate").pignoseCalendar({
            lang: 'es',
            format: 'DD-MM-YYYY',
            select: onSelectHandler,
            multiple: true
        });
    
        $('.pignose-calendar-unit-active.pignose-calendar-unit-first-active').find('a').first().trigger('click');
    
        $('.tooltipped').tooltip({delay: 10});
    
        $('select').material_select();
        
        $('#btn-loader').hide();
    
        $('#loading-current').hide();
    
        $('#table-content').hide();
    
        $('#breadcrum-title').text('Reporte de Colocación Pendiente');
    
        $('.generar-excel').click(function(){
    
            var obj = {
                desde: window.desde,
                hasta: window.hasta,
                por: window.por,
                consolidar: window.consolidar
            }
    
            $.ajax({
                type: 'POST',
                url: 'coldesrec/pendiente_desembolso/generar-excel.php',
                data: obj,
                success: function(data){
                    console.log(data);
                    window.open(data, '_blank');
                }
            });
    
        });
    
        $('#btn-generar').click(function(){
            
            window.por = $('#select-filtro').val();
            window.consolidar = ($('#agrupado')[0].checked ? 1 : 0);
    
            if(window.desde == undefined && window.hasta == undefined){
                swal('No ha seleccionado ninguna fecha');
                return false;
            }
    
            var obj = {
                desde: window.desde,
                hasta: window.hasta,
                por: $('#select-filtro').val(),
                consolidar: ($('#agrupado')[0].checked ? 1 : 0)
            }
            
            var current = $(this);
            
            $('#table-content').fadeOut(100, function(){
                $('#mensaje').fadeOut(100, function(){
                    $('#loading-current').fadeIn(100);
                });
            })
    
            current.fadeOut(100, function(){
    
                $('#btn-loader').fadeIn(100);
                $.ajax({
                    type: 'POST',
                    url: '../php/contabilidad/reporte_pendiente_desembolso.php',
                    data: obj,
                    success: function(data){
                        
                        var obj = JSON.parse(data);
                        delete window.listdesembolsos;
    
                        $('#loading-current').fadeOut(100, function(){
                            // console.log(data);
                            $('#list-rows').empty();
    
                            $.each(obj, function(index, value){
    
                                $('#list-rows').append(`
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s3 m3 l3">
                                                `+value[0]+`
                                            </div>
                                            <div class="col s5 m5 l5">
                                                `+value[1]+`
                                            </div>
                                            <div class="col s2 m2 l2 center">
                                                `+value[2]+`
                                            </div>
                                            <div class="col s2 m2 l2 center">
                                                `+value[3]+`
                                            </div>
                                        </div>
                                    </li>
                                `);
    
                            });
    
                            $('#table-content').fadeIn(100);
    
                            var options = {
                                page: 10,
                                pagination: true
                            };
                            window.listdesembolsos = new List('projects-collection', options);
                            
                        });
    
                        $('#btn-loader').fadeOut(100, function(){
                            current.fadeIn(100);
                        });
                        $('#btn-loader').fadeOut(100, function(){
                            current.fadeIn(100);
                        });
                    }
                });
    
            });
    
        });
    
        function onSelectHandler(date, context) {
    
            window.desde = null;
            window.hasta = null;
    
            if(date[0] !== null){
                window.desde = date[0].format('YYYY-MM-DD');
            }
    
            if(date[1] !== null){
                window.hasta = date[1].format('YYYY-MM-DD');
            }
    
        }
        
    });