<?php   include '../../plantilla.php'; ?>

 <div class="small-10 columns">
<h2>admon pruebas cmt</h2>

<a href="Ccmt.php" class="button primary">crear prueba cmt</a>


<?php
$res=$conex->query("SELECT distinct fecha,count(fecha) animales_revisados from pruebas_cmt group by fecha");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>fecha</th>			
			<th>animales revisados</th>			
                                                                   <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[fecha]?></td>
                <td><?php  echo $fila[animales_revisados]?></td>
    
                <td>
                    <a href="#" class="ver" data-id="<?php  echo  $fila[fecha] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a> |
                    <a href="../ajax/pdf_cmt.php?fecha=<?php  echo  $fila[fecha] ?>" class="pdf" data-id="<?php  echo  $fila[fecha] ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
</a>
<!--                    <a href="Ueventosanitario.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Deventosanitario.php?<?php  echo  base64_encode('eventosanitario='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
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
//                  $(".table").on('click','a.pdf',function(e){
//        e.preventDefault();
//                $.ajax({
//            url:"../ajax/pdf_cmt.php?fecha="+$(this).data('id'),
//            success:function(data){
//                data;
//            }
//        });
//    });

                    $(".table").on('click','a.ver',function(e){
        e.preventDefault();
        
        $.ajax({
            url:"../ajax/Rcmt.php?fecha="+$(this).data('id'),
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