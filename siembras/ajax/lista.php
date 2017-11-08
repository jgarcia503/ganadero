<?php
include '../../conexion.php';
$potrero_id=$_GET[pot_id];

$sql="select * from tablones where terreno_id='$potrero_id' and estatus='libre'";
$res=$conex->query($sql);
$opciones='';
while($fila=$res->fetch()){
    $opciones.="<option value='$fila[id]'>$fila[nombre]</option>";
}
if(strlen($opciones)==0){
    echo 'no hay tablones creados';
}else{
echo $opciones;
}