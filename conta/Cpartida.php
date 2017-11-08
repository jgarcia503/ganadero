<?php   include '../plantilla.php'; 

?>
<div class="small-10 columns">
    <span id="mensaje"></span>
<form action="" method="post" data-abide>    
        <h2>crear partida</h2>
    <div class="row">
        <?php echo $mensaje ?>
        <div class="small-6 columns">
                <label for="">fecha</label>
                <input type="text" name="fecha" >
                 <small class="error">elija fecha</small>
        </div>
        <div class="small-6 columns">
                <label for="">factura</label>
                <input type="text" name="factura" >
                 <small class="error">elija hora</small>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
                <label for="">proveedor</label>
          <input type="text" name="proveedor" class="awesomplete" list="proveedores" data-minchars="1"> 
        <datalist id="proveedores">
        <?php
//        while($fila=@$proveedores->fetch()){
//            echo "<option value='$fila[numero]'>$fila[nombre]</option>";
//        }
        ?>
    </datalist>
        </div>
        <div class="small-6 columns">
            <label for="">producto</label>
            <input type="text" name="producto" class="awesomplete" list="productos" data-minchars="1" id="producto"> 
                  <datalist id="productos">
                  <?php
//                  while($fila=$productos->fetch()){
//                      echo "<option value='$fila[nombre]' data-info='$fila[nombre],$fila[precio],$fila[unidad],$fila[categoria],$fila[marca]'>$fila[nombre]</option>";
//                  }
                  ?>
              </datalist>
        </div>
    </div>
    
    <div class="row">
        <div class="small-12 columns">
            <table style="width: 100%" id="lineas_fact">
        <thead>
        <tr>
                <th>nombre</th>
                <th>unidad</th>
                <th>cantidad</th>
                <th>precio</th>
                <th>subtotal</th>                
                <th>eliminar</th>                
         </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4"><span style="float: right">total</span></th>
                <th id="total">0</th>
            </tr>
        </tfoot>
    </table>
        </div>

        
        
        <div class="small-12 columns">
            <label for="">notas</label><textarea name="notas" id="" cols="30" rows="10"></textarea>
            <input type="button" class="button primary" id="envia" value="registrar">
        </div>
    </div>

</form>

</div>
</div>

