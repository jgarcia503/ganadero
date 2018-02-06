<?php   include '../plantilla.php'; ?>



 <div class="small-12 columns">
<h2>admon grupos</h2>

<!--<a href="Cgrupo.php" class="button primary">crear grupo</a>-->


<?php
echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Cgrupo.php','crear grupo');
$res=$conex->query("select * from grupos");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>nombre</th>			
			<th>produccion minima</th>			
			<th>dias de nacida</th>			
                                                                  <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[nombre]?></td>
                <td><?php  echo $fila[produccion_minima]?></td>
                <td><?php  echo $fila[dias_nac]?></td>
                
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="#" class="animal" data-id="<?php  echo  $fila[id] ?>"><i class="fa fa-500px" aria-hidden="true"></i></a>
                    
                    <a href="Ugrupo.php?<?php  echo  $fila[id]?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <!--<a href="Dcolor.php?<?php  echo  base64_encode('color='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
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

    
    
                $(".table").on('click','a.ver',function(e) {
                            e.preventDefault();

                            $.ajax({
                                url: "ajax/ver_grupo.php?" + $(this).data('id'),
                                success: function (datos) {
                                    
                                    $('#mimodal span').html(datos);
                                }
                            });


                            $('#mimodal').foundation('reveal', 'open');

                        });
    ///////////////////////////////////////////////
                    $(".table").on('click','a.animal',function(e) {
                            e.preventDefault();

                            $.ajax({
                                url: "ajax/animales_grupo.php?" + $(this).data('id'),
                                success: function (datos) {
                                    
                                    $('#mimodal span').html(datos);
                                }
                            });


                            $('#mimodal').foundation('reveal', 'open');

                        });
    
    ///////////eliminart///////////////////
        $("a#eliminar").on('click',function(e){
        
        e.preventDefault();
       if( confirm("desea eliminar?")){
           window.location=$(this).attr('href');
       }
    });

    $(".table").footable();
</script>