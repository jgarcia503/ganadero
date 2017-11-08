<?php

include '../../conexion.php';
$id= $_SERVER[QUERY_STRING];
$sql="update siembra_enc set cerrado='true' where id=$id";


try{

    $res=$conex->prepare($sql);

    if($res->execute()){

        echo 'exito';
    }
    else{
          throw new PDOException();
    }
        
}
catch(Exception $ex){

        echo 'error';
}
