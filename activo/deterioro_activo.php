<?php   include '../plantilla.php';
$res=$conex->query("select * from activo");
?>

<div class="small-12 columns">
    <h2>crear activo</h2>
    <!--<a href="Cdeterioro_activo.php" class="button primary">crear activo</a>-->
    <?php echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Cdeterioro_activo.php','crear activo'); ?>
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
                            url:"ajax/verActivo.php",
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
    
    