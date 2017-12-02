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
    $vta_total=  floatval($vta_elote);
    $costo_silo=  floatval($costo_proyecto)-$vta_total;
    
    $costo_cosecha_mano_obra=floatval($costo_cosecha_mano_obra);
    $costo_picar_mano_obra=  floatval($costo_picar_mano_obra);
    $costo_transporte=  floatval($costo_transporte);
    $costo_plastico= floatval($costo_plastico);
    $costo_compactacion=floatval($costo_compactacion);
    $costo_insumos=floatval($costo_insumos);
    $reclamo_costo=  floatval($costo_proyecto-($vta_total*($porcentaje_costo/100)));
    
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
    
    $kg_forraje= convertir('ton', floatval($_POST[ton_forraje]));
    $costo_promedio= number_format(floatval($costo_silo)/$kg_forraje,2);
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