<?php

try{
    
    require_once 'conection.php';
    require 'PHPExcel.php';

    $sql = $conn->prepare('call obtener_cartera_completa()');
    $sql->execute();
    $archivo = new PHPExcel();

    $archivo->getProperties()
        ->setCreator('Credito Solidario')
        ->setTitle('Reporte Gerencial');
    
    if($datos = $sql->fetchAll()){

        // Inicio de la Hoja -->>

        agregarEncabezados($archivo); // <- agrega encabezados a la hoja activa del archivo dado
        $cantidad = agregarDatos($archivo, $datos); // <- devuelve cantidad de datos ingresados
        $letters = formatearColumnas($archivo, $cantidad); // <- devuelve arreglo de columnas     
        agregarFormulas($archivo, $cantidad, $letters); // <- agregando formulas a la hoja activa
        darEstilo($archivo, $cantidad); // <- darle estilo a la hoja activa
        $archivo->getActiveSheet()->setTitle('CARTERA COMPLETA'); //<-asignarle nombre a la hoja activa
        
        // Fin de la Hoja -->>

    }
    
    // Creando la nueva hoja -------------------
    
    $archivo->createSheet(1);
    $archivo->setActiveSheetIndex(1);
    
    $sql = $conn->prepare('call obtener_cartera_afectada()');
    $sql->execute();

    if($datos = $sql->fetchAll()){
        
        // Inicio de la Hoja -->>
        
        agregarEncabezados($archivo); // <- agrega encabezados a la hoja activa del archivo dado
        $cantidad = agregarDatos($archivo, $datos); // <- devuelve cantidad de datos ingresados
        $letters = formatearColumnas($archivo, $cantidad); // <- devuelve arreglo de columnas     
        agregarFormulas($archivo, $cantidad, $letters); // <- agregando formulas a la hoja activa
        darEstilo($archivo, $cantidad); // <- darle estilo a la hoja activa
        $archivo->getActiveSheet()->setTitle('CARTERA AFECTADA'); //<-asignarle nombre a la hoja activa
        
        // Fin de la Hoja -->>

    }
    
    /*$date = new DateTime();
        
    $nombre_archivo = 'CARTERAS_'.$date->format('d-m-Y');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($archivo, 'Excel2007');
    $objWriter->save('php://output');*/
    
}catch(PDOException $e){
    
    echo $e->getMessage();
    
}


// ========= //
// FUNCIONES //
// ========= //


// Función para agregar headers al excel ---------------------

function agregarEncabezados($excel){
    
    // Combinando celdas -------------------
    
    $excel->getActiveSheet()
        ->mergeCells('A1:J1')
        ->mergeCells('K1:Q1')
        ->mergeCells('R1:X1')
        ->mergeCells('Y1:AE1')
        ->mergeCells('AF1:AL1')
        ->mergeCells('AM1:AS1');

    // Centrando todo en la hoja -------------------

    $style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

    $excel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);

    // Headers de la tabla ------------------

    $excel->getActiveSheet()
        ->setCellValueByColumnAndRow('0', '1', 'Resumen General')
        ->setCellValueByColumnAndRow('10', '1', 'Mora de 1 a 15 Días')
        ->setCellValueByColumnAndRow('17', '1', 'Mora de 16 a 30 Días')
        ->setCellValueByColumnAndRow('24', '1', 'Mora de 31 a 60 Días')
        ->setCellValueByColumnAndRow('31', '1', 'Mora de 61 a 120 Días')
        ->setCellValueByColumnAndRow('38', '1', 'Arriba de 120 Días')
        ->setCellValueByColumnAndRow('0', '2', 'Departamento')
        ->setCellValueByColumnAndRow('1', '2', 'Créditos')
        ->setCellValueByColumnAndRow('2', '2', 'Morosos')
        ->setCellValueByColumnAndRow('3', '2', 'Desembolsado')
        ->setCellValueByColumnAndRow('4', '2', 'Saldo')
        ->setCellValueByColumnAndRow('5', '2', 'Capital en Mora')
        ->setCellValueByColumnAndRow('6', '2', 'Interés en Mora')
        ->setCellValueByColumnAndRow('7', '2', 'Total Mora')
        ->setCellValueByColumnAndRow('8', '2', 'Indicador de Mora')
        ->setCellValueByColumnAndRow('9', '2', '% que Representa');

    $j=9;
    for($i = 0; $i < 5; $i++){
        $excel->getActiveSheet()
            ->setCellValueByColumnAndRow($j+=1, '2', 'Créditos Morosos')
            ->setCellValueByColumnAndRow($j+=1, '2', 'Saldo')
            ->setCellValueByColumnAndRow($j+=1, '2', 'Capital en Mora')
            ->setCellValueByColumnAndRow($j+=1, '2', 'Interes en mora')
            ->setCellValueByColumnAndRow($j+=1, '2', 'Total Mora')
            ->setCellValueByColumnAndRow($j+=1, '2', 'Indicador de Mora')
            ->setCellValueByColumnAndRow($j+=1, '2', '% que Representa');
    }
    
}

// Función para agregar datos a la hoja activa //

