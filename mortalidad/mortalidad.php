<?php    include '../plantilla.php'; ?>

<div class="small-10 columns">
<h2>admon mortalidades</h2>

<a href="Cmortalidad.php" class="button primary">crear mortalidad</a>


<?php
$res=$conex->query("select * from mortalidades  order by fecha desc");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>fecha</th>
			<th>hora</th>
			<th>animal</th>
			<th>causa</th>		
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[hora]?></td>
                <td><?php  echo $fila[animal]?></td>
                <td><?php  echo $fila[causa]?></td>                
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="Umortalidad.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Dmortalidad.php?<?php  echo  base64_encode('mortalidad='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
            
    <?php
}
?>	

	</tbody>
</table>

</div>
<div id="mimodal" class="reveal-modal"  data-reveal >
    <span></span>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
</div>
<script>


                            $(".table").on('click','a.ver',function(e){
        e.preventDefault();
        
        $.ajax({
            url:"Rmortalidad.php?"+$(this).data('id'),
            success:function (datos){
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