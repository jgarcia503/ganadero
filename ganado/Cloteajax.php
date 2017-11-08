<?php

include '../conexion.php';

$insert=$conex->prepare("insert into lotes values(default,'$_POST[lote]','$_POST[animales]',trim('$_POST[notas]'))");

if($insert->execute()){
    echo '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
}
else{
    echo '<div data-alert class="alert-box alert round">
 <h5 style="color:white">error al crear el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
}


