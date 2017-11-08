<?php   include '../plantilla.php'; 
   if ($_POST) {

    try {
        $conex->beginTransaction();
        $insert = $conex->prepare("update controles_potreros set nombre='$_POST[nombre]',notas=trim('$_POST[notas]') where id=$_POST[even_sani_id]");
        $insert2 = $conex->prepare("update control_potreros set tipo='$_POST[nombre]' where tipo='$_POST[even_sani_ant]'");

        if ($insert->execute() and $insert2->execute()) {
            $conex->commit();
            echo '<div data-alert class="alert-box success round">
     <h5 style="color:white">color creado exitosamente</h5>
    <a href="#" class="close">&times;</a>
    </div>';
        } else {
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
$tipocontrol=$conex->query("select * from controles_potreros where id=$id")->fetch();

?>



<div class="small-10 columns">
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    <div class="row">
        <div class="small-12 columns">
             <label for="">nombre</label>
             <input type="text" name="nombre" required="" pattern="letters_and_spaces" value="<?php echo $tipocontrol[nombre]?>">
                <small class="error">solo letras</small>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
    <label for="">notas</label>
    <textarea name="notas" id="" cols="30" rows="10"><?php echo $tipocontrol[notas]?></textarea>
    <input type="hidden" value="<?php echo $id ?>" name="even_sani_id">
    <input type="hidden" value="<?php echo $tipocontrol[nombre] ?>" name="even_sani_ant">
    <input type="submit" class="button primary" value="actualizar registro">        
        </div>
    </div>
   
    
</form>


</div>
</div>