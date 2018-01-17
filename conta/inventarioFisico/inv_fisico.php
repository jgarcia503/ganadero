<?php 
include '../../plantilla.php';
$res=$conex->query('select * from bodega');
$htmlsel="<option value=''>seleccione</option>";
while($fila=$res->fetch()){
  $htmlsel.="<option value='$fila[codigo]'>$fila[nombre]</option>";
}
?>
<div class="small-12 columns"> 
    <h2>inventario fisico</h2>
    <div class="row">
        <div class="small-2 columns">

            <form action=""  >
                <label>fecha
                    <input type="text" name="fecha">
                </label>
                <label>bodega
                    <select name="bodega">
                        <?php echo $htmlsel ?>
                    </select>   
                </label>
                <input type="submit" value="crear" class="button primary" name="envia">
            </form>
        </div>
        <div class="small-10 columns">
            tabs
        </div>
    </div>
</div>
<script>
    $('[name=fecha]').datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
      changeYear: true});
  
    $('[name=bodega]').on('change',function(){
      bod=$(this).val();
    });
    
    $('[name=envia]').on('click',function(e){
        e.preventDefault();
        bod=$('[name=bodega]').val();
        fecha=$('[name=fecha]').val();
        $.ajax({
            url:'ajax/crea_inv_fisico_enc.php',
            data:{bod:bod,fecha:fecha},
            
        });
        
    });
</script>