<?php

/**
 * Clase ReceptionReport
 * Sirve para crear y gestionar la creación de los reportes de recepción de créditos
 * @author Ricardo Valladares (Rychiv4)
 */

require_once '/../dompdf/autoload.inc.php';
use Dompdf\Adapter\CPDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Exception;

class ReceptionReport{
    
    public $name;
    public $department;
    public $user;
    public $groups = [];
    
    function __construct($n, $d, $u){ // Param: name, department, user
        
        $this->name = $n;
        $this->department = $d;
        $this->user = $u;
        $this->groups = array();
    }
    
    /**
     * Función que genera el reporte a un directorio dado
     *
     * @param string $dir dirección donde se guardará el archivo
     * @param PDO $conn conexión a la base de datos crédito solidario
     * @param PDO $conn2 conexión a la base de datos censo_nacional
     * @param string $entrega nombre de la persona que entrega los créditos
     * @return boolean true y genera el archivo en la $dir especificada
     */
    function generateReportToDirectory($dir = '', $conn, $conn2, $entrega){
        
        // Codigo para generars
        $stat = $conn->prepare('select distinct supervisor from cartera_consolidada 
        where grupo_solidario_hash in ('.'"'.implode('","', $this->groups).'"'.')');
        $stat->execute();
        
        $supervisores = $stat->fetchAll();
        
        $larahrmstat = $conn2->prepare('select concat(first_name, " ", last_name) as name from users where employee_id = :id or username = :id');
        $larahrmstat->bindValue(':id', $this->user, PDO::PARAM_STR);
        $larahrmstat->execute();
        $name = $larahrmstat->fetch(PDO::FETCH_ASSOC);

        $stat = $conn->prepare('select grupo_solidario_hash, nombre, identidad, grupo_solidario, gestor, ciclo from cartera_consolidada 
        where grupo_solidario_hash in ('.'"'.implode('","', $this->groups).'"'.') and supervisor = :supervisor');

        $string = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Reporte Autogenerado</title>
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="'.__DIR__.'\bootstrap\css\bootstrap.css">
            <style>
                * {
                    color: #000000 !important;
                    font-family: sans-serif;
                }

                h1,
                h2,
                h3,
                h4,
                h5,
                h6,
                .h1,
                .h2,
                .h3,
                .h4,
                .h5,
                .h6 {
                    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                }

                th, td {
                    font-size: 12px;
                }

                .no-padding-sides {
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                }

            </style>
        </head>
        <body>

            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 no-padding-sides">
                    <img src="http://creditosolidario.hn/csfrontend/images/logocredito.png" alt="" class="img-responsive">
                </div>
                <div class="col-xs-2 col-xs-offset-6 col-sm-2 col-sm-offset-6 col-md-2 col-md-offset-6 col-lg-2 col-lg-offset-6 no-padding-sides">
                    <img src="http://creditosolidario.hn/csfrontend/images/logo-presidencia.png" alt="" class="img-responsive">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 no-padding-sides">
                    <h2>Créditos '.($this->department == 'Créditos' ? 'Devueltos' : 'Recibidos').'</h2>
                    <h4>Departamento: '.$this->department.'</h4>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 no-padding-sides text-center">
                    <h3>'.date("d/m/Y").'</h3>
                    <h4>Hora: '.date("G:i").'</h4>
                </div>
            </div>
            ';            

        foreach($supervisores as $supervisor){

            $string .= '
            <table class="table table-condensed table-bordered">
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

                <tbody>';

            $stat->bindValue(':supervisor', $supervisor['supervisor'], PDO::PARAM_STR);
            $stat->execute();
            $creditos = $stat->fetchAll();

            foreach($creditos as $credito){

                $string .= '
                    <tr>
                        <td>'.$credito['grupo_solidario_hash'].'</td>
                        <td>'.$credito['nombre'].'</td>
                        <td>'.$credito['identidad'].'</td>
                        <td>'.$credito['grupo_solidario'].'</td>
                        <td>'.$credito['gestor'].'</td>
                        <td>'.$credito['ciclo'].'</td>
                    </tr>
                ';

            }
            
            $string .= '    
                </tbody>
            </table>
            ';

        }
        
        $string .= '
            <h5><span class="light">Cantidad de Grupos: </span>'.sizeof($this->groups).'</h5>
            <br>
            <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center no-padding-sides">
                    <hr>
                    <h5>'.$entrega.'</h5>Entrega
                </div>
                <div class="col-xs-3 col-xs-offset-4 col-sm-3 col-sm-offset-4 col-md-3 col-md-offset-4 col-lg-3 col-lg-offset-4 text-center no-padding-sides">
                    <hr>
                    <h5>'.$name['name'].'</h5>Recibe
                </div>
            </div>
            <br>';
        
        $string .= '
        </body>
        </html>
        ';

        // return $string;

        //$html = file_get_contents('archivo.php');
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        // instantiate and use the dompdf class
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($string);

        // (Optional) Setup the paper size and orientation
        //$dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        $output = $dompdf->output();
        if(!is_dir($dir)){
            mkdir($dir, 0755);
        }
        // Output the generated PDF to Browser
        file_put_contents($dir.$this->name, $output);
        
        return true;
        
    }
    
    /**
     * Método que guarda en la base de datos de documentos el archivo generado
     *
     * @param PDO $c conexión a la base de datos de crédito solidario
     * @return boolean true
     */
    function saveToDatabase($c){ // Param: the conection
        
        $stat = $c->prepare('insert into registro_documentos(nombre_documento, departamento, usuario) values(:nombre, :departamento, :usuario)');
        $stat->bindValue(':nombre', $this->name, PDO::PARAM_STR);
        $stat->bindValue(':departamento', $this->department, PDO::PARAM_STR);
        $stat->bindValue(':usuario', $this->user, PDO::PARAM_STR);
        return $stat->execute();
        
    }
    
}

?>