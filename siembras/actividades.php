<?php
include '../plantilla.php';
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

$proy_id=  explode('=', base64_decode( $_SERVER[QUERY_STRING]))[1];
$control='select nombre from controles_potreros';
$productos="select a.codigo_producto,b.nombre,b.precio_promedio,a.existencia,b.unidad_standar 
    from existencias a 
inner join productos b 
on b.referencia=a.codigo_producto 
where codigo_bodega 
in (
select bodega_seleccionada from proyectos_enc where id_proyecto =$proy_id
) ";
$activos="select *,(precio_promedio::numeric(10,5)/vida_util::numeric(10,5))::numeric(10,4) costo_hora_uso from activo";
$resactivos=$conex->query($activos);
$rescontrol=$conex->query($control);
$resproductos=$conex->query($productos);
$actividad=['seleccione'];
 $inventario=['seleccione'];
 $activos=['seleccione'];
while($filapro=$resproductos->fetch()){
            $inventario[]=$filapro[nombre];

                if($filapro[unidad_standar]=='kg'){
                        $unit_prod[$filapro[nombre]]=$unit_peso;
                }else{
                    $unit_prod[$filapro[nombre]]=$unit_vol;
                }

            if(!array_key_exists($filapro[nombre], $_SESSION['inventario'])){
                $_SESSION['inventario'][$filapro[nombre]]=  floatval($filapro[existencia]);
                $_SESSION['costo_unit'][$filapro[nombre]]=  floatval($filapro[precio_promedio]);
            }
}
while($fila=$rescontrol->fetch()){
    $actividad[]=$fila[nombre];

 
}
$html_act="<select class='hide' id='acts'>";
while($fila=$resactivos->fetch()){
    $activos[]=$fila['referencia'];
    $html_act.="<option value='$fila[referencia]'>$fila[costo_hora_uso]";
    $html_act.="</option>";
}
$html_act.="</select>";
?>
<div class="small-10 columns"  >
    <div id="mensaje"></div>
    <h2>actividades</h2>
    <a href="" class="actividades">actividades</a>
                       <form data-abide='ajax' id='actividades'>
                            <table id="tblAppendGrid">
                            </table>    
                          
                           <button type="submit">crear</button>
                        </form>
    
</div>  
<div id="mimodal" class="reveal-modal"  data-reveal >
    <span></span>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
</div>

<style>
    .ancho{        
        align-content: center
    }
