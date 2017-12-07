<?php

include '../../php clases/kardex_activo.php';
$id=$_GET[id];
try{
    $conex->beginTransaction();

$sql="update compras_activo_enc set aplicada='TRUE' where id='$id' ";
$res=$conex->prepare($sql);

if($res->execute()){
    ##aqui va ir kardex, existencia,inventario
            $kardex=new kardex_activo();
            $kardex->registrar_activo($id);

                                                      $conex->commit();
    echo 'aplicada con exito';
}else{
    throw new PDOException;
    
}

}
 catch (PDOException $pe){
     $conex->rollBack();
     echo 'error al aplicar factura';
 }