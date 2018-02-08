<?php
include '../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from servicios where id=$id";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);
$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>". ucwords('fecha')
        . "<input type='text' value='$animal[fecha]' readonly>"
        . "</div>"
                . "<div class='small-3 columns end'>". ucwords('hora')
        . "<input type='text' value='$animal[hora]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('animal')
        . "<input type='text' value='$animal[animal]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('tipo')
        . "<input type='text' value='$animal[tipo]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('inseminador')
        . "<input type='text' value='$animal[inseminador]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('padre')
        . "<input type='text' value='$animal[padre]' readonly>"
        . "</div>"
         . "<div class='small-3 columns end'>". ucwords('donadora')
        . "<input type='text' value='$animal[donadora]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('codigo pajilla')
        . "<input type='text' value='$animal[codigo_pajilla]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('hora visualizacion celo')
        . "<input type='text' value='$animal[hora_visualizacion_celo]' readonly>"
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
//    
//            
//     }
//}
//
//echo $datos;