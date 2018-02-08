<?php    include '../plantilla.php'; ?>


 <div class="small-12 columns">
<h2>admon pajillas</h2>

<!--<a href="Cpajillas.php" class="button primary">ingresar pajilla</a>-->


<?php
echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Cpajillas.php','crear pajillas');
$res=$conex->query("select * from pajillas_toros");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>toro</th>
			<th>codigo pajilla</th>
			<th>tipo semen</th>
			<th>disponible</th>			
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><a href="#" class="info_toro" data-info="<?php echo $fila[url_info_toro]?>" ><?php  echo $fila[codigo_toro]?></a></td>
                <td><?php  echo $fila[codigo_pajilla]?></td>
                <td><?php  echo $fila[tipo_semen]?></td>
                <td><?php  echo $fila[disponible]?'si':'no' ?></td>
   
                <td>
                      <!--<a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>-->
                    <!--<a href="Upalpaciones.php?<?php  echo  base64_encode($fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->                    
                    <a href="Dpalpaciones.php?<?php  echo  base64_encode('palpacion='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                        $(".table").on('click','a.info_toro',function(e){
                            window.open($(this).attr('data-info'),'_blank','height=800,width=1200');
                              
                        });

    
                        $(".table").on('click','a.ver',function(e){
        e.preventDefault();
        
        $.ajax({
            url:"Rpalpaciones.php?"+$(this).data('id'),
            success:function (datos){
                console.log(datos);
                   $('#mimodal span').html(datos);
            }
        });

     
        $('#mimodal').foundation('reveal', 'open');

    });
    
    //////////////////eliminar
        $("a#eliminar").on('click',function(e){
        
        e.preventDefault();
       if( confirm("desea eliminar?")){
           window.location=$(this).attr('href');
       }
    });

    $(".table").footable();
</script>