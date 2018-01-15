<?php    include '../plantilla.php'; 
if($_POST){
            try{
                $conex->beginTransaction();
                 $insert =$conex->prepare("update causas_mortalidades set"
                 . " nombre='$_POST[nombre]',notas=trim('$_POST[notas]') where id=$_POST[causa_morta_id]");
          $insert2=$conex->prepare("update mortalidades set"
                 . " causa='$_POST[nombre]' where causa='$_POST[causa_morta_ant]'");

                    if($insert->execute() and $insert2->execute()){
                        $conex->commit();
                          echo '<div data-alert class="alert-box success round">
                   <h5 style="color:white">registro actualizado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                      </div>';
                              }
                              else{
                                  throw new PDOException();
                              }
            }
            catch(PDOException $pe){
                    $conex->rollBack();
                            echo '<div data-alert class="alert-box alert round">
          <h5 style="color:white">Error al actualizar el registro</h5>
          <a href="#" class="close">&times;</a>
        </div>';
            }
 
}



$id=base64_decode($_SERVER[QUERY_STRING]);
$causamortalidades=$conex->query("select * from causas_mortalidades where id=$id")->fetch();
?>
<div class="small-12 columns">
    <a href="mortalidad.php" class="regresar">regresar</a>
<form action="" method="post">
    <label for="">nombre</label>
    <input type="text" name="nombre" value="<?php echo  $causamortalidades[nombre] ?>">
    <label for="">notas</label>
    <textarea name="notas" id="" cols="30" rows="10">
        <?php echo  $causamortalidades[notas] ?>
    </textarea>
    <input type="hidden" value="<?php echo $id ?>" name="causa_morta_id">
    <input type="hidden" value="<?php echo $causamortalidades[nombre] ?>" name="causa_morta_ant">
    <input type="submit" class="button primary" value="actualizar registro">
</form>
</div>
</div>
