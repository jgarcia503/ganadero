<?php

include '../conexion.php';
session_start();
$id= explode("=",base64_decode($_SERVER[QUERY_STRING]))[1];

$checksql="select potrero from aforos where potrero in (select nombre from potreros where id=$id)";
$checksql2="select potrero from control_potreros where potrero in (select nombre from potreros where id=$id)";

if($conex->query($checksql)->rowCount()>0 or $conex->query($checksql2)->rowCount()>0  ){
    $_SESSION['error']='no se puede eliminar';
}else{
$sql="delete from potreros where id=$id";

$conex->query($sql);
}
header("location:$_SERVER[HTTP_REFERER]");