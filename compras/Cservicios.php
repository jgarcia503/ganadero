<?php 
include '../plantilla.php';
if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')==='POST'){
    $sql="insert into compras_servicios values(default,'$_POST[fecha]','$_POST[tipo_servicio]','$_POST[proveedor]','$_POST[costo]',trim('$_POST[notas]'))";
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
  <h2>pago de servicios</h2>
  <a href="servicios.php" class="regresar">regresar</a>
    <form method="post" action="" data-abide>
  <div class="row">
      <?php echo $mensaje ?>
      <div class="small-6 columns">
          <label>fecha</label>
          <input type="text" name="fecha" readonly="" required="">
          <small class="error">requerido</small>
      </div>
            <div class="small-6 columns">
            <label>tipo servicio</label>
                <select name="tipo_servicio" required="">
                    <option value="">seleccione</option>
                    <option value="pago_veterinario">pago veterinario</option>
                    
                </select>
          <small class="error">requerido</small>
      </div>

  </div>
        <div class="row">
            <div class="small-6 columns">
                <label>proveedor</label>
                <input type="text" name="proveedor" required="">
                <small class="error">requerido</small>
            </div>
            <div class="small-6 columns">
                <label>costo</label>
                <input type="text" name="costo" required="">
                <small class="error">requerido</small>
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <label>notas</label>
                <textarea name="notas"></textarea>
            </div>
            <div class="small-6 columns"></div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <button type="submit">crear registro</button>
            </div>
            <div class="small-6 columns"></div>
        </div>
  </form>
                
</div>
</div>

<script>
    $("[name=fecha]").datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
      changeYear: true});
</script>