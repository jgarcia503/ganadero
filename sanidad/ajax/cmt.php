<?php

include '../../conexion.php';

$sql="insert into pruebas_cmt values ";

$fecha=$_GET[fecha];

unset($_GET[fecha]);
foreach($_GET as $value){
    foreach($value as $linea){
        $is_fecha=true;
        $sql.="(default,";
        foreach($linea as $valor){
            $sql.="'$valor',";
            $sql.=$is_fecha ? "'$fecha',":'';
            $is_fecha=false;
        }
        $sql=trim($sql,',');
        $sql.="),";
    }
    
}

$sql=trim($sql,',');
if($conex->prepare($sql)->execute()){
       echo '<div data-alert class="alert-box success round">
            <h5 style="color:white">registro creado exitosamente</h5>
            <a href="#" class="close">&times;</a>
            </div>';
}else{
         echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
}