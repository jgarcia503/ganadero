<?php   include '../plantilla.php'; 

if($_POST){

    try {
        $conex->beginTransaction();

        $insert = $conex->prepare("update unidades set"
                . " unidad='$_POST[unidad]',notas=trim('$_POST[notas]') where id=$_POST[id]");
        $insert2 = $conex->prepare("update productos set"
                . " unidad='$_POST[unidad]' where unidad='$_POST[uni_ant]'");
        
        if ($insert->execute() and $insert2->execute()) {
            $conex->commit();
            echo '<div data-alert class="alert-box success round">
        <h5 style="color:white">registro actualizado exitosamente</h5>
        <a href="#" class="close">&times;</a>
        </div>';
        }
    } catch (Exception $exc) {
        $conex->rollBack();
        echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al actualizar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
    }
}

$id=base64_decode($_SERVER[QUERY_STRING]);
$unidad=$conex->query("select * from unidades where id=$id")->fetch();
?>
<div class="small-10 columns">
<form action="" method="post" data-abide>
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
    <div class="row">
        <div class="small-12 columns">
             <label for="">unidad</label>
             <input type="text" name="unidad" required="" value="<?php echo $unidad[unidad]?>">
                <small class="error">escriba unidad</small>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
             <label for="">notas</label>
             <textarea name="" id="" cols="30" rows="10" name="notas">
                 <?php echo $unidad[notas]?>
             </textarea>
             <input type="hidden" value="<?php echo $id ?>" name="id">
             <input type="hidden" value="<?php echo $unidad[unidad] ?>" name="uni_ant">
             <input type="submit" class="button primary" value="actualizar registro">
        </div>
    </div>
   
   
</form>
</div>
</div>