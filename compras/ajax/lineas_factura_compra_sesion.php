<?php
include '../../conexion.php';
session_start();
extract($_GET);
//$_SESSION[lineas_fact][]=[];

    //$_SESSION[lineas_fact][]=$ref;
//    $_SESSION[lineas_fact][$ref]=array('bodega'=>$bod,'cant'=>$cant,'unidad'=>$unidad,'precio'=>$precio);
if(!in_array($ref, $_SESSION[lineas_fact])){
    //$_SESSION[lineas_fact][]=array($ref=>array('bodega'=>$bod,'cant'=>$cant,'unidad'=>$unidad,'precio'=>$precio));
    $subtotal= floatval($cant)*floatval($precio);
    $_SESSION[lineas_fact][$ref]=array('bodega'=>$bod,'cant'=>$cant,'unidad'=>$unidad,'precio'=>$precio,'subtotal'=>$subtotal);
    $prod_id=  explode('-', $ref)[0];
    $prod_nombre=  explode('-', $ref)[1];
    check($prod_id, $id_enc, $bod, $prod_nombre, $cant, $unidad, $precio, $subtotal);
}
echo json_encode($_SESSION[lineas_fact]);

//unset($_SESSION[lineas_fact]);
function check($prod_id,$id_enc,$bod,$prod_nombre,$cant,$unidad,$precio,$subtotal){
  global $conex;
    $sql_check="select * from compras_lns where referencia='$prod_id' and enc_id=$id_enc";
    $sql_insert="insert into compras_lns values(default,'$bod','$prod_id','$prod_nombre','$cant','$unidad','$precio','$subtotal',$id_enc)";
    $sql_update="update compras_lns set bodega='$bod',cantidad='$cant',unidad='$unidad',precio='$precio',subtotal='$subtotal' where referencia='$prod_id' and enc_id=$id_enc";
    
$res=$conex->query($sql_check);
if($res->rowCount()===0){
    $conex->prepare($sql_insert)->execute();
}
else{
    
            $conex->prepare($sql_update)->execute();
            
    }
}