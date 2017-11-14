<?php   include '../plantilla.php'; 

if($_POST){

 $insert =$conex->prepare("insert into categorias"
         . " values(default,'$_POST[categoria]',trim('$_POST[notas]'))");
     if($insert->execute()){
        $mensaje='<div data-alert class="alert-box success round">
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
       <h2>crear categoria</h2>
       <a href="categorias.php" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    <div class="row">
        <div class="small-12 columns">
            <label for="">categoria</label>  
             <input type="text" name="categoria" required="" >
           
                <small class="error">escriba categoria</small>
        </div>
      
    </div>
    <div class="row">
        <div class="small-12 columns">
             <label for="">notas</label>
    <textarea name="notas" id="" cols="30" rows="10" name="notas"></textarea>
    <input type="submit" class="button primary" value="crear registro">
        </div>
    </div>
   
   
</form>
</div>
</div>