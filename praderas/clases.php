<?php   include '../plantilla.php'; ?>

<div class="small-10 columns">
<h2>admon clases</h2>

<a href="Cclase.php" class="button primary">crear clase</a>


<?php
$res=$conex->query("select * from clases ");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>clase</th>
						
                        <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[potrero]?></td>
                <td><?php  echo $fila[empleado]?></td>                
                <td><a href="#" class="muestra" data-id="<?php echo $fila[id]?>">muestras</a></td>
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="Uaforos.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Daforos.php?<?php  echo  base64_encode('aforo='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
            
    <?php
}
?>	

	</tbody>
</table>
</div>




</div>
<div id="mimodal" class="reveal-modal"  data-reveal >
    <span></span>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>


<script>

    $(".table").footable();
            
                    $("a.ver").on('click',function(e) {
                                e.preventDefault();

                                $.ajax({
                                    url: "Raforos.php?" + $(this).data('id'),
                                    success: function (datos) {

                                        $('#mimodal span').html(datos);
                                    }
                                });



                                $('#mimodal').foundation('reveal', 'open');

                            });
        
            ///////////////ver muestras
    $('.muestra').on('click',function(e){
                        e.preventDefault();
                        var aforo=$(this).data('id');                               
                        $.ajax({
                            url:"listaMuestrasAforos.php",
                            method:'get',
                            data:{aforo:aforo},
                            success: function (data) {                                
                                                $('#mimodal span').html(data);
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


</script>