<?php
include '../conexion.php';


$id_enc=$_GET[id_enc];
$lineas=$_GET[lineas];

$sql="insert into prep_tierra_lns values ";

try{
$conex->beginTransaction();

$actividad;
$costo;
$tipo;


    foreach ($lineas as $linea){
        
    $actividad=$linea[actividad];
    $costo=$linea[costo];
    $tipo=$linea[tipo];


                $valores.="(default,'$actividad','$tipo','$costo',$id_enc),";         
                }
                
                             
               $sql.=trim($valores,',');
    
               $insert=$conex->prepare($sql);
               //$actualizaestado=$conex->prepare($sql3);
               
               if($insert->execute()){                                                                                                                                              
                            
                                                $conex->commit();
                                                echo '<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
                                            
                      
               }else{
                       throw new PDOException();
               }   
        
   }
 catch (PDOException $pe){
         $conex->rollBack();
        echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
 }