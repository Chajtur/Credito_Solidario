<?php 

$array = array(
    (object)array(
        'Nombre' => 'John Doe',
        'Departamento' => 'Francisco Morazán',
        'Direccion' => 'Tegucigalpa',
        'Teléfono' => '23323232',
        'Familia' => array(
            (object)array(
                'Nombre' => 'Joseph Doe',
                'Departamento' => 'Comayagua',
                'Parentezco' => 'Hermano',
                'Direccion' => 'SPS'
            ),
            (object)array(
                'Nombre' => 'Jane Doe',
                'Departamento' => 'Cortés',
                'Parentezco' => 'Hermana',
                'Direccion' => 'DMZ'
            ),
            (object)array(
                'Nombre' => 'Joanne Doe',
                'Departamento' => 'Francisco Morazán',
                'Parentezco' => 'Madre',
                'Direccion' => 'EDS'
            )
        ) 
    ),
    (object)array(
        'Nombre' => 'Frank Doe',
        'Departamento' => 'Cortés',
        'Direccion' => 'San Pedro Sula',
        'Teléfono' => '43322121',
        'Familia' => array(
            (object)array(
                'Nombre' => 'Jane Dowal',
                'Departamento' => 'Cortés',
                'Parentezco' => 'Hermana',
                'Direccion' => 'SPS'
            ),
            (object)array(
                'Nombre' => 'Kim Dashan',
                'Departamento' => 'Cortés',
                'Parentezco' => 'Hermana',
                'Direccion' => 'DMZ'
            )
        ) 
    ),
    (object)array(
        'Nombre' => 'Pablo Perez',
        'Departamento' => 'Francisco Morazán',
        'Direccion' => 'Tegucigalpa',
        'Teléfono' => '98670988',
        'Familia' => array(
            (object)array(
                'Nombre' => 'Pedro Perez',
                'Departamento' => 'Francisco Morazán',
                'Parentezco' => 'Hermano',
                'Direccion' => 'Tegucigalpa'
            ),
            (object)array(
                'Nombre' => 'Maria Perez',
                'Departamento' => 'Comayagua',
                'Parentezco' => 'Prima',
                'Direccion' => 'DMZ'
            ),
            (object)array(
                'Nombre' => 'Joanne Doe',
                'Departamento' => 'Francisco Morazán',
                'Parentezco' => 'Madre',
                'Direccion' => 'EDS'
            )
        ) 
    ),
    (object)array(
        'Nombre' => 'Cristian Valladares',
        'Departamento' => 'IOWA',
        'Direccion' => 'IOWA',
        'Teléfono' => '54312312',
        'Familia' => array(
            (object)array(
                'Nombre' => 'Ricardo Valladares',
                'Departamento' => 'Francisco Morazán',
                'Parentezco' => 'Hermano',
                'Direccion' => 'Tegucigalpa'
            ),
            (object)array(
                'Nombre' => 'Fernando Valladares',
                'Departamento' => 'Francisco Morazán',
                'Parentezco' => 'Hermano',
                'Direccion' => 'Tegucigalpa'
            ),
            (object)array(
                'Nombre' => 'Alejandro Valladares',
                'Departamento' => 'Tenessee',
                'Parentezco' => 'Hermano',
                'Direccion' => 'Memphis'
            )
        ) 
    ),
    (object)array(
        'Nombre' => 'Tamara Bennett',
        'Departamento' => 'Francisco Morazán',
        'Direccion' => '3254 E Broadway St',
        'Teléfono' => '8091394970',
        'Familia' => array(
            (object)array(
                'Nombre' => 'Gabriella Holland',
                'Departamento' => 'Comayagua',
                'Parentezco' => 'Hermana',
                'Direccion' => '1872 Red Saturn Dr'
            ),
            (object)array(
                'Nombre' => 'Joy Jennings',
                'Departamento' => 'Cortés',
                'Parentezco' => 'Hermana',
                'Direccion' => '5523 Shelley St'
            )
        ) 
    ),
    (object)array(
        'Nombre' => 'Greg Larson',
        'Departamento' => 'Cortés',
        'Direccion' => 'Jefferson',
        'Teléfono' => '2007465117',
        'Familia' => array(
            (object)array(
                'Nombre' => 'Joseph Doe',
                'Departamento' => 'Comayagua',
                'Parentezco' => 'Hermano',
                'Direccion' => 'SPS'
            ),
            (object)array(
                'Nombre' => 'Jane Doe',
                'Departamento' => 'Cortés',
                'Parentezco' => 'Hermana',
                'Direccion' => 'DMZ'
            ),
            (object)array(
                'Nombre' => 'Joanne Doe',
                'Departamento' => 'Francisco Morazán',
                'Parentezco' => 'Madre',
                'Direccion' => 'EDS'
            )
        ) 
    ),
    (object)array(
        'Nombre' => 'Jerry Scott',
        'Departamento' => 'Cortés',
        'Direccion' => '7607 Daisy Dr',
        'Teléfono' => '3433206369',
        'Familia' => array(
            (object)array(
                'Nombre' => 'Nora Jensen',
                'Departamento' => 'Royal',
                'Parentezco' => 'Conyugue',
                'Direccion' => '4014 Royal Ln'
            ),
            (object)array(
                'Nombre' => 'Leslie Jimenez',
                'Departamento' => 'Mcgowen',
                'Parentezco' => 'Hermana',
                'Direccion' => '7669 Mcgowen St'
            )
        ) 
    )
);

if(isset($_GET['initial'])){

    header('Content-type: application/json');
    echo json_encode($array);

}

if(isset($_GET['search'])){

    $search = $_POST['search'];
    $resultsarray = [];

    foreach($array as $elem){
        if(strtolower($search) == strtolower($elem->Nombre)){
            array_push($resultsarray, $elem);
        }
    }

    header('Content-type: application/json');
    echo json_encode($resultsarray);

}

?>