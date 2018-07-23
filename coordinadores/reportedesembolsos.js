$(document).ready(function() {
    
    $('.modal').modal();
     $('.collapsible').collapsible();
    $('select').material_select();
    var fechaseleccionada;
    $('.error').hide();
    
    $('#breadcrum-title').text('Reporte de desembolsos');
    
    $('#fabCalendar').css('top', $('.card-header').height()- $('#fabCalendar').height()/2);   
    
    setInterval('updateClock()', 1000);
    var objToday = new Date(),
                weekday = new Array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'),
                dayOfWeek = weekday[objToday.getDay()],
                dayOfMonth = objToday.getDate(),
                months = new Array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'),
                curMonth = months[objToday.getMonth()],
                curYear = objToday.getFullYear();
    var today = dayOfWeek + "<br>" + dayOfMonth + " " +"de " + curMonth + " " + ", " + curYear;
    
    
   	$("#date").html(today);
    
    /*$('.calender').pignoseCalender();*/
    $("#cadate").pignoseCalendar({
        lang: 'es',
        format: 'DD-MM-YYYY',
        select: onClickHandler

    });
    $('.pignose-calendar-unit-active.pignose-calendar-unit-first-active').find('a').first().trigger('click');
    
    function onClickHandler(date, obj) {
        fechaseleccionada = date[0].format('YYYY-M-D');
        var $calendar = obj.calendar;
        var text = 'Elegiste la fecha ';
        if(date[0] !== null) {
            obtenerlistaporfecha(date[0].format('YYYY-M-D'));
            
        }
        
    }
    
    
    
    
    $('#agregarDesembolsados').click(function(){
        if(!verificarinputs()) return false;
        //inserarDesembolsos(fechaseleccionada);
        agregarDesembolsados(fechaseleccionada,$('#elegirMunicipio option:selected').text(),$('#cantidadCreditos').val(),$('#montoDesembolsado').val(), $('#elegirCiclo').val());
        $('#modal1').modal('close');
    });
    
    
    function verificarinputs(){
        var verificar= false;
        if($('#elegirMunicipio').val() == null){
            Materialize.toast('Debe elegir un municipio!', 4000);
            $('#elegirMunicipio').parent().parent().find('.error').show();
            verificar = false;
        }else{
            verificar = true;
        }
        if($('#elegirCiclo').val() == null){
            Materialize.toast('Debe elegir un municipio!', 4000);
            $('#elegirCiclo').parent().parent().find('.error').show();
            verificar = false;
        }else{
            verificar = true;
        }
        if($('#cantidadCreditos').val() == ""){
            Materialize.toast('Debe elegir un municipio!', 4000);
            $('#cantidadCreditos').parent().find('.error').show();
            verificar = false;
        }else{
            verificar = true;
        }
        if($('#montoDesembolsado').val() == ""){
            Materialize.toast('Debe elegir un municipio!', 4000);
            $('#montoDesembolsado').parent().find('.error').show();
            verificar = false;
        }else{
            verificar = true;
        }
        
        return verificar;
    }
    
    $('#elegirMunicipio').on('change', function() {
        $('#elegirMunicipio').parent().parent().find('.error').hide();
    });
    $('#elegirCiclo').on('change', function() {
        $('#elegirCiclo').parent().parent().find('.error').hide();
    });
    $('#cantidadCreditos').on('input', function() {
        $('#cantidadCreditos').parent().find('.error').hide();
    });
    $('#montoDesembolsado').on('input', function() {
        $('#montoDesembolsado').parent().find('.error').hide();
    });
    
    function obtenerlistaporfecha(fecha){
        $('#listadesembolsados').empty();
        $('.list').empty();
        var root = document.location.hostname;
        $.ajax({
            type: 'POST',
            data: {
                fecha: fecha
            },
            url: '/csfrontend/coordinadores/'+'resultadosPorFecha.php', 
            success: function(data){
                console.log(data);
                var obj = JSON.parse(data);
                if(obj.length > 0){
                    $.each(obj, function(index, value){
                        if($(window).width() > 993){
                            $('#listadesembolsados').append(`
                            <li id="" class="listDesem collection-item">
                                <div class="row">
                                    <div class="col s3 m2 l2">
                                        <p id="fecha" class="fecha collections-content">`+value.fecha+`</p>
                                    </div>
                                    <div class="col s4 m2 l2">
                                        <p id="nombreMunicipio" class="nombreMunicipio collections-content">`+value.municipio+`</p>
                                    </div>
                                    <div class="col s2 m2 l2">
                                        <p id="ciclo" class="ciclo collections-content">`+value.ciclo+`</p>
                                    </div>
                                    <div class="col s2 m2 l2">
                                        <p id="cantCreditos" class="cantCreditos collections-content">`+value.desembolsos+`</p>
                                    </div>
                                    <div class="col s2 m2 l2 hide-on-small-only">
                                        <p id="MontDesembolsados" class="MontDesembolsados collections-content">`+numeral(value.monto).format('$0,0.00')+`</p>
                                    </div>
                                    <div class="col s2 m2 l1">
                                        <p class="collections-content"><a id="edit" class="btn-flat waves-effect waves-blue" href="#!"><span id="editar" class="hide">`+value.id+`</span><i class="material-icons blue-text text-darken-1">edit</i></a></p>
                                    </div>
                                    <div class="col s2 m2 l1">
                                        <p class="collections-content"><a id="eliminar" class="btn-flat waves-effect waves-blue" href="#!"><span id="eliminarid" class="hide">`+value.id+`</span><i class="material-icons red-text text-darken-1">delete</i></a></p>
                                    </div>
                                </div>
                            </li>
                        `);
                        }else {
                            $('.list').append(`
                                <li id="listDesem">
                                    <div class="collapsible-header sin-icon">
                                        <div class="row">
                                            <div class="col s4">
                                                <p id="fecha" class="collapsible-title truncate"><span class="blue-text">+</span> `+value.fecha+`</p>
                                            </div>
                                            <div class="col s4">
                                                <p id="nombreMunicipio" class="collapsible-content truncate">`+value.municipio+`</p>
                                            </div>
                                            <div class="col s1">
                                                <p class="collapsible-content"><a style="padding: 0px;" id="edit" class="btn-flat waves-effect waves-blue" href="#!"><span id="editar" class="hide">`+value.id+`</span><i class="material-icons blue-text text-darken-1">edit</i></a></p>
                                            </div>
                                            <div class="col s1">
                                                <p class="collapsible-content"><a style="padding: 0px; margin-left: 20px;" id="eliminar" class="btn-flat waves-effect waves-blue" href="#!"><span id="eliminarid" class="hide">`+value.id+`</span><i class="material-icons red-text text-darken-1">delete</i></a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapsible-body">
                                        <p><b>Ciclo: </b><span id="ciclo">`+value.ciclo+`</span></p>
                                        <p><b>Cantidad: </b><span id="cantCreditos">`+value.desembolsos+`</span></p>
                                        <p><b>Monto: </b><span id="MontDesembolsados">`+value.monto.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+`</span></p>
                                    </div>
                                </li>
                            `);
                            
                        }
                        
                    });
                    preEditar();
                    preEliminar();
                }else {
                    if($(window).width() > 993){
                       $('#listadesembolsados').append(`
                            <li class="collection-item center">
                                <div class="row">
                                    <div class="col s12">
                                        <p class="collections-content amber-text"><i style="display:block;" class="material-icons amber-text">warning</i>  No hay registros para esta fecha</p>
                                    </div>
                                </div>
                            </li>
                        `);
                    }else {
                        $('.list').append(`
                            <div class="collapsible-header center sin-icon">
                                <div class="row">
                                    <div class="col s12">
                                        <p class="collapsible-content amber-text"><i style="display:block;" class="material-icons amber-text">warning</i> No hay registros</p>
                                    </div>
                                </div>
                            </div>
                        `);
                       
                    }
                    
                }
            }
        });
        
    }
    
    function preEditar(){
        $('.listDesem').each(function(index){
            
            var fechaAEditar = $(this).find('#fecha').text();
            var MunicipioAEditar = $(this).find('#nombreMunicipio').text();
            var cicloAEditar = $(this).find('#ciclo').text();
            var cantidadAEditar = $(this).find('#cantCreditos').text();
            var montoAEditar = $(this).find('#MontDesembolsados').text();
            
            $(this).find('#edit').click(function(){
                $('#modal2').modal('open');
                
                console.log($(this).find('#editar').text());
                
                $('#idreg').val($(this).find('#editar').text());
                
                console.log(cicloAEditar);
                
                $('#elegirMunicipioEdit').append($("<option></option>").attr("value", 1).text(MunicipioAEditar)).material_select();
                
                $('#elegirCicloEdit').val(cicloAEditar).material_select();
                
                $('#cantidadCreditosEdit').val(cantidadAEditar);
               
                $('#montoDesembolsadoEdit').val(montoAEditar.replace(/,/g, ""));
                
                $('#fechaEdit').val(fechaAEditar);
                
            });
            
        });
    }
    
    $('#editarDesembolsados').click(function(){
        /*if(!verificarinputs()) return false;*/
        //inserarDesembolsos(fechaseleccionada);
        editar($('#idreg').val(),$('#fechaEdit').val(),$('#elegirMunicipioEdit option:selected').text(), $('#elegirCicloEdit option:selected').val(), $('#cantidadCreditosEdit').val(), $('#montoDesembolsadoEdit').val());
        $('#modal2').modal('close');
        console.log("fdfdf: " + $('#elegirCicloEdit option:selected').val());
    });
    
    function editar(id, fechaEdit, municipioEdit, cicloEdit, contidadEdit, montoEdit){
        $.ajax({
            type: 'POST',
            data: {
                id: id,
                fecha: fechaEdit,
                municipio: municipioEdit,
                ciclo: cicloEdit,
                cantidadCreditos: contidadEdit,
                montoCreditos: montoEdit
            },
            url: '/csfrontend/coordinadores/'+'editardesembolsos.php', 
            success: function(data){
                console.log(data);
                
                swal({
                    title: "Editado!",
                    text: "El registro se ha Editado con éxito!",
                    type: "success"
                },
                function (isConfirm) {
                    if (isConfirm) {
                        obtenerlistaporfecha(fechaEdit);
                    }
                }
            );
            }
        });
    }
    
    //FUNCIONES PARA ELIMINAR
    function preEliminar(){
        $('.listDesem').each(function(index){
            $(this).find('#eliminar').click(function(){
                console.log($(this).find('#eliminarid').text());
                eliminar($(this).find('#eliminarid').text());
            });
            
        });
    }
    
   function eliminar(id){
        
        $.ajax({
            type: 'POST',
            data: {
                id: id
            },
            url: '/csfrontend/coordinadores/'+'eliminarRegistroDesembolso.php', 
            success: function(data){
                console.log(data);
                
                swal({
                    title: "Eliminado!",
                    text: "El registro se ha Eliminado!",
                    type: "success"
                },
                function (isConfirm) {
                    if (isConfirm) {
                        obtenerlistaporfecha(fechaseleccionada);
                    }
                }
            );
            }
        });
    }
    
    function agregarDesembolsados(fecha, municipio, cantidadCreditos, montoCreditos, ciclo){
        //console.log(fecha + " " + municipio + " " + cantidadCreditos + " " + montoCreditos + " " + ciclo);
        $.ajax({
            type: 'POST',
            data: {
                fecha: fecha,
                municipio: municipio,
                cantidadCreditos: cantidadCreditos,
                montoCreditos: montoCreditos,
                ciclo: ciclo
            },
            url: '/csfrontend/coordinadores/'+'agregarPorFecha.php', 
            success: function(data){
                console.log(data);
                
                swal({
                    title: "Guardado!",
                    text: "El registro se ha guardado con éxito!",
                    type: "success"
                },
                function (isConfirm) {
                    if (isConfirm) {
                        obtenerlistaporfecha(fecha);
                        
                        $('#elegirMunicipio').val('').material_select();
                        $('#elegirCiclo').val('').material_select();
                        $('#cantidadCreditos').val('');
                        $('#montoDesembolsado').val('');
                    }
                }
            );
            }
        });
    }
    
    
    
});

function updateClock ( )
 	{
 	var currentTime = new Date ( );
  	var currentHours = currentTime.getHours ( );
  	var currentMinutes = currentTime.getMinutes ( );

  	// Pad the minutes and seconds with leading zeros, if required
  	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;

  	// Choose either "AM" or "PM" as appropriate
  	var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  	// Convert the hours component to 12-hour format if needed
  	currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  	// Convert an hours component of "0" to "12"
  	currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  	// Compose the string for display
  	var currentTimeString = currentHours + ":" + currentMinutes + " " + timeOfDay;
  	
  	
   	$("#time").html(currentTimeString);
   	  	
 }
 