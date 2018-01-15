<?php
include '../plantilla.php';
if($_POST){
    extract($_POST);
    $res=$conex->prepare("insert into activo values (default,'$referencia','$nombre','0','$marca','0','$vida_util')");
    if($res->execute()){
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

    $sql_marcas="select * from marcas";
    $res_marcas=$conex->query($sql_marcas);
?>

<div class="small-12 columns"  >
    <?php echo $mensaje ?>
    <h2>deterioro de activo</h2>
    <a href="deterioro_activo.php" class="regresar">regresar</a>
    <div class="row">
        
     <form action="" method="post" data-abide>
         
             <div class="columns small-6">
                      <label>referencia
                          <input type="text" name="referencia" required="">
                          <small class="error">obligatorio</small>
        </label>
        </div>
            <div class="columns small-6">
                   <label>nombre
                       <input type="text" name="nombre" required="">
                       <small class="error">obligatorio</small>
        </label>
        </div>
          <div class="columns small-6">
                      <label>marca
                          <select name="marca" required="">
                              <option value="">seleccione</option>
                              <?php
                                            while($fila=$res_marcas->fetch()){
                                                echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                                            }
                                        ?>
                          </select>
                          <small class="error">obligatorio</small>
                        </label>
        </div>
           <div class="columns small-6">
                      <label>vida util (horas)
                          <input type="text" name="vida_util" required="" pattern="integer">
                          <small class="error">obligatorio</small>
        </label>
        </div>

         <div class="columns small-12">
             <input type="submit" class="button primary" value="crear registro">
         </div>
    </form>
  
        </div>      
    </div>
</div>