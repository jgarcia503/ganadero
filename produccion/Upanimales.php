<?php   include '../plantilla.php';
$animales=$conex->query("select * from animales");

$id=base64_decode($_SERVER[QUERY_STRING]);
$pesos=$conex->query("select * from bit_peso_animal where id=$id")->fetch();
?>

  <div class="small-10 columns">
  <span id="mensaje">

</span>
<form action="">
    <div class="row">
        <div class="small-6 columns">
            <label for="">fecha</label>
            <input type="text" name="fecha" value="<?php echo $pesos[fecha]?>">
        </div>
        <div class="small-6 columns">
            <label for="">empleado</label>
            <select name="empleado" >
                <option value="yo">yo</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
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
        <div class="small-6 columns">
            <label for="">peso</label>
    <input type="text" name="peso">
        </div>
    </div>
    
    <div class="row">
        <div class="small-12 columns">
              <button value="adicionar" id="adicionar">adicionar</button>
    <table id="pesos" style="width: 100%">
        <thead>
            <tr>             
                <th>numero</th>
                <th>nombre</th>
                <th>peso</th>
                <th>eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
                                                   $sqlpesosanimales=$conex->query("select regexp_split_to_table(rtrim(numero,','),',') numero
                ,regexp_split_to_table(rtrim(nombre,','),',') nombre
                ,regexp_split_to_table(rtrim(peso,','),',') pesos
                from bit_peso_animal where id=$id");
                                                        while($fila=$sqlpesosanimales->fetch()){                                                            
                                                                    echo "<tr>";
                                                                   echo "<td>";
                                                                   echo $fila[numero];
                                                                   echo "</td>";
                                                                   echo "<td>";
                                                                   echo $fila[nombre];
                                                                   echo "</td>";
                                                                   echo "<td>";
                                                                   echo $fila[pesos];
                                                                   echo "</td>";
                                                                   echo "<td>";
                                                                   echo "<a href='#' class='quitar'>eliminar</a>";
                                                                   echo "</td>";
                                                                   echo "</tr>";          
                                                        }
                                    ?>
        </tbody>
    </table>
    notas
    <textarea name="notas" id="" cols="30" rows="10"><?php echo $pesos[notas]?></textarea>
    <input type="hidden" value="<?php echo $id ?>" name="id">
    <input type="button" value="actualizar registro" class="button primary" id="envia">
        </div>
    </div>

</form>

</div>
</div>
<script>
              var animaleslist=Array();
        $("#animales option").each(function(index,elem){
                    animaleslist.push(elem.innerHTML);
                        });
             var animalespeso=Array();
      $("[name=fecha]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy"});
      
      $("#adicionar").on('click',function(e){
          e.preventDefault();
                    
          var animal=$("[name=animal]").val().trim().split('-')[1];
          var animal_no=$("[name=animal]").val().trim().split('-')[0];
          var peso=$("[name=peso]").val();
          
                    if(peso=='' || animal==''){
                                        $(this).notify("animal o peso vacio",{className: 'info',autoHideDelay: 1500});
                                        return;
                    }
                   if(animaleslist.indexOf($("[name=animal]").val())=== -1){ 
                            $(this).notify("elemento no coincidente",{className: 'info',autoHideDelay: 1500});
                            return;
                        }
          
           if(animalespeso.indexOf(animal_no) !== -1){
                            $(this).notify("elemento repetido",{className: 'info',autoHideDelay: 1500});
                            return;
                        }
          
                        $("tbody:first").append('<tr><td>'+animal_no+'</td><td>'+animal+'</td><td>'+peso+'</td><td><a href="#" class="quitar">eliminar</a></td></tr>');
                        animalespeso.push(animal_no);
                        $("[name=peso],[name=animal]").val('');
                });
                
                /////////////////////////////////////////////////////////////////////
                    $("table").on('click','a.quitar',function(e){
                    e.preventDefault();
                      var valor=$(this).parents('tr').find('td:first').html();                    
                        animalespeso=_.without(animalespeso,valor);                        
                    $(this).parents("tr").remove();

                });
                /////////////////////////////////////////////////////////////////////
                $("#envia").on('click',function(e){                    
                    e.preventDefault();                    
                    var datoscadena='';
                    var notas=$('[name=notas]').val();
                    var fecha=$('[name=fecha]').val();
                    var empleado=$('[name=empleado]').val();
                    var id=$("[name=id]").val();
                    
                    if(fecha!='' &&  empleado!=''){
                        if( $("#pesos tr td").length>0){
                                                $("#pesos tr td").each(function(index,element){
                                                    var element=$(element);
                                                    if($(element.html()).is("a")){
                                                        datoscadena+=',';
                                                    }else{
                                                    datoscadena+=element.html()+'=';                        
                                                        }                        
                                                                                    });

                                                            $.ajax({
                                                                url:'Upanimalesajax.php',
                                                                data:{pesos:datoscadena,fecha:fecha,empleado:empleado,notas:notas,id:id},
                                                                method:'get',
                                                                success: function (datos) {
                                                                   $("span#mensaje").html(datos);
                                                                   $(".alert-box").fadeOut(2500);
                                                               
                                                                   animalespeso.splice(0,animalespeso.length);
                                                                           }

                                                            });
                                                        }    
                                                        else{
                                                            $.notify("no puede estar vacia la tabla",{className: 'info',autoHideDelay: 1500});
                                                        }
                                          }
                                          else{
                                              alert('seleccione fecha');
                                          }
                       //                                     console.log(datoscadena);
                    });

  </script>