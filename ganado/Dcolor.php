<?php
include '../conexion.php';
session_start();
$id= explode("=",base64_decode($_SERVER[QUERY_STRING]))[1];
$checksql="select color from animales where color in (select nombre from colores where id=$id)";
if($conex->query($checksql)->rowCount()>0){
    $_SESSION['error']='no se puede eliminar ya existe un animal con este color';
}else{
$sql="delete from colores where id=$id";
$conex->query($sql);
}
header("location:$_SERVER[HTTP_REFERER]");