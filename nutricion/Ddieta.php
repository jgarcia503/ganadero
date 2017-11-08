<?php

include '../conexion.php';
session_start();
$id= explode("=",base64_decode($_SERVER[QUERY_STRING]))[1];
$checksql="select dieta from suplementaciones  where dieta in (select nombre from dietas where id=$id)";

if($conex->query($checksql)->rowCount()>0){
    $_SESSION['error']='no se puede eliminar';
}else{
$sql="delete from dietas where id=$id";

$conex->query($sql);
}
header("location:$_SERVER[HTTP_REFERER]");