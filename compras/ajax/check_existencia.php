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
    $_SESSION['traslado_lns'][$ref]=array('nombre'=>$res[nombre],'cant'=>$cant,'unidad'=>$unidad,'costo'=>$res[costo],'subtotal'=>$subtotal);
    check($ref, $id_enc, $cant, $unidad, $res[costo], $subtotal);
    
    echo json_encode($_SESSION['traslado_lns']);
}else{
  echo json_encode(array('error'=>"hay $res[existencia] $res[unidad_standar]"));
}

function check($prod_id,$id_enc,$cant,$unidad,$costo,$subtotal){
  global $conex;
    $sql_check="select * from traslados_lns where producto='$prod_id' and enc_id='$id_enc'";
    $sql_insert="insert into traslados_lns values(default,'$prod_id','$cant','$costo','$unidad','$subtotal',$id_enc)";
    $sql_update="update traslados_lns set cantidad='$cant',unidad='$unidad',importe='$subtotal' where producto='$prod_id' and enc_id='$id_enc'";
    
$res=$conex->query($sql_check);
if($res->rowCount()===0){
    $conex->prepare($sql_insert)->execute();
}
else{    
            $conex->prepare($sql_update)->execute();            
    }
}