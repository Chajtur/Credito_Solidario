var dataSetconsulta = [
    
    [ "0801-1975-00568", "Ana María Lopez", "2", "La Guadalupe", "15/08/2016", "5000.00", "Desembolsado", "Luisa Joselina Moncada", "20/08/2016", "15/10/2016", "10", "00.00" ],
    [ "0801-1975-00568", "Ana María Lopez", "2", "La Guadalupe", "15/08/2016", "5000.00", "Desembolsado", "Luisa Joselina Moncada", "20/08/2016", "15/10/2016", "10", "00.00" ],
    [ "0801-1975-00568", "Ana María Lopez", "2", "La Guadalupe", "15/08/2016", "5000.00", "Desembolsado", "Luisa Joselina Moncada", "20/08/2016", "15/10/2016", "10", "00.00" ],
    [ "0801-1975-00568", "Ana María Lopez", "2", "La Guadalupe", "15/08/2016", "5000.00", "Desembolsado", "Luisa Joselina Moncada", "20/08/2016", "15/10/2016", "10", "00.00" ],
    [ "0801-1975-00568", "Ana María Lopez", "2", "La Guadalupe", "15/08/2016", "5000.00", "Desembolsado", "Luisa Joselina Moncada", "20/08/2016", "15/10/2016", "10", "00.00" ],
    [ "0801-1975-00568", "Ana María Lopez", "2", "La Guadalupe", "15/08/2016", "5000.00", "Desembolsado", "Luisa Joselina Moncada", "20/08/2016", "15/10/2016", "10", "00.00" ],
    [ "0801-1975-00568", "Ana María Lopez", "2", "La Guadalupe", "15/08/2016", "5000.00", "Desembolsado", "Luisa Joselina Moncada", "20/08/2016", "15/10/2016", "10", "00.00" ],
    [ "0801-1975-00568", "Ana María Lopez", "2", "La Guadalupe", "15/08/2016", "5000.00", "Desembolsado", "Luisa Joselina Moncada", "20/08/2016", "15/10/2016", "10", "00.00" ],
    [ "0801-1975-00568", "Ana María Lopez", "2", "La Guadalupe", "15/08/2016", "5000.00", "Desembolsado", "Luisa Joselina Moncada", "20/08/2016", "15/10/2016", "10", "00.00" ]
];

var dataSetconsultaCenso = [
    
    [ "23/09/1978", "0801-1978-00541", "Ana", "Joselina", "Lainez", "Lopez", "Femenino"],
    [ "23/09/1978", "0801-1978-00541", "Ana", "Joselina", "Lainez", "Lopez", "Femenino"],
    [ "23/09/1978", "0801-1978-00541", "Ana", "Joselina", "Lainez", "Lopez", "Femenino"],
    [ "23/09/1978", "0801-1978-00541", "Ana", "Joselina", "Lainez", "Lopez", "Femenino"],
    [ "23/09/1978", "0801-1978-00541", "Ana", "Joselina", "Lainez", "Lopez", "Femenino"],
    [ "23/09/1978", "0801-1978-00541", "Ana", "Joselina", "Lainez", "Lopez", "Femenino"],
    [ "23/09/1978", "0801-1978-00541", "Ana", "Joselina", "Lainez", "Lopez", "Femenino"],
    [ "23/09/1978", "0801-1978-00541", "Ana", "Joselina", "Lainez", "Lopez", "Femenino"],
    [ "23/09/1978", "0801-1978-00541", "Ana", "Joselina", "Lainez", "Lopez", "Femenino"]
    
];

$(document).ready(function() {
 var tableventa = $('#tb-consulta-general').DataTable({
    
    data: dataSetconsulta,
      columns: [
          { title : "Identidad" },
          { title : "Nombre" },
          { title : "Ciclo" },
          { title : "IFI" },
          { title : "Fecha Colocacion" },
          { title : "Monto" },
          { title : "Estado" },
          { title : "Gestor" },
          { title : "Fecha Desembolso" },
          { title : "Última Fecha Pago" },
          { title : "Cuotas" },
          { title : "Capital en Mora" }
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
    
    var tableventa = $('#tb-consulta-censo').DataTable({
    
    data: dataSetconsultaCenso,
      columns: [
          { title : "Fecha de Nacimiento" },
          { title : "Identidad" },
          { title : "Primer Nombre" },
          { title : "Segundo Nombre" },
          { title : "Primer Apellido" },
          { title : "Segundo Apellido" },
          { title : "Sexo" }
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
    
    
});