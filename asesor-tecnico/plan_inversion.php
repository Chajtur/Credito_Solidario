<script src="../js/plugins/pignose-datepicker/dist/moment.min.js"></script>
<link rel="stylesheet" href="../js/plugins/pignose-datepicker/dist/pignose.calendar.css">
<script src="../js/plugins/pignose-datepicker/dist/pignose.calendar.js"></script>
<script type="text/javascript" src="../auxiliar-creditos/buscarcenso.js"></script>

<style>
    .custom-label {
        color: #9e9e9e;
        position: absolute;
        top: 0.8rem;
        font-size: 1rem;
        cursor: text;
        transition: .2s ease-out;
        text-align: initial;
        left: 0.75rem;
    }
</style>

<section class="plan-inversion">
    <h4>PLAN DE INVERSIÓN</h4>
    <h5>REQUERIMIENTOS</h5>
    <table>
        <thead>
            <tr>
                <th>Requerimiento</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Monto L</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <h5>INVENTARIO EXISTENTE</h5>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Monto L</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <h5>REGISTROS DE COSTOS</h5>
    <table>
        <thead>
            <tr>
                <th colspan="3">Semana 1</th>
                <th colspan="3">Semana 2</th>
                <th colspan="3">Semana 3</th>
                <th colspan="3">Semana 4</th>
                <th colspan="2">Total</th>
            </tr>
            <tr>
                <th>Cantidad</th>
                <th>Costo</th>
                <th>Subtotal</th>
                <th>Cantidad</th>
                <th>Costo</th>
                <th>Subtotal</th>
                <th>Cantidad</th>
                <th>Costo</th>
                <th>Subtotal</th>
                <th>Cantidad</th>
                <th>Costo</th>
                <th>Subtotal</th>
                <th>Cantidad</th>
                <th>Costo</th>
                <th>Subtotal</th>
                <th>Cantidad</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <h5>PROYECCIÓN DE VENTA (SEMANAS)</h5>
    <table>
        <thead>
            <tr>
                <th></th>
                <th colspan="2">Semana 1</th>
                <th colspan="2">Semana 2</th>
                <th colspan="2">Semana 3</th>
                <th colspan="2">Semana 4</th>
                <th colspan="2">Total</th>
            </tr>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Monto</th>
                <th>Cantidad</th>
                <th>Monto</th>
                <th>Cantidad</th>
                <th>Monto</th>
                <th>Cantidad</th>
                <th>Monto</th>
                <th>Cantidad</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <h5>EGRESOS</h5>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Aporte del Empresario/Emprendedor</th>
                <th>Aporte Familiar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Alquileres</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Alimentación</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Transporte</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Educación</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Pago de préstamos</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Gastos de servicios públicos</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Otros</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Subtotal</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Total</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <h5>VERIFICACIÓN DEL PLAN DE INVERSIÓN</h5>
    <div class="row">
        <form id="frm-verificacion-plan">
            <div class="input-field col m6 s12">
                <input type="text" name="fecha-inspeccion" id="fecha-inspeccion">
                <label for="fecha-inspeccion">Fecha de inspección</label>
            </div>
            <div class="input-field col m6 s12">
                <input type="text" name="nombre-cliente" id="nombre-cliente">
                <label for="nombre-cliente">Nombre del cliente</label>
            </div>
            <div class="input-field col m6 s12">
                <input type="text" name="grupo-solidario" id="grupo-solidario">
                <label for="grupo-solidario">Grupo solidario</label>
            </div>
            <div class="input-field col m6 s12">
                <select name="inversion-aprobada" id="inversion-aprobada">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
                <label for="inversion-aprobada">¿Realizó la inversión según lo aprobado?</label>
            </div>
            <div class="input-field">
                <textarea name="verificacion-observercion" id="verificacion-observercion" class="materialize-textarea"></textarea>
                <label for="verificacion-observercion">Observaciones</label>
            </div>
        </form>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('select').material_select();
    });
</script>