<?php

include '../../conexion.php';
$mensajes=[];
if($_POST[estado]!=='muerto'){
    $insert=$conex->prepare("insert into animales (numero,nombre,fecha_nacimiento,peso_nacimiento,sexo,estado) 
                                values('$_POST[numero]','$_POST[nombre]','$_POST[fec_nac]','$_POST[peso_nac]','$_POST[sexo]'"
                                                            . ",'$_POST[estado]')");
                            if($insert->execute()){
                                               $mensaje[resp]= 'exito';
                            }else{
                                               $mensaje[resp] ='error';
                            }                            
}
    $mensaje[valores]= "<input type='hidden' value='$_POST[estado]' name='estado'>". "<input type='hidden' value='$_POST[sexo]' name='sexo'>";
    
   
echo json_encode($mensaje);
