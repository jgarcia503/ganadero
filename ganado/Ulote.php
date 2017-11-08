<?php   include '../plantilla.php';
$animales=$conex->query("select * from animales");
$id=base64_decode($_SERVER[QUERY_STRING]);
$lotes=$conex->query("select * from lotes where id=$id")->fetch();
?>

<span>

</span>

<div class="small-10 columns">
<h2>actualiza lote</h2>
<form action="" method="post" id="datos">
    <label for="">nombre</label>
    <input type="text" name="lote" value="<?php echo $lotes[nombre]?>">
    <label for="">animal</label>
    <input type="text" name="animal" class="awesomplete" list="animales" data-minchars="1"> 
    <datalist id="animales">
        <?php
        while($fila=$animales->fetch()){
            echo "<option value='$fila[numero]-$fila[nombre]'>$fila[numero]-$fila[nombre]</option>";
        }
        ?>
    </datalist>
    <table border='1' style="width: 100%">
        <thead>
        <tr>
                <th>numero</th>
                <th>nombre</th>
                <th>editar</th>
                
         </tr>
        </thead>
        <tbody>
            <?php
                                                
                                                $sqlnomanimales="select nombre,numero from animales where numero in (select regexp_split_to_table(rtrim(animales,','),',') animales from lotes where nombre='$lotes[nombre]')";
                                                $resnomanimales=$conex->query($sqlnomanimales);
                                             while($fila1=$resnomanimales->fetch()){
                                                 echo "<tr>";
                                                 echo "<td>";
                                                 echo $fila1[numero];
                                                 echo "</td>";
                                                 echo "<td>";
                                                 echo $fila1[nombre];
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
    <textarea name="notas" id="" cols="30" rows="10">
        <?php echo $lotes[notas]?>
    </textarea>
    <input type="hidden" value="<?php echo $id ?>" name="lote_id">
    <input type="button" value="envia" id="envia" class="button primary">
        </form>

</div>
</div>
<script>
        $("[name=animal]").on('keypress',function(e){
            var valor=$(this).val();
            if(valor !==' '){
            if(e.which==13){
                var numero=$(this).val().split('-')[0];
            var nombre=$(this).val().split('-')[1];
            $("tbody:first").append('<tr><td>'+numero+'</td><td>'+nombre+'</td><td><a href="#" class="quitar">eliminar</a></td></tr>');
           $(this).val("");
           //$(this).focus();
                }
            }
        });
        
        $("table").on('click','a.quitar',function(e){
            e.preventDefault();
   $(this).parents("tr").remove();

        });
        
        $("#envia").on('click',function(e){
            var datos=$("tr td:first-child");
            var animales='';
            var lote=$("[name=lote]").val();
            var notas=$("[name=notas]").val();
            $.each(datos,function(index,element){
                animales+=$(element).html()+",";
            });
             
             var id=$("[name=lote_id]").val();
            
                        $.ajax({
                            url:'Uloteajax.php',
                            method:'post',
                            data:{lote:lote,notas:notas,animales:animales,id:id},
                            success:function(datos){
                                
                                    $("span").html(datos);
                                    $(".alert-box").fadeOut(2500);

                                }
                        });
        });

</script>
