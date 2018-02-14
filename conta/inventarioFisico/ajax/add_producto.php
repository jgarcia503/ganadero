<?php
include '../../../conexion.php';
session_start();
extract($_GET);
$sql="select * from productos where referencia='$ref'";
$res=$conex->query($sql)->fetch(PDO::FETCH_ASSOC);

$_SESSION[inv_fisico][$ref]=array('nombre'=>$res[nombre],'unidad_elegida'=>$unidad,'precio_prom'=>$res[precio_promedio],'cant'=>$cant);

echo json_encode($_SESSION[inv_fisico]);
