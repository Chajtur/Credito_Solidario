$(document).ready(function() {
    $('ul.tabs').tabs();
    /*$('ul.tabs').tabs().onShow("active", function (e) {
              console.log( 'show tab' );
                $($.fn.dataTable.tables(true)).DataTable()
                  .columns.adjust()
                  .responsive.recalc();
            });*/
    $("ul.tabs").tabs({ onShow: function(tab) { 
        console.log(tab); 
        $($.fn.dataTable.tables(true)).DataTable()
                  .columns.adjust()
                  .responsive.recalc();
    } 
    });
    var tableT = $('.dt-responsive').DataTable();
 
    tableT.responsive.rebuild();
    tableT.responsive.recalc();
    
    $.ajax({
            type: "POST",
            url: "datatable.php",
           
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: true,
            success: function (response, status, error) {
                var resumen = response.resumen.data;
                var t15dias = response.de1a15dias.data;
                var t31dias = response.de16a30dias.data;
                var t61dias = response.de31a60dias.data;
                var t120dias = response.de61a120dias.data;
                var t120diasomas = response.de120adelante.data;
                console.log(resumen);
                console.log(t15dias);
                console.log(t31dias);
                console.log(t61dias);
                console.log(t120dias);
                console.log(t120diasomas);
                if (resumen) {
                    $("#resumengeneral").DataTable().destroy();
                    var tablaresumen = $("#resumengeneral").DataTable({
                        aaData: resumen,
                        "columns": [
                            { "data": "0" },
                            { "data": "1" },
                            { "data": "2" },
                            { "data": "3" },
                            { "data": "4" },
                            { "data": "5" },
                            { "data": "6" },
                            { "data": "7" },
                            { "data": "8" },
                            { "data": "9" }
                        ],
                        "language": {
                            "infoEmpty": "Mostrando 0 de 0 de 0 Entradas",
                            "zeroRecords": "No se han encontrado Datos",
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
                }
               if (t15dias) {
                    $("#de1a15").DataTable().destroy();
                    var tablade15dias = $("#de1a15").DataTable({
                        aaData: t15dias,
                        "columns": [
                            { "data": "0" },
                            { "data": "1" },
                            { "data": "2" },
                            { "data": "3" },
                            { "data": "4" },
                            { "data": "5" },
                            { "data": "6" }
                        ],
                        "language": {
                            "infoEmpty": "Mostrando 0 de 0 de 0 Entradas",
                            "zeroRecords": "No se han encontrado Datos",
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
                        pageResize: true,
                        bProcessing: false,
                        bAutoWidth: false,
                        responsive: true
                    });
                   
                }
                if (t31dias) {
                    $("#de16a30").DataTable().destroy();
                    var tablade30dias = $("#de16a30").DataTable({
                        aaData: t31dias,
                        "columns": [
                            { "data": "0" },
                            { "data": "1" },
                            { "data": "2" },
                            { "data": "3" },
                            { "data": "4" },
                            { "data": "5" },
                            { "data": "6" }
                        ],
                        "language": {
                            "infoEmpty": "Mostrando 0 de 0 de 0 Entradas",
                            "zeroRecords": "No se han encontrado Datos",
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
                }
                if (t61dias) {
                    $("#de31a60").DataTable().destroy();
                    var tablade60dias = $("#de31a60").DataTable({
                        aaData: t61dias,
                        "columns": [
                            { "data": "0" },
                            { "data": "1" },
                            { "data": "2" },
                            { "data": "3" },
                            { "data": "4" },
                            { "data": "5" },
                            { "data": "6" }
                        ],
                        "language": {
                            "infoEmpty": "Mostrando 0 de 0 de 0 Entradas",
                            "zeroRecords": "No se han encontrado Datos",
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
                }
                if (t120dias) {
                    $("#de61a120").DataTable().destroy();
                    var tablade120dias = $("#de61a120").DataTable({
                        aaData: t120dias,
                        "columns": [
                            { "data": "0" },
                            { "data": "1" },
                            { "data": "2" },
                            { "data": "3" },
                            { "data": "4" },
                            { "data": "5" },
                            { "data": "6" }
                        ],
                        "language": {
                            "infoEmpty": "Mostrando 0 de 0 de 0 Entradas",
                            "zeroRecords": "No se han encontrado Datos",
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
                }
                if (t120diasomas) {
                    $("#de120omas").DataTable().destroy();
                    var tablade120amas = $("#de120omas").DataTable({
                        aaData: t120diasomas,
                        "columns": [
                            { "data": "0" },
                            { "data": "1" },
                            { "data": "2" },
                            { "data": "3" },
                            { "data": "4" },
                            { "data": "5" },
                            { "data": "6" }
                        ],
                        "language": {
                            "infoEmpty": "Mostrando 0 de 0 de 0 Entradas",
                            "zeroRecords": "No se han encontrado Datos",
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
                    
                }
            },
            beforeSend : function(){
               $("#loading-indicator").show();
            },
            complete: function(){
               $("#loading-indicator").hide();
            }
    })
    
});

function recallResponsive(id) {
    var tableT = $(id).DataTable();
    
    //$( tableT.column( 2 ).header() ).addClass( 'never' );
 
    tableT.responsive.rebuild();
    tableT.responsive.recalc();
}

