<?php   include '../plantilla.php';
$res=$conex->query("select * from compras_enc  order by fecha desc");
?>

<div class="small-10 columns">
    <h2>compras</h2>
    <a href="Ccompra.php" class="button primary">crear compras</a>
    
    <table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>fecha</th>
			<th>Doc No</th>						
			<th>Tipo doc</th>						
			<th>total</th>		
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
?>
            <tr>
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[doc_no]?></td>                           
                <td><?php  echo $fila[tipo_doc]?></td>                           
                <td><?php  echo $fila[total]?></td>                
                <td>
                    <a href="#" class="ver" data-id="<?php  echo  $fila[id] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
<!--                    <a href="Umortalidad.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Dmortalidad.php?<?php  echo  base64_encode('mortalidad='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
                </td>
            </tr>
            
<?php
}
?>	

	</tbody>
        </table>
</div>
<div id="mimodal" class="reveal-modal"  data-reveal>
    <span></span>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
</div>
<script>

          $('.table').on('click','.ver',function(e){
                        e.preventDefault();
                        var id=$(this).data('id');                        
                        $.ajax({
                            url:"ajax/verFactura.php",
                            method:'get',
                            data:{id:id},
                            success: function (data) {                                
                                                $('#mimodal span').html(data);
                                            }
                        });
                           $('#mimodal').foundation('reveal', 'open');
    });
          $(".table").footable();
    </script>
