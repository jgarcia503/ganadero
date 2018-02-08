<?php

include '../conexion.php';
$raza=base64_decode($_SERVER[QUERY_STRING]);
$sql="select nombre,notas from razas where id=$raza";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);


$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>".  array_keys($animal,$animal[nombre])[0]
        . "<input type='text' value='$animal[nombre]' readonly>"
        . "</div>"
        . "</div>"
        . "<div class='row'>"
        . "<div class='small-12 columns'>".  array_keys($animal,$animal[notas])[0]
        . "<textarea readonly >$animal[notas]</textarea>"
        . "</div>"
        . "</div>";

echo $plantilla;