<?php   
session_start();
include '../plantilla.php';
$sql_compra="select * from compras_enc where id=$_GET[id]";
$res_compra=$conex->query($sql_compra)->fetchAll(PDO::FETCH_ASSOC)[0];

$sql="select * from productos";
$sqlproveedores="select * from contactos where tipo='proveedor'";
$resprods=$conex->query($sql);
$resproveedores=$conex->query($sqlproveedores);
#$resbodegas=$conex->query($sqlbodegas);
$productos[]='seleccione';
$bodegas[]='seleccione';
$unit_prod=[];
$unit_peso="<option value=''>seleccione</option>"
        . "<option value='qq'>quintal</option>"
        . "<option value='g'>gramos</option>"
        . "<option value='kg'>kilogramos</option>"
        . "<option value='oz'>onzas</option>"
        . "<option value='lb'>libras</option>";

$unit_vol="<option value=''>seleccione</option>"
        . "<option value='lt'>litros</option>"
        . "<option value='ml'>mililitros</option>";
$selectprod='<option value="">seleccione</option>';
while($filapro=$resprods->fetch()){
    $selectprod.="<option value='$filapro[referencia]-$filapro[nombre]' data-unidad='$filapro[unidad_standar]'>$filapro[nombre]</option>";
    $productos[]=$filapro[referencia].'-'.$filapro[nombre];
    if($filapro[unidad_standar]=='kg'){
        $unit_prod[$filapro[referencia]]=$unit_peso;
    }else{
        $unit_prod[$filapro[referencia]]=$unit_vol;
    }
    
}


$sql_bodega="select * from bodega";
$res=$conex->query($sql_bodega);
$selectbodega="<option value=''>seleccione</option>";
while($fila=$res->fetch()){
    $selectbodega.="<option value='$fila[codigo]'>$fila[nombre]</option>";
}
?>
<div class="small-12 columns">
    <h2>crear compra</h2>
    <a href="compras.php" class="regresar">regresar</a>
    <span id="mensaje"></span>
    <form data-abide='ajax' id="miforma" enctype="multipart/form-data" method="post">
            <div class="row">
                <!--<div class="small-12 columns"><h3 style="color: white;background-color: black" class="text-center">factura</h3></div>-->
        
        <div class="small-12 columns ">
            
            <table  width="100%">

        <tbody>
              <tr>
                  <td><label class="inline">tipo Doc</label></td>
              <td>
                  <input type="text" value="<?php echo $res_compra[tipo_doc]?>" readonly="">
                <small class="error">obligatorio</small>
            </td>
            <td>
                <label class="inline">doc. No</label>
            </td>
              <td>
                  <input type="text" name="fac_no" readonly="" class="error" pattern="alpha_numeric" value="<?php echo $res_compra[doc_no] ?>">
                    <small class="error">obligatorio</small>
            </td>
             <td>
                 <!--<label class="inline">bodega</label>-->
             </td>
                    <td>
<!--                <select name="bodega" required>
                    <option value=''>seleccione</option>
                    <?php
                                                                            while($fila=$res->fetch()){
                                                                                echo "<option value='$fila[codigo]'>$fila[nombre]</option>";
                                                                                $bodegas[$fila[codigo]]=$fila[nombre];
                                                                            }
                                                            ?>
                </select>
                         <small class="error">obligatorio</small>-->
                    </td>
          </tr>
          <tr>
           

          </tr>
          <tr>
              <td>
                  <label class="inline">fecha</label>
              </td>            
            <td>
                <input type="text" name="fecha" readonly=""  value="<?php echo $res_compra[fecha] ?>">
                <small class="error">obligatorio</small>
            </td>
            <td>
                <label class="inline">proveedor</label>
            </td>
            <td>
                <input type="text" value="<?php echo $res_compra[proveedor]?>" name="proveedor" readonly="">
                <small class="error">obligatorio</small>
            </td>
           
          </tr>

        </tbody>
            </table>
        </div>
                <div class="" id="lineas">
                   <div class="small-2 columns">
                       <label>bodega
                           <select id="bodega">                               
                               <?php
                                                                                          echo $selectbodega;
                                            ?>
                           </select>
                            </label>
        </div>
                <div class="small-4 columns">
                                          <label>referencia
                                              <select id="ref">
                                                  <?php
                                                         echo $selectprod;
                                                                    ?>
                                              </select>
                                 </label>
        </div>
                <div class="small-1 columns">
                                          <label>cantidad
                                 <input type="text" id='cantidad'>
                                 </label>
        </div>
                <div class="small-2 columns">
                                          <label>unidad
                                 <select id='unidad'>
                                     </select>
                                 </label>
        </div>
                <div class="small-1 columns">
                                  <label>precio
                                 <input type="text" id='precio'>
                                 </label>
                            
        </div>
         
                <div class="small-1 columns">
                    <button id="agregar" type="button">agregar</button>
                            
        </div>
        <div class="small-12 columns">
            <table id="lineas" width="100%">
                <thead>
                <tr>
                    <th>bodega</th>
                    <th>referencia</th>
                    <th>cantidad</th>
                    <th>unidad</th>
                    <th>precio</th>
                    <th>subtotal</th>
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
             <table  width="100%" id="total">
 
  
    <tr>
        <td><label class="inline">total</label></td>
      <td><input type="text" name="total" readonly=""></td>
     
    </tr>


</table>
        </div>
                
                
    </div>
    </div>
        <!--<button type="submit" class="encabezado">crear registro</button>-->
 </form>   
           <button type="submit" class='lineas' data-id='<?php echo $res_compra[id]?>'>crear lineas</button>
    </div>


