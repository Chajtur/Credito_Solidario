<?php

/**
 * Archivo para guardar la linea base deun crédito digitado
 * @param data contiene todlos los datos digitados (enfermendades, educación y línea base)
 * @author Rychiv4
 */

require '../conection.php';

if(isset($_POST['data'])){
    
    $conn->beginTransaction();
    
    try{

        $obj = json_decode($_POST['data']);
        $sql_enfermedades = 'select guardar_linea_base_enfermedad(:id, :enfermedad, :tratamiento);';
        $sql_educacion = 'select guardar_linea_base_educacion(:id, :nombre, :educacion, :edad, :oficio, :genero);';
        $sql_guardar_linea_base = 'call guardar_linea_base(:id, :identidad, :ciclo, :material_predomina, :cantidad_habitantes, :cantidad_familias, :cantidad_trabajadores, :cantidad_buscan_empleo, :energia_electrica, :aguas_negras, :agua_potable, :pozo_septico, :telefono_fijo, :micro_empresa, :emprendera_micro, :unidad_vivienda, :tiempo_residir, :idusuario, :cantidad_dependientes);';

        // Primero se guardan todas las enfermedades
        $stat = $conn->prepare($sql_enfermedades);
        foreach($obj->enfermedades as $enfermedad){
            
            $stat->bindValue(':id', $obj->id, PDO::PARAM_STR);
            $stat->bindValue(':enfermedad', $enfermedad->Enfermedad, PDO::PARAM_STR);
            $stat->bindValue(':tratamiento', $enfermedad->Tratamiento, PDO::PARAM_STR);
            $stat->execute();
            
        }

        // Luego la educación de cada familiar
        $stat = $conn->prepare($sql_educacion);
        foreach($obj->familiares as $familiar){

            $stat->bindValue(':id', $obj->id, PDO::PARAM_STR);
            $stat->bindValue(':nombre', $familiar->Nombre, PDO::PARAM_STR);
            $stat->bindValue(':educacion', $familiar->Educacion, PDO::PARAM_STR);
            $stat->bindValue(':edad', $familiar->Edad, PDO::PARAM_STR);
            $stat->bindValue(':oficio', $familiar->Oficio, PDO::PARAM_STR);
            $stat->bindValue(':genero', $familiar->Genero, PDO::PARAM_STR);
            $stat->execute();

        }

        // Verificamos que servicios públicos vienen habilitados
        $energia_electrica = 0;
        $aguas_negras = 0;
        $agua_potable = 0;
        $pozo_septico = 0;
        $telefono_fijo = 0;

        foreach($obj->serviciosPublicos as $servicio){
            if($servicio == 1)
                $energia_electrica = 1;
            if($servicio == 2)
                $aguas_negras = 1;
            if($servicio == 3)
                $agua_potable = 1;
            if($servicio == 4)
                $pozo_septico = 1;
            if($servicio == 5)
                $telefono_fijo = 1;
        }

        // Finalmente se guarda la linea base
        $stat = $conn->prepare($sql_guardar_linea_base);
        $stat->bindValue(':id', $obj->id, PDO::PARAM_STR);
        $stat->bindValue(':identidad', $obj->identidad, PDO::PARAM_STR);
        $stat->bindValue(':ciclo', $obj->ciclo, PDO::PARAM_STR);
        $stat->bindValue(':tiempo_residir', $obj->tiempoResideVivienda, PDO::PARAM_STR);
        $stat->bindValue(':unidad_vivienda', $obj->unidadVivienda, PDO::PARAM_STR);
        $stat->bindValue(':material_predomina', $obj->materialVivienda, PDO::PARAM_STR);
        $stat->bindValue(':cantidad_habitantes', $obj->personasHabitan, PDO::PARAM_STR);
        $stat->bindValue(':cantidad_familias', $obj->familiasViven, PDO::PARAM_STR);
        $stat->bindValue(':cantidad_trabajadores', $obj->cuantasTrabajan, PDO::PARAM_STR);
        $stat->bindValue(':cantidad_buscan_empleo', $obj->buscanEmpleo, PDO::PARAM_STR);
        $stat->bindValue(':energia_electrica', $energia_electrica, PDO::PARAM_STR);
        $stat->bindValue(':aguas_negras', $aguas_negras, PDO::PARAM_STR);
        $stat->bindValue(':agua_potable', $agua_potable, PDO::PARAM_STR);
        $stat->bindValue(':pozo_septico', $pozo_septico, PDO::PARAM_STR);
        $stat->bindValue(':telefono_fijo', $telefono_fijo, PDO::PARAM_STR);
        $stat->bindValue(':micro_empresa', $obj->tieneMicroempresa, PDO::PARAM_STR);
        $stat->bindValue(':emprendera_micro', $obj->emprenderMicroempresa, PDO::PARAM_STR);
        $stat->bindValue(':idusuario', $obj->idusuario, PDO::PARAM_STR);
        $stat->bindValue(':cantidad_dependientes', 0, PDO::PARAM_STR);
        $stat->execute();

        $stat = $conn->prepare('update cartera_consolidada set estatus_archivo = 3 where id = :id');
        $stat->bindValue(':id', $obj->id, PDO::PARAM_STR);
        $stat->execute();
        
        echo 'true';
        $conn->commit();

    }catch(PDOException $e){
        error_log($e->getMessage());
        $conn->rollback();
        echo 'false';
    }
    
}

?>