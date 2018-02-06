<?php   include '../plantilla.php'; ?>

 <div class="small-12 columns">
<h2>admon peso leche</h2>

<!--<a href="Cpleche.php" class="button primary">crear peso leche</a>-->


<?php
echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Cpleche.php','crear peso leche');
$res=$conex->query("select * from pesos_leches order by fecha desc");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>fecha</th>
			<th>animal</th>                        
			<th>botellas</th>                        
			<th>hora</th>                        
                        <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
        
    ?>
            <tr>
                <td><?php  echo $fila[fecha]?></td>                
                <td><?php  echo $fila[animal]?></td>                
                <td><?php  echo $fila[peso]?></td>                
                <td><?php  echo $fila[hora]?></td>                
                <!--<td><a href="#" class="animales" data-id="<?php echo $fila[id]?>">pesos</a></td>-->                
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <!--<a href="Upleche.php?<?php  echo  base64_encode($fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->                    
                    <a href="Dpleche.php?<?php  echo  base64_encode($fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
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

    
                            $(".table").on('click','a.ver',function(e) {
                                e.preventDefault();

                                $.ajax({
                                    url: "Rpleche.php?" + $(this).data('id'),
                                    success: function (datos) {

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
    
            ///////////////ver animales
    $('table').on('click','.animales',function(e){
                        e.preventDefault();
                        var id=$(this).data('id');
                        $.ajax({
                            url:"listaLechePesajes.php",
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