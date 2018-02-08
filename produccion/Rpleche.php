<?php

include '../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from pesos_leches where id=$id";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);
$plantilla="<div class='row'>"
        . "<div class='small-4 columns'>".  array_keys($animal,$animal[empleado])[0]
        . "<input type='text' value='$animal[empleado]' readonly>"
        . "</div>"
       . "<div class='small-4 columns'>". ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[fecha])[0]))
        . "<input type='text' value='$animal[fecha]' readonly>"
        . "</div>"
       . "<div class='small-4 columns'>".ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[animal])[0]))
        . "<input type='text' value='$animal[animal]' readonly>"
        . "</div>"
        . "</div>"
        . "<div class='row'>"        
       . "<div class='small-2 columns'>".  ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[peso])[0]))
        . "<input type='text' value='$animal[peso]' readonly>"
        . "</div>"
        . "<div class='small-2 columns end'>".  ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[hora])[0]))
        . "<input type='text' value='$animal[hora]' readonly>"
        . "</div>"
        . "</div>"
        . "<div class=row>"
        . "<div class='small-12 columns'>". ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[notas])[0]))
        . "<textarea readonly >$animal[notas]</textarea>"
        . "</div>"
        . "</div>";

echo $plantilla;
//$plantilla='<input type="text" value="{}" readonly>';
//$datos='';
//
//foreach ($animal as $key=>$valor){
//    if($key!='id'){
//            if($valor==null){
//                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
//            }else{
//                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
//            }
//    }
//}
//
//echo $datos;