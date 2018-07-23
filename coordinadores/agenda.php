<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agenda</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m4 l4">
                <div style="margin-top:8px" id="cadate" class="calendar z-depth-1"></div>
            </div>
            <div class="col s12 m6">
              <div class="card">
                <div class="card-content">
                  <span class="card-title">Tareas</span>
                  <div class="section">
                    <div class="row margin">
                      <div class="work-collapsible">
                        <div class="row">
                          <div class="col s12">
                            <ul id="tareas-list" class="collapsible" data-collapsible="accordion">
                              <li class="collapsible-item-header avatar">
                                <!--<i class="material-icons circle light-green">list</i>
                                  <span class="collapsible-title-header">Búsqueda
                                  <div class="secondary-content actions">
                                    <input type="search" name="busquedaTarea" id="busquedaTarea" class="search-expandida fuzzy-search" placeholder="Título">
                                    <a href="" class="waves-effect waves-light icon-collapse-search btn-flat-nopadding">
                                      <i class="material-icons center-align">search</i>
                                    </a>
                                  </div>
                                </span>-->
                              </li>
                              <li>
                                <div class="collapsible-header-titles sin-icon">
                                  <div class="row">
                                    <div class="col s1 m1 l2">
                                      <p class="collapsible-title">#</p>
                                    </div>
                                    <div class="col s10 m10 l8">
                                      <p class="collapsible-title">Título</p>
                                    </div>
                                    <div class="col s1 m1 l2">
                                      <p class="collapsible-title"></p>
                                    </div>
                                  </div>
                                </div>
                              </li>
                              <div id="tareasListaContenedor" class="list collapsible no-padding no-margin z-depth-0">
                                
                              </div>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>                  
                </div>
              </div>
          </div>
      </div>
    </div>

    <div class="fixed-action-btn">
      <a href="#tarea-modal" id="agregar_tarea" onclick="mostrarModalAgregar()" class="btn-floating btn-large red">
        <i class="material-icons">add</i>
      </a>
    </div>

    <div id="tarea-modal" class="modal">
        <div class="modal-content">
            <h4>Tarea</h4>
            <form id="tarea-form">
                <div class="input-field">
                    <input type="text" name="titulo" id="titulo" required maxlength="100">
                    <label for="titulo">Título</label>
                </div>
                <div class="input-field">
                    <textarea name="detalle" id="detalle" class="materialize-textarea" required maxlength="2000"></textarea>
                    <label for="detalle">Detalle</label>
                    <input type="hidden" name="accion" id="accion">
                    <input type="hidden" name="tareaId" id="tareaId">
                    <input type="hidden" name="fecha" id="fecha">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" id="registrar_tarea" class="modal-action btn blue white-text" onclick="mostrarModalConfirmacion('agregar')">Guardar</a>
            <a href="#!" id="cancelar_tarea" class="modal-action btn red white-text" onclick="cerrarModalTarea()">Cancelar</a>
        </div>
    </div>

    <div class="modal" id="confirmacion-modal">
      <div class="modal-content">
        <h4>Alerta</h4>
        <p id="mensaje-modal-confirmacion"></p>
        <form id="confirmacion-form">
          <input type="hidden" name="accion-confirmacion" id="accion-confirmacion">
          <input type="hidden" name="confirmacion-tareaId" id="confirmacion-tareaId">
        </form>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action btn blue white-text" id="confirmar-opcion" onclick="aceptarModalConfirmacion()">Acepto</a>
        <a href="#!" class="modal-action btn red white-text" id="cancelar-opcion" onclick="cerrarModalConfirmacion()">Cancelar</a>
      </div>
    </div>

    <script src="../js/plugins/pignose-datepicker/dist/moment.min.js"></script>
    <script src="../js/plugins/pignose-datepicker/dist/pignose.calendar.js"></script>

    <script src="../js/plugins/numeral/numeral.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {
            $('.collapsible').collapsible();
            $("#cadate").pignoseCalendar({
        lang: 'es',
        format: 'DD-MM-YYYY',
        select: onClickHandler

    });
    $('.pignose-calendar-unit-active.pignose-calendar-unit-first-active').find('a').first().trigger('click');
    
    function onClickHandler(date, obj) {
        fechaseleccionada = date[0].format('YYYY-M-D');
        var $calendar = obj.calendar;
        var text = 'Elegiste la fecha ';
        if(date[0] !== null) {
            obtenerlistaporfecha(date[0].format('YYYY-M-D'));
            
        }
        
    }
        
            var fechaHoy = obtenerFechaHoy();
            obtenerTareasLista(fechaHoy, 'USR');
            $('#fecha').val(fechaHoy);

            $('.modal').modal();

            $('#eliminar_tarea').click(function (evt) {
                Materialize.toast('Tarea eliminada');
                evt.preventDefault();
            });

            var options = {
            page: 10,
            pagination: true,
            valueNames: [ 'nombreb', 'identidadb', 'estatusb' ],
            fuzzySearch: {
                searchClass: "fuzzy-search",
                location: 0,
                distance: 100,
                threshold: 0.2,
                multiSearch: true
            }
          };

          window.listObj = new List('tareas-list', options);
        });

        function obtenerFechaHoy() {
          var fechaHoy = new Date();
          var dd = fechaHoy.getDate();
          var mm = fechaHoy.getMonth() + 1;
          var yyyy = fechaHoy.getFullYear();

          if (dd < 10) {
            dd = '0' + dd;
          }

          if (mm < 10) {
            mm = '0' + mm;
          }

          var fechaFormateada = yyyy + '-' + mm + '-' + dd;

          return fechaFormateada;
        }

        function cerrarModalTarea() {
          $('#tarea-modal').modal('close');
        }

        function mostrarModalAgregar() {
          $('#accion').val('agregar');

          $('#tarea-form')[0].reset();

          $('#tarea-modal').modal('open');
        }

        function mostrarModalConfirmacion(accion) {
          console.log(accion);
          $('#accion-confirmacion').val(accion);
          var mensaje = '';

          if (accion == 'agregar') {
            mensaje = '¿Está seguro que desea guardar esta tarea?';
          } else {
            mensaje = '¿Está seguro que desea eliminar esta tarea?';
          }
          $('#mensaje-modal-confirmacion').text(mensaje);
          $('#confirmacion-modal').modal('open');
        }

        function cerrarModalConfirmacion() {
          $('#confirmacion-modal').modal('close');
        }

        function aceptarModalConfirmacion() {
          var accion = $('#accion-confirmacion').val();
          if (accion == 'agregar') {
            guardarTarea();
          } else {
            var tareaId = $('#confirmacion-tareaId').val();
            eliminarTarea(tareaId);
          }

          cerrarModalConfirmacion();
        }

        function mostrarModalEditar(tareaId) {
          $('#accion').val('editar');

          $('#tarea-form')[0].reset();

          $.ajax({
            url: '../controllers/controladorTarea.php?accion=editar&tareaId=' + tareaId,
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
              $('#tareaId').val(data.tareaId);
              $('#titulo').val(data.titulo);
              $('#detalle').val(data.detalle);
              $('#fecha').val(data.fecha);
            },
            error: function (xhr, status, error) {
              alert('Error al obtener datos.');
            }
          });

          $('#tarea-modal').modal('open');
        }

        function mostrarModalEliminar(tareaId) {
          $('#confirmacion-tareaId').val(tareaId);
          mostrarModalConfirmacion('eliminar');
        }

        function guardarTarea() {
          var url;
          var metodoRegistro = $('#accion').val();
          var titulo = $('#titulo').val();
          var detalle = $('#detalle').val();
          var fecha = $('#fecha').val();
          var accion = $('#accion').val();
          var usuario = 'USR';
          var tareaId = $('#tareaId').val();
          var validado = true;
          var mensajes = '';

          if (titulo.trim().length <= 0) {
            validado = false;

            mensajes += '- El título esta vacío.<br />';
          }

          if (detalle.trim().length <=0) {
            validado = false;

            mensajes += '- El detalle esta vacío.<br />';
          }

          if (titulo.trim().length > 100) {
            validado = false;

            mensajes += '- El título no puede ser mayor a 100 caracteres.<br />';
          }

          if (detalle.trim().length > 2000) {
            validado = false;

            mensajes += '- El detalle no puede ser mayor a 2000 caracteres.<br />';
          }
          
          if (validado == false) {
            Materialize.toast(mensajes, 2000);
          } else {
            var data = {
              'tareaId': tareaId,
              'accion': accion,
              'titulo': titulo,
              'detalle': detalle,
              'fecha': fecha,
              'usuario': usuario
            };

            if (metodoRegistro == 'agregar') {
              url = '../controllers/controladorTarea.php';
            } else {
              url = '../controllers/controladorTarea.php';
            }

            $('#registrar_tarea').addClass('disabled');
            $('#cancelar_tarea').addClass('disabled');

            $.ajax({
              url: url,
              type: 'POST',
              data: data,
              success: function (data) {
                $('#registrar_tarea').removeClass('disabled');
                $('#cancelar_tarea').removeClass('disabled');
                $('#tarea-modal').modal('close');
                fecha = fecha.substring(0, 10);
                obtenerTareasLista(fecha, 'USR');
              },
              error: function (xhr, status, error) {
                alert('Error al guardar datos');
              }
            });
          }
        }

        function eliminarTarea(tareaId) {
          var fecha = $('#fecha').val();
          if (fecha) {

          } else {
            fecha = obtenerFechaHoy();
          }

          var data = {
            'tareaId': tareaId,
            'accion': 'eliminar'
          };

          $.ajax({
            url: '../controllers/controladorTarea.php',
            type: 'POST',
            data: data,
            success: function (data) {
              fecha = fecha.substring(0, 10);
              obtenerTareasLista(fecha, 'USR');
              Materialize.toast('Tarea eliminada :)', 2000);
            },
            error: function (xhr, status, error) {
              alert('Error al eliminar datos');
            }
          });
        }

        function obtenerTareasLista(fecha, usuario) {
          $.ajax({
            url: '../controllers/controladorTarea.php?accion=listar&fecha=' + fecha + '&usuario='+ usuario,
            type: 'GET',
            dataType: 'JSON',
            async: true,
            success: function (data) {
              var contenedorTareas = $('#tareasListaContenedor');
              contenedorTareas.text('');
              var i = 0;
              $.each(data, function (i, item) {
                i++;                
                var $li = contenedorTareas.append(
                  '<li>',
                    '<div class="collapsible-header sin-icon">',
                      '<div class="row">',
                        '<div class="col s1 m2 l2 truncate">'+ i +'</div>',
                        '<div class="col s10 m8 l8 truncate">'+ item.titulo +'</div>',
                        '<div class="col s1 m2 l2 truncate">',
                          '<a href="#!" id="editar_tarea" class="blue-text" onclick="mostrarModalEditar(' + item.tareaId + ')"><i class="material-icons">mode_edit</i></a> | ',
                          '<a href="#!" id="eliminar_tarea" class="red-text" onclick="mostrarModalEliminar('+ item.tareaId +')"><i class="material-icons">close</i>',
                          '</a>',
                        '</div>',
                      '</div>',
                    '</div>',
                    '<div class="collapsible-body no-padding">',
                      '<div class="card blue-grey white-text z-depth-0 no-margin no-border-radius">',
                        '<div class="card-content">',
                          '<span class="card-title text-darken-4">',
                            '<span class="light">Detalle: ' + item.detalle + '</span>',
                          '</span>',
                        '</div>',
                      '</div>',
                  '</div>',
                '</li>'
                );
              });
            }
          });
        }
    </script>
  </body>
</html>
