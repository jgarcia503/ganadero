<?php
include '../plantilla.php'; 
$prep_tierra=$conex->query("select * from prep_tierra_enc where cerrado='true' and id not in (select etapa_ant::integer from siembra_enc )");
$tipo_veg=$conex->query("select * from tipo_vegetacion");
?>
<div class="small-10 columns">
      <span id="mensaje"></span>
    <h2>siembra</h2>

    <form>
        <div class="row">
             <div class="small-6 columns">
                 <label for="">nombre
                     <input type="text" name="nombre" id="nombre">
                 </label>
                 <label>seleccione la tierra que esta lista para sembrarse
                     <select id="prep_tierra">
                     <option value="seleccione">seleccione</option>
                     <?php
                                                                            while($fila=$prep_tierra->fetch()){
                                                                                echo "<option value='$fila[id]'>$fila[nombre]</option>";
                                                                            }
                                                                ?>
                 </select>
                 </label>
   
                 
                 
             </div>
            <div class="small-6 columns">
                  
                <label for="">fecha inicio</label><input type="text" name="fecha_inicio" class="fecha" id="fecha_inicio">
                <label for="">fecha fin</label><input type="text" name="fecha_fin" class="fecha" id="fecha_fin">                
            
            </div>
        </div>
       
        <table id="tblAppendGrid">
        </table>
        
        <hr>
        <table id="tblplagas">
        </table>
        
        
        <label for="notas">notas</label><textarea name="notas" id="notas" cols="30" rows="10"></textarea>
    </form>
   
    <input type="submit" value="crear" class="button primary" id="envia">
</div>
</div>

<!--<script src="../assets/llamadas.js"></script>-->

<script>

                      $(document).on('ready',inicio);
          
          var ultimo_id;//se almacenara el id regresado por ajax
               var id_siembra;
                   var filas_added=new Array();
        function  inicio(){
                            setear_vals();
   <?php if(count($lineas_siembra)!==0){ ?>                                          
                                        $('#tblAppendGrid input').attr('readonly',true);//para hacer readonly las lineas que vienen de la bd
                                          $('#tblAppendGrid select').attr('disabled',true);
                                <?php } ?>
                                           <?php if(count($plagas_lineas)!==0){ ?>                                          
                                        $('#tblplagas input').attr('readonly',true);//para hacer readonly las lineas que vienen de la bd
                                          $('#tblplagas textarea').attr('disabled',true);
                                <?php } ?>
                    
                    $('#envia').on('click', bot_envia);
        } 
        
        function setear_vals(){
                    $(".fecha").attr('readonly', true).datepicker({dateFormat: "dd-mm-yy"});
         
                        var conf_tbl_act={
                        caption: 'actividades',
                        initRows: 1,
                        columns: [
                            {name: 'actividad', display: 'actividad', type: 'text', ctrlAttr: {maxlength: 100, require: true}, ctrlCss: {width: '90%'}},
                            {name: 'tipo', display: 'tipo', type: 'select',ctrlAttr:{require:true}, ctrlOptions: {seleccione: 'seleccione', trabajo: 'trabajo', material: 'material'}, ctrlCss: {width: '90%'}},
                            {name: 'costo', display: 'costo', type: 'number', ctrlAttr: {maxlength: 10,min:1,text:'solo numeros'}, ctrlCss: {width: '100px', 'text-align': 'right'}}
                        ],
                        hideButtons: {
                                remove: true,
                                removeLast: false,
                                 moveUp:true,
                                 moveDown:true,
                                 insert:true
                                                                    },
                         customFooterButtons: [
                                    {
                                        uiButton: { label: 'guardar' },                                        
                                        click: function (evt) {
                                              var lineas=new Array();
                                             var datos = $('#tblAppendGrid').appendGrid('getAllValue');
                                             var cuenta=0;
                                             
                                             $.each(datos,function(index,elem){
                                                    if(datos[index].actividad===''){cuenta++;}
                                                    if(datos[index].tipo===''){cuenta++;}
                                                    if(datos[index].costo===''){cuenta++;}
                                             });
                                                                                             
                                                
                                             if(cuenta===0){
                                                              if(filas_added.length!==0){//si es la primera vez que se ingresaran lineas
                                                                    $.each(filas_added,function (index,elem){
                                                                        var fila=$('#tblAppendGrid').appendGrid('getRowValue', filas_added[index]);
                                                                         if(fila!==null){
                                                                                 lineas.push(fila);
                                                                     }
                                                                    });
                                                                }else{
                                                                    var fila=$('#tblAppendGrid').appendGrid('getRowValue', 0);
                                                                    if(fila!==null){
                                                                                 lineas.push(fila);
                                                                     }
                                                                }
                                                         $.ajax({
                                                                    url:'siembra/actividadesAjax.php',
                                                                    method:'get',
                                                                    type:'json',
                                                                    data:{lineas: lineas,id_siembra:id_siembra},
                                                                    success: function (respuesta) {
                                                                            $('#tblAppendGrid input').attr('readonly',true);//para hacer readonly las lineas que vienen de la bd
                                                                            $('#tblAppendGrid select').attr('disabled',true);
                                                                       filas_added=[];
                                                         
                                                                        }
                                                        });
                                                }else{
                                                    alert('ingrese datos');
                                                }
                                        },
                                        atTheFront: true
                                    }
                                ],
                            afterRowAppended: function (caller, parentRowIndex, addedRowIndex) {
                                            if(parentRowIndex!==null){                                     
                                                     filas_added.push(addedRowIndex[0]);
                                                    }
                                    },
                           afterRowRemoved: function (caller, rowIndex) {
                                     filas_added=_.without(filas_added,filas_added[filas_added.length-1]);
                                    }

                    };

                   <?php if(count($lineas_siembra)!==0){ ?>
                           conf_tbl_act.initData=<?php echo json_encode($lineas_siembra) ?>;   
                   <?php } ?>
                    $('#tblAppendGrid').appendGrid(conf_tbl_act);
                    
     var filas_added_plagas=new Array();
                    var conf_tbl_plagas={
                        caption: 'plagas',
                        initRows: 1,
                        columns: [
                            {name: 'plagas', display: 'plagas', type: 'text', ctrlAttr: {maxlength: 100, require: true}, ctrlCss: {width: '90%'}},                            
                            {name: 'tratamiento', display: 'tratamiento', type: 'textarea', ctrlAttr: {cols:50}, ctrlCss: {width: '100%',resize:'none'}}
                                                ],
                          customFooterButtons: [
                                    {
                                        uiButton: { label: 'guardar' },                                        
                                        click: function (evt) {
                                             lineas=new Array();
                                             var datos = $('#tblplagas').appendGrid('getAllValue');
                                             console.log(datos);
                                             var cuenta=0;
                                             $.each(datos,function(index,elem){
                                                    if(datos[index].plagas===''){cuenta++;}
                                                    if(datos[index].tratamiento===''){cuenta++;}                                                    
                                             });
                                                                                             
                                                
                                             if(cuenta===0){
                                                                      if(filas_added_plagas.length!==0){
                                                                                                $.each(filas_added_plagas,function (index,elem){
                                                                                                    var fila=$('#tblplagas').appendGrid('getRowValue', filas_added_plagas[index]);
                                                                                                     if(fila!==null){
                                                                                                             lineas.push(fila);
                                                                                                 }
                                                                                                });
                                                                               }else{
                                                                                    var fila=$('#tblplagas').appendGrid('getRowValue', 0);
                                                                                    if(fila!==null){
                                                                                                 lineas.push(fila);
                                                                                     }
                                                                }
                                                                          
                                                         $.ajax({
                                                                    url:'siembra/plagasAjax.php',
                                                                    method:'get',
                                                                    type:'json',
                                                                    data:{lineas: lineas,id_siembra:id_siembra},
                                                                    success: function (respuesta) {
                                                                            $('#tblplagas input,textarea').attr('readonly',true);//para hacer readonly las lineas que vienen de la bd
                                                                            
                                                                       filas_added_plagas=[];
                                                         
                                                                        }
                                                        });
                                                }else{
                                                    alert('ingrese datos');
                                                }
                                        },
                                        atTheFront: true
                                    }
                                ],
                            afterRowAppended: function (caller, parentRowIndex, addedRowIndex) {
                                            if(parentRowIndex!==null){                                     
                                                     filas_added_plagas.push(addedRowIndex[0]);
                                                    }
                                    },
                           afterRowRemoved: function (caller, rowIndex) {
                                     filas_added_plagas=_.without(filas_added_plagas,filas_added_plagas[filas_added_plagas.length-1]);
                                    }
                    };
                    
                    <?php if(count($plagas_lineas)!==0){ ?>
                           conf_tbl_plagas.initData=<?php echo json_encode($plagas_lineas) ?>;   
                   <?php } ?>
                     $('#tblplagas').appendGrid(conf_tbl_plagas);
                    
                    
                         $('#tblAppendGrid,#tblplagas').hide();
}
        
