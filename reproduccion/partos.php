<?php    include '../plantilla.php'; ?>

 <div class="small-12 columns">
<h2>admon partos</h2>

<a href="Cpartos.php" class="button primary">crear partos</a>


<?php
$res=$conex->query("select * from partos  order by fecha desc");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>fecha</th>
			<th>hora</th>
			<th>animal</th>
			<th>cria</th>
			<th>empleado</th>			
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
                <td><?php  echo $fila[cria]?></td>
                <td><?php  echo $fila[contacto]?></td>
                
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <!--<a href="Upartos.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->                    
                    <a href="Dpartos.php?<?php  echo  base64_encode('parto='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
            url:"Rpartos.php?"+$(this).data('id'),
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