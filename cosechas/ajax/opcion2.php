<?php
include '../../conexion.php';
include '../../php funciones/funciones.php';
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
    $vta_total=  filter_var($vta_elote,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_silo= filter_var($costo_proyecto,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION)-$vta_total;
    $costo_proyecto= filter_var($costo_proyecto,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    
    $costo_cosecha_mano_obra=  filter_var($costo_cosecha_mano_obra,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_picar_mano_obra=  filter_var($costo_picar_mano_obra,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_transporte=  filter_var($costo_transporte,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_plastico= filter_var($costo_plastico,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_compactacion=filter_var($costo_compactacion,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_insumos=filter_var($costo_insumos,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    
    $reclamo_costo= filter_var($costo_proyecto-($vta_total*($porcentaje_costo/100)));
    
    $costo_silo+=($costo_cosecha_mano_obra+$costo_picar_mano_obra+$costo_transporte+$costo_plastico+$costo_compactacion+$costo_insumos);
    $consultas=[];
    
    ######insert opcion 2
    $consultas[]="insert into opcion_2 "            
            . "values(default,'$vta_elote','$redes_cos','$precio_red'"
            . ",'$costo_silo','$calidad_zacate','$calidad_elote'"            
            . ",'$costo_proyecto','$costo_cosecha_mano_obra','$ton_forraje','$costo_picar_mano_obra'"
            . ",'$costo_transporte','$costo_plastico','$costo_compactacion'"
            . ",'$costo_insumos','$fecha_inicio','$fecha_cierre'"
            . ",'$notas','$proy_id','$reclamo_costo')";
    
    ########update proyectos
    $consultas[]="update proyectos_enc set opcion='2' where id_proyecto=$proy_id";
    
    $kg_forraje= convertir('ton', filter_var($_POST[ton_forraje],FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION));
    $costo_promedio= number_format(filter_var($costo_silo,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION)/$kg_forraje,2);
    foreach ($silos as  $value) {

                $kg_forraje= convertir('ton', floatval($value[ton_silo]));
                $consultas[]="insert into opcion_2_lns values(default,'$value[cod_silo]','$value[ton_silo]','$value[descripcion]','$proy_id')";
                $consultas[]="insert into productos values(default,'$value[cod_silo]','silo','kg','$costo_promedio','silos','Paso Firme','$kg_forraje')";
                $consultas[]="insert into existencias values (default,'$value[cod_silo]','$cod_bodega','$kg_forraje')";
                $consultas[]="insert into kardex values(default,'$cod_bodega','$value[cod_silo]',now(),'proyecto','$proy_id','$costo_promedio','$kg_forraje')";
        

    }
//    $consultas[]="insert into productos values(default,'$_POST[cod_silo]','silo','kg','$costo_promedio','silos','Paso Firme','$kg_forraje')";
//    $consultas[]="insert into existencias values (default,'$_POST[cod_silo]','$_POST[cod_bodega]','$kg_forraje')";
//    $consultas[]="insert into kardex values(default,'$_POST[cod_bodega]','$_POST[cod_silo]',now(),'proyecto','$_POST[proy_id]','$costo_promedio','$kg_forraje')";
    
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