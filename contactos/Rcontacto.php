<?php
include '../conexion.php';
$contacto=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from contactos where id=$contacto";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);

$plantilla='<input type="text" value="{}" readonly>';
$datos='';

foreach ($animal as $key=>$valor){
    if($key!='id' and $key!='usuario' and  $key!='contrasena'){
            if($valor==null){
                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
            }else{
                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
            }
    }
}

echo $datos;