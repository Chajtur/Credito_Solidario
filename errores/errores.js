$(document).ready(function () {

    $('#enviarmsj').on('click', function () {
        swal({
                title: "Mensaje enviado",
                text: "tu mensaje ha sido enviado con éxito!",
                type: "success",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                closeOnConfirm: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    $('#nombre-error').val("");
                    $('#texthelp').val("");
                    Materialize.updateTextFields();
                }
                
            });
    });

});
