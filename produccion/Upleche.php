<?php   include '../plantilla.php'; 
$animales=$conex->query("select * from animales");
$id=base64_decode($_SERVER[QUERY_STRING]);
$contactos=$conex->query("select nombre from contactos where tipo='empleado'");
$pesoleche_enc=$conex->query("select * from bit_peso_leche_enc where id=$id")->fetch();
$pesoleche_lns=$conex->query("select regexp_split_to_table(rtrim(hora,','),',') hora
,regexp_split_to_table(rtrim(numero,','),',') numero
,regexp_split_to_table(rtrim(nombre,','),',') nombre
,regexp_split_to_table(rtrim(peso,','),',') peso from bit_peso_leche_lns where id_enc=$pesoleche_enc[id]");
?>

    <div class="small-10 columns">
    <div class="row">
        <div class="small-12 columnns"><span id="mensaje">
    </span></div>
    </div>
    

<form action="">
    <div class="row">
        <div class="columns small-6">
            <label for="">empleado</label>
            <select name="empleado" id="">
        <?php 
                            while($fila=$contactos->fetch()){
                                                echo "<option value='$fila[nombre]' ";
                                                echo $fila[nombre]==$pesoleche_enc[empleado]?'selected':'';
                                                echo ">$fila[nombre]</option>";
                                    }
                        ?>
    </select>
        </div>
        <div class="columns small-6">
            <label for="">fecha</label>
            <input type="text" name="fecha" value="<?php echo $pesoleche_enc[fecha]?>">
        </div>
    </div>
    <div class="row">
        <div class="columns small-6">
            <label for="">animal</label>
    <input type="text" name="animal" class="awesomplete" list="animales" data-minchars="1"> 
    <datalist id="animales">
        <?php
        while($fila=$animales->fetch()){
            echo "<option value='$fila[numero]-$fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
        }
        ?>
    </datalist>
        </div>
        <div class="columns small-6">
            <label for="">peso</label>
    <input type="text" name="peso">
        </div>
    </div>
    <div class="row">
        <div class="columns small-6"><label for="">hora</label>
    <select name="hora">
        <option value="">seleccione</option>
        <option value="manana">manana</option>
        <option value="medio dia">medio dia</option>
        <option value="tarde">tarde</option>
    </select></div>
        <div class="columns small-6"></div>
    </div>
    <div class="row">
        <div class="small-12 columns">
               <button value="adicionar" id="adicionar">adicionar</button>
                <table  style="width: 100%" id="pesos">
        <thead>
            <tr>           
                <th>hora</th>
                <th>numero</th>
                <th>nombre</th>
                <th>peso</th>
                <th>eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
                                                while($fila=$pesoleche_lns->fetch()){
                                                    
                                                 echo "<tr>";
                                                 echo "<td>";
                                                 echo $fila[hora];
                                                 echo "</td>";
                                                 echo "<td>";
                                                 echo $fila[numero];
                                                 echo "</td>";
                                                 echo "<td>";
                                                 echo $fila[nombre];
                                                 echo "</td>";                                                 
                                                 echo "<td>";
                                                 echo $fila[peso];
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
        <div class="small-12 columns">notas
        <textarea name="notas" id="" cols="30" rows="10"><?php echo $pesoleche_enc[notas]?></textarea>
        <input type="hidden" value="<?php echo $pesoleche_enc[id]?>" name="id_enc">
        <input type="button" value="actualizar registro" class="button primary" id="envia">
        </div>
    </div>
    
</form>

</div>
</div>
<script>

                  $("[name=fecha]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy"});
                        
        var animaleslist=Array();
        $("#animales option").each(function(index,elem){
                    animaleslist.push(elem.innerHTML);
                        });
                        
                        var pesosleches=Array()//alamacena el animal y la hora
                        var animal;
                        var animal_no;
                          var peso;
                          var hora;
        $("#adicionar").on('click',function(e){
                                e.preventDefault();                                             
                                 animal=$("[name=animal]").val().trim().split('-')[1];
                                 animal_no=$("[name=animal]").val().trim().split('-')[0];
                                 peso=$("[name=peso]").val();
                                hora=$("[name=hora]").val();
                                
                    if(peso=='' || animal==''){
                                        $(this).notify("animal o peso vacio",{className: 'info',autoHideDelay: 1500});
                                        return;
                    }
                    
                    if(hora==''){
                         $(this).notify("seleccione una hora",{className: 'info',autoHideDelay: 1500});
                          return;
                    }
                    
                    if(animaleslist.indexOf($("[name=animal]").val())=== -1){ 
                            $(this).notify("elemento no coincidente",{className: 'info',autoHideDelay: 1500});
                            return;
                        }
                        
                    if(pesosleches.indexOf(hora+'-'+animal_no+'-'+animal)!== -1){
                            $(this).notify("elemento repetido",{className: 'info',autoHideDelay: 1500});
                            return;
                    }
          
          $("tbody:first").append('<tr><td>'+hora+'</td><td>'+animal_no+'</td><td>'+animal+'</td><td>'+peso+'</td><td><a href="#" class="quitar">eliminar</a></td></tr>');
                        pesosleches.push(hora+'-'+animal_no+'-'+animal);
                        

                });
                //////////////////////////////////////////////////////////////////////////////////////
                    $("table").on('click','a.quitar',function(e){
                    e.preventDefault();
                      var valor=$(this).parents('tr').find('td:nth-child(1)').html()+'-';
                                valor+=$(this).parents('tr').find('td:nth-child(2)').html()+'-';
                                valor+=$(this).parents('tr').find('td:nth-child(3)').html();
                          
                        pesosleches=_.without(pesosleches,valor);                        
                        
                    $(this).parents("tr").remove();

                });
                ///////////////////////////////////////////////////////////////////////////////////////////
                                $("#envia").on('click',function(e){                    
                    e.preventDefault();                    
                    var datoscadena='';
                    var notas=$('[name=notas]').val();
                    var empleado=$('[name=empleado]').val();
                    var fecha=$('[name=fecha]').val();
                    var id_enc=$('[name=id_enc]').val();
                    $("#pesos tr td").each(function(index,element){
                        var element=$(element);
                        if($(element.html()).is("a")){
                            datoscadena+='|';
                        }else{
                        datoscadena+=element.html()+',';                        
                            }                        
                                                        });
                                                        
                             $.ajax({
                                 url:'Uplecheajax.php',
                                 data:{pesos:datoscadena,notas:notas,empleado:empleado,fecha:fecha,id_enc:id_enc},
                                 method:'get',
                                 success: function (datos) {
                                      $("span#mensaje").html(datos);
                                    $(".alert-box").fadeOut(2500);
                                    
                                            }
                                 
                             });
                             
                    });                

    </script>