<?php

require 'conection.php';
require 'PHPExcel.php';

$archivo = new PHPExcel();

$archivo->getProperties()
    ->setCreator('Credito Solidario')
    ->setTitle('Cartera Activa');

$stat = $conn->prepare('select b.nombre,departamento, get_agencia(gestor,agencia) as agencia, Identidad, Nombre_Completo, a.Numero_Prestamo, Direccion, Telefono, Negocio, Actividad_Economica, gestor, get_supervisor(gestor) as supervisor, a.Fecha_Desembolso, a.Monto_Desembolsado, a.saldo_capital,fecha_ultimo_pago, ultimo_pago, d.Mora15, d.Mora30, d.Mora60, d.Mora90, d.Mora120, d.Mora120mas, interes_mora, otros_gastos, if(capital_mora>0,capital_mora,0) + interes_mora + otros_gastos as total_pago_pendiente, DATEDIFF(current_date,if(fecha_ultimo_pago is null,a.Fecha_Desembolso,fecha_ultimo_pago)) as dias_sin_pagar, cuotas_vencidas, a.capital_pagado, interes_pagado, total_pagado, c.nombre 
from prestamo a, ifi b, programa c, mora_antiguedad d
where a.Estado_Credito = "desembolsado" and a.Ifi = b.id and if(a.programa is null,"P01",a.programa) = c.id and a.Numero_Prestamo = d.Numero_Prestamo');

if($stat->execute()){

    $result = $stat->fetchAll(PDO::FETCH_ASSOC);

    $i=0;
    $j=1;
    foreach($result[0] as $header => $value){

        $archivo->getActiveSheet()->setCellValueByColumnAndRow($i, $j, $header);
        $i++;
    
    }

    foreach($result as $array){

        $i=0;
        foreach($array as $header => $fila){
            $archivo->getActiveSheet()->setCellValueByColumnAndRow($i, $j, $fila);
            $i++;
        }
        $j++;

    }

    $date = new DateTime();
    
    $nombre_archivo = 'CARTERAS_'.$date->format('d-m-Y');
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($archivo, 'Excel2007');
    $objWriter->save('php://output');

}

$date = new DateTime();

$nombre_archivo = 'CARTERAS_'.$date->format('d-m-Y');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($archivo, 'Excel2007');
$objWriter->save('php://output');

?>