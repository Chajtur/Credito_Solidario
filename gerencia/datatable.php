<?php

try{
    
    require '../php/conection.php';
    $stat = $conn->prepare('call obtener_cartera_completa()');
    $stat->execute();
    
    $temp_array = [];
    
    $i=1;
    
    $array = [
        'resumen' => [
            'data' => []
        ],
        'de1a15dias' => [
            'data' => []
        ],
        'de16a30dias' => [
            'data' => []
        ],
        'de31a60dias' => [
            'data' => []
        ],
        'de61a120dias' => [
            'data' => []
        ],
        'de120adelante' => [
            'data' => []
        ]
    ];
    
    $i=0;
    while($result = $stat->fetch(PDO::FETCH_NUM)){
    
        $resumen = [];
        $de1a15dias = [];
        $de16a30dias = [];
        $de31a60dias = [];
        $de61a120dias = [];
        $de120adelante = [];

        for($i=0; $i<10; $i++){

            $resumen[] = $result[$i];
        
        }
        
        array_push($array['resumen']['data'], (object) $resumen);
        
        for($i=10; $i<17; $i++){

            $de1a15dias[] = $result[$i];

        }
        
        array_push($array['de1a15dias']['data'], (object) $de1a15dias);
        
        for($i=17; $i<24; $i++){
            
            $de16a30dias[] = $result[$i];

        }
        
        array_push($array['de16a30dias']['data'], (object) $de16a30dias);
        
        for($i=24; $i<31; $i++){
            
            $de31a60dias[] = $result[$i];

        }
        
        array_push($array['de31a60dias']['data'], (object) $de31a60dias);
        
        for($i=31; $i<38; $i++){
            
            $de61a120dias[] = $result[$i];

        }
        
        array_push($array['de61a120dias']['data'], (object) $de61a120dias);
        
        for($i=38; $i<45; $i++){
            
            $de120adelante[] = $result[$i];

        }
        
        array_push($array['de120adelante']['data'], (object) $de120adelante);
        
        $i++;
        
    }
    
    $array['resumen']['draw'] = 1;
    $array['resumen']['recordsTotal'] = $i;
    $array['resumen']['recordsFiltered'] = $i;
    
    $array['de1a15dias']['draw'] = 1;
    $array['de1a15dias']['recordsTotal'] = $i;
    $array['de1a15dias']['recordsFiltered'] = $i;
    
    $array['de16a30dias']['draw'] = 1;
    $array['de16a30dias']['recordsTotal'] = $i;
    $array['de16a30dias']['recordsFiltered'] = $i;
    
    $array['de31a60dias']['draw'] = 1;
    $array['de31a60dias']['recordsTotal'] = $i;
    $array['de31a60dias']['recordsFiltered'] = $i;
    
    $array['de61a120dias']['draw'] = 1;
    $array['de61a120dias']['recordsTotal'] = $i;
    $array['de61a120dias']['recordsFiltered'] = $i;
    
    $array['de120adelante']['draw'] = 1;
    $array['de120adelante']['recordsTotal'] = $i;
    $array['de120adelante']['recordsFiltered'] = $i;
    
    echo json_encode($array);
    
    /*$data_array = [
        "draw" => 1,
        "recordsTotal" => $cantidad,
        "recordsFiltered" => $cantidad,
        "data" => []
    ];
    
    foreach($temp_array as $fila){
        
        array_push($data_array['data'], (object) $fila);
        
    }*/
    
}catch(PDOException $e){
    
    echo $e->getMessage();
    
}



?>