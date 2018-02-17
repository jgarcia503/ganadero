<?php

require_once '../../conexion.php';
//require_once '../../php funciones/funciones.php';
extract($_GET);
   $datos=[];
$sql_enc="insert into traslados_enc values (default,'$fecha',now(),'$bod_org','$bod_dst','',trim('$notas')) returning id";
$res=$conex->prepare($sql_enc);

if($res->execute()){
     $id=$res->fetchColumn();
             $datos['id']=$id;
            $datos['ok']= '<div data-alert class="alert-box success round">
            <h5 style="color:white">registro creado exitosamente</h5>
            <a href="#" class="close">&times;</a>
            </div>';            
}else{
       $datos['error']= '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
}
     echo json_encode($datos);
     
     #guardar en  sesion y en tabla traslados_lns (similar que compras_lns)   
     #cuando se aplica verificar que los valores en tabla lineas sean menores de los que hay en existencias sino no dejar ingresar
     #y decirle cual producto es 