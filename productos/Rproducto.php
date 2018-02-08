<?php

include '../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from productos where id=$id";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);

$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>". ucwords('referencia')
        . "<input type='text' value='$animal[referencia]' readonly>"
        . "</div>"
                . "<div class='small-3 columns end'>". ucwords('nombre')
        . "<input type='text' value='$animal[nombre]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('unidad estandar')
        . "<input type='text' value='$animal[unidad_standar]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('precio promedio')
        . "<input type='text' value='$animal[precio_promedio]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('categorial')
        . "<input type='text' value='$animal[categoria]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('marca')
        . "<input type='text' value='$animal[marca]' readonly>"
        . "</div>"
         . "<div class='small-3 columns end'>". ucwords('cantidad total')
        . "<input type='text' value='$animal[cantidad_total]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('alerta minima')
        . "<input type='text' value='$animal[alerta_min]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>". ucwords('tipo semen')
        . "<input type='text' value='$animal[tipo_semen]' readonly>"
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