</style>
<script>
        var mapa=<?php echo json_encode($unit_prod); ?>;
    // Initialize appendGrid
    $('#tblAppendGrid').appendGrid({

        initRows: 1,          
        hideRowNumColumn:true,
        columns: [
            { name: 'fecha', display: 'fecha', type: 'text', ctrlAttr: { maxlength: 4 ,required:true,readonly:true}, ctrlCss: { width: '100px'} },
            { name: 'actividad', display: 'actividad', type: 'select',ctrlOptions: <?php echo json_encode($actividad) ?> , ctrlAttr: { maxlength: 100 ,required:true}, ctrlCss: { width: 'auto'} },
            { name: 'tipo', display: 'tipo', type: 'select', ctrlOptions:['seleccione','material','mano de obra','deterioro activo'], ctrlCss: { width: '100px'} , ctrlAttr: { required:true},
                 onChange: function (evt, rowIndex) {
                     tipo=$($('#tblAppendGrid').appendGrid('getCellCtrl', 'tipo', rowIndex)).val();
                     switch(tipo){
                         case 'material':
                            $($('#tblAppendGrid').appendGrid('getCellCtrl', 'costo', rowIndex)).attr({'readonly':true,'required':false}).val('');
                            $($('#tblAppendGrid').appendGrid('getCellCtrl', 'producto', rowIndex)).attr({'disabled':false,'required':true});
                            $($('#tblAppendGrid').appendGrid('getCellCtrl', 'unidad', rowIndex)).attr({'disabled':false,'required':true});
                            $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).attr({'readonly':true,'required':false});
                            $($('#tblAppendGrid').appendGrid('getCellCtrl', 'dias_cant', rowIndex)).val('');
                            $('#tblAppendGrid').appendGrid('hideColumn', 'activo');
                            $('#tblAppendGrid').appendGrid('showColumn', 'producto');
                            $('#tblAppendGrid').appendGrid('showColumn', 'unidad');
                            $('#tblAppendGrid').appendGrid('showColumn', 'dias_cant');
                             break;
                         case 'mano de obra':
                             $($('#tblAppendGrid').appendGrid('getCellCtrl', 'costo', rowIndex)).attr({'readonly':false,'required':true});
                             $($('#tblAppendGrid').appendGrid('getCellCtrl', 'producto', rowIndex)).attr({'disabled':true,'required':false});
                             $($('#tblAppendGrid').appendGrid('getCellCtrl', 'unidad', rowIndex)).attr({'disabled':true,'required':false});
                             $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).attr({'readonly':false,'required':true}).val('');
                             $('#tblAppendGrid').appendGrid('hideColumn', 'activo');
                             $('#tblAppendGrid').appendGrid('showColumn', 'costo');
                             $('#tblAppendGrid').appendGrid('showColumn', 'dias_cant');
                             break;
                         case 'deterioro activo':
                              $('#tblAppendGrid').appendGrid('showColumn', 'activo');
                              $('#tblAppendGrid').appendGrid('showColumn', 'costo_hora_uso');
                              $('#tblAppendGrid').appendGrid('hideColumn', 'unidad');
                              $('#tblAppendGrid').appendGrid('hideColumn', 'producto');
                              $('#tblAppendGrid').appendGrid('hideColumn', 'dias_cant');
                              $('#tblAppendGrid').appendGrid('hideColumn', 'costo');
                              $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).attr({'readonly':true}).val('');
                     }                     
                 }
             },
            { name: 'costo', display: 'mano de obra', type: 'text', ctrlAttr: { maxlength: 4,required:true }, ctrlCss: { width: '80px'} },
            { name: 'producto', display: 'producto', type: 'select',ctrlOptions: <?php echo json_encode($inventario) ?> , ctrlAttr: { maxlength: 4,required:true }, ctrlCss: { width: '100px'},
                    onChange:function(evt,rowIndex){
                        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'dias_cant', rowIndex)).trigger('change');
                          prod=$($('#tblAppendGrid').appendGrid('getCellCtrl', 'producto', rowIndex)).val();
                         $($('#tblAppendGrid').appendGrid('getCellCtrl', 'unidad', rowIndex)).html(mapa[prod]);
                    }
            },
            {name:'activo',display:'activo',type:'select',ctrlOptions: <?php echo json_encode($activos) ?>,invisible:true,
                    onChange:function(evt,rowIndex){
                              var act=$($('#tblAppendGrid').appendGrid('getCellCtrl', 'activo', rowIndex)).find('option:selected').val();                              
                              //$('#acts option[value="qweqweqw"]').html()                              
                            subt=parseFloat($('#acts option[value='+act+']').html()) * parseFloat($($('#tblAppendGrid').appendGrid('getCellCtrl', 'costo_hora_uso', rowIndex)).val());
                            $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).val(numeral(subt).format('0.00000'))
                }
            },
            {name:'costo_hora_uso',display:'horas uso',type:'text',invisible:true,cellCss: { 'width': '30px' },
                    onChange:function(evt,rowIndex){
                        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'activo', rowIndex)).trigger('change');
                        
                    }
            },
            { name: 'unidad', display: 'unidad', type: 'select', ctrlAttr: { required:true}, ctrlCss: { width: '100px'} ,
                        onChange:function(evt,rowIndex){
                        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'dias_cant', rowIndex)).trigger('change');
                    }
            },
            { name: 'dias_cant', display: 'dias/cant.', type: 'text', ctrlAttr: { maxlength: 10,required:true }, ctrlCss: { width: '60px'} ,
                onChange:function(evt,rowIndex){
                    tipo=$($('#tblAppendGrid').appendGrid('getCellCtrl', 'tipo', rowIndex)).val();
                    if(tipo==='material'){
                            producto=$($('#tblAppendGrid').appendGrid('getCellCtrl', 'producto', rowIndex)).val();
                            cant=parseFloat( $($('#tblAppendGrid').appendGrid('getCellCtrl', 'dias_cant', rowIndex)).val());
                            unidad=$($('#tblAppendGrid').appendGrid('getCellCtrl', 'unidad', rowIndex)).val();
                            if(producto!=='' || cant !==NaN || unidad !== ''){
                                            $.ajax({
                                                url:'ajax/controlar_inventario.php',
                                                data:{prod:producto,cantidad:cant,unidad:unidad,tipo:'-'},
                                                dataType:'json',
                                                success:function(data){
                                                    if(_.has(data,'mensaje')){
                                                        alert(data['mensaje']);
                                                        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'dias_cant', rowIndex)).val('');
                                                        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).val('');
                                                    }else{
                                        
                                                        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', rowIndex)).val(data['importe']);
                                                    }                                            
                                                }

                                            });
                                        }
                   }
                                //alert($($('#tblAppendGrid').appendGrid('getCellCtrl', 'dias_cant', rowIndex)).val());
                }
            },            
            { name: 'subtotal', display: 'subtotal', type: 'text', ctrlAttr: { maxlength: 4,required:true }, ctrlCss: { width: '60px'} },            
            { name: 'notas', display: 'notas', type: 'textarea', ctrlAttr: { cols:20,rows:5}, ctrlCss: { width: 'auto',resize:'none'} }

        ],
               hideButtons: {
                        remove: false,
             	insert:true,
             	moveUp:true,
             	moveDown:true,
                },
                 afterRowAppended: function (caller, parentRowIndex, addedRowIndex) {
                     $($('#tblAppendGrid').appendGrid('getCellCtrl', 'fecha', addedRowIndex)).after('<small class="error">requerido</small>').datepicker({ dateFormat: "dd-mm-yy" ,changeYear: true,  changeMonth: true});
                     $($('#tblAppendGrid').appendGrid('getCellCtrl', 'actividad', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
                     $($('#tblAppendGrid').appendGrid('getCellCtrl', 'tipo', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
                     $($('#tblAppendGrid').appendGrid('getCellCtrl', 'costo', addedRowIndex)).after('<small class="error">requerido</small>');
                     $($('#tblAppendGrid').appendGrid('getCellCtrl', 'dias_cant', addedRowIndex)).after('<small class="error">requerido</small>');
                     $($('#tblAppendGrid').appendGrid('getCellCtrl', 'subtotal', addedRowIndex)).after('<small class="error">requerido</small>');
                     $($('#tblAppendGrid').appendGrid('getCellCtrl', 'producto', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
                     $($('#tblAppendGrid').appendGrid('getCellCtrl', 'unidad', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
                                        
                 },
                  beforeRowRemove: function (caller, rowIndex) {
                             if( confirm('sure?')){
                                 producto=$($('#tblAppendGrid').appendGrid('getCellCtrl', 'producto', rowIndex)).val();
                                cant=parseFloat( $($('#tblAppendGrid').appendGrid('getCellCtrl', 'dias_cant', rowIndex)).val());
                                unidad=$($('#tblAppendGrid').appendGrid('getCellCtrl', 'unidad', rowIndex)).val();
                               $.ajax({
                                        url:'ajax/controlar_inventario.php',
                                        data:{prod:producto,cantidad:cant,unidad:unidad,tipo:'+'},
                                        success:function(data){
                                              $('#tblAppendGrid').appendGrid('removeRow', rowIndex);
                                        }
                                        
                                    });
                             }
                         }
//        useSubPanel: true,
//        subPanelBuilder: function (cell, uniqueIndex) {
//            // Create a table object and add to sub panel
//            var subgrid = $('<table></table>').attr('id', 'tblSubGrid_' + uniqueIndex).appendTo(cell);
//            // Optional. Add a class which is the CSS scope specified when you download jQuery UI
//            subgrid.addClass('alternate');
//            // Initial the sub grid
//            subgrid.appendGrid({
//                initRows: 1,
//                hideRowNumColumn: true,
//                columns: [
//                    {name: 'referencia', display: 'referencia',type:'text', ctrlAttr: { readonly: true },ctrlCss: { 'width': '100px'},cellCss: { 'width': '100px' },value:'codigo' },
//                    { name: 'producto', display: 'producto',type:'select',ctrlOptions: <?php echo json_encode($inventario) ?> , ctrlCss: { 'width': '200px'} ,ctrlAttr: { required: true },
//                                            onChange: function (evt, rowIndex){
//                                                $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'producto', rowIndex)).attr('disabled',true);
//                            var cant=$($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'cantidad', rowIndex)).val();
//                            var ref=$($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'producto', rowIndex)).find('option:selected').val();                            
//                                sublineas=$('#tblSubGrid_'+uniqueIndex).appendGrid('getAllValue');
//                            //var producto=$($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'producto', rowIndex)).find('option:selected').val();
//                            $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'referencia', rowIndex)).val(referencias[ref]);
//                            $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'disponible', rowIndex)).val(inventario_cant[ref]);
//                            $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'costo', rowIndex)).val(costo_producto[ref]);
//                            var codigo=$($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'referencia', rowIndex)).val();
//                            
//                            if(ref!=='seleccione'){
//                            
//                                for(i=0;i<sublineas.length;i++){
//                                    if(sublineas[i].referencia===codigo){
//                                        alert('relemento repetido');
//                                        $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'referencia', rowIndex)).val('codigo');
//                                        $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'producto', rowIndex)).find('option:first').prop('selected',true);
//                                        $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'disponible', rowIndex)).val('');
//                                    }
//                                }
//                                    
//                                    
//                            }else{
//                                //$('#tblAppendGrid').appendGrid('getRowValue', rowIndex).lineas[1].referencia
//               
//                                
//                                $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'referencia', rowIndex)).val('codigo');
//                                $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'disponible', rowIndex)).val('n/a');
//                            }
//                            
//                            
//                            if(ref==='seleccione' || cant===''){return;}
//                            //if(cant===''){return;}
//                            else{
//                                inventario_tmp=parseFloat(inventario_cant[ref])-parseFloat(cant);
//                                if(inventario_tmp<0){
//                                    alert('cant insuficiente hay '+inventario_cant[ref]);
//                                    $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'cantidad', rowIndex)).val('');
//                                }else{
//                                    inventario_cant[ref]=parseFloat(inventario_tmp);
//                                }
//                            }                            
//                           
//                        }
//                    },    
//                    { name: 'cantidad', display: 'cantidad', ctrlCss: { 'width': '60px', 'text-align': 'right' }, ctrlAttr: { required: true },
//                        onChange: function (evt, rowIndex){
//                            var cant=$($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'cantidad', rowIndex)).val();
//                            var ref=$($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'producto', rowIndex)).find('option:selected').val();
//                            if(ref==='seleccione'){ alert('elija prod');return;}
//                            if(cant===''){return;}
//                            else{                                
//                                inventario_tmp=parseFloat(inventario_cant[ref])-parseFloat(cant);
//                                if(inventario_tmp<0){
//                                    alert('cant insuficiente hay '+inventario_cant[ref]);
//                                    $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'cantidad', rowIndex)).val('');
//                                }else{
//                                    inventario_cant[ref]=parseFloat(inventario_tmp);
//                                    $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'disponible', rowIndex)).val(inventario_cant[ref]);
//                                }
//                            }
//                        }           
//            
//                    },
//                    {name:'disponible',display:'disponible',ctrlAttr: { readonly:true }, ctrlCss: { 'width': '60px'}},
//                    { name: 'costo', display: 'costo', ctrlCss: { 'width': '60px', 'text-align': 'right' }, value: 1 , ctrlAttr: { readonly:true }}
//                ],
//                 beforeRowRemove: function (caller, rowIndex) {
//                     var cant=parseFloat($($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'cantidad', rowIndex)).val());
//                     var ref=$($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'producto', rowIndex)).find('option:selected').val();
//                     if(ref==='seleccione'){ $('#tblSubGrid_'+uniqueIndex).appendGrid('removeRow', rowIndex);return;}
//                     if(!isNaN(cant)){
//                         inventario_cant[ref]=parseFloat(inventario_cant[ref])+parseFloat(cant);
//                         
//                     }
//                           $('#tblSubGrid_'+uniqueIndex).appendGrid('removeRow', rowIndex);
//                 },
//                 afterRowAppended: function (caller, parentRowIndex, addedRowIndex) {
//                                         $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'producto', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
//                                         $($('#tblSubGrid_'+uniqueIndex).appendGrid('getCellCtrl', 'cantidad', addedRowIndex)).after('<small class="error">requerido</small>');
//                  },
//                   hideButtons: {
//                        remove: false,
//             	insert:true,
//             	moveUp:true,
//             	moveDown:true
//                }
//            });
//        },
//        subPanelGetter: function (uniqueIndex) {
//            // Return the sub grid value inside sub panel for `getAllValue` and `getRowValue` methods
//            return {'lineas':$('#tblSubGrid_' + uniqueIndex).appendGrid('getAllValue')};
//            
//        }
    });


    $("#actividades").foundation('abide','events');
    
    $('#actividades').on('valid.fndtn.abide', function () {
    //$('#tblAppendGrid').appendGrid('removeEmptyRows');
      if($('#tblAppendGrid').appendGrid('getRowCount')>0){
          datos={};
          datos.proy_id=<?php echo $proy_id ?>;          
          datos.acts=$('#tblAppendGrid').appendGrid('getAllValue');
                                              $.ajax({
                                                        url:'ajax/actividades.php',
                                                        data:{datos:datos},
                                                        success:function(data){
                                                            $("div#mensaje").html(data);
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


    $(".actividades").on('click',function(e){
    e.preventDefault();
        $.ajax({
                                    url: "ajax/ver_actividades.php?"+'<?php echo base64_decode($_SERVER[QUERY_STRING]) ?>',
                                    success: function (datos) {

                                        $('#mimodal span').html(datos);

                                    }
                                });
                $('#mimodal').foundation('reveal', 'open');
    });
        
//window.addEventListener("beforeunload", function (event) {
//
//    event.preventDefault();
//    alert('dfsfds');
//});
</script>


<?php
echo $html_act;
?>