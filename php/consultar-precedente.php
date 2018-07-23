<?php

if(isset($_POST['id'])){

    try{

        require 'conection.php';

        $stat = $conn->prepare('select if(
				(select max(ciclo) from cartera_consolidada where identidad in (select identidad from cartera_consolidada where grupo_solidario_hash = :hash)) > 1,
        (
            select b.Nombre from cartera_consolidada a inner join ifi b on a.IFI = b.id where a.identidad in (select identidad from cartera_consolidada where grupo_solidario_hash = :hash) 
            and a.ciclo = (select ((max(ciclo))-1) from cartera_consolidada where identidad in (select identidad from cartera_consolidada where grupo_solidario_hash = :hash))
            limit 1),
            (select b.Nombre from cartera_consolidada a inner join ifi b on a.IFI = b.id where a.identidad in (select identidad from cartera_consolidada where grupo_solidario_hash = :hash) limit 1)
        ) as resultado
        ');

        $hash = $_POST['id'];

        $stat->bindValue(':hash', $hash, PDO::PARAM_STR);
        if($stat->execute()){
            $result = $stat->fetch(PDO::FETCH_ASSOC);
            echo $result['resultado'];
        }else{
            echo "error";
        }

    }catch(PDOException $e){

        echo $e->getMessage();

    }
    

}

?>