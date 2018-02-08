<?php

include '../../conexion.php';
$lote=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from grupos where id=$lote";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);
$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>".  array_keys($animal,$animal[nombre])[0]
        . "<input type='text' value='$animal[nombre]' readonly>"
        . "</div>"
       . "<div class='small-3 columns'>". ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[clasificacion])[0]))
        . "<input type='text' value='$animal[clasificacion]' readonly>"
        . "</div>"
       . "<div class='small-3 columns'>".ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[produccion_minima])[0]))
        . "<input type='text' value='$animal[produccion_minima]' readonly>"
        . "</div>"
       . "<div class='small-3 columns'>".  ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[dias_nac])[0]))
        . "<input type='text' value='$animal[dias_nac]' readonly>"
        . "</div>"
        . "</div>";

echo $plantilla;
//$plantilla='<input type="text" value="{}" readonly>';
//$datos='';
//
//foreach ($animal as $key=>$valor){
//    if($key!=='id'){
//    if($valor==null){
//        $datos.="$key ".preg_replace('/{}/', '', $plantilla);
//    }else{
//        $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
//            }
//    }
//}
//
//echo $datos;