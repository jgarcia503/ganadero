<?php   include '../plantilla.php';
$animales=$conex->query("select * from animales");
$dietas=$conex->query("select * from dietas");

if($_POST){

$insert=$conex->prepare("insert into suplementaciones "
        . "values(default,'$_POST[fecha]','$_POST[animal]','$_POST[dieta]',trim(trim('$_POST[notas]')))");      
  
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
<div class="small-12 columns">
    <?php echo $mensaje?>
       <h2>crear suplementacion</h2>
       <a href="javascript:history.back(1)" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    
    <div class="row">
        <div class="small-6 columns">
            <label for="">fecha</label>
            <input type="text" name="fecha" required="">
             <small class="error">selecciona fecha</small>
        </div>
        <div class="small-6 columns">
              <label for="">animal</label>
              <input type="text" name="animal" class="awesomplete" list="animales" data-minchars="1" data-autofirst>    
            <datalist id="animales">
                <?php
                while($fila=$animales->fetch()){
                    echo "<option value='$fila[numero]-$fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
                }
                ?>
            </datalist>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
             <label for="">dieta</label>
             <select name="dieta" required="">
        <option value="">seleccione</option>
                     <?php
                while($fila=$dietas->fetch()){
                    echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                }
                ?>
    </select>
             <small class="error">selecciona dieta</small>
        </div>
        <div class="small-6 columns"></div>
    </div>
    
    <div class="row">
        <div class="small-12 columns">
            <label for="">notas</label>
    <textarea name="notas" cols="30" rows="10"></textarea>
    <input type="submit" class="button primary" value="crear registro">
        </div>
    </div>
       
</form>

</div>
</div>
<script>
          $("[name=fecha]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});
</script>