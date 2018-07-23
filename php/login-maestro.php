<?php

if(isset($_POST['user'], $_POST['pass'])){

    if($_POST['user'] != 'G001' && $_POST['user'] != 'J001'){
        exit(false);
    }

    require 'conection.php';

}else{
    
    echo 'nada';
    
}

?>