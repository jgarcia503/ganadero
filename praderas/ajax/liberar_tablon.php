<?php

include '../../conexion.php';

$id=$_SERVER[QUERY_STRING];
$sql="update tablones set estatus='libre' where id=$id";

$stm=$conex->prepare($sql);

if($stm->execute()){
    echo "exito";
}else{
    echo 'error';
}