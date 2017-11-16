<?php   include '../plantilla.php'; ?>

<div class="small-10 columns">
<h2>admon cosechas</h2>
<?php
$res=$conex->query("select * from proyectos_enc where cerrado='true'");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>nombre</th>
			<th>fecha inicio</th>
			<th>finalizado</th>

                        <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><a href="#" class="<?php echo ($fila[opcion]===NULL)? 'elegir':'' ?>" data-proyecto_id="<?php echo $fila[id_proyecto]?>"><?php  echo $fila[nombre_proyecto]?></a></td>
                <td><?php  echo $fila[fecha_inicio]?></td>
                <td><?php  echo $fila[fecha_fin]?></td>
                         
                
                <td>
<!--                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id_proyecto]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>-->
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
<div id="mimodal" class="reveal-modal small"  data-reveal >
    <div class="row">
        <div class="small-6 columns">
            <span>
                <input type="hidden" value="" name="proyecto_id">
                <select id="opciones">
                    <option value="">seleccione</option>
                    <option value="opcion1.php">1-venta del zacate con grano</option>
                    <option value="opcion2.php">2-venta de elote y ensilaje de zacate</option>
                    <option value="opcion3.php">3-ensilado con grano</option>
                    <option value="opcion4.php">4-venta elote y zacate (prematuro)</option>
                    <option value="opcion5.php">5-cosecha del grano</option>
                    <option value="opcion6.php">6-ensilado antes del tiempo</option>            
                    <option value="opcion7.php">7-corte y reparte en verde</option>            
                    <option value="opcion8.php">8-otro tipo de cultivo</option>            
                </select>
                <button id="sigte">siguiente</button>
            </span>
        </div>
    </div>
 
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
</div>

<script>

    $(".table").on('click','.elegir',function (){
                            $('#mimodal [type=hidden]').val($(this).data('proyecto_id'));
                            $('#mimodal').foundation('reveal', 'open');
    });
    
    $('#sigte').on('click',function (){
        var valores='?proy_id='+$('[type=hidden]').val();
        if($("#opciones option:selected").val()!==''){
        window.location=$("#opciones option:selected").val()+valores;
    }else{
        alert('seleccione opcion');
    }
    });
    
    
        $(".table").footable();

</script>