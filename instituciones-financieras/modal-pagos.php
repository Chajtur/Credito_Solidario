<div id="modal-pago" class="modal modal-max-width">
    <div class="modal-content">
        <h4 class="light blue-text">Pagar</h4>
        <div class="input-field">
            <input type="text" name="" id="cantidadPago" value="190">
            <label for="cantidadPago" clasS="active">Monto a pagar</label>
        </div>
        <div class="input-field">
             <input type="date" class="datepicker" id="fechaPago">
            <label for="fechaPago" clasS="active">Fecha de pago</label>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action waves-effect waves-blue btn-flat" id="btn-pagar">Pagar</a>
        <a href="#!" class="btn-flat modal-action" id="modal-pago-preloader">
            <div class="preloader-wrapper small active right modal-spinner-action">
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
        </a>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#modal-pago-preloader').hide();
        $('.modal').modal();
        $('#btn-pagar').click(function(){

            if($('#cantidadPago').val() == ''){
                Materialize.toast('El valor de pago está vacío', 3000);
                return false;
            }

            if($('#fechaPago').val() == ''){
                Materialize.toast('No ha seleccionado la fecha', 3000);
                return false;
            }

            var dat = {
                valor: $('#cantidadPago').val(),
                fecha: $('#fechaPago').val(),
                prestamo: $('#numero-prestamo').val()
            }

            $('#modal-pago-preloader').show();
            $(this).hide();

            $.ajax({
                type: 'POST',
                url: '../php/ventanilla/nuevo-pago.php',
                data: 'data='+JSON.stringify(dat),
                success: function(data){
                    console.log(data);
                    if(data == "true"){
                        swal('Completado', 'El pago ha sido registrado correctamente.', 'success');
                        $('#modal-pago').modal('close');
                        $('#btn-pagar').show();
                        $('#modal-pago-preloader').hide();
                        $('#floating-refresh').trigger('click');
                    }else{
                        $('#modal-pago').modal('close');
                        $('#btn-pagar').show();
                        $('#modal-pago-preloader').hide();
                        swal('Error', 'No se guardó el pago.', 'error');
                    }
                    
                }
            });
        });

    });
</script>