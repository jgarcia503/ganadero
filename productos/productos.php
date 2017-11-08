<?php   include '../plantilla.php'; 
$bod_sql="select * from bodega";
$res_bod=$conex->query($bod_sql);
?>

 <div class="small-10 columns">
<h2>admon producto</h2>

<a href="Cproducto.php" class="button primary">crear producto</a>


<?php
$res=$conex->query("select * from productos");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>referencia</th>		
			<th>nombre</th>			
                                                                 <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
        
    ?>
            <tr>
                <td><?php  echo $fila[referencia]?></td>
             
                <td><?php  echo $fila[nombre]?></td>
                     
                <td>
                     <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
<!--                    <a href="Uproducto.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    -->
                    <!--<a href="Dproducto.php?<?php  echo  base64_encode('mortalidad='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
                    <a href="#" class="detalle" data-id='<?php  echo $fila[referencia] ?>' ><i class="fa fa-list" aria-hidden="true"></i></a>
                    <a href="#" class="mov"><i class="fa fa-address-card-o" aria-hidden="true"></i></a>
                </td>
            </tr>
            
    <?php
}
?>	

	</tbody>
</table>
<div id="mimodal" class="reveal-modal"  data-reveal >
    
    <span id="filtrado">
      <div class="row">
        <div class="small-2 columns">
            <label>bodega</label>
            <select name="bodega">
            <option value="" >seleccione</option>

            <?php
                        while($fila_bod=$res_bod->fetch()){
                            echo "<option value='$fila_bod[codigo]'>$fila_bod[nombre]</option>";
                        }
                ?>
        </select>
        </div>
        <div class="small-2 column">
            <label>desde</label>
            <input type="text" name="desde">            
        </div>
        <div class="small-2 column">
            <label>hasta</label>
            <input type="text" name="hasta">
        </div>
        <div class="small-2 column end">
            <button id="filtrar">filtrar</button>
        </div>
    </div>
    </span>
    <span id="datos"></span>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

</div>
</div>
<script>

    $(".table").on('click','a.ver',function(e){
        e.preventDefault();
        $("#filtrado").hide();
        $.ajax({
            url:"Rproducto.php?"+$(this).data('id'),
            success:function (datos){
                
                   $('#mimodal #datos').html(datos);
            }
        });

     
        $('#mimodal').foundation('reveal', 'open');

    });

///////////////ver existencias bodegas
    $(".table").on('click','a.detalle',function(e){
        e.preventDefault();
        $("#filtrado").hide();
        $.ajax({
            url:"ajax/ver_existencias_bodega.php?"+$(this).data('id'),
            success:function (datos){
                
                   $('#mimodal #datos').html(datos);
            }
        });

     
        $('#mimodal').foundation('reveal', 'open');

    });

///////////////ver movimientos

    $(".table").on('click','a.mov',function(e){
  
        e.preventDefault();
        prod_id=$(this).siblings('.detalle').data('id');

        $("#filtrado").show();
         $('#mimodal #datos').html('');



     
        $('#mimodal').foundation('reveal', 'open');

    });

         $("#filtrar").on('click',filtrar);
         
         function filtrar(){
             desde=$("[name=desde]").val();
             hasta=$("[name=hasta]").val();
             bodega=$("[name=bodega]").val();
             if(bodega===''){
                 bodega='todas';
             }
            
             if (desde!=='' && hasta!==''){
                             $.ajax({
                                                url:"ajax/ver_movimientos.php",
                                                data:{desde:desde,hasta:hasta,bodega:bodega,prod_id:prod_id},
                                                success:function (datos){

                                                    $('#mimodal #datos').html(datos);
                                                    
                                        }
                           });
        
             }else{
                 alert('campos invalidos');
             }
         }
    ////////////////////eliminar
    
    
        $("a#eliminar").on('click',function(e){
        
        e.preventDefault();
       if( confirm("desea eliminar?")){
           window.location=$(this).attr('href');
       }
    });

$(".table").footable();
      $("[name=desde],[name=hasta]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy",changeYear: true,changeMonth:true});
    
</script>