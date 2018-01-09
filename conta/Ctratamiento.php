<?php   include '../plantilla.php'; 
$animales=$conex->query("select * from animales");
$productos=$conex->query("select a.referencia,a.nombre from existencias b inner join productos a on a.referencia=b.codigo_producto where b.codigo_bodega ='2'");
$productos_farm[]='seleccione';
    $inventario[]='seleccione';
while($fila=$productos->fetch()){
    $productos_farm[]=$fila[referencia].'-'.$fila[nombre];

}

$productos_farm=  json_encode($productos_farm);

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
        <div class="small-12 columns">
               <table id="tblAppendGrid">
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
var productos_added=new Array();
      $('#tblAppendGrid').appendGrid({
        initRows: 1,
        columns: [
            { name: 'producto', display: 'producto', type: 'select', ctrlAttr: { maxlength: 100,required:true }, ctrlCss: { width: '160px'}, ctrlOptions: <?php echo $productos_farm?> ,
                 onChange: function (evt, rowIndex){
                      
                     var ref=$($('#tblAppendGrid').appendGrid('getCellCtrl', 'producto', rowIndex)).val().split('-')[0];
                     if(_.indexOf(productos_added,ref)===-1){
                         productos_added.push(ref);
                     }else{
                         alert('elemento repetido');
                         $($('#tblAppendGrid').appendGrid('getCellCtrl', 'producto', rowIndex)).find('option:first').prop('selected',true)
                     }
                     

                 }
            },            
            { name: 'cantidad', display: 'cantidad', type: 'text', ctrlAttr: { maxlength: 100 ,required:true}, ctrlCss: { width: '100px'}},            
            { name: 'desde', display: 'desde', type: 'text', ctrlAttr: { maxlength: 100 ,required:true,readonly:true}, ctrlCss: { width: '100px'}},            
            { name: 'hasta', display: 'hasta', type: 'text', ctrlAttr: { maxlength: 100 ,required:true,readonly:true}, ctrlCss: { width: '100px'}},            
            { name: 'medida', display: 'medida', type: 'select', ctrlAttr: { maxlength: 4,required:true }, ctrlOptions: { 0: 'seleccione', 'ml': 'ml', 'cc': 'cc'}},
            { name: 'frecuencia', display: 'veces x dias', type: 'number', ctrlAttr: { maxlength: 4,required:true,pattern:'integer' },ctrlCss: { width: '100px'}},

        ],
        afterRowAppended: function (caller, parentRowIndex, addedRowIndex) {
        
        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'producto', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');
        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'cantidad', addedRowIndex)).after('<small class="error">requerido</small>');
        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'desde', addedRowIndex)).after('<small class="error">requerido</small>').datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
      changeYear: true});
        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'hasta', addedRowIndex)).after('<small class="error">requerido</small>').datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
      changeYear: true});
        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'medida', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');        
        $($('#tblAppendGrid').appendGrid('getCellCtrl', 'frecuencia', addedRowIndex)).after('<small class="error">requerido</small>').find('option:first').val('');        
       
        },
                  hideButtons: {
                    insert:true,
                    moveDown:true,
                    moveUp:true
        }
    });
    
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
        $("[name=fecha]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
      changeYear: true});
          

    </script>

