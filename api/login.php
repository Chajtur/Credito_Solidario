<?php

/*
* Este archivo es utilizado por el ajax para iniciar sesion en el API
* @author Rychiv4
*/

    if(isset($_POST['user']) && isset($_POST['pass'])){

        try{

            require_once "../php/conection.php";
            
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            $array = array();
            if($conn2){

                $stat = $conn2->prepare('
                    select email, users.first_name, users.last_name, users.password, users.employee_id, designation_items.designation_item 
                    from users 
                    inner join designation_items on users.designation_item_id = designation_items.id
                    where username = :user');
                $stat->bindValue(':user', $user, PDO::PARAM_STR);
                if($stat->execute()){

                    $result = $stat->fetch(PDO::FETCH_ASSOC);

                    if(password_verify($pass, $result['password'])){
                        $array[] = $result;
                        echo json_encode($array);
                    }else{
                        echo json_encode($array);                      
                    }
                }                
            }                        
        } catch(PDOException $e){

            echo $e->getCode();        
        }    
    } else{

        // echo "nada";    
    }
?>