<?php
include '../../plantilla.php';
$animales=$conex->query("select * from animales");

?>

<div class="small-12 columns">
    <h2>pruebas CMT</h2>
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
    <div class="row">
        <span id="mensaje">
            
        </span>
        <div class="small-3 columns">
       
            <div class="row">
                <div class="small-12 columns">                 
                    <label>fecha
                    <input type="text" name="fecha">
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="small-12 columns">                 
                             <label>animal
                 <select id="animal" class="js-example-basic-single">
                     <option value="">seleccione</option>
                     <?php
                     while($fila=$animales->fetch()){
                         echo "<option value='$fila[numero]'>$fila[nombre]</option>";
                     }
                     ?>
                 </select>
                        </label>
            </div>
            </div>
                
            <div class="row">
                <div class="small-6 columns">
                     <label>DI
                         <select id="ubre_1">
                <option value="">seleccione</option>
                
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="c">clinico</option>
                <option value="x">cuarto ciego</option>
                <option value="t">traza</option>                
                <option value="-">-</option>
            </select>
                    </label>
                </div>
                <div class="small-6 columns">
                     <label>DR
                         <select id="ubre_2">
                <option value="">seleccione</option>
                
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="c">clinico</option>
                <option value="x">cuarto ciego</option>
                <option value="t">traza</option>
                <option value="-">-</option>
            </select>
                    </label>
                </div>                 
            </div>
            <div class="row">
                <div class="small-6 columns">
                     <label>TI
                         <select id="ubre_3">
                <option value="">seleccione</option>
                
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="c">clinico</option>
                <option value="x">cuarto ciego</option>
                <option value="t">traza</option>
                <option value="-">-</option>
            </select>
                    </label>
                </div>
                <div class="small-6 columns">
                     <label>TD
                         <select id="ubre_4">
                <option value="">seleccione</option>
                
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="c">clinico</option>
                <option value="x">cuarto ciego</option>
                <option value="t">traza</option>
                <option value="-">-</option>
            </select>
                    </label>
                </div>  
            </div>
            <div class="row">
                <div class="small-12 columns">
                    <button id="add"> add</button>
            </div>
            </div>

            
            
        </div>    
        
        <div class="small-9 columns">
                             <table id="tblAppendGrid">
                            </table>
            <button id="save" >crear registro</button>
        </div>    
    </div>    
    
        </div>
</div>

<script>        
    $("[name=fecha]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy"});
    
    $(document).ready(function() {
                $('.js-example-basic-single').select2();
                        });
    
        $('#tblAppendGrid').appendGrid({        
        initRows: 0,
        columns: [
            { name: 'animal', display: 'animal', type: 'text', ctrlAttr: { readonly: true }},
            { name: 'ubre_1', display: 'DI', type: 'text', ctrlAttr: { readonly: true }},
            { name: 'ubre_2', display: 'DR', type: 'text', ctrlAttr: { readonly: true }},
            { name: 'ubre_3', display: 'TI', type: 'text', ctrlAttr: { readonly:true} },
            { name: 'ubre_4', display: 'TR', type: 'text' ,ctrlAttr: { readonly:true} }            
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
        maintainScroll: true
    });
    
    $("#add").on('click',function(){
        
        ub1=$("#ubre_1").val();
        ub2=$("#ubre_2").val();
        ub3=$("#ubre_3").val();
        ub4=$("#ubre_4").val();
        animal=$("#animal").val();
        $("#animal").find('option:selected').remove();
  
        if(ub1!=='' || ub2!=='' || ub3!=='' || ub4 !=='' || animal!==''){
         $('#tblAppendGrid').appendGrid('appendRow', [ 
        { animal: animal, ubre_1: ub1, ubre_2: ub2, ubre_3: ub3, ubre_4: ub4 }                
            ]);   
        }
        else{
            alert('complete los campos');
            return;
        }
         
    });
    
    $("#save").on('click',function(e){
        e.preventDefault();
        fecha=$("[name=fecha]").val();
        tabla=$('#tblAppendGrid').appendGrid('getAllValue');
        datos={};
        datos.fecha=fecha;
        datos.tabla=tabla;
        
        $.ajax({
            url:'../ajax/cmt.php',
            data:datos,
            success:function(data){
                $("#mensaje").html(data);
                setTimeout(function(){
                    window.location.reload();
                },1000);
            }
        });
        
    });
    
    </script>