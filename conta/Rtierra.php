<?php
include '../conexion.php';
$color=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from prep_tierra_enc where id=$color";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);

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