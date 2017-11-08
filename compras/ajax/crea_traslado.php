<?php

require_once '../../conexion.php';
require_once '../../php funciones/funciones.php';
extract($_GET);
$sql_enc="insert into traslados_enc values (default,'$fecha',now(),'$bod_org','$bod_dst','$total',trim('$notas')) returning id";
$sql_lns="insert into traslados_lns values ";
$sql_kardex="insert into kardex values ";
try{
    $conex->beginTransaction();
    $stm=$conex->prepare($sql_enc);
    
    if($stm->execute()){
        $enc_id=$stm->fetchColumn();
        foreach ($traslados as $value) {
            $sql_lns.="(default,'$value[referencia]','$value[cantidad]','$value[costo]','$value[unidad]','$value[subtotal]','$enc_id'),";
        }
        $sql_lns=  trim($sql_lns,',');
        $stm_lns=$conex->prepare($sql_lns);
        if($stm_lns->execute()){
            $sql_lns_ins="select a.id,a.bodega_origen,a.bodega_destino,b.producto,b.cantidad,b.unidad,b.costo
                  from traslados_enc a 
                  inner join traslados_lns b 
                  on a.id::text=b.enc_id
                  where a.id=$enc_id";
            $lns_ins=$conex->query($sql_lns_ins);
            
            while($fila=$lns_ins->fetch(PDO::FETCH_ASSOC)){
                $cant_conv=  convertir($fila[unidad], $fila[cantidad]);
                
                $sql_actualiza_sal="update existencias set existencia=existencia::numeric(10,2)-$cant_conv "
                                                                     . "where codigo_bodega='$fila[bodega_origen]' "
                                                                    . "and codigo_producto='$fila[producto]'";
                               
                  $sql_actualiza_ent="update existencias set existencia=existencia::numeric(10,2)+$cant_conv "
                                                                           . "where codigo_bodega='$fila[bodega_destino]' "
                                                                           . "and codigo_producto='$fila[producto]'";
                                      
                    $sql_insert_ent="insert into existencias values(default,'$fila[producto]','$fila[bodega_destino]','$cant_conv')";
                   
                #verificar si existe
                $existe="select count(id) from existencias where codigo_producto='$fila[producto]' and codigo_bodega='$fila[bodega_destino]'";
                $res=  $conex->query($existe)->fetch()[count];
                if($res==1){
                                  if(!$conex->prepare($sql_actualiza_ent)->execute() or  
                                              !$conex->prepare($sql_actualiza_sal)->execute()){
                                                   
                                                                throw PDOException;                              
                            }
                      
                }else{
                              if( ! $conex->prepare($sql_insert_ent)->execute() or  
                                            !  $conex->prepare($sql_actualiza_sal)->execute()){
                                  
                                                        throw PDOException;                                           
                            
                }
                                                
            }
            
                    $sql_kardex.="(default,'$fila[bodega_origen]','$fila[producto]',now(),'traslado',$fila[id],'$fila[costo]','','$cant_conv'),";
                    $sql_kardex.="(default,'$fila[bodega_destino]','$fila[producto]',now(),'traslado',$fila[id],'$fila[costo]','$cant_conv',''),";
                 
            

        }#cierro while
            
                  $sql_kardex=  trim($sql_kardex,',');
                  if(!$conex->prepare($sql_kardex)->execute()){
                                    throw PDOException;                                           
                  }
                $conex->commit();
                                                echo '<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
        
    }else{
        throw  new PDOException;
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