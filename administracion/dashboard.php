<?php session_start();?>
<div class="section">
    <div class="row margin">
        <div class="col s12">

            <div id="work-collapsible">
                <div class="row">
                    <div class="col s12" id="todos-los-beneficiarios">
                        <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                            <li class="collapsible-item-header avatar">
                                <i class="material-icons circle light-blue">list</i>
                                <span class="collapsible-title-header">Cartera Total
                                    <div class="secondary-content actions">
                                        <input class="search-expandida fuzzy-search" type="search" placeholder="buscar usuario" />
                                        <a class="waves-effect waves-light icon-collapse-search btn-flat nopadding">
                                            <i class="material-icons center-align">search</i>
                                        </a> 
                                        <form action="../php/excel.php" method="post" id="form_excel">
                                            <input type="hidden" name="user_id" id="hidden_id" value="<?php echo $_SESSION['user'];?>">
                                            <button type="submit" class="waves-effect btn-flat nopadding"><i class="material-icons">description</i></button>
                                        </form> 
                                        <a id="desactivarLista" class="dropdown-button waves-effect waves-light btn-flat nopadding" data-activates='dropdown_listOrder'>
                                            <i class="material-icons center-align">sort</i>
                                        </a> 
                                    </div>
                                </span>
                                <p>Información acerca de su cartera total.</p>
                            </li>
                            <li>
                                <div class="collapsible-header-titles sin-icon">
                                    <div class="row">
                                        <div class="col s2 m1 l1"><p class="collapsible-title">#</p></div>
                                        <div class="col s10 m3 l3 "><p id="headerNombre" class="collapsible-title">Nombre</p></div>
                                        <div class="col s6 m3 l3 hide-on-small-only"><p class="collapsible-title">Identidad</p></div>
                                        <div class="col s6 m2 l2 hide-on-small-only"><p class="collapsible-title">Ciclo</p></div>
                                        <div class="col s6 m3 l3 hide-on-small-only"><p class="collapsible-title">IFI</p></div>
                                    </div>
                                </div>
                            </li>

                            <div class="list collapsible no-padding no-margin z-depth-0">

                            </div>

                            <li class="collapsible-item-header light">
                                <ul id="pag-control" class="pag pagination">
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Dropdown Structure -->
<ul id='dropdown_listOrder' class='dropdown-content'>
    <li><a value="5" href="#!">ver 5</a></li>
    <li><a value="10" href="#!">ver 10</a></li>
    <li><a value="20" href="#!">ver 20</a></li>
    <li><a value="10000" href="#!">ver todo</a></li>
</ul>

<!-- Modal Structure -->
<div id="modal-plan-pago" class="modal modal-fixed-footer modal-max-width">
    <div class="modal-content">
        <h4 class="light blue-text">Plan de pagos</h4>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cuota</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>2012-02-02</td>
                    <td>190</td>
                </tr>
                <tr>
                    <td>2012-02-02</td>
                    <td>190</td>
                </tr>
            </tbody>
        </table>
        <div id="modal-plan-pagos-content"></div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cerrar</a>
    </div>
</div>