<?php 
include '../plantilla.php'; 
include '../php funciones/funciones.php';

if($_POST){

    extract($_POST);
    $costo_proyecto=filter_var($costo_proyecto,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_tapizca=filter_var($costo_tapizca,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_desgranado=filter_var($costo_desgranado,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $precio_vta=filter_var($precio_vta,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_moler_1=filter_var($costo_moler_1,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_moler_2=filter_var($costo_moler_2,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_moler_3=filter_var($costo_moler_3,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_envasar_1=filter_var($costo_envasar_1,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_envasar_2=filter_var($costo_envasar_2,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $costo_envasar_3=filter_var($costo_envasar_3,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    //$precio_vta=filter_var($precio_vta,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    #costo_proyecto
     $costo_proyecto_1=$costo_proyecto;
    ##calculos
     $costo_proyecto=  $costo_proyecto +  $costo_tapizca+ $costo_desgranado ;
             
    if(isset($es_vta)){
        $reclamo_costo=  $costo_proyecto_1-($precio_vta*($porcentaje_costo/100));
      $costo_proyecto=$costo_proyecto-  $precio_vta;   
    }else{
        $costo_proyecto=$costo_proyecto+$costo_moler_1+$costo_envasar_1;
        $reclamo_costo=0;
    }
    
    $costo_tuza_olote=$costo_tuza_olote+ $costo_moler_2+$costo_envasar_2;
    $costo_rastrojo=  $costo_rastrojo+  $costo_moler_3+$costo_envasar_3;
    
    ##fin calculos
    
    

#    prod. 1 maiz en grano 
#prod 2 tuza y olote para moler 
#prod 3 rastrojo para para moler
    $cod_1=  isset($es_vta)?'':$proy_id.'-1';
    $cod_2=$proy_id.'-2';
    $cod_3=$proy_id.'-3';
    
    $consultas=[];
    
    $sql="insert into opcion_5 values(default,'$costo_tapizca','$costo_desgranado','$ton_maiz','$ton_tuza','$ton_rastrojo'";
            $sql.= ",'$cod_2','$cod_3','$cod_1','$costo_tuza_olote','$costo_rastrojo',";
            $sql.= isset($es_vta)?"'si'":"'no'";            
            $sql.=",";
            $sql.=isset($es_vta)?"'$precio_vta'":"''";
            $sql.=",'$notas','$proy_id','$reclamo_costo')";
            
    $consultas[]=$sql;
    $consultas[]="update proyectos_enc set opcion='5' where id_proyecto=$proy_id";
    
    ##ingreso a inventario,producto y registro en kardex
   $kg_prod_1=  convertir('ton', $ton_maiz);
   $kg_prod_2=  convertir('ton', $ton_tuza);
   $kg_prod_3=  convertir('ton', $ton_rastrojo);
   
         $costo_promedio_1= floatval($costo_proyecto)/$kg_prod_1;
         $costo_promedio_2= floatval($costo_tuza_olote)/$kg_prod_2;
         $costo_promedio_3= floatval($costo_rastrojo)/$kg_prod_3;
         
##productos
   $consultas[]=  isset($es_vta)?'': "insert into productos values(default,'$cod_1','maiz','kg','$costo_promedio_1','consumible','Paso Firme','$kg_prod_1','$notas')";
   $consultas[]=   "insert into productos values(default,'$cod_2','tuza_olote','kg','$costo_promedio_2','consumible','Paso Firme','$kg_prod_2','$notas')";
   $consultas[]=   "insert into productos values(default,'$cod_3','rastrojo','kg','$costo_promedio_3','consumible','Paso Firme','$kg_prod_3','$notas')";
    
   ##existencias   
   $consultas[]=isset($es_vta)?'':"insert into existencias values (default,'$cod_1',$bodega,'$kg_prod_1')";
   $consultas[]="insert into existencias values (default,'$cod_2','$bodega','$kg_prod_2')";
   $consultas[]="insert into existencias values (default,'$cod_3','$bodega','$kg_prod_3')";
   
   ##kardex
   $consultas[]=isset($es_vta)?'':"insert into kardex values(default,'$bodega','$cod_1',now(),'proyecto','$proy_id','$costo_promedio_1','$kg_prod_1')";
   $consultas[]="insert into kardex values(default,'$bodega','$cod_2',now(),'proyecto','$proy_id','$costo_promedio_2','$kg_prod_2')";
   $consultas[]="insert into kardex values(default,'$bodega','$cod_3',now(),'proyecto','$proy_id','$costo_promedio_3','$kg_prod_3')";
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
$proy_id=$_GET[proy_id];

#calcular costo de uso de el/los tablones
$sql_costo_uso_tablones="select sum(a.dato)
from (select ((regexp_split_to_table(costo_uso_x_dia,',')::numeric(1000,10)* (select fecha_fin::date-fecha_inicio::date from proyectos_enc where id_proyecto =$proy_id))) as dato
from proyecto_tablones where id_proyecto =$proy_id) as a";
$res_uso=$conex->query($sql_costo_uso_tablones)->fetchColumn();
$costo_total+=$res_uso;
?>

<div class="small-10 columns">
           <h2>doblado y cosecha del grano</h2>
           <a href="cosechas.php" class="regresar">regresar</a>
                    <?php  
                            if($mensaje !==''){
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
                             <label>bodega
                                 <select name="bodega">
                                     <option value="">seleccione</option>
                                          <?php
                                                                                                                                        while($fila=$res->fetch()){
                                                                                                                                            echo "<option value='$fila[codigo]'>$fila[nombre]</option>";
                                                                                                                                        }
                                                                                                                            ?>
                                 </select>
                    </label>
                   </div>
 
        
                         
                              
                              <div class="columns small-6">
                                  <label>notas</label>
                                  
                                  <textarea name="notas"></textarea>
                              </div>
           </div>
               
               <div class="row">
                                        <div class="columns small-3">
                   <label>costo tapizca 
                       <input type="text" name="costo_tapizca" required=""  class="cantidad">
                       <small class="error">obligatorio</small>
                   </label>

               </div>
  
                                                      <div class="columns small-3 end">
                   <label>costo desgranado
                       <input type="text" name="costo_desgranado" required=""  class="cantidad">
                       <small class="error">obligatorio</small>
                   </label>
                            </div>
                          
           </div>
               
               <div class="row">
                               <div class="columns small-2">
                   <label>ton. maiz en grano
                       <input type="text" name="ton_maiz" required=""  class="cantidad">
                       <small class="error">obligatorio</small>
                   </label>
                            </div>
                                  <div class="columns small-1">
                   <label>precio venta
                       <input type="text" name="precio_vta" class="cantidad" required="" disabled="">
                       <small class="error">obligatorio</small>
                   </label>
                                          
               </div>       
                                      <div class="columns small-2">
                   <label>reclamacion de costo (%)       
                       <input type="text"  name="porcentaje_costo" min="0" required="" disabled="">                       
                       <small class="error">obligatorio</small>
                   </label>
              
               </div>     
                                  <div class="columns small-1 end">
                   <label>es venta        
                   </label>
              <input type="checkbox" name="es_vta" style="vertical-align: middle">
                       
               </div>    
               </div>
               
               <div class="row">
                                  <div class="columns small-3 ">
                   <label>ton. rastrojo 
                       <input type="text" name="ton_rastrojo" required=""  class="cantidad">
                       <small class="error">obligatorio</small>
                   </label>
               </div>
                         <div class="columns small-3 end">
                   <label>costo  oportunidad venta rastrojo
                       <input type="text" name="costo_rastrojo">
                   </label>
                   </div>
               </div>
               
               
               <div class="row">
                                                   <div class="columns small-3 ">
                   <label>ton. tuza y olote
                       <input type="text" name="ton_tuza" required=""  class="cantidad">
                       <small class="error">obligatorio</small>
                   </label>
                            </div>
                                                                        <div class="columns small-3 end">
                   <label>costo oportunidad venta  tuza olote
                       <input type="text" name="costo_tuza_olote">
                   </label>
                   </div>
               </div>
               
                     

               <fieldset>
                   <legend>procesado de productos</legend>
                   <table>
                       <tr>
                           <th>producto</th>
                           <th>costo moler</th>
                           <th>costo envasar</th>
                       </tr>
                       <tr>
                           <td>maiz en grano</td>
                           <td><input type="text" name="costo_moler_1"></td>
                           <td><input type="text" name="costo_envasar_1"></td>
                       </tr>
                        <tr>
                           <td>tuza y olote para moler</td>
                           <td><input type="text" name="costo_moler_2"></td>
                           <td><input type="text" name="costo_envasar_2"></td>
                       </tr>
                        <tr>
                           <td>rastrojo</td>
                           <td><input type="text" name="costo_moler_3"></td>
                           <td><input type="text" name="costo_envasar_3"></td>
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
    $('[name=es_vta]').on('click',function(){
        if($(this).is(':checked')){
                $('[name=porcentaje_costo]').attr('disabled',false);
                $('[name=precio_vta]').attr('disabled',false);            
        }else{
            $('[name=porcentaje_costo]').val('').attr('disabled',true);
            $('[name=precio_vta]').val('').attr('disabled',true);
        }
    });
</script>