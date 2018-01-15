<?php   include '../plantilla.php';
if($_POST){

    try {

 $insert =$conex->prepare("insert into productos"
         . " values(default,'$_POST[referencia]','$_POST[nombre]','$_POST[unidad_std]','0','$_POST[categoria]'"
         . ",'$_POST[marca]','0',trim('$_POST[notas]'))");

     if($insert->execute()){
         
                                
                         $mensaje= '<div data-alert class="alert-box success round">
                   <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                      </div>';
    }    else{
                                  throw new PDOException();
                              }
 
    } catch (PDOException $pe) {
     
                            $mensaje= '<div data-alert class="alert-box alert round">
          <h5 style="color:white">Error al crear el registro</h5>
          <a href="#" class="close">&times;</a>
        </div>';
    }

 
}
$id=$_SERVER[QUERY_STRING];
$prod=$conex->query("select * from productos where id=$id")->fetch();


?>

<div class="small-12 columns">
    <?php echo $mensaje?>
       <h2>acualizar producto</h2>
       <a href="productos.php" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    
    <div class="row">
        <div class="small-4 columns">
             <label for="">referencia</label>
             <input type="text" name="referencia" required="" value="<?php echo $prod[referencia]?>" readonly="">
             <small class="error">escriba nombre</small>
        </div>
        <div class="small-4 columns">
              <label for="">nombre</label>
              <input type="text" name="nombre" required="" pattern="letters_and_spaces" value="<?php echo $prod[nombre]?>" readonly="">
              <small class="error">escriba nombre</small>
        </div>
        <div class="small-4 columns">
              <label for="">unidad estandard</label>
              <input type="text" value="<?php echo $prod[unidad_standar]?>" readonly="">
              <small class="error">elija opcion</small>
        </div>
    </div>
<div class="row">
    <div class="small-6 columns">
<!--         <label for="">precio</label>
         <input type="text" name="precio" required="" pattern="number">
         <small class="error">escriba precio, debe ser numero</small>-->
    </div>
    <div class="small-6 columns">
<!--         <label for="">unidad</label>
         <select name="unidad" required="">
             <option value="">seleccione</option>
             <?php //  while($fila=$unidades->fetch()){
                                                                //echo "<option value='$fila[unidad]'>$fila[unidad]</option>";
                                                                //}                     
                                        ?>
         </select>
         <small class="error">selecione unidad</small>-->
    </div>
</div>
    
    <div class="row">
        <div class="small-6 columns">
            <label for="">marca</label>
            <input type="text" value="<?php echo $prod[marca]?>" readonly="">
         <small class="error">selecione marca</small>
        </div>
        <div class="small-6 columns">
            <label for="">categoria</label>
            <input type="text" value="<?php echo $prod[categoria]?>" readonly="">
         <small class="error">selecione categoria</small>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
<!--     <label for="">bodega</label>
            <select name="bodega" required="">
                <option value="">seleccione</option>
                <option value="farmacia">farmacia</option>
                <option value="bodega 1">bodega 1</option>       
            </select>
            <small class="error">elija almacen</small>-->
        </div>
        <div class="small-6 columns">
<!--            <label for="">almacen</label>
            <select name="almacen" required="">
                <option value="">seleccione</option>
                <option value="farmacia">farmacia</option>
                <option value="bodega concentrado">bodega concentrado</option>
                <option value="sala ordeno">sala de ordeño</option>
                <option value="utensilios">utensilios</option>
            </select>
            <small class="error">elija almacen</small>-->
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
<!--            <label for="">fecha ingreso producto</label>
            <input type="text" name="fecha_ingreso" required="">
            <small class="error">ingrese fecha</small>-->
        </div>
         <div class="small-6 columns">
<!--            <label for="">fecha vencimiento producto</label>
            <input type="text" name="fecha_vencimiento" required="">
            <small class="error">ingrese fecha</small>-->
        </div>
    </div>
     <div class="row">
        <div class="small-6 columns">
<!--            <label for="">proveedor</label>
            <input type="text" name="proveedor" required="" list="proveedores" class="flexdatalist">
            <small class="error">ingrese proveedor</small>
            <datalist id="proveedores">
                <?php
                                                #while($fila=$proveedores->fetch()){
                                                   #echo "<option $fila[nombre]>$fila[nombre]</option>";
                                                #}
                                                ?>
            </datalist>-->
        </div>
       
    </div>
    <div class="row">
        <div class="small-12 columns">
             <label for="">notas</label>
    <textarea name="notas" id="" cols="30" rows="10"><?php echo $prod[notas]?></textarea>
    <input type="submit" class="button primary" value="crear registro">
        </div>
    </div>
  
   
</form>

</div>
</div>
<script>    
               $("[name=fecha_ingreso],[name=fecha_vencimiento]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});
               $('.flexdatalist').flexdatalist({  minLength: 1,searchContain:true,focusFirstResult:true});
               
</script>