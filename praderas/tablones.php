<?php   include '../plantilla.php'; ?>

<div class="small-12 columns">
<h2>admon tablones</h2>

<!--<a href="Ctablon.php" class="button primary">crear tablon</a>-->


<?php
echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Ctablon.php','crear tablon');
$res=$conex->query("select * from tablones");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>nombre</th>
                                                                    <th>extension (m<sup>2</sup>)</th>
			<th>estatus</th>
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
                <td><?php  echo $fila[estatus]?></td>
                <td><?php  echo $fila[notas]?></td>
                
                <td>
                    <?php if($fila[estatus]==='descansando') { ?>
                    <a href="#" class="release" data-id="<?php  echo $fila[id] ?>">liberar terreno</a>
                    <?php } ?>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <!--<a href="Upotrero.php?<?php  echo  base64_encode($fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->                    
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
<script>


                    $(".table").on('click','a.ver',function(e){
        e.preventDefault();
        
        $.ajax({
            url:"ajax/tablon.php?"+$(this).data('id'),
            success:function (datos){                
                   $('#mimodal span').html(datos);
            }
        });

        $('#mimodal').foundation('reveal', 'open');

    });
    
    $(".table").on('click','a.release',function(e){
        e.preventDefault();
        
             $.ajax({
            url:"ajax/liberar_tablon.php?"+$(this).data('id'),
            success:function (datos){                
                  alert(datos);
                  window.location.reload();
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