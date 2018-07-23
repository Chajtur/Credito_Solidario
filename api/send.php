<?php

/**
 * Send.php
 * 
 * Archivo importante para la API, a través del cual las ifis reportarán 
 * desembolsos y pagos de si mismos
 * @author Rychiv4
 */

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    try{
        
        if(isset($_POST)){
            
            require '../php/conection.php';
            require 'functions.php';

            // si los parametros enviados no son correctos, finalizamos el script y enviamos el error 400
            if(!parametrosCorrectos($_POST, 'send')) exit('400 (Parametros incorrectos)');
            // si el usuario no se pudo autenticar, finalizamos el script y enviamos el error 401
            if(!usuarioAutenticado($_POST, $conn)) exit('401');

            $complete = false;
            
            switch($_POST['tipo']){
                case 'reportar_desembolso':                  
                    $complete = reportarDesembolso($_POST, $conn);
                    break;
                case 'reportar_pago':
                    $complete = reportarPago($_POST, $conn);
                    break;
                case 'confirmar_colocacion':
                    $complete = confirmarColocacion($_POST, $conn);
                    break;
                case 'reportar_convocar':
                    $complete = reportarConvocar($_POST, $conn);
                    break;
            }
            
            return ($complete ? success200() : error500());

        }else{

            error400();

        }

    }catch(PDOException $e){

        error_log($e->getMessage());

    }

}

?>