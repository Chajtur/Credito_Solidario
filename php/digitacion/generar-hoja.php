<?php

if(isset($_POST['codigofaja'])){
    
    try {

        session_start();
        require '../conection.php';
        require '../plugins/pro-excel/pro-excel.class.php';

        $conn->beginTransaction();

        $sql = 'select * from bitacora_fajas where faja = :faja group by grupo_solidario_hash;';
        $stat = $conn->prepare($sql);
        $stat->bindValue(':faja', $_POST['codigofaja'], PDO::PARAM_STR);
        $stat->execute();
        $result = $stat->fetchAll(PDO::FETCH_ASSOC);
        $grupos = array();
        foreach($result as $grupo){
            array_push($grupos, $grupo['grupo_solidario_hash']);
        }        

        $sql = 'select a.nombre, a.grupo_solidario_hash, a.identidad, get_supervisor(a.gestor), 
        b.nombre as nombre_ifi, a.ciclo, a.Lista_archivo as Faja from cartera_consolidada a, ifi b where a.ifi = b.id and 
        grupo_solidario_hash in ("'.implode('", "',$grupos).'") order by b.nombre, a.grupo_solidario_hash';

        $archivo = new ProExcel('hoja_archivo_'.date('d-m-Y'), 'docs', $conn);
        $archivo->query = $sql;
        $archivo->generarExcel();
        $conn->commit();

        // echo json_encode($grupos);
        echo $archivo->ruta;

    }catch(PDOException $e){

        $conn->rollback();
        echo 'false';

    }

}

?>