<?php
include '../conexion.php';
session_start();
$id= explode("=",base64_decode($_SERVER[QUERY_STRING]))[1];

#verificacion antes de eliminar
$checksql="select raza from animales where raza in (select nombre from razas where id=$id)";
if($conex->query($checksql)->rowCount()>0){
    $_SESSION['error']='no se puede eliminar ya existe un animal de esta raza';
}else{
$sql="delete from razas where id=$id";

$conex->query($sql);
}
header("location:$_SERVER[HTTP_REFERER]");

