<?php
include '../conexion.php';
$fecha=$_GET[datos][fecha];
$animal=$_GET[datos][animal];
$notas=$_GET[datos][notas];
$lineas=$_GET[datos][lineas];
$tipo=$_GET[datos][tipo];
$descripcion=$_GET[datos][descripcion];

$sql="insert into tratamientos_enc values(default,'$fecha','$animal','$descripcion','$tipo',trim('$notas')) returning id";
$sql2="insert into tratamientos_lns values ";

try{
$conex->beginTransaction();
$insert=$conex->prepare($sql);
$decrease_inv=[];

if($insert->execute()){
    $ultimo_id=$insert->fetch()[id];
    foreach ($lineas as $linea){
                $nombre=$linea[producto];
                $cantidad=$linea[cant];
                $medida=$linea[medida];
                $desde=$linea[desde];
                $hasta=$linea[hasta];
                $frecuencia=$linea[veces];
                                            $f1 = new DateTime($desde);
                                            $f2  = new DateTime($hasta);
                                            $dias = $f2->diff($f1)->days;
   
                $valores.="(default,'$nombre','$cantidad','$desde','$hasta','$medida','$frecuencia',$ultimo_id),";      
                $decrease_inv[$nombre]=($cantidad*$frecuencia*$dias);                
                }

                             
               $sql2.=trim($valores,',');
               $sql2.=' returning id_producto,cantidad';
               $insert=$conex->prepare($sql2);
               
               if($insert->execute()){  
                   
                                                include '../php clases/kardex.php';
                                                $kardex=new kardex();
                                                $kardex->decrease_inventario_farmacia($decrease_inv,2);
                                                
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