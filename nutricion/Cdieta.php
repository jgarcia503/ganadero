<?php   include '../plantilla.php';
$productos=$conex->query("select * from productos");

?>

<div class="small-10 columns">
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
        while($fila=$productos->fetch()){
            echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
        }
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
</div>
</div>
<script>
    
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

    </script>