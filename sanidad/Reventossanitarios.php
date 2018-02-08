<?php

include '../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from eventos_sanitarios where id=$id";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);

$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>". ucwords('nombre')
        . "<input type='text' value='$animal[nombre]' readonly>"
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