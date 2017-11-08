<?php    include '../plantilla.php'; 
if($_POST){
  $insert=  $conex->prepare("update resul_palpaciones "
            . "set nombre='$_POST[nombre]',notas=trim('$_POST[notas]') where id=$_POST[res_palpa_id]");
    
      if($insert->execute()){
        echo '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro actualizado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }else{
      echo '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al actualizar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
        }
  
}   

$id=base64_decode($_SERVER[QUERY_STRING]);
$respalpaciones=$conex->query("select * from resul_palpaciones where id=$id")->fetch();

?>



<div class="small-10 columns">
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
<form action="" method="post">
    <label for="">nombre</label>
    
    <input type="text" name="nombre" value="<?php echo   $respalpaciones[nombre] ?>">
    <label for="">notas</label>
    <textarea name="notas"  cols="30" rows="10">
        <?php echo   $respalpaciones[notas] ?>
    </textarea>
    <input type="hidden" value="<?php echo   $id ?>" name="res_palpa_id">
    <input type="submit" class="button primary">
</form>

</div>
</div>