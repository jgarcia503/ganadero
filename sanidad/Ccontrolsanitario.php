<?php   include '../plantilla.php'; 
$animales=$conex->query("select * from animales");
$eventos=$conex->query("select * from eventos_sanitarios");
$contactos=$conex->query("select nombre from contactos where tipo='empleado'");
$productos=$conex->query("select nombre from productos");
if($_POST){
    
  $insert =$conex->prepare("insert into controles_sanitarios"
          . " values(default,'$_POST[fecha]','$_POST[hora]','$_POST[empleado]','$_POST[evento]','$_POST[animal]'"
          . ",trim('$_POST[notas]'))");
  
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
    <?php echo $mensaje ?>
       <h2>crear control sanitario</h2>
       <a href="controlessanitarios.php" class="regresar">regresar</a>
    <form action="" method="post" data-abide>
        <div class="row">
            <div class="small-6 columns">
                <label for="">fecha</label>
                <input type="text" name="fecha" required="">
  <small class="error">elija nombre, solo letras</small>
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
            echo "<option value='$fila[numero]-$fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
        }
        ?>
    </datalist>
            </div>
            <div class="small-6 columns">
                <label for="">empleado</label>
                <select name="empleado" >
                    <option value="yo">yo</option>
                               <?php
                    while($fila=$contactos->fetch()){
                                                echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                                    }
                                ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="small-6 columns">

                <label for="">evento</label>
                <select name="evento" required="">
                    
                    <option value="">seleccione</option>
                            <?php
        while($fila=$eventos->fetch()){
            echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
        }
        ?>
                </select>
        <small class="error">elija opcion</small>
            </div>
        </div>
        
          <div class="row">
            <div class="small-6 columns">

<!--                <label for="">producto</label>
                <input type="text" name="producto" required="" id="producto"> 
                <datalist id="productos">
                            <?php
        while($fila=$productos->fetch()){
            echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
        }
        ?>
               </datalist>
               <small class="error">elija producto</small>         -->
            </div>
              <div class="small-6 columns">
<!--                  <label for="">cantidad</label>
                  <input type="text" name="cantidad" required="" pattern="number">
                  <small class="error">elija opcion</small>-->
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
<script>      
              $("[name=fecha]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy"});
                 $("[name=hora]").timepicker({disableTextInput:true,step:15});
              
              var producto=document.getElementById('producto');
              new Awesomplete(producto, {list: document.querySelector("#productos"),minChars:1});
              
    </script>
