<?php
session_start();
include '../../../conexion.php';
extract($_GET);
$conex->beginTransaction();
$inse_enc=$conex->prepare("insert into inventario_fisico_enc(id,fecha,bodega_id,usuario_id,fecha_hora,en_proceso) values (default,'$fecha',$bod_id,$usuario_id,now(),'true') returning id");
if($inse_enc->execute()){
    $ultimo_id=$inse_enc->fetchColumn();
    $sql="insert into inventario_fisico_lns(bodega_id,producto_id,cantidad_teorica,costo,enc_id) 
select $bod_id bodega_id
,b.referencia
,a.existencia
,b.precio_promedio costo
,$ultimo_id
from existencias a 
        inner join productos b on a.codigo_producto=b.referencia  where codigo_bodega =$bod_id";
    if($conex->prepare($sql)->execute()){
        $conex->commit();
        echo 'true';
        $_SESSION['ultimo_id_inv_fisico']=$ultimo_id;
        $_SESSION['fecha_inv_fisico_enc']=$fecha;
    }else{
        $conex->rollBack();
        echo 'false';
    }
}