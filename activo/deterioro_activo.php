<?php   include '../plantilla.php';
$res=$conex->query("select * from deterioro_activo");
?>

<div class="small-10 columns">
    <h2>adquirir servicios</h2>
    <a href="Cdeterioro_activo.php" class="button primary">crear deterioro</a>
    
    <table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>descripcion</th>
			<th>costo deterioro por hora</th>						
				
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
?>
            <tr>
                <td><?php  echo $fila[descripcion]?></td>
                <td><?php  echo $fila[costo_deterioro_x_hora]?></td>                           
      
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
                            url:"ajax/ver_compra_servicio.php",
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
    
    