<?php

session_start();
extract($_GET);
//$_SESSION[lineas_fact][]=[];

    //$_SESSION[lineas_fact][]=$ref;
//    $_SESSION[lineas_fact][$ref]=array('bodega'=>$bod,'cant'=>$cant,'unidad'=>$unidad,'precio'=>$precio);
if(!in_array($ref, $_SESSION[lineas_fact])){
    //$_SESSION[lineas_fact][]=array($ref=>array('bodega'=>$bod,'cant'=>$cant,'unidad'=>$unidad,'precio'=>$precio));
    $subtotal= floatval($cant)*floatval($precio);
    $_SESSION[lineas_fact][$ref]=array('bodega'=>$bod,'cant'=>$cant,'unidad'=>$unidad,'precio'=>$precio,'subtotal'=>$subtotal);

}
echo json_encode($_SESSION[lineas_fact]);

//unset($_SESSION[lineas_fact]);