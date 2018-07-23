<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Prueba documento</title>
            <!-- Compiled and minified CSS -->
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="http://creditosolidario.hn/csfrontend/php/plugins/reception-report/bootstrap.css">
            <style>

                * {
                    color: #000000 !important;
                    font-family: sans-serif;
                }

                th, td {
                    font-size: 12px;
                }

            </style>
        </head>
        <body>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                       <img src="../../images/logocredito.png" alt="" class="img-responsive">
                    </div>
                    <div class="col-xs-2 col-xs-offset-6 col-sm-2 col-sm-offset-6 col-md-2 col-md-offset-6 col-lg-2 col-lg-offset-6">
                       <img src="../../images/logo-presidencia.png" alt="" class="img-responsive">
                    </div>
                </div>
            </div><br><br>
            
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <h2>Créditos Recibidos</h2>
                        <h4>Departamento: '.$this->department.'</h4>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <h3>01/01/2111</h3>
                        <h4>20:00</h4>
                    </div>
                </div>
            </div>
            <br><br><br><br><br>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered">
                            <caption>Supervisor: '.$supervisor['supervisor'].'</caption>
                            <thead>
                              <tr>
                                  <th>Hash</th>
                                  <th>Beneficiario</th>
                                  <th>Identidad</th>
                                  <th>Nombre Grupo</th>
                                  <th>Asesor</th>
                                  <th>Ciclo</th>
                              </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>'.$credito['grupo_solidario_hash'].'</td>
                                    <td>'.$credito['nombre'].'</td>
                                    <td>'.$credito['identidad'].'</td>
                                    <td>'.$credito['grupo_solidario'].'</td>
                                    <td>'.$credito['gestor'].'</td>
                                    <td>'.$credito['ciclo'].'</td>
                                </tr>
                                <tr>
                                    <td>'.$credito['grupo_solidario_hash'].'</td>
                                    <td>'.$credito['nombre'].'</td>
                                    <td>'.$credito['identidad'].'</td>
                                    <td>'.$credito['grupo_solidario'].'</td>
                                    <td>'.$credito['gestor'].'</td>
                                    <td>'.$credito['ciclo'].'</td>
                                </tr>
                                <tr>
                                    <td>'.$credito['grupo_solidario_hash'].'</td>
                                    <td>'.$credito['nombre'].'</td>
                                    <td>'.$credito['identidad'].'</td>
                                    <td>'.$credito['grupo_solidario'].'</td>
                                    <td>'.$credito['gestor'].'</td>
                                    <td>'.$credito['ciclo'].'</td>
                                </tr>
                                <tr>
                                    <td>'.$credito['grupo_solidario_hash'].'</td>
                                    <td>'.$credito['nombre'].'</td>
                                    <td>'.$credito['identidad'].'</td>
                                    <td>'.$credito['grupo_solidario'].'</td>
                                    <td>'.$credito['gestor'].'</td>
                                    <td>'.$credito['ciclo'].'</td>
                                </tr>
                                <tr>
                                    <td>'.$credito['grupo_solidario_hash'].'</td>
                                    <td>'.$credito['nombre'].'</td>
                                    <td>'.$credito['identidad'].'</td>
                                    <td>'.$credito['grupo_solidario'].'</td>
                                    <td>'.$credito['gestor'].'</td>
                                    <td>'.$credito['ciclo'].'</td>
                                </tr>
                                <tr>
                                    <td>'.$credito['grupo_solidario_hash'].'</td>
                                    <td>'.$credito['nombre'].'</td>
                                    <td>'.$credito['identidad'].'</td>
                                    <td>'.$credito['grupo_solidario'].'</td>
                                    <td>'.$credito['gestor'].'</td>
                                    <td>'.$credito['ciclo'].'</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
                        <hr>
                        <h5>'.$entrega.'</h5>Entrega
                    </div>
                    <div class="col-xs-3 col-xs-offset-4 col-sm-3 col-sm-offset-4 col-md-3 col-md-offset-4 col-lg-3 col-lg-offset-4 text-center">
                        <hr>
                        <h5>'.$name['name'].'</h5>Recibe
                    </div>
                </div>
            </div>
            <br>
            </body>
        </html>