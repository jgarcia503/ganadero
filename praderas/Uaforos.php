<?php   include '../plantilla.php'; 
$vegetaciones=$conex->query("select * from vegetaciones");
$potreros=$conex->query("select * from potrero");

$id=base64_decode($_SERVER[QUERY_STRING]);
$aforo=$conex->query("select * from aforos where id=$id")->fetch();
?>

<div class="small-10 columns">
    <span id="mensaje">
    
    </span>

<form action="" method="post">
    
    <div class="row">
        <div class="small-6 columns">
                <label for="">fecha</label>
                <input type="text" name="fecha" value="<?php echo $aforo[fecha]?>">
        </div>
        <div class="small-6 columns">
             <label for="">peso</label>
    <input type="text" name="peso">
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
             <label for="">potrero</label>
             <select name="potrero" >
                 <option value="seleccione">seleccione</option>
                         <?php
        while($fila=$potreros->fetch()){
            echo "<option value='$fila[nombre]'";
            echo $fila[nombre]==$aforo[potrero]?'selected':'';
            echo ">$fila[nombre]</option>";
        }
        ?>
             </select>
        </div>
        <div class="small-6 columns">
              <label for="">empleado</label>
              <select name="empleado">
                  <option value="yo">yo</option>
              </select>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <label for="">vegetacion</label>
            <select name="vegetacion">
                <option value="seleccione">seleccione</option>
                        <?php
        while($fila=$vegetaciones->fetch()){
            echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
        }
        ?>
            </select>
        </div>
        <div class="small-6 columns"></div>
    </div>

    <div class="row">
        <div class="small-12 columns">
            <button value="adicionar muestra" id="adicionar">adicionar muestra</button>
            <table border="1" style="width: 100%" id="vegetaciones">
        <thead>
        <th>nombre</th>
        <th>peso</th>
        <th>editar</th>
        </thead>
        <tbody>
            <?php
                                                        $sqlveges=$conex->query("select  regexp_split_to_table(rtrim(vegetacion,','),',') veg , regexp_split_to_table(rtrim(peso,','),',') pesos  from aforos where id=$id");
                                                        while($fila=$sqlveges->fetch()){                                                            
                                                  echo "<tr>";
                                                 echo "<td>";
                                                 echo $fila[veg];
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
            
        </div>
    </div>
   
    <div class="row">
        <div class="small-12 columns">
             <label for="">notas</label>
    <textarea name="notas" id="" cols="30" rows="10"></textarea>
    <input type="hidden" value="<?php echo $id?>" name="aforo_id">
    <input type="button" value="actualizar registro" class="button primary" id="envia">
        </div>
    </div>

</form>

</div>
</div>
<script>
    
                  $("[name=fecha]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});
                  
           $("#adicionar").on('click',function(e){
                        e.preventDefault();
                        var vegetacion=$("[name=vegetacion]").val().trim();
                        var peso=$("[name=peso]").val().trim();          
                        $("tbody:first").append('<tr><td>'+vegetacion+'</td><td>'+peso+'</td><td><a href="#" class="quitar">eliminar</a></td></tr>');
          
                });
                //////////////////////////////////////////////////////////////////////////////////////
               $("table").on('click','a.quitar',function(e){
                    e.preventDefault();
                    $(this).parents("tr").remove();

                });
                ///////////////////////////////////////////////////////////////////////////////////////////
                                $("#envia").on('click',function(e){                    
                    e.preventDefault();                    
                    var datoscadena='';
                    var notas=$('[name=notas]').val();
                    var potrero=$("[name=potrero]").val();
                    var fecha=$("[name=fecha]").val();
                    var empleado=$('[name=empleado]').val();
                    var aforo_id=$("[name=aforo_id]").val();
                    $("#vegetaciones tr td").each(function(index,element){
                                                                var element=$(element);
                                                                if($(element.html()).is("a")){
                                                                    datoscadena+=',';
                                                                }else{
                                                                datoscadena+=element.html()+'=';                        
                                                                    }                        
                                                  });
                                                        datoscadena=datoscadena.replace(/=,/g,',');
                                                        
                             $.ajax({
                                 url:'Uaforoajax.php',
                                 data:{vegetaciones:datoscadena,notas:notas,empleado:empleado,potrero:potrero,fecha:fecha,aforo_id:aforo_id},
                                 method:'get',
                                 success: function (datos) {
                                    $("span#mensaje").html(datos);
                                    $(".alert-box").fadeOut(2500);

                                            }
                                 
                             });
                                                                                         //console.log(datoscadena);
                    });

    </script>