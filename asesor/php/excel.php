<?php

require "conexion.php";
require 'PHPExcel.php';

if(isset($_POST['user_id'])){
    
    if($conn){
        
        $stat = $conn->prepare('select b.nombre, a.departamento, get_agencia(a.gestor,a.agencia) as agencia, Identidad, Nombre_Completo, Numero_Prestamo, Direccion, Telefono, Negocio, Actividad_Economica, gestor, get_supervisor(gestor) as supervisor, Fecha_Desembolso, Monto_Desembolsado, saldo_capital,fecha_ultimo_pago, capital_mora, interes_mora, otros_gastos, if(capital_mora>0,capital_mora,0) + interes_mora + otros_gastos as pago_total, DATEDIFF(current_date,if(fecha_ultimo_pago is null,Fecha_Desembolso,fecha_ultimo_pago)) as dias_en_mora, cuotas_vencidas, capital_pagado, interes_pagado, total_pagado, c.nombre as nombre2 from prestamo a, ifi b, programa c, gsc d
where a.Estado_Credito = "desembolsado" and a.Ifi = b.id and if(a.programa is null,"P01",a.programa) = c.id and :id = d.id and d.nombre = a.gestor');
        $stat->bindValue(':id', $_POST['user_id'], PDO::PARAM_STR);
        $stat->execute();

        $data = $stat->fetchAll();
        $hoy = new DateTime();

        $archivo = new PHPExcel();

        //$archivo->getProperties()->setCreator("Ricardo Valladares");

        $archivo->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow('0', '2', 'Fecha: ')
            ->setCellValueByColumnAndRow('1', '2', $hoy->format('d/m/Y'))
            ->setCellValueByColumnAndRow('0', '3', 'Gestor: ')
            ->setCellValueByColumnAndRow('1', '3', $_POST['user_id'])
            ->setCellValueByColumnAndRow('0', '5', 'Ifi')
            ->setCellValueByColumnAndRow('1', '5', 'Departamento')
            ->setCellValueByColumnAndRow('2', '5', 'Agencia')
            ->setCellValueByColumnAndRow('3', '5', 'Identidad')
            ->setCellValueByColumnAndRow('4', '5', 'Nombre Completo')
            ->setCellValueByColumnAndRow('5', '5', 'Numero Prestamo')
            ->setCellValueByColumnAndRow('6', '5', 'Direccion')
            ->setCellValueByColumnAndRow('7', '5', 'Telefono')
            ->setCellValueByColumnAndRow('8', '5', 'Negocio')
            ->setCellValueByColumnAndRow('9', '5', 'Actividad Economica')
            ->setCellValueByColumnAndRow('10', '5', 'Gestor')
            ->setCellValueByColumnAndRow('11', '5', 'Supervisor')
            ->setCellValueByColumnAndRow('12', '5', 'Fecha Desembolso')
            ->setCellValueByColumnAndRow('13', '5', 'Monto Desembolsado')
            ->setCellValueByColumnAndRow('14', '5', 'Negocio')
            ->setCellValueByColumnAndRow('15', '5', 'Saldo Capital')
            ->setCellValueByColumnAndRow('16', '5', 'Fecha de Ultimo Pagos')
            ->setCellValueByColumnAndRow('17', '5', 'Capital Mora')
            ->setCellValueByColumnAndRow('18', '5', 'Interes mora')
            ->setCellValueByColumnAndRow('19', '5', 'Otros Gastos')
            ->setCellValueByColumnAndRow('20', '5', 'Dias en mora')
            ->setCellValueByColumnAndRow('21', '5', 'Pago Total')
            ->setCellValueByColumnAndRow('22', '5', 'Cuotas Vencidas')
            ->setCellValueByColumnAndRow('23', '5', 'Capital Pagado')
            ->setCellValueByColumnAndRow('24', '5', 'Interes Pagado')
            ->setCellValueByColumnAndRow('25', '5', 'Total Pagado');

        $i = 6;
        foreach($data as $fila){

            $archivo->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow('0', $i, $fila['nombre'])
                ->setCellValueByColumnAndRow('1', $i, $fila['departamento'])
                ->setCellValueByColumnAndRow('2', $i, $fila['agencia'])
                ->setCellValueByColumnAndRow('3', $i, $fila['Identidad'])
                ->setCellValueByColumnAndRow('4', $i, $fila['Nombre_Completo'])
                ->setCellValueByColumnAndRow('5', $i, $fila['Numero_Prestamo'])
                ->setCellValueByColumnAndRow('6', $i, $fila['Direccion'])
                ->setCellValueByColumnAndRow('7', $i, $fila['Telefono'])
                ->setCellValueByColumnAndRow('8', $i, $fila['Negocio'])
                ->setCellValueByColumnAndRow('9', $i, $fila['Actividad_Economica'])
                ->setCellValueByColumnAndRow('10', $i, $fila['gestor'])
                ->setCellValueByColumnAndRow('11', $i, $fila['supervisor'])
                ->setCellValueByColumnAndRow('12', $i, $fila['Fecha_Desembolso'])
                ->setCellValueByColumnAndRow('13', $i, $fila['Negocio'])
                ->setCellValueByColumnAndRow('14', $i, $fila['Monto_Desembolsado'])
                ->setCellValueByColumnAndRow('15', $i, $fila['saldo_capital'])
                ->setCellValueByColumnAndRow('16', $i, $fila['fecha_ultimo_pago'])
                ->setCellValueByColumnAndRow('17', $i, $fila['capital_mora'])
                ->setCellValueByColumnAndRow('18', $i, $fila['interes_mora'])
                ->setCellValueByColumnAndRow('19', $i, $fila['otros_gastos'])
                ->setCellValueByColumnAndRow('20', $i, $fila['dias_en_mora'])
                ->setCellValueByColumnAndRow('21', $i, $fila['pago_total'])
                ->setCellValueByColumnAndRow('22', $i, $fila['cuotas_vencidas'])
                ->setCellValueByColumnAndRow('23', $i, $fila['capital_pagado'])
                ->setCellValueByColumnAndRow('24', $i, $fila['interes_pagado'])
                ->setCellValueByColumnAndRow('25', $i, $fila['total_pagado']);
            $i++;

        }

        $archivo->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow('0', $i + 1, 'Registros:')
            ->setCellValueByColumnAndRow('1', $i + 1, $i - 6);

        //Estilo
        $archivo->setActiveSheetIndex(0)->getStyle('A5:Z5')->getFont()->setBold(true);
        $archivo->getActiveSheet()->getStyle('D1:D'.$i)->getNumberFormat()->setFormatCode('0000000000000');
        
        $letters = range('A', 'Z');
        foreach($letters as $letter){
            $archivo->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
        }

        $nombre_archivo = 'CARTERA_'.$_POST['user_id'].'_'.$hoy->format('Y-m-d');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($archivo, 'Excel2007');
        $objWriter->save('php://output');
        //echo "hola";
        
    }else{
        
        echo "No se ha podido conectar con el servidor <br><br>";
        echo "<a href='../dashboard-asesor'>Regresar a cartera</a>";
        
    }
    
    
}else{
    echo "No captura";
}

?>