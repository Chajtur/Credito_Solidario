function buscarEnCenso (campoIdentidad, campoNombre, notificaciones = true) {
    campoNombre.val('Buscando...');

    if (notificaciones) {
        Materialize.toast('Buscando...', 1000);
    }

    $.ajax({
        type: 'POST',
        url: '../php/credito/buscarcenso.php',
        data: 'id='+campoIdentidad.val(),
        success: function (data) {
            if (data == 'No esta en el censo') {
                campoNombre.val('No encontrado. Escriba el nombre');
                Materialize.toast('No encontrado. Escriba el nombre.', 2000);
            } else {
                let persona = JSON.parse(data);
                campoNombre.val(persona.nombre);

                if (notificaciones) {
                    Materialize.toast(persona.nombre, 2000);
                }
            }
        },
        error: function (data) {
            if (notificaciones) {
                Materialize.toast('Error', data);
            }
        }
    });
}