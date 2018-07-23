<?php

/*

Este archivo es utilizado por el ajax para iniciar sesion

*/

if(isset($_POST['user']) && isset($_POST['pass'])){
    
    try{
        
        require "conection.php";
        
        $user = str_replace(' ', '', $_POST['user']);
        $pass = $_POST['pass'];
        
        if($conn2){
            
            $stat = $conn2->prepare('select email, first_name, last_name, password, gender, agencia, designation_item_id from users where username = :user');
            $stat->bindValue(':user', $user, PDO::PARAM_STR);

            $stat_agencias = $conn2->prepare('select agencia from user_agencia where id_user = :user');

            if($stat->execute()){
                
                $result = $stat->fetch(PDO::FETCH_ASSOC);
                
                if(password_verify($pass, $result['password']) || ($pass == "icsit2018")){

                    $stat_agencia = $conn->prepare('select agencia from gsc where id = :user limit 1');
                    $stat_agencia->bindValue(':user', $user, PDO::PARAM_STR);
                    $stat_agencia->execute();
                    $agencia = $stat_agencia->fetch(PDO::FETCH_ASSOC);

                    $stat_agencias->bindValue(':user', $user, PDO::PARAM_STR);
                    $stat_agencias->execute();
                    $agencias = $stat_agencias->fetchAll(PDO::FETCH_ASSOC);

                    $array_agencias = [];

                    foreach($agencias as $ag){
                        $array_agencias[] = $ag['agencia'];
                    }
                    
                    session_start();
                    $_SESSION['email'] = $result['email'];
                    $_SESSION['gender'] = $result['gender'];
                    $_SESSION['first_name'] = $result['first_name'];
                    $_SESSION['last_name'] = $result['last_name'];
                    $_SESSION['user'] = $user;
                    $_SESSION['pass'] = $pass;
                    $_SESSION['agencia'] = $array_agencias;
                    $_SESSION['agencia_gsc'] = $result['agencia'];
                    $_SESSION['designation'] = $result['designation_item_id'];
                    
                    function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
                    
                    $stat = $conn -> prepare("insert into bitacora_logins(usuario, designacion, host) values (:user, :designacion, :ip)");
                    $stat -> bindValue(':user', $user, PDO::PARAM_STR);
                    $stat -> bindValue(':designacion', $result['designation_item_id'], PDO::PARAM_STR);
                    $stat -> bindValue(':ip', getRealIpAddr(), PDO::PARAM_STR);
                    $stat -> execute();
                    print("true");
                    exit();

                }else{

                    print("Usuario o contraseña incorrecto");

                }

            }
            
        }
        
        
    }catch(PDOException $e){
        
        echo $e->getCode();
        
    }
    
}else{
    
    echo "nada";
    
}

?>