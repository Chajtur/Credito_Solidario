var dataSetventanilla = [
    
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"],
    ["Ana", "Joselina", "Lainez", "Lopez", "0801-1978-00541", "1", "monto", "desembolsado"]
];

$(document).ready(function() {
 var tableventa = $('#tb-ventanilla-mosquitia').DataTable({
    
    data: dataSetventanilla,
      columns: [
          { title : "Identidad" },
          { title : "Nombre" },
          { title : "Ciclo" },
          { title : "IFI" },
          { title : "Fecha Colocacion" },
          { title : "Monto" },
          { title : "Estado" },
          { title : "Gestor" }
      ],
        "oLanguage": {
            "sStripClasses": "",
            "sSearch": "",
            "sSearchPlaceholder": "Realice Una Busqueda Rápida",
            "sInfo": "_END_ -_TOTAL_",
            "sLengthMenu": '<span>por pág:</span><select class="browser-default">' +
            '<option value="5">5</option>' +
            '<option value="10">10</option>' +
            '<option value="30">30</option>' +
            '<option value="40">40</option>' +
            '<option value="50">50</option>' +
            '<option value="-1">Todos</option>' +
            '</select></div>'
        },
        bAutoWidth: false,
        responsive: true
  });
    
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
        format: 'DD-MM-YYYY'

    });

    
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