<?php   include '../plantilla.php'; 
$potreros=$conex->query("select * from potreros");
$lotes=$conex->query("select * from lotes");

if($_POST){
          $insert=$conex->prepare("insert into ocupaciones_potreros "
                  . "values(default,'$_POST[potrero]','$_POST[lote]','$_POST[fecha_ent]','$_POST[fecha_sal]'"
                  . ",'$_POST[afo_ent]','$_POST[afo_sal]',trim('$_POST[notas]'))");
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


?>

<div class="small-10 columns">
    <?php echo $mensaje?>
       <h2>crear ocupaciones potrero</h2>
<form action="" method="post">
    <div class="row">
        <div class="small-6 columns">
            <label for="">potrero</label>
            <select name="potrero" >
                <option>seleccione</option>
                <?php
                while($fila=$potreros->fetch()){
                    echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                }
                ?>
            </select>
        </div>
        <div class="small-6 columns">
            <label for="">lote</label>
            <select name="lote">
                <option>seleccione</option>
             <?php
                while($fila=$lotes->fetch()){
                    echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
             <label for="">fecha entrada</label>
             <input type="text" name="fecha_ent">
        </div>
        <div class="small-6 columns">
            <label for="">fecha salida</label>
    <input type="text" name="fecha_sal">
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <label for="">aforo entrada</label>
            <input type="text" name="afo_ent">
        </div>
        <div class="small-6 columns">
             <label for="">aforo salida</label>
             <input type="text" name="afo_sal">
        </div>
    </div>
    
    <div class="row">
        <div class="small-12 columns">
             <label for="">notas</label>
    <textarea name="notas" id="" cols="30" rows="10"></textarea>
    <input type="submit" class="button primary">
        </div>
    </div>

</form>

</div>
</div>
<script>        
            $("[name^=fecha]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});        
    </script>