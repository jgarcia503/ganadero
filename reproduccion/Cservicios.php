<?php   include '../plantilla.php';
$hembras=$conex->query("select * from animales where sexo='Hembra'");
$machos=$conex->query("select * from animales where sexo='Macho'");

if($_POST){

 $insert =$conex->prepare("insert into servicios"
         . " values(default,'$_POST[fecha]','$_POST[hora]','$_POST[animal]','$_POST[tipo]','$_POST[inseminador]'"
         . ",'$_POST[padre]','$_POST[donadora]',trim('$_POST[notas]'))");
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
       <h2>crear servicio</h2>
       <a href="javascript:history.back(1)" class="regresar">regresar</a>
    <form action="" method="post" data-abide>
    <div class="row">
        <div class="small-6 columns">
          
          
                     <label for="">fecha</label>
            <input type="text" name="fecha" required="">
            <small class="error">eliga una fecha</small>
         
           
        </div>
        <div class="small-6 columns">
            <label for="">hora</label>
            <input type="text" name="hora" required="">
            <small class="error">eliga una fecha</small>
        </div>
        <div class="small-6 columns">
            <label for="">animal</label>
            
            <select name="animal">
                <option value="">seleccione</option>
                       <?php
        while($fila=$hembras->fetch()){
            echo "<option value='$fila[numero] $fila[nombre]'>$fila[numero] $fila[nombre]</option>";
        }
        ?>
                </select>
             <small class="error">eliga un animal</small>
        </div>

        <div class="small-6 columns">
             <label for="">padre</label>
            
            <select name="padre">
                <option>seleccione</option>
                <?php
                        while($fila=$machos->fetch()){
                            echo "<option value='$fila[numero]-$fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
                        }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
            <div class="small-6 columns">
                        <label for="">tipo</label>
            <select name="tipo" id="">
        <option value="">seleccionar</option>
        <option value="monta directa">monta directa</option>
        <option value="inseminacion">inseminacion</option>
        <option value="fiv">fecundacion in vitro</option>
        <option value="te">tranferencia de embriones</option>
    </select>
        </div>
           <div class="small-6 columns">

        </div>
        
        </div>
        <div class="row">
        <div class="small-6 columns">
             <label for="">donadora
             <input type="text" name="donadora">
             </label>
    
        </div>
        <div class="small-6 columns">
            <label for="" id="inseminador">inseminador
                  <input type="text" name="inseminador">
              </label>
    
        </div>
    </div>
     

    
    <div class="row">
        <div class="small-12 columns">
             <label>notas</label>
    <textarea name="notas" id="" cols="30" rows="10"></textarea>
    <input type="submit" class="button primary" value="crear registro">
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
              $("[name=fecha]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy"});
              $("[name=hora]").timepicker({disableTextInput:true,step:15});

    </script>
