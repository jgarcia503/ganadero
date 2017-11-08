<?php   include '../plantilla.php'; 
$tipo_vegetacion=$conex->query("select * from tipo_vegetacion");



if($_POST){
    
    try {
                $conex->beginTransaction();
                
                    $insert =$conex->prepare("update vegetaciones set "
          . " tipo='$_POST[tipo]',nombre='$_POST[nombre]',notas=trim('$_POST[notas]') where id=$_POST[veg_id]");
  
                    $sqlactualiza="update aforos set vegetacion=replace(vegetacion,'$_POST[nom_ant]','$_POST[nombre]')";
                         $actualiza2=$conex->prepare($sqlactualiza) ;
                         
                
                       if($insert->execute() and $actualiza2->execute()){
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
$vegetacion=$conex->query("select * from vegetaciones where id=$id")->fetch();

?>

<div class="small-10 columns">
<form action="" method="post">
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
    <label for="">tipo</label>
    <select name="tipo">
        <option value="seleccione">seleccione</option>
        <?php
                while($fila=$tipo_vegetacion->fetch()){
                   echo  "<option value='$fila[nombre]'";
                   echo $fila[nombre]==$vegetacion[tipo]?'selected':'';
                   echo ">$fila[nombre]</option>";
                }
                      ?>
    </select>
    <label for="">nombre</label>
    <input type="text" name="nombre" value="<?php echo $vegetacion[nombre] ?>">
    <label for="">notas</label>
    <textarea name="notas"  cols="30" rows="10">
        <?php echo $vegetacion[nombre] ?>
    </textarea>
    <input type="hidden" value="<?php echo $id ?>" name='veg_id'>
    <input type="hidden" value="<?php echo $vegetacion[nombre] ?>" name='nom_ant'>
    <input type="submit" class="button primary" value="actualizar registro">
</form>
</div>
</div>