<?php
include '../../conexion.php';
$color=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from siembra_enc where id=$color";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);

$plantilla='<input type="text" value="{}" readonly>';
$datos='';

foreach ($animal as $key=>$valor){
    if($key!='id' and $key !='etapa_ant'){
          $key= ucwords(preg_replace('/_/', ' ', $key));
            if($valor==null){
                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
            }else{
                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
            }
    }
}

echo $datos;