<?php
session_start();
include '../../php funciones/funciones.php';
include '../../conexion.php';
$cant_conv=convertir($_GET[unidad], $_GET[cant]);
$ref=$_GET[ref];
$mensaje=[];
if($_SESSION['traslado'][$ref]<$cant_conv) {
    $mensaje[mensaje]= "cantidad insuficiente hay ".$_SESSION['traslado'][$ref];
}else{
    $sql_costo_unit="select precio_promedio from productos where referencia='$ref'";
    $precio_prom=  floatval($conex->query($sql_costo_unit)->fetch()[precio_promedio]);
    $mensaje[cant]=  $precio_prom;
    $mensaje[importe]=$cant_conv*$precio_prom;
}

echo json_encode($mensaje);