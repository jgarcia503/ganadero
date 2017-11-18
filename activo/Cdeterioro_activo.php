<?php
include '../plantilla.php';
if($_POST){
    $desc=$_POST['descripcion'];
    $costo=$_POST['costo_x_hora'];
    $res=$conex->prepare("insert into deterioro_activo values (default,'$desc',$costo)");
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

?>

<div class="small-10 columns"  >
    <?php echo $mensaje ?>
    <h2>deterioro de activo</h2>
    <div class="row">
     <form action="" method="post">
             <div class="columns small-6">
                      <label>descripcion activo
                          <input type="text" name="descripcion">
        </label>
        </div>
            <div class="columns small-6">
                   <label>costo deterioro por hora
                       <input type="text" name="costo_x_hora">
        </label>
        </div>
         <div class="columns small-12">
             <input type="submit" class="button primary" value="crear registro">
         </div>
    </form>
  
        </div>      
    </div>
</div>