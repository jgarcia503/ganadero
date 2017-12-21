<?php

include '../../conexion.php';
$val= $_GET[val];
$sql="select valor_puntos from puntos_grasa where porcentaje ='$val'";
echo $conex->query($sql)->fetchColumn();
