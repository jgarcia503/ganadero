<?php   
include '../plantilla.php'; 


if($_POST){
    
    try{
        $conex->beginTransaction();
        $insert = $conex->prepare("update razas set nombre='$_POST[nombre]',notas=trim('$_POST[notas]') where id=$_POST[raza_id]");
        $insert2 = $conex->prepare("update animales set raza='$_POST[nombre]' where raza='$_POST[raza_ant]'");
        if($insert->execute() and    $insert2->execute()){
            $conex->commit();
                echo '<div data-alert class="alert-box success round">
           <h5 style="color:white">registro actualizado exitosamente</h5>
           <a href="#" class="close">&times;</a>
           </div>';
        }else{
            throw new PDOException();
        }
        
    }
    catch(PDOException $pe){
        $conex->rollBack();
                echo "<div data-alert class='alert-box alert round'>
          <h5 style='color:white'>Error al actualizar el registro</h5>
          <a href='#' class='close'>&times;</a>
          </div>";
    }

}


$id=base64_decode($_SERVER[QUERY_STRING]);
$razas=$conex->query("select * from razas where id=$id")->fetch();

?>
<div class="small-12 columns">
        
            <h2>actualiza raza</h2>
            <a href="razas.php" class="regresar">regresar</a>
<form action="" method="post">
    <label for="">nombre</label>
    <input type="text" name="nombre" value="<?php echo $razas[nombre]?>">
    <label for="">notas</label>
    <textarea name="notas" id="" cols="100" rows="10"><?php echo $razas[notas] ?>
    </textarea>
    <input type="hidden" value="<?php echo $id?>" name="raza_id">
    <input type="hidden" value="<?php echo $razas[nombre]?>" name="raza_ant">
    <input type="submit" name="" value="actualizar registro" class="button primary">
</form>

</div>
</div>