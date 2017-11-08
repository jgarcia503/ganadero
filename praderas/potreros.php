<?php   include '../plantilla.php'; ?>

 <div class="small-10 columns">
<h2>admon terreno</h2>

<a href="Cpotrero.php" class="button primary">crear terreno</a>


<?php
$res=$conex->query("select * from potreros");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>nombre</th>
                        <th>extension m<sup>2</sup></th>
			<th>coordenadas</th>
			<th>titulo</th>			
			<th>notas</th>	
                        <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[nombre]?></td>
                <td><?php  echo $fila[extension]?></td>
                <td><?php  echo $fila[latitud].','.$fila[longitud]?></td>
                <td><?php  echo $fila[propiedad]?></td>
                <td><textarea readonly=""><?php  echo $fila[notas]?></textarea></td>
                
                <td>
                     <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="Upotrero.php?<?php  echo  base64_encode($fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Dpotrero.php?<?php  echo  base64_encode('potrero='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
<style>
    textarea{
        resize: none;
        word-wrap: break-word;
    }
</style>
<script>

        
                    $(".table").on('click','a.ver',function(e){
        e.preventDefault();
        
        $.ajax({
            url:"Rpotreros.php?"+$(this).data('id'),
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