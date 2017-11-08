<?php   include '../plantilla.php';
$potreros=$conex->query("select * from potreros");
$controles=$conex->query("select * from controles_potreros");
$productos=$conex->query("select * from productos");

$id=base64_decode($_SERVER[QUERY_STRING]);
$control_potrero=$conex->query("select * from control_potreros where id=$id")->fetch();

?>

<div class="small-10 columns">
<span></span>
<form action="" >    
    <div class="row">
        <div class="small-6 columns">
            <label for="">potrero</label>
    <select name="potrero" >
        <option value="">seleccione</option>
    <?php
        while($fila=$potreros->fetch()){
            echo "<option value='$fila[nombre]' ";
            echo $fila[nombre]==$control_potrero[potrero]?'selected':'';
            echo ">$fila[nombre]</option>";
        }
        ?>
    </select>
        </div>
        <div class="small-6 columns">
             <label for="">tipo</label>
    <select name="tipo" >
        <option value="seleccione">seleccione</option>
                       <?php
        while($fila=$controles->fetch()){
            echo "<option value='$fila[nombre]' ";
            echo $fila[nombre]==$control_potrero[tipo]?'selected':'';
            echo ">$fila[nombre]</option>";
        }
        ?>
    </select>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
             <label for="">fecha</label>
             <input type="text" name="fecha" value="<?php echo $control_potrero[fecha] ?>">
        </div>
        <div class="small-6 columns"></div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <label for="">producto</label>
            <input type="text" name="producto" class="awesomplete" list="prods" data-minchars="1"  data-autofirst>
            <datalist id="prods">
                <?php
                        while ($fila=$productos->fetch()){
                            echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                        }
                                                ?>
            </datalist>
        </div>
        <div class="small-6 columns">
            <label for="">cantidad</label>
    <input type="text" name="cantidad">
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
            <button value="adicionar muestra" id="adicionar">adicionar muestra</button>
            <table border='1' style="width: 100%" id="productos">
        <thead>
        <tr>
                <th>producto</th>
                <th>cantidad</th>
                <th>editar</th>
                
         </tr>
        </thead>
        <tbody>
                <?php
                                                   $sqlveges=$conex->query("select  regexp_split_to_table(rtrim(producto,','),',') prod , regexp_split_to_table(rtrim(cantidad,','),',') cant  from control_potreros where id=$id");
                                                  while($fila=$sqlveges->fetch()){                                                            
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
        </div>
    </div>

   
    <div class="row">
        <div class="small-12 columns">
            <label for="">notas</label>
            <textarea name="nota" cols="30" rows="10">
            <?php echo  $control_potrero[notas] ?>
            </textarea>
        <input type="button" value="actualizar registro" id="envia" class="button primary" >
        </div>
    </div>

     
</form>

</div>
</div>
<script>
        var productospotrero=Array();
        var productoslist=Array();
                $("#prods option").each(function(index,elem){
                    productoslist.push(elem.innerHTML);
                        });
                        
                  $("[name=fecha]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy"});
                  $("[name=fecha]").datepicker(  "setDate", new Date());               
             
                        
        $("#adicionar").on('click',function(e){
          e.preventDefault();
            var cantidad=$("[name=cantidad]").val().trim();
      
          var producto=$("[name=producto]").val().trim();          
          
          if(cantidad==='' || producto===''){
              $(this).notify("producto o cantidad vacios",{className: 'info',autoHideDelay: 1500});
              return;
          }
         
             if(productoslist.indexOf(producto)=== -1){ 
                  $(this).notify("elemento no coincidente",{className: 'info',autoHideDelay: 1500});
                    return;
                }
         
          if(productospotrero.indexOf(producto)!== -1){
              $(this).notify("producto ya esta en potrero",{className: 'info',autoHideDelay: 1500});
              return;
          }
          
          $("tbody:first").append('<tr><td>'+producto+'</td><td>'+cantidad+'</td><td><a href="#" class="quitar">eliminar</a></td></tr>');
          productospotrero.push(producto);
          $("[name=producto],[name=cantidad]").val("");
                });
                //////////////////////////////////////////////////////////////////////////////////////
                     $("table").on('click','a.quitar',function(e){
                    e.preventDefault();                    
                       var valor=$(this).parents('tr').find('td:first').html();
                        productospotrero=_.without(productospotrero,valor);
                    $(this).parents("tr").remove();

                });
                ///////////////////////////////////////////////////////////////////////////////////////////
                                $("#envia").on('click',function(e){                    
                    e.preventDefault();                    
                    var datoscadena='';
                    var notas=$('[name=notas]').val();
                    var potrero=$("[name=potrero]").val();
                    var fecha=$("[name=fecha]").val();
                    var tipo=$('[name=tipo]').val();
                    if($("#productos tr td").length>0){
                        if($("[name=potrero]").val()!==''){
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
                                                                             url:'Ccontrolpotreroajax.php',
                                                                             data:{productos:datoscadena,notas:notas,tipo:tipo,potrero:potrero,fecha:fecha},
                                                                             method:'get',
                                                                             success: function (datos) {
                                                                                  $("span").html(datos);
                                                                                $(".alert-box").fadeOut(2500);
                                                                                $("input").not('[type=button]').val("");
                                                                                $("#prods tbody tr").remove();
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