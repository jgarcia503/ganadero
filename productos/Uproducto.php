<?php  
include '../plantilla.php';
    
if($_POST){
    
    try {
                  $conex->beginTransaction();
                  
                      $insert =$conex->prepare("update productos set "
                                                . "referencia='$_POST[referencia]'"
                                                . ",unidad='$_POST[unidad]'"
                                                . ",nombre='$_POST[nombre]'"
                                                . ",precio='$_POST[precio]'"
                                                . ",notas=trim('$_POST[notas]') where id=$_POST[id]");                         
                      ////////////////////////////
                      $sqlactualiza="update dietas set producto=replace(producto,'$_POST[nom_ant]','$_POST[nombre]')";
                         $actualiza2=$conex->prepare($sqlactualiza) ;
                         
                         $sqlactualiza3="update control_potreros set producto=replace(producto,'$_POST[nom_ant]','$_POST[nombre]')";
                         $actualiza3=$conex->prepare($sqlactualiza3) ;
                         
                         $sqlactualiza4="update farmacia set ref_prod='$_POST[referencia]' where id=$_POST[id]";
                         
                           if($insert->execute() and $actualiza2->execute() and $actualiza3->execute()){
                                            $conex->commit();
                    echo '<div data-alert class="alert-box success round">
             <h5 style="color:white">registro actualizado exitosamente</h5>
              <a href="#" class="close">&times;</a>
                </div>';
                    }else{
                                    throw new PDOException();
                    }
        
    } catch (PDOException $pe) {
                $conex->rollBack();
                echo '<div data-alert class="alert-box alert round">
            <h5 style="color:white">Error al actualizar el registro</h5>
            <a href="#" class="close">&times;</a>
            </div>';
            }
    }
 

$id=base64_decode($_SERVER[QUERY_STRING]);
$productos=$conex->query("select * from productos where id=$id")->fetch();

$unidades=$conex->query("select * from unidades");
$marcas=$conex->query("select * from marcas");
$categorias=$conex->query("select * from categorias");

?>
<div class="small-10 columns">
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    
    <div class="row">
        <div class="small-6 columns">
             <label for="">referencia</label>
             <input type="text" name="referencia" value="<?php echo $productos[referencia] ?>">
        </div>
        <div class="small-6 columns">
              <label for="">nombre</label>
              <input type="text" name="nombre" required="" pattern="letters_and_spaces" value="<?php echo $productos[nombre] ?>">
              <small class="error">escriba nombre</small>
        </div>
</div>
<div class="row">
    <div class="small-6 columns">
         <label for="">precio</label>
         <input type="text" name="precio" required="" pattern="number" value="<?php echo $productos[precio] ?>">
         <small class="error">escriba precio, debe ser numero</small>
    </div>
    <div class="small-6 columns">
         <label for="">unidad</label>
         <select name="unidad" required="">
             <option value="">seleccione</option>
             <?php 
                                                      while($fila=$unidades->fetch()){
                                                                echo "<option value='$fila[unidad]' ";
                                                                echo $fila[unidad]==$productos[unidad]?'selected':'';
                                                                echo ">$fila[unidad]</option>";
                                                                }                     
                                        ?>
         </select>
         <small class="error">selecione unidad</small>
    </div>
</div>
    
        <div class="row">
        <div class="small-6 columns">
            <label for="">marca</label>
         <select name="marca" required="">
             <option value="">seleccione</option>
             <?php  while($fila=$marcas->fetch()){
                                                                echo "<option value='$fila[nombre]' ";
                                                               echo $fila[nombre]==$productos[marca]?'selected':'';
                                                                echo ">$fila[nombre]</option>";
                                                                }                     
                                        ?>
         </select>
         <small class="error">selecione marca</small>
        </div>
        <div class="small-6 columns">
            <label for="">categoria</label>
         <select name="categoria" required="">
             <option value="">seleccione</option>
             <?php  while($fila=$categorias->fetch()){
                                                                echo "<option value='$fila[nombre]' ";
                                                                  echo $fila[nombre]==$productos[categoria]?'selected':'';
                                                                echo ">$fila[nombre]</option>";
                                                                }                     
                                        ?>
         </select>
         <small class="error">selecione categoria</small>
        </div>
    </div>
    
    <div class="row">
        <div class="small-12 columns">
             <label for="">notas</label>
             <textarea name="notas"  cols="30" rows="10">
                 <?php echo $productos[notas]?>
             </textarea>
             <input type="hidden" name="id" value="<?php echo $id?>">
             <input type="hidden" name="nom_ant" value="<?php echo $productos[nombre] ?>">
             <input type="submit" class="button primary" value="actualizar registro">
        </div>
    </div>
  
   
</form>

</div>
</div>
