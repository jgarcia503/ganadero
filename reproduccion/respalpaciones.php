<?php    include '../plantilla.php'; ?>

 <div class="small-12 columns">
<h2>admon res. palpaciones</h2>

<!--<a href="Crespalpaciones.php" class="button primary">crear res .palpaciones</a>-->


<?php
echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Crespalpaciones.php','crear resultado palpacion');
$res=$conex->query("select * from resul_palpaciones");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>nombre</th>			
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[nombre]?></td>     
                <td>
                      <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                      <?php echo check_permiso_for_update($_SESSION[permisos][$_SERVER[REQUEST_URI]], 'Urespalpaciones.php', base64_encode($fila[id])) ?>
                    <!--<a href="Urespalpaciones.php?<?php  echo  base64_encode($fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->                    
                    <a href="Drespalpaciones.php?<?php  echo  base64_encode('palpacion='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
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


            
                        $(".table").on('click','a.ver',function(e){
        e.preventDefault();
        
        $.ajax({
            url:"Rrespalpaciones.php?"+$(this).data('id'),
            success:function (datos){
                console.log(datos);
                   $('#mimodal span').html(datos);
            }
        });

     
        $('#mimodal').foundation('reveal', 'open');

    });
          
    ////////////////////eliminar
        $("a#eliminar").on('click',function(e){
        
        e.preventDefault();
       if( confirm("desea eliminar?")){
           window.location=$(this).attr('href');
       }
    });

    $(".table").footable();

</script>