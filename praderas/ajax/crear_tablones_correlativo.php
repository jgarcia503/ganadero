<?php

include '../../conexion.php';
$id_terreno=$_GET[id_terreno];
$sql="select count(*)+1  from tablones where terreno_id='$id_terreno'";
$sigte=$conex->query($sql)->fetchColumn();



$sql_extension_disponible="select (select extension::numeric(10,2) from potreros where id=$id_terreno)-coalesce(sum(extension::numeric(10,2)),0) from tablones where terreno_id ='$id_terreno'";
$dispo=$conex->query($sql_extension_disponible)->fetchColumn();

$datos=[];
$datos['sigte']=$sigte;
$datos['dispo']=$dispo;

echo json_encode($datos);