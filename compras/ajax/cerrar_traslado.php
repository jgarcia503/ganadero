<?php

include '../../conexion.php';
extract($_GET);
$sql="update traslados_enc set costo_total='$total' where id=$id_enc";
$conex->prepare($sql)->execute();