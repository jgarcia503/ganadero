<?php   include '../plantilla.php'; 
if($_POST){
          $insert=$conex->prepare("insert into controles_potreros values(default,'$_POST[nombre]','$_POST[clase]',trim('$_POST[notas]'))");
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

$productos="select * from productos";
$resprods=$conex->query($productos);
$clases="select * from clases";
$resclases=$conex->query($clases);
?>



<div class="small-10 columns">
    <?php echo $mensaje?>
       <h2>crear actividad</h2>
       <a href="javascript:history.back(1)" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    <div class="row">

        <div class="small-6 columns">
            <label for="">nombre</label>
            <input type="text" name="nombre" required="" pattern="letters_and_spaces">
            <small class="error">solo letras</small>
        </div>
        <div class="small-6 columns">
<!--            <label for="">clase</label>
            <select required="" name="clase">
                <option value="">seleccione</option>
                           <?php
                while ($fila = $resclases->fetch()) {
                    echo "<option values='$fila[nombre]'>$fila[nombre]</option>";
                }
                                                    ?>
            </select>
            <small class="error">elija opcion</small>-->
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
           
        </div>
        <div class="small-6 columns">
            
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
    $("[name=producto]").parent('div').hide();
$("[name=tipo]").on('change',function(){
        if($(this).val()=='material'){
            $("[name=producto]").parent('div').show(2000);
        }else{
            $("[name=producto]").parent('div').hide(2000);
            
        }
});

</script>