<?php
include '../plantilla.php'; 
$potreros=$conex->query("select * from potreros");
$tipo_veg=$conex->query("select * from tipo_vegetacion");
?>
<div class="small-10 columns">
      <span id="mensaje"></span>
    <h2>preparacion tierra</h2>

    <form>
        <div class="row">
             <div class="small-6 columns">
                 <label for="" >nombre</label>
                 <input type="text" name="nombre"  id="nombre">
                 <label for="">potrero</label>
                 <input type="text" name="potrero"  list="potreros"  id="potrero"  >
                 <label for="">tipo cultivo</label>
                 <input type="text" name="tipo_cultivo" list="veg"  id="tipo_cultivo">                 
                 <datalist id="potreros">
                     <?php
                                                            while($fila=$potreros->fetch()){
                                                                echo "<option value='$fila[id]-$fila[nombre]'>$fila[id]-$fila[nombre]</option>";
                                                            }
                                                                ?>
                 </datalist>
                 <datalist id="veg">
                     <?php
                                                                    while($fila=$tipo_veg->fetch()){
                                                                        echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                                                                    }
                                                                ?>
                 </datalist>
                 
                 
        </div>
            <div class="small-6 columns">
                <label for="">fecha inicio</label><input type="text" name="fecha_inicio" class="fecha" id="fecha_inicio">
                <label for="">fecha fin</label><input type="text" name="fecha_fin" class="fecha" id="fecha_fin">                
            </div>
        </div>
       
        <table id="tblAppendGrid">
        </table>
       
        <label for="notas">notas</label><textarea name="notas" id="notas" cols="30" rows="10"></textarea>
    </form>
   
    <input type="submit" value="crear" class="button primary" id="envia">
</div>
</div>

<!--<script src="../assets/llamadas.js"></script>-->

<script>

                      $(document).on('ready',inicio);
          
          
        function  inicio(){
                            setear_vals();
                    $('#potrero').flexdatalist({minLength: 1, searchContain: true, focusFirstResult: true,searchDisabled:true});
                    $('#tipo_cultivo').flexdatalist({minLength: 1, searchContain: true, focusFirstResult: true});

                    
                    $('#envia').on('click', bot_envia);
                    $('#tblAppendGrid').on('change','.prueba', verifica);
        } 
        
        function setear_vals(){
                    $(".fecha").attr('readonly', true).datepicker({dateFormat: "dd-mm-yy"});


                    $('#tblAppendGrid').appendGrid({
                        caption: 'actividades',
                        initRows: 5,
                        columns: [
                            {name: 'actividad', display: 'actividad', type: 'text', ctrlAttr: {maxlength: 100, require: true}, ctrlCss: {width: '90%'}},
                            {name: 'tipo', display: 'tipo', type: 'select',ctrlAttr:{require:true,class:'prueba'}, ctrlOptions: {seleccione: 'seleccione', trabajo: 'trabajo', material: 'material'}, ctrlCss: {width: '90%'}    },
                            {name: 'costo', display: 'costo', type: 'number', ctrlAttr: {maxlength: 10,min:1,text:'solo numeros'}, ctrlCss: {width: '100px', 'text-align': 'right'}},
                            {name: 'plaga', display: 'plaga', type: 'text', ctrlAttr: {maxlength: 10,min:1,text:'solo numeros',readonly:true,class:'plaga'}, ctrlCss: {width: '100px', 'text-align': 'right'}}
                        ],
                         maxBodyHeight: 240
                         
                    });
}

function verifica(){

    switch($(this).val()){
        case 'trabajo':
            $(this).parents('tr').find('.plaga').attr('readonly',false);
            break;
        case 'material':
            $(this).parents('tr').find('.plaga').attr('readonly',true);
            break;
    }
}
        
function bot_envia() {                
                var nombre=$('#nombre').val();
                var fecha_inicio=$('#fecha_inicio').val();
                var fecha_fin=$('#fecha_fin').val();
                var potrero=$('#potrero').val().split('-')[1];
                var potrero_id=$('#potrero').val().split('-')[0];
                var tipo_cultivo=$('#tipo_cultivo').val();
      
                var notas=$('#notas').val();
                var datos={};
                
                if (nombre === '') {
                    $('#nombre').notify('nombre de etapa', {className: 'info', autoHideDelay: 1500});
                    return;
                }else{
                    datos.nombre=nombre;
                }
                
                
                   if (potrero === undefined) {
                    $('#potrero').notify('escriba nombre de potrero', {className: 'info', autoHideDelay: 1500});
           
                    return;
                }else{
                    datos.potrero=potrero;
                    datos.potrero_id=potrero_id;
                }
                
                if (tipo_cultivo === '') {
                    $('#tipo_cultivo').notify('seleccione tipo de cultivo', {className: 'info', autoHideDelay: 1500});
                    return;
                }else{
                    datos.tipo_cultivo=tipo_cultivo;
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
                    
                    
                datos.notas=notas;


$(document.forms[0]).validate();

      $('#tblAppendGrid').appendGrid('removeEmptyRows');
                var vacios=0;
                          var lineas = $('#tblAppendGrid').appendGrid('getAllValue');
                          lineas=_.without(lineas,'_RowCount');
        
                          
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
                                                                    url:'CptierraAjax.php',
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