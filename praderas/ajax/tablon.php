<?php

include '../../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);

$sql="select * from tablones where id=$id";
$res=$conex->query($sql)->fetch(PDO::FETCH_ASSOC);

$plantilla='<input type="text" value="{}" readonly>';
$datos='';

foreach ($res as $key=>$valor){
    if($key!='id' and $key!='terreno_id'){
            if($valor==null){
                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
            }else{
                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
            }
    }
}

echo $datos;