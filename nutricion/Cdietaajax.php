<?php

include '../conexion.php';
$datos=  explode(',',  $_GET[prods]);
$notas= $_GET[notas];
$dieta= $_GET[dieta];

$vegetaciones='';
$pesos='';
$sql="insert into dietas values ";
foreach ($datos as $dato){
    if($dato!==''){
    $productos.=explode('=', $dato)[0].',';
    $cantidades.=explode('=', $dato)[1].',';    
    }
}

        $sql.="(default,'$dieta','$productos','$cantidades','$notas')";
    


$insert=$conex->prepare($sql);
if($insert->execute()){
        echo '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
}else{
        echo '<div data-alert class="alert-box alert round">
 <h5 style="color:white">error al crear el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
}