<?php

if(isset($_POST['data'])){
    
    session_start();
    
    if($_SESSION['pass'] == $_POST['data']){
        echo true;
    }else{
        echo false;
    }
    
}

?>