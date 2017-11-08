<?php    include '../plantilla.php'; 

$resul_palpaciones=$conex->query("select * from resul_palpaciones");
$animales=$conex->query("select distinct nombre,numero from animales a 
inner join servicios b on b.animal=a.numero ||' '|| a.nombre
where a.sexo='Hembra'");
$contactos=$conex->query("select nombre from contactos where tipo='empleado'");


if($_POST){
    
    if($_POST[prenada]==='si'){
    $fecha_servicio=$conex->query("select fecha from servicios where animal='$_POST[animal]' order by fecha::date desc limit 1");
    $datetime1 = new DateTime($fecha_servicio->fetchColumn());
    $datetime2 = new DateTime( $_POST[fecha]);
    $interval = $datetime1->diff($datetime2);
    
    $dias_prenez=  $interval->format('%a');
    }else{
        $dias_prenez=0;
    }
    
 
  $insert =$conex->prepare("insert into palpaciones"
          . " values(default,'$_POST[fecha]','$_POST[hora]','$_POST[animal]','$_POST[resultado]','$_POST[palpador]'"
          . ",'$dias_prenez','$_POST[prenada]',trim('$_POST[notas]'))");
  
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
<style>
    [type='radio']+[type='radio']{
        margin-left: 25px;
    }
</style>

<div class="small-10 columns">
    <?php echo $mensaje ?>
       <h2>crear palpacion</h2>
       <a href="javascript:history.back(1)" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    <div class="row">
        <div class="small-6 columns">
            <label for="">fecha</label>
            <input type="text" name="fecha" required="">
            <small class="error">eliga fecha</small>
        </div>
        <div class="small-6 columns">
             <label for="">hora</label>
             <input type="text" name="hora" required="">
             <small class="error">eliga hora</small>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <label for="">animal</label>
            
            <small class='error'>elija un animal</small>
    <select name="animal">
        <option value="">seleccione</option>
        <?php
        while($fila=$animales->fetch()){
            echo "<option value='$fila[numero] $fila[nombre]'>$fila[numero] $fila[nombre]</option>";
        }
        ?>
    </select>
        </div>
        <div class="small-6 columns">
            <label for="">palpador</label>
    <select name="palpador" >
        <option value="">seleccione</option>
            <?php
                    while($fila=$contactos->fetch()){
                                                echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                                    }
                                ?>
    </select></div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <label for="">resultado</label>
            <select name="resultado"  required="">
                    <option value="">seleccione</option>
                    <?php
            while($fila=$resul_palpaciones->fetch()){
                ?>
                    <option value="<?php echo $fila[nombre] ?>"><?php echo  $fila[nombre] ?></option>

    <?php
            }
            ?>	
    </select>
            <small class="error">seleccione opcion</small>
        </div>
        <div class="small-6 columns">
            <label for="">prenada</label>
            <input type="radio" name="prenada" value="si"  >  si
            <input type="radio" name="prenada" value="no" checked="">  no
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
<!--            <label for="">dias preñez
                        <input type="text" name="dias_prenez">
            </label>-->

        </div>
        <div class="small-6 columns"></div>
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

        $("[name=dias_prenez]").parent('label').hide();
        /////////////////////////////////////////////////////////////////////////////////
              $("[name=fecha]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy"});
              $("[name=hora]").timepicker({disableTextInput:true,step:15});
              
//              $("[type=radio]").on('change',function(){
//                switch($(this).val()){
//                  case 'si':
//                      $("[name=dias_prenez]").parent('label').fadeIn();
//                      break;
//                  case 'no':
//                      $("[name=dias_prenez]").parent('label').fadeOut();
//                      $("[name=dias_prenez]").val("");
//                      break;
//                            }
//              });
</script>