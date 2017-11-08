<?php

include '../conexion.php';
$datos=  explode(',',  $_GET[vegetaciones]);
$notas= $_GET[notas];
$empleado= $_GET[empleado];
$potrero= $_GET[potrero];
$fecha= $_GET[fecha];
$aforo_id=$_GET[aforo_id];
$vegetaciones='';
$pesos='';
$sql="update aforos set ";
foreach ($datos as $dato){
    if($dato!==''){
    $vegetaciones.=explode('=', $dato)[0].',';
    $pesos.=explode('=', $dato)[1].',';    
    }
}

        $sql.="fecha='$fecha'"
                    . ",potrero='$potrero'"
                    . ",vegetacion='$vegetaciones'"
                    . ",empleado='$empleado'"
                    . ",peso='$pesos'"
                    . ",notas='$notas' where id=$aforo_id";
    


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
    
