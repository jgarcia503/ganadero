<?php
include '../conexion.php';
$color=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from colores where id=$color";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);


$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>".  array_keys($animal,$animal[nombre])[0]
        . "<input type='text' value='$animal[nombre]' readonly>"
        . "</div>"
        . "</div>";

echo $plantilla;