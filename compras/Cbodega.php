<?php
include '../plantilla.php';

if($_POST){
    $sql="insert into bodega values(default,'$_POST[codigo]','$_POST[nombre]','$_POST[notas]')";
    $insert=$conex->prepare($sql);
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
<div class="small-12 columns">
       <?php echo $mensaje ?>
    <h2>crear bodega</h2>
    <a href="bodegas.php" class="regresar">regresar</a>
    <span id="mensaje"></span>
    <form data-abide method="post" action="">
            <div class="row">
                <!--<div class="small-12 columns"><h3 style="color: white;background-color: black" class="text-center">factura</h3></div>-->
        
        <div class="small-6 columns ">
            <label>codigo</label>
            <input type="text" name="codigo">
         </div>   
                <div class="small-6 columns">
            <label>nombre</label>
            <input type="text" name="nombre">
        </div>
        
         
    </div>
        <div class="row">
            <div class="small-6 columns">
             <label>notas</label>
             <textarea name="notas"></textarea>
        </div>
        </div>
        <button type="submit">crear registro</button>
    </form>   
    </div>


</div>