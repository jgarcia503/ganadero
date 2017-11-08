<?php   include '../plantilla.php';


if($_POST){
    
    try {
        $conex->beginTransaction();

        $insert = $conex->prepare("update categorias set "
                . " nombre='$_POST[categoria]',notas=trim('$_POST[notas]') where id=$_POST[id_cate]");
        $insert2 = $conex->prepare("update productos set "
                . " categoria='$_POST[categoria]' where categoria='$_POST[cate_ant]'");
        if ($insert->execute() and $insert2->execute()) {
            $conex->commit();
            echo '<div data-alert class="alert-box success round">
        <h5 style="color:white">registro actualizado exitosamente</h5>
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
$categoria=$conex->query("select * from categorias where id=$id")->fetch();


?>
<div class="small-10 columns">
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
    <form action="" method="post" data-abide>
        <div class="row">
            <div class="small-12 columns">
                <label for="">marca</label>
                <input type="text" name="categoria" required=""  value="<?php echo $categoria[nombre] ?>">
                <small class="error">escriba una marca</small>
            </div>
        </div>  
        <div class="row">
            <div class="small-12 columns">
                <label>notas</label>
                <textarea name="notas" cols="30" rows="10">
                    <?php echo $categoria[notas] ?>
                </textarea>
                <input type="hidden" name="id_cate" value="<?php echo $id ?>">
                <input type="hidden" name="cate_ant" value="<?php echo $categoria[nombre] ?>">
                <input type="submit" class="button primary" value="actualizar registro">
                
            </div>
        </div>
   
</form>

</div>
</div>

