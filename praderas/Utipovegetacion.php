<?php   include '../plantilla.php';
if($_POST){
    try {
          $conex->beginTransaction();
            $insert=$conex->prepare("update tipo_vegetacion set nombre='$_POST[nombre]'"
                                        . ",notas=trim('$_POST[notas]') where id=$_POST[tipo_veg_id]");
                                
                                $update2=$conex->prepare("update vegetaciones set tipo='$_POST[nombre]' where tipo='$_POST[nombre_ant]'");
                                
                 if($insert->execute() and $update2->execute()){
                                                     $conex->commit();
                                echo '<div data-alert class="alert-box success round">
                         <h5 style="color:white">registro actualizado exitosamente</h5>
                          <a href="#" class="close">&times;</a>
                        </div>';
                            }else{
                                throw new PDOException();                 
                    }
    
} catch (PDOException $exc) {
          $conex->rollBack();
     echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al actualizar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
    }



}

$id=base64_decode($_SERVER[QUERY_STRING]);
$tipovegetacion=$conex->query("select * from tipo_vegetacion where id=$id")->fetch();

?>
<div class="small-10 columns">
<form action="" method="post">
    <label for="">nombre</label>
    <input type="text" name="nombre" value="<?php echo $tipovegetacion[nombre]?>">
    <label for="">notas</label>
    <textarea name="notas"  cols="30" rows="10">
        <?php echo $tipovegetacion[notas]?>
    </textarea>
    <input type="hidden" value="<?php echo $id ?>" name="tipo_veg_id">
    <input type="hidden" value="<?php echo $tipovegetacion[nombre] ?>" name="nombre_ant">
    <input type="submit" class="button primary" value="actualizar registro">
</form>
</div>
</div>