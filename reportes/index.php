<?php require 'head.php'; ?>

    <div class="card">
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a class="active" href="#desembolsos">Desembolsos</a></li>
                    <li class="tab col s3"><a href="#recuperacion">Recuperación</a></li>
                </ul>
            </div>
            <div id="desembolsos" class="col s12">
                <form action="../php/desembolsos.php" method="post">
                    <div class="card-content">
                        <h5>Reporte de desembolsos</h5>
                        <div class="row">
                            <div class="input-field col l12 m12 s12">
                                <select name="select_ifi" id="select_ifi" class="validate" required>
                                    <option value="" selected disabled>Seleccione una IFI...</option>
                                    <option value="1">Banco de los Trabajadores</option>
                                    <option value="2">Banrural</option>
                                    <option value="3">Cooperativa Chorotega</option>
                                    <option value="4">Catacamas</option>
                                    <option value="8">Banadesa</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l6 m6 s12">
                                <label for="date_desde">Desde</label>
                                <input type="date" name="date_desde" id="date_desde" class="datepicker" placeholder="Fecha" format="yyy-mm-dd" required>
                            </div>
                            <div class="input-field col l6 m6 s12">
                                <label for="date_hasta">Hasta</label>
                                <input type="date" name="date_hasta" id="date_hasta" class="datepicker" placeholder="Fecha" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l12 m12 s12">
                                <select name="select_formato" id="select_formato" class="validate" required>
                                    <option value="" disabled selected>Seleccione un formato...</option>
                                    <option value="xls">Excel</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <input type="submit" value="Generar" class="btn">
                    </div>
                </form>
            </div>
            <div id="recuperacion" class="col s12">
                <form action="../php/recuperacion.php" method="post">
                    <div class="card-content">
                        <h5>Reporte de Recuperación</h5>
                        <div class="row">
                            <div class="input-field col l6 m6 s12">
                                <select name="select_ifi_rec[]" id="select_ifi_rec" class="validate" required multiple>
                                    <option value="" selected disabled>Seleccione las IFI...</option>
                                    <option value="1">Banco de los Trabajadores</option>
                                    <option value="2">Banrural</option>
                                    <option value="3">Cooperativa Chorotega</option>
                                    <option value="4">Catacamas</option>
                                    <option value="8">Banadesa</option>
                                </select>
                            </div>
                            <div class="input-field col l6 m6 s12">
                                <select name="select_fondo" id="select_fondo" class="validate" required multiple disabled="true">
                                    <option value="" selected disabled>Seleccione los fondos...</option>
                                    <option value="f01">REDUC</option>
                                    <option value="f02">FINA</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l6 m6 s12">
                                <label for="date_desde_rec">Desde</label>
                                <input type="date" name="date_desde_rec" id="date_desde_rec" class="datepicker" placeholder="Fecha" format="yyy-mm-dd" required>
                            </div>
                            <div class="input-field col l6 m6 s12">
                                <label for="date_hasta_rec">Hasta</label>
                                <input type="date" name="date_hasta_rec" id="date_hasta_rec" class="datepicker" placeholder="Fecha" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l12 m12 s12">
                                <select name="select_formato_rec" id="select_formato_rec" class="validate" required>
                                    <option value="" disabled selected>Seleccione un formato...</option>
                                    <option value="xls">Excel</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="container">
                                <p>Nota: Puede que algunos reportes sean demasiado grandes y no halla suficiente memoria para generarlos.
                                    <br> En ese caso intente generar la Recuperación de una sola ifi a la vez.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <input type="submit" value="Generar" class="btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
<?php require 'footer.php'; ?>