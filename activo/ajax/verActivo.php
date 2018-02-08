<?php

include '../../conexion.php';
$id=$_GET[id];
$sql="select * from activo where id=$id";
$res=$conex->query($sql);

$animal=$res->fetch(PDO::FETCH_ASSOC);

$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>". ucwords('referencia')
        . "<input type='text' value='$animal[referencia]' readonly>"
        . "</div>"
                . "<div class='small-3 columns end'>". ucwords('nombre')
        . "<input type='text' value='$animal[nombre]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('precio promedio')
        . "<input type='text' value='$animal[precio_promedio]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('marca')
        . "<input type='text' value='$animal[marca]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('cantidad total')
        . "<input type='text' value='$animal[cantidad_total]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('vida util')
        . "<input type='text' value='$animal[vida_util]' readonly>"
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