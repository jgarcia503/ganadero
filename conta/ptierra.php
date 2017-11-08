<?php
include '../plantilla.php'; 

?>

<div class="small-10 columns">
<h2>admon preparacion tierra</h2>

<a href="Cptierra.php" class="button primary">crear preparacion tierra</a>


<?php
$res=$conex->query("select * from prep_tierra_enc");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>nombre</th>
			<th>fecha inicio</th>
			<th>potrero</th>
			<th>tipo cultivo</th>		
			<th>finalizado</th>		
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    $sql="select id from potrero where nombre='$fila[potrero]'";
    $pot_id=$conex->query($sql)->fetch()[id];
    ?>
            <tr>
                <td><?php  echo $fila[nombre]?></td>
                <td><?php  echo $fila[fecha_inicio]?></td>
                <td><?php  echo $fila[potrero]?></td>
                <td><?php  echo $fila[tipo_cultivo]?></td>                
                <td><?php  if($fila[cerrado]=='false'){
                                                                                  echo "<input type='checkbox' name='finalizado' data-enc_id='$fila[id]' data-potrero_id='$pot_id'>"  ;
                                                                }else{
                                                                    echo "<a href='#' class='actividades' data-enc_id='$fila[id]'>actividades</a>";
                                                                        }                                                                 
                                                                ?>
                    
                </td>                
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <?php
                                                                    if($fila[cerrado]=='false'){
                                                            ?>
                    <a href="Uptierra.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                   <?php }    ?>
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
  <script>
          $(".table").footable();   
          
                $("a.ver").on('click',function(e) {
                            e.preventDefault();

                            $.ajax({
                                url: "Rtierra.php?" + $(this).data('id'),
                                success: function (datos) {
                                    
                                    $('#mimodal span').html(datos);
                                }
                            });


                            $('#mimodal').foundation('reveal', 'open');

                        });
                        
                      $('[name=finalizado]').on('change',function(){
                                        if($(this).is(':checked')){
                                              if(confirm('desea cerra este proceso')){
                                                               $.ajax({
                                                              url: "etapaTierra.php?" + $(this).data('enc_id'),
                                                              success: function (datos) {
                                                                              alert(datos);
                                                                              window.location.reload();
                                                              }
                                          });

                                        }else{
                                            $(this).attr('checked',false);
                                            $(this).blur();
                                        }
                                    }
                          });
                          
                          
                $(".actividades").on('click',function(e){
                            e.preventDefault();

                            $.ajax({
                                url: "verActividades.php?" + $(this).data('enc_id')+'/'+'prep_tierra_lns',
                                success: function (datos) {
                                    
                                    $('#mimodal span').html(datos);
                                }
                            });


                            $('#mimodal').foundation('reveal', 'open');

                        });
                        
      </script>