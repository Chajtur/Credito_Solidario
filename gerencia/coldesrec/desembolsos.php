<div class="row">
    <div class="col l4 m4 s4">
        <div class="card">
            <div class="card-content">
                <div style="" id="cadate" class="calender">
                </div>
                <div class="input-field">
                    <select id="select-filtro">
                        <option value="0" selected>General</option>
                        <option value="1">Departamento</option>
                        <option value="2">Agencia</option>
                        <option value="3">Coordinador</option>
                        <option value="4">Supervisor</option>
                        <option value="5">Asesor Técnico</option>
                        <option value="6">Ifi</option>
                        <option value="7">Fondo</option>
                        <option value="8">Ciclo</option>
                        <option value="9">Programa</option>
                    </select>
                    <label for="select-filtro">Desembolsos por</label>
                </div>
                <div class="input-fielf">
                    <input type="checkbox" id="agrupado"/>
                    <label for="agrupado" class="tooltipped" data-position="right" data-delay="10" data-tooltip="Consolidar los desembolsos de todo el rango de fecha">Consolidar</label>
                </div>
            </div>
            <div class="card-action">
                <a href="#!" class="btn-flat modal-action" id="btn-loader">
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
                <a href="#!" class="btn-flat" id="btn-generar">Generar</a>
            </div>
        </div>
    </div>
    <div class="col l4 m4 s4 offset-l2 offset-m2 offset-s2">
        <div class="center" id="loading-current">
            <br>
            <br>
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
        <div class="card blue-grey" id="mensaje">
            <div class="card-content white-text">
                <span class="card-title">Reporte de Desembolsos</span>
                <p>Seleccione, desde el calendario de la izquierda, la fecha inicial y final del reporte de desembolsos que desea ver. <br>
                    Luego seleccione el elemento por el cual se filtrará la información.
                </p>
            </div>
        </div>
    </div>
    <div class="col s12 m8 l8" id="table-content">

        <div id="work-collections" class="hide-on-small-only">
            <div class="row">
                <div class="col s12 m12 l12 no-padding">
                    <ul id="projects-collection" class="collection z-depth-1">
                        <li class="collection-item avatar">
                            <i class="material-icons circle light-blue ">list</i>
                            <span id="titulo-del-collection" class="collection-header">Reporte de Desembolsos</span>
                            <p id="descripcion-del-collection">lista de créditos desembolsados</p>
                            <div class="secondary-content actions">
                                <a href="#modal1" class="waves-effect waves-light btn-flat nopadding tooltipped generar-excel" data-delay="10" data-position="left" data-tooltip="Exportar a Excel">
                                    <i class="material-icons center-align">description</i>
                                </a>
                            </div>
                            <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                        </li>
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s3 m3 l3">
                                    <p class="collections-title">Fecha</p>
                                </div>
                                <div class="col s5 m5 l5">
                                    <p class="collections-title">Detalle</p>
                                </div>
                                <div class="col s2 m2 l2 center">
                                    <p class="collections-title">Cantidad</p>
                                </div>
                                <div class="col s2 m2 l2 center">
                                    <p class="collections-title">Monto</p>
                                </div>
                            </div>
                        </li>
                        <div id="list-rows" class="list">
                        </div>
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s12">
                                    <ul class="pagination"></ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/plugins/pignose-datepicker/dist/moment.min.js"></script>
<script src="../js/plugins/pignose-datepicker/dist/pignose.calendar.js"></script>
<script src="../js/plugins/numeral/numeral.js"></script>
<script type="text/javascript" src="coldesrec/desembolsos/desembolsos.js"></script>