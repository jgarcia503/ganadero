<?php   include '../plantilla.php';
if($_POST){   

                                $insert=$conex->prepare("insert into tipo_vegetacion values(default,'$_POST[nombre]'"
                                        . ",trim('$_POST[notas]'),'$_POST[cuenta]')");
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
    <?php echo $mensaje?>
       <h2>crear tipo cultivo</h2>
       <a href="tiposvegetacion.php" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    <div class="row">
        <div class="small-6 columns">
             <label for="">nombre</label>
             <input type="text" name="nombre" required="" pattern="letters_and_spaces">
                 <small class="error">solo letras</small>
        </div>
        <div class="small-6 columns">
                   <label>cuenta contable
                    <select name="cuenta" required="">
                        <option value="">seleccione</option>
                        <?php
                        $cc="SELECT * from cn_catalogo where acceso_manual =true";
                        $rescc=$conex->query($cc);
                        while($fila=$rescc->fetch(PDO::FETCH_ASSOC)){
                            echo "<option value='$fila[cuenta_id]'>$fila[cuenta_id]  $fila[descripcion]</option>";
                        }
                                ?>
                    </select>
                    <small class="error">requerido</small>
                </label>
    </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
             <label for="">notas</label>
    <textarea name="notas" id="" cols="30" rows="10"></textarea>
    <input type="submit" class="button primary" value="crear registro">
        </div>
    </div>
   
   
</form>
</div>
</div>
<script>
    $('select').select2();
    </script>