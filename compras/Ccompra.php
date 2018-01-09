<?php   
session_start();
include '../plantilla.php';
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
<div class="small-10 columns">
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
                  <select name="tipo_doc" required="">
                      <option value="">seleccione</option>
                      <option value="factura">factura</option>
                      <option value="credito fiscal">credito fiscal</option>
                      <option value="sujeto externo">sujeto externo</option>
                  </select>
                <small class="error">obligatorio</small>
            </td>
            <td>
                <label class="inline">doc. No</label>
            </td>
              <td>
                  <input type="text" name="fac_no" required="" class="error" pattern="alpha_numeric">
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
                <input type="text" name="fecha" readonly="" required="">
                <small class="error">obligatorio</small>
            </td>
            <td>
                <label class="inline">proveedor</label>
            </td>
            <td>
                <select name="proveedor" required="">
                    <option value="">seleccione</option>
                    <?php
                                                                                while($fila=$resproveedores->fetch()){
                                                                                    echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                                                                                }

                                                            ?>
                </select>
                <small class="error">obligatorio</small>
            </td>
           
          </tr>

        </tbody>
            </table>
        </div>                       
                <span id="otros_gastos">
                <div class="columns small-2">
                        <label>valor
                            <input type="text" id="valor"class="cantidad">
                        </label>                        
                    </div>
           
                     <div class="columns small-5">
                        <label>concepto
                            <input type="text" id="concepto">
                        </label>
                        
                    </div>
                  <div class="columns small-3">
                      <button type="button" id="btn_costo">agregar</button>
                      </div>
                <div class="columns small-12">
                    <table id="tblAppendGrid">
                        
                    </table>
                </div>
                </span>
                <div class="hide" id="lineas">
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
        <button type="submit" class="encabezado">crear registro</button>
 </form>   
           <button type="submit" class='lineas hide' data-id=''>crear lineas</button>
    </div>


</div>
<script>
       $('#tblAppendGrid').appendGrid({
        caption: 'Otros gastos',
        initRows: 0,
        columns: [           
            { name: 'valor', display: 'valor', type: 'text', ctrlAttr: { readonly: true }, ctrlCss: { background: 'none',border:'none'} },
            { name: 'concepto', display: 'concepto', type: 'text', ctrlAttr: { readonly: true }, ctrlCss: {  background: 'none',border:'none'} }            
        ],
        hideButtons:{
        append:true,
removeLast:true,
insert:true,
remove:true,
moveUp:true,
moveDown: true
        },
        hideRowNumColumn:true,
         maxBodyHeight: 240, 
        maintainScroll: true ,
         idPrefix: 'gastos'
    });

    var mapa=<?php echo json_encode($unit_prod); ?>;

    //{'seleccione':'seleccione','qq':'quintal','g':'gramos','kg':'kilogramos','oz':'onzas',
