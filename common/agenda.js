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
        var text = 'You choose date ';
        if(date[0] !== null) {
            obtenerlistaporfecha(date[0].format('YYYY-M-D'));
            
        }
        
    }
}
    