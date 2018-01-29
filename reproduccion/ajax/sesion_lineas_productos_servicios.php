<?php
session_start();
include '../../conexion.php';

if($_SERVER[REQUEST_METHOD]==='GET'){
extract($_GET);

if (!$remover) {
    $res = $conex->query("select a.producto_id, b.nombre ,a.cantidad,a.unidad from plantilla_servicios_requisicion_lns a join productos b 
on b.referencia=a.producto_id
  where enc_id='$id_enc' and a.producto_id='$id_prod'")->fetchAll();

    if (count($res) !== 0) {
        $_SESSION[productos_servicios][$id_prod] = array('nombre' => $res[0][nombre], 'cantidad' => $cant, 'unidad' => $unidad);
    } else {
        $_SESSION[productos_servicios][$id_prod] = array('nombre' => $nombre, 'cantidad' => $cant, 'unidad' => $unidad);
    }
} else {
    unset($_SESSION[productos_servicios][$id_prod]);
}
}
if($_SERVER[REQUEST_METHOD]==='POST'){
    extract($_POST);
        $res = $conex->query("select * from plantilla_servicios_requisicion_lns where enc_id='$id_enc'")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res as $consulta){
            $encontrado = false;
            $cantidad = 0;
            $unidad = "";
            foreach ($_SESSION[productos_servicios] as $k=>$v){
                               $producto_id = $consulta[producto_id];
                if($consulta[producto_id] == $k){
                    //Asignar valores
                    $encontrado = true;
                    $cantidad = $v[cantidad];
                    $unidad = $v[unidad];
     
                }
            }
            if($encontrado){
                $sql_update="update plantilla_servicios_requisicion_lns set cantidad='$cantidad', unidad='$unidad' where producto_id='$producto_id' and enc_id=$id_enc";
                $conex->prepare($sql_update)->execute();
               
            }else{
                $sql_eliminar="delete from plantilla_servicios_requisicion_lns where enc_id=$id_enc and producto_id='$producto_id'";
                $conex->prepare($sql_eliminar)->execute();
            }
        }
         $sql_update2="update plantilla_servicios_requisicion_enc set fecha_modificacion=now(),usuario='$_SESSION[usuario]'   where id_tipo=$id_enc";
                $conex->prepare($sql_update2)->execute();

    ##insertar 
    foreach ($_SESSION[productos_servicios] as $k=>$v){
            $sql_check="select * from plantilla_servicios_requisicion_lns where enc_id=$id_enc and producto_id='$k'";
            $res_check=$conex->query($sql_check)->fetchAll();
            if(count($res_check)===0){
                $sql_ins="insert into plantilla_servicios_requisicion_lns values(default,'$k','$v[cantidad]','$v[unidad]',$id_enc)";
                $conex->prepare($sql_ins)->execute();
            }
    }
    
}

echo json_encode($_SESSION[productos_servicios]);
