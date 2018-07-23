<div class="row">
    <div class="col l8 offset-l2">
        <div class="card">
            <div class="card-content">
                <div class="input-field">
                    <input placeholder="Ingrese el PBS" id="pbs" type="text" class="validate">
                    <label for="first_name" class="active">PBS</label>
                </div>
            </div>
            <div class="card-action">
                <a href="#!" class="btn-flat" id="btn-generar">Generar</a>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function(){
        $('#btn-generar').click(function(){
            Materialize.toast('Generando', 1000);
            $.ajax({
                type: 'POST',
                url: '../php/informatica/generar-pbs.php',
                data: 'data='+$('#pbs').val(),
                success: function(data){
                    if(data != 'false'){
                        Materialize.toast('Listo', 1000);
                        console.log(data);
                        window.open('../docs/excel/'+data, '_blank');
                    }else{
                        console.log('error');
                    }
                }
            });
        });
    });

</script>