<?php   
include '../plantilla.php';


if($_POST){
  try {
          $conex->beginTransaction();
        $insert = $conex->prepare("update colores set nombre='$_POST[color]' where id=$_POST[color_id]");
        $insert2 = $conex->prepare("update animales set color='$_POST[color]' where color='$_POST[color_ant]'");
        if ($insert->execute() and $insert2->execute()) {
              $conex->commit();
            echo '<div data-alert class="alert-box success round">
 <h5 style="color:white">color actualizado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
        } else {
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
$colores=$conex->query("select * from colores where id=$id")->fetch();

?>
<div class="small-10 columns">

     <h2>actualizar color</h2>
     <a href="javascript:history.back(1)" class="regresar">regresar</a>
<form action="" method="post">
    <label for="">nombre</label>
    <input type="text" name="color" value="<?php echo $colores[nombre]?>">
    <input type="hidden" value="<?php echo $id ?>" name="color_id">
    <input type="hidden" value="<?php echo $colores[nombre] ?>" name="color_ant">
    <input type="submit" class="button primary" value="actualizar registro">     
      
</form>
</div>
</div>


