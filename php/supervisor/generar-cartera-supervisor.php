<?php

if(isset($_GET['supervisor'])){

    require '../plugins/pro-excel/pro-excel.class.php';

    require '../conection.php';

    $proExcel = new ProExcel('Cartera_'.$_GET['supervisor'], '', $conn);
    $proExcel->outputEnable = true;
    $proExcel->query = 'select a.Nombre_completo, a.Identidad, a.Ciclo, b.Nombre as IFI,a.Gestor, a.Supervisor, 
a.Direccion, a.Monto_desembolsado, a.Saldo_Capital, a.Fecha_Ultimo_Pago, a.Fecha_Desembolso, 
a.Total_Pago_Pendiente, a.Cuotas_Vencidas, a.Negocio, a.usuario_digitador as Cartera
from prestamo a 
left join ifi b on a.ifi = b.id 
left join gsc d on d.parent = "'.$_GET['supervisor'].'"
where estado_credito = "desembolsado" and a.Gestor = d.nombre';
    $proExcel->generarExcel();
    
}




?>