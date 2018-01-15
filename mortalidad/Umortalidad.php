<?php    include '../plantilla.php';
$animales=$conex->query("select * from animales");
$causa_mortalidades=$conex->query("select * from causas_mortalidades");
if($_POST){

 $insert =$conex->prepare("update mortalidades set "
         . " fecha='$_POST[fecha]'"
         . ",hora='$_POST[hora]'"
         . ",animal='$_POST[animal]'"
         . ",causa='$_POST[causa]'"
         . ",notas=trim('$_POST[notas]') where id=$_POST[mortalidad_id]");
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

$id=base64_decode($_SERVER[QUERY_STRING]);
$mortalidades=$conex->query("select * from mortalidades where id=$id")->fetch();
?>

<div class="small-12 columns">
    <a href="mortalidad.php" class="regresar">regresar</a>
<form action="" method="post">
    
    <div class="row">
        <div class="small-6 columns">
                <label for="">fecha</label>
                <input type="text" name="fecha" value="<?php echo $mortalidades[fecha] ?>">
        </div>
        <div class="small-6 columns">
                <label for="">hora</label>
    <input type="text" name="hora" value="<?php echo $mortalidades[hora] ?>">
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
                <label for="">animal</label>
          <input type="text" name="animal" class="awesomplete" list="animales" data-minchars="1" value="<?php echo $mortalidades[animal] ?>"> 
        <datalist id="animales">
        <?php
        while($fila=$animales->fetch()){
            echo "<option value='$fila[numero] $fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
        }
        ?>
    </datalist>
        </div>
        <div class="small-6 columns">
                <label for="">causa</label>
    <select name="causa" >
        <option value="">seleccionar</option>
                <?php
        while($fila=$causa_mortalidades->fetch()){
            echo "<option value='$fila[nombre]' ";
            echo  $fila[nombre]== $mortalidades[causa]?'selected':'';
            echo ">$fila[nombre]</option>";
        }
        ?>
        
    </select>
        </div>
    </div>
    
    <div class="row">
        <div class="small-12 columns">
            <label for="">notas</label><textarea name="notas" id="" cols="30" rows="10">
                <?php echo $mortalidades[notas] ?>
            </textarea>
            <input type="hidden" value="<?php echo $id  ?>" name="mortalidad_id">
            <input type="submit" class="button primary" value="actualizar registro">
        </div>
    </div>

    
</form>

</div>
</div>
<script>      
            $("[name=fecha]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});
              $("[name=hora]").timepicker({disableTextInput:true,step:15});

    </script>