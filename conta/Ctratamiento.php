<?php   include '../plantilla.php'; 
$animales=$conex->query("select * from animales");
$productos=$conex->query("select a.referencia,a.nombre,b.existencia from existencias b inner join productos a on a.referencia=b.codigo_producto where b.codigo_bodega ='2'");
?>


<div class="small-10 columns">
    <span id="mensaje"></span>
    <form action="" method="post" data-abide='ajax' id="miforma">    
        <h2>crear tratamiento medico</h2>
    <div class="row">
        <?php echo $mensaje ?>
        <div class="small-2 columns">
                <label for="">fecha</label>
                <input type="text" name="fecha"  required="">
                 <small class="error">elija fecha</small>
        </div>
        <div class="small-4 columns">
                <label for="">tipo tratamiento</label>
                <select name="tipo" required="">
                    <option value="">seleccione</option>
                    <option value="receta_medica">tratamiento por receta medica</option>
                    <option value="eventual">tratamiento eventual</option>
                    <option value="rutinario">tratamiento rutinario</option>
                </select>
                 <small class="error">elija tipo tratamiento</small>
        </div>
        <div class="small-6 columns">
                             <label for="">animal</label>
                             <select name="animal" id="" required="">
                            <option value="">seleccione animal</option>
        <?php
        while($fila=$animales->fetch()){
            echo "<option value='$fila[numero]-$fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
        }
        ?>
                </select>
                <small class="error">elija animal</small>
        </div>
    </div>
        <div class="row">
            <div class="small-12 columns">
                <label>descripcion tratamiento</label>
                <input type="text" name="descripcion">
            </div>
        </div>
    <div class="row">
        <div class="small-3 columns">           
            <label>producto
                <select name="producto">
                    <option value="">seleccione</option>
                    <?php
                    
                    $productos=$conex->query("select a.referencia,a.nombre,b.existencia,a.unidad_standar from existencias b inner join productos a on a.referencia=b.codigo_producto where b.codigo_bodega ='2'");
                    while($fila=$productos->fetch()){
                        echo "<option value='$fila[referencia]' data-unidad='$fila[unidad_standar]' data-existencia='$fila[existencia]'>". $fila[referencia].'-'.$fila[nombre]."</option>";

                            }
                    ?>
                </select>
            </label>
            </div>
        <div class="small-1 columns">          
                        <label>cantidad
            <input type="text" name="cant">
            </label>
            </div>
        <div class="small-2 columns">   
            <label>desde
            <input type="text" name="desde">
            </label>
            </div>
        <div class="small-2 columns">   
            <label>hasta
            <input type="text" name="hasta">
            </label>
            </div>
        <div class="small-1 columns">   
            <label>medida
                <input type="text" name="medida" readonly="">
            </label>
            </div>
        <div class="small-1 columns">   
            <label>veces x dia
            <input type="text" name="veces_x_dia">
            </label>
            </div>
             <div class="small-2 columns">   
                 <button value="agregar" id="add">agregar</button>
            </div>
        <div class="small-12 columns">           
               <table id="tblAppendGrid" width='100%'>                   
               </table>  
        </div>

    </div>
    
    <div class="row">
        <div class="small-12 columns">
            <label for="">notas</label><textarea name="notas" id="" cols="30" rows="10"></textarea>
            <input type="submit" class="button primary" id="envia">
        </div>
    </div>

</form>

</div>
</div>


<!--<a href="catalogo.php">catalogo</a>-->


</div>

