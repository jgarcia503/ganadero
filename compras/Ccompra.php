<?php   
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

while($filapro=$resprods->fetch()){
    $productos[]=$filapro[referencia].'-'.$filapro[nombre];
    if($filapro[unidad_standar]=='kg'){
        $unit_prod[$filapro[referencia]]=$unit_peso;
    }else{
        $unit_prod[$filapro[referencia]]=$unit_vol;
    }
    
}


$sql_bodega="select * from bodega";
$res=$conex->query($sql_bodega);
?>
<div class="small-10 columns">
    <h2>crear compra</h2>
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
    <span id="mensaje"></span>
    <form data-abide='ajax' id="miforma">
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
    var mapa=<?php echo json_encode($unit_prod); ?>;

    //{'seleccione':'seleccione','qq':'quintal','g':'gramos','kg':'kilogramos','oz':'onzas',
//                                                            ,'lb':'libras'}
  $('#tblAppendGrid').appendGrid({        
        initRows: 1,
        idPrefix: 'linea',
        columns: [
            {name: 'bodega', display: 'bodega', type: 'select', ctrlAttr: { maxlength: 100,required:true }, ctrlCss: { width: '160px'},
                  ctrlOptions:<?php            echo json_encode($bodegas);     ?>
            },
            { name: 'referencia', display: 'referencia', type: 'select', ctrlAttr: { maxlength: 100,required:true }, ctrlCss: { width: '160px'} ,
                     ctrlOptions: <?php echo json_encode($productos)?>,
                     onChange:function(evt,rowIndex){
                         prod=$($('#tblAppendGrid').appendGrid('getCellCtrl', 'referencia', rowIndex)).val().split('-')[0];
                         $($('#tblAppendGrid').appendGrid('getCellCtrl', 'unidad', rowIndex)).html(mapa[prod]);
                      
                     }
            },            
            { name: 'cantidad', display: 'cantidad', type: 'text', ctrlAttr: { maxlength: 100 ,required:true}, ctrlCss: { width: '100px'},
                   onChange: function (evt, rowIndex) {
                       var cantidad =parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'cantidad', rowIndex)).val());
                       var precio =parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'precio', rowIndex)).val());
                       var subt=cantidad*precio;
                       $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).val(parseFloat(subt).toFixed(2));
                        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).trigger('change');
                   }
            },
            { name: 'unidad', display: 'unidad', type: 'select', ctrlAttr: { required:true}, ctrlCss: { width: '100px'} 
                      
            },
            { name: 'precio', display: 'precio', type: 'text', ctrlAttr: { maxlength: 100,required:true}, ctrlCss: { width: '100px'} ,
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
        
        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'bodega', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'referencia', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'cantidad', addedRowIndex)).after('<small class="error">requerido</small>');
        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'unidad', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'precio', addedRowIndex)).after('<small class="error">requerido</small>');
        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'proveedor', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
        
       
        },
           hideButtons: {
            moveDown:true,
            removeLast: true,
            moveUp:true,
            insert:true
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
    
    $('#miforma').on('valid.fndtn.abide', function () {

      if($('#tblAppendGrid').appendGrid('getRowCount')>0){
          
                                              $.ajax({
                                        url:'ajax/crea_compra.php',
                                        data:$(this).serialize(),
                                        success:function(data){
                                            $("span#mensaje").html(data);
                                            setTimeout(function (){
                                                 window.location.reload();
                                            },500);
                                        }
                                    });
            }

      else{
          alert('factura vacia');
      }

    
  });
  
    $("[name=fecha]").datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
      changeYear: true});

</script>