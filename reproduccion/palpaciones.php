<?php    include '../plantilla.php'; ?>


 <div class="small-12 columns">
<h2>admon palpaciones</h2>

<!--<a href="Cpalpaciones.php" class="button primary">crear palpaciones</a>-->


<?php
echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Cpalpaciones.php','crear palpacion');
$res=$conex->query("select *,prenada from palpaciones order by fecha desc");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>fecha</th>
			<th>hora</th>
			<th>animal</th>
			<th>resultado</th>
			<th>palpador</th>
			<th>dias preñez</th>
			<th>preñada</th>
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[hora]?></td>
                <td><?php  echo $fila[animal]?></td>
                <td><?php  echo $fila[resultado]?></td>
                <td><?php  echo $fila[palpador]?></td>
                <td><?php  echo $fila[dias_prenez]?></td>
                <td><?php  echo $fila[prenada]?></td>
                <td>
                      <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <!--<a href="Upalpaciones.php?<?php  echo  base64_encode($fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->                    
                    <a href="Dpalpaciones.php?<?php  echo  base64_encode('palpacion='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
            url:"Rpalpaciones.php?"+$(this).data('id'),
            success:function (datos){
                console.log(datos);
                   $('#mimodal span').html(datos);
            }
        });

     
        $('#mimodal').foundation('reveal', 'open');

    });
    
    //////////////////eliminar
        $("a#eliminar").on('click',function(e){
        
        e.preventDefault();
       if( confirm("desea eliminar?")){
           window.location=$(this).attr('href');
       }
    });

    $(".table").footable();
</script>