<?php   include '../plantilla.php';
$mensaje='';
if($_POST){

  //  var_dump($_POST);
$insert=$conex->prepare("insert into razas values(default,'$_POST[nombre]',trim('$_POST[notas]'))");      
  
    if($insert->execute()){
        $mensaje='<div data-alert class="alert-box success round">
 <h5 style="color:white">registro creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }else{
      $mensaje='<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
}
   
}
?>
<div class="small-10 columns">
       <h2>crear raza</h2>
       <?php echo $mensaje?>
       <a href="razas.php" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    <div class="row">
        <div class="small-12 columns">          
      
            <label for="">nombre</label>
            <input type="text" name="nombre" required="" pattern="letters_and_spaces">
            <small class="error"> raza es requerido, solo se permiten letras</small>
            
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
            <label for="">notas</label>
    <textarea name="notas" id="" cols="100" rows="10"></textarea>
    <input type="submit" name="" value="crear registro" class="button primary">
        </div>
    </div>
    
</form>




</div>
</div>