function agregarDatos($excel, $data){
    
    // Agregando dinamicamente datos al archivo excel ------------------
    
    $i=3;
    foreach($data as $fila){

        $excel->getActiveSheet()
            ->setCellValueByColumnAndRow('0', $i, $fila[0])
            ->setCellValueByColumnAndRow('1', $i, $fila[1])
            ->setCellValueByColumnAndRow('2', $i, $fila[2])
            ->setCellValueByColumnAndRow('3', $i, $fila[3])
            ->setCellValueByColumnAndRow('4', $i, $fila[4])
            ->setCellValueByColumnAndRow('5', $i, $fila[5])
            ->setCellValueByColumnAndRow('6', $i, $fila[6])
            ->setCellValueByColumnAndRow('7', $i, $fila[7])
            ->setCellValueByColumnAndRow('8', $i, $fila[8])
            ->setCellValueByColumnAndRow('9', $i, $fila[9]);

        $j=9;
        for($k = 0; $k < 5; $k++){
            $excel->getActiveSheet()
                ->setCellValueByColumnAndRow($j+=1, $i, $fila[$j])
                ->setCellValueByColumnAndRow($j+=1, $i, $fila[$j])
                ->setCellValueByColumnAndRow($j+=1, $i, $fila[$j])
                ->setCellValueByColumnAndRow($j+=1, $i, $fila[$j])
                ->setCellValueByColumnAndRow($j+=1, $i, $fila[$j])
                ->setCellValueByColumnAndRow($j+=1, $i, $fila[$j])
                ->setCellValueByColumnAndRow($j+=1, $i, $fila[$j]);
        }
        $i++;
        $cantidad = $i;

    }
    
    return $cantidad;
    
}

// Función para formatear columnas a la hoja activa

function formatearColumnas($excel, $cant){
    
    $arreglo_letras = range('A', 'Z');

    foreach($arreglo_letras as $letter){
        $excel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
    }

    $counter = sizeof($arreglo_letras);
    $ciclos = count($arreglo_letras);

    // Formateando autosize todas las columnas

    for($i = 0; $i < $ciclos; $i++){

        for($j = 0; $j < $ciclos; $j++){

            $excel->getActiveSheet()->getColumnDimension($arreglo_letras[$i].$arreglo_letras[$j])->setAutoSize(true);
            $counter++;

            array_push($arreglo_letras, $arreglo_letras[$i].$arreglo_letras[$j]); // Usado para agregar el resto de formulas

            if($cant >= $counter) break;

        }

    }
    
    return $arreglo_letras;
}

// Función para agregar formulas a la hoja activa

function agregarFormulas($excel, $cant, $letras){
    
    // Agregando las primeras formulas al final de cada columna -----------------
    
    $excel->getActiveSheet()
        ->setCellValueByColumnAndRow('0', $cant, 'Total')
        ->setCellValueByColumnAndRow('1', $cant, '=SUM(B3:B'.($cant - 1).')')
        ->setCellValueByColumnAndRow('2', $cant, '=SUM(C3:C'.($cant - 1).')')
        ->setCellValueByColumnAndRow('3', $cant, '=SUM(D3:D'.($cant - 1).')')
        ->setCellValueByColumnAndRow('4', $cant, '=SUM(E3:E'.($cant - 1).')')
        ->setCellValueByColumnAndRow('5', $cant, '=SUM(F3:F'.($cant - 1).')')
        ->setCellValueByColumnAndRow('6', $cant, '=SUM(G3:G'.($cant - 1).')')
        ->setCellValueByColumnAndRow('7', $cant, '=SUM(H3:H'.($cant - 1).')')
        ->setCellValueByColumnAndRow('8', $cant, '=F'.$cant.'/E'.$cant)
        ->setCellValueByColumnAndRow('9', $cant, '=SUM(J3:J'.($cant - 1).')');

    // Agregando el resto de formulas ----------------

    $j=9;
    for($i = 0; $i < 5; $i++){
        $excel->getActiveSheet()
            ->setCellValueByColumnAndRow($j+=1, $cant, '=SUM('.$letras[$j].'3:'.$letras[$j].($cant - 1).')')
            ->setCellValueByColumnAndRow($j+=1, $cant, '=SUM('.$letras[$j].'3:'.$letras[$j].($cant - 1).')')
            ->setCellValueByColumnAndRow($j+=1, $cant, '=SUM('.$letras[$j].'3:'.$letras[$j].($cant - 1).')')
            ->setCellValueByColumnAndRow($j+=1, $cant, '=SUM('.$letras[$j].'3:'.$letras[$j].($cant - 1).')')
            ->setCellValueByColumnAndRow($j+=1, $cant, '=SUM('.$letras[$j].'3:'.$letras[$j].($cant - 1).')')
            ->setCellValueByColumnAndRow($j+=1, $cant, '='.$letras[$j - 3].$cant.'/'.$letras[$j - 4].$cant)
            ->setCellValueByColumnAndRow($j+=1, $cant, '=SUM('.$letras[$j].'3:'.$letras[$j].($cant - 1).')');
    }
}

// Función para dar estilo a la hoja activa

function darEstilo($excel, $cant){
    
    // Dando estilo a las celdas ---------------------
        
    $celdas = [
        'A1:J1', 'K1:Q1', 'R1:X1', 'Y1:AE1', 'AF1:AL1', 'AM1:AS1', 'A2:AS2', 'A'.$cant.':AS'.$cant,
        'A1:J'.$cant, 'K1:Q'.$cant, 'R1:X'.$cant, 'Y1:AE'.$cant, 'AF1:AL'.$cant, 'AM1:AS'.$cant
    ];

    $borderstyle = array(
        'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
            )
        )
    );

    foreach($celdas as $celda){
        $excel->getActiveSheet()->getStyle($celda)->applyFromArray($borderstyle);
    }
    
}

?>