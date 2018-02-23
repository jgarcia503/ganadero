<?php
include '../../../conexion.php';
include '../../../php funciones/funciones.php';
session_start();
extract($_GET);
$sql="select * from productos where referencia='$ref'";
$res=$conex->query($sql)->fetch(PDO::FETCH_ASSOC);
$cant_conv=  convertir($unidad, $cant);
$_SESSION[inv_fisico][$ref]=array('nombre'=>$res[nombre],'unidad_elegida'=>$unidad,'precio_prom'=>$res[precio_promedio],'cant'=>$cant_conv);
$sql_check="select * from inventario_fisico_lns where producto_id='$ref'  and enc_id=$enc_id ";
$sql_insert="insert into  inventario_fisico_lns (id,bodega_id,producto_id,cantidad_teorica,cantidad_real,costo,enc_id) "
                              . "values(default,$bod_id,'$ref','0','$cant_conv','$res[precio_promedio]',$enc_id)";
$sql_update="update inventario_fisico_lns set cantidad_real=cantidad_real::numeric(10,2)+$cant_conv  where producto_id='$ref'  and enc_id=$enc_id";

$res_check=$conex->query($sql_check);

if($res_check->rowCount()===0){
    $conex->prepare($sql_insert)->execute();    
}else{
    $conex->prepare($sql_update)->execute();    
}


echo json_encode($_SESSION[inv_fisico]);
