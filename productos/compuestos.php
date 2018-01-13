<?php   include '../plantilla.php'; 
if($_POST){
   $sql="insert into compuestos values(default,'$_POST[compuesto]',btrim('$_POST[notas]'))";
   if($conex->prepare($sql)->execute()){
               $mensaje='<div data-alert class="alert-box success round">
 <h5 style="color:white">registro creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
   }else{
             $mensaje= '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
   }
}
?>

 <div class="small-10 columns">
<h2>admon compuestos</h2>
<?php echo $mensaje ?>
<a href="#" class="button primary" id="crear">crear compuesto</a>

<?php
$res=$conex->query("select * from compuestos");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>nombre</th>		
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
                <td><?php  echo $fila[notas]?></td>

                
                <td>
                    <!--<a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>-->
                    <!--<a href="Uunidad.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->                    
                    <!--<a href="Dunidad.php?<?php  echo  base64_encode('mortalidad='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
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
<div id="mimodalform" class="reveal-modal tiny"  data-reveal >

    <form action="" method="post" data-abide>
        <div class='row'>
            <div class='small-12 columns'>

                <label>
                    nombre
                    <input type="text" name="compuesto" required="">
                    <small class="error">obligatorio</small>
                </label>
            </div>
            <div class='small-12 columns'>
                <label>
                    notas
                    <textarea name="notas">
                    
                    </textarea>
                </label>

            </div>
            <div class='small-12 columns'>
                <input type="submit" value="enviar" class="button primary">
            </div>
        </div>


    </form>

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
    $(".table").footable();
    $('#crear').on('click',function(e){
        e.preventDefault();
           $('#mimodalform').foundation('reveal', 'open');
    });
                                $("a.ver").on('click',function(e){
        e.preventDefault();
        
        $.ajax({
            url:"Runidad.php?"+$(this).data('id'),
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
</script>