<?php   include '../plantilla.php'; ?>

<div class="small-12 columns">
 
<h2>admon dietas</h2>

<a href="Cdieta.php" class="button primary">crear dieta</a>


<?php
$res=$conex->query("select * from alimentacion_enc");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>fecha</th>
			<th>grupo</th>			
                                                                  <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[grupo]?></td>
                <!--<td><a href="#" class="prods" data-id="<?php echo $fila[id]?>">productos</a></td>-->        
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
<!--                    <a href="Udieta.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Ddieta.php?<?php  echo  base64_encode('raza='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
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
                            url: "Rdieta.php?" + $(this).data('id'),
                            success: function (datos) {
                                
                                $('#mimodal span').html(datos);
                            }
                        });


                        $('#mimodal').foundation('reveal', 'open');

                    });
                    
                        ///////////////ver productos
    $('.table').on('click','.prods',function(e){
                        e.preventDefault();
                        var dieta=$(this).data('id');                        
                        $.ajax({
                            url:"listaProductosDieta.php",
                            method:'get',
                            data:{dieta:dieta},
                            success: function (data) {                                
                                                $('#mimodal span').html(data);
                                            }
                        });
                           $('#mimodal').foundation('reveal', 'open');
    });
        
    /////////////////eliminar
        $("a#eliminar").on('click',function(e){
        
        e.preventDefault();
       if( confirm("desea eliminar?")){
           window.location=$(this).attr('href');
       }

    });    
    
        $(".table").footable();
        

</script>