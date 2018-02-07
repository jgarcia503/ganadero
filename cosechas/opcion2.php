<?php 
include '../plantilla.php'; 
#include '../php funciones/funciones.php';


        if(!isset($_GET[proy_id])){
        echo "<script>window.location=''http://'.$_SERVER[HTTP_HOST]/ganadero/cosechas/cosechas.php'</script>";
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

<div class="small-12 columns">
    <h2>venta de siembra con silo de zacate</h2>
    <a href="cosechas.php" class="regresar">regresar</a>
         <span id="mensaje"></span>
    <form data-abide='ajax'  id="myform">
    <div class="row">
        <input type="hidden" name="proy_id" value="<?php echo $_GET[proy_id] ?>">
        <div class="small-3 columns"> 
              <label>costo total de la siembra
                <input type="text" name="costo_proyecto" readonly="" value="<?php echo  number_format($costo_total,2)?>">
            </label>
            
        </div>
        <div class="small-3 columns end">
            <label>
                redes cosechadas
                <input type="text"  name="redes_cos" class="cantidad">

            </label>
        </div>
        <div class="small-6 columns ">
             <label>
            calidad zacate
            <textarea name="calidad_zacate"></textarea>
                    </label>
     </div>
     </div>
              <div class="row">
        <div class="small-2 columns">
            <label>
            precio x red
            <input type="text"  name="precio_red" class="cantidad">
   
        </label>
        </div>
        <div class="small-2 columns">
                <label>
                venta de elote
                <input type="text" readonly="" name="vta_elote" min="0">
                
            </label>
        </div>
                      <div class="small-2 columns end">
                <label>
               reclamacion de costo (%)
               <input type="text"  name="porcentaje_costo" min="0" required="">
                <small class="error">obligatorio</small>
            </label>
        </div>
                 <div class="small-6 columns "> 
                       <label>
            calidad elote
            <textarea name="calidad_elote"></textarea>
                        </label>
                </div>
        </div>
        <div class="row">
               <div class="small-2 columns">
                <label>costo mano obra(cosecha)
                    <input type="text" name="costo_cosecha_mano_obra" required="" class="cantidad">
                </label>
                <small class="error">obligatorio</small>
            </div>
            <div class="small-2 columns">
                <label>costo de picado<input type="text" name="costo_picar_mano_obra" required="" class="cantidad"></label>
                <small class="error">obligatorio</small>
            </div>
            <div class="small-2 columns end">
                <label>costo de transporte<input type="text" name="costo_transporte" required="" class="cantidad"></label>
                <small class="error">obligatorio</small>
            </div>
              <div class="small-6 columns end">
                <label>notas silos<textarea name="notas"></textarea></label>
            </div>    
            </div>
        <div class="row">
                <div class="small-2 columns">
                <label>costo de plastico<input type="text" name="costo_plastico" required="" class="cantidad"></label>
                <small class="error">obligatorio</small>
            </div>
            <div class="small-2 columns">
                <label>toneladas de forraje<input type="text" name="ton_forraje" required="" class="cantidad"></label>
                <small class="error">obligatorio</small>
            </div>
            <div class="small-2 columns end">
                <label>costo de compactacion<input type="text" name="costo_compactacion" required="" class="cantidad"></label>
                <small class="error">obligatorio</small>
            </div>
        </div>
                <div class="row">
            <div class="small-2 columns">
                <label>costo de insumos
                    <input type="text" name="costo_insumos" required="" class="cantidad">
                </label>
                <small class="error">obligatorio</small>
            </div>
            <div class="small-2 columns">
                <label>fecha inicio preparacion<input type="text" name="fecha_inicio" required=""  class="fecha"></label>
                <small class="error">obligatorio</small>
            </div>
            <div class="small-2 columns end">
                <label>fecha de cierre<input type="text" name="fecha_cierre" required="" class="fecha"></label>
                <small class="error">obligatorio</small>
            </div>
                         <div class="small-3 columns end">
                              <label>bodega
                                  <select name="cod_bodega" required="">
                                      <option value="">seleccione</option>
                                      <?php
                                                                                                                                        while($fila=$res->fetch()){
                                                                                                                                            echo "<option value='$fila[codigo]'>$fila[nombre]</option>";
                                                                                                                                        }
                                                                                                                            ?>
                                  </select>
                                      
                              </label>
                              <small class="error">obligatorio</small>
                          </div>
        </div>      
     
    <fieldset>
        <legend>elaboracion silo</legend>
        <div class="row">
                 <div class="small-3 columns">
                     <label>codigo silo
                         <input type="text" id='cod_silo'>
                         </label>
                     </div>
            <div class="small-3 columns">
                     <label>
                         toneladas silo
                         <input type="text" id="cant_silo">
                     </label>
                        </div>
              <div class="small-3 columns">
                  <button id="add" type="button">add</button>
                        </div>
            
            <div class="small-12 columns">
                            <table id="tblAppendGrid">
                            </table>    
                        </div>
        </div>
                       
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
    

    $('#tblAppendGrid').appendGrid({
        initRows: 0,
        idPrefix: '',
        columns: [
            { name: 'cod_silo', display: 'codigo silo', type: 'text', ctrlAttr: { readonly:true }, ctrlCss: { width: '160px'} },
            { name: 'ton_silo', display: 'toneladas silo', type: 'text', ctrlAttr: { readonly: true }, ctrlCss: { width: '100px'} },
            { name: 'descripcion', display: 'descripcion', type: 'text', ctrlAttr: { readonly: false}, ctrlCss: { width: '50%'} },
        ],
         hideButtons: {
            remove: true,
            removeLast: true,
            append:true,
            insert:true,
            moveUp: true,
            moveDown:true
        }
    });



                    $(".fecha").attr('readonly', true).datepicker({dateFormat: "dd-mm-yy",  changeYear: true,  changeMonth: true});
                    
                    $("[name=redes_cos]").on('change',function(){
                        redes_cos=numeral($(this).val()).multiply($("[name=precio_red]").val());
                        //var vta_elote=parseFloat($(this).val())*parseFloat($("[name=precio_red]").val());
                       redes_cos.format('.00');
                        $('[name=vta_elote]').val(redes_cos.value());
                    });
                    
                     $("[name=precio_red]").on('change',function(){
                         vta_elote=numeral($(this).val()).multiply($("[name=redes_cos]").val());
                        //var vta_elote=parseFloat($(this).val())*parseFloat($("[name=redes_cos]").val());
                        vta_elote.format('.00');
                        $('[name=vta_elote]').val(vta_elote.value());
                    });
    
    $("#myform").foundation('abide','events');
    
$('#myform').on('valid.fndtn.abide', function () {
    var datos={};
    datos.forma=$(this).serialize();
    datos.silos=  $('#tblAppendGrid').appendGrid('getAllValue');
      
        $.ajax({
            url:'ajax/opcion2.php',    
            method:'post',
            data:datos,
            success:function(data){
                $("span#mensaje").html(datos);
                                                                               setTimeout(function(){
                                                                                   window.location='http://localhost:8089/ganadero/cosechas/cosechas.php';
                                                                               },1500);
                
            }
        });
  });
  
        var    tot_forraje;
  $("[name=ton_forraje]").on('change',function (){
       tot_forraje=parseFloat($(this).val());
  });

  $("#add").on('click',function(e){
      e.preventDefault();
      
      var cod_silo=$('#cod_silo').val();
      var cant_silo=$("#cant_silo").val();
    
    
    
      if(tot_forraje>=parseFloat(cant_silo)){
                if(cod_silo!==''  &&  cant_silo!=='' ){
                $.ajax({
          url:'ajax/check_codigo_silo.php',
          data:{cod_silo:cod_silo},
          success:function(data){
              if(data!==''){
                    alert(data);
                    
              }else{
                                 
                     $('#tblAppendGrid').appendGrid('appendRow',[{ cod_silo: cod_silo,ton_silo: cant_silo,descripcion:''}]);
                     tot_forraje-=cant_silo;
                 
              }
          }
      });
      }else{
          alert('campos vacios');
            }
      }else{
          alert('cantidad insuficiente');
      }

  });
  
$(".cantidad").mask('000,000,000,000,000.00', {reverse: true});
</script>
