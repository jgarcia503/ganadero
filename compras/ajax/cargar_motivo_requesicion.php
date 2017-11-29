<?php
include '../../conexion.php';

$sql="select * from motivos_requesiciones where id=$_GET[id]";

$res=$conex->query($sql)->fetch(PDO::FETCH_ASSOC);

echo json_encode($res);