<?php

include '../conexion.php';
$contacto=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from tratamientos_enc where id=$contacto";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);
$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>". ucwords('fecha')
        . "<input type='text' value='$animal[fecha]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('animal')
        . "<input type='text' value='$animal[animal]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('descripcion tratamiento')
        . "<input type='text' value='$animal[descripcion_tratamiento]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('tipo tratamiento')
        . "<input type='text' value='$animal[tipo_tratamiento]' readonly>"
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