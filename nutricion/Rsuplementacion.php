<?php

include '../conexion.php';
$suple=base64_decode($_SERVER[QUERY_STRING]);
$sql="select a.fecha,b.nombre grupo,c.nombre dieta,d.nombre bodega from suplementaciones_enc a
join grupos b on b.id::text=a.grupo_id
join alimentacion_enc c on c.id::text=a.dieta_id
join bodega d on d.codigo::text=a.bodega_id where a.id=$suple";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);
$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>". ucwords('fecha')
        . "<input type='text' value='$animal[fecha]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('grupo')
        . "<input type='text' value='$animal[grupo]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('dieta')
        . "<input type='text' value='$animal[dieta]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('bodega')
        . "<input type='text' value='$animal[bodega]' readonly>"
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