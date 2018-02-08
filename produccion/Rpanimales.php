<?php

include '../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);
$sql="select fecha from bit_peso_animal where id=$id";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);
$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>".  array_keys($animal,$animal[fecha])[0]
        . "<input type='text' value='$animal[fecha]' readonly>"
        . "</div>"
        . "</div>";

echo $plantilla;
//$plantilla='<input type="text" value="{}" readonly>';
//$datos='';
//
//foreach ($animal as $key=>$valor){
//
//            if($valor==null){
//                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
//            }else{
//                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
//            }
//    
//}
//
//echo $datos;