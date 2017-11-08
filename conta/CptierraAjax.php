<?php

include '../conexion.php';

$fecha_fin=$_GET[fecha_fin];
$fecha_inicio=$_GET[fecha_inicio];

$nombre=$_GET[nombre];
$potrero=$_GET[potrero];
$tipo_cultivo=$_GET[tipo_cultivo];
$notas=$_GET[notas];
$lineas=$_GET[lineas];
$potrero_id=$_GET[potrero_id];
$sql="insert into prep_tierra_enc values(default,'$nombre','$fecha_inicio','$fecha_fin','$potrero','$tipo_cultivo','false',trim('$notas')) returning id";
$sql2="insert into prep_tierra_lns values ";
$sql3="update potrero set estado='ocupado' where id=$potrero_id";
try{
$conex->beginTransaction();
$insert=$conex->prepare($sql);
$actividad;
$costo;
$tipo;

if($insert->execute()){//insercion en bit_peso_leche_enc 
    $ultimo_id=$insert->fetch()[id];
    foreach ($lineas as $linea){
        
    $actividad=$linea[actividad];
    $costo=$linea[costo];
    $tipo=$linea[tipo];


                $valores.="(default,'$actividad','$tipo','$costo',$ultimo_id),";         
                }
                
                             
               $sql2.=trim($valores,',');
    
               $insert=$conex->prepare($sql2);
               $actualizaestado=$conex->prepare($sql3);
               
               if($insert->execute() and $actualizaestado->execute()){                                                                                                                                              
                            
                                                $conex->commit();
                                                echo '<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
                                            
                      
               }else{
                       throw new PDOException();
               }   
        }
   }
 catch (PDOException $pe){
         $conex->rollBack();
        echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
 }
