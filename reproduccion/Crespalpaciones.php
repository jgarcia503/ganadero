<?php    include '../plantilla.php'; 
if($_POST){
  $insert=  $conex->prepare("insert into resul_palpaciones "
            . "values(default,'$_POST[nombre]',trim('$_POST[notas]'))");
    
      if($insert->execute()){
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



<div class="small-10 columns">
    <?php echo $mensaje?>
       <h2>crear resultado palpacion</h2>
       <a href="javascript:history.back(1)" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    <div class="row">
        <div class="small-12 columns">
            <label for="">nombre</label>    
            <input type="text" name="nombre" required="" pattern="letters_and_spaces">
            <small class="error">elija un nombre, solo letras</small>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
             <label for="">notas</label>
    <textarea name="notas" id="" cols="30" rows="10"></textarea>
    <input type="submit" class="button primary" value="crear registro">
        </div>
    </div>
   
</form>

</div>
</div>