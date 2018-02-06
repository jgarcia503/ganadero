<?php   include '../plantilla.php'; ?>

 <div class="small-12 columns">
<h2>admon suplementacion</h2>

<!--<a href="Csuplementacion.php" class="button primary">crear suplementacion</a>-->


<?php
echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Csuplementacion.php','crear suplementacion');
$res=$conex->query("select a.*,c.nombre grupo,b.nombre dieta from suplementaciones_enc a
join alimentacion_enc b on b.id::text=a.dieta_id
join grupos c on c.id::text=a.grupo_id");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>fecha</th>
			<th>grupo</th>
			<th>dieta</th>		
                        <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[grupo]?></td>
                <td><?php  echo $fila[dieta]?></td>
                
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
<!--                    <a href="Usuplementacion.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Dsuplementacion.php?<?php  echo  base64_encode('raza='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
                </td>
            </tr>
            
    <?php
}
?>	

	</tbody>
</table>


<div id="mimodal" class="reveal-modal"  data-reveal >
    <span></span>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
</div>
</div>
<script>
    $(".table").footable();
                $("a.ver").on('click',function(e){
                        e.preventDefault();

                        $.ajax({
                            url: "Rsuplementacion.php?" + $(this).data('id'),
                            success: function (datos) {
                                
                                $('#mimodal span').html(datos);
                            }
                        });

                        $('#mimodal').foundation('reveal', 'open');

                    });

</script>