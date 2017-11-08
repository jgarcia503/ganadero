<?php   include '../plantilla.php'; 
$vegetaciones=$conex->query("select * from vegetaciones");
$potreros=$conex->query("select * from potreros");
$contactos=$conex->query("select nombre from contactos where tipo='empleado'");
?>

<div class="small-10 columns">
    <span id="mensaje">
    
    </span>


<form action="" method="post" data-abide>
       <h2>crear aforo</h2>
       <a href="javascript:history.back(1)" class="regresar">regresar</a>
    <div class="row">
        <div class="small-6 columns">
                <label for="">fecha</label>
                <input type="text" name="fecha" required="">
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
                 <option value="">seleccione</option>
                         <?php
        while($fila=$potreros->fetch()){
            echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
        }
        ?>
             </select>
        </div>
        <div class="small-6 columns">
              <label for="">empleado</label>
              <select name="empleado">
            <?php
                    while($fila=$contactos->fetch()){
                                                echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                                    }
                                ?>
              </select>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
<!--            <label for="">vegetacion</label>
            <select name="vegetacion">
                <option value="">seleccione</option>
                        <?php
//        while($fila=$vegetaciones->fetch()){
//            echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
//        }
        ?>
            </select>-->
<label for="">vegetacion</label>
     <input type="text" name="vegetaciones" class="awesomplete" list="vegetaciones" data-minchars="1" data-autofirst> 
            <datalist id="vegetaciones">
                        <?php
        while($fila=$vegetaciones->fetch()){
            echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
        }
        ?>             
            </datalist>
        </div>
        <div class="small-6 columns"></div>
    </div>

    <div class="row">
        <div class="small-12 columns">
            <button value="adicionar muestra" id="adicionar">adicionar muestra</button>
            <table   id="vegetaciones" style="width: 100%">
        <thead>
        <th>nombre</th>
        <th>peso</th>
        <th>editar</th>
        </thead>
        <tbody>
            
        </tbody>
    </table>
            
        </div>
    </div>
   
    <div class="row">
        <div class="small-12 columns">
             <label for="">notas</label>
    <textarea name="notas" id="" cols="30" rows="10"></textarea>
    <input type="button" value="crear" class="button primary" id="envia">
        </div>
    </div>

</form>

</div>
</div>
<script>
    
        var vegetacionaforo=Array();
        var vegetacioneslist=Array();
                $("#vegetaciones option").each(function(index,elem){
                    vegetacioneslist.push(elem.innerHTML);
                        });
                        
                  $("[name=fecha]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy"});
                  $("[name=fecha]").datepicker(  "setDate", new Date());               
             
                        
        $("#adicionar").on('click',function(e){
          e.preventDefault();
            var vegetacion=$("[name=vegetaciones]").val().trim();
      
          var peso=$("[name=peso]").val().trim();          
          
          if(vegetacion==='' || peso===''){
              $(this).notify("vegetacion o peso vacios",{className: 'info',autoHideDelay: 1500});
              return;
          }
         
             if(vegetacioneslist.indexOf(vegetacion)=== -1){ 
                  $(this).notify("elemento no coincidente",{className: 'info',autoHideDelay: 1500});
                    return;
                }
         
          if(vegetacionaforo.indexOf(vegetacion)!== -1){
              $(this).notify("vegetacion ya esta en aforo",{className: 'info',autoHideDelay: 1500});
              return;
          }
          
          $("tbody:first").append('<tr><td>'+vegetacion+'</td><td>'+peso+'</td><td><a href="#" class="quitar">eliminar</a></td></tr>');
          vegetacionaforo.push(vegetacion);
          $("[name=vegetaciones],[name=peso]").val("");
                });
                //////////////////////////////////////////////////////////////////////////////////////
                     $("table").on('click','a.quitar',function(e){
                    e.preventDefault();                    
                       var valor=$(this).parents('tr').find('td:first').html();
                        vegetacionaforo=_.without(vegetacionaforo,valor);
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
                    if($("#vegetaciones tr td").length>0){
                        if($("[name=potrero]").val()!==''){
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
                                                                             url:'Caforoajax.php',
                                                                             data:{vegetaciones:datoscadena,notas:notas,empleado:empleado,potrero:potrero,fecha:fecha},
                                                                             method:'get',
                                                                             success: function (datos) {
                                                                                  $("span#mensaje").html(datos);
                                                                                $(".alert-box").fadeOut(2500);
                                                                                $("input").not('[type=button]').val("");
                                                                                $("#vegetaciones tbody tr").remove();
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