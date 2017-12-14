<?php

include '../../conexion.php';
$id=$_SERVER[QUERY_STRING];
$sql="select * from analisis_leche where id=$id";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);

$plantilla='<input type="text" value="{}" readonly>';
$datos='';

foreach ($animal as $key=>$valor){
if($key!='id'){
    $key=ucwords(preg_replace('/_/', ' ', $key));
            if($valor==null){
                
                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
            }else{
                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
            }
}
}

echo $datos;