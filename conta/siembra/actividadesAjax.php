<?php

try{
include '../../conexion.php';

$lineas=$_GET[lineas];
$siembra_id_enc=$_GET[id_siembra];
$sql2="insert into siembra_lns values ";
$valores='';
    foreach ($lineas as $linea){
        
    $actividad=$linea[actividad];
    $costo=$linea[costo];
    $tipo=$linea[tipo];

        
                        
                                            
                $valores.="(default,'$actividad','$tipo','$costo',$siembra_id_enc),";         
                }
                

 $sql2.=trim($valores,',');
    
               $insert=$conex->prepare($sql2);
               
               
                            if($insert->execute()){                                                                                                                                              
                    
                                                echo '<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
                                            
                      
               }else{
                       throw new PDOException();
               }
               
} catch (PDOException $pe){
         $conex->rollBack();
        echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
 }
 catch (Exception $ex){
     echo 'hubo algun error';
 }