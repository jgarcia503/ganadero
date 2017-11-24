<?php

include '../../conexion.php';

$cod=$_GET[cod];

$res=$conex->query("select * from productos where referencia ='$cod' ");
if(count($res->fetchAll())!==0){
    echo 'ya existe';
}
