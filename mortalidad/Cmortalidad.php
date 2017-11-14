<?php    include '../plantilla.php';
$animales=$conex->query("
select * from animales where numero||' '||nombre not in (select animal from mortalidades)");
$causa_mortalidades=$conex->query("select * from causas_mortalidades");

if($_POST){

 $insert =$conex->prepare("insert into mortalidades"
         . " values(default,'$_POST[fecha]','$_POST[hora]','$_POST[animal]','$_POST[causa]',trim('$_POST[notas]'))");
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

<form action="" method="post" data-abide>    
        <h2>crear mortalidad</h2>
        <a href="mortalidad.php" class="regresar">regresar</a>
            <div class="row">
        <?php echo $mensaje ?>
        <div class="small-6 columns">
                <label for="">fecha</label>
                <input type="text" name="fecha" required="">
                 <small class="error">elija fecha</small>
        </div>
        <div class="small-6 columns">
                <label for="">hora</label>
                <input type="text" name="hora" required="">
                 <small class="error">elija hora</small>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
                <label for="">animal</label>
          <input type="text" name="animal" class="awesomplete" list="animales" data-minchars="1"> 
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
                <select name="causa"  required="">
        <option value="">seleccionar</option>
                <?php
        while($fila=$causa_mortalidades->fetch()){
            echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
        }
        ?>
        
    </select>
                 <small class="error">elija opcion</small>
        </div>
    </div>
    
    <div class="row">
        <div class="small-12 columns">
            <label for="">notas</label><textarea name="notas" id="" cols="30" rows="10"></textarea>
            <input type="submit" class="button primary" value="crear registro">
        </div>
    </div>

</form>

</div>
</div>
<script>       
            $("[name=fecha]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});
              $("[name=hora]").timepicker({disableTextInput:true,step:15});

    </script>