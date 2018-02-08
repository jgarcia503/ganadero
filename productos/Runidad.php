<?php

include '../conexion.php';
$lluvia=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from unidades where id=$lluvia";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);
$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>". ucwords('categoria')
        . "<input type='text' value='$animal[categoria]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('unidad')
        . "<input type='text' value='$animal[unidad]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('prefijo')
        . "<input type='text' value='$animal[prefijo]' readonly>"
        . "</div>"
        . "</div>"
       ."<div class='row'>"
       . "<div class='small-12 columns'>".  ucwords('notas')
        . "<textarea readonly>$animal[notas]</textarea>"
        . "</div>"        
        . "</div>";
       
echo $plantilla;
//$plantilla='<input type="text" value="{}" readonly>';
//$datos='';
//
//foreach ($animal as $key=>$valor){
//        if ($key != 'id') {
//        if ($valor == null) {
//            $datos.="$key " . preg_replace('/{}/', '', $plantilla);
//        } else {
//            $datos.="$key " . preg_replace('/{}/', $valor, $plantilla);
//        }
//    }
//}
//
//echo $datos;