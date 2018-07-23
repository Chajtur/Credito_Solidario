<?php

if(isset($_POST['gestor']) && isset($_POST['nombre_grupo']) && isset($_POST['beneficiarios']) && isset($_POST['nombre']) && isset($_POST['ciclo'])){
    
    //print_r($_POST);
    
    // error_log($_POST['gestor']);
    
    try{
        
        require_once "../conection.php";
        
        $stat = $conn->prepare('select a.departamento, a.agencia, a.nombre, Get_Supervisor(a.nombre) as supervisor, Get_Supervisor(Get_Supervisor(a.nombre)) as coordinador
        from gsc a where id = :idgestor');
        $stat->bindValue(':idgestor', $_POST['gestor'], PDO::PARAM_STR);
        
        if($stat->execute()){
            
            $datogestor = $stat->fetch(PDO::FETCH_ASSOC);
            
        
            $hoy = new DateTime();
            
            /*$hashstat = $conn->prepare('select Get_Grupo_Hash(:nombre_grupo, :gestor, :fecha, :municipio, :departamento) as hash');
            $hashstat->bindValue(':nombre_grupo', $_POST['nombre_grupo'], PDO::PARAM_STR);
            $hashstat->bindValue(':gestor', $_POST['gestor'], PDO::PARAM_STR);
            $hashstat->bindValue(':fecha', $hoy->format('Y-m-d'), PDO::PARAM_STR);
            $hashstat->bindValue(':municipio', $datogestor['agencia'], PDO::PARAM_STR);
            $hashstat->bindValue(':departamento', $datogestor['departamento'], PDO::PARAM_STR);*/
            
            //if($hashstat->execute()){
                
            /*$result = $hashstat->fetch(PDO::FETCH_ASSOC);
            $hash = $result['hash'];*/

            $beneficiarios = $_POST['beneficiarios'];
            $nombres = $_POST['nombre'];
            
            session_start();

            foreach($beneficiarios as $index => $identidad){

                $censostat = $conn3->prepare('select * from censo where identidad = :identidad');
                $censostat->bindValue(':identidad', $identidad, PDO::PARAM_STR);

                if($censostat->execute()){

                    $persona = $censostat->fetch(PDO::FETCH_ASSOC);

                    if(!empty($persona)){

                        $nombre = $persona['primerNombre'].' '.$persona['segundoNombre'].' '.$persona['primerApellido'].' '.$persona['segundoApellido'];

                    }else{

                        $arraynombres = explode(' ', $nombres[$index]);

                        $nombre = '';

                        foreach($arraynombres as $nom){

                            $nombre .= $nom.' ';

                        }

                        switch(sizeof($arraynombres)){

                            case 2:
                                $persona['primerNombre'] = $arraynombres[0];
                                $persona['segundoNombre'] = '';
                                $persona['primerApellido'] = $arraynombres[1];
                                $persona['segundoApellido'] = '';
                                break;

                            case 3:
                                $persona['primerNombre'] = $arraynombres[0];
                                $persona['segundoNombre'] = '';
                                $persona['primerApellido'] = $arraynombres[1];
                                $persona['segundoApellido'] = $arraynombres[2];
                                break;

                            case 4:
                                $persona['primerNombre'] = $arraynombres[0];
                                $persona['segundoNombre'] = $arraynombres[1];
                                $persona['primerApellido'] = $arraynombres[2];
                                $persona['segundoApellido'] = $arraynombres[3];
                                break;

                            case 5:
                                $persona['primerNombre'] = $arraynombres[0];
                                $persona['segundoNombre'] = $arraynombres[1].' '.$arraynombres[2];
                                $persona['primerApellido'] = $arraynombres[3];
                                $persona['segundoApellido'] = $arraynombres[4];
                                break;

                            case 6:
                                $persona['primerNombre'] = $arraynombres[0];
                                $persona['segundoNombre'] = $arraynombres[1].' '.$arraynombres[2].' '.$arraynombres[3];
                                $persona['primerApellido'] = $arraynombres[4];
                                $persona['segundoApellido'] = $arraynombres[5];
                                break;

                            case 6:
                                $persona['primerNombre'] = $arraynombres[0];
                                $persona['segundoNombre'] = $arraynombres[1].' '.$arraynombres[2].' '.$arraynombres[3];
                                $persona['primerApellido'] = $arraynombres[4];
                                $persona['segundoApellido'] = $arraynombres[5];
                                break;

                            case 7:
                                $persona['primerNombre'] = $arraynombres[0];
                                $persona['segundoNombre'] = $arraynombres[1].' '.$arraynombres[2].' '.$arraynombres[3];
                                $persona['primerApellido'] = $arraynombres[4].' '.$arraynombres[5];
                                $persona['segundoApellido'] = $arraynombres[6];
                                break;

                        }

                    }

                    $stat = $conn->prepare('insert into cartera_consolidada(Identidad, Nombre, PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, Agencia, Departamento, Estatus_Prestamo, ciclo, fecha_procesamiento, Gestor, Supervisor, grupo_solidario, Sexo, Fecha_Nacimiento, Coordinador) 
                                                                    values(:identidad, :nombre, :primernombre, :segundonombre, :primerapellido, :segundoapellido, :agencia, :departamento, "Call Center", :ciclo, :fecha, :gestor, :supervisor, :gruposolidario, :sexo, :fechanacimiento, :coordinador)');
                    
                    $stat->bindValue(':primernombre', $persona['primerNombre'], PDO::PARAM_STR);
                    $stat->bindValue(':segundonombre', $persona['segundoNombre'], PDO::PARAM_STR);
                    $stat->bindValue(':primerapellido', $persona['primerApellido'], PDO::PARAM_STR);
                    $stat->bindValue(':segundoapellido', $persona['segundoApellido'], PDO::PARAM_STR);
                    $stat->bindValue(':identidad', $identidad, PDO::PARAM_STR);
                    $stat->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                    $stat->bindValue(':agencia', $datogestor['agencia'], PDO::PARAM_STR);
                    $stat->bindValue(':departamento', $datogestor['departamento'], PDO::PARAM_STR);
                    $stat->bindValue(':ciclo', $_POST['ciclo'], PDO::PARAM_STR);
                    $stat->bindValue(':fecha', $hoy->format('Y-m-d'), PDO::PARAM_STR);
                    $stat->bindValue(':gestor', $datogestor['nombre'], PDO::PARAM_STR);
                    $stat->bindValue(':supervisor', $datogestor['supervisor'], PDO::PARAM_STR);
                    $stat->bindValue(':gruposolidario', $_POST['nombre_grupo'], PDO::PARAM_STR);
                    $stat->bindValue(':sexo', ($persona['codigoSexo'] == "1" ? "M" : "F"), PDO::PARAM_STR);
                    $stat->bindValue(':fechanacimiento', $persona['fechaNacimiento'], PDO::PARAM_STR);
                    $stat->bindValue(':coordinador', $datogestor['coordinador'], PDO::PARAM_STR);

                    $stat->execute();
                    
                    $id_credito = $conn->lastInsertId();
                    
                    $stat = $conn->prepare('select conv(conv(max(grupo_solidario_hash),16,10),10,16) as grupo_solidario_hash from cartera_consolidada where identidad = :id and fecha_procesamiento = :fecha');
                    $stat->bindValue(':id', $identidad, PDO::PARAM_STR);
                    $stat->bindValue(':fecha', $hoy->format('Y-m-d'), PDO::PARAM_STR);
                    $stat->execute();
                    
                    $result = $stat->fetch(PDO::FETCH_ASSOC);
                    $hash = $result['grupo_solidario_hash'];
                    
                    $stat = $conn->prepare('insert into bitacora_creditos(id_credito, grupo_hash, razon, observacion, fecha, estado_credito, id_usuario) values (:id_credito, :hash, "Ingreso de credito", "Ingreso de credito", CURRENT_TIMESTAMP(), "Call Center", :user_id)');
                    
                    $stat->bindValue(':id_credito', $id_credito, PDO::PARAM_INT);
                    $stat->bindValue(':hash', $hash, PDO::PARAM_STR);
                                        
                    $stat->bindValue(':user_id', $_SESSION['user'], PDO::PARAM_STR);
                    $stat->execute();
                    
                }else{

                    echo "error 3";
                    // break;

                }

            }

            echo $hash;
                
        }else{
            
            echo "error 1";
            // break;
            
        }
        
    }catch(PDOException $e){
        
        echo $e->getMessage();
        
    }
    
}else{
    
    echo "error";
    
}

?>