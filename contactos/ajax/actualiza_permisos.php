<?php

include '../../conexion.php';
$id_usr=$_GET[id_usuario];
unset($_GET[id_usuario]);
foreach ($_GET as $k=>$v){
    $id_url=  explode('-', $k)[1];
    $sql="update menu_permisos set nivel=$v where id_url=$id_url and id_usuario=$id_usr";
    $conex->prepare($sql)->execute();
    
}
echo 'exito debe salir para que surgan efecto los cambios';