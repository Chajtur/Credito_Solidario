<?php

    if(isset($_POST['type']) && isset($_POST['data'])){
        try{
            require_once '../conection.php';

            $json = json_encode($_POST['data']);
            $data = json_decode($json);
            
            // echo $json."\n";
            // echo $data->{'departamento'};
        
            switch($_POST['type']){

                case "municipio":

                    $stat = $conn->prepare('select idMunicipio, nombre from municipio where idDepartamento = :departamento*1 ORDER BY idMunicipio');
                    $stat->bindValue(':departamento', $data->departamento, PDO::PARAM_STR);

                    if ($stat->execute()) {
                        $result = $stat->fetchAll();
                        echo json_encode($result);
                        // echo "Hola Mundo!";
                    } else {
                        // echo "Else";
                    }
                    // echo $data->{'departamento'};
                    // echo "Hola Mundo!";
                    break;

                case "aldea":

                    $stat = $conn->prepare('select distinct idAldea, Aldea as nombre from barrio where idDepartamento = :departamento*1 and idMunicipio = :municipio*1 order by idAldea');
                    $stat->bindValue(':departamento', $data->departamento, PDO::PARAM_STR);
                    $stat->bindValue(':municipio', $data->municipio, PDO::PARAM_STR);

                    if ($stat->execute()) {
                        $result = $stat->fetchAll();
                        echo json_encode($result);
                        // echo "Hola Mundo!";
                    } else {
                        // echo "Else";
                    }
                    // echo $data->{'departamento'};
                    // echo "Hola Mundo!";
                    break;

                case "caserio":
                    $stat = $conn->prepare('select distinct idCaserio, Caserio as nombre from barrio where idDepartamento = :departamento*1 and idMunicipio = :municipio*1 and idAldea = :aldea*1 order by idCaserio');
                    $stat->bindValue(':departamento', $data->departamento, PDO::PARAM_STR);
                    $stat->bindValue(':municipio', $data->municipio, PDO::PARAM_STR);
                    $stat->bindValue(':aldea', $data->aldea, PDO::PARAM_STR);

                    if ($stat->execute()) {
                        $result = $stat->fetchAll();
                        echo json_encode($result);
                    } else {
                        echo "Else";
                    }
                    // echo $data->{'departamento'};
                    // echo "Hola Mundo!";
                    break;                    

                case "barrio":
                    $stat = $conn->prepare('select distinct idBarrio, Barrio as nombre from barrio where idDepartamento = :departamento*1 and idMunicipio = :municipio*1 and idAldea = :aldea*1 and idCaserio = :caserio*1 order by idBarrio');
                    $stat->bindValue(':departamento', $data->departamento, PDO::PARAM_STR);
                    $stat->bindValue(':municipio', $data->municipio, PDO::PARAM_STR);
                    $stat->bindValue(':aldea', $data->aldea, PDO::PARAM_STR);
                    $stat->bindValue(':caserio', $data->caserio, PDO::PARAM_STR);

                    if ($stat->execute()) {

                        $result = [];
                        while($data = $stat->fetch(PDO::FETCH_ASSOC)){
                            $result[] = $data;
                        }
                        echo json_encode($result);
                    } else {
                        echo "Else";
                    }
                    // echo $data->{'departamento'};
                    // echo "Hola Mundo!";
                    break;   

                default:
                    echo "default";

            }
            
        }catch(PDOException $e){
            
            echo $e->getMessage();
            
        }
        
    }

?>