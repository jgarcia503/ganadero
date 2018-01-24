<?php   include '../plantilla.php';
$hembras=$conex->query("select * from animales where sexo='Hembra' and estado not in ('Muerto','Vendido')");
$machos=$conex->query("select * from animales where sexo='Macho'");
$pajillas=$conex->query("select * from pajillas_toros where disponible =true");
$cat_servicio=$conex->query("select * from cat_tipos_servicios");
if($_POST){
$reload='window.location.reload';
 $insert =$conex->prepare("insert into servicios"
         . " values(default,'$_POST[fecha]','$_POST[hora]','$_POST[animal]','$_POST[tipo]','$_POST[inseminador]'"
         . ",'$_POST[padre]','$_POST[donadora]',trim('$_POST[notas]'),'$_POST[cod_pajilla]','$_POST[hora_visualizacion_celo]')");
     if($insert->execute()){
         $sql_update="update pajillas_toros set disponible=false where codigo_pajilla='$_POST[cod_pajilla]'";
         $res=$conex->prepare($sql_update);
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
}
?>

<div class="small-12 columns">
    <?php 
    if($mensaje !==''){
                        echo $mensaje;
                       echo "<script>setTimeout(function(){window.location='http://localhost:8089/ganadero/reproduccion/servicios.php'},1500) </script>";
    }
    ?>
       <h2>crear servicio</h2>
       <a href="servicios.php" class="regresar">regresar</a>
    <form action="" method="post" data-abide>
    <div class="row">
        <div class="small-2 columns">
          
          
                     <label for="">fecha</label>
            <input type="text" name="fecha" required="">
            <small class="error">eliga una fecha</small>
         
           
        </div>
        <div class="small-2 columns">
            <label for="">hora de servicio</label>
            <input type="text" name="hora" required="">
            <small class="error">eliga una fecha</small>
        </div>
                <div class="small-2 columns">
            <label for="">hora visualizacion celo</label>
            <input type="text" name="hora_visualizacion_celo" required="">
            <small class="error">eliga una fecha</small>
        </div>
        <div class="small-2 columns">
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
                <div class="small-2 columns end">
             <label for="">toro</label>
            
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
        

            <div class="small-2 columns">
                        <label for="">tipo</label>
            <select name="tipo" id="">
        <option value="">seleccionar</option>
        <?php
        while($fila=$cat_servicio->fetch()){
            echo "<option value='$fila[id]'>$fila[nombre] </option>";
        }
        ?>
    </select>
        </div>
        <div class="small-2 columns">
             <label for="">donadora
             <input type="text" name="donadora">
             </label>
    
        </div>
        <div class="small-2 columns">
            <label for="" id="inseminador">inseminador
                  <input type="text" name="inseminador">
              </label>
    
        </div>
                  <div class="small-2 end columns">
            <label for="" id="inseminador">pajillas
                <select name="cod_pajilla" required="">
                    <option value="">seleccione</option>
                    <?php
                    while($fila=$pajillas->fetch()){
                        echo "<option value='$fila[codigo_pajilla]'>$fila[codigo_toro]-$fila[codigo_pajilla]</option>";
                    }
                            ?>
                </select>
                <small class="error">eliga una pajilla</small>
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
                    $("[name=donadora],[name=inseminador],[name=cod_pajilla]").parent('label').fadeOut();
                    $("[name=donadora],[name=inseminador]").val('');
                    break;
                case 'te':
                case 'fiv':
                    $("[name=donadora],[name=inseminador],[name=cod_pajilla]").parent('label').fadeIn();
                    
                    break;
                case 'inseminacion':
                    $("[name=inseminador]").parent('label').fadeIn();
                    $("[name=cod_pajilla]").parent('label').fadeIn();
                    $("[name=donadora]").parent('label').fadeOut();
                    $("[name=donadora]").val('');
                    break;
            }

        });
        
        /////////////////////////////////////////////////////////////////////////////////
              $("[name=fecha]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy"});
              $("[name=hora]").timepicker({disableTextInput:true,step:15});
              $("[name=hora_visualizacion_celo]").timepicker({disableTextInput:true,step:15});

    </script>
