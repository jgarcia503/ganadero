<?php
include '../plantilla.php'; 
$id=base64_decode($_SERVER[QUERY_STRING]);

$enc=$conex->query("select * from prep_tierra_enc where id=$id")->fetch();
$lns=$conex->query("select actividad,tipo_costo tipo,costo from prep_tierra_lns where id_enc=$enc[id]");
$potrero_id=$conex->query("select id from potrero where nombre='$enc[potrero]'")->fetch()[id];
$arrayLns=[];
        while($fila=$lns->fetch(PDO::FETCH_ASSOC)){
            $arrayLns[]=$fila;
        }
?>

<div class="small-10 columns">
      <span id="mensaje"></span>
      <h2>preparacion tierra</h2>

    <form>
        <div class="row">
             <div class="small-6 columns">
                 <label for="">nombre</label>
                 <input type="text" name="nombre"  id="nombre" value="<?php echo $enc[nombre]?>" readonly="">
                 <label for="">potrero</label>
                 <input type="text" name="potrero"  list="potreros" id="potrero" value="<?php echo $enc[potrero]?>" readonly="">
                 <input type="hidden" id="potrero_id" value="<?php echo $potrero_id ?>">
                 <label for="">tipo cultivo</label>
                 <input type="text" name="tipo_cultivo" list="veg" id="tipo_cultivo" value="<?php echo $enc[tipo_cultivo]?>" readonly="">                 

                 
                 
            </div>
            <div class="small-6 columns">
                <label for="">fecha inicio</label><input type="text" name="fecha_inicio" class="fecha" id="fecha_inicio" value="<?php echo $enc[fecha_inicio]?>">
                <label for="">fecha fin</label><input type="text" name="fecha_fin" class="fecha" id="fecha_fin" value="<?php echo $enc[fecha_fin]?>">                
            </div>
        </div>

        <table id="tblAppendGrid">
        </table>
        <input type="hidden"  value="<?php echo $enc[id]?>"  id="id_enc">
        <label for="notas">notas</label><textarea name="notas" id="notas" cols="30" rows="10" readonly=""><?php echo $enc[notas] ?></textarea>
    </form>

    <input type="submit" value="crear" class="button primary" id="envia">
</div>
</div>

<!--<script src="../assets/llamadas.js"></script>-->

<script>

                      $(document).on('ready',inicio);
                      var filas_added=new Array();
                      
        function  inicio(){
                            setear_vals();
                    
                    $('#tblAppendGrid input').attr('readonly',true);//para hacer readonly las lineas que vienen de la bd
                    $('#tblAppendGrid select').attr('disabled',true);//para hacer readonly las lineas que vienen de la bd
                    $('.flexdatalist').flexdatalist({minLength: 1, searchContain: true, focusFirstResult: true});
                    $('#envia').on('click', bot_envia);
        } 
        
        function setear_vals(){
                    $(".fecha").attr('readonly', true).datepicker({dateFormat: "dd-mm-yy"});

                    $('#tblAppendGrid').appendGrid({
                        caption: 'actividades',                                            
                        columns: [
                            {name: 'actividad', display: 'actividad', type: 'text', ctrlAttr: {maxlength: 100, require: true}, ctrlCss: {width: '90%'}},
                            {name: 'tipo', display: 'tipo', type: 'select',ctrlAttr:{require:true}, ctrlOptions: {seleccione: 'seleccione', trabajo: 'trabajo', material: 'material'}, ctrlCss: {width: '90%'}},
                            {name: 'costo', display: 'costo', type: 'number', ctrlAttr: {maxlength: 10,min:1,text:'solo numeros'}, ctrlCss: {width: '100px', 'text-align': 'right'}}
                                                ],
                          initData:<?php echo json_encode($arrayLns) ?>,
                           hideButtons: {
                                remove: true,
                                removeLast: true,
                                 moveUp:true,
                                 moveDown:true,
                                 insert:true
                                                                    },
                        afterRowAppended: function (caller, parentRowIndex, addedRowIndex) {
                            if(parentRowIndex!==null){
                                            filas_added.push(addedRowIndex[0]);
                                }
                        }                                                                           

                    });
        }
        
function bot_envia() {                
               
           
                var id_enc=$('#id_enc').val();
 
                var datos={};
                    datos.id_enc=id_enc;
                    

                    

$(document.forms[0]).validate();

    $('#tblAppendGrid').appendGrid('removeEmptyRows');
                var vacios=0;
                          //var lineas = $('#tblAppendGrid').appendGrid('getAllValue');
                          var lineas=new Array() ;
                          $.each(filas_added,function (index,elem){
                              var fila=$('#tblAppendGrid').appendGrid('getRowValue', filas_added[index]);
                               if(fila!==null){
                                       lineas.push(fila);
                           }
                          });
                          
           
        
                          
                            $.each(lineas,function (index,elem){
                                if(lineas[index]['actividad']==='' ||
                                         lineas[index]['tipo']==='seleccione' ||
                                         lineas[index]['costo']===''){
                                     vacios++;
                                }
                 
                            });
                              
        if(vacios !== 0){
            alert('campos vacios');
        }else{
                              datos.lineas=lineas;
                                                        $.ajax({
                                                                    url:'UptierraAjax.php',
                                                                    method:'get',
                                                                    data:datos,
                                                                        success: function (datos) {
                                                                                $("span#mensaje").html(datos);
                                                                                $(".alert-box").fadeOut(2500);
                                                                                window.location.reload();
                                                                        }
                                                        });
        }

    
}
    </script>