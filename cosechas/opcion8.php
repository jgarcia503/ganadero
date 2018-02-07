<?php 
include '../plantilla.php'; 
#include '../php funciones/funciones.php';

if($_POST){
 extract($_POST);
$consultas[]="insert into opcion_8 values(default,'$costo_manojear','$costo_secar','$costo_aporreo','$costo_proyecto','$proy_id')";
$consultas[]="update proyectos_enc set opcion='8' where id_proyecto=$proy_id";
   try{
       $conex->beginTransaction();
       foreach ($consultas as $value){
           if($value==='')   continue;
            if(!$conex->prepare($value)->execute()){                
                throw new PDOException();
            }
       }
               $conex->commit();
                              $mensaje='<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';                
   }
 catch (Exception $pe){
                   $conex->rollBack();
      $mensaje= '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
 }
   
}
$costo_total=  calcular_costo_proyecto($_GET[proy_id]);
$sql_bodegas="select * from bodega";
$res=$conex->query($sql_bodegas);
?>

<div class="small-12 columns">
           <h2>cosecha de frijol</h2>
           <a href="cosechas.php" class="regresar">regresar</a>
                    <?php  
                            if(isset($mensaje)){
                                    echo $mensaje;
                                    echo "<script>setTimeout(function(){window.location='http://localhost:8089/ganadero/cosechas/cosechas.php'},1500) </script>";
                                   }
                            ?>
           <form data-abide method="post" action="">
               <input type="hidden" name="proy_id" value="<?php echo $_GET[proy_id] ?>">
                          <div class="row">
                         
               <div class="columns small-2">
                             <label>costo total de la siembra
                        <input type="text" readonly="" value="<?php echo number_format($costo_total,2) ?>" name="costo_proyecto">
                    </label>
                   </div>
                              
                                      <div class="columns small-2">
<!--                             <label>bodega
                                 <select name="bodega">
                                     <option value="">seleccione</option>
                                          <?php
                                                                                                                                        while($fila=$res->fetch()){
                                                                                                                                            echo "<option value='$fila[codigo]'>$fila[nombre]</option>";
                                                                                                                                        }
                                                                                                                            ?>
                                 </select>
                    </label>-->
                   </div>
 
        
                         
                              
                              <div class="columns small-6">
<!--                                  <label>notas</label>
                                  
                                  <textarea name="notas"></textarea>-->
                              </div>
           </div>
               
               <div class="row">
                                        <div class="columns small-3">
<!--                   <label>costo tapizca 
                       <input type="text" name="costo_tapizca" required=""  class="cantidad">
                       <small class="error">obligatorio</small>
                   </label>-->

               </div>
  
                                                      <div class="columns small-3 end">
<!--                   <label>costo desgranado
                       <input type="text" name="costo_desgranado" required=""  class="cantidad">
                       <small class="error">obligatorio</small>
                   </label>-->
                            </div>
                          
           </div>
               
               <div class="row">
                               <div class="columns small-3 ">
<!--                   <label>ton. maiz en grano
                       <input type="text" name="ton_maiz" required=""  class="cantidad">
                       <small class="error">obligatorio</small>
                   </label>-->
                            </div>
                                  <div class="columns small-1">
<!--                   <label>precio venta
                       <input type="text" name="precio_vta" class="cantidad">
                       <small class="error">obligatorio</small>
                   </label>-->
                                          
               </div>       
                                      <div class="columns small-1 end">
<!--                   <label>es venta        
                   </label>
              <input type="checkbox" name="es_vta" style="vertical-align: middle">-->
                       
               </div>     
               </div>
               
               <div class="row">
                                  <div class="columns small-3 ">
<!--                   <label>ton. rastrojo 
                       <input type="text" name="ton_rastrojo" required=""  class="cantidad">
                       <small class="error">obligatorio</small>
                   </label>-->
               </div>
                         <div class="columns small-3 end">
<!--                   <label>costo  oportunidad venta rastrojo
                       <input type="text" name="costo_rastrojo">
                   </label>-->
                   </div>
               </div>
               
               
               <div class="row">
                                                   <div class="columns small-3 ">
<!--                   <label>ton. tuza y olote
                       <input type="text" name="ton_tuza" required=""  class="cantidad">
                       <small class="error">obligatorio</small>
                   </label>-->
                            </div>
                                                                        <div class="columns small-3 end">
<!--                   <label>costo oportunidad venta  tuza olote
                       <input type="text" name="costo_tuza_olote">
                   </label>-->
                   </div>
               </div>
               
                     

               <fieldset>
                   <legend>procesado de productos</legend>
                   <table>
                       <tr>
                           <th>proceso</th>
                           <th>costo</th>
                           <!--<th>costo envasar</th>-->
                       </tr>
                       <tr>
                           <td>cortar y manojear</td>
                           <td><input type="text" name="costo_manojear"></td>
                           <!--<td><input type="text" name="costo_envasar_1"></td>-->
                       </tr>
                        <tr>
                           <td>secar</td>
                           <td><input type="text" name="costo_secar"></td>
                           <!--<td><input type="text" name="costo_envasar_2"></td>-->
                       </tr>
                        <tr>
                           <td>aporreo</td>
                           <td><input type="text" name="costo_aporreo"></td>
<!--                           <td><input type="text" name="costo_envasar_3"></td>-->
                       </tr>
                   </table>
               </fieldset>
               
               
               <div class="row">
                   <div class="small-6 columns">
                       <button type="submit">crear registro</button>
                   </div>
               </div>
           </form>

</div>
</div>

<script>
    $(".cantidad").mask('000,000,000,000,000.00', {reverse: true});
</script>