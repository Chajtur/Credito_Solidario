<?php

/**
 * Clase ProExcel
 * Sirve para generar un archivo de excel en base a un query dado
 * @author Ricardo Valladares (Rychiv4)
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/csfrontend/php/PHPExcel.php';

class ProExcel{

    public $nombre; // Nombre del archivo final
    public $ruta; // Ruta donde generar el archivo
    public $conection; // PDO conexión a crédito solidario
    public $query; // Query en el cual se basará el archivo
    public $outputEnable = false; // Si es true se generará el archivo en la ventana actual, en caso contrario se generará en la ruta
    public $nombreConFecha = true; // Si se desea concatenar la fecha actual (current_timestamp) en el nombre del archivo

    /**
     * Al crear el archivo hay que enviar obligatoriamente el nombre, la ruta y la PDO conection a la base de datos de crédito solidario
     * Si se desea outputenable y no es necesaria la ruta, enviar la ruta con un string vacío
     */
    function __construct($nombre, $ruta, $conection){
        $this->nombre = $nombre;
        $this->ruta = $ruta;
        $this->conection = $conection;
    }

    /**
     * Método para generar un archiv de excel en base a los parámetros configurados previamente
     * si outputenable = true entonces generará el archivo en la ventana actual, sino lo guardará en la ruta especificada 
     *
     * @return boolean true o false
     */
    public function generarExcel(){

        $letters = range('A', 'Z');

        $archivo = new PHPExcel();
        $archivo->getProperties()
            ->setCreator('Credito Solidario')
            ->setTitle('Reporte autogenerado');

        $stat = $this->conection->prepare($this->query);
        $stat->execute();
        $result = $stat->fetchAll(PDO::FETCH_ASSOC);

        // generar los headers

        $i=0;$j=1;
        // error_log(json_encode($result));
        $first = $result[0];

        foreach($first as $header => $value){

            $archivo->getActiveSheet()->setCellValueByColumnAndRow($i, $j, $header);
            $i++;

        }

        // escribir celdas

        $j++;
        foreach($result as $array){

            $i=0;
            foreach($array as $header => $fila){
                $archivo->getActiveSheet()->setCellValueByColumnAndRow($i, $j, $fila);
                $i++;
            }
            $j++;

        }

        // formatear celdas
        // Estilo de los headers
        $styleArray = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '1A237E')
            ),
            'font'  => array(
                'color' => array('rgb' => 'ffffff'),
                'size'  => 13
            )
        );
        $i=0;
        foreach($first as $header => $value){
            
            if($i >= count($letters)){
                return false;
            }
            $archivo->getActiveSheet()->getColumnDimension($letters[$i])
                    ->setAutoSize(true); // autosize
            $archivo->getActiveSheet()->getStyle($letters[$i].'1')->applyFromArray($styleArray); // headers
            $i++;

        }

        $archivo->getDefaultStyle()->getFont()
            ->setName('Calibri')
            ->setSize(12);

        // asignar nombre, fecha y generar archivo

        $date = new DateTime();
        $nombre_archivo = $this->nombre.($this->nombreConFecha == true ? '-'.$date->format('d-m-Y') : '');

        if($this->outputEnable){

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($archivo, 'Excel5');
            $objWriter->save('php://output');
            return true;

        }else{

            $excelwriter = PHPExcel_IOFactory::createWriter($archivo, 'Excel5');
            $root = explode('/',$_SERVER['PHP_SELF']);
            try{
                $excelwriter->save($_SERVER['DOCUMENT_ROOT'].'/'.$root['1'].'/'.($this->ruta != '' ? $this->ruta.'/' : '').$this->nombre.'.xls');
                $this->ruta = 'http://'.$_SERVER['SERVER_NAME'].'/'.$root['1'].'/'.($this->ruta != '' ? $this->ruta.'/' : '').$this->nombre.'.xls';
                return true;
            }catch(PHPExcel_Writer_Exception $e){
                return false;
            }

        }

    } 

}

?>
