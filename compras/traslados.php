<?php  
include '../plantilla.php';
$res=$conex->query("select a.*,b.nombre origen,c.nombre destino 
from traslados_enc a 
inner join bodega b
on b.codigo=a.bodega_origen::integer
inner join bodega c 
on c.codigo=a.bodega_destino::integer
order by fecha desc");

?>

<div class="small-10 columns">
    <h2>administracion traslados</h2>
    <a href="Ctraslado.php" class="button primary">crear traslado</a>
    
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
    
    