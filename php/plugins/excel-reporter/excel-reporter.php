<?php

/**
 * ExcelReporter es la clase que sirve para generar el archivo de excel luego de colocar un crédito
 * @author Ricardo Valladares (Rychiv4)
 */

require_once '/../../PHPExcel.php';

class ExcelReporter{
    
    public $name;
    public $user;
    public $groups;
    
    /**
     * Al crear una instancia de la clase es obligatorio enviar en el constructor los parametros descritos a continuación
     *
     * @param string $n nombre del archivo que será generado
     * @param [type] $g arreglo de grupos que estarán en el excel
     * @param [type] $u usuario que generó el archivo de excel
     */
    function __construct($n, $g, $u){
        
        $this->name = $n;
        $this->groups = $g;
        $this->user = $u;
        
    }
    
    /**
     * Función que genera el excel en la dirección espeficada
     *
     * @param string $dir dirección donde se generará el archivo
     * @param PDO $c conexión a la base de datos de crédito solidario
     * @return void
     */
    function generarExcel($dir, $c){
        
        if(!is_dir($dir)){
            mkdir($dir, 0755);
        }
        
        $archivo = new PHPExcel();
        $archivo->getProperties()
            ->setCreator("Credito Solidario")
            ->setTitle("COLOCACION")
            ->setSubject("COLOCACION DE CREDITOS")
            ->setKeywords("colocacion creditos ifi fondo")
            ->setCategory("Colocacion de datos");
        
        $letters = range('A', 'Z');
        
        $cols = array(
            'No', 'Departamento', 'Municipio', 'Ciudad', 'Nombre', 'Primer Nombre', 'Segundo Nombre', 
            'Primer Apellido', 'Segundo Apellido', 'Identidad', 'Lugar de Nacimiento', 'Fecha de Nacimiento', 'Edad', 
            'Estado Civil', 'Sexo', 'Nivel Educativo', 'Profesión', 'Tipo de Persona', 
            'Número de Dependientes', 'Dirección de Domicilio', 'Telefono', 'Grupo Solidario',
            'Sector Económico', 'Actividad Económica', 'Direccion del Negocio', 'Fecha de Solicitud',
            'Monto Autorizado',/*Z*/ 'Plazo', 'Valor del Ahorro', 'Tasa', 'Fecha de Autorización', 'Forma de pago',
            'Prestamo No', 'Nombre del Gestor', 'Nombre Supervisor', 'Nombre Coordinador',
            'Tipo de Cliente', 'IFI', 'Ciclo', 'Fecha de Procesamiento', 'Estatus Prestamo', 'Observaciones',
            'ID Crédito', 'ID Grupo Solidario', 'ID Documento', 'Programa', 'Fondo', 'Nombre Ref1', 'Telefono Ref1',
            'Direccion Ref1', 'Parentesco Ref1', 'Nombre Ref2', 'Telefono Ref2', 'Direccion Ref2', 'Parentesco Ref2',
            'Nombre Ref3', 'Telefono Ref3', 'Direccion Ref3', 'Parentesco Ref3', 'Nombre Ref4', 'Telefono Ref4',
            'Direccion Ref4', 'Parentesco Ref4'
         );
        
        $databasecols = array(
            'No', 'Departamento', 'Municipio', 'Ciudad', 'Nombre', 'PrimerNombre', 'SegundoNombre', 
            'PrimerApellido', 'SegundoApellido', 'Identidad', 'Lugar_Nacimiento', 'Fecha_Nacimiento', 'Edad', 
            'Estado_Civil', 'Sexo', 'Nivel_Educativo', 'Profesion', 'Tipo_de_Persona', 
            'Dependientes', 'Direccion_Domicilio', 'Telefono', 'Grupo_Solidario',
            'Sector_Económico', 'Actividad_Económica', 'Direccion_Negocio', 'Fecha_Solicitud',
            'Monto_Autorizado',/*Z*/ 'Plazo', 'Valor_del_Ahorro', 'Tasa', 'Fecha_Autorizacion', 'Forma_de_pago',
            'Prestamo_Numero', 'Gestor', 'Supervisor', 'Coordinador',
            'Tipo_Cliente', 'IFI', 'Ciclo', 'Fecha_Log', 'Estatus_Prestamo', 'Observaciones',
            'id', 'grupo_solidario_hash', 'documento', 'Programa', 'Fondo', 'Nombre Ref1', 'Telefono Ref1',
            'Direccion Ref1', 'Parentesco Ref1', 'Nombre Ref2', 'Telefono Ref2', 'Direccion Ref2', 'Parentesco Ref2',
            'Nombre Ref3', 'Telefono Ref3', 'Direccion Ref3', 'Parentesco Ref3', 'Nombre Ref4', 'Telefono Ref4',
            'Direccion Ref4', 'Parentesco Ref4'
        );
        
        // Capturamos los datos de la base de datos
        
        $stat = $c->prepare('select "" as No, Departamento, Municipio, if(Ciudad is null, Municipio, Ciudad) as Ciudad, Nombre, PrimerNombre, SegundoNombre, 
        PrimerApellido, SegundoApellido, concat(SUBSTR(Identidad,1,4),"-",SUBSTR(Identidad,5,4),"-",SUBSTR(Identidad,9,5)) as Identidad, Lugar_Nacimiento, DATE_FORMAT(Fecha_Nacimiento,"%d-%m-%Y") as Fecha_Nacimiento, Edad, 
        Estado_Civil, Sexo, Nivel_Educativo, Profesion, Tipo_de_Persona, 
        Dependientes, Direccion_Domicilio, Telefono, Grupo_Solidario,
        `Sector_Económico`, `Actividad_Económica`, Direccion_Negocio, Fecha_Solicitud,
        Monto_Autorizado, Plazo, Valor_del_Ahorro, "12%" as Tasa, Fecha_Autorizacion, Forma_de_pago,
        Prestamo_Numero, Gestor, Supervisor, Coordinador,
        Tipo_Cliente, IFI, Ciclo, Fecha_Log, Estatus_Prestamo, Observaciones,
        id, grupo_solidario_hash, documento, Programa, Fondo, `Nombre Ref1`, `Telefono Ref1`,
        `Direccion Ref1`, `Parentesco Ref1`, `Nombre Ref2`, `Telefono Ref2`, `Direccion Ref2`, `Parentesco Ref2`,
        `Nombre Ref3`, `Telefono Ref3`, `Direccion Ref3`, `Parentesco Ref3`, `Nombre Ref4`, `Telefono Ref4`,
        `Direccion Ref4`, `Parentesco Ref4` from cartera_consolidada 
        where grupo_solidario_hash in ('.'"'.implode('","', $this->groups).'"'.')');
        $stat->execute();
        $data = $stat->fetchAll();
        
        $cantidadletras = count($letters);
        $cant = count($cols);
        
        $row = 2;
        
        error_log('========INICIO========');

        foreach($data as $fila){
            
            $i=0;$k=0;$l=0;
        
            for($j = 0; $j < $cant; $j++){
                if($i >= $cantidadletras){
                    if($k >= $cantidadletras){
                        $l++;$k=0;
                    }

                    $archivo->getActiveSheet()->setCellValue($letters[$l].$letters[$k].$row, $fila[$databasecols[$j]]);
                    $k++;

                }else{

                    // Si la columna actual es edad, entonces la calculamos en base a la fecha de nacimiento
                    if($databasecols[$j] == "Edad"){

                        $date = new DateTime($fila['Fecha_Nacimiento']);
                        $now = new DateTime();
                        $interval = $now->diff($date);

                        $archivo->getActiveSheet()->setCellValue($letters[$i].$row, $interval->format('%y'));
                    }else{
                        $archivo->getActiveSheet()->setCellValue($letters[$i].$row, $fila[$databasecols[$j]]);
                    }
                    $i++;

                }
            }
            
            $row++;
            
        }
        $row--;
        // Hasta aqui ya deberia estar casi completo el archivo, solo faltan los encabezados y el estilo
        
        // Estilo de los headers
        $styleArray = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '1B5E20')
            ),
            'font'  => array(
                'color' => array('rgb' => 'ffffff'),
                'size'  => 13
            )
        );
        
        // Para los headers del archivo
        $i=0;$k=0;$l=0;
        
        for($j = 0; $j < $cant; $j++){
            if($i >= $cantidadletras){
                if($k >= $cantidadletras){
                    $l++;$k=0;
                }
                $archivo->getActiveSheet()->setCellValue($letters[$l].$letters[$k].'1', $cols[$j]);
                $archivo->getActiveSheet()->getColumnDimension($letters[$l].$letters[$k])
                    ->setAutoSize(true);
                // Setting the style while adding headers
                $archivo->getActiveSheet()->getStyle($letters[$l].$letters[$k].'1')->applyFromArray($styleArray);
                $k++;
            }else{
                $archivo->getActiveSheet()->setCellValue($letters[$i].'1', $cols[$j]);
                // Setting the style while adding headers
                $archivo->getActiveSheet()->getStyle($letters[$i].'1')->applyFromArray($styleArray);
                $archivo->getActiveSheet()->getColumnDimension($letters[$i])
                    ->setAutoSize(true);
                $i++;
            }
        }
        
        // Estilizando el archivo
        $aux = 1;
        while($row > $aux){
            $archivo->getActiveSheet()->setCellValue('A'.($aux + 1), $aux);
            $archivo->getActiveSheet()->getStyle('J'.($aux + 1))->getNumberFormat()->setFormatCode('0000000000000');
            $aux++;
        }
        
        $archivo->getDefaultStyle()->getFont()
            ->setName('Calibri')
            ->setSize(12);
        
        $excelwriter = PHPExcel_IOFactory::createWriter($archivo, 'Excel5');
        
        try{
            $excelwriter->save($dir.$this->name.'.xls');
            // echo "Generado con exito";
        }catch(PHPExcel_Writer_Exception $e){
            // echo "Error, excepcion capturada";
        }
        
    }
    
    /**
     * Guarda el archivo en el registro de documentos de la base de datos
     *
     * @param PDO $c conexión a la base de datos de crédito solidario
     * @return void
     */
    function saveToDatabase($c){ // Param: the conection
        
        $stat = $c->prepare('insert into registro_documentos(nombre_documento, departamento, usuario) values(:nombre, :departamento, :usuario)');
        $stat->bindValue(':nombre', $this->name.'.xls', PDO::PARAM_STR);
        $stat->bindValue(':departamento', 'Colocación', PDO::PARAM_STR);
        $stat->bindValue(':usuario', $this->user, PDO::PARAM_STR);
        return $stat->execute();
        
    }
    
}

?>