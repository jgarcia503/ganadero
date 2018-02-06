<?php   include '../plantilla.php'; ?>

 <div class="small-12 columns">
<h2>admon servicios</h2>

<!--<a href="Cservicios.php" class="button primary">crear servicios</a>-->


<?php
echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Cservicios.php','crear servicios');
$res=$conex->query("select * from servicios  order by fecha desc");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>fecha</th>
			<th>hora</th>
			<th>tipo</th>
			<th>animal</th>
			<th>padre</th>
                                                                  <th>inseminador</th>
			<th>donadora</th>			
                                                                  <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[hora]?></td>
                <td><?php  echo $fila[tipo]?></td>
                <td><?php  echo $fila[animal]?></td>                
                <td><?php  echo $fila[padre]?></td>
                <td><?php  echo $fila[inseminador]?></td>
                <td><?php  echo $fila[donadora]?></td>
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="Uservicio.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Dservicio.php?<?php  echo  base64_encode('servicio='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
            url:"Rservicios.php?"+$(this).data('id'),
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