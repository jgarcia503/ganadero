<?php

include '../conexion.php';

$datos=  explode(',', trim($_GET[pesos],','));
$notas=$_GET[notas];
$fecha=$_GET[fecha];
$empleado=$_GET[empleado];
$sql="insert into bit_peso_animal ";
$numeros='';
$nombres='';
$pesajes='';
foreach ($datos as $valores){
$numeros.=explode('=', $valores)[0].',';
$nombres.=explode('=', $valores)[1].',';
$pesajes.=explode('=', $valores)[2].',';

}

$sql.="values(default,'$fecha','$empleado','$numeros','$nombres','$pesajes','$notas')";

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
    



