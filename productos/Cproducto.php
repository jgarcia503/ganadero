<?php   include '../plantilla.php';
if($_POST){
//    $almacen='';
//    switch($_POST[almacen]){
//        case 'farmacia':            
//            $almacen='farmacia';
//            break;
//        case 'bodega concentrado':
//            $almacen='bodega_concentrado';
//            break;
//        case 'sala ordeno':
//            $almacen='sala_ordeno';
//            break;
//        case 'utensilios':            
//            break;
//        
//    }
    try {
           $conex->beginTransaction();
 $insert =$conex->prepare("insert into productos"
         . " values(default,'$_POST[referencia]','$_POST[nombre]','$_POST[unidad_std]','0','$_POST[categoria]'"
         . ",'$_POST[marca]','0',trim('$_POST[notas]'))");
 
// $insert_farmacia=$conex->prepare("insert into $almacen values(default,'$_POST[referencia]','$_POST[fecha_ingreso]'"
//         . ",'$_POST[fecha_vencimiento]','$_POST[proveedor]','$_POST[cantidad]','$_POST[cantidad]')");
 
     if($insert->execute()){
         
                                $conex->commit();
                         $mensaje= '<div data-alert class="alert-box success round">
                   <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                      </div>';
    }    else{
                                  throw new PDOException();
                              }
 
    } catch (PDOException $pe) {
          $conex->rollBack();
                            $mensaje= '<div data-alert class="alert-box alert round">
          <h5 style="color:white">Error al crear el registro</h5>
          <a href="#" class="close">&times;</a>
        </div>';
    }

 
}

$unidades=$conex->query("select * from unidades");
$marcas=$conex->query("select * from marcas");
$categorias=$conex->query("select * from categorias");
$proveedores=$conex->query("select * from contactos where tipo='proveedor'");

?>

<div class="small-10 columns">
    <?php echo $mensaje?>
       <h2>crear producto</h2>
       <a href="productos.php" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    
    <div class="row">
        <div class="small-4 columns">
             <label for="">referencia</label>
             <input type="text" name="referencia" required="">
             <small class="error">escriba nombre</small>
        </div>
        <div class="small-4 columns">
              <label for="">nombre</label>
              <input type="text" name="nombre" required="" pattern="letters_and_spaces">
              <small class="error">escriba nombre</small>
        </div>
        <div class="small-4 columns">
              <label for="">unidad estandard</label>
              <select name="unidad_std" required="">
                  <option value="">seleccione</option>
                  <option value="kg">kilogramos</option>
                  <option value="lt">litros</option>
              </select>
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
         <select name="marca" required="">
             <option value="">seleccione</option>
             <?php  while($fila=$marcas->fetch()){
                                                                echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                                                                }                     
                                        ?>
         </select>
         <small class="error">selecione marca</small>
        </div>
        <div class="small-6 columns">
            <label for="">categoria</label>
         <select name="categoria" required="">
             <option value="">seleccione</option>
             <?php  while($fila=$categorias->fetch()){
                                                                echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                                                                }                     
                                        ?>
         </select>
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
    <textarea name="notas" id="" cols="30" rows="10"></textarea>
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