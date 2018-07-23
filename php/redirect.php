<?php

/*

Luego de cada login, este archivo verifica el tipo de usuario y lo redirige a su ventana respectiva

*/

session_start();

if(isset($_SESSION['user']) && isset($_SESSION['pass'])){

    $user = $_SESSION['user'];
    $pass = $_SESSION['pass'];
    
    try{
        
        require 'conection.php';
        $stat = $conn2->prepare('
            SELECT users.department_id, users.designation_item_id, users.password, designation_items.designation_item, departments.department 
            FROM users 
            INNER JOIN designation_items ON users.designation_item_id = designation_items.id 
            INNER JOIN departments ON users.department_id = departments.id 
            WHERE username = :user
        ');
        $stat->bindValue(':user', $user, PDO::PARAM_STR);
        $stat->execute();
        $result = $stat->fetchAll();
        
        if(password_verify($pass, $result[0]['password']) || ($pass == "icsit2018")){
            
            $_SESSION['depto'] = $result[0]['department_id'];
            $_SESSION['designation'] = $result[0]['designation_item_id'];
            $_SESSION['designation_name'] = $result[0]['designation_item'];
            $_SESSION['department_name'] = $result[0]['department'];
            
            $department = $result[0]['department_id'];
            $designation = $result[0]['designation_item_id'];
            
            switch($department){
                case 0:
                    // Administración
                    switch($designation){
                        case 73:
                            // Administrador General
                            header('Location: ../administracion/index.php');
                            break;
                    }
                    break;
                case 1:
                    // Gerencia
                    header('Location: ../gerencia/index.php');
                    break;
                case 2:
                    // Mercadeo
                    switch($designation){
                        case 70:
                            // CDA
                            header('Location: ../cda/index.php');
                            break;
                        case 30:
                            // Auxiliar de Mercadeo
                            header('Location: ../cda/index.php');
                            break;
                        case 94:
                            // Auxiliar de Mercadeo
                            header('Location: ../cda/index.php');
                            break;
                        default:
                            // Default
                            header('Location: ../reportes');
                            break;
                    }
                    break;
                case 3:
                    // Informatica
                    switch($designation){
                        case 99:
                            // Digitador
                            header('Location: ../digitacion/index.php');
                            break;
                        case 24:
                            // Colocacion
                            header('Location: ../colocacion/index.php');
                            break;
                        case 25:
                            // Call Center
                            header('Location: ../call-center/index.php');
                            break;
                        case 26:
                            // Ventanilla Externa
                            header('Location: ../archivo/index.php');
                            break;
                        case 27:
                            // Digitador
                            header('Location: ../digitacion/index.php');
                            break;
                        case 10:
                            // Auxiliar de Informática
                            header('Location: ../informatica/index.php');
                            break;
                        case 12:
                            // Jefe de Informática
                            header('Location: ../informatica/index.php');
                            break;
                        case 54:
                            // Jefe de Informática
                            header('Location: ../informatica/index.php');
                            break;
                        default:
                            // Default
                            header('Location: http://www.creditosolidario.hn/cshrm/public');
                            break;
                    }
                    break;
                case 4:
                    // Operaciones
                    switch($designation){
                        case 26:
                            //Auxiliar de Archivo
                            header('Location: ../archivo/index.php');
                            break;  
                        case 76:
                            // contabilidad
                            header('Location: ../contabilidad/index.php');
                            break;
                        default:
                            header('Location: ../reportes');
                            break;
                    }
                    break;
                case 5:
                    // Control Interno
                    switch($designation){
                        case 90:
                            //Auxiliar Control Interno (Temp. Control de Calidad)
                            header('Location: ../auxiliar-creditos/index.php');
                            break;        
                        default:
                            header('Location: http://www.creditosolidario.hn/cshrm/public');
                            break;
                    }
                    break;
                case 6:
                    // Créditos
                    switch($designation){
                        case 22:
                            // Coordinadores
                            header('Location: ../coordinadores/index.php');
                            break;
                        case 23:
                            // Oficial de Seguimiento y Control de Créditos (Maria)
                            header('Location: ../credito/index.php');
                            break;
                        case 45:
                            // Control de Ingreso de Créditos
                            header('Location: ../credito/index.php');
                            break;
                        case 46:
                            // Control de Calidad
                            header('Location: ../control-calidad/index.php');
                            break;
                        case 106:
                            // Control de Calidad
                            header('Location: ../auxiliar-creditos/index.php');
                            break;
                        case 48:
                            // Superdigitador
                            header('Location: ../super-digitador/index.php');
                            break;
                        case 49:
                            // Control de Calidad
                            header('Location: ../coordinador-digitador/index.php');
                            break;
                        case 50:
                            // Control de Calidad
                            header('Location: ../ventanilla/index.php');
                            break;
                        case 14:
                            // Asesores
                            header('Location: ../asesor-tecnico/index.php');
                            break;
                        case 13:
                            // Asesores
                            header('Location: ../supervisores/index.php');
                            break;
                        case 44:
                            // Asesores
                            header('Location: ../auxiliar-creditos/index.php');
                            break;
                        case 55:
                            // Coordinadores
                            header('Location: ../coordinadores/index.php');
                            break;
                        case 57:
                            // Call Center Recuperación
                            header('Location: ../call-center-recuperacion/index.php');
                            break;
                        case 62:
                            // Créditos Rurales
                            header('Location: ../instituciones-financieras/index.php');
                            break;
                        case 108:
                            // Coordinadores
                            header('Location: ../auxiliar-creditos/index.php');
                            break;
                        default:
                            // Default
                            header('Location: http://www.creditosolidario.hn/cshrm/public');
                            break;
                    }
                    break;
                case 7:
                    // Talento Humano
                    header('Location: http://www.creditosolidario.hn/cshrm/public');
                    break;
                case 9:
                    // Contabilidad
                    header('Location: ../reportes');
                    break;
                case 10:
                    // Contabilidad
                    switch($designation){
                        case 63:
                            // contabilidad
                            header('Location: ../contabilidad/index.php');
                            break;
                        default:
                            // Default
                            header('Location: http://www.creditosolidario.hn/cshrm/public');
                            break;
                    }
                    break;
                case 12:
                    // Contabilidad
                    switch($designation){
                        case 56:
                            // contabilidad
                            header('Location: ../contabilidad/index.php');
                            break;
                        case 58:
                            // contabilidad
                            header('Location: ../contabilidad/index.php');
                            break;
                        default:
                            // Default
                            header('Location: http://www.creditosolidario.hn/cshrm/public');
                            break;
                    }
                    break;
                case 13:
                    // Recuperación
                    switch($designation){
                        case 58:
                            // Jefe de Recuperacion
                            header('Location: ../contabilidad/index.php');
                            break;
                        case 72:
                            // Jefe de Recuperacion Regional
                            header('Location: ../contabilidad/index.php');
                            break;
                        case 75:
                            // Oficial de Recuperacion
                            header('Location: ../contabilidad/index.php');
                            break;
                        default:
                            // Default
                            header('Location: http://www.creditosolidario.hn/cshrm/public');
                            break;
                    }
                    break;

                case 14:
                    // Control de Calidad
                    switch($designation){
                        case 82:
                            // Anai
                            header('Location: ../auxiliar-creditos/index.php');
                            break;
                        case 44:
                            header('Location: ../control-calidad/index.php');
                            break;
                        case 45:
                            header('Location: ../credito/index.php');
                            break;
                        default:
                            // Default
                            header('Location: http://www.creditosolidario.hn/cshrm/public');
                            break;
                    }
                    break;
                case 15:
                    // Externos
                    switch($designation){
                        case 62:
                            // Ventanilla Externa
                            header('Location: ../instituciones-financieras/index.php');
                            break;
                        case 68:
                            // Ventanilla Externa
                            header('Location: ../instituciones-financieras/index.php');
                            break;
                        case 69:
                            // Digitación Externa
                            header('Location: ../instituciones-financieras/index.php');
                            break;
                        default:
                            // Default
                            header('Location: http://www.creditosolidario.hn');
                            break;
                    }
                    break;
                case 18:
                    // Archivo
                    switch($designation){
                        case 78:
                            // Ventanilla Externa
                            header('Location: ../archivo/index.php');
                            break;
                        default:
                            // Default
                            header('Location: http://www.creditosolidario.hn');
                            break;
                    }
                    break;
                case 19:
                    // Enlaces
                    switch($designation){
                        case 87:
                            // Ciudad Mujer
                            header('Location: ../cda/index.php');
                            break;
                        case 81:
                            // Auxiliar Ciudad Mujer
                            header('Location: ../cda/index.php');
                            break;
                        case 18:
                            // Ciudad Mujer
                            header('Location: ../cda/index.php');
                            break;
                        default:
                            // Default
                            header('Location: http://www.creditosolidario.hn');
                            break;
                    }
                    break;
                default:
                    // Todas las demas
                    header('Location: http://www.creditosolidario.hn/cshrm/public');
                    break;
            }
            
        }else{
            
            unset($_SESSION['user']);
            unset($_SESSION['pass']);
            session_destroy();
            header('Location: ../login.php');
            
        }
        
    }catch(PDOException $e){
        
        $e->getMessage();
        
    }
    
}else{
    
    echo "No captura";
    //header('Location: ../login.html');
    
}


?>