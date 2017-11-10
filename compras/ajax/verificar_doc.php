<?php

include '../../conexion.php';

$no_doc=$_GET[no_doc];
$tipo_doc=$_GET[tipo_doc];

$sql="select * from compras_enc where tipo_doc ='$tipo_doc' and doc_no = '$no_doc'";

$res=$conex->query($sql);

if(count($res->fetchAll())!==0){
    echo 'ya existe';
}
