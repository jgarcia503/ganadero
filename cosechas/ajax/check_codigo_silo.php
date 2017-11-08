<?php
include '../../conexion.php';
session_start();
$cod_silo=$_GET[cod_silo];
//$tot_forraje=  floatval($_GET[tot_forraje]);

$res=$conex->query("select count(referencia) from productos where referencia ='$cod_silo'")->fetch()[count];




if($res!==0){
    echo "el codigo ya existe";
}else{
    if(in_array($cod_silo, $_SESSION[codigo_silos])){
        echo "no se permiten duplicados";
    }  else {
            $_SESSION[codigo_silos][]=$cod_silo;
    }
    
}

