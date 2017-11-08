<?php   include '../plantilla.php';
$animales=$conex->query("select * from animales");

?>

<span id="mensaje">

</span>

<div class="small-10 columns">
<h2>crear lote</h2>
<form action="" method="post" id="datos">
    
    <label for="">nombre</label>
    <input type="text" name="lote" >
    <label for="">animal</label>
    <input type="text" name="animal" class="awesomplete" list="animales" data-minchars="1" data-autofirst> 

   
    <datalist id="animales">
        <?php
        while($fila=$animales->fetch()){
            echo "<option value='$fila[numero]-$fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
        }
        ?>
    </datalist>
    <table style="width: 100%">
        <thead>
        <tr>
                <th>numero</th>
                <th>nombre</th>
                <th>editar</th>
                
         </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
    notas
    <textarea name="notas"  cols="30" rows="10"></textarea>
    <input type="button" value="envia" id="envia" class="button primary">
    
        </form>

</div>
</div>
<script>
    
        var animaleslist=Array();
        $("#animales option").each(function(index,elem){
    animaleslist.push(elem.innerHTML);
                        });
             var animaleslote=Array();

        $("[name=animal]").on('keypress',function(e){
            var valor=$(this).val();            
            if(e.which==13){
                if(valor!==''){
                    //si el valor no esta en la lista de los animales
                        if(animaleslist.indexOf(valor)=== -1){ 
                            $(this).notify("elemento no coincidente",{className: 'info',autoHideDelay: 1500});
                            return;
                        }
                        
                        //si el animal ya esta en el lote
                        if(animaleslote.indexOf(valor) !== -1){
                            $(this).notify("elemento repetido",{className: 'info',autoHideDelay: 1500});
                            return;
                        }
                    
                           var numero=$(this).val().split('-')[0];
                           var nombre=$(this).val().split('-')[1];
                           $("tbody:first").append('<tr><td>' + numero + '</td><td>' + nombre + '</td><td><a href="#" class="quitar">eliminar</a></td></tr>');                                                    
                           $(this).val("");
                           animaleslote.push(valor);
                                                                                            
                            }
                            else{
                                $(this).notify("elija un animal",{className: 'info',autoHideDelay: 1500});
                            }
                }
});
        ///quitar 
        $("table").on('click','a.quitar',function(e){
            e.preventDefault();
            var valor=$(this).parents('tr').find('td:first').html()+'-'+$(this).parents('tr').find('td:first').next().html();                        
            animaleslote=_.without(animaleslote,valor);
            $(this).parents("tr").remove();

        });
        ////envia
        $("#envia").on('click',function(e){
            var datos=$("tr td:first-child");
            var animales='';
            var lote=$("[name=lote]").val();
            var notas=$("[name=notas]").val();
          if(lote.length>0) {
                                    if(datos.length>0){
                                    $.each(datos,function(index,element){
                                        animales+=$(element).html()+",";
                                    });


                                                $.ajax({
                                                    url:'Cloteajax.php',
                                                    method:'post',
                                                    data:{lote:lote,notas:notas,animales:animales},
                                                    success:function(datos){                                
                                                            $("span#mensaje").html(datos);
                                                            $(".alert-box").fadeOut(2500);
                                                            $("tbody tr").remove();
                                                            $("[name=lote],textarea").val("");
                                                            animaleslote.splice(0,animaleslote.length);
                                                        }
                                                });
                                            }
                                            else{
                                                alert('no puede star vacia la tabla');

                                            }
                         }else{
                             alert('lote vacio');
                         }
        });//envia function

</script>
