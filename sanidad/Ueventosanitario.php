<?php   include '../plantilla.php'; 
if($_POST){
    try {
                       $conex->beginTransaction();
                         $update1 =$conex->prepare("update eventos_sanitarios set"
          . " nombre='$_POST[nombre]',notas=trim('$_POST[notas]') where id=$_POST[even_sani_id]");
  
                $update2=$conex->prepare("update controles_sanitarios set evento='$_POST[nombre]' where evento='$_POST[evento_ant]'");
                       
             if($update1->execute() and  $update2->execute()){
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
$evsanitario=$conex->query("select * from eventos_sanitarios where id=$id")->fetch();

?>
<div class="small-10 columns">
<a href="javascript:history.back(1)" class="regresar">regresar</a>
<form action="" method="post">
    <label for="">nombre</label>
    <input type="text" name="nombre" value="<?php echo $evsanitario[nombre] ?>">
    <input type="hidden" name="evento_ant" value="<?php echo $evsanitario[nombre] ?>">
    <label for="">notas</label>
    <textarea name="notas" cols="30" rows="10">
        <?php echo $evsanitario[notas] ?>
    </textarea>
    <input type="hidden" value="<?php echo $id ?>" name="even_sani_id">
    <input type="submit" class="button primary" value="actualizar registro">
</form>

</div>
</div>