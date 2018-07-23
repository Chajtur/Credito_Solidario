/**
 * Created by Chajtur on 8/4/2016.
 */

var $user, $carteraTotal, $carteraSana, $carteraMora;

function toggleDivs(name) {
    $(".cuadro").hide();
    $("#" + name).show();
    $(".search").hide();
    if(name == "Consultas"){
        $(".search").show();
    }
}
var buscarBeneficiario = function(nombre, identidad){
    try {
		identidad = identidad.replace(/-/g,"");
        nombre = nombre.replace(/-/g,"");
		if (identidad == ''){
		if (!isNaN(nombre)){
            identidad = nombre;
            nombre = "";
        }
		}
		nombre = nombre.replace(/\s/g,"%");
		if (nombre != ""){
			nombre = '%' + nombre + '%'
		}
        var data = {
            nombre : nombre,
           identidad : identidad
    };
        data = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "http://www.creditosolidario.hn/csws/CSWS.asmx/BuscarBeneficiario",
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: true,
            success: function (response, status, error) {
                var obj = JSON.parse(response.d);
                if (obj) {
                    $("#tb-consulta-general").DataTable().destroy();
					$("#searchSmall").blur();
                    var tabla = $("#tb-consulta-general").DataTable({
                        aaData: obj,
                        aoColumns : [
                            { mData : "identidad" },
                            { mData : "nombre" },
                            { mData : "ciclo" },
                            { mData : "ifi" },
				            { mData : "fechaColocacion" },
                            { mData : "monto" },
                            { mData : "estado" },
                            { mData : "gestor" },
                            { mData : "fechaDesembolso" },
				            { mData : "ultimaFechaPago" },
				            { mData : "cuotas" },
				            { mData : "capitalMora" }
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
                }
                else {
                    alert("Usuario o contraseña incorrecta");
                    $("#pass").val('');
                    $("#user").focus();
                }
            },
            beforeSend : function(){
               $("#loading-indicator").show();
                $("#searchSmall").blur();
                //$('#tb-consulta-general').dataTable({"bProcessing": false});
            },
            complete: function(){
               $("#loading-indicator").hide();
               //$('#tb-consulta-general').dataTable({"bProcessing": true});
            },
            error: function (result) {
                /*var obj = jQuery.parseJSON(result);
                alert(obj.responseText);*/
                if(result.status == "500"){
                    location.href = "../errores/error-500.html";
                };
                if(resul.status == "404"){
                    lacation.href = "../errores/error-404.html";
                }
                
            }
        })
    }
    catch (error) {
        alert("error" + error.message);
    }
};

function cargarCarteraTotal() {
    //$("#data-table-carteraTotal").DataTable().destroy();
    var tt = $("#data-table-carteraTotal").DataTable({
        bDestroy: true,
        data: $carteraTotal,
        columns: [
            {
                data: "nombre"
            },
            {
                data: "cuotas"
            },
            {
                data: "capitalMora"
            },
            {
                data: "identidad"
            },
            {
                data: "ciclo"
            },
            {
                data: "ifi"
            },
            {
                data: "monto"
            },
            {
                data: "fechaDesembolso"
            },
            {
                data: "ultimaFechaPago"
            },
            {
                data: "telefono"
            },
            {
                data: "direccion"
            },
            {
                data: "negocio"
            }
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
    
};


function cargarCarteraMora() {
    $("#data-table-carteraMora").DataTable().destroy();
    var tabla = $("#data-table-carteraMora").DataTable({
        aaData: $carteraMora,
        aoColumns: [
            {
                mData: "nombre"
            },
            {
                mData: "cuotas"
            },
            {
                mData: "capitalMora"
            },
            {
                mData: "identidad"
            },
            {
                mData: "ciclo"
            },
            {
                mData: "ifi"
            },
            {
                mData: "monto"
            },
            {
                mData: "fechaDesembolso"
            },
            {
                mData: "ultimaFechaPago"
            },
            {
                mData: "telefono"
            },
            {
                mData: "direccion"
            },
            {
                mData: "negocio"
            }
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

};

function cargarCarteraSana() {
    $("#data-table-carteraSana").DataTable().destroy();
    var tabla = $("#data-table-carteraSana").DataTable({
        aaData: $carteraSana,
        aoColumns: [
            {
                mData: "nombre"
            },
            {
                mData: "identidad"
            },
            {
                mData: "ciclo"
            },
            {
                mData: "ifi"
            },
            {
                mData: "monto"
            },
            {
                mData: "fechaDesembolso"
            },
            {
                mData: "ultimaFechaPago"
            },
            {
                mData: "telefono"
            },
            {
                mData: "direccion"
            },
            {
                mData: "negocio"
            }
        ],
        buttons: [
        'copy', 'excel', 'pdf'
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
// $("#data-table-carteraSana").DataTable().buttons().container().appendTo("#actionsbtn");
};
$(document).ready(function () {
    
    /*$("#btn_generar_excel").click(function(){
        
        var user = jQuery.parseJSON(sessionStorage.getItem('user'));
        alert(user.id);
        $("#hidden_id").val(user.id);
        $("#btn_excel_submit").trigger('click');
        
    });*/
    
    $("#form_excel").on('submit', function(e){
        
        var user = jQuery.parseJSON(sessionStorage.getItem('user'));
        $("#hidden_id").val(user.id);
        
    });
    
    $user = jQuery.parseJSON(sessionStorage.getItem("user"));
    $("#rol").text($user.rol);
    $("#nombre").text($user.nombre);
    //$("#welcome_usr_name").text($user.nombre);
    $(".btn").click(function (event) {
        event.preventDefault();
    });
    $(".cuadro").hide();
    $("#Cartas").show();
    try {
        var data = {
            nombre: $user.nombre
        }
        data = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "http://www.creditosolidario.hn/csws/CSWS.asmx/cartas",
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: true,
            success: function (response, status, error) {
                var obj = JSON.parse(response.d);
                obj = obj[0];
                if (obj) {
                    $("#cartera-activa").text(obj.carteraActiva);
                    $("#total-mora").text(addCommas(obj.moraTotal));
                    $("#porcentaje-mora").text(obj.porcentajeMora + "%");
                } else {
                    alert("Error");

                }
            },
            error: function (result) {
                var obj = jQuery.parseJSON(result);
                alert(obj.responseText);
            }
        })
    } catch (error) {
        alert("error" + error.message);
    }
    try {
        data = {
            nombre: $user.nombre
        };
        data = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "http://www.creditosolidario.hn/csws/CSWS.asmx/cargarCarteraAsesor",
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: true,
            success: function (response, status, error) {
                $carteraTotal = JSON.parse(response.d);
                $carteraSana = $.grep($carteraTotal, function (cartera) {
                    return parseFloat(cartera.capitalMora) == 0
                });
                $carteraMora = $.grep($carteraTotal, function (cartera) {
                    return parseFloat(cartera.capitalMora) > 0
                })
            },
            error: function (result) {
                var obj = jQuery.parseJSON(result);
                alert(obj.responseText);
            }
        })
    } catch (error) {
        alert("error" + error.message);
    }
    /*$('#censo_nombre').keypress(function(e){
        if(e.keyCode==13)
            $('#censoBuscar').click();
    });
    $('#censo_id').keypress(function(e){
        if(e.keyCode==13)
            $('#censoBuscar').click();
    });*/
    $('#censo_small').keypress(function(e){
        if(e.keyCode==13)
            $('#censoBuscarSmall').click();
    });
    /*$('#search_nombre').keypress(function(e){
        if(e.keyCode==13)
            $('#searchBtn').click();
    });
    $('#search_id').keypress(function(e){
        if(e.keyCode==13)
            $('#searchBtn').click();
    });*/
    $('#searchSmall').keypress(function(e){
        if(e.keyCode==13)
            $('#consultarMovil').click();
    });
    $('#search').keypress(function(e){
        if(e.keyCode == 13){
            $('#consultarDesktop').click();
        }
    });
    $('#searchSmall').keypress(function(e){
        if(e.keyCode==13)
            $('#consultarMovil').click();
    });
    
});
