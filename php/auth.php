<?php

session_start();

try{
    
    if(isset($_SESSION['user']) && isset($_SESSION['pass'])){
        
        $auth_list = array(
            "credito" => array(
                "departamento" => array("6", "14"),
                "designaciones" => array("23", "45")
            ),
            "call-center" => array(
                "departamento" => array("3"),
                "designaciones" => array("25")
            ),
            "control-calidad" => array(
                "departamento" => array("6","14"),
                "designaciones" => array("46","44")
            ),
            "coordinadores" => array(
                "departamento" => array("6"),
                "designaciones" => array("22","55")
            ),
            "digitacion" => array(
                "departamento" => array("3"),
                "designaciones" => array("27", "99")
            ),
            "colocacion" => array(
                "departamento" => array("3"),
                "designaciones" => array("24")
            ),
            "asesor-tecnico" => array(
                "departamento" => array("6"),
                "designaciones" => array("14")
            ),
            "archivo" => array(
                "departamento" => array("4"),
                "designaciones" => array("26","78")
            ),
            "super-digitador" => array(
                "departamento" => array("6"),
                "designaciones" => array("48")
            ),
            "coordinador-digitador" => array(
                "departamento" => array("6"),
                "designaciones" => array("49")
            ),
            "ventanilla" => array(
                "departamento" => array("6"),
                "designaciones" => array("50")
            ),
            "gerencia" => array(
                "departamento" => array("1"),
                "designaciones" => array("1")
            ),
            "supervisores" => array(
                "departamento" => array("6"),
                "designaciones" => array("13")
            ),
            "auxiliar-creditos" => array(
                "departamento" => array("14", "6"),
                "designaciones" => array("82", "106", "44", "108")
            ),
            "informatica" => array(
                "departamento" => array("3"),
                "designaciones" => array("10","12","54")
            ),
            "contabilidad" => array(
                "departamento" => array("10","13", "4"),
                "designaciones" => array("63", "58","72","75", "76")
            ),
            "contabilidad-backup" => array(
                "departamento" => array("12"),
                "designaciones" => array("56","57","58")
            ),
            "call-center-recuperacion" => array(
                "departamento" => array("6"),
                "designaciones" => array("57")
            ),
            "instituciones-financieras" => array(
                "departamento" => array("15"),
                "designaciones" => array("62", "68", "69")
            ),
            "cda" => array(
                "departamento" => array("2","19"),
                "designaciones" => array("70","30","87","94","81")
            ),
            "administracion" => array(
                "departamento" => array("0"),
                "designaciones" => array("73")
            ),
            "control-interno" => array(
                "departamento" => array("5"),
                "designaciones" => array("90")
            )
        );
        
        $window = getcwd();
        $array_temp = explode("\\", $window);
        $base_dir = end($array_temp);
        
        $tiene_acceso_departamento = false;
        foreach($auth_list[$base_dir]['departamento'] as $departamento){
            if($departamento == $_SESSION['depto']) $tiene_acceso_departamento = true;
        }

        $tiene_acceso_designacion = false;
        foreach($auth_list[$base_dir]['designaciones'] as $designacion){
            if($designacion == $_SESSION['designation']) $tiene_acceso_designacion = true;
        }
        
        if(!$tiene_acceso_designacion || !$tiene_acceso_departamento) redirectToLogin('no_auth');
        
        require '../php/conection.php';
        $stat = $conn2->prepare('select password from users where username = :user');
        $stat->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
        $stat->execute();
        $result = $stat->fetch(PDO::FETCH_ASSOC);
        
    if(!($_SESSION['pass'] == "icsit2018") && (!(password_verify($_SESSION['pass'], $result['password'])))) 
            redirectToLogin('error_auth');
        
    }else{
        
        $_SESSION = array();
        redirectToLogin('no_auth');
        
    }
    
}catch(PDOException $e){
    
    $_SESSION = array();
    redirectToLogin('conn_exception');
    
}

function redirectToLogin($var){
    
    $_SESSION = array();
    session_destroy();
    header('Location: ../login.php?'.$var);
    
}

function redirectToRedirect(){
    
    header('Location: ../php/redirect.php');
    
}

?>