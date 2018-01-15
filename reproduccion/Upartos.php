<?php    include '../plantilla.php';

if($_POST){
    if(isset($_POST[canimal])){
                            $insert =$conex->prepare("insert into animales (numero,nombre,fecha_nacimiento,peso_nacimiento,sexo,estado) 
                                values('$_POST[numero]','$_POST[nombre]','$_POST[fec_nac]','$_POST[peso_nac]','$_POST[sexo]'"
                                                            . ",'$_POST[estado]')");
                            if($insert->execute()){
                                echo "exito";
                            }else{
                                echo "error";
                            }
    }
    
    else{
                                $insert=$conex->prepare("insert into partos values(default,'$_POST[fecha]','$_POST[animal]','$_POST[cria]','$_POST[hora]'"
                                        . ",'$_POST[empleado]',trim('$_POST[notas]'))");
                                    if($insert->execute()){
                                echo '<div data-alert class="alert-box success round">
                         <h5 style="color:white">animal creado exitosamente</h5>
                          <a href="#" class="close">&times;</a>
                        </div>';
                            }else{
                              echo '<div data-alert class="alert-box alert round">
                          <h5 style="color:white">Error al insertar el registro</h5>
                          <a href="#" class="close">&times;</a>
                        </div>';
                        }

        
    }

    
}

$id=base64_decode($_SERVER[QUERY_STRING]);
$partos=$conex->query("select * from partos where id=$id")->fetch();
?>

    <div class="small-12 columns">
        <a href="partos.php" class="regresar">regresar</a>
<form action="" method="post">
    
    
    <div class="row">
        <div class="small-6 columns">
            <label for="">fecha</label>
            <input type="text" name="fecha" value="<?php echo $partos[fecha]?>">
        </div>
        <div class="small-6 columns">
             <label for="">hora</label>
    <input type="text" name="hora" value="<?php echo $partos[hora]?>">
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <div class="row collapse">
                      <label for="">animal</label>
                <div class="small-12 columns">
                          
                            <input type="text" name="animal" value="<?php echo $partos[animal]?>">
                            
                </div>
   
            </div>

        </div>
        <div class="small-6 columns">
            <div class="row collapse">
                <label for="">cria</label>
                <div class="small-12 columns">
                    <input type="text" name="cria" value="<?php echo $partos[cria]?>">
                </div>

            </div>
            
    
        </div>
    </div>
    
    <div class="row">
        <div class="small-6 columns">
            <label for="">empleado</label>
    <select name="empleado" >
        <option value="yo">seleccionar</option>
    </select>
        </div>
        <div class="small-6 columns"></div>
    </div>
    
    <div class="row">
        <div class="small-12 columns">
            <label for="">notas</label>
            <textarea name="notas" id="" cols="30" rows="10">
                <?php echo $partos[notas]?>
            </textarea>
            <input type="submit" class="button primary" value="actualizar registro">
        </div>
    </div>
    
    
</form>    

</div>
</div>
<script>
            $("[name=fecha],[name=fec_nac]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});
           $("[name=hora]").timepicker({disableTextInput:true,step:15});
    </script>