<?php

require_once '../../conexion.php';
require_once '../../php funciones/funciones.php';
extract($_GET);
$sql_alimen_enc="insert into alimentacion_enc values ";
$sql_alimen_lns="insert into alimentacion_lns values ";
$sql_enc="insert into requisicion_enc values (default,'$fecha',now(),'$bod_org','$total',trim('$notas'),$motivo) returning id";
$sql_lns="insert into requisicion_lns values ";
$sql_animales_grupo="select  btrim(array_agg(id)::text,'{}') from animales where grupo='$grupo'";
    $res_animales_grupo=$conex->query($sql_animales_grupo)->fetchColumn();
try{
    $conex->beginTransaction();
    $stm=$conex->prepare($sql_enc);

    
    if($stm->execute()){
        $enc_id=$stm->fetchColumn();
        $sql_alimen_enc.="(default,'$fecha','$grupo',$enc_id,'$res_animales_grupo') returning id";
        $stm_alimen=$conex->prepare($sql_alimen_enc);
        if(!$stm_alimen->execute()){
            throw new PDOException;
        }
        $enc_id_alimen=$stm_alimen->fetchColumn();
        foreach ($traslados as $value) {
            $sql_lns.="(default,'$value[referencia]','$value[cantidad]','$value[costo]','$value[unidad]','$value[subtotal]','$enc_id'),";
            $sql_alimen_lns.="(default,'$value[referencia]','$value[cantidad]','$value[unidad]','$enc_id_alimen'),";
        }
        $sql_lns=  trim($sql_lns,',');
        $sql_alimen_lns=  trim($sql_alimen_lns,',');
        
        $stm_lns=$conex->prepare($sql_lns);
        $stm_lns_alimen=$conex->prepare($sql_alimen_lns);
        if($stm_lns->execute() and $stm_lns_alimen->execute()){
            $sql_lns_ins="select a.bodega_id,b.producto,b.cantidad,b.unidad,b.costo,a.id
                  from requisicion_enc a 
                  inner join requisicion_lns b 
                  on a.id::text=b.enc_id
                  where a.id=$enc_id";
            $lns_ins=$conex->query($sql_lns_ins);
            $consultas=[];
            while($fila=$lns_ins->fetch(PDO::FETCH_ASSOC)){
                $cant_conv=  convertir($fila[unidad], $fila[cantidad]);
                
                $sql_actualiza_sal="update existencias set existencia=existencia::numeric(1000,2)-$cant_conv "
                                                                     . "where codigo_bodega='$fila[bodega_id]' "
                                                                    . "and codigo_producto='$fila[producto]'";                                               

                $sql_actualiza_prod="update productos set cantidad_total=(cantidad_total::numeric(1000,2)-$cant_conv) where referencia='$fila[producto]'";
                    
                $sql_kardex="insert into kardex values (default,'$fila[bodega_id]','$fila[producto]',now(),'requisicion','$fila[id]','$fila[costo]','','$cant_conv')";
                
                $consultas[]=$sql_actualiza_sal;
                $consultas[]=$sql_actualiza_prod;
                $consultas[]=$sql_kardex;
                
                 
                    
                 
            
        }#cierro while
            
        foreach ($consultas as $value) {
                    if(!$conex->prepare($value)->execute()){
                                    throw new PDOException();                                           
                  }
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
       <h5 style="color:white">Error al insertar el registro</h5>'.$pe->getMessage().'
       <a href="#" class="close">&times;</a>
       </div>';
 }