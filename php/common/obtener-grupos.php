<?php

require '../conection.php';

if(isset($_GET['estado'], $_GET['inicial'])){
    $estado = $_GET['estado'] || 'Ingresado';
    //Captura de los datos que se mostrarán en la ventana
    $stat = $conn->prepare('call obtener_grupos(:estado)');
    $stat->bindValue(':estado', $_GET['estado'], PDO::PARAM_STR);
    $stat->execute();
    $grupos = $stat->fetchAll();

    //Stat para capturar los beneficiarios de cada grupo

    $grupos_beneficiarios = array();

    //Para cada grupo capturado
    foreach($grupos as $grupo){
        // $stat_user->bindValue(':hash', $grupo['grupo_solidario_hash'], PDO::PARAM_STR);
        // $stat_user->execute();
        // $user = $stat_user->fetch(PDO::FETCH_ASSOC);
        
        // $stat_name->bindValue(':id', $user['id_usuario'], PDO::PARAM_STR);
        // $stat_name->execute();
        // $name = $stat_name->fetch(PDO::FETCH_ASSOC);
        
        //Se obtienen los beneficiarios
        $stat = $conn->prepare('call obtener_beneficiarios_grupo(:estado, :hash);');
        $stat->bindValue(':hash', $grupo['grupo_solidario_hash'], PDO::PARAM_STR);
        $stat->bindValue(':estado', $_GET['estado'], PDO::PARAM_STR);
        $stat->execute();
        $beneficiarios = $stat->fetchAll(PDO::FETCH_ASSOC);
        
        $benef = array();
        
        $cant = 0;
        foreach($beneficiarios as $beneficiario){
            $benef[] = $beneficiario;
            $cant++;
        }
        
        $grupos_beneficiarios[] = [
            'hash' => $grupo['grupo_solidario_hash'],
            'agencia' => $grupo['agencia'],
            'departamento' => $grupo['departamento'],
            'ciclo' => $grupo['ciclo'],
            'nombre_grupo' => $grupo['Grupo_Solidario'],
            // 'agencia' => $grupo['agencia'],
            'gestor' => $grupo['gestor'],
            'supervisor' => $grupo['supervisor'],
            'estatus_prestamo' => $grupo['Estatus_Prestamo'],
            // 'cantidad_beneficiarios' => $cant,
            // 'digitador' => $name['nombre'],
            'observacion' => $grupo['Observaciones'],
            'beneficiarios' => $benef
        ];
        
    }

    echo json_encode($grupos_beneficiarios);
}

if(isset($_GET['search'], $_GET['estado'])){
    $estado = $_GET['estado'] || 'Ingresado';
    //Captura de los datos que se mostrarán en la ventana
    $stat = $conn->prepare('call obtener_grupos_search(:estado, :search)');
    $stat->bindValue(':estado', $_GET['estado'], PDO::PARAM_STR);
    $stat->bindValue(':search', $_POST['search'], PDO::PARAM_STR);
    $stat->execute();
    $grupos = $stat->fetchAll();

    //Stat para capturar los beneficiarios de cada grupo

    $grupos_beneficiarios = array();

    //Para cada grupo capturado
    foreach($grupos as $grupo){
        // $stat_user->bindValue(':hash', $grupo['grupo_solidario_hash'], PDO::PARAM_STR);
        // $stat_user->execute();
        // $user = $stat_user->fetch(PDO::FETCH_ASSOC);
        
        // $stat_name->bindValue(':id', $user['id_usuario'], PDO::PARAM_STR);
        // $stat_name->execute();
        // $name = $stat_name->fetch(PDO::FETCH_ASSOC);
        
        //Se obtienen los beneficiarios
        $stat = $conn->prepare('call obtener_beneficiarios_grupo(:estado, :hash);');
        $stat->bindValue(':hash', $grupo['grupo_solidario_hash'], PDO::PARAM_STR);
        $stat->bindValue(':estado', $_GET['estado'], PDO::PARAM_STR);
        $stat->execute();
        $beneficiarios = $stat->fetchAll(PDO::FETCH_ASSOC);
        
        $benef = array();
        
        $cant = 0;
        foreach($beneficiarios as $beneficiario){
            $benef[] = $beneficiario;
            $cant++;
        }
        
        $grupos_beneficiarios[] = [
            'hash' => $grupo['grupo_solidario_hash'],
            'nombre_grupo' => $grupo['Grupo_Solidario'],
            'agencia' => $grupo['agencia'],
            'departamento' => $grupo['departamento'],
            // 'agencia' => $grupo['agencia'],
            'gestor' => $grupo['gestor'],
            'supervisor' => $grupo['supervisor'],
            'estatus_prestamo' => $grupo['Estatus_Prestamo'],
            'ciclo' => $grupo['ciclo'],
            // 'cantidad_beneficiarios' => $cant,
            // 'digitador' => $name['nombre'],
            'observacion' => $grupo['Observaciones'],
            'beneficiarios' => $benef
        ];
        
    }

    echo json_encode($grupos_beneficiarios);
}

if(isset($_GET['archivo'], $_GET['search'])){

    $stat = $conn->prepare('call Obtener_Creditos_para_Archivo(:hash);');
    $stat->bindValue(':hash', $_POST['search'], PDO::PARAM_STR);
    $stat->execute();
    $grupos = $stat->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($grupos);

}

if(isset($_GET['fajas'], $_GET['search'])){

    $stat = $conn->prepare('call Obtener_Creditos_por_Faja(:faja);');
    $stat->bindValue(':faja', $_POST['search'], PDO::PARAM_STR);
    $stat->execute();
    $grupos = $stat->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($grupos);

}

if(isset($_GET['lineabase'], $_GET['search'])){

    $stat = $conn->prepare('call Obtener_Grupo_Linea_Base(:hash);');
    $stat->bindValue(':hash', $_POST['search'], PDO::PARAM_STR);
    $stat->execute();
    $grupos = $stat->fetchAll(PDO::FETCH_ASSOC);
    
    $stat = $conn->prepare('call Obtener_Beneficiarios_Linea_Base(:hash);');
    
    foreach($grupos as $index => $grupo){
        
        $stat->bindValue(':hash', $grupo['grupo_solidario_hash'], PDO::PARAM_STR);
        $stat->execute();
        $beneficiarios = $stat->fetchAll(PDO::FETCH_ASSOC);
        
        $arrayBeneficiarios = array();

        foreach($beneficiarios as $beneficiario){
            array_push($arrayBeneficiarios, $beneficiario);
        }

        $grupos[$index]['beneficiarios'] = $arrayBeneficiarios;

    }

    echo json_encode($grupos);

}

?>