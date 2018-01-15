<?php   include '../plantilla.php'; 
if($_POST){
  try{
      $insert=$conex->prepare("insert into colores values(default,'$_POST[color]')");
    if($insert->execute()){
        $mensaje= '<div data-alert class="alert-box success round">
 <h5 style="color:white">color creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }else{
      $mensaje= '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
}
  }
 catch (Exception $ex){
     echo $ex->getMessage();
 }
}

?>

<div class="small-12 columns">
       <h2>crear color</h2>
          <?php echo $mensaje?>
       <a href="colores.php" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    <div class="row">
        <div class="small-12 columns">
             <label for="">nombre</label>   
             <input type="text" name="color" required="" pattern="letters_and_spaces">
            <small class="error">color es requierido,  solo se permiten letras</small>
           
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
             <input type="submit" class="button primary" value="crear registro"> 
        
        </div>
    </div>
            
   
  
   

    
      
</form>



</div>
</div>


