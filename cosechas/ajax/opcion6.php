<?php
include '../../php funciones/funciones.php';
include '../../conexion.php';

if($_SERVER[REQUEST_METHOD]=='POST'){
        $params=[];
    $datos_form=explode('&',$_POST[forma]);
    foreach ($datos_form as $value) {
        $tmp=explode('=', $value);
        $params[$tmp[0]]=$tmp[1];
                
    }
    extract($params);
    $silos=$_POST[silos];
try{
    $consultas=[];
    $consultas[]="insert into opcion_6 values(default,'$costo_proyecto'"
            . ",'$costo_cosecha_mano_obra'"
            . ",'$costo_picar_mano_obra','$costo_transporte'"
            . ",'$notas',$proy_id)";
    
    $consultas[]="update proyectos_enc set opcion='6' where id_proyecto=$proy_id";
    
    $costo_silo=  filter_var($costo_proyecto,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    
    $costo_cosecha_mano_obra=filter_var($costo_cosecha_mano_obra,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_picar_mano_obra=  filter_var($costo_picar_mano_obra,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_transporte=  filter_var($costo_transporte,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

    
      $costo_silo+=($costo_cosecha_mano_obra+$costo_picar_mano_obra+$costo_transporte);
      $kg_forraje= convertir('ton', filter_var($_POST[ton_estimadas],FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION));
      $costo_promedio= filter_var($costo_silo,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION)/$kg_forraje;
      
            foreach ($silos as  $value) {
                    $kg_forraje= convertir('ton', filter_var($ton_forraje,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION));
                    
                $consultas[]="insert into opcion_6_lns values(default,'$value[cod_silo]','$value[ton_silo]','$value[descripcion]','$proy_id')";
                $consultas[]="insert into productos values (default,'$value[cod_silo]','silo','kg','$costo_promedio','silos','Paso Firme','$kg_forraje')";
                $consultas[]="insert into existencias values (default,'$value[cod_silo]','$cod_bodega','$kg_forraje')";
                $consultas[]="insert into kardex values (default,'$cod_bodega','$value[cod_silo]',now(),'proyecto','$proy_id','$costo_promedio','$kg_forraje')";
        
            }
            
$conex->beginTransaction();

  foreach ($consultas as $value) {
        if(!$conex->prepare($value)->execute()){                
           throw new PDOException();
    }
}
        $conex->commit();
                              $mensaje='<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';                
                              
    
}
 catch (PDOException $pe){
              $conex->rollBack();
      $mensaje= '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
 }
}