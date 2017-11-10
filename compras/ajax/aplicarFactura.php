<?php

include '../../conexion.php';
include '../../php clases/kardex.php';
$id=$_GET[id];
try{
    $conex->beginTransaction();

$sql="update compras_enc set aplicada='TRUE' where id='$id' ";
$res=$conex->prepare($sql);

if($res->execute()){
    ##aqui va ir kardex, existencia,inventario
            $kardex=new kardex();
                                                      $kardex->actualiza_inventario('+',$id);
                                                      $kardex->actualiza_existencias( $id);
                                                      $kardex->actualiza_kardex($id);
                                                      $conex->commit();
    echo 'aplicada con exito';
}else{
    throw new PDOException;
    
}

}
 catch (PDOException $pe){
     echo 'error al aplicar factura';
 }