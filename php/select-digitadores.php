<?php

require_once 'conection.php';

if($conn2){
    
    $stat = $conn2->prepare('select employee_id, concat(first_name, " ", last_name) as name from users where department_id = 3 and designation_item_id = 27');
    $stat->execute();

    $result = $stat->fetchAll();

    foreach($result as $fila){

        echo '<option value="'.$fila['employee_id'].'">'.$fila['name'].'</option>';

    }
}


?>