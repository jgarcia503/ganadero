<?php   include '../plantilla.php';
$hembras=$conex->query("select * from animales where sexo='Hembra' and estado not in ('Muerto','Vendido')");
$machos=$conex->query("select * from animales where sexo='Macho'");
$pajillas=$conex->query("select * from pajillas_toros where disponible =true");
$cat_servicio=$conex->query("select * from cat_tipos_servicios");
$bodegas=$conex->query("select * from bodega");

if($_POST){
    extract($_POST);
    include '../php funciones/funciones.php';
    $lineas_prods=$conex->query("select * from plantilla_servicios_requisicion_lns a join productos b on b.referencia=a.producto_id where a.enc_id=$tipo");
    $copia_vals='';
    $total=0;
$subtotal=0;
$consultas=[];
try{
    $conex->beginTransaction();
    $insert1 = $conex->prepare("insert into servicios  values(default,'$fecha','$hora','$animal','$tipo','$inseminador','$padre','$donadora',trim('$notas'),'$cod_pajilla','$hora_visualizacion_celo') returning id");
        if ($insert1->execute()) {
            $ultimo_id = $insert1->fetchColumn();
            $insert2 = $conex->prepare("insert into servicios_requisicion_enc  values(default,'$tipo','$_SESSION[usuario]',now()::text,'$ultimo_id') returning id");
            if ($insert2->execute()) {
                $ultimo_id = $insert2->fetchColumn();
                $sql3 = "insert into servicios_requisicion_lns  values ";
                while ($fila = $lineas_prods->fetch()) {
                    $cant_conv = convertir($fila[unidad], $fila[cantidad]);
                    $total+=($cant_conv * $fila[precio_promedio]);
                    $subtotal = ($cant_conv * $fila[precio_promedio]);
                    $copia_vals.="(default,'" . $fila[producto_id] . "','" . $fila[cantidad] . "','" . $fila[unidad] . "','$ultimo_id','$fila[precio_promedio]','$subtotal'),";

                    #########################################################
                    $consultas[] = "update existencias set existencia=existencia::numeric(1000,2)-$cant_conv "
                            . "where codigo_bodega='$bodega' "
                            . "and codigo_producto='$fila[producto_id]'";

                    $consultas[] = "update productos set cantidad_total=(cantidad_total::numeric(1000,2)-$cant_conv) where referencia='$fila[producto_id]'";

                    $consultas[] = "insert into kardex values (default,'$bodega','$fila[producto_id]',now(),'requisicion-servicio','$ultimo_id','$fila[precio_promedio]','','$cant_conv')";
                }
                $consultas[] = trim($sql3 . $copia_vals, ',');
            }
        }
        foreach ($consultas as $value){
                if(!$conex->prepare($value)->execute()){
                                    throw new PDOException();                                           
                  }
        }
            $conex->commit();
            $mensaje= '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }  
catch (PDOException $pe){
    $conex->rollBack();
              $mensaje= '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }
}
?>

<div class="small-12 columns">
    <?php 
    if(isset($mensaje)){
                        echo $mensaje;
                       echo "<script>setTimeout(function(){window.location='http://". $_SERVER[HTTP_HOST].":8089/ganadero/reproduccion/servicios.php'},1500) </script>";
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
        <div class="small-2 columns">
            <label>
                bodega
                            <select name="bodega">
                <option value="">seleccione</option>
                 <?php
                        while($fila=$bodegas->fetch()){
                            echo "<option value='$fila[codigo]'>$fila[nombre]</option>";
                        }
                        ?>
            </select>
            </label>
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
        $("select[name=tipo]").on('change',function(){
            
            switch($(this).val()){
                case '1':
                    $("[name=donadora],[name=inseminador],[name=cod_pajilla]").parent('label').fadeOut();
                    $("[name=donadora],[name=inseminador]").val('');
                    break;
                case '3':
                case '4':
                    $("[name=donadora],[name=inseminador],[name=cod_pajilla]").parent('label').fadeIn();
                    
                    break;
                case '2':
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
