<div class="section">
    <div class="row margin">
        <div class="col s12">
            <div class="card-panel material-table">
                <div class="table-header">
                    <i class="material-icons large indigo-text text-darken-3">bookmark</i><span class="table-title">Consulta General</span>
                    <div class="actions">
                        <button id="search-toggle" href="#!" class="search-toggle waves-effect btn-flat nopadding disabled">
                            <i class="material-icons">search</i></button>
                    </div>
                </div>
                <table id="data-table" class="table striped bordered dt-responsive nowrap" cellspacing="0" width="100%"></table>
            </div>
        </div>
    </div>
</div>
 <!--<script type="text/javascript" src="../js/plugins/data-tables/scripts.js"></script>-->
<script>
    
    //script para hacer funcionar el search-toggle de DataTable
    $('.search-toggle').click(function() {
      if ($('.hiddensearch').css('display') == 'none')
        $('.hiddensearch').slideDown();
      else
        $('.hiddensearch').slideUp();
    });
    
    //Se crea en una variable global para poder crearla dinámicamente
    
    window.objdatatablegeneral = {
        data: [],
        columns: [
            {
                title: "Identidad"
            }, 
            {
                title: "Nombre"
            }, 
            {
                title: "Ciclo"
            }, 
            {
                title: "Monto Autorizado"
            }, 
            {
                title: "Estado del Préstamo"
            }, 
            {
                title: "Gestor"
            }, 
            {
                title: "Fecha de Desembolso"
            }, 
            {
                title: "IFI"
            }, 
            {
                title: "Fecha de último pago"
            }, 
            {
                title: "Cuotas Vencidas"
            }, 
            {
                title: "Capital en mora"
            }, 
            {
                title: "PBS"
            }
        ],
        language: {
            "infoEmpty": "Mostrando 0 de 0 de 0 Entradas",
            "zeroRecords": "No se han encontrado Datos",
            "sSearchPlaceholder": "Realice Una Busqueda Rápida",
            "search": "",
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
        bAutoWidth: false,
        responsive: true
    }
    
    $(document).ready(function() {
        
        //currentdatatable es la variable global que mantendrá la datatable actual en el sitio
        window.currentdatatable = $('#data-table').DataTable(window.objdatatablegeneral);
        
    });

</script>
