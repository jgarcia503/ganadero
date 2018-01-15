<?php   include '../plantilla.php'; 
$animales=$conex->query("select * from animales");
$eventos=$conex->query("select * from eventos_sanitarios");
if($_POST){
    
  $insert =$conex->prepare("update controles_sanitarios set "
          . " fecha='$_POST[fecha]'"
          . ",hora='$_POST[hora]'"
          . ",empleado='$_POST[empleado]'"
          . ",evento='$_POST[evento]'"
          . ",animal='$_POST[animal]'"
          . ",notas=trim('$_POST[notas]') where id=$_POST[control_sani_id]");
  
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
$controlsanitario=$conex->query("select * from controles_sanitarios where id=$id")->fetch();

?>


<div class="small-12 columns">
    <a href="controlessanitarios.php" class="regresar">regresar</a>
    <form action="" method="post">
        <div class="row">
            <div class="small-6 columns">
                <label for="">fecha</label>
                <input type="text" name="fecha" value="<?php  echo $controlsanitario[fecha] ?>">

            </div>
            <div class="small-6 columns">
                <label for="">hora</label>
                <input type="text" name="hora" value="<?php  echo $controlsanitario[hora] ?>">
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <label for="">animal</label>
                 <input type="text" name="animal" class="awesomplete" list="animales" data-minchars="1" value="<?php  echo $controlsanitario[animal] ?>"> 
    <datalist id="animales">
        <?php
        while($fila=$animales->fetch()){
            echo "<option value='$fila[numero]-$fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
        }
        ?>
    </datalist>
            </div>
            <div class="small-6 columns">
                <label for="">empleado</label>
                <select name="empleado" >
                    <option value="yo">yo</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="small-6 columns">

                <label for="">evento</label>
                <select name="evento" id="">
                    
                    <option value="seleccione">seleccione</option>
                            <?php
        while($fila=$eventos->fetch()){
            echo "<option value='$fila[nombre]' ";
            echo $fila[nombre]==$controlsanitario[evento]?'selected':"";
            echo ">$fila[nombre]</option>";
        }
        ?>
                </select>

            </div>
        </div>

        <div class="row">
            <div class="small-12 columns">
                <label for="">notas</label>
                <textarea name="notas" id="" cols="30" rows="10">
                    <?php  echo $controlsanitario[notas] ?>
                </textarea>
                <input type="hidden" value="<?php echo $id ?>" name="control_sani_id">
                <input type="submit" class="button primary" value="actualizar registro">
            </div>
        </div>

    </form>
</div>
</div>
<script>     
        
              $("[name=fecha]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy"});
                 $("[name=hora]").timepicker({disableTextInput:true,step:15});

    </script>