<?php
include '../conexion.php';

$id= base64_decode($_SERVER[QUERY_STRING]);
$sql="delete from bit_peso_leche_enc where id=$id";
$sql2="delete from bit_peso_leche_lns where id_enc=$id";

$conex->query($sql);
$conex->query($sql2);

header("location:$_SERVER[HTTP_REFERER]");