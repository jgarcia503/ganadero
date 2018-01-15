<?php //   include '../plantilla.php';
//$productos=$conex->query("select * from productos");

?>

<!--<div class="small-10 columns">
       <h2>crear dieta</h2>
       <a href="javascript:history.back(1)" class="regresar">regresar</a>
    <span id="mensaje">
    
    </span>

<form action="" >
    <label for="">nombre dieta</label>
    <input type="text" name="nom_dieta">
    <label for="">producto</label>
    <select name="producto" id="producto">
        <option value="">seleccione</option>
            <?php
//        while($fila=$productos->fetch()){
//            echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
//        }
        ?>
    </select>

    <label for="">cantidad</label>
    <input type="text" name="cantidad">
    <button id="adicionar">adicionar producto</button>
    <table id="productos" style="width: 100%">
        <thead>
            <th>nombre</th>            
            <th>cantidad</th>
            <th>editar</th>   
        </thead>
        <tbody>
        </tbody>
    </table>
         <label for="">notas</label>
        <textarea name="notas" id="" cols="30" rows="10" name="notas"></textarea>
        <input type="submit" class="button primary" id="envia" value="crear registro">
</form>
</div>-->
<!--</div>-->
<!--<script>
    
        var productosdieta=Array();
        var productoslist=Array();
                $("#producto option").each(function(index,elem){
                    productoslist.push(elem.innerHTML);
                        });
                        
    
        $("#adicionar").on('click',function(e){
          e.preventDefault();
            var producto=$("[name=producto]").val().trim();
      
          var cantidad=$("[name=cantidad]").val().trim();          
          
          if(producto==='' || cantidad===''){
              $(this).notify("producto o cantidad vacios",{className: 'info',autoHideDelay: 1500});
              return;
          }
         
             if(productoslist.indexOf(producto)=== -1){ 
                  $(this).notify("elemento no coincidente",{className: 'info',autoHideDelay: 1500});
                    return;
               }
         
          if(productosdieta.indexOf(producto)!== -1){
              $(this).notify("producto ya esta en dieta",{className: 'info',autoHideDelay: 1500});
              return;
          }
          
          $("tbody:first").append('<tr><td>'+producto+'</td><td>'+cantidad+'</td><td><a href="#" class="quitar">eliminar</a></td></tr>');
          productosdieta.push(producto);
          $("[name=producto],[name=cantidad]").val("");
                });
                //////////////////////////////////////////////////////////////////////////////////////
                     $("table").on('click','a.quitar',function(e){
                    e.preventDefault();                    
                       var valor=$(this).parents('tr').find('td:first').html();
                        productosdieta=_.without(productosdieta,valor);
                    $(this).parents("tr").remove();

                });
                ///////////////////////////////////////////////////////////////////////////////////////////
                                $("#envia").on('click',function(e){                    
                    e.preventDefault();                    
                    var datoscadena='';
                    var notas=$('[name=notas]').val();
                    var dieta=$("[name=nom_dieta]").val();
                    
                    if($("#productos tr td").length>0){
                        if($("[name=nom_dieta]").val()!==''){
                                                                $("#productos tr td").each(function(index,element){
                                                                    var element=$(element);
                                                                    if($(element.html()).is("a")){
                                                                        datoscadena+=',';
                                                                    }else{
                                                                    datoscadena+=element.html()+'=';                        
                                                                        }                        
                                                                                                    });
                                                                                                    datoscadena=datoscadena.replace(/=,/g,',');
                                           
                                                                         $.ajax({
                                                                             url:'Cdietaajax.php',
                                                                             data:{prods:datoscadena,notas:notas,dieta:dieta},
                                                                             method:'get',
                                                                             success: function (datos) {
                                                                                  $("span#mensaje").html(datos);
                                                                                $(".alert-box").fadeOut(2500);
                                                                                $("input").not('[type=submit]').val("");
                                                                                $("#productos tbody tr").remove();
                                                                                        }

                                                                         });
                                                                 }
                                                                 else{
                                                                     alert("escriba nombre dieta")
                                                                 }
                                           }else{
                                               alert("no puede estar vacia la tabla");
                                           }
                    });//cierro on click

    </script>-->

<?php   include '../plantilla.php';
$sql_bodega="select * from bodega where codigo in (select distinct codigo_bodega from existencias)";
$sql_reque="select * from motivos_requesiciones";
$sql_grupo="select * from grupos";
$res_bodega=$conex->query($sql_bodega);
$res_motivo=$conex->query($sql_reque);
$res_grupo=$conex->query($sql_grupo);
?>
<div class="small-12 columns">
    <h2>crear dieta</h2>
    <a href="dietas.php" class="regresar">regresar</a>
    <span id="mensaje"></span>
    <form data-abide='ajax' id="miforma">
            <div class="row">
                <!--<div class="small-12 columns"><h3 style="color: white;background-color: black" class="text-center">factura</h3></div>-->
        
        <div class="small-12 columns ">
            
            <table  width="100%">

        <tbody>
              <tr>
            
             <td>
                 <label class="inline">bodega </label>
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
                 <label class="inline">motivo </label>                 
                    </td>
                    <td>
                        <select name="motivo">
                            <option value="">seleccione</option>
                            <?php
                                                        while($fila=$res_motivo->fetch()){
                                                                       echo "<option value='$fila[id]'>$fila[descripcion]</option>";
                                                                  }
                                    ?>
                        </select>
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
                  <label class="inline">grupo</label>
              </td>            
            <td>
                <select name="grupo">
                    <option value="">seleccione</option>
                    <?php
                    while($fila=$res_grupo->fetch()){
                        echo "<option value='$fila[id]'>$fila[nombre]</option>";
                    }
                            ?>
                </select>
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
      //$("#referencia").attr('disabled',true);
    
    $('#miforma').on('valid.fndtn.abide', function () {

      if($('#tblAppendGrid').appendGrid('getRowCount')>0){
          datos={};
          datos.traslados=$('#tblAppendGrid').appendGrid('getAllValue');
          datos.motivo=$('[name=motivo]').val();
          datos.grupo=$('[name=grupo]').val();
          //datos.doc_no=$("[name=fac_no]").val();
          datos.bod_org=$("[name=bodega_origen]").val();
          //datos.bod_dst=$("[name=bodega_destino]").val();
          datos.fecha=$("[name=fecha]").val();
          datos.notas=$("[name=notas]").val();
          datos.total=$("[name=total]").val();
          
                                    $.ajax({
                                        url:'ajax/crea_dieta.php',
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
  

      
//            $("[name=bodega_destino]").on('change',function(){
//                if($(this).val()===''){
//                    $("#referencia").attr('disabled',true);
//                }else{
//                    $("#referencia").attr('disabled',false);
//                }
//            });
      
      $("[name=bodega_origen]").on('change',function(){
          bodega_id=$(this).val();                  
             
                    $.ajax({
                        url:'../compras/ajax/bodegas.php',
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
                        url:'../compras/ajax/check_existencia.php',
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

