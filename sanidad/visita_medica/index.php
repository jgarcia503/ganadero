<?php   include '../../plantilla.php'; ?>

<div class="row">
 <div class="small-12 columns">
<h2>visitas medicas</h2>

<!--<a href="Cvisita.php" class="button primary">registrar visita medica</a>-->


<?php
echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Cvisita.php','crear visita medica');
$res=$conex->query("select * from visita_medica");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>fecha</th>			
			<th>tipo</th>			
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[tipo_visita]?></td>
    
                <td>
                    <a href="#" class="ver" data-id="<?php  echo $fila[id] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <!--<a href="#" class="animales" data-id="<?php  echo  $fila[id]?>"><i class="fa fa-venus-double" aria-hidden="true"></i></a>-->
                    <!--<a href="Ueventosanitario.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->                    
                    <!--<a href="Deventosanitario.php?<?php  echo  base64_encode('eventosanitario='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
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

<?php
if(isset($_SESSION[error])){
    echo "<script>alert('$_SESSION[error]')</script>";
    unset($_SESSION[error]);
}
?>
</div>
</div>
<script>


                    $(".table").on('click','a.ver',function(e){
        e.preventDefault();
        
        $.ajax({
            url:"Rvisitas.php?id="+$(this).data('id'),
            success:function (datos){
                
                   $('#mimodal span').html(datos);
            }
        });


     
        $('#mimodal').foundation('reveal', 'open');

    });
        /////////////////////////////////ver animales con x evento sanitario
                            $(".table").on('click','a.animales',function(e){
        e.preventDefault();
        
        $.ajax({
            url:"ajax/animales_x_evento_sani.php?id="+$(this).data('id'),
            success:function (datos){
                
                   $('#mimodal span').html(datos);
                   $('#tabla_modal').footable();
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