<?php

include '../conexion.php';
session_start();
$id= explode("=",base64_decode($_SERVER[QUERY_STRING]))[1];

$checksql="select evento from controles_sanitarios  where evento in (select nombre from eventos_sanitarios  where id=$id)";
if($conex->query($checksql)->rowCount()>0){
    $_SESSION['error']='no se puede eliminar';
}else{
$sql="delete from eventos_sanitarios where id=$id";

$conex->query($sql);
}
header("location:$_SERVER[HTTP_REFERER]");