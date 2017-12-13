<?php

include '../../conexion.php';
$tipo_id=$_GET[tipo_id];

$sql="select a.* from vegetaciones a inner join tipo_vegetacion b on a.id_tipo_cultivo::integer=b.id
where id_tipo_cultivo='$tipo_id'";
$res=$conex->query($sql);
$opciones='<option value="">seleccione</option>';
while($fila=$res->fetch()){
    $opciones.="<option value='$fila[id]'>$fila[nombre]</option>";
}

echo $opciones;