<?php   include '../plantilla.php';
$sql_bodega="select * from bodega where codigo in (select distinct codigo_bodega from existencias)";
$res_bodega=$conex->query($sql_bodega);
?>
<div class="small-12 columns">
    <h2>crear traslados</h2>
    <a href="traslados.php" class="regresar">regresar</a>
    <span id="mensaje"></span>
    <form data-abide='ajax' id="miforma">
            <div class="row">
                <!--<div class="small-12 columns"><h3 style="color: white;background-color: black" class="text-center">factura</h3></div>-->
        
        <div class="small-12 columns ">
            
            <table  width="100%">

        <tbody>
              <tr>
<!--                  <td><label class="inline">tipo Doc</label></td>
              <td>
                  <select name="tipo_doc" required="">
                      <option value="">seleccione</option>
                      <option value="factura">factura</option>
                      <option value="credito fiscal">credito fiscal</option>
                      <option value="sujeto externo">sujeto externo</option>
                  </select>
                <small class="error">obligatorio</small>
            </td>-->
<!--            <td>
                <label class="inline">doc. No</label>
            </td>
              <td>
                  <input type="text" name="fac_no" required="" class="error" pattern="alpha_numeric">
                    <small class="error">obligatorio</small>
            </td>-->
             <td>
                 <label class="inline">bodega origen</label>
             </td>
                    <td>
                <select name="bodega_origen" required>
                    <option value=''>seleccione</option>
                    <?php
                                                                   while($fila=$res_bodega->fetch()){
                                                                       echo "<option value='$fila[codigo]'>$fila[nombre]</option>";
                                                                   }
                                                            ?>
                </select>
                         <small class="error">obligatorio</small>
                    </td>
                       <td>
                 <label class="inline">bodega destino</label>
             </td>
                    <td>
                <select name="bodega_destino" required>
                    <option value=''>seleccione</option>
                 
                </select>
                         <small class="error">obligatorio</small>
                    </td>
          </tr>
          <tr>
           

          </tr>
          <tr>
              <td>
                  <label class="inline">fecha</label>
              </td>            
            <td>
                <input type="text" name="fecha" readonly="" required="">
                <small class="error">obligatorio</small>
            </td>
            <td>
                <label class="inline">notas</label>
            </td>
            <td>
                <textarea name="notas" style="resize:none">                    
                </textarea>                
            </td>
           
          </tr>

        </tbody>
            </table>
        </div>
                <span id="add_panel">
                <div class="small-3 columns">
                    <label>referencia
                        <select id="referencia" >
                            <option value="">seleccione</option>
                        </select>
                    </label>

                </div>

                <div class="small-3 columns">
                    <label>cantidad<input type="text" id="cantidad" ></label>

                </div>
                <div class="small-3 columns">
                    <label>unidad
                        <select id="unidad">
                           
                        </select>
                    </label>

                </div>
                <div class="small-3 columns">
                    <button id="add" type="button" >add</button>

                </div>
                </span>
        <div class="small-12 columns">
                        <table id="lineas" width="100%">
                <thead>
                <tr>
                    <th>referencia</th>                    
                    <th>cantidad</th>
                    <th>unidad</th>
                    <th>costo</th>
                    <th>subtotal</th>
                    <th>eliminar</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
<!--                            <table id="tblAppendGrid">
                            </table>    -->
        </div>
        <div class="small-4 columns">
            
        </div>
               <div class="small-4 columns">
            
        </div>
         <div class="small-4 columns">
                         <table  width="100%">
 
  <tbody>
    <tr>
        <td><label class="inline">total</label></td>
      <td><input type="text" name="total" readonly=""></td>
     
    </tr>

  </tbody>
</table>
        </div>
    </div>
        <button type="submit" id="crea_enc_registro">crear registro</button>
        <button type="submit" id="crea">cerrar traslado</button>
 </form>   
    </div>


