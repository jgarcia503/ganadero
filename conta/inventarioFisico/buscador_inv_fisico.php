<?php  
include '../../plantilla.php';
$res=$conex->query("select * from inventario_fisico_enc");

?>

<div class="small-12 columns">
    <h2>administracion inventarios fisicos</h2>
    <!--<a href="Ctraslado.php" class="button primary">crear traslado</a>-->
    <?php  echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'inv_fisico.php','crear inventario fisico'); ?>
    <table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>fecha</th>
			<th>No Doc</th>						
			<th>bodega origen</th>		
			<th>bodega destino</th>		
			<th>costo total</th>		
			<th>notas</th>		
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
?>
            <tr>
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[id]?></td>                           
                <td><?php  echo $fila[origen]?></td>                
                <td><?php  echo $fila[destino]?></td>                
                <td><?php  echo $fila[costo_total]?></td>                
                <td><?php  echo $fila[notas]?></td>                
                <td>
                    <a href="#" class="ver" data-id="<?php  echo  $fila[id] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <?php 
                    if($fila[en_proceso]){
                            echo check_permiso_for_update($_SESSION[permisos][$_SERVER[REQUEST_URI]], 'Uinv_fisico.php', "id=$fila[id]"); 
                    }
                    ?>
<!--                    <a href="Umortalidad.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Dmortalidad.php?<?php  echo  base64_encode('mortalidad='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
                </td>
            </tr>
            
<?php
}
?>	

	</tbody>
        </table>
</div>
<div id="mimodal" class="reveal-modal"  data-reveal>
    <span></span>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
</div>
<script>

          $('.table').on('click','.ver',function(e){
                        e.preventDefault();
                        var id=$(this).data('id');                        
                        $.ajax({
                            url:"ajax/ver_detalle_traslado.php",
                            method:'get',
                            data:{id:id},
                            success: function (data) {                                
                                                $('#mimodal span').html(data);
                                            }
                        });
                           $('#mimodal').foundation('reveal', 'open');
    });
    
          $(".table").footable();
    </script>
    
    