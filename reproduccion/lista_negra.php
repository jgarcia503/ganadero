<?php   include '../plantilla.php'; ?>

 <div class="small-12 columns">
<h2>admon lista incompatible</h2>

<a href="Clista_negra.php" class="button primary">crear lista incompatible</a>


<?php
$res=$conex->query("select * from lista_negra");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>animal</th>
			<th>incompatibles</th>		
                                                                  <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[animal]?></td>
                <td><?php  echo substr($fila[animales_incompatibles],0,10).'...' ?></td>

                <td>
                    <a href="#" class="ver" data-id="<?php  echo  $fila[animal] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <!--<a href="Uservicio.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->                    
                    <!--<a href="Dservicio.php?<?php  echo  base64_encode('servicio='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
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
            url:"ajax/lista_negra.php?id="+$(this).data('id'),
            success:function (datos){
            
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