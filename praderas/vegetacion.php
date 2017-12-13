<?php   include '../plantilla.php'; ?>

 <div class="small-10 columns">
<h2>admon vegetacion</h2>

<a href="Cvegetacion.php" class="button primary">crear vegetacion</a>


<?php
$res=$conex->query("select a.id,a.nombre subtipo,b.nombre tipo,a.notas from vegetaciones a inner join tipo_vegetacion b on b.id::varchar=a.id_tipo_cultivo");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>tipo</th>
			<th>subtipo</th>
			<th>notas</th>
		
                        <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[tipo]?></td>
                <td><?php  echo $fila[subtipo]?></td>
                <td><?php  echo $fila[notas]?></td>
                
 
                <td>
                     <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
<!--                    <a href="Uvegetacion.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Dvegetacion.php?<?php  echo  base64_encode('vegetacion='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
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
</div><!-- incluir para cerra div de la plantilla-->
<script>

                                $(".table").on('click','a.ver',function(e) {
                                e.preventDefault();

                                $.ajax({
                                    url: "Rvegetacion.php?" + $(this).data('id'),
                                    success: function (datos) {
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