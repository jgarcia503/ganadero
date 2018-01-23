<?php

include '../../conexion.php';
include '../../php funciones/funciones.php';

extract($_GET);
$conex->beginTransaction();
$sql_alimen_enc="insert into plantilla_productos_enc values (default,'$tipo','$empleado','$fecha') returning id";
$ultimo_id;
$stm=$conex->prepare($sql_alimen_enc);
if($stm->execute()){
    $ultimo_id=$stm->fetchColumn();
}
$sql_alimen_lns="insert into plantilla_productos_lns values ";
$tmp='';
foreach ($lineas as  $value) {
    
        $tmp.="(default,'$value[id_producto]','$value[cantidad]','$value[unidad]','$ultimo_id'),";
    
}
$tmp=  trim($tmp,',');
$sql_alimen_lns.=$tmp;
if($conex->prepare($sql_alimen_lns)->execute()){
    $conex->commit();
                                          echo '<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
}else{
    $conex->rollBack();
          echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';         
}