<?php
session_start();
include '../../../conexion.php';
include '../../../php funciones/funciones.php';
extract($_GET);
$sql="SELECT trim(array(select producto_id from inventario_fisico_lns where enc_id=$_SESSION[ultimo_id_inv_fisico])::text,'{}')";
$res=$conex->query($sql)->fetch();
$prod_ids=  explode(',', $res[0]);
  $ultimo_id=$_SESSION['ultimo_id_inv_fisico'];
  $fecha=$_SESSION['fecha_inv_fisico_enc'];
try{
    $conex->beginTransaction();
                foreach ($_SESSION[inv_fisico] as $k=>$v){
                    if(in_array($k, $prod_ids)){
                        $sql_update="update inventario_fisico_lns set cantidad_real=$v[cant],unidad='$v[unidad_elegida]',cantidad_primera_aplicacion=$v[cant] "
                                . "where producto_id='$k' and enc_id=$ultimo_id and bodega_id=$bod_id";                
                           if(!$conex->prepare($sql_update)->execute()) {
                               throw new PDOException;
                           }

                    }else{
                        $sql_costo_prom="select precio_promedio from productos where referencia='$k'";
                        $precio_prom=$conex->query($sql_costo_prom)->fetchColumn();
                        $sql_ins="insert into inventario_fisico_lns (bodega_id,producto_id,cantidad_teorica,cantidad_real,costo,enc_id,unidad,cantidad_primera_aplicacion) "
                                          . "values($bod_id,'$k',0,$v[cant],'$precio_prom',$ultimo_id,'$v[unidad_elegida]',$v[cant])";
                        if(!$conex->prepare($sql_ins)->execute()){
                            throw new PDOException;
                        }            
                    }
                }
                include '../../../php clases/kardex.php';
                $kardex=new kardex();
                $kardex->crea_inv_fisico($ultimo_id, $fecha);
                
    $conex->commit();
}
 catch (PDOException $pe){
     $conex->rollBack();
 }


 unset($_SESSION[inv_fisico]);
 unset($_SESSION[ultimo_id_inv_fisico]);
 unset($_SESSION[fecha_inv_fisico_enc]);