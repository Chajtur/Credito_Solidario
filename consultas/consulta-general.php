<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="credito solidario, banca solidaria, credito joven, banca, solidaria, honduras">
    <meta name="keywords" content="credito solidario, banca solidaria, credito joven, banca, solidaria, honduras">
    <title>Credito Solidario</title>

    <!-- Favicons-->
    <link rel="icon" href="../images/favicon/favicon-32x32.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="../images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#">
    <meta name="msapplication-TileImage" content="../images/favicon/mstile-144x144.png">
    <!--Tint Titlebar for Chrome-->
    <meta name="theme-color" content="#3F51B5" />
    <!-- For Windows Phone -->


    <!-- CORE CSS-->
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->
    <link href="../css/custom/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link rel="stylesheet" href="../css/custom/nuevo.css">
    <link rel="stylesheet" href="../css/custom/tema-indigo.css">
    <link rel="stylesheet" href="../css/custom/search.css">
    <!-- Material-icons-->
    <link href="../fonts/material-icons/material-icons.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="../js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="../js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!--<link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">-->

    <!--dataTables-->
    <link href="../css/dataTable/datatable.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!--    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap4.min.css">-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap4.min.css">
    <style>
    
        .dataTables_empty {
            padding-left: 30px !important;
        }
        
    </style>
</head>

