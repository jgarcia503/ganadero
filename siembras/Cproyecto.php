<?php   include '../plantilla.php';  
$potreros=$conex->query("select * from potreros");
$tipos_cultivo=$conex->query("select * from tipo_vegetacion");

$bodegas=$conex->query("select distinct codigo,nombre from bodega a 
                        inner join existencias b on 
                        a.codigo=b.codigo_bodega");
?>

<div class="small-10 columns">
      <span id="mensaje"></span>
    <h2>siembra</h2>
    <a href="proyectos.php" class="regresar">regresar</a>
    <form data-abide='ajax' id='proyecto'>
        <div class="row">
            <input type="hidden" value="false" name="cerrado">
             <div class="small-6 columns">
      
                     <label for="">nombre </label>
                     <input type="text" name="nombre" id="nombre"  required="">
                     <small class="error">requerido</small>
             </div>
            <div class="small-6 columns">
                  
                <label for="">fecha inicio</label>
                <input type="text" name="fecha_inicio" class="fecha" id="fecha_inicio" required="">
                <small class="error">requerido</small>
                </div>
            </div>
        <div class="row">
            <div class="small-6 columns">
                                <label>seleccione potrero
                     <select id="potrero"  required="" name="potrero">
                         <option value="">seleccione</option>
                         <?php
                         while($fila=$potreros->fetch()){
                             echo "<option value='$fila[id]'>$fila[nombre]</option>";
                         }
                                                                            ?>
                    </select>
                 </label>
                <small class="error">requerido</small>
           </div>     
           
                <div class="small-6 columns">
                 <label>seleccione los tablones
                     <select id="tablon" multiple=""  name="tablones[]">
                    
                    </select>
                 </label>
                    
            </div>
                </div> 
         <div class="row">
        <div class="small-6 columns">    
            <label>tipo cultivo
                <select name="tipo" required="">
                    <option value="">seleccione</option>
                              <?php
                                                        while($fila=$tipos_cultivo->fetch()){
                                                                                                    echo "<option value='$fila[id]'>$fila[nombre]</option>";
                                                                                                }
                                                                            ?>
                </select>
            </label>
            <small class="error">requerido</small>
        </div>
                <div class="small-6 columns">    
                    <label>bodega
                        <select name="bodega" required="">
                            <option value="">seleccione</option>
                            <?php
                                                                                                    while($fila=$bodegas->fetch()){
                                                                                                        echo "<option value='$fila[codigo]'>$fila[nombre]</option>";
                                                                                                    }
                                                                                    ?>
                        </select>
                        <small class="error">requerido</small>
                    </label>
                </div>
        
            </div>
        <div class="row">
             <div class="small-12 columns">  
            
                 <label for="notas">notas</label>
                 <textarea name="notas" id="notas" cols="30" rows="10"></textarea>   
                    
                <input type="submit" value="crear registro" class="button primary" id="envia">
            </div>
        </div>
                
    </form>
        
</div>
 
</div>

<script>

                   $(document).on('ready',inicio);
                   
                           function  inicio(){
                            setear_vals();
                    
                   
                                            $("#proyecto").foundation('abide','events');
    
                                        $('#proyecto').on('valid.fndtn.abide', function () {
                                                      $.ajax({
                                                                    url:'ajax/cproyecto.php',
                                                                    method:'get',
                                                                    type:'json',
                                                                    data:$(this).serialize(),
                                                                        success: function (datos) {
                                                                               $("span#mensaje").html(datos);
                                                                               setTimeout(function(){
                                                                                   window.location='http://localhost:8089/ganadero/siembras/proyectos.php';
                                                                               },2500);
                                                                                
                                                                        }
                                                        });
                                        });
                          
                        }
        
                function setear_vals(){
                    $(".fecha").attr('readonly', true).datepicker({dateFormat: "dd-mm-yy", changeYear: true,  changeMonth: true});
                    $('#tablon').multipleSelect();
                    $('#potrero').on('change',tablones);
         
                }
                
                function tablones(){
                    var pot_id=$(this).val();
                    if(pot_id!=='seleccione'){
                             $.ajax({
                                                                    url:'ajax/lista.php',
                                                                    method:'get',
                                                                    type:'json',
                                                                    data:{pot_id:pot_id},
                                                                        success: function (datos) {
                                                                              $('#tablon').html(datos);
                                                                                      $('#tablon').multipleSelect('refresh');
                                                                            
                                                                        }
                                                        });
                                  }else{
                                        $('#tablon').html('');
                                                 $('#tablon').multipleSelect('refresh');
                                 }
                                      
                }
                
</script>