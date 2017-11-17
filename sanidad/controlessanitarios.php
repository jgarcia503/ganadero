<?php   include '../plantilla.php'; ?>


 <div class="small-10 columns">
<h2>admon controles sanitarios</h2>

<a href="Ccontrolsanitario.php" class="button primary">crear control sanitario</a>


<?php
$res=$conex->query("select distinct animal from controles_sanitarios ");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			
			<th>animal</th>			
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
               
                <td><?php  echo $fila[animal]?></td>
                
                <td>
                    <!--<a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>-->
                    <a href="#" class="history" data-animal="<?php  echo  $fila[animal] ?>"><i class="fa fa-history" aria-hidden="true"></i></a>
                    <!--<a href="Ucontrolsanitario.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->                    
                    <!--<a href="Dcontrolsanitario.php?<?php  echo  base64_encode('controlsanitario='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
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
            url:"Rcontrolessanitarios.php?"+$(this).data('id'),
            success:function (datos){
                
                   $('#mimodal span').html(datos);
            }
        });


        $('#mimodal').foundation('reveal', 'open');

    });
        
        $('.table').on('click','a.history',function(e){
            var animal=$(this).attr('data-animal');
            
            $.ajax({
                url:'ajax/ver_controles_sanitarios.php',
                data:{animal:animal},
                success:function(datos){
                    $('#mimodal span').html(datos);
                    $('#mimodal').foundation('reveal', 'open');
                }
            });
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