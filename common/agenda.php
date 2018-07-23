<?php

require '../php/conection.php';
session_start();

$user = $_SESSION['user'];
/*query para obtener cada registro en la bitacora*/
$sql = $conn->prepare('select * from bitacora_agenda where iduser = :user order by fecha DESC limit 10');
$sql->bindValue(':user', $user, PDO::PARAM_STR);
$sql->execute();
$agenda = $sql->fetchAll();


?>


    <div class="section">

        <!--cartas de estado Inicio-->
        <!--<div class="row">
            <div id="card-stats">
                <div class="row margin">
                    <div class="col s12 m8 l3 wow fadeInLeft" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat1" class="card">
                            <div class="card-content  teal accent-4 white-text">
                                <p class="card-stats-title"><i class="material-icons">looks_one</i> Ciclo 1</p>
                                <h4 id="cartera-activa" class="card-stats-number">50</h4>
                                <p class="card-stats-compare"><i class="material-icons">local_atm</i> L. 10,000.00 <span class="green-text text-lighten-5">desembolsado</span>
                                </p>
                            </div>
                            <div class="card-action  teal darken-2">

                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l3 wow fadeInDown" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat2" class="card">
                            <div class="card-content pink lighten-2 white-text">
                                <p class="card-stats-title"><i class="material-icons">looks_two</i> Ciclo 2</p>
                                <h4 id="total-mora" class="card-stats-number">30</h4>
                                <p class="card-stats-compare"><i class="material-icons">local_atm</i> L. 545.00 <span class="purple-text text-lighten-5">desembolsado</span>
                                </p>
                            </div>
                            <div class="card-action pink darken-2">

                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l3 wow fadeInRight" data-wow-offset="10" data-wow-duration="1.5s">
                        <div id="cardStat3" class="card wow fadeInDown" data-wow-duration="1s">
                            <div class="card-content blue accent-2 white-text">
                                <p class="card-stats-title"><i class="material-icons">looks_3</i> Ciclo 3</p>
                                <h4 id="porcentaje-mora" class="card-stats-number">56</h4>
                                <p class="card-stats-compare"><i class="material-icons">local_atm</i> L. 8,965.00 <span class="blue-grey-text text-lighten-5">desembolsado</span>
                                </p>
                            </div>
                            <div class="card-action blue accent-4">

                            </div>
                        </div>
                    </div>
                    <div class="col s12 m8 l3 ">
                        <div id="cardStat4" class="card">
                            <div class="card-content deep-purple white-text">
                                <p class="card-stats-title"><i class="material-icons">beenhere</i> Total de Créditos</p>
                                <h4 class="card-stats-number">4,984</h4>
                                <p class="card-stats-compare"><i class="material-icons">local_atm</i> L. 45,000.00 <span class="deep-purple-text text-lighten-5">en  total</span>
                                </p>
                            </div>
                            <div class="card-action  deep-purple darken-2">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <!--cartas de estado final-->
        <div class="row">
            <div class="col s12 m4 l4">
                <div style="margin-top:8px" id="cadate" class="calender z-depth-1"></div>
            </div>

            <div class="col s12 m8 l8">

                <div id="work-collections" class="hide-on-small-only">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                            <ul id="projects-collection" class="collection z-depth-1">
                                <li class="collection-item avatar">
                                    <i class="material-icons circle light-blue ">list</i>
                                    <span class="collection-header">Agenda</span>
                                    <p>Agenda de trabajo diaria</p>
                                    <div class="secondary-content actions">
                                        <a href="#modal1" class="waves-effect waves-light btn-flat nopadding">
                                            <i class="material-icons center-align">add</i>
                                        </a>
                                    </div>
                                    <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s3 m2 l2">
                                            <p class="collections-title">Fecha</p>
                                        </div>
                                        <div class="col s4 m3 l3">
                                            <p class="collections-title">Título</p>
                                        </div>
                                        <div class="col s2 m2 l7">
                                            <p class="collections-title">Descripción</p>
                                        </div>
                                        <div class="col s2 center">
                                            <p class="collections-title">Acciones</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!--movil-->
                <div id="work-collapsible" class="hide-on-med-and-up">
                    <div class="row">
                        <div class="col s12" id="">
                            <ul id="projects-collection" class="collapsible" data-collapsible="accordion">
                                <li class="collapsible-item-header avatar">
                                    <i class="material-icons circle circle light-blue ">timeline</i>
                                    <span class="collapsible-title-header">Agenda
                                        <div class="secondary-content actions">
                                            <a href="#modal1" class="waves-effect waves-light btn-flat nopadding">
                                                <i class="material-icons center-align">add</i>
                                            </a>
                                        </div>
                                    </span>
                                    <p>Agenda diaria de trabajo</p>
                                    <!--<a href="#" class="secondary-content waves-effect waves-green"><i class="material-icons">search</i></a>-->
                                </li>
                                <li>
                                    <div class="collapsible-header-titles  sin-icon">
                                        <div class="row">
                                            <div class="col s3">
                                                <p class="collapsible-title">Fecha</p>
                                            </div>
                                            <div class="col s3">
                                                <p class="collapsible-title">Título</p>
                                            </div>
                                            <div class="col s4">
                                                <p class="collapsible-title">Descripción</p>
                                            </div>
                                            <div class="col s2">
                                                <p class="collapsible-title">acciones</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <div class="list collapsible no-padding no-margin z-depth-0">
                                    
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="modal1" class="modal modal-fixed-footer modal-max-width">
        <div class="modal-content">
            <h5>Ingreso de datos</h5>
            <div class="divider"></div>
            <br>
            
            
        </div>
        <div class="modal-footer">
            <a id="agregarDesembolsados" href="#!" class="modal-action waves-effect waves-blue blue-text btn-flat">Agregar</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="modal2" class="modal modal-fixed-footer modal-max-width">
        <div class="modal-content">
            <h5>Edición de datos</h5>
            <div class="divider"></div>
            <br>
            <p id="idreg" class="hide"></p>
            <div class="row">
                <div class="input-field col s12">
                    <input disabled placeholder="" id="fechaEdit" type="text" class="validate">
                    <label class="active" for="cantidadCreditos">Fecha</label>
                    <label class="error" id="error-label">Este campo es requerido</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a id="editarDesembolsados" href="#!" class="modal-action waves-effect waves-blue blue-text btn-flat">Guardar</a>
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
        </div>
    </div>

    <div class="divider"></div>


    <script src="../js/plugins/pignose-datepicker/dist/moment.min.js"></script>
    <script src="../js/plugins/pignose-datepicker/dist/pignose.calendar.js"></script>

    <script src="../js/plugins/numeral/numeral.js"></script>
    <script src="../common/agenda.js"></script>
