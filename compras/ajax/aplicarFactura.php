<?php

include '../../conexion.php';

$id=$_GET[id];

$sql="update compras_enc set aplicada='TRUE' where id='$id' ";
$res=$conex->prepare($sql);

if($res->execute()){
    ##aqui va ir kardex, existencia,inventario
    echo 'aplicada con exito';
}else{
    echo 'error al aplicar factura';
}

