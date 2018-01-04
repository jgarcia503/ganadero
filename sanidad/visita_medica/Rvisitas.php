<?php

include '../../conexion.php';
$id=$_GET[id];
$sql="select descripcion from visita_medica where id=$id";
$res=$conex->query($sql)->fetchColumn();
echo "<h3>tratamiento</h3>";
echo "<textarea cols=50 rows=50 readonly style='resize:none'>$res</textarea>";
?>
<style>
    *{
        border: 
    }
</style>