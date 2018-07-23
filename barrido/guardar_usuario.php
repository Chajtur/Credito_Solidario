<?php

if(isset($_POST['user'], $_POST['name'])){
    session_start();
    $_SESSION['user'] = $_POST['user'];
    $_SESSION['name'] = $_POST['name'];
}

?>