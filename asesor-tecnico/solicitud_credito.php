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

<section class="linea-base">
    <h4>LÍNEA BASE: EVALUACIÓN DE CALIDAD Y CONDICIONES DE VIDA</h4>
    <h5>Información sobre la vivienda.</h5>
    <div class="row">
        <form id="form-informacion-vivienda">
            <div class="input-field col s12">
                <input type="range" name="tiempo-vivienda" id="tiempo-vivienda" min="0" max="20"><br>
                <p class="custom-label">Tiempo de residir en la vivienda</p>
            </div>
            <div class="input-field col s12">
                <select name="material-vivienda" id="material-vivienda">
                    <option value="1">Ladrillo</option>
                    <option value="2">Adobe</option>
                    <option value="3">Madera</option>
                    <option value="4">Bloque</option>
                    <option value="5">Otro</option>
                </select>
                <label for="material-vivienda">Material que predomina en vivienda</label>
            </div>
            <div class="input-field col s12">
                <p>
                    <input type="checkbox" name="chk-energia-electrica" id="chk-energia-electrica" min="0" max="100">
                    <label for="chk-energia-electrica">Energía eléctrica</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-agua-potable" id="chk-agua-potable" min="0" max="100">
                    <label for="chk-agua-potable">Red de agua potable</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-agua-negras" id="chk-agua-negras" min="0" max="100">
                    <label for="chk-agua-negras">Red de aguas negras</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-letrina" id="chk-letrina" min="0" max="100">
                    <label for="chk-letrina">Pozo séptico/Letrina/otro</label>
                </p>
                <p>
                    <input type="checkbox" name="chk-telefono" id="chk-telefono" min="0" max="100">
                    <label for="chk-telefono">Teléfono fijo</label>
                </p>
                <label>Marque los servicios públicos que tiene en su vivienda</label>
            </div>
            <div class="input-field col s12">
                <input type="range" name="personas-vivienda" id="personas-vivienda" min="0" max="15"><br>
                <p class="custom-label"># de personas que habitan en la vivienda</p>
            </div>
            <div class="input-field col s12">
                <input type="range" name="familias-vivienda" id="familias-vivienda" min="0" max="4"><br>
                <p class="custom-label"># de familias que habitan en la vivienda</p>
            </div>
            <div class="input-field col s12">
                <input type="range" name="trabajadores-vivienda" id="trabajadores-vivienda" min="0" max="10"><br>
                <p class="custom-label"># de trabajadores que habitan en la vivienda</p>
            </div>
            <div class="input-field col s12">
                <input type="range" name="dependientes-vivienda" id="dependientes-vivienda" min="0" max="10"><br>
                <p class="custom-label"># de dependientes que habitan en la vivienda</p>
            </div>
            <div class="input-field col s12">
                <input type="range" name="desempleados-vivienda" id="desempleados-vivienda" min="0" max="10"><br>
                <p class="custom-label"># de desempleados que habitan en la vivienda</p>
            </div>
        </form>
    </div>
</section>

<section class="nivel-educacion">
    <h4>NIVEL DE EDUCACIÓN Y OCUPACIÓN DE LOS MIEMBROS DE SU FAMILIA</h4>
    <h5>Nivel educativo</h5>
    <table>
        <thead>
            <tr>
                <th>Parentesco</th>
                <th>Fecha de nacimiento</th>
                <th>Sexo</th>
                <th>Ocupación</th>
                <th>Primaria</th>
                <th>Secundaria</th>
                <th>Universidad</th>
                <th>Ninguno</th>
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
            </tr>
        </tbody>
    </table>
    <h5>Enfermedades que afectan con mayor frecuencia a los niños y adultos de su familia y como las tratan</h5>
    <table>
        <thead>
            <tr>
                <th>Parentesco</th>
                <th>Enfermedad</th>
                <th>Tratamiento</th>
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
</section>

<section class="plan-negocio">
    <h5>MARCO ESTRATÉGICO</h5>
    <form id="plan-negocio">
        <div class="input-field">
            <input type="text" name="plan-mision" id="plan-mision">
            <label for="plan-mision">Misión</label>
        </div>
        <div class="input-field">
            <input type="text" name="plan-vision" id="plan-vision">
            <label for="plan-vision">Visión</label>
        </div>
    </form>
    <h4>Objetivos</h4>
    <table>
        <thead>
            <tr>
                <th>Objetivo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Objetivo 1</td>
            </tr>
            <tr>
                <td>Objetivo 2</td>
            </tr>
        </tbody>
    </table>
    <h4>Valores</h4>
    <table>
        <thead>
            <tr>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Valor 1</td>
            </tr>
            <tr>
                <td>Valor 2</td>
            </tr>
        </tbody>
    </table>
    <h4>FODA</h4>
    <div class="row">
        <form id="form-foda">
            <div class="input-field col s6">
                <textarea class="materialize-textarea" name="plan-fortalezas" id="plan-fortalezas"></textarea>
                <label for="plan-fortalezas">Fortalezas</label>
            </div>
            <div class="input-field col s6">
                <textarea class="materialize-textarea" name="plan-oportunidades" id="plan-oportunidades"></textarea>
                <label for="plan-oportunidades">Oportunidades</label>
            </div>
            <div class="input-field col s6">
                <textarea class="materialize-textarea" name="plan-debilidades" id="plan-debilidades"></textarea>
                <label for="plan-debilidades">Debilidades</label>
            </div>
            <div class="input-field col s6">
                <textarea class="materialize-textarea" name="plan-amenazas" id="plan-amenazas"></textarea>
                <label for="plan-amenazas">Amenazas</label>
            </div>
        </form>
    </div>

    <h5>ASPECTOS ORGANIZATIVOS</h5>
    <form id="frm-aspectos-organizativos">
        <div class="input-field">
            <input type="range" name="empleos-genera" id="empleos-genera">
            <p class="custom-label">Empleos que genera</p>
        </div>
    </form>
    <h6>Empleados</h6>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Persona</th>
                <th>Cualidad</th>
                <th>Responsabilidad y funciones</th>
                <th>Reconocimiento</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <h5>PRODUCTO Y FORMA DE DISTRIBUCIÓN</h5>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Ventaja competitiva</th>
                <th>Forma de distribución</th>
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
    <h5>CLIENTES FRECUENTES</h5>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ubicación de clientes o tipo de relación</th>
                <th>Teléfono</th>
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
</section>

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
            <div class="input-field">
                <input type="text" name="fecha-inspeccion" id="fecha-inspeccion">
                <label for="fecha-inspeccion">Fecha de inspección</label>
            </div>
            <div class="input-field">
                <input type="text" name="nombre-cliente" id="nombre-cliente">
                <label for="nombre-cliente">Nombre del cliente</label>
            </div>
            <div class="input-field">
                <input type="text" name="grupo-solidario" id="grupo-solidario">
                <label for="grupo-solidario">Grupo solidario</label>
            </div>
            <div class="input-field">
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