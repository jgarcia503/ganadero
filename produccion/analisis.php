<?php   include '../plantilla.php';?>

 <div class="small-12 columns">
<h2>analisis de leche</h2>

<!--<a href="Canalisis.php" class="button primary">registrar analisis</a>-->


<?php
echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Canalisis.php','crear analisis');
$res=$conex->query("select * from analisis_leche ");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>fecha</th>
			<th>botellas</th>
			<th>recepcion No</th>				
                                                                  <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    ?>
            <tr>
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[cantidad_botellas] ?></td>
                <td><?php  echo $fila[recepcion_no] ?></td>                
                
                <td>
                    <a href="#" class="ver" data-id="<?php  echo  $fila[id] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="ajax/vta_factura.php?id=<?php  echo  $fila[id] ?>"  ><i class="fa fa-newspaper-o" aria-hidden="true"></i></a>
<!--                    <a href="Upanimales.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Dpanimales.php?<?php  echo  base64_encode('color='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
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
                                    url: "ajax/ver_analisis.php?" + $(this).data('id'),
                                    success: function (datos) {

                                        $('#mimodal span').html(datos);
                                    }
                                });

                                $('#mimodal').foundation('reveal', 'open');

                            });            
    ///////////////////////////////////////
                $(".table").on('click','a.fact',function(e) {
                                e.preventDefault();


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