<body>

    <!-- Start Page Loading -->
    <div class="preloader">
        <div class="statusl">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Loading -->


    <!-- START HEADER -->
    <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="navbar-color">
                <div class="nav-wrapper row">
                   
                    <ul class="left col s3">
                        <li>
                            <h1 class="logo-wrapper">
                      <a href="#" class="brand-logo darken-1">
                      <object type="image/svg+xml" data="../images/logocredito.svg"></object>
                      </a> <span class="logo-text">Materialize</span></h1>
                        </li>
                    </ul>
                    <!--barra de busqueda en el header-->
                    <!--<div class="header-search-wrapper hide-on-med-and-down">
                        <i class="material-icons">search</i>
                        <input type="text" name="Search" class="header-search-input"
                        placeholder="Realice una consulta por Nombre o por Identidad"/>
                    </div>-->
                    <form id="consultar" class="left search col s6 hide-on-med-and-down">
                            <div class="input-field">
                                <input id="search" type="search" placeholder="" autocomplete="off">
                                <label for="search"><i class="material-icons search-icon">search</i></label>
                                <!--<i class="material-icons">close</i>-->
                                <a href="#" onClick="limpiarfields();" class="close-search"><i class="material-icons clear-icon">close</i></a>
                            </div>
                            
                    </form>
                    <ul class="right hide-on-med-and-down col s3 nav-right-menu">
                        <!--<li><a class="perfil-on-nav-button" href="#!" data-activates="perfil-on-nav">Victor Alvarado<i class="material-icons right">arrow_drop_down</i></a></li>
                        <li class="waves-effect waves-light"><a href="">Sass</a></li>
                        <li class="waves-effect waves-light"><a href="">Components</a></li>-->
                        <!-- Dropdown Trigger -->
                        <li><a href="#" class="brand-logo right logo2"><img src="../images/logo-presidencia.png" alt=""></a></li>
                    </ul>
                    <div class="col col s8 m8 l8">
                        <ul id="perfil-on-nav" class="dropdown-content">
                            <li><a href="#"><i class="material-icons">face</i>
                        <span class="option-user-select">Perfil</span>
                        </a>
                            </li>
                            <li><a href="#"><i class="material-icons">account_circle</i>
                        <span class="option-user-select">Cuenta</span>
                        </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="material-icons">home</i>
                        <span class="option-user-select">Salir</span>
                        </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>
        </div>
        <!-- end header nav-->
    </header>
    <!-- END HEADER -->


    <!-- START MAIN -->
    <div id="main">
        <!-- START WRAPPER -->
        <div class="wrapper">

            <!-- START LEFT SIDEBAR NAV-->
            <aside id="left-sidebar-nav">
                <ul id="slide-out" class="side-nav fixed leftside-navigation">
                    <li>
                        <div class="userView">
                            <div class="background">
                                <img class="responsive-img" src="../images/2b.jpg">
                            </div><br><br><br>
                            <!--código para agregar datos del usuario al sideNav, en esta pagina no es necesario-->
                            <!--<a href="#!user"><img class="circle" src="../images/user.png"></a>
                            <a href="#!name" class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" data-activates="profile-dropdown"><i class="material-icons right white-text">arrow_drop_down</i><span class="white-text name">John Doe</span></a>
                            <a href="#!email"><span class="white-text email">jdandturk@gmail.com</span></a>
                            <ul id="profile-dropdown" class="dropdown-content">
                                <li><a href="#"><i class="material-icons">face</i> Perfil</a>
                                </li>
                                <li><a href="#"><i class="material-icons">account_circle</i> Cuenta</a>
                                </li>
                                <li><a href="#"><i class="material-icons">help</i> Ayuda</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="material-icons">keyboard_backspace</i> Salir</a>
                                </li>
                            </ul>-->
                        </div>
                    </li>
                    <li onclick="toggleDivs('iniciar_sesion'); hideMenuOnClick()"><a href="../login.php" class="waves-effect waves-light"><i class="material-icons">account_circle</i>Inicio de Sesión</a></li>

                    <li>
                        <div class="divider"></div>
                    </li>

                    <li><a class="subheader">Tipos de Consultas</a></li>
                    <li onclick="hideMenuOnClick()" id="btn-consulta-general"><a class="waves-effect waves-light" href="#!"><i class="material-icons">search</i>Consulta General</a></li>
                    <li onclick="hideMenuOnClick()" id="btn-consulta-censo"><a class="waves-effect waves-light" href="#!"><i class="material-icons">search</i>Consulta al Censo</a></li>
                </ul>
                <a href="#" data-activates="slide-out" class="sidebar-collapse  waves-effect waves-light hide-on-large-only">
                    <i class="material-icons white600 md-36">menu</i>
                </a>

            </aside>
            <!-- END LEFT SIDEBAR NAV-->


            <!-- START CONTENT -->
            <section id="content">

                <!--breadcrumbs start-->
                <div id="breadcrumbs-wrapper">
                    <!-- Search for small screen -->
                    <form id="consultar-mobil" class="hide-on-large-only">
                        <div class="header-search-wrapper grey">
                            <i class="material-icons active">search</i>
                        <input id="search-mobil" type="text" name="Search" class="header-search-input z-depth-2" placeholder="">
                    </div>
                    </form>
                    
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <!--<h5 class="breadcrumbs-title">Blank Page</h5>-->
                                <ol class="breadcrumbs">
                                    <li><a href="index.html">Inicio</a></li>
                                    <li class="active" id="breadcrum-menu-current">Consulta General</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!--breadcrumbs end-->
                
                <div class="container center" id="loading">
                    <br><br>
                    <div class="preloader-wrapper big active">
                        <div class="spinner-layer spinner-blue-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="gap-patch">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
                

                <!--start container-->
                <div class="container" id="main-container">
                   
                    <!-- 

                    aqui va el codigo dinamico
                      
                    -->
                   
                    
                    <!-- Floating Action Button -->
                    
                </div>
                <!--end container-->
            </section>
            <!-- END CONTENT -->


        </div>
        <!-- END WRAPPER -->

    </div>
    <!-- END MAIN -->


    <!-- START FOOTER -->
    <footer class="page-footer">
        <div class="footer-copyright">
            <div class="container">
                <span>Copyright © 2016 <a class="grey-text text-lighten-4" href="http://www.creditosolidario.hn" target="_blank">Credito Solidario</a> All rights reserved.</span>
                <span class="right"> Desarrollado por <a class="grey-text text-lighten-4" href="http://www.creditosolidario.hn" target="_blank">Credito Solidario</a></span>
            </div>
        </div>
    </footer>
    <!-- END FOOTER -->
    
    <div class="preloader-tb" id="loading-indicator">
        <div class="statusl-tb">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ================================================
    Scripts
    ================================================ -->

    <!-- jQuery Library -->
   <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="../js/materialize.js"></script>
    <!--prism
    <script type="text/javascript" src="js/prism/prism.js"></script>-->
    <!--scrollbar-->
    <script type="text/javascript" src="../js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <!--custom-script.js - Add your own theme custom JS-->
    <script src="../js/custom-script.js"></script>

    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="../js/plugins.js"></script>

    <!-- DataTable-->
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" src="../js/plugins/data-tables/scripts.js"></script>
    <script type="text/javascript" src="../js/jquery.form.js"></script>
    <script>
    
        $(document).ready(function(){
            
            
            
            window.menucurrent = 0;
            window.hacerconsulta = 'general';
            window.currentMenuIid = 'btn-consulta-general';
            /*$('#main-container').empty();*/
            $('#main-container').load('/csfrontend/consultas/general.php');
            $('#'+window.currentMenuIid).addClass('active');
            $('#loading').hide();
            
            //Eventos:
            var anchoPantalla = window.innerWidth;
            if(anchoPantalla <= 992){
                $('#search-mobil').attr('placeholder', 'Realice una búsqueda en el sistema');
                hacerConsultas('#search-mobil','#consultar-mobil');
            }else{
                $('#search').attr('placeholder', 'Realice una búsqueda en el sistema');
                hacerConsultas('#search','#consultar');
            }
            
            /*AddEventListener para leer los cambios de tamaño que 
            sufra la pantalla si esa es redimencionada por el usuario
            de esta manera sabremos en que tamaño estamos y llamaremos a la 
            funcion correcta*/
            
            window.addEventListener('resize', function(event){
                
                var anchoPantallaOnChange = window.innerWidth;
                if(anchoPantallaOnChange <= 992){
                    $('#search-mobil').attr('placeholder', 'Realice una búsqueda en el sistema');
                    hacerConsultas('#search-mobil','#consultar-mobil');
                }else{
                    $('#search').attr('placeholder', 'Realice una búsqueda en el sistema');
                    hacerConsultas('#search','#consultar');
                }
                
            });
            
            //Eventos click para el menu
        
            $('#btn-consulta-censo').click(function(){

                //Acciones necesarias al hacer clic en un elemento del menú
                
                if(window.menucurrent == 0){
                    window.hacerconsulta = "censo";

                    cambiarMenuActivo('btn-consulta-censo');
                    
                    //modificando el nombre del breadcrum activo
                    $('#breadcrum-menu-current').html('Consulta al Censo');
                    
                    $('#main-container').fadeOut(100, function(){
                        $('#loading').show(0);
                        $('#main-container').load('/csfrontend/consultas/censo.php', function(){
                            $('#main-container').fadeIn();
                            
                            //recreamos la tabla recién insertada
                            window.currentdatatable.destroy();
                            window.currentdatatable = $('#data-table').DataTable(window.objdatatablecenso);
                            $('#loading').hide(0);
                        });
                    });
                    
                    window.menucurrent = 1;
                    $('#search').attr('placeholder', 'Realice una búsqueda en el censo');

                }

            });

            $('#btn-consulta-general').click(function(){
                
                //Acciones necesarias al hacer clic en un elemento del menú
                
                if(window.menucurrent == 1){
                    window.hacerconsulta = "general";

                    cambiarMenuActivo('btn-consulta-general');
                    $('#breadcrum-menu-current').html('Consulta General');
                    
                    $('#main-container').fadeOut(100, function(){
                        $('#loading').show(0);
                        $('#main-container').load('/csfrontend/consultas/general.php', function(){
                            $('#main-container').fadeIn();
                            
                            //recreamos la tabla recién insertada
                            window.currentdatatable.destroy();
                            window.currentdatatable = $('#data-table').DataTable(window.objdatatablegeneral);
                            /*var tableT;
                            tableT = $('.dt-responsive').DataTable();
                            tableT.responsive.rebuild();
                            tableT.responsive.recalc();*/
                            $('#loading').hide(0);
                        });
                    });
                    
                    window.menucurrent = 0;
                    $('#search').attr('placeholder', 'Realice una búsqueda en el sistema');
                }

            });
            
        });
        
        /*
        Función que alterna la clase active entre cada elemento del menu 
        asigna la clase a quien se le halla hecho clic
        */

        var cambiarMenuActivo = function(id){
            $('#'+window.currentMenuIid).removeClass('active');
            window.currentMenuIid = id;
            $('#'+window.currentMenuIid).addClass('active');
            $('#search').val('');
            $('#search-mobil').val('');
        }
        
        /*Funcion para realizar las consultas. Recibe como parametro el id del input
        según sea el tamaño de pantalla cuando se carga la pagina*/
        function hacerConsultas(inputId, formId){
            $(formId).submit(function(e){
                
                e.preventDefault();
                //alert($('#search').val());
                
                var data = {
                    consulta : window.hacerconsulta,
                    parametro : $(inputId).val()
                }
                
                //INICIO AJAX
                
                $(this).ajaxSubmit({
                    
                    type: 'POST',
                    data: data,
                    url: 'consultas.php',
                    success: function(data){
                        
                        console.log(data); //logueamos la data para ver si está funcionando
                        
                        if(data == "2002" || data == "2006"){ // códigos de error de mysql
                            
                            Materialize.toast('Error de conexión, por favor intentelo más tarde', 3000);
                            $("#loading-indicator").hide();
                            
                        }else{
                            
                            //creamos un bloque try y catch en caso de que no devuelva un objeto válido (ocurra un error en el php)
                            
                            try{
                                var obj = JSON.parse(data);
                                $("#data-table").DataTable().destroy();
                                $("#search-mobil").blur();

                                if(window.hacerconsulta == "general"){
                                    
                                    $('.search-toggle').removeClass('disabled'); //habilitar el buscador de DataTable una vez cargados los datos
                                    
                                    var tabla = $("#data-table").DataTable({
                                        aaData: obj,
                                        aoColumns : [
                                            { mData : "identidad" },
                                            { mData : "Nombre" },
                                            { mData : "ciclo" },
                                            { mData : "monto_autorizado" },
                                            { mData : "Estatus_Prestamo" },
                                            { mData : "Gestor" },
                                            { mData : "Fecha_Desembolso" },
                                            { mData : "nombre_ifi" },
                                            { mData : "fecha_ultimo_pago" },
                                            { mData : "cuotas_vencidas" },
                                            { mData : "capital_mora" },
                                            { mData : "documento" }
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

                                if(window.hacerconsulta == "censo"){
                                    
                                    $('.search-toggle').removeClass('disabled'); //habilitar el buscador de DataTable una vez cargados los datos
                                    
                                    var tabla = $("#data-table").DataTable({
                                        aaData: obj,
                                        aoColumns : [
                                            { mData : "primerNombre" },
                                            { mData : "segundoNombre" },
                                            { mData : "primerApellido" },
                                            { mData : "segundoApellido" },
                                            { mData : "identidad" },
                                            { mData : "fechaNacimiento" },
                                            { mData : "sexo" }
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
                            }catch(error){

                                $("#loading-indicator").hide();
                                Materialize.toast('Ocurrió un error durante la busqueda, por favor intente otra vez', 3000);

                            }  
                            
                        }
                        
                    },
                    beforeSend : function(){
                        console.log('Iniciando Consulta');
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
                    
                });
                
                //FIN AJAX
                
            });
        }
        
        
    </script>
    


</body>

</html>