<script>
    $("[name=fecha]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});
    
            //var productoslist=Array();
            var productosDetalles={};
            var productosfact=Array();
            var total=0;
            var cantidad_anterior;
            
        $("#productos option").each(function(index,elem){
    //productoslist.push(elem.innerHTML);
    productosDetalles[elem.innerHTML]=elem.dataset.info;

                        });       
                        
           var no_permitidos=Array();
          for(var i =0;i<=128;i++){
              if(i>=48 && i<=57){//numeros
                  continue;
              }
              no_permitidos.push(String.fromCharCode(i));
          }
    
    ///////////////////////////////////////////////////////////////////////////////
$("[name=producto]").on('keypress',function(e){
             var valor=$(this).val();     
                         var cantidad=1;
            if(e.which==13){
                if(valor!==''){                                       
                    
                    //si el valor no esta en la lista de los animales
                        //if(productoslist.indexOf(valor)=== -1){ 
                        
                        if(productosDetalles[valor]===undefined){ 
                            $(this).notify("elemento no coincidente",{className: 'info',autoHideDelay: 1500});
                            return;
                        }
                        
                        //si el animal ya esta en el lote
                        if(productosfact.indexOf(valor) !== -1){
                            $(this).notify("elemento repetido",{className: 'info',autoHideDelay: 1500});
                            return;
                        }
                    
                            var valores=productosDetalles[valor].split(',');
                           var nombre=valores[0];
                           var precio=valores[1];
                           var unidad=valores[2];
                           var categoria=valores[3];
                           var marca=valores[4];
                           
                            var subtotal=parseFloat(precio)*parseInt(cantidad);
               
                   
                           $("tbody:first").append('<tr><td>' + nombre + '</td><td>' + unidad + '</td><td><span id="cantidad">'+cantidad+'</span></td><td>'+precio+'</td><td>'+subtotal+'</td><td><a href="#" class="quitar">eliminar</a></td></tr>');                                                    
                           $(this).val("");
                           productosfact.push(valor);
                           total+=parseFloat(subtotal);
                            $('#total').html(total);
                                          
                            }
                            else{
                                $(this).notify("elija un producto",{className: 'info',autoHideDelay: 1500});
                            }
                }
});

        ///quitar 
        $("table").on('click','a.quitar',function(e){
            e.preventDefault();
            var valor=$(this).parents('tr').find('td:first').html();                        
            productosfact=_.without(productosfact,valor);
            total-=parseFloat($(this).parents('tr').find('td:eq(4)').html());
     
              $('#total').html(total);
                  
            $(this).parents("tr").remove();
        });
        
        ////////////////////////////////////////////////////////////////////////
 $("table").on('click','#cantidad',function(){
        cantidad_anterior=parseInt($(this).html());
     $(this).attr('contenteditable',true)
                            .css({'border':'1px dashed red','width':'30%','background-color':'pink'})
                            .focus()
         
  
          });


         $("table").on('blur','#cantidad',function(){
             var cantidad_actual=parseInt($(this).html());
             var dif;            
             var precio=parseFloat($(this).parents('tr').find('td:eq(3)').html());
             var subtotal=$(this).parents('tr').find('td:eq(4)');
             
                    if($(this).html()==''){
                             $(this).notify('no puede estar vacio',{className: 'info',autoHideDelay: 1500})
                                                 .focus();
                        return;
                    }
                                $(this).css({'border':'none','background-color':'white'})
                                                    .attr('contenteditable',false);
                                           
                                if(cantidad_actual>cantidad_anterior){
                                    dif=cantidad_actual-cantidad_anterior;
                                    total+=(precio*dif);
                                }else{
                                    dif=cantidad_anterior-cantidad_actual;
                                    total-=(precio*dif);
                                }
                               
                               subtotal.html(precio*cantidad_actual);
                                        $('#total').html(total);
                           
     
          });        
          ///////////////////////////////////////////////          
          
          $('table').on('keypress','#cantidad',function(e){
          
              if((e.keyCode===13 || _.indexOf(no_permitidos,e.key)!== -1)||
                        ($(this).html().length===4 && e.keyCode!==8)   
                ){        
                        e.preventDefault();
              }               

              
          });
          
                /////////////////////////////////////////////////////////////////////
                $("#envia").on('click',function(e){                    
                    e.preventDefault();                    
                    var datoscadena='';
                    var notas=$('[name=notas]').val();
                    var fecha=$('[name=fecha]').val();
                    var proveedor=$('[name=proveedor]').val();
                    var factura=$('[name=factura]').val();
                    var total=$('#total').html();
                    
                    if(fecha=='' ){$('[name=fecha]').notify('elija fecha',{className: 'info',autoHideDelay: 1500});return; }
                    if( proveedor=='' ){$('[name=proveedor]').notify('elija proveedor',{className: 'info',autoHideDelay: 1500}); return;}
                        if( $("#lineas_fact tr td").length>0){
                                                $("#lineas_fact tr td").each(function(index,element){
                                                    var element=$(element);
                                                    
                                                    if($(element.html()).is("a")){
                                                        datoscadena+='|';
                                                    }
                                                    else if($(element.html()).is("span")){
                                                        datoscadena+=$(element.html()).html()+',';
                                                    }                                      
                                                    else{
                                                    datoscadena+=element.html()+',';                        
                                                        }                        
                                                                                    });

                                                            $.ajax({
                                                                url:'Ccompraajax.php',
                                                                data:{lineas_fact:datoscadena,fecha:fecha,proveedor:proveedor,factura:factura,notas:notas,total:total},
                                                                method:'get',
                                                                success: function (datos) {
                                                                   $("span#mensaje").html(datos);
                                                                   $(".alert-box").fadeOut(2500);
                                                                   $("[name=fecha],[name=animal],[name=peso],textarea").val("");
                                                                   $("#pesos tbody tr").remove();
                                                                   productosfact.splice(0,productosfact.length);
                                                                           }

                                                            });
                                                        }    
                                                        else{
                                                            $.notify("no puede estar vacia la tabla",{className: 'info',autoHideDelay: 1500});
                                                        }                               
                                                            //console.log(datoscadena);
                    });
        
</script>
