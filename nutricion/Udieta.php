<?php   include '../plantilla.php';
$productos=$conex->query("select * from productos");

$id=base64_decode($_SERVER[QUERY_STRING]);
$dietas=$conex->query("select * from dietas where id=$id")->fetch();

?>

<div class="small-10 columns">
    <span id="mensaje">
    
    </span>

<form action="" >
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
    <label for="">nombre dieta</label>
    <input type="text" name="nom_dieta" value="<?php echo  $dietas[nombre]?>">
    <label for="">producto</label>
    <input type="text" name="producto" class="awesomplete" list="prods" data-minchars="1" data-autofirst> 

   
    <datalist id="prods">
        <?php
        while($fila=$productos->fetch()){
            echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
        }
        ?>
    </datalist>
    <label for="">cantidad</label>
    <input type="text" name="cantidad">
    <button id="adicionar">adicionar producto</button>
    <table id="productos">
        <thead>
            <th>nombre</th>            
            <th>cantidad</th>
            <th>editar</th>   
        </thead>
        <tbody>
           <?php
                                                        $sqldietaprod=$conex->query("select  regexp_split_to_table(rtrim(producto,','),',') prod , regexp_split_to_table(rtrim(cantidad,','),',') cant  from dietas where id=$id");
                                                        while($fila=$sqldietaprod->fetch()){                                                            
                                                  echo "<tr>";
                                                 echo "<td>";
                                                 echo $fila[prod];
                                                 echo "</td>";
                                                 echo "<td>";
                                                 echo $fila[cant];
                                                 echo "</td>";
                                                 echo "<td>";
                                                 echo "<a href='#' class='quitar'>eliminar</a>";
                                                 echo "</td>";
                                                 echo "</tr>";                                                            
                                                        }
                                       ?>
        </tbody>
    </table>
         <label for="">notas</label>
         <textarea name="notas" id="" cols="30" rows="10" name="notas">
            <?php echo $dietas[notas] ?>
         </textarea>
             <input type="hidden" value="<?php echo $id?>" name="dieta_id">
             <input type="hidden" value="<?php echo $dietas[nombre]?>" name="dieta_ant">
             <input type="submit" class="button primary" id="envia" value="actualizar registro">
</form>
</div>
</div>
<script>
        var productosdieta=Array();
        var productoslist=Array();
                $("#prods option").each(function(index,elem){
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
                    var dieta_id=$("[name=dieta_id]").val();
                    var dieta_ant=$("[name=dieta_ant]").val();
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
                                                                             url:'Udietaajax.php',
                                                                             data:{prods:datoscadena,notas:notas,dieta:dieta,dieta_id:dieta_id,dieta_ant:dieta_ant},
                                                                             method:'get',
                                                                             success: function (datos) {
                                                                                  $("span#mensaje").html(datos);
                                                                                $(".alert-box").fadeOut(2500);          
                                                                                
//                                                                                $("input").not('[type=button]').val("");
//                                                                                $("#productos tbody tr").remove();
                                                                                        }

                                                                         });
                                                                 }
                                                                 else{
                                                                     alert("seleccione potrero")
                                                                 }
                                           }else{
                                               alert("no puede estar vacia la tabla");
                                           }
                    });//cierro on click


    </script>
