<?php

/**
 * Este archivo es para generar la cartera diaria y guardarlo en el directorio respectivo
 * comunmente para que los asesores y supervisores tengan acceso a la cartera todos los días
 */

require 'plugins/pro-excel/pro-excel.class.php';

require 'conection.php';

ini_set('memory_limit', '2048M');

$proExcel = new ProExcel('Cartera', '', $conn);
$proExcel->outputEnable = true;
$proExcel->query = '
select a.usuario_digitador, b.nombre as IFI, departamento as Departamento, 
agencia as Agencia, Identidad, Nombre_Completo as Beneficiario, a.Numero_Prestamo, Direccion, 
Telefono, Negocio, Actividad_Economica, gestor as Asesor, get_supervisor(gestor) as Supervisor, 
a.Fecha_Desembolso, a.Monto_Desembolsado, a.saldo_capital as Saldo, fecha_ultimo_pago, ultimo_pago

from prestamo a, ifi b, programa c, mora_antiguedad d
where a.Estado_Credito = "desembolsado" and a.Ifi = b.id 
and if(a.programa is null,"P01",a.programa) = c.id and a.Numero_Prestamo = d.Numero_Prestamo
';

if($proExcel->generarExcel()){
    echo "correcto";
}else{
    echo "error";
}

?>