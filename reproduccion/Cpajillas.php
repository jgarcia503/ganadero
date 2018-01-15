<?php
include '../plantilla.php';
if($_POST){
    $sql="insert into pajillas_toros values(default,'$_POST[toro]','$_POST[pajilla]','$_POST[tipo_semen]',true)";
    $res=$conex->prepare($sql);
  if($res->execute()){
        $mensaje= '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
       }else{
      $mensaje= '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
        }
}
?>
<div class="small-12 columns">
        <?php echo $mensaje ?>
        <h2>pajilla </h2>
        <a href="pajillas.php" class="regresar">regresar</a>
           <form action="" method="post" data-abide>
    <div class="row">
        <div class="small-4 columns">
        <label>toro
            <input type="text" name="toro" required="">               
            <small class="error">requerido</small>
        </label>
            </div>
            <div class="small-4 columns">
        <label>codigo pajilla
            <input type="text" name="pajilla" required="">
            <small class="error">requerido</small>
        </label>
         </div>
        <div class="small-4 columns">
        <label>tipo semen
            <select name="tipo_semen" required="">
                <option value="">seleccione</option>
                <option value="sexado">sexado</option>
                <option value="convencional">convencional</option>
            </select>
            <small class="error">requerido</small>
        </label>
         </div>
        

</div>
        <input type="submit" value="crear registro" class="button primary">
    </form>
</div>
</div>