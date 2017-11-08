<?php

include '../conexion.php';
$datos=  explode(',',  $_GET[productos]);
$notas= $_GET[notas];
$tipo= $_GET[tipo];
$potrero= $_GET[potrero];
$fecha= $_GET[fecha];
$productos='';
$cantidad='';
$sql="insert into control_potreros values ";
foreach ($datos as $dato){
    if($dato!==''){
    $productos.=explode('=', $dato)[0].',';
    $cantidad.=explode('=', $dato)[1].',';    
    }
}

        $sql.="(default,'$potrero','$tipo','$productos','$fecha','$cantidad','$notas')";
    


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