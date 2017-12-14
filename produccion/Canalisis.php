<?php
include '../plantilla.php';
if($_POST){
    extract($_POST);
    $sql="insert into analisis_leche values(default,'$fecha','$cantidad','$recepcion','$grasa','$grasa_val','$proteina','$proteina_val','$rcs','$rcs_val',"
            . "'$reductasa','$reductasa_val','$acidez','$acidez_val','$temperatura','$temperatura_val','$agua','$agua_val')";
    
    $res=$conex->prepare($sql);
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
<div class="small-10 columns">
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
                    <input type="text" name="grasa_val">
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
                    <input type="text" name="proteina_val">
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
                    <input type="text" name="rcs_val">
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
</script>
