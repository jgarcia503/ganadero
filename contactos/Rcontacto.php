<?php
include '../conexion.php';
$contacto=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from contactos where id=$contacto";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);
$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>". ucwords('identificacion')
        . "<input type='text' value='$animal[identificacion]' readonly>"
        . "</div>"
                . "<div class='small-3 columns end'>". ucwords('tipo')
        . "<input type='text' value='$animal[tipo]' readonly>"
        . "</div>"
                        . "<div class='small-3 columns end'>". ucwords('telefono')
        . "<input type='text' value='$animal[telefono]' readonly>"
        . "</div>"
                        . "<div class='small-3 columns end'>". ucwords('direccion')
        . "<input type='text' value='$animal[direccion]' readonly>"
        . "</div>"
                        . "<div class='small-3 columns end'>". ucwords('nombre')
        . "<input type='text' value='$animal[nombre]' readonly>"
        . "</div>"
                        . "<div class='small-3 columns end'>". ucwords('correo')
        . "<input type='text' value='$animal[correo]' readonly>"
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
//    if($key!='id' and $key!='usuario' and  $key!='contrasena'){
//            if($valor==null){
//                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
//            }else{
//                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
//            }
//    }
//}
//
//echo $datos;