//                                                            ,'lb':'libras'}
//  $('#tblAppendGrid').appendGrid({        
//        initRows: 0,
//        hideRowNumColumn:true,
//        idPrefix: 'linea',
//        columns: [
//            {name: 'bodega', display: 'bodega', type: 'text', ctrlAttr: { maxlength: 100,required:true,readonly:true }, ctrlCss: { width: '160px'},
//                  ctrlOptions:<?php            echo json_encode($bodegas);     ?>
//            },
//            { name: 'referencia', display: 'referencia', type: 'text', ctrlAttr: { maxlength: 100,required:true,readonly:true }, ctrlCss: { width: '160px'} ,
//                     ctrlOptions: <?php echo json_encode($productos)?>,
//                     onChange:function(evt,rowIndex){
//                         prod=$($('#tblAppendGrid').appendGrid('getCellCtrl', 'referencia', rowIndex)).val().split('-')[0];
//                         $($('#tblAppendGrid').appendGrid('getCellCtrl', 'unidad', rowIndex)).html(mapa[prod]);
//                      
//                     }
//            },            
//            { name: 'cantidad', display: 'cantidad', type: 'text', ctrlAttr: { maxlength: 100 ,required:true,readonly:true}, ctrlCss: { width: '100px'},
//                   onChange: function (evt, rowIndex) {
//                       var cantidad =parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'cantidad', rowIndex)).val());
//                       var precio =parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'precio', rowIndex)).val());
//                       var subt=cantidad*precio;
//                       $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).val(parseFloat(subt).toFixed(2));
//                        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).trigger('change');
//                   }
//            },
//            { name: 'unidad', display: 'unidad', type: 'text', ctrlAttr: { required:true}, ctrlCss: { width: '100px'} 
//                      
//            },
//            { name: 'precio', display: 'precio', type: 'text', ctrlAttr: { maxlength: 100,required:true,readonly:true}, ctrlCss: { width: '100px'} ,
//                         onChange: function (evt, rowIndex) {
//                       var cantidad =parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'cantidad', rowIndex)).val());
//                       var precio =parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'precio', rowIndex)).val());
//                       var subt=cantidad*precio;
//                       $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).val(parseFloat(subt).toFixed(2));
//                       $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).trigger('change');
//                   }
//            },
////            { name: 'proveedor', display: 'proveedor', type: 'select', ctrlAttr: { required:true }, ctrlCss: { width: '150px'},
////                ctrlOptions: <?php echo json_encode($proveedores)?>,
////                 emptyCriteria: 'seleccione'
////            },
//            { name: 'subtotal', display: 'subtotal', type: 'text', ctrlAttr: { maxlength: 100,readonly:true }, ctrlCss: { width: '100px'},
//                         onChange: function (evt, rowIndex) {
//                             var i=0;
//                             var total=0;
//                        var filas= $('#tblAppendGrid').appendGrid('getRowCount');
//                        for( ;i<filas;i++){
//                           total+=parseFloat($('#tblAppendGrid').appendGrid('getCtrlValue', 'subtotal', i));                            
//                        }   
//                        
//                         $('[name=total]').val(total.toFixed(2));
//                    }
//            }
//        ],
//        afterRowAppended: function (caller, parentRowIndex, addedRowIndex) {
//        
//        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'bodega', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
//        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'referencia', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
//        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'cantidad', addedRowIndex)).after('<small class="error">requerido</small>');
//        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'unidad', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
//        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'precio', addedRowIndex)).after('<small class="error">requerido</small>');
//        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'proveedor', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
//        
//       
//        },
//           hideButtons: {
//            moveDown:true,
//            removeLast: true,
//            moveUp:true,
//            insert:true,
//            append:true
//        },
//            maintainScroll:true,            
//            maxBodyHeight:400,
//            beforeRowRemove: function (caller, rowIndex) {
//                    var subt=parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).val());
//                    
//                    if(!isNaN(subt)){
//                    var total_actual=parseFloat($('[name=total]').val());
//                    var act=total_actual-subt;
//                    $('[name=total]').val(parseFloat(act).toFixed(2));
//                       
//                    }
//                     $('#tblAppendGrid').appendGrid('removeRow', rowIndex);
//        }
//    });
    
        $("#miforma").foundation('abide','events');
    
    $('#miforma').on('valid.fndtn.abide', function () {
                      $.ajax({
                                        url:'ajax/crea_compra_enc.php',
                                        data:$(this).serialize(),                                         
                                        dataType:'json',
                                        success:function(data){
                                                if(_.has(data,'ok')){
                                                    $("#lineas").removeClass('hide');
                                                    $(".lineas").removeClass('hide').attr('data-id',data.id);
                                                    $(".encabezado").addClass('hide');
                                                    $('#otros_gastos').addClass('hide');
                                                    $("span#mensaje").html(data.ok);
                                                    $('[name=tipo_doc]').attr('disabled',true);
                                                    $('[name=fac_no]').attr('readonly',true);
                                                    $('[name=fecha]').attr('readonly',true);
                                                    $('[name=proveedor]').attr('disabled',true);                                                    
                                                    
                                                }else{
                                                    $("span#mensaje").html(data.error);
                                                }
                                            
                                    $("span#mensaje").fadeOut(1500);
//                                            setTimeout(function (){
//                                                 window.location.reload();
//                                            },500);
                                                
                                              
                                        }
                                    });    
  });
  
  $('.lineas').on('click',function(){
      if($('#lineas>tbody tr').size()>0){          
          enc_id=$('.lineas').attr('data-id');
                         $.ajax({
                                        url:'ajax/crea_compra_lns.php',     
                                        data:{enc_id:enc_id},
                                        success:function(data){                                                                           
                                        $("span#mensaje").html(data).fadeOut(1500);
                                            setTimeout(function (){
                                                 window.location.reload();
                                            },500);
                                                
                                              
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
  
  $('[name=tipo_doc]').on('change',function(){
      if($("[name=fac_no]").val()!==''){
      $("[name=fac_no]").trigger('blur');
        }
  });
  
  $("[name=fac_no]").on('blur',function(){
      no_doc=$(this).val();
      tipo_doc=$('[name=tipo_doc]').val();
      if(no_doc!=='' && tipo_doc!==''){
              $.ajax({
          url:"ajax/verificar_doc.php",
          data:{no_doc:no_doc,tipo_doc:tipo_doc},
          success:function(data){
              if(data!==''){
                  alert('ya existe el documento');
                  $('[name=fac_no]').val('');
              }
          }
      });
      }else{
          alert('seleccione  documento')
      }
  
  });
  
    $("[name=fecha]").datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
      changeYear: true});
      
$(".cantidad").mask('000,000,000,000,000.00', {reverse: true});

$('#btn_costo').on('click',function (e){
    e.preventDefault();
    valor=$("#valor").val();
    concepto=$("#concepto").val();
    $('#tblAppendGrid').appendGrid('appendRow', [ 
        { valor: valor, concepto: concepto }    
    ]);
});
</script>