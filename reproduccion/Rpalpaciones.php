<?php

include '../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from palpaciones where id=$id";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);
$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>". ucwords('fecha')
        . "<input type='text' value='$animal[fecha]' readonly>"
        . "</div>"
       . "<div class='small-3 columns'>". ucwords( 'animal')
        . "<input type='text' value='$animal[animal]' readonly>"
        . "</div>"
       . "<div class='small-3 columns'>".ucwords( 'resultado')
        . "<input type='text' value='$animal[resultado]' readonly>"
        . "</div>"
       . "<div class='small-3 columns'>".  ucwords( 'palpador')
        . "<input type='text' value='$animal[palpador]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>".  ucwords( 'dias preñez')
        . "<input type='text' value='$animal[dias_prenez]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>".  ucwords(preñada)
        . "<input type='text' value='$animal[prenada]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>".  ucwords( 'cuerno uterino')
        . "<input type='text' value='$animal[cuerno]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>".  ucwords( 'nivel suciedad')
        . "<input type='text' value='$animal[nivel_suciedad]' readonly>"
        . "</div>"
        . "<div class='small-3 columns end'>".  ucwords('mese preñez')
        . "<input type='text' value='$animal[meses_prenez]' readonly>"
        . "</div>"
        . "</div>"
        ."<div class='row'>"
       . "<div class='small-12 columns'>".  ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[notas])[0]))
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