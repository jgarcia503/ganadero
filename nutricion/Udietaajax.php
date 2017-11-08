<?php

include '../conexion.php';
$datos=  explode(',',  $_GET[prods]);
$notas= $_GET[notas];
$dieta= $_GET[dieta];
$dieta_id=$_GET[dieta_id];
$prods='';
$cant='';
$sql="update dietas set ";
foreach ($datos as $dato){
    if($dato!==''){
    $prods.=explode('=', $dato)[0].',';
    $cant.=explode('=', $dato)[1].',';    
    }
}

        $sql.="nombre='$dieta'"
                . ",producto='$prods'"
                . ",cantidad='$cant'"
                . ",notas='$notas' where id=$dieta_id";
    
$insert2=$conex->prepare("update suplementaciones set dieta='$dieta' where dieta='$_GET[dieta_ant]'");

$insert=$conex->prepare($sql);

try {
    $conex->beginTransaction();

    if ($insert->execute() and $insert2->execute()) {
        $conex->commit();
        echo '<div data-alert class="alert-box success round">
        <h5 style="color:white">registro actualizado exitosamente</h5>
        <a href="#" class="close">&times;</a>
        </div>';
    } else {
        throw new PDOException();
    }
} catch (PDOException $pe) {
    $conex->rollBack();
    echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al actualizar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
}    