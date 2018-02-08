<?php

include '../../conexion.php';

$id=$_GET[id];
$sql="select * from compras_servicios where id='$id'";

$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);

$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>".  array_keys($animal,$animal[fecha])[0]
        . "<input type='text' value='$animal[fecha]' readonly>"
        . "</div>"
         . "<div class='small-3 columns'>".  array_keys($animal,$animal[tipo_servicio])[0]
        . "<input type='text' value='$animal[tipo_servicio]' readonly>"
        . "</div>"
         . "<div class='small-3 columns'>".  array_keys($animal,$animal[proveedor])[0]
        . "<input type='text' value='$animal[proveedor]' readonly>"
        . "</div>"
         . "<div class='small-3 columns'>".  array_keys($animal,$animal[costo])[0]
        . "<input type='text' value='$animal[costo]' readonly>"
        . "</div>"
         . "<div class='small-12 columns'>".  array_keys($animal,$animal[notas])[0]
        . "<textarea readonly>$animal[notas]</textarea>"
        . "</div>"
        . "</div>";

echo $plantilla;
//$plantilla='<input type="text" value="{}" readonly>';
//$datos='';
//
//foreach ($animal as $key=>$valor){
//    if($key!='id' ){
//            if($valor==null){
//                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
//            }else{
//                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
//            }
//    }
//}
//
//echo $datos;