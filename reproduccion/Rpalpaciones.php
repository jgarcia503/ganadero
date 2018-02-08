<?php

include '../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from palpaciones where id=$id";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);
$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>".  array_keys($animal,$animal[fecha])[0]
        . "<input type='text' value='$animal[fecha]' readonly>"
        . "</div>"
       . "<div class='small-3 columns'>". ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[animal])[0]))
        . "<input type='text' value='$animal[animal]' readonly>"
        . "</div>"
       . "<div class='small-3 columns'>".ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[resultado])[0]))
        . "<input type='text' value='$animal[resultado]' readonly>"
        . "</div>"
       . "<div class='small-3 columns'>".  ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[palpador])[0]))
        . "<input type='text' value='$animal[palpador]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>".  ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[dias_prenez])[0]))
        . "<input type='text' value='$animal[dias_prenez]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>".  ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[prenada])[0]))
        . "<input type='text' value='$animal[prenada]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>".  ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[cuerno])[0]))
        . "<input type='text' value='$animal[cuerno]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>".  ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[nivel_suciedad])[0]))
        . "<input type='text' value='$animal[nivel_suciedad]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>".  ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[meses_prenez])[0]))
        . "<input type='text' value='$animal[meses_prenez]' readonly>"
        . "</div>"
        . "</div>"
        ."<div class='row'>"
       . "<div class='small-12 columns'>".  ucwords( preg_replace('/_/',' ',array_keys($animal,$animal[notas])[0]))
        . "<textarea readonly>$animal[notas]</textarea>"
        . "</div>"        
        . "</div>";

//echo $plantilla;

$plantilla='<input type="text" value="{}" readonly>';
$datos='';

foreach ($animal as $key=>$valor){
    if($key!='id'){
            if($valor==null){
                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
            }else{
                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
            }
    }
}

echo $datos;