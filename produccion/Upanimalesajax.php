<?php

include '../conexion.php';

$datos=  explode(',', trim($_GET[pesos],','));
$notas=$_GET[notas];
$fecha=$_GET[fecha];
$empleado=$_GET[empleado];
$sql="update bit_peso_animal set ";
$numeros='';
$nombres='';
$pesajes='';
foreach ($datos as $valores){
$numeros.=explode('=', $valores)[0].',';
$nombres.=explode('=', $valores)[1].',';
$pesajes.=explode('=', $valores)[2].',';

}

$sql.="fecha='$fecha',empleado='$empleado',numero='$numeros',nombre='$nombres',peso='$pesajes',notas='$notas' where id=$_GET[id]";

$insert=$conex->prepare($sql);
if($insert->execute()){
        echo '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro actualizado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
}else{
        echo '<div data-alert class="alert-box alert round">
 <h5 style="color:white">error al actualizar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
}
    



