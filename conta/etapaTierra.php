<?php

include '../conexion.php';


$sql="update prep_tierra_enc set cerrado='true' where id=$_SERVER[QUERY_STRING]";


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
