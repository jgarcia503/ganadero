<?php

include '../conexion.php';
$datos=  explode(',',  $_GET[vegetaciones]);
$notas= $_GET[notas];
$empleado= $_GET[empleado];
$potrero= $_GET[potrero];
$fecha= $_GET[fecha];
$vegetaciones='';
$pesos='';
$sql="insert into aforos values ";
foreach ($datos as $dato){
    if($dato!==''){
    $vegetaciones.=explode('=', $dato)[0].',';
    $pesos.=explode('=', $dato)[1].',';    
    }
}

        $sql.="(default,'$fecha','$potrero','$vegetaciones','$empleado','$pesos','$notas')";
    


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
    
