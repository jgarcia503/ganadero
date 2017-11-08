<?php   include '../plantilla.php'; ?>

<div class="small-10 columns">
<h2>admon proyectos</h2>

<a href="Cproyecto.php" class="button primary">crear proyecto siembra</a>


<?php
$res=$conex->query("select * from proyectos_enc");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>nombre</th>
			<th>fecha inicio</th>
			<th>finalizado</th>
			<th>actividades</th>
                        
                        <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){

    ?>
            <tr>
                <td><?php  echo $fila[nombre_proyecto]?></td>
                <td><?php  echo $fila[fecha_inicio]?></td>
                <td><?php  if($fila[cerrado]==='false'){
                                                                                  echo "<input type='checkbox' name='finalizado' data-enc_id='$fila[id_proyecto]' data-potrero_id='$pot_id'>"  ;
                                                                                  
                                                                }else{
                                                                                echo '<i class="fa fa-check" aria-hidden="true"></i>';

                                                                }                                                            
                                                                ?></td>                             
                <td><a href="actividades.php?<?php echo base64_encode("proy_id=$fila[id_proyecto]")  ?>" class='<?php  echo ($fila[cerrado]=='true') ?   'cerrado' : '';  ?>' >actividades</a></td>                             
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id_proyecto]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
<!--                    <a href="Uaforos.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>                    
                    <a href="Daforos.php?<?php  echo  base64_encode('aforo='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
                </td>
            </tr>
            
    <?php
}
?>	

	</tbody>
</table>
</div>

</div>
<div id="mimodal" class="reveal-modal"  data-reveal >
    <span id="info"></span>
    <span id="forma">
        desea cerrar este proyecto <input type='checkbox' name='proyecto'>si<br>
        dese liberar el tablon <input type="checkbox" name="tablon">si<br>
        <button id='f_cerrar'>enviar</button>
    </span>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>


<script>
                    $(".table").on('click','a.ver',function(e) {
                                e.preventDefault();

                                $.ajax({
                                    url: "ajax/Rproyecto.php?" + $(this).data('id'),
                                    success: function (datos) {
                                         $('#mimodal #forma').hide();
                                        $('#mimodal #info').show().html(datos);                                            

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
    
    
                          $('.table').on('change','[name=finalizado]',cerrar);
function cerrar(){
    
                    url="ajax/cerrar.php?" + $(this).data('enc_id')+'&';
                            //para uncheck el checkbox cuando cierre la ventana modal
                               $("#mimodal").foundation('reveal','events');
                            $(document).on('close.fndtn.reveal', '[data-reveal]', function () {
                                                         $('[name=finalizado]').attr('checked',false);
                                                         $('[name=finalizado]').blur();
                                });
                            

                                        if($(this).is(':checked')){
                                            $('#mimodal #forma #f_cerrar').hide();
                                            //evento para cuando cambie checbox cerrar proyecto
                                            $('#mimodal #forma [name=proyecto]').on('change',function(){
                                                if($(this).is(':checked')){
                                                    $('#f_cerrar').show();
                                                }else{
                                                    $('#f_cerrar').hide();
                                                }
                                            });
                                                    $('#mimodal #forma').show();
                                                       $('#mimodal #info').hide();
                                                                        
                                        }

                                        $('#mimodal').foundation('reveal', 'open');
                                    }
                                    //se define afuera porque si lo de fino dentro de la funcion cerrar cada vez que se cierra y abre 
                                    //vincula esa misma cantidad de eventos a este boton
                                            $("#f_cerrar").on('click',function(e){
                                                                        e.preventDefault();
                                                                        //proy=$('[name=proyecto]').is(':checked');
                                                                        tablon=$('[name=tablon]').is(':checked');
                                                                        url+=tablon?'true':'false';//esto indica que el tablon se tiene que liberar                                              
                                                                                 $.ajax({
                                                                                                            url: url,
                                                                                                            success: function (datos) {
                                                                                                                            alert(datos);
                                                                                                                            window.location.reload();
                                                                                                            }
                                                                                                     });                                                                           
                                                                        });         
                                             
        
function  deshabilitar(){
 
            $(".cerrado").css(
                    {'pointer-events':'none',
                        'cursor': 'default',
                        'color':'grey'});

}
deshabilitar();
    $(".table").footable();
</script>