<script>
//var productos_added=new Array();
//      $('#tblAppendGrid').appendGrid({
//        initRows: 1,
//        columns: [
//            { name: 'producto', display: 'producto', type: 'select', ctrlAttr: { maxlength: 100,required:true }, ctrlCss: { width: '160px'}, ctrlOptions: <?php echo $productos_farm?> ,
//                 onChange: function (evt, rowIndex){
//                      
//                     var ref=$($('#tblAppendGrid').appendGrid('getCellCtrl', 'producto', rowIndex)).val().split('-')[0];
//                     if(_.indexOf(productos_added,ref)===-1){
//                         productos_added.push(ref);
//                     }else{
//                         alert('elemento repetido');
//                         $($('#tblAppendGrid').appendGrid('getCellCtrl', 'producto', rowIndex)).find('option:first').prop('selected',true)
//                     }
//                     
//
//                 }
//            },            
//            { name: 'cantidad', display: 'cantidad', type: 'text', ctrlAttr: { maxlength: 100 ,required:true}, ctrlCss: { width: '100px'}},            
//            { name: 'desde', display: 'desde', type: 'text', ctrlAttr: { maxlength: 100 ,required:true,readonly:true}, ctrlCss: { width: '100px'}},            
//            { name: 'hasta', display: 'hasta', type: 'text', ctrlAttr: { maxlength: 100 ,required:true,readonly:true}, ctrlCss: { width: '100px'}},            
//            { name: 'medida', display: 'medida', type: 'select', ctrlAttr: { maxlength: 4,required:true }, ctrlOptions: { 0: 'seleccione', 'ml': 'ml', 'cc': 'cc'}},
//            { name: 'frecuencia', display: 'veces x dias', type: 'number', ctrlAttr: { maxlength: 4,required:true,pattern:'integer' },ctrlCss: { width: '100px'}},
//
//        ],
//        afterRowAppended: function (caller, parentRowIndex, addedRowIndex) {
//        
//        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'producto', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
//        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'cantidad', addedRowIndex)).after('<small class="error">requerido</small>');
//        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'desde', addedRowIndex)).after('<small class="error">requerido</small>').datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
//      changeYear: true});
//        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'hasta', addedRowIndex)).after('<small class="error">requerido</small>').datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
//      changeYear: true});
//        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'medida', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');        
//        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'frecuencia', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');        
//       
//        },
//                  hideButtons: {
//                    insert:true,
//                    moveDown:true,
//                    moveUp:true
//        }
//    });
    
    /////////////////////////////////////////termina appendgrid///////////////////////////////
    $("#miforma").foundation('abide','events');
    
    $('#miforma').on('valid.fndtn.abide', function () {

      if($('#tblAppendGrid').appendGrid('getRowCount')>0){
          datos={};
          animal=$('[name=animal] option:selected').val();
          fecha=$('[name=fecha]').val();
          tipo=$('[name=tipo]').val();
          descripcion=$('[name=descripcion]').val();
          lineas=$('#tblAppendGrid').appendGrid('getAllValue');
          
          datos.animal=animal;
          datos.fecha=fecha;
          datos.lineas=lineas;
          datos.tipo=tipo;
          datos.descripcion=descripcion;
                                              $.ajax({
                                        url:'Ctratamientoajax.php',
                                        data:{datos:datos},
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
    <?php
    $partes=  explode(' ', $_SESSION[fecha]);
    ?>
        $("[name=fecha],[name=desde],[name=hasta]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
      changeYear: true});
          
$('[name=producto]').on('change',function(){
    unidad=$(this).find('option:selected').data('unidad');    
        $('[name=medida]').val(unidad);    
});

var productos=[];
  $('#tblAppendGrid').appendGrid({
        caption: 'productos',
        initRows: 0,
        columns: [
            { name: 'producto', display: 'producto', type: 'text', ctrlAttr: { readonly:true } },
            { name: 'cant', display: 'cant', type: 'text', ctrlAttr: {readonly:true } },
            { name: 'desde', display: 'desde', type: 'text', ctrlAttr: { readonly:true }},
            { name: 'hasta', display: 'hasta', type: 'text' ,ctrlAttr: { readonly:true }},
            { name: 'medida', display: 'medida', type: 'text',ctrlAttr: { readonly:true } },
            { name: 'veces', display: 'veces', type: 'text', ctrlAttr: { readonly:true } }            
        ],
        hideButtons:{
            append:true,
            removeLast:true,
            insert:true,
            remove:true,
            moveUp:true,
            moveDown: true
        }
    });
$('#add').on('click',function(e){
    e.preventDefault();
    producto=$('[name=producto]').val();
    cant=$('[name=cant]').val();
    desde=$('[name=desde]').val();
    hasta=$('[name=hasta]').val();
    medida=$('[name=medida]').val();
    veces=$('[name=veces_x_dia]').val();
    disponible=$('[name=producto]').find('option:selected').data('existencia');
    //limpiar
    $('[name=producto]').val('');
    $('[name=cant]').val('');
    $('[name=desde]').val('');
    $('[name=hasta]').val('');
    $('[name=medida]').val('');
    $('[name=veces_x_dia]').val('')
    
    if(producto==='' || cant==='' || desde==='' || hasta==='' || medida==='' || veces===''){
        alert('complete todos los campos');
        return;
    }
    f1=moment(desde,'DD-MM-YYYY');
f2=moment(hasta,'DD-MM-YYYY');
dias=parseInt(f2.diff(f1,'days'));

    if(disponible>=(cant*veces*dias)){
            if(_.indexOf(productos, producto)===-1){
                    productos.push(producto);
                         $('#tblAppendGrid').appendGrid('appendRow', [ 
                            { producto: producto, cant: cant, desde: desde,hasta:hasta,medida:medida,veces:veces}
                        ]);
        }    
    }else{
        alert('cantidad insuficiente, hay '+disponible)
    }
});
    </script>

