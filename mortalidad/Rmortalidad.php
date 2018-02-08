<?php

include '../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from mortalidades where id=$id";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);

$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>". ucwords('fecha')
        . "<input type='text' value='$animal[fecha]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('hora')
        . "<input type='text' value='$animal[hora]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('animal')
        . "<input type='text' value='$animal[animal]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('causa')
        . "<input type='text' value='$animal[causa]' readonly>"
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