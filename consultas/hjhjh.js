function consultarCenso2(datoConsulta) {
    
    /*console.log(datoConsulta);*/
    datoConsulta = datoConsulta.replace(/-/g,"");
    
    if (isNaN(datoConsulta)) {
        var data = {
            texto: "Select identidad, primerNombre, segundoNombre, primerApellido, segundoApellido, codigoSexo, Date_FORMAT(fechaNacimiento,'%d/%m/%Y') as fechaNacimiento from `censo nacional`.censo where nombre like '%" + datoConsulta.replace(" ","%") + "%'",
            token: "itmediabox"
        }
    }else{
        var data = {
            texto: "Select identidad, primerNombre, segundoNombre, primerApellido, segundoApellido, codigoSexo, Date_FORMAT(fechaNacimiento,'%d/%m/%Y') as fechaNacimiento from `censo nacional`.censo where identidad = replace(replace('" + datoConsulta + "','-',''),' ','')",
            token: "itmediabox"
        };
    }
    data = JSON.stringify(data);
    $.ajax({
        type: "POST",
        url: "http://www.creditosolidario.hn/Services/Alertas.asmx/JQuery",
        data: data,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        timeout: 60000,
        success: function (response) {
            var persona = JSON.parse(response.d);
            /*var sexo;
            if(persona[0].codigoSexo == "1"){
                sexo = "M";
            }else{
                sexo = "F";
            }*/
            /*var tabla = $("#tb-consulta-censo").find("tbody");*/
            $("#tb-consulta-censo").DataTable().destroy();
            var tabla = $("#tb-consulta-censo").DataTable({
                aaData: persona,
                aoColumns : [
                    { mData : "identidad" },
                    { mData : "primerNombre" },
                    { mData : "segundoNombre" },
                    { mData : "primerApellido" },
                    { mData : "segundoApellido" },
                    { mData : "codigoSexo" },
                    { mData : "fechaNacimiento" }
                ],
                "language": {
                    "infoEmpty": "Mostrando 0 de 0 de 0 Entradas",
                    "zeroRecords": "No se han encontrado Datos",
                    "loadingRecords": "<img src='../images/ring.gif'>",
                    "processing":     "Processing...",
                    "sStripClasses": "",
                    "sSearch": "",
                    "sSearchPlaceholder": "Realice Una Busqueda Rápida",
                    "sInfo": "_END_-_TOTAL_",
                    "sLengthMenu": '<span>por pag:</span><select class="browser-default">' +
                    '<option value="5">5</option>' +
                    '<option value="10">10</option>' +
                    '<option value="30">30</option>' +
                    '<option value="40">40</option>' +
                    '<option value="50">50</option>' +
                    '<option value="-1">Todos</option>' +
                    '</select></div>'
                },
                bProcessing: false,
                bAutoWidth: false,
                responsive: true
            });
            /*tabla.empty();
            for (var i = 0; i < persona.length; i++) {
                tabla.append("<tr><td>" + persona[i].identidad + "</td><td>" + persona[i].primerNombre + "</td><td>" + persona[i].segundoNombre + "</td><td>" + persona[i].primerApellido + "</td><td>" + persona[i].segundoApellido + "</td><td>" + (persona[i].codigoSexo == 1 ? 'M' : 'F') + "</td><td>" + persona[i].fechaNacimiento + "</td></tr>");
            }*/
        },
        beforeSend : function(){
               $("#loading-indicator").show();
            $("#buscar-censo-movil").blur();
                //$('#tb-consulta-general').dataTable({"bProcessing": false});
            },
            complete: function(){
               $("#loading-indicator").hide();
               //$('#tb-consulta-general').dataTable({"bProcessing": true});
            },
        error: function () {
        }
    });
}
