<?php
include '../conexion.php';

$id= explode("=",base64_decode($_SERVER[QUERY_STRING]))[1];
$sql="delete from animales where id=$id";
$sqlfoto="select fotos from animales where id=$id";
$resfoto=$conex->query($sqlfoto);
$foto=$resfoto->fetch();
$ruta=$_SERVER['DOCUMENT_ROOT'].'/ganadero/img_animales/'.$foto[fotos];

unlink($ruta);

$conex->query($sql);

header("location:$_SERVER[HTTP_REFERER]");