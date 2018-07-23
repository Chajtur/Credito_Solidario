<?php

/**
 * Get.php
 * 
 * Archivo importante para la API, para que las ifis puedan obtener 
 * información de los créditos que han sido colocados en ellos.
 * @author Rychiv4
 */

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    try{

        require '../php/conection.php';
        require 'functions.php';

        if(!parametrosCorrectos($_POST, 'get')) exit('400');
        if(!usuarioAutenticado($_POST, $conn)) exit('401');

        switch($_POST['tipo']){
            case 'colocaciones_pendientes':
                echo enviarColocaciones($_POST, $conn);
                break;
        }
        
    }catch(PDOException $e){
        echo $e->getMessage();
    }

}

?>