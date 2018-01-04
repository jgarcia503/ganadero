<?php   include '../../plantilla.php';
$sql="select * from animales";
$res=$conex->query($sql)->fetchAll();

if($_POST){
    extract($_POST);
  $insert="insert into visita_medica values(default,'$localizacion','$tecnico',$vacas_prod,$terneras,'$fecha','$tipo',$novillas,$horras,'$costo',$botellas,'$socio','$animal',trim('$descripcion'))";
  $res=$conex->prepare($insert);
  
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


 <div class="small-12 columns">
<h2>registrar visita medica</h2>
<?php echo $mensaje?>
<form action="" method="post" data-abide>
    <div class="row">
    <div class="small-3 columns">
    <label>localizacion
        <input type="text" name="localizacion">
    </label>
        </div>
        <div class="small-3 columns">
    <label>tecnico
        <input type="text" name="tecnico">
    </label>
        </div>
    
    <div class="small-3 columns">
    <label>vacas prod.
        <input type="text" name="vacas_prod">
    </label>
     </div>
        <div class="small-3 columns">
    <label>terneras
        <input type="text" name="terneras">
    </label>
     </div>
     </div>
    <div class="row">
    <div class="small-3 columns">
    <label>fecha
        <input type="text" name="fecha" readonly="">
    </label>
     </div>
    <div class="small-3 columns">
    <label>tipo de visita
        <select name="tipo" required="">
            <option value="">selccione</option>
            <option value="rutinaria">rutinaria</option>
            <option value="prueba">prueba</option>
            <option value="cirugia">cirugia</option>
        </select>
        <small class="error">obligatorio</small>
    </label>
     </div>
            <div class="small-3 columns">
    <label>novillas
        <input type="text" name="novillas">
    </label>
     </div>
               <div class="small-3 columns">
    <label>vacas horras
        <input type="text" name="horras">
    </label>
     </div>
     </div>
    <div class='row'>
               <div class="small-3 columns">
    <label>animal
        <select name="animal" required="">
            <option value="">seleccione</option>
            <?php
            foreach ($res as $value) {
                echo "<option value='$value[numero]'>$value[nombre]</option>";
            }
            ?>
        </select>
        <small class="error">obligatorio</small>
    </label>
     </div>
                   <div class="small-3 columns">
    <label>costo visita
        <input type="text" name="costo" required="" class="cantidad">
        <small class="error">obligatorio</small>
    </label>
     </div>
           <div class="small-3 columns">
    <label>prod. botellas
        <input type="text" name="botellas">
    </label>
     </div>
               <div class="small-3 columns end">
    <label>socio
        <select name="socio">
            <option value="si">si</option>
            <option value="no">no</option>
        </select>
    </label>
     </div>
     </div>
    <div class="small-12 columns">
        <textarea rows="35" style="resize: none" name="descripcion"></textarea>
     </div>
    <div class="small-12 columns">
        <input type="submit" class="button primary">
     </div>
    
</form>
    
</div>

<script>
    $(".cantidad").mask('000,000,000,000,000.00', {reverse: true});
      $('[name=animal]').parent('label').hide();
      
    $("[name=fecha]").datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050", changeYear: true});
    
    $('[name=tipo]').on('change',function(){
        if($(this).val()==='rutinaria'){
            $('[name=animal]').parent('label').hide(1500);
        }else{
                        $('[name=animal]').parent('label').show(1500);
        }
    });
</script>