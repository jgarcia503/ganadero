<?php
session_start();
include '../../php funciones/funciones.php';
include '../../conexion.php';
extract($_GET);
$cant_conv=convertir($unidad, $cant);
$sql_check="select existencia,precio_promedio costo,nombre,unidad_standar from existencias a 
join productos b on a.codigo_producto=b.referencia
where a.codigo_producto='$ref' and a.codigo_bodega=$bod_org";

$res=$conex->query($sql_check)->fetch(PDO::FETCH_ASSOC);
if($res[existencia]>=$cant_conv){
    $subtotal=  floatval($cant_conv)*floatval($res[costo]);
    $sql_insert="insert into traslados_lns values(default,'$ref','$cant','$res[costo]','$unidad','$subtotal',$enc_id)";
    $conex->prepare($sql_insert)->execute();
    $_SESSION['traslado_lns'][$ref]=array('nombre'=>$res[nombre],'cant'=>$cant,'unidad'=>$unidad,'costo'=>$res[costo],'subtotal'=>$subtotal);
    echo json_encode($_SESSION['traslado_lns']);
    //echo 'ok';
}else{
  echo json_encode(array('error'=>"hay $res[existencia] $res[unidad_standar]"));
}

