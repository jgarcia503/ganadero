<?php   include '../plantilla.php';
$animales=$conex->query("select * from animales");

if($_POST){

 $insert =$conex->prepare("insert into marcas"
         . " values(default,'$_POST[marca]',trim('$_POST[notas]'))");
     if($insert->execute()){
        $mensaje= '<div data-alert class="alert-box success round">
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
<div class="small-12 columns">
    <?php echo $mensaje?>
       <h2>crear marca</h2>
       <a href="marcas.php" class="regresar">regresar</a>
    <form action="" method="post" data-abide>
        <div class="row">
            <div class="small-12 columns">
                <label for="">marca</label>
                <input type="text" name="marca" required="" >
                <small class="error">escriba una marca</small>
            </div>
        </div>  
        <div class="row">
            <div class="small-12 columns">
                <label>notas</label>
                <textarea name="notas" id="" cols="30" rows="10"></textarea>
                <input type="submit" class="button primary" value="crear registro">
            </div>
        </div>
   
</form>

</div>
</div>

