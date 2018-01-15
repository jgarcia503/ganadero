<?php   include '../plantilla.php'; ?>

 <div class="small-12 columns">
<h2>admon marcas</h2>

<a href="Cmarca.php" class="button primary">crear marca</a>

<?php
$res=$conex->query("select * from marcas");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>marcas</th>		
                        <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){        
    ?>
            <tr>
                <td><?php  echo $fila[nombre]?></td>

                
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="Umarca.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Dmarca.php?<?php  echo  base64_encode('mortalidad='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
            url:"Rmarca.php?"+$(this).data('id'),
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