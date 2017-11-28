<?php    include '../plantilla.php'; 

$resul_palpaciones=$conex->query("select * from resul_palpaciones");
$animales=$conex->query("select distinct nombre,numero from animales a 
inner join servicios b on b.animal=a.numero ||' '|| a.nombre
where a.sexo='Hembra'");
$contactos=$conex->query("select nombre from contactos where tipo='empleado'");


if($_POST){
    $resultado=$conex->query("select nombre from resul_palpaciones where id=$_POST[resultado]")->fetchColumn();
    if($_POST[prenada]==='si'){
    $fecha_servicio=$conex->query("select fecha from servicios where animal='$_POST[animal]' order by fecha::date desc limit 1");
    $datetime1 = new DateTime($fecha_servicio->fetchColumn());
    $datetime2 = new DateTime( $_POST[fecha]);
    $interval = $datetime1->diff($datetime2);
    
    $dias_prenez=  $interval->format('%a');
    }else{
        $dias_prenez=0;
    }
    
 $sql="insert into palpaciones"
          . " values(default,'$_POST[fecha]','$_POST[hora]','$_POST[animal]','$resultado','$_POST[palpador]'"
          . ",'$dias_prenez','$_POST[prenada]',trim('$_POST[notas]'),";
 
  if($_POST['resultado']=='9'){
     $sql.="'$_POST[cuerno]','',";
 }
 
 if($_POST['resultado']=='11'){
     $sql.="'','$_POST[grado_suciedad]',";
 }
 
 if($_POST['resultado']!=='9' and $_POST['resultado']!=='11'){
     $sql.="'','',";
 }
 
    if($_POST[prenada]==='si'){
        
        $sql.="'$_POST[meses]')";
        
    }
    else{
        
        $sql.="'')";
        
    }
  $insert =$conex->prepare($sql);
  
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
       <a href="palpaciones.php" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    <div class="row">
        <div class="small-3 columns">
            <label for="">fecha</label>
            <input type="text" name="fecha" required="">
            <small class="error">eliga fecha</small>
        </div>
        <div class="small-3 columns">
             <label for="">hora</label>
             <input type="text" name="hora" required="">
             <small class="error">eliga hora</small>
        </div>
                <div class="small-3 columns">
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
        <div class="small-3 columns">
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
        <div class="small-5 columns">
            <label for="">resultado</label>
            <select name="resultado"  required="">
                    <option value="">seleccione</option>
                    <?php
            while($fila=$resul_palpaciones->fetch()){
                ?>
                    <option value="<?php echo $fila[id] ?>" data-id="<?php echo $fila[id]?>"><?php echo  $fila[nombre] ?></option>

    <?php
            }
            ?>	
    </select>
            <small class="error">seleccione opcion</small>
        </div>
        <div class="small-2 columns">

            <label for="" id="suciedad" class="hide">nivel suciedad
                   <select name="grado_suciedad" required="">
                <option value="">seleccione</option>
                <option value="leve">leve</option>
                <option value="regular">regular</option>
                <option value="severo">severo</option>
            </select>
                   <small class="error">seleccione opcion</small>
            </label>
             
            <label for="" id="cuerno" class="hide">cuerno
                   <select name="cuerno" required="">
                <option value="">seleccione</option>
                <option value="izquierdo">izquierdo</option>
                <option value="derecho">derecho</option>                    
            </select>
                <small class="error">seleccione opcion</small>
                </label>
            
        </div>
        <div class="small-2 columns">
            <label for="">prenada</label>
            <input type="radio" name="prenada" value="si"  >  si
            <input type="radio" name="prenada" value="no" checked="">  no
        </div>
              <div class="small-2 columns">
                  <label for="" class="hide">meses de preñez
                <input type="text" name="meses" required="">
                <small class="error">requerido</small>
            </label>            
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
              
              $('[name=resultado]').on('change',function(e){
                                switch($(this).find('option:selected').data('id')){
                                    case 11:
                                        $("#suciedad").fadeIn();
                                        $("#cuerno").fadeOut();
                                        break;
                                    case 9:
                                     $("#cuerno").fadeIn();
                                         $("#suciedad").fadeOut();                                         
                                         break;
                                                                            
                                    default:
                                         $("#suciedad").fadeOut();
                                         $("#cuerno").fadeOut();
                                         break;
                                }
              });
              $("[type=radio]").on('change',function(){
                switch($(this).val()){
                  case 'si':
                      $("[name=meses]").parent('label').fadeIn();
                      break;
                  case 'no':
                      $("[name=meses]").parent('label').fadeOut();
                      $("[name=meses]").val("");
                      break;
                            }
              });
</script>