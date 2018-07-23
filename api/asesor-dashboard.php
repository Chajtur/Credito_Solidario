<?php

/**
 * Archivo que devuelve los creditos colocados y desembolsados de un gestor
 * @return JSON devuelve un arreglo de formato fetchAll en formato JSON
 * @author Ricardo Valladares (Rychiv4)
 */

if(isset($_POST['nombre'])){
    
    $id = $_POST['nombre'];
    
    try{
        
        require '../php/conection.php';
    
        $stat = $conn->prepare('select count(*) as cantidad, sum(capital_mora) as capital_mora, (sum(capital_mora)/sum(saldo_capital))*100 as porcentaje, 
        (select count(*) from credito_solidario.prestamo where Estado_Credito = "Colocado" and Gestor = :nombre_gestor) as cantidad_colocados
        from credito_solidario.prestamo where Estado_Credito = "Desembolsado" and Gestor = :nombre_gestor');
        $stat->bindValue(':nombre_gestor', $id, PDO::PARAM_STR);
        $stat->execute();
        $result = $stat->fetchAll();

        echo json_encode($result[0]);
        
    }catch(PDOException $e){
        
        echo $e->getMessage();
        
    }
    
    
}else{
    
    echo "Por favor envie el nombre";
    
}

?>