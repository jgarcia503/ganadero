<?php   include '../plantilla.php'; 

   if ($_POST) {
    if($conex->query("select * from haciendas")->rowCount()>0){
                           $insert = $conex->prepare("update haciendas set nit='$_POST[nit]'"
                                   . ",nombre='$_POST[nombre]'"
                                   . ",propietario='$_POST[propietario]'"
                                   . ",direccion='$_POST[direccion]'"
                                   . ",telefono='$_POST[tel]'"
                                   . ",correo='$_POST[correo]'"
                                   . ",notas=trim('$_POST[notas]')");
                                if ($insert->execute()) {
                                    echo '<div data-alert class="alert-box success round">
                         <h5 style="color:white">registro actualizado exitosamente</h5>
                          <a href="#" class="close">&times;</a>
                        </div>';
                                     $_SESSION[hacienda]=$_POST[nombre];
                                } else {
                                    echo '<div data-alert class="alert-box alert round">
                          <h5 style="color:white">Error al actualizar el registro</h5>
                          <a href="#" class="close">&times;</a>
                        </div>';
                                }
    }else{
                                $insert = $conex->prepare("insert into haciendas values(default,'$_POST[nit]','$_POST[nombre]'"
                                        . ",'$_POST[propietario]','$_POST[direccion]','$_POST[tel]','$_POST[correo]',trim('$_POST[notas]'))");
                                if ($insert->execute()) {
                                    echo '<div data-alert class="alert-box success round">
                         <h5 style="color:white">registro creado exitosamente</h5>
                          <a href="#" class="close">&times;</a>
                        </div>';
                                } else {
                                    echo '<div data-alert class="alert-box alert round">
                          <h5 style="color:white">Error al insertar el registro</h5>
                          <a href="#" class="close">&times;</a>
                        </div>';
                                }
            }
}

$haciendas=$conex->query("select * from haciendas")->fetch();
$propietario=$conex->query("select nombre from contactos where tipo='admin'");
?>
<div class="small-12 columns">
<form action="" method="post" data-abide>
    <h1>hacienda</h1>
    <hr>
    <div class="row">
        <div class="small-6 columns">
            <label for="">nit</label>   
            <input type="text" name="nit" required="" pattern="letters_and_spaces" value="<?php echo $haciendas[nit]?>">
            <small class="error">nit es requerido</small>
        </div>
        <div class="small-6 columns">
             <label for="">nombre</label>   
             <input type="text" name="nombre" required="" pattern="letters_and_spaces" value="<?php echo $haciendas[nombre]?>">
            <small class="error">nombre es requerido</small>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
             <label for="">propietario</label>   
             <select name="propietario"  required="">
                 <option value="">seleccione</option>
                 <?php
                                                    while($fila=$propietario->fetch()){
                                                        echo "<option value='$fila[nombre]' ";
                                                        echo $fila[nombre]==$haciendas[propietario]?'selected':'';
                                                        echo ">$fila[nombre]</option>";
                                                    }
                                                   ?>
             </select>             
            <small class="error">propietario es requerido</small>
        </div>
        <div class="small-6 columns"></div>
    </div>
    <div class="row">
        <div class="small-6 columns">
             <label for="">telefono</label>   
             <input type="text" name="tel"  value="<?php echo $haciendas[telefono]?>">             
        </div>
        <div class="small-6 columns">
             <label for="">correo</label>   
             <input type="text" name="correo" value="<?php echo $haciendas[correo]?>" pattern="email">
            <small class="error">debe ser un correo</small>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns"><label for="">notas</label><textarea name="notas"  cols="30" rows="10"><?php echo $haciendas[notas]?></textarea></div>
        <div class="small-6 columns"><label for="">direccion</label><textarea name="direccion"  cols="30" rows="10"><?php echo $haciendas[direccion]?></textarea></div>
    </div>

    <div class="row">
        <div class="small-12 columns">
             <input type="submit" class="button primary" value="enviar"> 
    
        </div>
    </div>

</form>

</div>
</div>


