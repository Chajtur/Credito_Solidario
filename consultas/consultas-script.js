/**
 * Created by Chajtur on 8/1/2016.
 */
var $boton = "btnconsultarDesktop";
function toggleDivs(name){
    $(".cuadro").hide();
    $("#" + name).show();
    if(name == "consultas"){
        $("#btncenso").hide();
        $("#consulta-menu").addClass("active");
        $("#censo-menu").removeClass("active");
        $("#initSesionMenu").removeClass("active");
        $boton = "btnconsultarDesktop";
        $(".search").show();
    }
    if(name == "censo"){
        $("#btnconsultas").hide();
        $("#btncenso").show();
        $("#censo-menu").addClass("active");
        $("#consulta-menu").removeClass("active");
        $("#initSesionMenu").removeClass("active");
        $boton = "btnconsultarCensoDesktop";
        $(".search").show();
    }
    if(name == "iniciar_sesion"){
        $("#initSesionMenu").addClass("active");
        $("#consulta-menu").removeClass("active");
        $("#censo-menu").removeClass("active");
        $(".search").hide();
    }
    $("#");
}

var iniciarSesion = function(user, pass){
    try {
        
        /*
        //Iniciando sesión
        let name = "ingresado";
        let data = {
            user: user,
        }
        Session.set(name, data);
        */
        
        var data = {
            user : user,
            pass : pass
        };
        data = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "http://www.creditosolidario.hn/csws/CSWS.asmx/Login",
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: true,
            success: function (response, status, error) {
                var obj = jQuery.parseJSON(response.d);
                
                if (obj.nombre !== null) {
                    sessionStorage.setItem("user", JSON.stringify(obj));
                    location.href = "../asesor/dashboard-asesor.html";
                }
                else {
                    alert("Usuario o contraseña incorrecta");
                    $("#pass").val('');
                    $("#user").focus();
                }
            },
            error: function (result) {
                var obj = jQuery.parseJSON(result);
                alert(obj.responseText);
            }
        })
    }
    catch (error) {
        alert("error" + error.message);
    }
};

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
            url: "http://181.210.15.138/csws/CSWS.asmx/BuscarBeneficiario",
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
                            { mData : "ifi" },
                            { mData : "monto" },
                            { mData : "ciclo" },
                            { mData : "estado" },
				            { mData : "fechaColocacion" },
                            { mData : "gestor" },
                            { mData : "fechaDesembolso" },
				            { mData : "ultimaFechaPago" },
				            { mData : "cuotas" },
				            { mData : "capitalMora" },
                            { mData : "PBS" }
                            /*{
                                mData: null,
                                "bSortable": false,
                                "mRender": function(data, type, full) {
                                    return '<a class="btn white-text " href=#/' + full[0] + '>' + 'Detalle' + '</a>';
                                }
                            }*/
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
                if(result.status == "404"){
                    lacation.href = "../errores/error-404.html";
                }
                
            }
        })
    }
    catch (error) {
        alert("error" + error.message);
    }
};
var consultarCenso = function(nombre, identidad){
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
            url: "http://www.creditosolidario.hn/csws/CSWS.asmx/consultarCenso",
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: true,
            success: function (response, status, error) {
                var obj = JSON.parse(response.d);
                if (obj) {
                    $("#tb-consulta-censo").DataTable().destroy();
					$("#censo_small").blur();
                    var tabla = $("#tb-consulta-censo").DataTable({
                        aaData: obj,
                        aoColumns : [
                            { mData : "fechaNacimiento" },
                            { mData : "identidad" },
                            { mData : "primerNombre" },
                            { mData : "segundoNombre" },
                            { mData : "primerApellido" },
                            { mData : "segundoApellido" },
                            { mData : "sexo" }
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
                //$('#tb-consulta-general').dataTable({"bProcessing": false});
            },
            complete: function(){
               $("#loading-indicator").hide();
               //$('#tb-consulta-general').dataTable({"bProcessing": true});
            },
            error: function (result) {
                var obj = jQuery.parseJSON(result);
                alert(obj.responseText);
            }
        })
    }
    catch (error) {
        alert("error" + error.message);
    }
};

/*function getCookie(c_name) {
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1) {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1) {
        c_value = null;
    } else {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1) {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start, c_end));
    }
    return c_value;
}*/

function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


function recallResponsive() {
    var tableT = $('.dt-responsive').DataTable();
    
    //$( tableT.column( 1 ).header() ).addClass( 'never' );
 
    tableT.responsive.rebuild();
    tableT.responsive.recalc();
}

$(document).ready(function(){
    /*window.location.reload(true);*/
    //OBTENIENDO COOKIES PARA PERMITR MENSAJE DE BIENVENIDA Y BORRAR CACHE
    
   
    var user=getCookie("username");
    if (user != "") {
        
    } else {
        $('#modal1-b').modal('open');
        setCookie("username", "csconsultas", 30);
    }

    /*var visit = getCookie("cookie");
    if (visit == null) {
        
        var expire = new Date();
        expire = new Date(expire.getTime() + 7776000000);
        alert(expire);
        $('#modal1-b').modal('open');
        document.cookie = "cookie=here; expires=" + expire + "; path=/";
        
        window.location.reload(true);
    }*/
    
    
    /*$('#modal1-b').firstVisitPopup({
        cookieName : 'homepageConsultasCokie3',
        showAgainSelector : '#show-message'
    });*/
    //$("#loading-indicator").hide();
    $(".btn").click(function(event){
        event.preventDefault();
    });
    //buscarBeneficiario("","4747744747");
     recallResponsive();
    $("#btncenso").hide();
    $("#consulta-menu").addClass("active");
    /*consultarCenso("","0501198207733");*/
    $(".cuadro").hide();
    $("#consultas").show();
    /*$('#censo_nombre').keypress(function(e){
        if(e.keyCode==13)
            $('#censoBuscar').click();
    });
    $('#censo_id').keypress(function(e){
        if(e.keyCode==13)
            $('#censoBuscar').click();
    });*/
    $('#buscar-censo-movil').keypress(function(e){
        if(e.keyCode==13)
            $('#btnconsultarCensoMovil').click();
            //$("#buscar-censo-movil").blur();
    });
    $('#search').keypress(function(e){
        if(e.keyCode==13){
           $('#' + $boton).click();
       } 
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
            $('#btnconsultarMovil').click();
            //$("#searchSmall").blur();
    });
    $('#pass').keypress(function(e){
       if(e.keyCode==13){
           $('#btn_login').click();
       }
    });
});
