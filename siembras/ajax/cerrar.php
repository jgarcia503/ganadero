<?php

include '../../conexion.php';
$consultas=[];
$tmp=  explode('&', $_SERVER[QUERY_STRING]);
$consultas[]="update proyectos_enc set cerrado='true',fecha_fin=current_date where id_proyecto=$tmp[0]";

if($tmp[1]==='true'){
$consultas[]="update tablones set estatus='libre' where id in (select id_tablones::integer from proyecto_tablones where id_proyecto='$tmp[0]')";
}else{
    $consultas[]="update tablones set estatus='descansando' where id in (select id_tablones::integer from proyecto_tablones where id_proyecto='$tmp[0]')";
}

try{
$conex->beginTransaction();
    
foreach ($consultas as $value) {
      if(!$conex->prepare($value)->execute()){                
           throw new PDOException();
    }
}
                
                $conex->commit();
                echo 'exito';
}
catch(Exception $ex){    
        $conex->rollBack();
        echo 'error';
}