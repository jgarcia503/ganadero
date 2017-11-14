<?php
include '../plantilla.php';
$res=$conex->query("select * from animales ");
$res2=$conex->query("select * from animales ");

if($_POST){
    $sql="insert into lista_negra values(default,'$_POST[animal]','$_POST[incompatibles]','$_POST[notas]')";
    $insert=$conex->prepare($sql);
    
       if ($insert->execute()) {
        $mensaje = '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    } else {
        $mensaje = '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }
}
?>
<div class="small-10 column"> 
     <?php echo $mensaje ?>
    <h2>lista incompatibilidad</h2>
    <a href="lista_negra.php" class="regresar">regresar</a>
    <form action="" data-abide method="post">
    <div class="row">
        <div class="small-6 column">
            <label>seleccione animal</label>
            <select name="animal" required="">
                <option value="">seleccione</option>  
                <?php
                                                                while ($fila=$res->fetch()){
                                                                    echo "<option value='$fila[numero]'>$fila[numero]-$fila[nombre]</option>";
                                                                }
                                                ?>
            </select>   
            <small class="error">requerido</small>
        </div>
        <div class="small-6 column">
            <label>elija animales incompatibles</label>
            <input type="text" list="animales" class="flexdatalist" multiple="" name="incompatibles" >            
            <datalist id="animales" >
                <?php
                                                                while ($fila=$res2->fetch()){
                                                                    echo "<option value='$fila[numero]'>$fila[numero]-$fila[nombre]</option>";
                                                                }
                                                ?>
            </datalist>
        </div>
    </div>
        <div class="row">
            <div class="small-12 column">
                <label>notas</label>
                <textarea name="notas"></textarea>
                <button type="submit" >crear registro</button>
            </div>
        </div>
    </form>

    </div>
</div>
<script>
       $('.flexdatalist').flexdatalist({  minLength: 1,searchContain:true,focusFirstResult:true});
</script>