<?php   include '../plantilla.php';
if($_POST){
    
    try {
        $conex->beginTransaction();

        $insert = $conex->prepare("update potreros set "
                . "nombre='$_POST[nombre]'"
                . ",latitud='$_POST[latitud]'"
                . ",longitud='$_POST[longitud]'"
                . ",extension='$_POST[extension]'"
                . ",unidad_seleccionada='$_POST[unidad]'"
                . ",propiedad='$_POST[propiedad]'"
                . ",valor_alquiler='$_POST[valor_alquiler]'"
                . ",notas=trim('$_POST[notas]') where id=$_POST[potrero_id]");

        #$insert2 = $conex->prepare("update aforos set potrero='$_POST[nombre]' where potreros='$_POST[potrero_ant]'");
        #$insert3 = $conex->prepare("update control_potreros set potrero='$_POST[nombre]' where potreros='$_POST[potrero_ant]'");

        #if ($insert->execute() and $insert2->execute() and $insert3->execute()) {
        if ($insert->execute()) {
            $conex->commit();
            echo '<div data-alert class="alert-box success round">
          <h5 style="color:white">registro actualizado exitosamente</h5>
          <a href="#" class="close">&times;</a>
          </div>';
        } else {
            throw new PDOException();
        }
    } catch (PDOException $pe) {
        $conex->rollBack();
        echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al actualizar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
    }
}

$id=base64_decode($_SERVER[QUERY_STRING]);
$potrero=$conex->query("select * from potreros where id=$id")->fetch();

?>
<div class="small-10 columns">

<form action="" method="post" data-abide>
           <h2>actualizar potrero</h2>
           <a href="potreros.php" class="regresar">regresar</a>
    <div class="row">
        <div class="small-6 columns">
             <label for="">nombre</label>
             <input type="text" name="nombre" value="<?php echo $potrero[nombre]?>">
        </div>
        <div class="small-3 columns">
                <label for="">extension</label>                       
                <input type="text" name="extension"  pattern="number" value="<?php echo floatval( $potrero[extension])?>">
        </div>
        <div class="small-3 columns">
              <label for="">unidad</label>
            <select name="unidad" required="">
                <option value="">seleccione</option>
                <option value="hectarea">hectareas</option>
                <option value="manzana">manzanas</option>
            </select>
       
        </div>
    </div>
    <div class="row">
            <div class="small-2 columns">
             <label for="">latitud</label>
             <input type="text" name="latitud" value="<?php echo $potrero[latitud]?>">
            </div>
             <div class="small-2 columns">
            <label for="">longitud</label>
            <input type="text" name="longitud" value="<?php echo $potrero[longitud]?>">
        
        </div>
        <div class="small-2 columns">
        
            <a href='' id="mapa">
                <i class="fa fa-map-marker fa-3x" aria-hidden="true"></i>
            </a>            
            </div>
        <div class="small-6 columns">
             <label for="">terreno?</label>
            <select name="propiedad" id="propiedad" required="">
                <option value="">seleccione</option>                
                <option value="propio" <?php if($potrero[propiedad]=='propio'){echo 'selected';}?>>propio</option>
                <option value="alquilado" <?php if($potrero[propiedad]=='alquilado'){echo 'selected';}?>>alquilado</option>
            </select>
              
        </div>
    </div>
    
    <div class="row">
        
           <div class="small-6 columns">
               <label for="">valor alquiler anual</label>
               <input type="text" name="valor_alquiler"  value="<?php echo $potrero[valor_alquiler]?>">                
           </div>
       
    </div>
    
    <div class="row">
        <div class="small-12 columns">
             <label for="">notas</label>
             <textarea name="notas" id="" cols="30" rows="10">
        <?php echo $potrero[notas]?>
             </textarea>
             <input type="hidden" value="<?php echo $id?>" name="potrero_id">
             <input type="hidden" value="<?php echo $potrero[nombre]?>" name="potrero_ant">
             <input type="submit" class="button primary" value="actualizar registro">
        </div>
    </div>
    
    
   
    
   
   
</form>
</div>
</div>

<script>
    var valor_alquiler;
    $("[name='valor_alquiler']").val('<?php echo $potrero[valor_alquiler]?>');
        $("#propiedad").on('change',function(){
        if($("#propiedad option:selected").val()==='propio'){
                $("[name='valor_alquiler']").parent('div').hide(1000)
                valor_alquiler=$("[name='valor_alquiler']").val();
                $("[name='valor_alquiler']").val('');
            }else{
                $("[name='valor_alquiler']").parent('div').show(1000);
                $("[name='valor_alquiler']").val(valor_alquiler);
            }
    
    });
    
   if($('#propiedad option:selected').val()=='propio' || $('#propiedad option:selected').val()==''){               
           $("[name='valor_alquiler']").parent('div').hide();
   }
    </script>