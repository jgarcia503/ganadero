<?php   include '../plantilla.php'; 
if($_POST){
    
  $insert =$conex->prepare("insert into eventos_sanitarios"
          . " values(default,'$_POST[nombre]',trim('$_POST[notas]'))");
  
       if($insert->execute()){
        echo '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }else{
      echo '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
        }
}

?>

<div class="small-12 columns">
       <h2>crear evento sanitario</h2>
       <a href="eventossanitarios.php" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    <div class="row">
        <div class="small-12 columns">
            <label for="">nombre</label>
            <input type="text" name="nombre" required="" pattern="letters_and_spaces">
            <small class='error'>escriba nombre solo letras</small>
            
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