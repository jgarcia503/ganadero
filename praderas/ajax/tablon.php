<?php

include '../../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);

$sql="select * from tablones where id=$id";
$res=$conex->query($sql)->fetch(PDO::FETCH_ASSOC);
$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>". ucwords('nombre')
        . "<input type='text' value='$res[nombre]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('extension')
        . "<input type='text' value='$res[extension]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('estatus')
        . "<input type='text' value='$res[estatus]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('costo uso por dia')
        . "<input type='text' value='$res[costo_uso_x_dia]' readonly>"
        . "</div>"     
        . "</div>"
       ."<div class='row'>"
       . "<div class='small-12 columns'>".  ucwords('notas')
        . "<textarea readonly>$res[notas]</textarea>"
        . "</div>"        
        . "</div>";
       
echo $plantilla;
//$plantilla='<input type="text" value="{}" readonly>';
//$datos='';
//
//foreach ($res as $key=>$valor){
//    if($key!='id' and $key!='terreno_id'){
//            if($valor==null){
//                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
//            }else{
//                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
//            }
//    }
//}
//
//echo $datos;