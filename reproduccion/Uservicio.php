<?php   include '../plantilla.php';
$animales=$conex->query("select * from animales");

if($_POST){

 $insert =$conex->prepare("update servicios set fecha='$_POST[fecha]'"
         . ",hora='$_POST[hora]'"
         . ",animal='$_POST[animal]'"
         . ",tipo='$_POST[tipo]'"
         . ",inseminador='$_POST[inseminador]'"
         . ",padre='$_POST[padre]'"
         . ",donadora='$_POST[donadora]'"
         . ",notas=trim('$_POST[notas]') where id=$_POST[servicio_id]");
     if($insert->execute()){
        echo '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }else{
      echo '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
    </div>';
}
 
}


$id=base64_decode($_SERVER[QUERY_STRING]);
$servicios=$conex->query("select * from servicios where id=$id")->fetch();
?>


<div class="small-10 columns">
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
    <form action="" method="post">
    <div class="row">
        <div class="small-6 columns">
            <label for="">fecha</label>
            <input type="text" name="fecha" value="<?php echo $servicios[fecha] ?>">
        </div>
        <div class="small-6 columns">
            <label for="">hora</label>
    <input type="text" name="hora"  value="<?php echo $servicios[hora] ?>">
        </div>
        <div class="small-6 columns">
            <label for="">animal</label>
            <input type="text" name="animal" class="awesomplete" list="animales" data-minchars="1"  value="<?php echo $servicios[animal] ?>"> 
        <datalist id="animales">
        <?php
        while($fila=$animales->fetch()){
            echo "<option value='$fila[numero] $fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
        }
        ?>
    </datalist>
        </div>
        <div class="small-6 columns">
             <label for="">padre</label>
    <input type="text" name="padre"  value="<?php echo $servicios[padre] ?>">
        </div>
    </div>
    <div class="row">
            <div class="small-6 columns">
              <label for="">tipo</label>
            <select name="tipo" id="">
        <option value="">seleccionar</option>
        <option value="monta directa">monta directa</option>
        <option value="inseminacion">inseminacion</option>
        <option value="fiv">fiv</option>
        <option value="te">te</option>
    </select>
        </div>
           <div class="small-6 columns">

        </div>
        
        </div>
        <div class="row">
        <div class="small-6 columns">
             <label for="">donadora
             <input type="text" name="donadora"  value="<?php echo $servicios[donadora] ?>">
             </label>
    
        </div>
        <div class="small-6 columns">
            <label for="" id="inseminador">inseminador
                  <input type="text" name="inseminador"  value="<?php echo $servicios[inseminador] ?>">
              </label>
    
        </div>
    </div>
     

    
    <div class="row">
        <div class="small-12 columns">
             <label>notas</label>
    <textarea name="notas" id="" cols="30" rows="10"> <?php echo $servicios[notas] ?></textarea>
    <input type="hidden" name="servicio_id" value="<?php echo $id ?>">
    <input type="submit" class="button primary">
        </div>
    </div>
    
   
</form>

</div>
</div>
<script>
        $("select").on('change',function(){
            
            switch($(this).val()){
                case 'monta directa':
                    $("[name=donadora],[name=inseminador]").parent('label').fadeOut();
                    $("[name=donadora],[name=inseminador]").val('');
                    break;
                case 'te':
                case 'fiv':
                    $("[name=donadora],[name=inseminador]").parent('label').fadeIn();
                    
                    break;
                case 'inseminacion':
                    $("[name=inseminador]").parent('label').fadeIn();
                    $("[name=donadora]").parent('label').fadeOut();
                    $("[name=donadora]").val('');
                    break;
            }

        });
        
        /////////////////////////////////////////////////////////////////////////////////
              $("[name=fecha]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});
                $("[name=hora]").timepicker({disableTextInput:true,step:15});

    </script>

