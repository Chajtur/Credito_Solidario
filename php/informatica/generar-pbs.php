<?php

if(isset($_POST['data'])){

    try{

        session_start();
        
        require '../conection.php';
        require '../plugins/excel-reporter/excel-reporter.php';

        $stat_pbs = $conn->prepare('select ifi, departamento, ciclo, fondo, date_format(fecha_log, "%Y-%m-%d") as fecha_log from cartera_consolidada where documento = :documento limit 1');
        $stat_pbs->bindValue(':documento', $_POST['data'], PDO::PARAM_STR);
        $stat_pbs->execute();
        $result = $stat_pbs->fetch(PDO::FETCH_ASSOC);
        $departamento = $result['departamento'];
        $ifi_id = $result['ifi'];
        $ciclo = $result['ciclo'];
        $fondo = $result['fondo'];
        $fecha = $result['fecha_log'];

        $stat_datos = $conn->prepare('select sum(Monto_Autorizado) as monto_total, count(*) as cantidadcreditos from cartera_consolidada where documento = :documento');
        $stat_datos->bindValue(':documento', $_POST['data'], PDO::PARAM_STR);
        $stat_datos->execute();
        $stat_datos_result = $stat_datos->fetch(PDO::FETCH_ASSOC);

        // Obtenemos la abreviación de IFI para el nombre del archivo
        $stat_ifi = $conn->prepare('select abreviacion from ifi where id = :id');
        $stat_ifi->bindValue(':id', $ifi_id, PDO::PARAM_STR);
        $stat_ifi->execute();
        $ifi = $stat_ifi->fetch(PDO::FETCH_ASSOC);

        $stat_grupos = $conn->prepare('select grupo_solidario_hash from cartera_consolidada where documento = :documento');
        $stat_grupos->bindValue(':documento', $_POST['data'], PDO::PARAM_STR);
        $stat_grupos->execute();
        $stat_grupos_result = $stat_grupos->fetchAll(PDO::FETCH_ASSOC);

        $grupos = array();

        foreach($stat_grupos_result as $row){
            array_push($grupos, $row['grupo_solidario_hash']);
        }

        $nombre_archivo = quitar_tildes($departamento).'_'.$_POST['data'].'_'.$stat_datos_result['cantidadcreditos'].'_CREDITOS_CICLO_'.$ciclo.'_'.$ifi['abreviacion'].'_'.$fondo.'_'.$fecha.'_MONTO_TOTAL_'.$stat_datos_result['monto_total'];
        $excel = new ExcelReporter($nombre_archivo, $grupos, $_SESSION['user']);
        $excel->saveToDatabase($conn);
        $excel->generarExcel('../../docs/excel/', $conn);
        
        echo $nombre_archivo.'.xls';

    }catch(PDOException $e){

        error_log($e->getMessage());
        echo 'false';

    }
    
}

function quitar_tildes($cadena) {
    $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
    $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    $texto = str_replace($no_permitidas, $permitidas ,$cadena);
    return $texto;
}

?>