<?php   include '../plantilla.php';
$grupos=$conex->query("select distinct b.nombre ,b.id from animales a join grupos b on a.grupo=b.id::text");
$dietas=$conex->query("select * from alimentacion_enc");
$motivos=$conex->query('select * from motivos_requesiciones');
$bodegas=$conex->query('select * from bodega a join existencias b on a.codigo=b.codigo_bodega');
if($_POST){
    include '../php funciones/funciones.php';
try{
        extract($_POST);
      $animales_grp=$conex->query("select a.numero,(select count(a.numero) from animales a , grupos b  where  a.grupo =b.id::varchar and b.id=$grupo) total_animales from animales a , grupos b  where  a.grupo =b.id::varchar and b.id=$grupo");
      $productos_dieta=$conex->query("select a.*,b.* from alimentacion_lns a  
                                                                            join productos b on b.referencia=a.producto_id where a.enc_id =$dieta");
      $conex->beginTransaction();

$total=0;
$subtotal=0;
$tmp='';
        while($fila=$productos_dieta->fetch()){
            $cant_conv=convertir($fila[unidad], $fila[cantidad]);
            $total+=($cant_conv*$fila[precio_promedio]);
            $subtotal=($cant_conv*$fila[precio_promedio]);
            $tmp.="(default,'$fila[referencia]','$fila[cantidad]','$fila[precio_promedio]','$fila[unidad]','$subtotal','{enc_id}'),";

        }
        
        
        
$insert2=$conex->prepare("insert into requisicion_enc values (default,'$fecha',now(),'$bodega','$total',trim('$notas'),$motivo) returning id");
$sql_lns="insert into requisicion_lns values ";
if($insert2->execute()){
    $ultimo_id=$insert2->fetchColumn();
    $sql_lns.=  trim(preg_replace('/{enc_id}/', $ultimo_id, $tmp),',');
    if($conex->prepare($sql_lns)->execute()){
            $sql_lns_ins="select a.bodega_id,b.producto,b.cantidad,b.unidad,b.costo,a.id
                  from requisicion_enc a 
                  inner join requisicion_lns b 
                  on a.id::text=b.enc_id
                  where a.id=$ultimo_id";
            $lns_ins=$conex->query($sql_lns_ins);
            $consultas=[];
                        while($fila=$lns_ins->fetch(PDO::FETCH_ASSOC)){
                $cant_conv=  convertir($fila[unidad], $fila[cantidad]);
                
                $sql_actualiza_sal="update existencias set existencia=existencia::numeric(1000,2)-$cant_conv "
                                                                     . "where codigo_bodega='$fila[bodega_id]' "
                                                                    . "and codigo_producto='$fila[producto]'";                                               

                $sql_actualiza_prod="update productos set cantidad_total=(cantidad_total::numeric(1000,2)-$cant_conv) where referencia='$fila[producto]'";
                    
                $sql_kardex="insert into kardex values (default,'$fila[bodega_id]','$fila[producto]',now(),'requisicion-alimentacion','$fila[id]','$fila[costo]','','$cant_conv')";
                
                $consultas[]=$sql_actualiza_sal;
                $consultas[]=$sql_actualiza_prod;
                $consultas[]=$sql_kardex;

            
        }#cierro while
                foreach ($consultas as $value) {
                    if(!$conex->prepare($value)->execute()){
                                    throw new PDOException();                                           
                  }
        }
    }else{
        throw new PDOException;
    }
}else{
    throw new PDOException;
}
#############################################
        $insert=$conex->prepare("insert into suplementaciones_enc  values(default,'$fecha','$grupo','$dieta',trim('$_POST[notas]'),'$bodega','$motivo') returning id");    
        $lns="insert into suplementaciones_lns values ";
    if($insert->execute()){
        
        $tmp='';
        $ultimo_id=$insert->fetchColumn();
        while($fila=$animales_grp->fetch()){
            $prorateo=$total/$fila[total_animales];
            $tmp.="(default,'$fila[numero]','$prorateo','$ultimo_id'),";
        }
     $lns.=trim($tmp, ',');
    if(!$conex->prepare($lns)->execute()){
        throw new PDOException;
    }

    }else{
        throw new PDOException;
    }
    $conex->commit();
            $mensaje= '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
}
 catch(PDOException $pe){
     $conex->rollBack();
          $mensaje= '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
 }

}
?>
<div class="small-12 columns">
    <?php echo $mensaje?>
       <h2>crear suplementacion</h2>
       <a href="suplementaciones.php" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    
    <div class="row">
        <div class="small-2 columns">
            <label for="">fecha</label>
            <input type="text" name="fecha" required="">
             <small class="error">selecciona fecha</small>
        </div>
        <div class="small-2 columns">
              <label for="">grupo</label>
              <select name="grupo" required="">
                  <option value="">seleccione</option>
                  <?php
                  while($fila=$grupos->fetch()){
                      echo "<option value='$fila[id]'>$fila[nombre]</option>";
                  }
                  ?>
              </select>
<small class='error'>obligatorio</small>
        </div>
         <div class="small-2 columns">
                    <label>
                        motivo
                        <select name="motivo" required="">
                            <option value="">seleccione</option>
                            <?php
                                while($fila=$motivos->fetch()){
                                    echo "<option value='$fila[id]'>$fila[descripcion]</option>";
                                }
                                    ?>
                        </select>
                        <small class='error'>obligatorio</small>
                    </label>
        </div>
        <div class="small-2 columns">
                    <label>
                        bodega
                        <select name="bodega" required="">
                            <option value="">seleccione</option>
                            <?php
                            while($fila=$bodegas->fetch()){
                                echo "<option value='$fila[codigo]'>$fila[nombre]</option>";
                            }
                            ?>                            
                        </select>
                        <small class='error'>obligatorio</small>
                    </label>
        </div>
         <div class="small-2 columns end">
             <label for="">dieta</label>
             <select name="dieta" required="">
        <option value="">seleccione</option>
                     <?php
                while($fila=$dietas->fetch()){
                    echo "<option value='$fila[id]'>$fila[nombre]</option>";
                }
                ?>
    </select>
             <small class="error">selecciona dieta</small>
        </div>
    </div>
    <div class="row">

        <div class="small-6 columns"></div>
    </div>
    
    <div class="row">
        <div class="small-12 columns">
            <label for="">notas</label>
    <textarea name="notas" cols="30" rows="10"></textarea>
    <input type="submit" class="button primary" value="crear registro">
        </div>
    </div>
       
</form>

</div>

<script>
          $("[name=fecha]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});
          
</script>