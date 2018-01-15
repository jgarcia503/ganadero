<?php   
include '../plantilla.php';


if($_POST){
  
  try {
          
          extract($_POST);
 $sql="update grupos set nombre='$grupo',produccion_minima='$prod_min' where id=$grupo_id";
          
          $stm=$conex->prepare($sql);
  
              if($stm->execute()){
          $mensaje='<div data-alert class="alert-box success round">
                    <h5 style="color:white">grupo actualizado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
              }else{
                  throw  new PDOException;
              }
    } catch (PDOException $pe) {
           $conex->rollBack();
                    $mensaje= '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al actualizar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }
}

$id=$_SERVER[QUERY_STRING];
$colores=$conex->query("select * from grupos where id=$id")->fetch();

?>
<div class="small-12 columns">
    <a href="grupos.php" class="regresar">regresar</a>
<form action="" method="post">
    <?php echo $mensaje ?>
    <h2>actualiza grupo</h2>
    
    <label for="">nombre</label>
    <input type="text" name="grupo" value="<?php echo $colores[nombre]?>">
    <input type="hidden" value="<?php echo $id ?>" name="grupo_id">
    <label>produccion minima</label>
    <input type="text" name="prod_min" value="<?php echo $colores[produccion_minima]?>">  
    <input type="submit" class="button primary" value="actualizar registro">     
      
</form>
</div>
</div>


