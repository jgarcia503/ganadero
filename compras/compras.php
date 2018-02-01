<?php   include '../plantilla.php';
$res=$conex->query("select * from compras_enc  order by fecha desc");
$sql_sin_terminar="select count(a.*) from compras_enc a left join compras_lns b on a.id =b.enc_id where b.enc_id is null";
$res_sin_terminar=$conex->query($sql_sin_terminar)->fetchColumn();
?>

<div class="small-12 columns">
    <h2>compras</h2>
    <?php if(intval($res_sin_terminar)===0) {?>
    <a href="Ccompra.php" class="button primary">crear compras</a>
    <?php } ?>
    <table class="table" data-filtering='true' data-paging="true" data-toggle-column="last">
	<thead>
		<tr>
			<th>fecha</th>
			<th>Doc No</th>						
			<th>Tipo doc</th>						
			<th>total</th>					
                                                                  <th data-breakpoints="all" >detalle</th>                                                                  
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
?>
            <tr style="background-color: <?php echo ($fila[total])===null?'pink':''?>">
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[doc_no]?></td>                           
                <td><?php  echo $fila[tipo_doc]?></td>                           
                <td><?php  echo ($fila[total])===NULL?'sin terminar':number_format($fila[total],2)?></td>   
                <td>
                    <table>
                        <tr><th>producto</th><th>cantidad</th><th>unidad</th><th>precio unitario</th><th>subtotal</th></tr>
                    <?php
                    $sql="select * from compras_lns where enc_id=$fila[id]";
                    $reslineas=$conex->query($sql);
                    while($linea=$reslineas->fetch()){
                        echo "<tr>";
                        echo "<td>$linea[producto]</td>";
                        echo "<td>".number_format($linea[cantidad],2)."</td>";
                        echo "<td>$linea[unidad]</td>";
                        echo "<td>".number_format($linea[precio],2)."</td>";
                        echo "<td>".number_format($linea[subtotal],2)."</td>";
                        echo "</tr>";
                    }
                    #echo "asdasdasdas";
                        ?>
                        </table>
                </td>
                <td>
                    <a href="#" class="ver" data-id="<?php  echo  $fila[id] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <?php if ($fila[total]!==null){?>
                    <a href="ajax/print_fact.php?id=<?php  echo  $fila[id] ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                    <?php } ?>
                    <?php if($fila[total]===NULL and !$fila[aplicada]){?>
                    <a href="Ucompra.php?id=<?php  echo   $fila[id]?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <?php } 
                                            if($fila[total]!==NULL  and !$fila[aplicada]){ ?>
                           <a href='#' class='aplicar' data-id="<?php echo $fila[id]?>" title='aplicar'><i class='fa fa-check' aria-hidden='true'></i></a>
                    <?php //echo ($fila[aplicada]!==TRUE) ?"<a href='#' class='aplicar' data-id='$fila[id]' title='aplicar'><i class='fa fa-check' aria-hidden='true'></i></a>":''?>
                    <?php } ?>
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

        $('.table').on('click','.aplicar',function(e){
            e.preventDefault();
           resp=confirm('desea aplicar factura?');
           if(resp){
                                var id=$(this).data('id');                        
                        $.ajax({
                            url:"ajax/aplicarFactura.php",
                            method:'get',
                            data:{id:id},
                            success: function (data) {                                
                                                alert(data);
                                                window.location.reload();
                                            }
                        });
                    }
        });

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
