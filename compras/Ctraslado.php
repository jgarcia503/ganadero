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
                    <button id="add" >add</button>

                </div>
                
        <div class="small-12 columns">
                            <table id="tblAppendGrid">
                            </table>    
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
        <button type="submit">crear registro</button>
 </form>   
    </div>


</div>
<script>
    var mapa;
  $('#tblAppendGrid').appendGrid({        
        initRows: 0,
        idPrefix: 'linea',
        columns: [
            { name: 'referencia', display: 'referencia', type: 'text', ctrlAttr: { maxlength: 100,readonly:true }, ctrlCss: { width: '160px'}},            
            { name: 'cantidad', display: 'cantidad', type: 'text', ctrlAttr: { maxlength: 100 ,readonly:true}, ctrlCss: { width: '100px'},
                   onChange: function (evt, rowIndex) {
                       var cantidad =parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'cantidad', rowIndex)).val());
                       var precio =parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'precio', rowIndex)).val());
                       var subt=cantidad*precio;
                       $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).val(parseFloat(subt).toFixed(2));
                        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).trigger('change');
                   }
            },
            { name: 'unidad', display: 'unidad', type: 'text', ctrlAttr: { readonly:true}, ctrlCss: { width: '100px'}  },
            { name: 'costo', display: 'costo', type: 'text', ctrlAttr: { maxlength: 100,readonly:true}, ctrlCss: { width: '100px'} ,
                         onChange: function (evt, rowIndex) {
                       var cantidad =parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'cantidad', rowIndex)).val());
                       var precio =parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'precio', rowIndex)).val());
                       var subt=cantidad*precio;
                       $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).val(parseFloat(subt).toFixed(2));
                       $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).trigger('change');
                   }
            },
//            { name: 'proveedor', display: 'proveedor', type: 'select', ctrlAttr: { required:true }, ctrlCss: { width: '150px'},
//                ctrlOptions: <?php echo json_encode($proveedores)?>,
//                 emptyCriteria: 'seleccione'
//            },
            { name: 'subtotal', display: 'subtotal', type: 'text', ctrlAttr: { maxlength: 100,readonly:true }, ctrlCss: { width: '100px'},
                         onChange: function (evt, rowIndex) {
                             var i=0;
                             var total=0;
                        var filas= $('#tblAppendGrid').appendGrid('getRowCount');
                        for( ;i<filas;i++){
                           total+=parseFloat($('#tblAppendGrid').appendGrid('getCtrlValue', 'subtotal', i));                            
                        }   
                        
                         $('[name=total]').val(total.toFixed(2));
                    }
            }
        ],
        afterRowAppended: function (caller, parentRowIndex, addedRowIndex) {        
                $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', addedRowIndex)).trigger('change');
       
        },
           hideButtons: {
            moveDown:true,
            removeLast: true,
            moveUp:true,
            insert:true,
            remove:true,
            append:true
        },
            maintainScroll:true,            
            maxBodyHeight:400,
            beforeRowRemove: function (caller, rowIndex) {
                    var subt=parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).val());
                    
                    if(!isNaN(subt)){
                    var total_actual=parseFloat($('[name=total]').val());
                    var act=total_actual-subt;
                    $('[name=total]').val(parseFloat(act).toFixed(2));
                       
                    }
                     $('#tblAppendGrid').appendGrid('removeRow', rowIndex);
        }
    });
    
        $("#miforma").foundation('abide','events');
           $("[name=fecha]").datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",changeYear: true});
      $("#referencia").attr('disabled',true);
    
    $('#miforma').on('valid.fndtn.abide', function () {

      if($('#tblAppendGrid').appendGrid('getRowCount')>0){
          datos={};
          datos.traslados=$('#tblAppendGrid').appendGrid('getAllValue');
          datos.doc_no=$("[name=fac_no]").val();
          datos.bod_org=$("[name=bodega_origen]").val();
          datos.bod_dst=$("[name=bodega_destino]").val();
          datos.fecha=$("[name=fecha]").val();
          datos.notas=$("[name=notas]").val();
          datos.total=$("[name=total]").val();
          
                                    $.ajax({
                                        url:'ajax/crea_traslado.php',
                                        data:datos,
                                        success:function(data){
                                            $("span#mensaje").html(data);
                                            setTimeout(function(){
                                                 window.location.reload();
                                            },500);
                                        }
                                    });
            }

      else{
          alert('factura vacia');
      }

    
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
            e.preventDefault();
                
        ref=$("#referencia");
        cant=$("#cantidad");
        unidad=$("#unidad");
        if(ref.val() !=='' && cant.val()!=='' && unidad.val()!==''){
                
                //verificar si hay cantidad disponible pra agaregar
                    $.ajax({
                        url:'ajax/check_existencia.php',
                        data:{ref:ref.val(),cant:cant.val(),unidad:unidad.val()},
                        dataType:'json'   ,
                        success:function(data){                                                     
                            if(_.has(data,'mensaje')){
                            alert(data['mensaje']);
                            return;
                            }else{
                                       $('#tblAppendGrid').appendGrid('appendRow',
                                       [{ referencia: ref.val(),cantidad: cant.val(), unidad: unidad.val(),costo:data.cant ,subtotal:data.importe}]);

                                    $("#referencia option[value='"+ref.val()+"']").remove();
                                    ref.val('');
                                    cant.val('');
                                    unidad.val('');
            
                            }
                        }            
            });

        }else{
            alert('campos vacios');
            return;
        }
        //para evitar que cambien de bodega en el proceso
        $("[name=bodega_origen]").attr('disabled',true);
        $("[name=bodega_destino]").attr('disabled',true);
    });
    
    $("#referencia").on('change',function(){
        tmp=$(this).val();
        $('#unidad').html(mapa[tmp]);
        
    });
</script>

