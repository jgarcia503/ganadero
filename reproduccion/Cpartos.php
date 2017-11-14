<?php    include '../plantilla.php';
$animales=$conex->query("select * from animales where sexo='Hembra'");
$contactos=$conex->query("select nombre from contactos where tipo='empleado'");
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
                               $mensaje= '<div data-alert class="alert-box success round">
                         <h5 style="color:white">animal creado exitosamente</h5>
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

    <div class="small-10 columns">
<form action="" method="post" data-abide>
    <?php echo $mensaje ?>
       <h2>crear partos</h2>
       <a href="partos.php" class="regresar">regresar</a>
    <div class="row">
        <div class="small-6 columns">
            <label for="">fecha</label>
            <input type="text" name="fecha" required="">
            <small class="error">elija fecha</small>
        </div>
        <div class="small-6 columns">
             <label for="">hora</label>
             <input type="text" name="hora" required="">
             <small class="error">elija hora</small>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <div class="row collapse">
                     <label for="">animal</label>
                <div class="small-10 columns">
                           
                    <input type="text" name="animal"  class="awesomplete" list="animales" data-minchars="1" data-autofirst>
                    <small class="error">elija animal</small>
                                <datalist id="animales">
        <?php
        while($fila=$animales->fetch()){
            echo "<option value='$fila[numero]-$fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
        }
        ?>
    </datalist>
                </div>
                <div class="small-2 columns">
                    <span class="postfix">
                        <a href="#" data-reveal-id='modalanimal'>
                            <i class="fa fa-plus-circle fa-2x" ></i>
                        </a>
                    </span>
                </div>
            </div>



        </div>
        <div class="small-6 columns">
            <div class="row collapse">
                <label for="">cria</label>
                <div class="small-10 columns">
                    <input type="text" name="cria"  class="awesomplete" list="animales" data-minchars="1" data-autofirst>
                </div>
                
                <div class="small-2 columns">
                    <span class="postfix">
                        <a href="#" data-reveal-id='modalanimal'><i class="fa fa-plus-circle fa-2x"></i></a>
                    </span>
                </div>
            </div>
            
    
        </div>
    </div>
    
    <div class="row">
        <div class="small-6 columns">
            <label for="">empleado</label>
    <select name="empleado" >
        <option value="yo">seleccionar</option>
           <?php
                    while($fila=$contactos->fetch()){
                                                echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                                    }
                                ?>
    </select>
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
    
<!-- EMPIEZA MODAL  -->
    <div id="modalanimal" class="reveal-modal" data-reveal>
        <h2>crear animal</h2>
        <form action="" method="post" >
            <input type="hidden" value="crea_animal" name="canimal">
            <div class="row">
                <div class="small-6 columns">      
                    <label for="">numero</label>
                    <input type="text" name='numero'>
                    <label for="">nombre</label>
                    <input type="text" name="nombre">

                    <label for="">fec nacimiento</label>
                    <input type="text" name="fec_nac">

                   


                </div>
                <div class="small-6 columns">
            <label for="">peso nac</label>
                    <input type="text" name="peso_nac">
                    <label for="">sexo</label>
                    <select name="sexo" id="">
                        <option value="">seleccionar</option>
                        <option value="hembra">hembra</option>
                        <option value="macho">macho</option>
                    </select>
                    <label for="">estado</label>
                    <select name="estado" id="">
                        <option value="">seleccione</option>
                        <option value="muerto">muerto</option>
                        <option value="activo">activo</option>
                        <option value="vendido">vendido</option>
                        <option value="externo">externo</option>
                    </select>

                </div>
            </div>

            <div class="row">
                <div class="small-12 columns">
                    <input type="submit" value="enviar" class="button primary">
                </div>
            </div>

        </form>
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>

    </div>

<!--TERMINA MODAL-->   


</div>
</div>
<script>
            $("[name=fecha],[name=fec_nac]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});
           $("[name=hora]").timepicker({disableTextInput:true,step:15});
    </script>