<?php
include '../plantilla.php';
if($_POST){
    extract($_POST);
    if($acidez_val===''){
        $acidez_val=0.0000;
    }
    if($temperatura_val===''){
        $temperatura_val=0.0000;
    }
    if($agua_val===''){
                $agua_val=0.0000;
    }
    if($reductasa_val===''){
        $reductasa_val=0.0000;
    }
    $sql="insert into analisis_leche values(default,'$fecha','$cantidad','$recepcion','$grasa','$grasa_val','$proteina','$proteina_val','$rcs','$rcs_val',"
            . "'$reductasa','$reductasa_val','$acidez',$acidez_val,$temperatura_val,'$temperatura','$agua',$agua_val)";    
    $res=$conex->prepare($sql);
    error_log($sql);
if($res->execute()){
    $mensaje=  '<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
}
else{
    $mensaje=  '<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
    }
}
?>
<div class="small-12 columns">
    <h2>analisis de leche</h2>
    <?php echo $mensaje?>
    <form action="" method="post">
        <div class="row">
            <div class="small-4 columns">
                <label>fecha
                    <input type="text" name="fecha" readonly="">
                </label>                
            </div>
             <div class="small-4 columns">
                <label>cantidad
                    <input type="text" name="cantidad">
                </label>                
            </div>
             <div class="small-4 columns">
                <label>recepcion No.
                    <input type="text" name="recepcion">
                </label>                
            </div>
        </div>
        <div class='row'>
            <div class="small-3 columns">
                <fieldset>
                    <legend>grasa</legend>
                    <label>%
                    <input type="text" name="grasa">
                    </label>
                    
                    <label>valor
                        <input type="text" name="grasa_val" readonly="">
                    </label>
                </fieldset>
            </div>
                     <div class="small-3 columns">
                <fieldset>
                    <legend>proteina</legend>
                    <label>%
                    <input type="text" name="proteina">
                    </label>
                    
                    <label>valor
                        <input type="text" name="proteina_val" readonly="">
                    </label>
                </fieldset>
            </div>
                     <div class="small-3 columns">
                <fieldset>
                    <legend>RCS</legend>
                    <label>x 1000
                    <input type="text" name="rcs">
                    </label>
                    
                    <label>valor
                        <input type="text" name="rcs_val" readonly="">
                    </label>
                </fieldset>
            </div>
                     <div class="small-3 columns">
                <fieldset>
                    <legend>reductasa</legend>
                    <label>%
                    <input type="text" name="reductasa">
                    </label>
                    
                    <label>valor
                    <input type="text" name="reductasa_val">
                    </label>
                </fieldset>
            </div>
                     <div class="small-3 columns">
                <fieldset>
                    <legend>acidez</legend>
                    <label>%
                    <input type="text" name="acidez">
                    </label>
                    
                    <label>valor
                    <input type="text" name="acidez_val">
                    </label>
                </fieldset>
            </div>
                     <div class="small-3 columns">
                <fieldset>
                    <legend>temperatura</legend>
                    <label>%
                    <input type="text" name="temperatura">
                    </label>
                    
                    <label>valor
                    <input type="text" name="temperatura_val">
                    </label>
                </fieldset>
            </div>
                     <div class="small-3 columns end">
                <fieldset>
                    <legend>% de agua</legend>
                    <label>%
                    <input type="text" name="agua">
                    </label>
                    
                    <label>valor
                    <input type="text" name="agua_val">
                    </label>
                </fieldset>
            </div>
            </div>
        <input type="submit" value="guardar" class="button primary">
    </form>
</div>

</div>

<script>
$("[name=fecha]").datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
      changeYear: true});
  
  $('[name=grasa]').on('change',function(){
        base_grasa=3.5;//es porcentaje  abajo castigo, arriba premio
  grasa_val=parseFloat($('[name=grasa]').val());
  valor_x_botella=(grasa_val-base_grasa)/100;
  num_botellas=parseInt($('[name=cantidad]').val());
  total=num_botellas*valor_x_botella;
  $("[name=grasa_val]").val(total.toFixed(4));
  });
  
    $('[name=proteina]').on('change',function(){
    valores=[3.11,3.12,3.13,3.14,3.15];    
  proteina_val=parseFloat($('[name=proteina]').val());
  if(_.indexOf(valores,proteina_val)===-1){
      //castigo
      if(proteina_val<3.11){
          valor_x_botella=(3.11-proteina_val)/100;
          num_botellas=parseInt($('[name=cantidad]').val());
            total=num_botellas*valor_x_botella;
            $("[name=proteina_val]").val(Math.abs(total.toFixed(4)));
      }
      //premio
      if(proteina_val>3.15){
          valor_x_botella=(3.15-proteina_val)/100;
          num_botellas=parseInt($('[name=cantidad]').val());
            total=num_botellas*valor_x_botella;
            $("[name=proteina_val]").val(Math.abs(total.toFixed(4)));
      }
  }else{
                valor_x_botella=(valores[_.indexOf(valores,proteina_val)]-proteina_val)/100;
          num_botellas=parseInt($('[name=cantidad]').val());
            total=num_botellas*valor_x_botella;
            $("[name=proteina_val]").val(Math.abs(total.toFixed(4)));
  }
  
  
  });
  
    $('[name=rcs]').on('change',function(){
        base_rcs=600;//x1000 abajo premio,arriba castigo
  rcs_val=parseFloat($('[name=rcs]').val());
  valor_x_botella=((rcs_val-base_rcs)/1000)/20;//se divide entre 20 porque cada 20 es un punto
  num_botellas=parseInt($('[name=cantidad]').val());
  total=num_botellas*valor_x_botella;
  $("[name=rcs_val]").val(Math.abs(total.toFixed(4)));
  });
  
</script>