function bot_envia() {                
                var nombre=$('#nombre').val();
                var etapa_anterior=$('#prep_tierra').val();
                var notas=$('#notas').val();
                var fecha_inicio=$('#fecha_inicio').val();
                var fecha_fin=$('#fecha_fin').val();
                var datos={};
                
                if (nombre === '') {
                    $('#nombre').notify('nombre de etapa', {className: 'info', autoHideDelay: 1500});
                    return;
                }else{
                    datos.nombre=nombre;
                }        
                
                                if (fecha_inicio === '') {
                    $('#fecha_inicio').notify('elija fecha', {className: 'info', autoHideDelay: 1500});
                    return;
                }else{
                    datos.fecha_inicio=fecha_inicio;
                }


                if (fecha_fin ==='') {
                    $('#fecha_fin').notify('elija fecha', {className: 'info', autoHideDelay: 1500});
                    return;
                }else{
                    datos.fecha_fin=fecha_fin;
                }
                    
                    if(etapa_anterior==='seleccione'){
                          $('#prep_tierra').notify('elija', {className: 'info', autoHideDelay: 1500});
                          return;
                    }else{
                        datos.etapa_ant=etapa_anterior;
                    }
                    
                datos.notas=notas;
                datos.cerrado='false';
                            
                              
                                                        $.ajax({
                                                                    url:'CpsiembraAjax.php',
                                                                    method:'get',
                                                                    type:'json',
                                                                    data:datos,
                                                                        success: function (datos) {
                                                                            if(datos.split('|')[1]!==undefined){
                                                                                $("span#mensaje").html(datos.split('|')[0]);
                                                                                $(".alert-box").fadeOut(2500);
                                                                                $('#tblAppendGrid,#tblplagas').show();
                                                                                ultimo_id=datos.split('|')[1];
                                                                                id_siembra=ultimo_id;
                                                                            }else{
                                                                                $("span#mensaje").html(datos);
                                                                                         $(".alert-box").fadeOut(2500);
                                                                            }
                                                                        }
                                                        });
        

    
}
    </script>