<?php   include '../plantilla.php'; 
$animales=$conex->query("select * from animales");
$contactos=$conex->query("select nombre from contactos where tipo='empleado'");

if($_POST){
$sql="insert into pesos_leches values(default,'$_POST[empleado]','$_POST[fecha]','$_POST[animal]','$_POST[peso]','$_POST[hora]','$_POST[notas]')";
$insert=$conex->prepare($sql);
if($insert->execute()){
    $mensaje=  '<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
}
else{
    $mensaje=  '<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
    }
}
?>

  <div class="small-10 columns">  
    <div class="row">
        <div class="small-12 columnns">
            <span id="mensaje">  <?php  echo $mensaje ?>      </span>
        </div>
    </div>
    

      <form action="" method="post" data-abide>
       <h2>crear peso leche</h2>
       <a href="pleche.php" class="regresar">regresar</a>
    <div class="row">
        <div class="columns small-6">
            <label for="">empleado</label>
            <select name="empleado">
                <option value="">seleccione</option>
                  <?php
                    while($fila=$contactos->fetch()){
                          echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                    }
                                ?>
            </select>
        </div>
        <div class="columns small-6">
            <label for="">fecha</label>
            <input type="text" name="fecha" required="">
        </div>
    </div>
    <div class="row">
        <div class="columns small-6">
            <label for="">animal</label>            
            <select  name="animal" required="">
                <option value="">seleccione</option>
        <?php
        while($fila=$animales->fetch()){
            echo "<option value='$fila[numero]-$fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
        }
        ?>
    </select>
        </div>
        <div class="columns small-6">
            <label for="">botellas</label>
             <input type="text" name="peso" required="">
                     
        </div>
        
    </div>

       <div class="row">
           <div class="small-6 columns">
                        <label for="">hora</label>
            <select name="hora" required="">
        <option value="">seleccione</option>
        <option value="manana">manana</option>
        <option value="medio dia">medio dia</option>
        <option value="tarde">tarde</option>
        <option value="dia">dia</option>
    </select>
           </div>
       </div>
    
    <div class="row">
        <div class="small-12 columns">
            <label>notas</label>
    <textarea name="notas" id="" cols="30" rows="10"></textarea>
    <button type="submit" value="crear registro">crear</button>
        </div>
    </div>
    
</form>


</div>
</div>

<script>
  $("[name=fecha]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy"});
</script>
<!--<script>
                       $("[name=fecha]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy"});
                  
                  $("[name=peso]").on('keypress',function(){
                      var ltrs;
     
            ltrs=parseFloat($(this).val())/1.32;
        if(isNaN(ltrs)){
            alert('ingrese un numero');
            return;
        }
        
                      $("#conversiones").html(ltrs+' litros');
                      
                  });
                  
                  
                        ////////////////////////////////////////////////////////////////////////////
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
                    
                    if(fecha==''){
                        alert("seleccione fecha");
                        return;
                    }
                    if($("#pesos tr td").length==0){
                        alert("no puede estar vacia la tabla");
                        return;
                    }
                    
                    $("#pesos tr td").each(function(index,element){
                        var element=$(element);
                        if($(element.html()).is("a")){
                            datoscadena+='|';
                        }else{
                        datoscadena+=element.html()+',';                        
                            }                        
                                                        });
                                                        
                             $.ajax({
                                 url:'Cplecheajax.php',
                                 data:{pesos:datoscadena,notas:notas,empleado:empleado,fecha:fecha},
                                 method:'get',
                                 success: function (datos) {
                                    $("span#mensaje").html(datos);
                                    $(".alert-box").fadeOut(2500);
                                    $("[name=fecha],[name=animal],[name=peso],textarea").val("");
                                    $("#pesos tbody tr").remove();
                                            }
                                 
                             });
                             
                    });                

    </script>-->