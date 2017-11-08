<?php   include '../plantilla.php'; ?>



 <div class="small-10 columns">
<h2>admon lotes</h2>

<a href="Clote.php" class="button primary">crear lote</a>


<?php
$res=$conex->query("select * from lotes");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>nombre</th>
			<th>animales</th>			
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
        
    ?>
            <tr>
                <td><?php  echo $fila[nombre]?></td>
                <td><a href="#" class="animales" >animales</a></td>
     
                <td>
                   <a href="Rlotes.php" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="Ulote.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Dlote.php?<?php  echo  base64_encode('lote='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
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

                
    ///////////////ver animales
    $('.table').on('click','.animales',function(e){
                        e.preventDefault();
                        var lote=$(this).parents("tr").find("td:first").html();                        
                        $.ajax({
                            url:"listaAnimalesLotes.php",
                            method:'get',
                            data:{lote:lote},
                            success: function (data) {                                
                                                $('#mimodal span').html(data);
                                            }
                        });
                           $('#mimodal').foundation('reveal', 'open');
    });
    
    ///////////////////////////////////ver lote
        $("a.ver").on('click',function(e){
        e.preventDefault();
        
        $.ajax({
            url:"Rlotes.php?"+$(this).data('id'),
            success:function (datos){

                   $('#mimodal span').html(datos);
            }
        });
     
        $('#mimodal').foundation('reveal', 'open');

    });
    
    /////////////////////eliminar///////////////////////////////////
        $("a#eliminar").on('click',function(e){        
        e.preventDefault();
       if( confirm("desea eliminar?")){
           window.location=$(this).attr('href');
       }
    });

    $(".table").footable();     
</script>