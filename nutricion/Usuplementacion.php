<?php   include '../plantilla.php';
$animales=$conex->query("select * from animales");
$dietas=$conex->query("select * from dietas");

$id=base64_decode($_SERVER[QUERY_STRING]);
$suple=$conex->query("select * from suplementaciones where id=$id")->fetch();

if($_POST){

$insert=$conex->prepare("update suplementaciones set "
        . "fecha='$_POST[fecha]',animal='$_POST[animal]',dieta='$_POST[dieta]',notas=trim('$_POST[notas]') where id=$_POST[id]");      
  
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
?>

<div class="small-10 columns">
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    
    <div class="row">
        <div class="small-6 columns">
            <label for="">fecha</label>
            <input type="text" name="fecha" required="" value="<?php echo $suple[fecha]?>">
             <small class="error">selecciona fecha</small>
        </div>
        <div class="small-6 columns">
              <label for="">animal</label>
              <input type="text" name="animal" class="awesomplete" list="animales" data-minchars="1" data-autofirst value="<?php echo $suple[animal]?>">    
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
                    echo "<option value='$fila[nombre]' ";
                    echo $fila[nombre]==$suple[dieta]?'selected':'';
                    echo ">$fila[nombre]</option>";
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
    <input type="hidden" value="<?php echo $id ?>" name="id">
    <input type="submit" class="button primary" value="actualizar registro">
        </div>
    </div>
   
    
</form>


</div>
</div>
<script>
          $("[name=fecha]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});
</script>