</div>
<script>
    $('#crea').hide();
    $('#add_panel').hide();
    
        $("#miforma").foundation('abide','events');
           $("[name=fecha]").datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",changeYear: true});
      $("#referencia").attr('disabled',true);
    
    $('#miforma').on('valid.fndtn.abide', function () {
               datos={};
               datos.bod_org=$("[name=bodega_origen]").val();
               datos.bod_dst=$("[name=bodega_destino]").val();
               datos.fecha=$("[name=fecha]").val();
               datos.notas=$("[name=notas]").val();
                                    $.ajax({
                                        url:'ajax/crea_traslado_enc.php',
                                        data:datos,
                                        dataType:'json',
                                        success:function(data){
                                           if(_.has(data,'ok')){
                                                $("span#mensaje").html(data.ok);
                                                $('#crea').show();
                                                $('#crea').attr('data-id_enc',data.id);
                                                $('#add_panel').show();
                                                $('#crea_enc_registro').hide();
                                                $("[name=bodega_origen]").attr('disabled',true);
                                                $("[name=bodega_destino]").attr('disabled',true);
                                                $("[name=fecha]").attr('disabled',true);
                                                $("[name=notas]").attr('disabled',true);
                                           }else{
                                               $("span#mensaje").html(data.error);
                                           }
                                            $("span#mensaje").fadeOut(1500);
                                        }
                                    });
    
  });
  

      
            $("[name=bodega_destino]").on('change',function(){
                if($(this).val()===''){
                    $("#referencia").attr('disabled',true);
                }else{
                    $("#referencia").attr('disabled',false);
                }
            });
      
      $("[name=bodega_origen]").on('change',function(){
          bodega_id=$(this).val();                  
             
                    $.ajax({
                        url:'ajax/bodegas.php',
                        data:{bodega_id:bodega_id},
                        dataType:'json',
                        success:function(data){
                            $("#referencia").html(data['opciones']);
                            $("[name=bodega_destino]").html(data.bodega_dst);
                            mapa=data.unit_prod;
                            $("[name=bodega_destino]").trigger('change');
                        }
                    });

      });

    $("#add").on('click',function(e){
        ref=$('#referencia').find('option:selected').val();
        cant=$('#cantidad').val();
        unidad=$('#unidad').find('option:selected').val();
        bod_org=$('[name=bodega_origen]').val();
        id_enc=$('#crea').attr('data-id_enc');
        if(ref==='' || cant==='' || unidad===''){
            alert('compete todos los campos');
            return;
        }
        subtotales=0;
        $.ajax({
               url:'ajax/check_existencia.php',
                        data:{ref:ref,cant:cant,unidad:unidad,bod_org:bod_org,id_enc:id_enc},
                        dataType:'json',
                        success:function(data){
                             if(_.has(data,'error')){
                                 alert(data.error);
                             }else{
                                 linea='';
                                       _.each(data,function(value,key,list){
                                     linea+='<tr>';
                                     linea+='<td>'+data[key].nombre+'</td><td>'+data[key].cant+'</td><td>'+data[key].unidad+'</td><td>'+data[key].costo+'</td><td>'+numeral(data[key].subtotal).format('0,0.00')+'</td><td><a href="#" class="delete" data-prod_id='+key+' data-id_enc='+id_enc+'>eliminar</a></td>';
                                     linea+='</tr>';
                                     subtotales+=parseFloat(data[key].subtotal);
                                        });
                                 $('#lineas>tbody').html(linea);
                                 $('[name=total]').val(numeral(subtotales).format('0,0.00'));
                             }
                        }
        });

    });
    
      $('#lineas>tbody').on('click','.delete',function(e){
        e.preventDefault();
        prod_id=$(this).attr('data-prod_id');
        id_enc=$(this).attr('data-id_enc');
        $.ajax({
                 url:'ajax/del_check_existencia.php',
                 data:{id_enc:id_enc,ref:prod_id},
                 dataType:'json',
                 success:function(data){
                                    linea='';
                                    _.each(data,function(value,key,list){
                                     linea+='<tr>';
                                    linea+='<td>'+data[key].nombre+'</td><td>'+data[key].cant+'</td><td>'+data[key].unidad+'</td><td>'+data[key].costo+'</td><td>'+numeral(data[key].subtotal).format('0,0.00')+'</td><td><a href="#" class="delete" data-prod_id='+key+' data-id_enc='+id_enc+'>eliminar</a></td>';
                                     linea+='</tr>';
                                     subtotales+=parseFloat(data[key].subtotal);
                                 });
                                            //linea=`<tr><td>${bod}</td><td>${ref}</td><td>${cant}</td><td>${unidad}</td><td>${precio}</td><td>${subtotal}</td></tr>`;
                                           // linea+=`<tr><td>${bod}</td><td>${ref}</td><td>${cant}</td><td>${unidad}</td><td>${precio}</td><td>${subtotal}</td></tr>`;
                                            $('#lineas>tbody').html(linea);
                                            $('[name=total]').val(numeral(subtotales).format('0,0.00'));

                                }
        });
        
  });
    
    $("#referencia").on('change',function(){
      unidad=$(this).find('option:selected').data('unidad');           
      kg="<option value=''>seleccione</option>         <option value='qq'>quintal</option>        <option value='g'>gramos</option>        <option value='kg'>kilogramos</option>         <option value='oz'>onzas</option>         <option value='lb'>libras</option>";
      lt="<option value=''>seleccione</option>        <option value='lt'>litros</option>        <option value='ml'>mililitros</option>";
      switch(unidad){
          case 'kg':
              $('#unidad').html(kg);
              break;
          case 'unidad':
              $('#unidad').html('<option value="unidad">unidad</option>');
              break;
          case 'cc':
               $('#unidad').html('<option value="cc">cc</option>');
              break;
          case 'lt':
               $('#unidad').html(lt);
              break;
      }
                switch(unidad){
                        case 'kg':                
                        case 'lt':                                
                        case 'cc':                
                            $("#cantidad").mask('000,000,000,000,000.00', {reverse: true});
                            break;
                        case 'unidad':
                            $('#cantidad').mask('00000000');
                            break;
        }
        
    });
</script>

