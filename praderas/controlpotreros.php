<?php   include '../plantilla.php'; ?>

 <div class="small-10 columns">
<h2>admon control potrero</h2>

<a href="Ccontrolpotrero.php" class="button primary">crear control potrero</a>


<?php
$res=$conex->query("select * from control_potreros");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
                        <th>potrero</th>
			<th>fecha</th>			
			<th>tipo</th>		
			<th>productos</th>		
                        <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[potrero]?></td>
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[tipo]?></td>
                <td><a href="#" class="productos">productos</a></td>
       
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="Ucontrolpotrero.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Dcontrolpotrero.php?<?php  echo  base64_encode('controlpotrero='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
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

    
        $('.table').on('click','.productos',function(e){
                        e.preventDefault();
                        var potrero=$('a.ver').data('id');                        
                        $.ajax({
                            url:"listaProductosPotrero.php",
                            method:'get',
                            data:{potrero:potrero},
                            success: function (data) {                                
                                                $('#mimodal span').html(data);
                                            }
                        });
                           $('#mimodal').foundation('reveal', 'open');
    });
    
    /////////////////////////////////////////
    
                        $("a.ver").on('click',function(e) {
                                e.preventDefault();

                                $.ajax({
                                    url: "Rcontrolpotrero.php?" + $(this).data('id'),
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