</div>
<script>
    
//        $("#miforma").foundation('abide','events');
    
//    $('#miforma').on('valid.fndtn.abide', function () {
//                      $.ajax({
//                                        url:'ajax/crea_compra_enc.php',
//                                        data:$(this).serialize(),                                         
//                                        dataType:'json',
//                                        success:function(data){
//                                                if(_.has(data,'ok')){
//                                                    $("#lineas").removeClass('hide');
//                                                    $(".lineas").removeClass('hide').attr('data-id',data.id);
//                                                    $(".encabezado").addClass('hide');
//                                                    
//                                                    $("span#mensaje").html(data.ok);
//                                                    $('[name=tipo_doc]').attr('disabled',true);
//                                                    $('[name=fac_no]').attr('readonly',true);
//                                                    $('[name=fecha]').attr('readonly',true);
//                                                    $('[name=proveedor]').attr('disabled',true);                                                    
//                                                    
//                                                }else{
//                                                    $("span#mensaje").html(data.error);
//                                                }
//                                            
//                                    $("span#mensaje").fadeOut(1500);
////                                            setTimeout(function (){
////                                                 window.location.reload();
////                                            },500);
//                                                
//                                              
//                                        }
//                                    });    
//  });
  
  $('.lineas').on('click',function(){
      if($('#lineas>tbody tr').size()>0){          
          enc_id=$('.lineas').attr('data-id');
                         $.ajax({
                                        url:'ajax/crea_compra_lns.php',     
                                        data:{enc_id:enc_id},
                                        success:function(data){                                                                           
                                        $("span#mensaje").html(data).fadeOut(1500);
                                             setTimeout(function(){
                                                                                   window.location='compras.php';
                                                                               },2500);                                                                                         
                                              
                                        }
                                    });
  }
  });
  
//        if($('#lineas tbody tr').size()>0){              
//                
//                                              $.ajax({
//                                        url:'ajax/crea_compra_lns.php',
//                                        data:$(this).serialize(),                                         
//                                        success:function(data){
//                                            $("span#mensaje").html(data);
//                                            setTimeout(function (){
//                                                 window.location.reload();
//                                            },500);
//                                        }
//                                    });
//                                    
//           }

//      else{
//          alert('factura vacia');
//      }
  
  $("#agregar").on('click',function(){
      bod=$('#bodega').val();
      ref=$('#ref').val();
      cant=$('#cantidad').val();
      unidad=$('#unidad').val();
      precio=$('#precio').val();
      
      if(bod!=='' && ref!=='' && cant!=='' && unidad!=='' && precio!==''){
          subtotales=0;
                            $.ajax({
                                url:'ajax/lineas_factura_compra_sesion.php',
                                data:{bod:bod,ref:ref,cant:cant,unidad:unidad,precio:precio},
                                dataType:'json',
                                success:function(data){
                                    linea='';
                                    _.each(data,function(value,key,list){
                                     linea+='<tr>';
                                     linea+='<td>'+data[key].bodega+'</td><td>'+key+'</td><td>'+data[key].cant+'</td><td>'+data[key].unidad+'</td><td>'+data[key].precio+'</td><td>'+numeral(data[key].subtotal).format('0,0.00')+'</td>';
                                     linea+='</tr>';
                                     subtotales+=parseFloat(data[key].subtotal);
                                 });
                                            //linea=`<tr><td>${bod}</td><td>${ref}</td><td>${cant}</td><td>${unidad}</td><td>${precio}</td><td>${subtotal}</td></tr>`;
                                           // linea+=`<tr><td>${bod}</td><td>${ref}</td><td>${cant}</td><td>${unidad}</td><td>${precio}</td><td>${subtotal}</td></tr>`;
                                            $('#lineas>tbody').html(linea);
                                            $('[name=total]').val(numeral(subtotales).format('0,0.00'));

                                }
                            });
                  }else{
                  alert('complete todos los campos');
                  return;
                  }
  });
  
  $('#ref').on('change',function (){
      unidad=$(this).find('option:selected').data('unidad');
      kg="<option value=''>seleccione</option>         <option value='qq'>quintal</option>        <option value='g'>gramos</option>        <option value='kg'>kilogramos</option>         <option value='oz'>onzas</option>         <option value='lb'>libras</option>";
      lt="<option value=''>seleccione</option>        <option value='lt'>litros</option>        <option value='ml'>mililitros</option>";
      if(unidad==='kg'){
      $('#unidad').html(kg);
  }
  if(unidad==='unidad'){
            $('#unidad').html('<option value="unidad">unidad</option>');
  }
  if(unidad==='cc'){
            $('#unidad').html('<option value="cc">cc</option>');
  }
  else{
            $('#unidad').html(lt);
  }
  });
  
//  $('[name=tipo_doc]').on('change',function(){
//      if($("[name=fac_no]").val()!==''){
//      $("[name=fac_no]").trigger('blur');
//        }
//  });
  
//  $("[name=fac_no]").on('blur',function(){
//      no_doc=$(this).val();
//      tipo_doc=$('[name=tipo_doc]').val();
//      if(no_doc!=='' && tipo_doc!==''){
//              $.ajax({
//          url:"ajax/verificar_doc.php",
//          data:{no_doc:no_doc,tipo_doc:tipo_doc},
//          success:function(data){
//              if(data!==''){
//                  alert('ya existe el documento');
//                  $('[name=fac_no]').val('');
//              }
//          }
//      });
//      }else{
//          alert('seleccione  documento')
//      }
//  
//  });
  
    $("[name=fecha]").datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
      changeYear: true});

</script>