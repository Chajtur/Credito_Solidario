<?php

$array = array();

for($i = 1; $i < 20; $i++){
    array_push($array, (object)array(
        'value' => $i,
        'text' => generateRandomString()
    ));
}

echo json_encode($array);

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>