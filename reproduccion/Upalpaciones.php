<?php    include '../plantilla.php'; 
$resul_palpaciones=$conex->query("select * from resul_palpaciones");
$animales=$conex->query("select * from animales");
if($_POST){
    var_dump($_POST);
  $insert =$conex->prepare("update palpaciones set fecha='$_POST[fecha]'"
          . ",hora='$_POST[hora]'"
          . ",animal='$_POST[animal]'"
          . ",resultado='$_POST[resultado]'"
          . ",palpador='$_POST[palpador]'"
          . ",dias_prenez='$_POST[dias_prenez]'"
          . ",prenada='$_POST[prenada]'"
          . ",notas=trim('$_POST[notas]') where id=$_POST[palpacion_id]");
  
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
$palpaciones=$conex->query("select * from palpaciones where id=$id")->fetch();

?>
<style>
    [type='radio']+[type='radio']{
        margin-left: 25px;
    }
</style>

<div class="small-10 columns">
<form action="" method="post">
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
    <div class="row">
        <div class="small-6 columns">
            <label for="">fecha</label>
    <input type="text" name="fecha" value="<?php echo  $palpaciones[fecha] ?>">
        </div>
        <div class="small-6 columns">
             <label for="">hora</label>
    <input type="text" name="hora" value="<?php echo  $palpaciones[hora]?>">
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <label for="">animal</label>
                     <input type="text" name="animal" class="awesomplete" list="animales" data-minchars="1"  value="<?php echo  $palpaciones[animal]?>"> 
    <datalist id="animales">
        <?php
        while($fila=$animales->fetch()){
            echo "<option value='$fila[numero]-$fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
        }
        ?>
    </datalist>
        </div>
        <div class="small-6 columns">
            <label for="">palpador</label>
    <select name="palpador" id="">
        <option value="yo">yo</option>
    </select></div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <label for="">resultado</label>
    <select name="resultado" id="">
        <option value="seleccione">seleccione</option>
        <?php
while($fila=$resul_palpaciones->fetch()){
    
    
    ?>
        <option value="<?php echo $fila[nombre] ?>" <?php if($fila[nombre]==$palpaciones[resultado]) echo 'selected' ?>><?php echo  $fila[nombre] ?></option>

 <?php
}
?>	
    </select>
        </div>
        <div class="small-6 columns">
            <label for="">prenada</label>
            <input type="radio" name="prenada" value="si"  >  si
            <input type="radio" name="prenada" value="no" checked="">  no

        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <label for="">dias preñez
                        <input type="text" name="dias_prenez"  value="<?php echo  $palpaciones[dias_prenez]?>">
            </label>

        </div>
        <div class="small-6 columns"></div>
    </div>
    
    <div class="row">
        <div class="small-12 columns">
            <label for="">notas</label>
            <textarea name="notas" id="" cols="30" rows="10">
                 <?php echo  $palpaciones[notas]?>
            </textarea>
            <input type="hidden" value="<?php echo $id?>" name="palapcion_id">
            <input type="submit" class="button primary" value="actualizar registro">
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
              
              $("[type=radio]").on('change',function(){
                switch($(this).val()){
                  case 'si':
                      $("[name=dias_prenez]").parent('label').fadeIn();
                      break;
                  case 'no':
                      $("[name=dias_prenez]").parent('label').fadeOut();
                      $("[name=dias_prenez]").val("");
                      break;
                            }
              });

    </script>