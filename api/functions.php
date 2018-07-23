<?php

/**
 * Archivo de funciones para la API
 * 
 * Los archivos del api deben hacer un require de estas funciones.
 * @author Rychiv4
 */

function success200(){
    // Estado correctos
    echo '200';
}

function error400(){
    // Datos incorrectos
    echo '400';
}

function error401(){
    // Logueado con error
    echo '401';
}

function error404(){
    // Credito no encontrado
    echo '404';
}

function error500(){
    // error en el codigo o algo más
    echo '500';
}

/**
 * FUNCION
 * parametrosCorrectos(<array POST>, <nombre del archivo de api>)
 * 
 * Función para verificar si se han recibido los 
 * parametros correctos en el archivo
 * 
 * retorna true o false
 */

function parametrosCorrectos($post, $file){

    // verifica que los parametros sean correctos para cada tipo de operación de la api
    if($file == 'send'){

        if(isset($post['tipo'])){
            // si no existe masivo o viene falso, asignamos false al valor
            if(!isset($post['masivo'])) $post['masivo'] = false;
            if($post['tipo'] == 'reportar_desembolso'){
                if(isset($post['user'])
                && isset($post['password'])
                && ($post['masivo'] ? true : isset($post['id_credito'])) // si es masivo, no requerimos id_credito, si no entonces si
                && ($post['masivo'] ? true : isset($post['num_prestamo'])) // si es masivo, no requerimos num_prestamo, si no entonces si
                && ($post['masivo'] ? true : isset($post['fecha'])) // si es masivo, no requerimos id_credito, si no entonces si
                && ($post['masivo'] ? true : isset($post['monto'])) // si es masivo, no requerimos id_credito, si no entonces si
                && isset($post['tipo'])
                && ($post['masivo'] ? isset($post['data']) : true)){ // si masivo es true, requerimos data sino retornamos true
                    return true;
                }else{
                    return false;
                }
            }else if($post['tipo'] == 'reportar_pago'){
                if(isset($post['user'])
                && isset($post['password'])
                && isset($post['num_prestamo'])
                && isset($post['fecha'])
                && isset($post['capital'])
                && isset($post['interes'])
                && isset($post['mora'])
                && isset($post['tipo'])){
                    return true;
                }else{
                    return false;
                }
            }else if($post['tipo'] == 'confirmar_colocacion'){
                if(isset($post['user'])
                && isset($post['password'])
                && ($post['masivo'] ? true : isset($post['id_credito'])) // si es masivo, no requerimos id_credito, si no entonces si
                && ($post['masivo'] ? isset($post['data']) : true)){ // si masivo es true, requerimos data sino retornamos true
                    return true;
                }else{
                    return false;
                }
            }else if($post['tipo'] == 'reportar_convocar'){
                if(isset($post['user'])
                && isset($post['password'])
                && ($post['masivo'] ? true : isset($post['id_credito'])) // si es masivo, no requerimos id_credito, si no entonces si
                && ($post['masivo'] ? isset($post['data']) : true)){ // si masivo es true, requerimos data sino retornamos true
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }

    }else if($file == 'get'){
        if(isset($post['tipo'])){
            if($post['tipo'] == 'colocaciones_pendientes'){
                if(isset($post['user'])
                && isset($post['password'])
                && isset($post['tipo'])){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }

    }
    
}

/**
 * FUNCION
 * usuarioAutenticado(<array POST>, <instancia pdo de conexión>)
 * 
 * Función para verificar si el usuario es auténtico
 * 
 * retorna true o false
 */

function usuarioAutenticado($post, $conn){

    $stat = $conn->prepare('select password, ifi from apiusers 
                            where usuario = :usuario and activo = "1"');
    $stat->bindValue(':usuario', $post['user'], PDO::PARAM_STR);
    $stat->execute();

    $result = $stat->fetchAll(PDO::FETCH_ASSOC);

    if(count($result) > 0){
        $post['ifi'] = $result[0]['ifi'];
        return password_verify($post['password'], password_hash($result[0]['password'], PASSWORD_DEFAULT));
    }else{
        return false;
    }
    
}

/**
 * FUNCION 
 * reportarDesembolso(<array POST>, <instancia pdo de conexión>)
 * 
 * Función para reportar un desembolso
 * 
 * retorna true o false
 */

function reportarDesembolso($post, $conn){
    /*
    object struct:

    obj = {
        user:
        password:
        id_credito:
        num_prestamo:
        fecha:
        monto:
        tipo:
    }
    */

    if(!$post['masivo']){
        reportarDesembolsoIndividual($post, $conn);    
    }else{
        foreach($post['data'] as $credito){
            reportarDesembolsoIndividual($credito, $conn);
        }
    }

}

/**
 * FUNCION PRINCIPAL
 * reportarPago(<array POST>, <instancia pdo de conexión>)
 * 
 * Función para reportar un pago
 * 
 * retorna true o false
 */

function reportarPago($post, $conn){
    /*
    object struct:

    obj = {
        user:
        password:
        num_prestamo:
        fecha:
        monto:
        capital:
        interes:
        mora:
        tipo:
    }
    */
    $stat = $conn->prepare('select api_registrar_pago(:saldo_capital, :interes, :interes_mora, :prestamo, :fecha)');
    $stat->bindValue(':saldo_capital', $post['capital'], PDO::PARAM_STR);
    $stat->bindValue(':interes', $post['interes'], PDO::PARAM_STR);
    $stat->bindValue(':interes_mora', $post['mora'], PDO::PARAM_STR);
    $stat->bindValue(':prestamo', $post['num_prestamo'], PDO::PARAM_STR);
    $stat->bindValue(':fecha', $post['fecha'], PDO::PARAM_STR);
    return $stat->execute();
}

/**
 * FUNCION PRINCIPAL
 * enviarColocaciones(<array POST>, <instancia pdo de conexión>)
 * 
 * Función para enviar al navegador las colocaciones
 * 
 * retorna un json con la información
 */

function enviarColocaciones($post, $conn){

    $stat = $conn->prepare('select ifi from apiusers where usuario = :user');
    $stat->bindValue(':user', $post['user'], PDO::PARAM_STR);
    $stat->execute();
    $result = $stat->fetch(PDO::FETCH_ASSOC);

    $select = $conn->prepare('select "" as No, Departamento, Municipio, Ciudad, Nombre, PrimerNombre, SegundoNombre, 
    PrimerApellido, SegundoApellido, concat(SUBSTR(Identidad,1,4),"-",SUBSTR(Identidad,5,4),"-",SUBSTR(Identidad,9,5)) as Identidad, Lugar_Nacimiento, DATE_FORMAT(Fecha_Nacimiento,"%d-%m-%Y") as Fecha_Nacimiento, Edad, 
    Estado_Civil, Sexo, Nivel_Educativo, Profesion, Tipo_de_Persona, 
    Dependientes, Direccion_Domicilio, Telefono, Grupo_Solidario,
    `Sector_Económico`, `Actividad_Económica`, Direccion_Negocio, Fecha_Solicitud,
    Monto_Autorizado, Plazo, Valor_del_Ahorro, Tasa, Fecha_Autorizacion, Forma_de_pago,
    Prestamo_Numero, Gestor, Supervisor, Coordinador,
    Tipo_Cliente, IFI, Ciclo, Fecha_Log, Estatus_Prestamo, Observaciones,
    id, grupo_solidario_hash, documento, Programa, Fondo, `Nombre Ref1`, `Telefono Ref1`,
    `Direccion Ref1`, `Parentesco Ref1`, `Nombre Ref2`, `Telefono Ref2`, `Direccion Ref2`, `Parentesco Ref2`,
    `Nombre Ref3`, `Telefono Ref3`, `Direccion Ref3`, `Parentesco Ref3`, `Nombre Ref4`, `Telefono Ref4`,
    `Direccion Ref4`, `Parentesco Ref4` from cartera_consolidada_online 
    where ifi = :ifi and Estatus_Prestamo = "Colocado"');
    $select->bindValue(':ifi', $result['ifi']);
    $select->execute();
    $all = $select->fetchAll(PDO::FETCH_ASSOC);

    return json_encode($all);
    
}

/**
 * FUNCION
 * reportarDesembolsoIndividual(<array POST>, <instancia pdo de conexion>)
 * 
 * Función para reportar desembolso individual
 */

function reportarDesembolsoIndividual($post, $conn){

    /**
     * Si la ifi que realiza la solicitud es Credito Solidario, 
     * Cooperativa Mixta Lempira o Vendedores del Sur
     * se actualiza solamente cartera consolidada,
     * de lo contrario se ejecuta naturalmente
     */

    if(in_array($post['ifi'], ['0','11','15'])){

        $stat = $conn->prepare('update credito_solidario.cartera_consolidada 
                                set Fecha_Desembolso = :fecha, Monto_Otorgado = :monto, Estatus_Prestamo = "Desembolsado"
                                where a.Numero_Prestamo = :prestamo and b.id = :idCredito;');
        $stat->bindValue(':fecha', $post['fecha'], PDO::PARAM_STR);
        $stat->bindValue(':monto', $post['monto'], PDO::PARAM_STR);
        $stat->bindValue(':prestamo', $post['num_prestamo'], PDO::PARAM_STR);
        $stat->bindValue(':idCredito', $post['id_credito'], PDO::PARAM_STR);           
        return $stat->execute();

    }else{

        $stat = $conn->prepare('insert into prestamo (numero_prestamo, fecha_desembolso, monto_desembolsado, estado_credito)
                                values (:prestamo, :fecha, :monto, "Desembolsado")');
        $stat->bindValue(':prestamo', $post['num_prestamo'], PDO::PARAM_STR);
        $stat->bindValue(':fecha', $post['fecha'], PDO::PARAM_STR);
        $stat->bindValue(':monto', $post['monto'], PDO::PARAM_STR);
        $stat->execute();

        $stat = $conn->prepare('update credito_solidario.prestamo a, credito_solidario.cartera_consolidada b
                                set a.fondo = b.Fondo, a.programa = b.Programa, a.Negocio = b.Direccion_Negocio, 
                                b.Estatus_Prestamo = "Desembolsado", a.Agencia = get_agencia(b.gestor, b.agencia), a.Ciclo = b.Ciclo, 
                                a.IFI = b.Ifi, a.Telefono = b.Telefono, a.Direccion = b.Direccion_Domicilio, a.Grupo_Solidario = b.Grupo_Solidario,
                                a.Departamento = b.Departamento, a.Municipio = b.Municipio, a.Actividad_Economica = b.`Actividad_Económica`
                                where a.Numero_Prestamo = :prestamo and b.id = :idCredito;');
        $stat->bindValue(':prestamo', $post['num_prestamo'], PDO::PARAM_STR);
        $stat->bindValue(':idCredito', $post['id_credito'], PDO::PARAM_STR);
        return $stat->execute();

    }
        
    
}

/**
 * FUNCION
 * confirmarColocacion(<array POST>, <instancia pdo de conexion>)
 * 
 * Función para confirmar que se ha recibido la información
 * del crédito
 */

function confirmarColocacion($post, $conn){

    if(!$post['masivo']){
        confirmarColocacionIndividual($post, $conn); 
    }else{
        foreach($post['data'] as $credito){
            confirmarColocacionIndividual($credito, $conn);
        }
    }

}

/**
 * FUNCION
 * confirmarColocacionIndividual(<array POST>, <instancia pdo de conexion>)
 * 
 * Función para confirmar que se ha recibido la información
 * del crédito de manera individual
 */

function confirmarColocacionIndividual($post, $conn){

    $stat = $conn->prepare('update credito_solidario.cartera_consolidada 
                            set Estatus_Prestamo = "Colocado"
                            where b.id = :idCredito;');
    $stat->bindValue(':idCredito', $post['id_credito'], PDO::PARAM_STR);           
    return $stat->execute();

}

/**
 * FUNCION
 * reportarConvocar(<array POST>, <instancia pdo de conexion>)
 * 
 * Función para reportar creditos para convocar
 * del crédito
 */

function reportarConvocar($post, $conn){

    if(!$post['masivo']){
        reportarConvocarIndividual($post, $conn); 
    }else{
        foreach($post['data'] as $credito){
            reportarConvocarIndividual($credito, $conn);
        }
    }

}

/**
 * FUNCION
 * reportarConvocarIndividual(<array POST>, <instanca pdo de conexion>)
 * 
 * Función para reportar a Crédito Solidario que un crédito está listo para 
 * convocar al cliente
 */


function reportarConvocarIndividual($post, $conn){

    $stat = $conn->prepare('update credito_solidario.cartera_consolidada 
                            set Estatus_Prestamo = "Convocar"
                            where b.id = :idCredito;');
    $stat->bindValue(':idCredito', $post['id_credito'], PDO::PARAM_STR);           
    return $stat->execute();

}

?>