<?php

if(isset($_POST['grupos'], $_POST['ifi'])){
    
    try {

        $grupos = json_decode($_POST['grupos']);

        session_start();
        require '../conection.php';
        require '../plugins/pro-excel/pro-excel.class.php';

        $conn->beginTransaction();

        $sql = 'select generar_lista_archivo(:ifi) as codigo_lista;';
        $stat = $conn->prepare($sql);
        $stat->bindValue(':ifi', $_POST['ifi'], PDO::PARAM_STR);
        $stat->execute();
        $result = $stat->fetch(PDO::FETCH_ASSOC);

        $sql = 'update cartera_consolidada set Lista_archivo = :lista 
        where grupo_solidario_hash in ("'.implode('", "',$grupos).'")';
        $stat = $conn->prepare($sql);
        $stat->bindValue(':lista', $result['codigo_lista'], PDO::PARAM_STR);
        $stat->execute();

        $sql = 'insert into listas_archivo(lista, ifi) values(:lista, :ifi)';
        $stat = $conn->prepare($sql);
        $stat->bindValue(':lista', $result['codigo_lista'], PDO::PARAM_STR);
        $stat->bindValue(':ifi', $_POST['ifi'], PDO::PARAM_STR);
        $stat->execute();

        $sql = 'select insertar_bitacora_fajas(:user, :faja, :hash);';
        $stat = $conn->prepare($sql);

        foreach($grupos as $grupo){
            
            $stat->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
            $stat->bindValue(':faja', $result['codigo_lista'], PDO::PARAM_STR);
            $stat->bindValue(':hash', $grupo, PDO::PARAM_STR);
            $stat->execute();
        }        

        $sql = 'select a.nombre, a.grupo_solidario_hash, a.identidad, get_supervisor(a.gestor), 
        b.nombre as nombre_ifi, a.ciclo, a.Lista_archivo as Faja from cartera_consolidada a, ifi b where a.ifi = b.id and 
        grupo_solidario_hash in ("'.implode('", "',$grupos).'") order by b.nombre, a.grupo_solidario_hash';

        $archivo = new ProExcel('hoja_archivo_'.date('d-m-Y'), 'docs', $conn);
        $archivo->query = $sql;
        $archivo->generarExcel();
        $returns = array(
            'ruta' => $archivo->ruta,
            'codigo_faja' => $result['codigo_lista']
        );
        $conn->commit();

        echo json_encode($returns);

    }catch(PDOException $e){

        $conn->rollback();
        echo 'false';

    }
    

}

?>