<?php   include '../plantilla.php'; ?>
<div class="small-12 columns">
<h2>admon contactos</h2>

<!--<a href="Ccontactos.php" class="button primary">crear contacto</a>-->


<?php
echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Ccontactos.php','crear contacto');
$res=$conex->query("select * from contactos");
?>

<table class="table" data-filtering='true' data-paging="true" >
	<thead>
		<tr>
			<th>identificacion</th>			
			<th>nombre</th>			
			<th>telefono</th>			
			<th>correo</th>			
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){

    ?>
            <tr>
                <td><?php  echo $fila[identificacion]?></td>
                <td><?php  echo $fila[nombre]?></td>
                <td><?php  echo $fila[telefono]?></td>
                <td><?php  echo $fila[correo]?></td>
                
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <?php echo check_permiso_for_update($_SESSION[permisos][$_SERVER[REQUEST_URI]], 'Ucontacto.php', base64_encode($fila[id])) ?>
                    <!--<a href="Ucontacto.php?<?php  echo  base64_encode($fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->                    
                    <a href="Dcontacto.php?<?php  echo  base64_encode('color='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                                url: "Rcontacto.php?" + $(this).data('id'),
                                success: function (datos) {
                                    console.log(datos);
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