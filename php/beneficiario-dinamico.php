<?php

if(isset($_POST['data'])){

    try{
        
        require_once 'conection.php';
        $numeric = false;
        if(ctype_digit($_POST['data'])){
            $stat = $conn->prepare('select nombre, identidad from emprendedor where identidad like :identidad limit 100');
            $stat->bindValue(':identidad', '%'.$_POST['data'].'%', PDO::PARAM_STR);
            $numeric = true;
        }else{
            $stat = $conn->prepare('select nombre, identidad from emprendedor where nombre like :nombre limit 100');
            $stat->bindValue(':nombre', '%'.$_POST['data'].'%', PDO::PARAM_STR);
        }
        
        if($stat->execute()){
            $result = $stat->fetchAll();
            $i=0;
            $return = '';
            foreach($result as $row){

                $return .= '
                <li class="collection-item avatar beneficiario">
                    <i class="material-icons circle">account_circle</i>
                    <span class="title" id="nombre">'.$row['nombre'].'</span>
                    <p id="identidad">'.$row['identidad'].'</p>
                </li>';
                $i++;
                
            }
            if($i == 0){
                $return .= '
                <li class="collection-item">
                    <span class="title">No hay ningun beneficiario '.($numeric ? 'con identidad' : 'llamado').' <b>'.$_POST['data'].'</b></span>
                    <a class="waves-effect waves-light btn">Crear</a>
                </li>';
            }
            echo $return;
        }
        
    }catch(PDOException $e){
        echo '
        <li class="collection-item">
            <span class="title">Error de conexion, intentelo de nuevo</span>
        </li>';
    }


}
        


?>