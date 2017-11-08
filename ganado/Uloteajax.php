<?php


include '../conexion.php';

$insert=$conex->prepare("update lotes set nombre='$_POST[lote]',animales='$_POST[animales]',notas=trim('$_POST[notas]') where id=$_POST[id]");

if($insert->execute()){
    echo '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro actualizado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
}
else{
    echo '<div data-alert class="alert-box alert round">
 <h5 style="color:white">error al actualizar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
}


