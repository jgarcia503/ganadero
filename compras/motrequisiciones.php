<?php
include '../plantilla.php';

if($_POST){
    
    if($_POST[id_motivo]===''){
                    $sql_insert="insert into motivos_requesiciones values (default,'$_POST[nombre]','$_POST[cuenta]','salida',TRUE)";
            $res=$conex->prepare($sql_insert);
                if($res->execute()){
                $mensaje= '<div data-alert class="alert-box success round">            
         <h5 style="color:white">registro creado exitosamente</h5>
          <a href="#" class="close">&times;</a>
          </div>';
            }else{
              $mensaje= '<div data-alert class="alert-box alert round">
          <h5 style="color:white">Error al insertar el registro</h5>
          <a href="#" class="close">&times;</a>
          </div>';
        }
    }else{
        $sql_update="update  motivos_requesiciones set descripcion='$_POST[nombre]',cuenta_id='$_POST[cuenta]' where id=$_POST[id_motivo]";
        $res=$conex->prepare($sql_update);
        if($res->execute()){
                $mensaje= '<div data-alert class="alert-box success round">            
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

}
?>

<div class="small-10 column">
    <h2>motivos requisiciones</h2>
    <?php echo $mensaje?>
    <div class="row">
        <div class="small-6 column">
                <table class="table" data-filtering='true' data-paging="true" width="100%">
	<thead>
		<tr>
			<th>motivo</th>				
			<th>cuenta</th>				
                        <th data-filterable="false">acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
$res=$conex->query("select * from motivos_requesiciones");
while($fila=$res->fetch()){
?>
            <tr>
                <td><?php  echo $fila[descripcion]?></td>
                <td><?php  echo $fila[cuenta_id]?></td>
                
                <td>
                    <?php
                    if($fila[id]!==35){
                        echo "<a href='#' class='ver' data-id='$fila[id]'><i class='fa fa-eye' aria-hidden='true'></i></a>";
                    }
                ?>
                    
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
        <div class="small-6 column">
            <form action="" method="post" data-abide>
                <input type="hidden" name="id_motivo" value="">
                <label>nombre
                    <input type="text" name="nombre" required="">
                    <small class="error">requerido</small>
                </label>
                <label>cuenta
                    <select name="cuenta" required="">
                        <option value="">seleccione</option>
                        <?php
                        $cc="SELECT * from cn_catalogo where acceso_manual =true";
                        $rescc=$conex->query($cc);
                        while($fila=$rescc->fetch(PDO::FETCH_ASSOC)){
                            echo "<option value='$fila[cuenta_id]'>$fila[descripcion]</option>";
                        }
                                ?>
                    </select>
                    <small class="error">requerido</small>
                </label>
                <br/>
                <input type="submit" class="button primary"value="crear">
                <input type="button" class="button primary" value="limpiar" id="limpia">
            </form>
        </div>
    </div>
</div>
</div>

<script>
$('select').select2();
$('#limpia').on('click',function(){
    window.location.reload();
});
$('.table').on('click','a.ver',function(e){
    e.preventDefault();
    
    id=$(this).attr('data-id');
    
    $.ajax({
        url:'ajax/cargar_motivo_requesicion.php',
        data:{id:id},
        dataType:'json',
        success:function(data){
            $('[name=id_motivo]').val(data.id);
            $('[name=nombre]').val(data.descripcion);
            $('[name=cuenta]').val(data.cuenta_id).trigger('change');
        }
    });
});

   $(".table").footable();
</script>