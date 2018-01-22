<?php    include '../plantilla.php';
$animales=$conex->query("select  distinct a.numero,a.nombre
 from animales a 
inner join palpaciones b on a.numero||' '||a.nombre=b.animal
where a.sexo='Hembra' and b.prenada='si'");
$contactos=$conex->query("select nombre from contactos where tipo='empleado'");
if($_POST){

                                $insert=$conex->prepare("insert into partos values(default,'$_POST[fecha]','$_POST[animal]','$_POST[cria]','$_POST[hora]'"
                                        . ",'$_POST[empleado]',trim('$_POST[notas]'),'$_POST[sexo]','$_POST[estado]')");
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

?>

    <div class="small-12 columns">
        <form action="" method="post" data-abide  id="partoform">
    <?php echo $mensaje ?>
       <h2>crear partos</h2>
       <a href="partos.php" class="regresar">regresar</a>
    <div class="row">
        <div class="small-1 columns">
            <label for="">fecha</label>
            <input type="text" name="fecha" required="">
            <small class="error">elija fecha</small>
        </div>
        <div class="small-1 columns">
             <label for="">hora</label>
             <input type="text" name="hora" required="">
             <small class="error">elija hora</small>
        </div>
        <div class="small-3 columns">
                         <label for="">animal</label>
                         <input type="text" name="animal"  class="awesomplete" list="animales" data-minchars="1" data-autofirst>
                         <small class="error">elija animal</small>
                         <datalist id="animales">
                             <?php
                             while ($fila = $animales->fetch()) {
                                 echo "<option value='$fila[numero]-$fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
                             }
                             ?>
                         </datalist>
        </div>
        <div class="small-3 columns">
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
        <div class="small-4 columns">
                       <div class="row collapse">
                <label for="">cria</label>
                <div class="small-5 columns">
                    <input type="text" name="cria" readonly="">
                </div>
                
                <div class="small-1 columns small-pull-7">
                    <span class="postfix">
                        <a href="#" data-reveal-id='modalanimal'><i class="fa fa-plus-circle fa-2x"></i></a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="small-6 columns">

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
        <form  id="modal" data-abide='ajax'>
            <input type="hidden" value="crea_animal" name="canimal">
            <div class="row">
                <div class="small-6 columns">      
                       <label for="">estado</label>
                       <select name="estado" id="" required="">
                        <option value="">seleccione</option>
                        <option value="muerto">muerto</option>
                        <option value="activo">activo</option>
                        <option value="vendido">vendido</option>
                        <option value="externo">externo</option>
                    </select>
              <small class="error">elija estado</small>
                    <label for="">numero
                             <input type="text" name='numero'>
                    </label>
               
                    <label for="">nombre
                          <input type="text" name="nombre">
                    </label>
                  
                </div>
                <div class="small-6 columns">
                       <label for="">fec nacimiento
                             <input type="text" name="fec_nac">
                       </label>
              

            <label for="">peso nac
            <input type="text" name="peso_nac">
            </label>
                    
                    <label for="">sexo </label>
                                     <select name="sexo" id="">
                        <option value="">seleccionar</option>
                        <option value="hembra">hembra</option>
                        <option value="macho">macho</option>
                    </select>
                   
   

                </div>
            </div>

            <div class="row">
                <div class="small-12 columns">
                    <input type="submit" value="listo" class="button primary" id="add_cria">
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
           $('[name=estado]').on('change',function(){
           if($(this).find('option:selected').val()==='muerto') {
                        $('#modal label').hide();
                    }else{
                        $('#modal label').show();
                    }   
           });
           
           $('#add_cria').on('click',function(e){
               e.preventDefault();
                 estado=$('[name=estado]').find('option:selected').val();
                 numero=$('[name=numero]').val();
                 nombre=$('[name=nombre]').val();
                 fecha=$('[name=fec_nac]').val();
                 peso=$('[name=peso_nac]').val();
                 sexo=$('[name=sexo]').val();
                 $.ajax({
                     url:'ajax/cria_parto.php',
                     data:{estado:estado,numero:numero,nombre:nombre,fecha:fecha,peso:peso,sexo:sexo},
                     dataType:'json',
                     method:'post',
                     success:function(data){
                         if(data.resp==='exito' || data.resp==='error'){
                                alert(data.resp);
                                if(data.resp==='exito'){
                                     $('[name=cria]').val(numero+'-'+nombre);
                                }
                            }else{
                                
                                $('[name=cria]').val('-');
                            }
                            $('#partoform').append(data.valores);
                            $('#modalanimal').foundation('reveal', 'close');
                     }
                     
                 });
           });
    </script>